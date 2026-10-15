<?php
/*
 * Crawler de servidores públicos de Mogi das Cruzes.
 *
 * Lê a lista de servidores do portal da prefeitura e:
 *   1. gera docs/data/servidores.json, que o site (GitHub Pages) usa;
 *   2. com a opção --banco, grava também na tabela tb_servidores do MySQL.
 *
 * Uso (no terminal, dentro desta pasta):
 *   php crawler_servidores.php            -> só gera o JSON
 *   php crawler_servidores.php --banco    -> gera o JSON e atualiza o banco
 *
 * Antes de usar --banco, rode banco/correcoes.sql no MySQL e crie
 * crawler/conexao.php a partir de crawler/conexao.example.php.
 */

const URL_FONTE = 'http://www.licitacao.pmmc.com.br/Transparencia/vencimentos2';
const ARQUIVO_JSON = __DIR__ . '/../../docs/data/servidores.json';

$usarBanco = in_array('--banco', $argv ?? [], true) || isset($_GET['banco']);

if (PHP_SAPI !== 'cli') {
	header('Content-Type: text/plain; charset=utf-8');
}

function falhar($mensagem) {
	echo 'ERRO: ' . $mensagem . PHP_EOL;
	exit(1);
}

// "  FULANO  DE TAL " -> "FULANO DE TAL"
function limparTexto($texto) {
	return trim(preg_replace('/\s+/u', ' ', (string) $texto));
}

// "1.715,26" -> 1715.26 (o banco antigo gravava 1.715 e perdia os centavos)
function paraNumero($valorBR) {
	return (float) str_replace(['.', ','], ['', '.'], trim($valorBR));
}

// 1. Baixar os dados ----------------------------------------------------------
echo 'Baixando ' . URL_FONTE . ' ...' . PHP_EOL;

$contexto = stream_context_create(['http' => [
	'timeout' => 60,
	'header' => "User-Agent: MONITORAE-crawler (projeto academico FATEC Mogi das Cruzes)\r\n",
]]);
$resposta = @file_get_contents(URL_FONTE, false, $contexto);
if ($resposta === false) {
	falhar('não foi possível acessar o portal da prefeitura.');
}

// O portal responde em ISO-8859-1. O código antigo usava iconv com //IGNORE,
// que apagava as letras acentuadas ("EDUCAÇÃO" virava "EDUCAO").
if (!mb_check_encoding($resposta, 'UTF-8')) {
	$resposta = mb_convert_encoding($resposta, 'UTF-8', 'ISO-8859-1');
}

$dados = json_decode($resposta, true);
if (!is_array($dados) || !isset($dados['servidores']) || !is_array($dados['servidores'])) {
	falhar('a resposta do portal não está no formato esperado (' . json_last_error_msg() . ').');
}

// 2. Limpar os registros ------------------------------------------------------
$servidores = [];
foreach ($dados['servidores'] as $item) {
	$rgf = limparTexto($item['rgf'] ?? '');
	if ($rgf === '') {
		continue;
	}
	$servidores[] = [
		'rgf' => $rgf,
		'nome' => limparTexto($item['nome'] ?? ''),
		'cargo' => limparTexto($item['cargo'] ?? ''),
		'rendimentos' => limparTexto($item['rendimentos'] ?? '0,00'),
	];
}

if (count($servidores) === 0) {
	falhar('nenhum servidor encontrado; o JSON do site não foi alterado.');
}

$referencia = limparTexto($dados['referencia'] ?? '');
echo count($servidores) . ' servidores encontrados (referência: ' . ($referencia ?: 'não informada') . ').' . PHP_EOL;

// 3. Gerar o JSON do site -----------------------------------------------------
$saida = [
	'fonte' => URL_FONTE,
	'referencia' => $referencia,
	'coletadoEm' => date('Y-m-d'),
	'colunas' => ['rgf', 'nome', 'cargo', 'rendimentos'],
	'dados' => array_map(function ($s) {
		return [$s['rgf'], $s['nome'], $s['cargo'], $s['rendimentos']];
	}, $servidores),
];

// Só grava se os dados mudaram, para o GitHub Actions não criar commits vazios
$antigo = file_exists(ARQUIVO_JSON) ? json_decode(file_get_contents(ARQUIVO_JSON), true) : null;
if (is_array($antigo) && ($antigo['referencia'] ?? null) === $saida['referencia'] && ($antigo['dados'] ?? null) === $saida['dados']) {
	echo 'Sem novidades: docs/data/servidores.json já está atualizado.' . PHP_EOL;
} else {
	$json = json_encode($saida, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	if ($json === false || file_put_contents(ARQUIVO_JSON, $json) === false) {
		falhar('não foi possível gravar ' . ARQUIVO_JSON);
	}
	echo 'JSON do site atualizado: docs/data/servidores.json' . PHP_EOL;
}

// 4. Gravar no banco (opcional) -----------------------------------------------
if (!$usarBanco) {
	echo 'Banco não atualizado (use --banco para gravar no MySQL).' . PHP_EOL;
	exit(0);
}

$arquivoConexao = __DIR__ . '/../conexao.php';
if (!file_exists($arquivoConexao)) {
	falhar('crie crawler/conexao.php a partir de crawler/conexao.example.php.');
}
require_once $arquivoConexao;

try {
	$connection = connection();
	$connection->begin_transaction();

	// Consulta preparada: nomes com apóstrofo (ex.: D'AVILA) não quebram mais o
	// INSERT, e não há risco de SQL injection. Rodar de novo atualiza os dados
	// em vez de duplicar os servidores (rgf é UNIQUE, ver banco/correcoes.sql).
	$stmt = $connection->prepare(
		'INSERT INTO tb_servidores (rgf, nome, cargo, rendimentos) VALUES (?, ?, ?, ?)
		 ON DUPLICATE KEY UPDATE nome = VALUES(nome), cargo = VALUES(cargo), rendimentos = VALUES(rendimentos)'
	);
	foreach ($servidores as $s) {
		$rgf = (int) $s['rgf'];
		$rendimentos = paraNumero($s['rendimentos']);
		$stmt->bind_param('issd', $rgf, $s['nome'], $s['cargo'], $rendimentos);
		$stmt->execute();
	}
	$stmt->close();
	$connection->commit();
	sair($connection);
} catch (mysqli_sql_exception $erro) {
	if (isset($connection)) {
		$connection->rollback();
	}
	falhar('banco de dados: ' . $erro->getMessage());
}

echo 'Banco atualizado: ' . count($servidores) . ' servidores em tb_servidores.' . PHP_EOL;
