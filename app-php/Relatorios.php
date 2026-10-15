<?php
/*
 * Relatórios (para onde vai o dinheiro e repasses do Estado).
 * Esses dados não estão no banco: vêm de docs/data/financas.json, gerado pelo
 * crawler de finanças (crawler/financas/crawler_financas.js). Por isso a página
 * reaproveita a do site publicado, só trocando os caminhos e os links do menu.
 */
require_once __DIR__ . '/inc/layout.php';

$html = file_get_contents(__DIR__ . '/../docs/Relatorios.html');
$html = str_replace(
	['href="css/', 'href="imgs/', 'src="js/', 'href="index.html"'],
	['href="' . RAIZ_SITE . 'css/', 'href="' . RAIZ_SITE . 'imgs/', 'src="' . RAIZ_SITE . 'js/', 'href="index.php"'],
	$html
);
echo str_replace('</head>', configuracaoJS() . "\n</head>", $html);
