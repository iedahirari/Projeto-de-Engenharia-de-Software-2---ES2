// Funções compartilhadas pelas páginas estáticas do MONITORAÊ.
// Os dados vêm de docs/data/*.json (gerados pelo crawler e pelo banco).

// Ícones --------------------------------------------------------------------
var ICONES = {
	lupa: '<path d="m21 21-4.3-4.3"/><circle cx="11" cy="11" r="7"/>',
	estrela: '<path fill="currentColor" stroke="none" d="M12 2.5l2.9 6.1 6.6.8-4.9 4.6 1.3 6.6L12 17.3l-5.9 3.3 1.3-6.6-4.9-4.6 6.6-.8z"/>',
	pessoas: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.9M16 3.1a4 4 0 0 1 0 7.8"/>',
	predio: '<path d="M3 21h18M5 21V10l7-5 7 5v11M9 21v-6h6v6"/>',
	documento: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M8 13h8M8 17h5"/>',
	dinheiro: '<rect x="2" y="6" width="20" height="12" rx="2"/><circle cx="12" cy="12" r="2.5"/><path d="M6 12h.01M18 12h.01"/>',
	usuario: '<circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/>',
	grafico: '<path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/>',
	externo: '<path d="M7 17 17 7M8 7h9v9"/>',
	info: '<circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/>',
	menu: '<path d="M4 6h16M4 12h16M4 18h16"/>',
	seta: '<path d="M5 12h14M13 6l6 6-6 6"/>',
	jornal: '<path d="M4 4h13v16H6a2 2 0 0 1-2-2zM17 8h3v10a2 2 0 0 1-2 2"/><path d="M8 8h5M8 12h5M8 16h3"/>'
};

function icone(nome, classe) {
	return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"' +
		(classe ? ' class="' + classe + '"' : '') + '>' + ICONES[nome] + '</svg>';
}

// Lupa com a estrela dourada da bandeira
var LOGO_SVG = '<svg viewBox="0 0 40 40" aria-hidden="true">' +
	'<circle cx="17" cy="17" r="12" fill="#24387f" stroke="#fff" stroke-width="3"/>' +
	'<path d="M17 9.5l2.2 4.6 5 .6-3.7 3.5 1 5L17 20.7l-4.5 2.5 1-5-3.7-3.5 5-.6z" fill="#f2c230"/>' +
	'<path d="M26 26l9 9" stroke="#d0262d" stroke-width="5" stroke-linecap="round"/>' +
	'</svg>';

// Layout (cabeçalho e rodapé iguais em todas as páginas) ---------------------
var PAGINAS = [
	{ id: 'inicio', titulo: 'Início', href: 'index.html' },
	{ id: 'prefeito', titulo: 'Prefeito', href: 'PerfilPrefeito.html' },
	{ id: 'vereadores', titulo: 'Vereadores', href: 'PerfilVereador.html' },
	{ id: 'servidores', titulo: 'Servidores', href: 'Servidores.html' },
	{ id: 'relatorios', titulo: 'Relatórios', href: 'Relatorios.html' },
	{ id: 'noticias', titulo: 'Notícias', href: 'index.html#noticias' }
];

function marcaHTML() {
	return '<a class="marca" href="index.html" aria-label="MONITORAÊ, página inicial">' + LOGO_SVG +
		'<span class="marca-nome">MONITORAÊ<small>Mogi das Cruzes</small></span></a>';
}

function montarLayout(paginaAtual) {
	var cabecalho = document.getElementById('cabecalho');
	if (cabecalho) {
		cabecalho.className = 'cabecalho';
		cabecalho.innerHTML =
			'<div class="faixa-bandeira"></div>' +
			'<div class="container">' + marcaHTML() +
			'<button class="botao-menu" type="button" aria-expanded="false" aria-controls="menu-principal">' +
			icone('menu') + '<span class="visualmente-oculto">Abrir menu</span></button>' +
			'<nav class="menu" id="menu-principal" aria-label="Principal"><ul>' +
			PAGINAS.map(function (p) {
				return '<li><a href="' + p.href + '"' + (p.id === paginaAtual ? ' aria-current="page"' : '') + '>' + p.titulo + '</a></li>';
			}).join('') +
			'</ul></nav></div>';

		var botao = cabecalho.querySelector('.botao-menu');
		var menu = cabecalho.querySelector('.menu');
		botao.addEventListener('click', function () {
			var aberto = menu.classList.toggle('aberto');
			botao.setAttribute('aria-expanded', aberto);
		});
		menu.addEventListener('click', function (e) {
			if (e.target.tagName === 'A') {
				menu.classList.remove('aberto');
				botao.setAttribute('aria-expanded', 'false');
			}
		});
	}

	var rodape = document.getElementById('rodape');
	if (rodape) {
		rodape.className = 'rodape';
		rodape.innerHTML =
			'<div class="container"><div class="rodape-grade">' +
			'<div>' + marcaHTML() +
			'<p>Portal acadêmico de transparência que reúne, em linguagem simples, dados públicos sobre quem governa e trabalha para Mogi das Cruzes.</p></div>' +
			'<div><h3>Navegue</h3><ul>' +
			PAGINAS.map(function (p) { return '<li><a href="' + p.href + '">' + p.titulo + '</a></li>'; }).join('') +
			'</ul></div>' +
			'<div><h3>Fontes oficiais</h3><ul>' +
			'<li><a href="https://siconfi.tesouro.gov.br" target="_blank" rel="noopener">Tesouro Nacional (SICONFI)</a></li>' +
			'<li><a href="https://portaldatransparencia.mogidascruzes.sp.gov.br/" target="_blank" rel="noopener">Portal da Transparência</a></li>' +
			'<li><a href="http://cmmc.com.br/" target="_blank" rel="noopener">Câmara Municipal</a></li>' +
			'<li><a href="https://www.fatecmogidascruzes.com.br/" target="_blank" rel="noopener">FATEC Mogi das Cruzes</a></li>' +
			'</ul></div>' +
			'</div><div class="rodape-base">' +
			'<span>© 2020 MONITORAÊ · Projeto de Engenharia de Software II · FATEC Mogi das Cruzes</span>' +
			'<span>Dados coletados de fontes públicas (Lei de Acesso à Informação)</span>' +
			'</div></div>';
	}
}

// Dados ----------------------------------------------------------------------
function carregarJSON(nome) {
	return fetch('data/' + nome + '.json').then(function (resposta) {
		if (!resposta.ok) throw new Error('Não foi possível carregar ' + nome + '.json');
		return resposta.json();
	});
}

function escaparHTML(texto) {
	return String(texto == null ? '' : texto)
		.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
		.replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

// Remove acentos e deixa minúsculo, para a busca achar "jose" em "JOSÉ".
function normalizar(texto) {
	return String(texto || '').normalize('NFD').replace(/[̀-ͯ]/g, '').toLowerCase();
}

// "ANTONIO LINO DA SILVA" -> "Antonio Lino da Silva"
function nomeProprio(texto) {
	var minusculas = ['da', 'de', 'do', 'das', 'dos', 'e'];
	return String(texto || '').toLowerCase().split(' ').map(function (p, i) {
		return i > 0 && minusculas.indexOf(p) !== -1 ? p : p.charAt(0).toUpperCase() + p.slice(1);
	}).join(' ');
}

// "1.715,26" -> 1715.26
function paraNumero(valorBR) {
	return Number(String(valorBR).replace(/\./g, '').replace(',', '.')) || 0;
}

function formatarReais(numero, casas) {
	return numero.toLocaleString('pt-BR', {
		style: 'currency', currency: 'BRL',
		minimumFractionDigits: casas == null ? 2 : casas,
		maximumFractionDigits: casas == null ? 2 : casas
	});
}

function formatarNumero(numero) {
	return numero.toLocaleString('pt-BR');
}

// "2026-10-15" -> "15/10/2026"
function dataBR(iso) {
	return String(iso).split('-').reverse().join('/');
}

function etiquetaSituacao(anotacao) {
	var texto = normalizar(anotacao);
	// "Aprovado" e "Lei nº 7.551/20" (já virou lei) ficam verdes; "Em trâmite", dourado
	var classe = texto.indexOf('aprovad') !== -1 || texto.indexOf('lei n') === 0 ? 'etiqueta--verde'
		: texto.indexOf('arquiv') !== -1 || texto.indexOf('rejeit') !== -1 || texto.indexOf('vetad') !== -1 ? 'etiqueta--vermelho'
		: 'etiqueta--ouro';
	return '<span class="etiqueta ' + classe + '">' + escaparHTML(anotacao || 'Sem situação') + '</span>';
}

function listaProjetos(projetos, mostrarAutor) {
	if (!projetos.length) return '<p class="vazio">Nenhum projeto de lei encontrado para este perfil.</p>';
	return '<ul class="projetos">' + projetos.map(function (p) {
		return '<li class="projeto"><span class="projeto-numero">PL ' + escaparHTML(p.numero) + '</span>' +
			'<p>' + escaparHTML(p.assunto) + '</p>' +
			'<div class="projeto-rodape">' + etiquetaSituacao(p.anotacao) +
			(mostrarAutor ? '<small>' + escaparHTML(nomeProprio(p.autor)) + '</small>' : '') + '</div></li>';
	}).join('') + '</ul>';
}

function mostrarErro(elemento, erro) {
	elemento.innerHTML = '<p class="vazio">Não foi possível carregar os dados. ' + escaparHTML(erro.message) + '</p>';
}
