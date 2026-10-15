<?php
require_once __DIR__ . '/inc/funcoes.php';
$conn = conexaoOuErro();

$stmt = $conn->prepare('SELECT NUMERO, AUTOR, ASSUNTO, ANOTACAO FROM tb_projetoslei WHERE AUTOR = ? ORDER BY codigo');
$stmt->execute(['PREFEITO']);
$projetos = $stmt->fetchAll();

topo('Prefeito · MONITORAÊ', 'Perfil do prefeito de Mogi das Cruzes: dados, salário e projetos de lei enviados à Câmara.');
?>
	<main id="conteudo">
		<?php topoPagina('Prefeito', 'Prefeito de Mogi das Cruzes', 'Quem comanda o Poder Executivo da cidade, quanto recebe e quais projetos de lei enviou à Câmara Municipal.'); ?>

		<div class="container conteudo-sobreposto">
			<div class="cartao">
				<div class="perfil-cabecalho">
					<img class="avatar" src="<?= RAIZ_SITE ?>imgs/prefeito.jpg" alt="Foto de Marcus Melo">
					<div>
						<span class="etiqueta">Prefeito · Gestão 2017–2020</span>
						<h2>Marcus Melo</h2>
						<p>PSDB · eleito em 1º turno com 129.763 votos (64,34% dos votos válidos)</p>
					</div>
				</div>

				<dl class="fatos">
					<div class="fato fato--destaque"><dt>Salário</dt><dd>R$ 27.520,30</dd></div>
					<div class="fato"><dt>Partido</dt><dd>PSDB</dd></div>
					<div class="fato"><dt>Nascimento</dt><dd>1º de setembro de 1972</dd></div>
					<div class="fato"><dt>Ocupação</dt><dd>Empresário</dd></div>
					<div class="fato"><dt>Telefone</dt><dd><a href="tel:+551147985028">(11) 4798-5028</a></dd></div>
					<div class="fato"><dt>E-mail</dt><dd><a href="mailto:gabinete@pmmc.com.br">gabinete@pmmc.com.br</a></dd></div>
				</dl>
			</div>

			<div class="cartao bloco">
				<h3 class="bloco-titulo"><span data-icone="usuario"></span> Trajetória</h3>
				<p>Marcus Melo nasceu em Mogi das Cruzes, é formado em Direito pela Universidade de Mogi das Cruzes, pós-graduado em Administração Estratégica pela Universidade Braz Cubas e tem MBA pela Fundação Getúlio Vargas.</p>
				<p>Antes da vida pública, construiu carreira na iniciativa privada como proprietário e administrador de uma das escolas mais tradicionais da cidade. A partir de 2000 atuou na Associação Comercial, onde coordenou o Núcleo de Jovens Empreendedores, chegou à vice-presidência em 2008 e foi eleito presidente em 2009, além de vice-presidente da Facesp (Federação das Associações Comerciais do Estado de São Paulo).</p>
				<p>Em 2009 entrou na Administração Pública como secretário-adjunto de Gabinete da Prefeitura. Em 2011 assumiu a direção geral do Semae, a autarquia de saneamento básico do município, e deixou o cargo em 2016 para disputar sua primeira eleição.</p>
			</div>

			<div class="cartao bloco">
				<h3 class="bloco-titulo"><span data-icone="documento"></span> Projetos de lei enviados à Câmara <span class="etiqueta"><?= count($projetos) ?> projetos</span></h3>
				<?= listaProjetos($projetos) ?>
			</div>
		</div>
	</main>
<?php rodape('prefeito'); ?>
	<script>
		document.querySelectorAll('[data-icone]').forEach(function (el) { el.outerHTML = icone(el.dataset.icone); });
	</script>
</body>
</html>
