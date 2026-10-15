<?php
// Funções de apoio das páginas PHP (as mesmas regras de docs/js/monitorae.js).

require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/layout.php';

// Escapa texto para HTML (evita que dados do banco quebrem a página)
function e($texto) {
	return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

// Os dados vieram do crawler com quebras de linha, espaços extras e "</a>"
function limpar($texto) {
	return trim(preg_replace('/\s+/u', ' ', strip_tags((string) $texto)));
}

// "José Serviços" -> "jose servicos" (para buscar e agrupar sem depender de acento)
function normalizar($texto) {
	$texto = mb_strtolower(limpar($texto), 'UTF-8');
	return strtr($texto, [
		'á' => 'a', 'à' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'é' => 'e', 'ê' => 'e', 'è' => 'e', 'ë' => 'e',
		'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i', 'ó' => 'o', 'ò' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
		'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u', 'ç' => 'c', 'ñ' => 'n',
	]);
}

// "ANTONIO LINO DA SILVA" -> "Antonio Lino da Silva"
function nomeProprio($texto) {
	$minusculas = ['da', 'de', 'do', 'das', 'dos', 'e'];
	$palavras = explode(' ', mb_strtolower(limpar($texto), 'UTF-8'));
	foreach ($palavras as $i => $p) {
		if ($i > 0 && in_array($p, $minusculas, true)) continue;
		$palavras[$i] = mb_strtoupper(mb_substr($p, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr($p, 1, null, 'UTF-8');
	}
	return implode(' ', $palavras);
}

function reais($valor, $casas = 2) {
	return 'R$ ' . number_format((float) $valor, $casas, ',', '.');
}

function numero($valor) {
	return number_format((float) $valor, 0, ',', '.');
}

// As fotos ficam em docs/imgs/FotoVereadores (caminho gravado no banco)
function fotoVereador($caminho) {
	$caminho = limpar($caminho);
	return $caminho !== '' ? RAIZ_SITE . $caminho : RAIZ_SITE . 'imgs/perfil.png';
}

// "Aprovado" e "Lei nº ..." ficam verdes; "Em trâmite", dourado
function etiquetaSituacao($anotacao) {
	$texto = mb_strtolower(limpar($anotacao), 'UTF-8');
	$classe = (strpos($texto, 'aprovad') !== false || strpos($texto, 'lei n') === 0) ? 'etiqueta--verde'
		: ((strpos($texto, 'arquiv') !== false || strpos($texto, 'rejeit') !== false || strpos($texto, 'vetad') !== false) ? 'etiqueta--vermelho' : 'etiqueta--ouro');
	return '<span class="etiqueta ' . $classe . '">' . e(limpar($anotacao) ?: 'Sem situação') . '</span>';
}

function listaProjetos($projetos, $mostrarAutor = false) {
	if (!$projetos) {
		return '<p class="vazio">Nenhum projeto de lei encontrado para este perfil.</p>';
	}
	$html = '<ul class="projetos">';
	foreach ($projetos as $p) {
		$html .= '<li class="projeto"><span class="projeto-numero">PL ' . e(limpar($p['NUMERO'])) . '</span>'
			. '<p>' . e(limpar($p['ASSUNTO'])) . '</p>'
			. '<div class="projeto-rodape">' . etiquetaSituacao($p['ANOTACAO'])
			. ($mostrarAutor ? '<small>' . e(nomeProprio($p['AUTOR'])) . '</small>' : '') . '</div></li>';
	}
	return $html . '</ul>';
}

// Item da lista lateral de vereadores (usado no perfil e na busca por AJAX)
function itemVereador($v, $idAtual = null) {
	return '<li><a href="profile-alderman.php?id=' . (int) $v['codigo'] . '"' . ((int) $v['codigo'] === $idAtual ? ' aria-current="page"' : '') . '>'
		. '<img src="' . e(fotoVereador($v['imagem'])) . '" alt="" loading="lazy"><span>' . e(nomeProprio($v['NOME']))
		. '<small>' . e(limpar($v['Partido'])) . '</small></span></a></li>';
}

function conexaoOuErro() {
	$conn = getConnection();
	if (!$conn) {
		http_response_code(500);
		exit('<p class="vazio">Não foi possível conectar ao banco de dados. Verifique se o MySQL do XAMPP está ligado e se o banco bdservidores foi importado.</p>');
	}
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	return $conn;
}
