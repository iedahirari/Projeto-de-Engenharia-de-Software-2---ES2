<?php
require_once __DIR__ . '/inc/funcoes.php';
$conn = conexaoOuErro();

// Números do topo
$vereadores = $conn->query('SELECT codigo, NOME, Partido, imagem FROM tb_vereadores ORDER BY codigo')->fetchAll();
$totalProjetos = (int) $conn->query('SELECT COUNT(*) FROM tb_projetoslei')->fetchColumn();
$folha = $conn->query('SELECT COUNT(*) AS quantidade, SUM(rendimentos) AS total FROM tb_servidores')->fetch();

// Painel: cargos com mais servidores (agrupa "SERVIÇOS" e "SERVICOS" como o mesmo cargo)
$cargos = [];
foreach ($conn->query('SELECT cargo, COUNT(*) AS quantidade FROM tb_servidores GROUP BY cargo') as $linha) {
	$chave = normalizar($linha['cargo']);
	if (!isset($cargos[$chave])) $cargos[$chave] = ['rotulo' => nomeProprio($linha['cargo']), 'valor' => 0];
	if (preg_match('/[^\x00-\x7f]/', $linha['cargo'])) $cargos[$chave]['rotulo'] = nomeProprio($linha['cargo']);
	$cargos[$chave]['valor'] += $linha['quantidade'];
}
usort($cargos, function ($a, $b) { return $b['valor'] - $a['valor']; });
$cargos = array_slice($cargos, 0, 6);

// Painel: faixas de salário calculadas no próprio MySQL
$faixas = $conn->query("
	SELECT CASE
		WHEN rendimentos <= 2000 THEN 'Até R$ 2 mil'
		WHEN rendimentos <= 4000 THEN 'R$ 2 mil a 4 mil'
		WHEN rendimentos <= 6000 THEN 'R$ 4 mil a 6 mil'
		WHEN rendimentos <= 10000 THEN 'R$ 6 mil a 10 mil'
		WHEN rendimentos <= 20000 THEN 'R$ 10 mil a 20 mil'
		ELSE 'Acima de R$ 20 mil' END AS rotulo,
		MIN(rendimentos) AS ordem, COUNT(*) AS valor
	FROM tb_servidores GROUP BY rotulo ORDER BY ordem")->fetchAll();

$partidos = $conn->query('SELECT Partido AS rotulo, COUNT(*) AS valor FROM tb_vereadores GROUP BY Partido ORDER BY valor DESC LIMIT 6')->fetchAll();

function barras($lista, $texto, $classe = '') {
	$maior = max(array_column($lista, 'valor')) ?: 1;
	$html = '';
	foreach ($lista as $item) {
		$html .= '<li><div class="barra-rotulo"><span>' . e($item['rotulo']) . '</span><span>' . e($texto($item)) . '</span></div>'
			. '<div class="barra ' . $classe . '"><i style="width:' . round($item['valor'] / $maior * 100, 1) . '%"></i></div></li>';
	}
	return $html;
}

topo('MONITORAÊ · Transparência em Mogi das Cruzes', 'Acompanhe vereadores, prefeito e servidores públicos de Mogi das Cruzes.');
?>
	<main id="conteudo">
		<section class="hero">
			<?php for ($i = 1; $i <= 3; $i++): ?>
			<svg class="hero-estrela hero-estrela--<?= $i ?>" viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M12 2.5l2.9 6.1 6.6.8-4.9 4.6 1.3 6.6L12 17.3l-5.9 3.3 1.3-6.6-4.9-4.6 6.6-.8z"/></svg>
			<?php endfor; ?>
			<div class="container">
				<span class="hero-rotulo">Transparência pública · Mogi das Cruzes</span>
				<h1>Acompanhe <em>quem governa</em> e quem trabalha para a sua cidade</h1>
				<p class="lead">Vereadores, prefeito, projetos de lei e salários de servidores públicos reunidos em um só lugar, com dados abertos e linguagem simples.</p>

				<div class="busca" role="search">
					<label class="visualmente-oculto" for="busca-geral">Buscar vereador, partido ou servidor</label>
					<div class="busca-campo">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m21 21-4.3-4.3"/><circle cx="11" cy="11" r="7"/></svg>
						<input id="busca-geral" type="search" placeholder="Busque um vereador, partido ou servidor" autocomplete="off"
							role="combobox" aria-expanded="false" aria-controls="busca-sugestoes" aria-autocomplete="list">
						<button class="botao botao--ouro" type="button" id="busca-botao">Buscar</button>
					</div>
					<ul class="busca-sugestoes" id="busca-sugestoes" role="listbox" hidden></ul>
				</div>
			</div>
		</section>

		<div class="container">
			<div class="numeros">
				<a class="numero" href="profile-alderman.php">
					<span class="numero-icone" data-icone="pessoas"></span>
					<span><strong><?= count($vereadores) ?></strong><span>vereadores</span></span>
				</a>
				<a class="numero" href="#painel">
					<span class="numero-icone" data-icone="documento"></span>
					<span><strong><?= $totalProjetos ?></strong><span>projetos de lei</span></span>
				</a>
				<a class="numero" href="Servidores.php">
					<span class="numero-icone" data-icone="predio"></span>
					<span><strong><?= numero($folha['quantidade']) ?></strong><span>servidores públicos</span></span>
				</a>
				<a class="numero" href="#painel">
					<span class="numero-icone" data-icone="dinheiro"></span>
					<span><strong>R$ <?= number_format($folha['total'] / 1e6, 1, ',', '.') ?> mi</strong><span>folha mensal</span></span>
				</a>
			</div>
		</div>

		<section class="secao" id="vereadores">
			<div class="container">
				<div class="secao-cabecalho">
					<div>
						<span class="sobretitulo">Poder Legislativo</span>
						<h2>Vereadores de Mogi das Cruzes</h2>
						<p>Os vereadores discutem e votam leis sobre impostos municipais, educação, transporte, saneamento e outros temas da cidade. Cada um é eleito pelo voto direto para representar a população.</p>
					</div>
					<a class="botao botao--contorno" href="profile-alderman.php">Ver perfis completos</a>
				</div>
				<div class="grade grade--4">
					<?php foreach ($vereadores as $v): ?>
					<a class="cartao pessoa" href="profile-alderman.php?id=<?= (int) $v['codigo'] ?>">
						<img class="avatar" src="<?= e(fotoVereador($v['imagem'])) ?>" alt="" loading="lazy">
						<span class="pessoa-nome"><?= e(nomeProprio($v['NOME'])) ?></span>
						<span class="etiqueta"><?= e(limpar($v['Partido'])) ?></span>
					</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>

		<section class="secao secao--alternada" id="painel">
			<div class="container">
				<div class="secao-cabecalho">
					<div>
						<span class="sobretitulo">Painel</span>
						<h2>Para onde vai o dinheiro da folha</h2>
						<p><?= reais($folha['total'], 0) ?> em salários brutos, média de <?= reais($folha['total'] / max(1, $folha['quantidade'])) ?> por servidor. Calculado direto do banco de dados.</p>
					</div>
					<a class="botao botao--primario" href="Servidores.php">Consultar servidores</a>
				</div>
				<div class="grade grade--3">
					<div class="cartao">
						<h3>Cargos com mais servidores</h3>
						<ul class="barra-lista"><?= barras($cargos, function ($i) { return numero($i['valor']); }) ?></ul>
					</div>
					<div class="cartao">
						<h3>Faixas de salário bruto</h3>
						<ul class="barra-lista"><?= barras($faixas, function ($i) use ($folha) { return numero($i['valor']) . ' (' . round($i['valor'] / max(1, $folha['quantidade']) * 100) . '%)'; }) ?></ul>
					</div>
					<div class="cartao">
						<h3>Vereadores por partido</h3>
						<ul class="barra-lista"><?= barras($partidos, function ($i) { return $i['valor'] . ($i['valor'] > 1 ? ' vereadores' : ' vereador'); }, 'barra--ouro') ?></ul>
					</div>
				</div>
			</div>
		</section>

		<section class="secao" id="noticias">
			<div class="container">
				<div class="secao-cabecalho">
					<div>
						<span class="sobretitulo">Notícias</span>
						<h2>Acontece em Mogi</h2>
						<p>Notícias selecionadas pela equipe em julho de 2020.</p>
					</div>
				</div>
				<div class="grade grade--3">
					<article class="cartao noticia">
						<span class="etiqueta etiqueta--verde">Saúde</span>
						<h3>Mogi das Cruzes inicia campanha de vacinação contra o sarampo</h3>
						<p>A segunda etapa da Campanha Nacional de Vacinação contra o Sarampo atende o público de 6 meses a 49 anos, em todas as unidades de saúde da cidade, de segunda a sexta, das 8h às 16h30.</p>
						<a href="https://noticiasdemogi.com.br/mogi-das-cruzes-inicia-campanha-de-vacinacao-contra-o-sarampo-nesta-quarta/" target="_blank" rel="noopener">Ler no Notícias de Mogi</a>
					</article>
					<article class="cartao noticia">
						<span class="etiqueta etiqueta--ouro">Economia</span>
						<h3>Prefeitura abre chamamento para 37 vagas em feiras livres e varejões</h3>
						<p>A Secretaria de Agricultura abriu chamamento público para espaços em feiras noturnas e diurnas de vários bairros, como Centro, Vila Industrial, Braz Cubas e Jardim Maricá.</p>
						<a href="https://noticiasdemogi.com.br/prefeitura-de-mogi-abre-chamamento-para-37-vagas-em-feiras-livres-e-varejoes/" target="_blank" rel="noopener">Ler no Notícias de Mogi</a>
					</article>
					<article class="cartao noticia">
						<span class="etiqueta">Cidade</span>
						<h3>Comitê da Retomada se reúne com clubes para definir reabertura</h3>
						<p>Com o avanço para a fase amarela do Plano São Paulo, clubes da cidade planejam retomar academias, bares e restaurantes seguindo as regras do Governo do Estado.</p>
						<a href="https://noticiasdemogi.com.br/comite-gestor-da-retomada-em-mogi-se-reune-com-clubes-para-definir-reabertura/" target="_blank" rel="noopener">Ler no Notícias de Mogi</a>
					</article>
				</div>
			</div>
		</section>

		<section class="secao secao--alternada" id="sobre">
			<div class="container sobre">
				<div>
					<span class="sobretitulo">Sobre o projeto</span>
					<h2>Feito por estudantes da FATEC Mogi das Cruzes</h2>
					<p>O MONITORAÊ é um projeto da disciplina de Engenharia de Software II do curso de Análise e Desenvolvimento de Sistemas. A ideia é acompanhar, depois das eleições, o trabalho de quem foi eleito e de quem é pago com dinheiro público na cidade.</p>
					<p>Esta é a <strong>versão em PHP + MySQL</strong>: um <strong>web crawler</strong> grava os dados no banco e as páginas consultam o banco a cada acesso.</p>
					<p>Professor orientador: <strong>Leandro Luque</strong>.</p>
				</div>
				<div class="cartao">
					<h3>Equipe</h3>
					<ul class="equipe">
						<li><span class="inicial" aria-hidden="true">B</span><span>Bruno Stevan<small><a href="mailto:bruno.silva290@fatec.sp.gov.br">bruno.silva290@fatec.sp.gov.br</a></small></span></li>
						<li><span class="inicial" aria-hidden="true">I</span><span>Ieda de Oliveira<small>Desenvolvimento e requisitos</small></span></li>
						<li><span class="inicial" aria-hidden="true">M</span><span>Maria Beatriz<small><a href="mailto:maria.silva263@fatec.sp.gov.br">maria.silva263@fatec.sp.gov.br</a></small></span></li>
						<li><span class="inicial" aria-hidden="true">T</span><span>Thais Ferreira<small><a href="mailto:thais.pereira15@fatec.sp.gov.br">thais.pereira15@fatec.sp.gov.br</a></small></span></li>
					</ul>
				</div>
			</div>
		</section>
	</main>
<?php rodape('inicio'); ?>
	<script>
		document.querySelectorAll('[data-icone]').forEach(function (el) { el.innerHTML = icone(el.dataset.icone); });

		// Sugestões da busca (a lista de vereadores vem do banco)
		var vereadores = <?= json_encode(array_map(function ($v) {
			return ['codigo' => (int) $v['codigo'], 'nome' => limpar($v['NOME']), 'partido' => limpar($v['Partido']), 'imagem' => fotoVereador($v['imagem'])];
		}, $vereadores), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
		var campo = document.getElementById('busca-geral');
		var sugestoes = document.getElementById('busca-sugestoes');
		var ativo = -1;

		function atualizar() {
			var termo = normalizar(campo.value.trim());
			ativo = -1;
			sugestoes.hidden = !termo;
			campo.setAttribute('aria-expanded', String(!!termo));
			if (!termo) return;
			sugestoes.innerHTML = vereadores.filter(function (v) {
				return normalizar(v.nome).indexOf(termo) !== -1 || normalizar(v.partido) === termo;
			}).slice(0, 6).map(function (v) {
				return '<li role="option"><a href="profile-alderman.php?id=' + v.codigo + '"><img src="' + escaparHTML(v.imagem) + '" alt=""><span>' +
					escaparHTML(nomeProprio(v.nome)) + '<small>Vereador(a) · ' + escaparHTML(v.partido) + '</small></span></a></li>';
			}).join('') +
				'<li role="option"><a href="Servidores.php?busca=' + encodeURIComponent(campo.value.trim()) + '"><span class="busca-icone-item">' + icone('predio') +
				'</span><span>Buscar “' + escaparHTML(campo.value.trim()) + '” entre os servidores<small>Nome, cargo ou RGF</small></span></a></li>';
		}
		function irParaPrimeira() {
			var link = sugestoes.querySelectorAll('a')[ativo >= 0 ? ativo : 0];
			if (link && !sugestoes.hidden) location.href = link.href;
		}
		campo.addEventListener('input', atualizar);
		campo.addEventListener('keydown', function (e) {
			var links = sugestoes.querySelectorAll('a');
			if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
				e.preventDefault();
				ativo = (ativo + (e.key === 'ArrowDown' ? 1 : -1) + links.length) % links.length;
				links.forEach(function (l, i) { l.classList.toggle('ativo', i === ativo); });
			} else if (e.key === 'Enter') { irParaPrimeira(); }
			else if (e.key === 'Escape') { sugestoes.hidden = true; }
		});
		document.getElementById('busca-botao').addEventListener('click', function () { atualizar(); irParaPrimeira(); });
		document.addEventListener('click', function (e) { if (!e.target.closest('.busca')) sugestoes.hidden = true; });
	</script>
</body>
</html>
