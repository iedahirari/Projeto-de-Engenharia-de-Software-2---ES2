<?php
require_once __DIR__ . '/inc/funcoes.php';
$conn = conexaoOuErro();

// Parâmetros da URL (busca, ordenação e paginação são feitas pelo MySQL)
$busca = limpar($_GET['busca'] ?? '');
$colunas = ['rgf' => 'rgf', 'nome' => 'nome', 'cargo' => 'cargo', 'rendimentos' => 'rendimentos'];
$ordem = isset($colunas[$_GET['ordem'] ?? '']) ? $_GET['ordem'] : 'nome';
$direcao = ($_GET['dir'] ?? '') === 'desc' ? 'desc' : 'asc';
$porPagina = (int) ($_GET['por'] ?? 25);
if (!in_array($porPagina, [25, 50, 100], true)) $porPagina = 25;
$pagina = max(1, (int) ($_GET['pagina'] ?? 1));

$filtro = '';
$parametros = [];
if ($busca !== '') {
	$filtro = 'WHERE nome LIKE ? OR cargo LIKE ? OR rgf LIKE ?';
	$parametros = ['%' . $busca . '%', '%' . $busca . '%', $busca . '%'];
}

$total = (int) $conn->query('SELECT COUNT(*) FROM tb_servidores')->fetchColumn();
$stmt = $conn->prepare("SELECT COUNT(*) FROM tb_servidores $filtro");
$stmt->execute($parametros);
$encontrados = (int) $stmt->fetchColumn();

$paginas = max(1, (int) ceil($encontrados / $porPagina));
$pagina = min($pagina, $paginas);
$inicio = ($pagina - 1) * $porPagina;

// Coluna e direção vêm de uma lista fixa, então podem entrar no SQL com segurança
$stmt = $conn->prepare("SELECT rgf, nome, cargo, rendimentos FROM tb_servidores $filtro
	ORDER BY {$colunas[$ordem]} $direcao, nome LIMIT $inicio, $porPagina");
$stmt->execute($parametros);
$servidores = $stmt->fetchAll();

function url($mudancas) {
	global $busca, $ordem, $direcao, $porPagina, $pagina;
	$atual = ['busca' => $busca, 'ordem' => $ordem, 'dir' => $direcao, 'por' => $porPagina, 'pagina' => $pagina];
	return 'Servidores.php?' . http_build_query(array_filter(array_merge($atual, $mudancas), function ($v) { return $v !== '' && $v !== null; }));
}

function cabecalhoColuna($coluna, $rotulo, $classe = '') {
	global $ordem, $direcao;
	$ativa = $ordem === $coluna;
	$nova = $ativa ? ($direcao === 'asc' ? 'desc' : 'asc') : ($coluna === 'rendimentos' ? 'desc' : 'asc');
	return '<th scope="col"' . ($classe ? ' class="' . $classe . '"' : '')
		. ($ativa ? ' aria-sort="' . ($direcao === 'asc' ? 'ascending' : 'descending') . '"' : '')
		. '><a href="' . e(url(['ordem' => $coluna, 'dir' => $nova, 'pagina' => 1])) . '">' . $rotulo . '</a></th>';
}

// Destaca o termo buscado (sem diferenciar maiúsculas)
function destacar($texto) {
	global $busca;
	$texto = limpar($texto);
	$posicao = $busca === '' ? false : mb_stripos($texto, $busca, 0, 'UTF-8');
	if ($posicao === false) return e($texto);
	$tamanho = mb_strlen($busca, 'UTF-8');
	return e(mb_substr($texto, 0, $posicao, 'UTF-8')) . '<mark>' . e(mb_substr($texto, $posicao, $tamanho, 'UTF-8')) . '</mark>'
		. e(mb_substr($texto, $posicao + $tamanho, null, 'UTF-8'));
}

topo('Servidores · MONITORAÊ', 'Consulte nome, cargo e salário dos servidores públicos de Mogi das Cruzes.');
?>
	<main id="conteudo">
		<?php topoPagina('Servidores', 'Servidores públicos e estagiários', 'Gastos com servidores, dentro dos limites da Lei de Responsabilidade Fiscal, podem ser verificados e acompanhados por qualquer cidadão.'); ?>

		<div class="container conteudo-sobreposto">
			<div class="cartao">
				<p class="aviso-fonte"><span data-icone="info"></span><span>Dados gravados no banco MySQL pelo crawler <code>crawler/servidores/crawler_servidores.php --banco</code>, a partir do portal da prefeitura.</span></p>

				<form class="filtros" role="search" method="get" action="Servidores.php">
					<label class="lista-busca">
						<span data-icone="lupa"></span>
						<span class="visualmente-oculto">Pesquisar por nome, cargo ou RGF</span>
						<input type="search" name="busca" value="<?= e($busca) ?>" placeholder="Pesquisar por nome, cargo ou RGF" autocomplete="off">
					</label>
					<input type="hidden" name="ordem" value="<?= e($ordem) ?>">
					<input type="hidden" name="dir" value="<?= e($direcao) ?>">
					<label>
						<span class="visualmente-oculto">Servidores por página</span>
						<select name="por" onchange="this.form.submit()">
							<?php foreach ([25, 50, 100] as $opcao): ?>
							<option value="<?= $opcao ?>"<?= $opcao === $porPagina ? ' selected' : '' ?>><?= $opcao ?> por página</option>
							<?php endforeach; ?>
						</select>
					</label>
					<button class="botao botao--primario" type="submit">Pesquisar</button>
				</form>

				<p class="resumo-tabela"><?= $encontrados === $total ? numero($total) . ' servidores' : numero($encontrados) . ' de ' . numero($total) . ' servidores' ?></p>

				<div class="tabela-rolagem">
					<table class="tabela">
						<thead>
							<tr>
								<?= cabecalhoColuna('rgf', 'RGF') ?>
								<?= cabecalhoColuna('nome', 'Nome') ?>
								<?= cabecalhoColuna('cargo', 'Cargo') ?>
								<?= cabecalhoColuna('rendimentos', 'Salário bruto', 'num') ?>
							</tr>
						</thead>
						<tbody>
							<?php if (!$servidores): ?>
							<tr><td colspan="4" class="vazio">Nenhum servidor encontrado.</td></tr>
							<?php endif; ?>
							<?php foreach ($servidores as $s): ?>
							<tr>
								<td data-coluna="rgf"><?= destacar($s['rgf']) ?></td>
								<td data-coluna="nome"><?= destacar($s['nome']) ?></td>
								<td data-coluna="cargo"><?= destacar($s['cargo']) ?></td>
								<td data-coluna="rendimentos" class="num"><?= reais($s['rendimentos']) ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<nav class="paginacao" aria-label="Páginas">
					<span>Página <?= $pagina ?> de <?= $paginas ?></span>
					<div class="paginacao-botoes">
						<?php if ($pagina > 1): ?><a href="<?= e(url(['pagina' => $pagina - 1])) ?>">Anterior</a><?php else: ?><span aria-disabled="true">Anterior</span><?php endif; ?>
						<?php if ($pagina < $paginas): ?><a href="<?= e(url(['pagina' => $pagina + 1])) ?>">Próxima</a><?php else: ?><span aria-disabled="true">Próxima</span><?php endif; ?>
					</div>
				</nav>
			</div>
		</div>
	</main>
<?php rodape('servidores'); ?>
	<script>
		document.querySelectorAll('[data-icone]').forEach(function (el) { el.outerHTML = icone(el.dataset.icone); });
	</script>
</body>
</html>
