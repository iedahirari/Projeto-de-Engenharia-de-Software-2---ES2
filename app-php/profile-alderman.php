<?php
require_once __DIR__ . '/inc/funcoes.php';
$conn = conexaoOuErro();

$vereadores = $conn->query('SELECT * FROM tb_vereadores ORDER BY codigo')->fetchAll();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Consulta preparada: o id vem da URL e não entra direto no SQL
$stmt = $conn->prepare('SELECT * FROM tb_vereadores WHERE codigo = ?');
$stmt->execute([$id]);
$v = $stmt->fetch() ?: $vereadores[0];
$id = (int) $v['codigo'];

// Inclui projetos em coautoria ("FULANO E CICLANO")
$stmt = $conn->prepare('SELECT NUMERO, AUTOR, ASSUNTO, ANOTACAO FROM tb_projetoslei WHERE AUTOR LIKE ? ORDER BY codigo');
$stmt->execute(['%' . limpar($v['NOME']) . '%']);
$projetos = $stmt->fetchAll();

// Alguns vereadores têm site no lugar do e-mail
function contato($texto) {
	$t = limpar($texto);
	if ($t === '') return 'Não informado';
	if (strpos($t, '@') !== false) return '<a href="mailto:' . e($t) . '">' . e($t) . '</a>';
	$url = preg_match('#^https?://#', $t) ? $t : 'http://' . $t;
	return '<a href="' . e($url) . '" target="_blank" rel="noopener">' . e(rtrim(preg_replace('#^https?://#', '', $t), '/')) . '</a>';
}

function fato($rotulo, $valorHTML, $destaque = false) {
	return '<div class="fato' . ($destaque ? ' fato--destaque' : '') . '"><dt>' . $rotulo . '</dt><dd>' . $valorHTML . '</dd></div>';
}

$nome = nomeProprio($v['NOME']);
$votos = limpar($v['VOTOS']);
topo($nome . ' · Vereadores · MONITORAÊ', 'Perfil dos vereadores de Mogi das Cruzes: dados pessoais, votos, salário e projetos de lei.');
?>
	<main id="conteudo">
		<?php topoPagina('Vereadores', 'Vereadores', 'Conheça cada vereador da Câmara Municipal de Mogi das Cruzes: formação, votos recebidos, salário e os projetos de lei que apresentou.'); ?>

		<div class="container conteudo-sobreposto">
			<div class="perfil">
				<aside class="cartao perfil-lateral" aria-label="Lista de vereadores">
					<label class="lista-busca">
						<span data-icone="lupa"></span>
						<span class="visualmente-oculto">Pesquisar vereador por nome ou partido</span>
						<input type="search" id="campodepesquisaveredor" placeholder="Nome ou partido" autocomplete="off">
					</label>
					<ul class="lista-vereadores" id="lista-vereadores">
						<?php foreach ($vereadores as $item) echo itemVereador($item, $id); ?>
					</ul>
				</aside>

				<div>
					<article class="cartao">
						<div class="perfil-cabecalho">
							<img class="avatar" src="<?= e(fotoVereador($v['imagem'])) ?>" alt="Foto de <?= e($nome) ?>">
							<div>
								<span class="etiqueta"><?= e(limpar($v['Partido'])) ?> · <?= e(limpar($v['LEGISLATURA'])) ?></span>
								<h2><?= e($nome) ?></h2>
								<p><?= e(limpar($v['ATIVIDADE']) ? nomeProprio($v['ATIVIDADE']) : 'Vereador(a)') ?> · <?= e($votos) ?></p>
							</div>
						</div>
						<dl class="fatos">
							<?= fato('Salário líquido', limpar($v['SALARIO']) ? 'R$ ' . e(limpar($v['SALARIO'])) : 'Não informado', true) ?>
							<?= fato('Votos', e(preg_replace('/ votos$/i', '', $votos))) ?>
							<?= fato('Formação', e(nomeProprio($v['FORMACAO']) ?: 'Não informada')) ?>
							<?= fato('Nascimento', e(limpar($v['DATANASCIMENTO']))) ?>
							<?= fato('Estado civil', e(limpar($v['ESTADOCIVIL']))) ?>
							<?= fato('Telefone', '<a href="tel:' . e(preg_replace('/\D/', '', $v['TELEFONE'])) . '">' . e(limpar($v['TELEFONE'])) . '</a>') ?>
							<?= fato('Contato', contato($v['EMAIL'])) ?>
						</dl>
					</article>

					<div class="cartao bloco">
						<h3 class="bloco-titulo"><span data-icone="documento"></span> Projetos de lei <span class="etiqueta"><?= count($projetos) . (count($projetos) === 1 ? ' projeto' : ' projetos') ?></span></h3>
						<?= listaProjetos($projetos, true) ?>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php rodape('vereadores'); ?>
	<script>
		document.querySelectorAll('[data-icone]').forEach(function (el) { el.outerHTML = icone(el.dataset.icone); });

		var atual = document.querySelector('.lista-vereadores [aria-current]');
		if (atual) atual.scrollIntoView({ block: 'nearest' });

		// Busca no banco a cada letra digitada (pesquisa.php devolve os itens da lista)
		var lista = document.getElementById('lista-vereadores');
		var pedido = 0;
		document.getElementById('campodepesquisaveredor').addEventListener('input', function () {
			var meuPedido = ++pedido;
			fetch('pesquisa.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: 'id=<?= $id ?>&nome=' + encodeURIComponent(this.value.trim())
			}).then(function (r) { return r.text(); }).then(function (html) {
				if (meuPedido === pedido) lista.innerHTML = html; // ignora respostas antigas
			});
		});
	</script>
</body>
</html>
