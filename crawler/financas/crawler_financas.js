/*
 * Crawler das finanças de Mogi das Cruzes.
 *
 * Baixa da API oficial do Tesouro Nacional (SICONFI) os relatórios que toda
 * prefeitura é obrigada a publicar a cada dois meses (RREO) e gera
 * docs/data/financas.json, usado pela página de Relatórios do site:
 *
 *   - Anexo 01: de onde vem o dinheiro (impostos, União, Estado...)
 *   - Anexo 02: para onde vai o dinheiro (Saúde, Educação, Transporte...)
 *   - Anexo 03: detalhe dos repasses (cota-parte do ICMS e do IPVA do Estado)
 *
 * Uso (na raiz do repositório):  node crawler/financas/crawler_financas.js
 * Precisa do Node.js 18 ou mais novo. Não usa banco de dados nem pacotes do npm.
 */

const fs = require('fs');
const path = require('path');

const API = 'https://apidatalake.tesouro.gov.br/ords/siconfi/tt/rreo';
const COD_IBGE = 3530607; // Mogi das Cruzes
const ANO_INICIAL = 2019;
const ARQUIVO_JSON = path.join(__dirname, '..', '..', 'docs', 'data', 'financas.json');

// As 28 funções de governo (Portaria MOG nº 42/1999). No Anexo 02, cada função
// vem seguida das suas subfunções, sem um código que diferencie as duas.
const FUNCOES = new Set([
	'Legislativa', 'Judiciária', 'Essencial à Justiça', 'Administração', 'Defesa Nacional',
	'Segurança Pública', 'Relações Exteriores', 'Assistência Social', 'Previdência Social',
	'Saúde', 'Trabalho', 'Educação', 'Cultura', 'Direitos da Cidadania', 'Urbanismo',
	'Habitação', 'Saneamento', 'Gestão Ambiental', 'Ciência e Tecnologia', 'Agricultura',
	'Organização Agrária', 'Indústria', 'Comércio e Serviços', 'Comunicações', 'Energia',
	'Transporte', 'Desporto e Lazer', 'Encargos Especiais',
]);

const MESES = ['fevereiro', 'abril', 'junho', 'agosto', 'outubro', 'dezembro'];

const esperar = (ms) => new Promise((resolve) => setTimeout(resolve, ms));
const arredondar = (valor) => Math.round(valor * 100) / 100;

// Devolve as linhas de um anexo do RREO (lista vazia se ainda não foi publicado)
async function baixar(ano, periodo, anexo) {
	const parametros = new URLSearchParams({
		an_exercicio: ano, nr_periodo: periodo, co_tipo_demonstrativo: 'RREO',
		no_anexo: 'RREO-Anexo ' + anexo, id_ente: COD_IBGE,
	});
	for (let tentativa = 0; tentativa < 3; tentativa++) {
		try {
			const resposta = await fetch(API + '?' + parametros, {
				headers: { 'User-Agent': 'MONITORAE-crawler (projeto academico FATEC Mogi das Cruzes)' },
				signal: AbortSignal.timeout(90000),
			});
			if (!resposta.ok) throw new Error('HTTP ' + resposta.status);
			const dados = await resposta.json();
			await esperar(1000); // a API limita a quantidade de pedidos por segundo
			return dados.items || [];
		} catch (erro) { // rede instável: tenta de novo
			console.error(`  falha ao baixar ${ano}/${periodo} anexo ${anexo}: ${erro.message}`);
			await esperar(5000 * (tentativa + 1));
		}
	}
	throw new Error(`não foi possível baixar ${ano}/${periodo} anexo ${anexo}`);
}

// Último bimestre publicado no ano (6 = ano completo)
async function ultimoPeriodo(ano) {
	for (let periodo = 6; periodo >= 1; periodo--) {
		const linhas = await baixar(ano, periodo, '02');
		if (linhas.length) return { periodo, linhas };
	}
	return { periodo: null, linhas: [] };
}

function despesasPorFuncao(linhas) {
	const coluna = [...new Set(linhas.map((l) => l.coluna))].find((c) => c.startsWith('DESPESAS LIQUIDADAS AT'));
	let total = 0;
	let atual = null;
	const funcoes = [];
	for (const l of linhas) {
		if (l.coluna !== coluna || !l.rotulo.includes('Exceto Intra')) continue;
		const conta = l.conta.trim();
		if (conta.startsWith('DESPESAS (EXCETO')) {
			total = l.valor;
		} else if (FUNCOES.has(conta)) {
			atual = { funcao: conta, valor: l.valor, subfuncoes: [] };
			funcoes.push(atual);
		} else if (atual) {
			// "FU04 - Administração Geral" -> "Administração Geral"
			const nome = conta.startsWith('FU') && conta.includes(' - ') ? conta.split(' - ').slice(1).join(' - ') : conta;
			atual.subfuncoes.push({ nome, valor: l.valor });
		}
	}

	const soma = funcoes.reduce((s, f) => s + f.valor, 0);
	if (Math.abs(soma - total) > 1) {
		throw new Error(`soma das funções (${soma.toFixed(2)}) diferente do total (${total.toFixed(2)})`);
	}
	funcoes.forEach((f) => f.subfuncoes.sort((a, b) => b.valor - a.valor));
	funcoes.sort((a, b) => b.valor - a.valor);
	return { total, funcoes };
}

function receitasPorOrigem(linhas) {
	const valores = {};
	for (const l of linhas) {
		if (l.coluna.startsWith('At') && l.coluna.includes('Bimestre')) valores[l.cod_conta] = l.valor;
	}
	const v = (codigo) => valores[codigo] || 0;
	const total = v('ReceitasExcetoIntraOrcamentarias');
	const origens = {
		impostos: v('ReceitaTributaria'),
		uniao: v('TransferenciasCorrentesDaUniaoEDeSuasEntidades') + v('TransferenciasDeCapitalDaUniaoEDeSuasEntidades'),
		estado: v('TransferenciasCorrentesDosEstadosEDoDistritoFederalEDeSuasEntidades') + v('TransferenciasDeCapitalDosEstadosEDoDistritoFederalEDeSuasEntidades'),
		fundeb: v('TransferenciasCorrentesDeOutrasInstituicoesPublicas'),
		emprestimos: v('ReceitasDeOperacoesDeCredito'),
	};
	origens.outras = total - Object.values(origens).reduce((s, x) => s + x, 0);
	return { total, origens };
}

// O Anexo 03 traz os últimos 12 meses; soma só os meses do ano
function repasses(linhas, periodo) {
	const meses = new Set(['<MR>']);
	for (let i = 1; i < periodo * 2; i++) meses.add(`<MR-${i}>`);
	const soma = {};
	for (const l of linhas) {
		if (meses.has(l.coluna)) soma[l.cod_conta] = (soma[l.cod_conta] || 0) + (l.valor || 0);
	}
	const v = (codigo) => arredondar(soma[codigo] || 0);
	return {
		icms: v('RREO3CotaParteDoICMS'),
		ipva: v('RREO3CotaParteDoIPVA'),
		fpm: v('RREO3CotaParteDoFPM'),
		iptu: v('IPTULiquidoExcetoTransferenciasEFUNDEB'),
		iss: v('ISSLiquidoExcetoTransferenciasEFUNDEB'),
		itbi: v('ITBILiquidoExcetoTransferenciasEFUNDEB'),
	};
}

const reais = (valor) => 'R$ ' + Math.round(valor).toLocaleString('pt-BR');

async function main() {
	const anoAtual = new Date().getFullYear();
	const anos = [];
	for (let ano = anoAtual; ano >= ANO_INICIAL; ano--) {
		console.log(`${ano}...`);
		const { periodo, linhas: anexo2 } = await ultimoPeriodo(ano);
		if (!periodo) {
			console.log('  ainda sem relatório publicado');
			continue;
		}
		const despesas = despesasPorFuncao(anexo2);
		const receitas = receitasPorOrigem(await baixar(ano, periodo, '01'));
		const detalhe = repasses(await baixar(ano, periodo, '03'), periodo);
		const receitasArredondadas = {};
		for (const [chave, valor] of Object.entries(receitas.origens)) receitasArredondadas[chave] = arredondar(valor);

		anos.push({
			ano,
			periodo,
			ate: periodo === 6 ? 'ano completo' : 'até ' + MESES[periodo - 1],
			populacao: anexo2[0].populacao,
			despesaTotal: arredondar(despesas.total),
			despesas: despesas.funcoes,
			receitaTotal: arredondar(receitas.total),
			receitas: receitasArredondadas,
			detalhe,
		});
		console.log(`  ${anos[anos.length - 1].ate}: gasto ${reais(despesas.total)}, Estado ${reais(receitas.origens.estado)}`);
	}

	if (!anos.length) {
		console.error('ERRO: nenhum ano encontrado; o JSON do site não foi alterado.');
		process.exit(1);
	}

	const novo = {
		fonte: 'https://siconfi.tesouro.gov.br',
		municipio: 'Mogi das Cruzes',
		codIbge: COD_IBGE,
		anos,
	};

	// Só grava se os dados mudaram, para o GitHub Actions não criar commits vazios
	if (fs.existsSync(ARQUIVO_JSON)) {
		const antigo = JSON.parse(fs.readFileSync(ARQUIVO_JSON, 'utf8'));
		delete antigo.coletadoEm;
		if (JSON.stringify(antigo) === JSON.stringify(novo)) {
			console.log('Sem novidades: docs/data/financas.json já está atualizado.');
			return;
		}
	}

	novo.coletadoEm = new Date().toISOString().slice(0, 10);
	fs.writeFileSync(ARQUIVO_JSON, JSON.stringify(novo));
	console.log(`JSON do site atualizado: docs/data/financas.json (${anos.length} anos)`);
}

main().catch((erro) => {
	console.error('ERRO: ' + erro.message);
	process.exit(1);
});
