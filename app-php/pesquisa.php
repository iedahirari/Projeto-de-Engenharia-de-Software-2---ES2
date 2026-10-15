<?php
// Busca de vereadores por nome ou partido, chamada por AJAX em profile-alderman.php.
// Devolve os itens <li> da lista lateral.
require_once __DIR__ . '/inc/funcoes.php';
$conn = conexaoOuErro();

$nome = limpar($_POST['nome'] ?? '');
$idAtual = (int) ($_POST['id'] ?? 0);

// Consulta preparada: o texto digitado não entra direto no SQL (evita SQL injection)
$stmt = $conn->prepare('SELECT * FROM tb_vereadores WHERE NOME LIKE ? OR Partido LIKE ? ORDER BY codigo');
$stmt->execute(['%' . $nome . '%', $nome . '%']);
$resultado = $stmt->fetchAll();

if (!$resultado) {
	echo '<li class="vazio">Nenhum vereador encontrado.</li>';
}
foreach ($resultado as $v) {
	echo itemVereador($v, $idAtual);
}
