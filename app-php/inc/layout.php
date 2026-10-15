<?php
/*
 * Cabeçalho e rodapé das páginas PHP.
 * Reaproveitam o visual do site publicado (docs/css/estilo.css e docs/js/monitorae.js),
 * então as duas versões ficam com a mesma identidade.
 */

const RAIZ_SITE = '../docs/';

// Links da versão PHP e pasta dos JSON (usados por docs/js/monitorae.js)
function configuracaoJS() {
	$config = [
		'links' => [
			'inicio' => 'index.php',
			'prefeito' => 'PerfilPrefeito.php',
			'vereadores' => 'profile-alderman.php',
			'servidores' => 'Servidores.php',
			'relatorios' => 'Relatorios.php',
			'noticias' => 'index.php#noticias',
		],
		'dados' => RAIZ_SITE . 'data/',
	];
	return '<script>window.MONITORAE = ' . json_encode($config, JSON_UNESCAPED_SLASHES) . ';</script>';
}

function topo($titulo, $descricao) {
	?><!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?= e($descricao) ?>">
	<meta name="theme-color" content="#16245a">
	<title><?= e($titulo) ?></title>
	<link rel="icon" type="image/svg+xml" href="<?= RAIZ_SITE ?>imgs/icone.svg">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap">
	<link rel="stylesheet" href="<?= RAIZ_SITE ?>css/estilo.css">
	<?= configuracaoJS() ?>
</head>
<body>
	<a class="pular-conteudo" href="#conteudo">Pular para o conteúdo</a>
	<header id="cabecalho"></header>
<?php
}

function rodape($paginaAtual) {
	?>
	<footer id="rodape"></footer>
	<script src="<?= RAIZ_SITE ?>js/monitorae.js"></script>
	<script>montarLayout(<?= json_encode($paginaAtual) ?>);</script>
<?php
}

function topoPagina($trilha, $titulo, $texto) {
	?>
		<section class="topo-pagina">
			<div class="container">
				<div class="trilha"><a href="index.php">Início</a> / <?= e($trilha) ?></div>
				<h1><?= e($titulo) ?></h1>
				<p><?= e($texto) ?></p>
			</div>
		</section>
<?php
}
