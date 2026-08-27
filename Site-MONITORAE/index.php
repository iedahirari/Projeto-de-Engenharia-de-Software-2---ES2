<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/x-png" href="./imgs/icon.png"/>
	<link rel="stylesheet" type="text/css" href="./css/index.css">
	<title> MONITORAÊ </title>
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	<script>
		jQuery(document).ready(function($){
			$(".scroll").click(function(event){
				event.preventDefault();
				$("html,body").animate({scrollTop:$(this.hash).offset().top},800);
			});
		});
	</script>
</head>
<body>	
	<!-- MENU -->
		<div class="header-2">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		 <a href="index.php"> <img src="./imgs/logo.png" ></a>
		 <div class="menu">
			<ul>
				<li>
					<a href="PerfilPrefeito.php">Prefeito</a>
				</li>
				<li>
					<a href="profile-alderman.php?id=1&nome=ANTONIO LINO DA SILVA">Vereadores</a>
				</li>
				<li>
					<a href="Servidores.php">Servidores</a>
				</li>
				<li>
					<a  class="scroll" href="#session2">Notícias</a>
				</li>
				<li>
					<a class="scroll" href="#session3">Dashboard</a>
				</li>
				<li>
					<a href="#bg"> Relatórios</a>
				</li>
			</ul>
		 </div>
		 <div class="busca">
				<input id="home" type="text" placeholder="O que você procura?                        " value="" tabindex="1" autocomplete="off">
		 </div>
		</div>
		<!-- SESSION 1 - vereadores -->
		<div id="session1" class="vereadores-lista">
			<div class="toticias" id="AA"> VEREADORES - MOGI DAS CRUZES </div> <BR>
			<div class="corponoticia" style="justify-content: center; text-align: justify; margin-left: 6%;">Os vereadores fazem parte do Poder Legislativo, e discutem e votam matérias que envolvem impostos municipais, educação municipal, linhas de ônibus e saneamento, entre outros temas da cidade. Cada vereador é eleito de forma direta, pelo voto, tornando-se um representante da população.  <br> <br> </div>
			<div style="display: flex; flex-direction: row; width: 100%;">
				<div style="display: flex; flex-direction: row; width: 100%; justify-content: space-between;">
					<div class="listafotos" style="justify-content: space-between;"><div class="foto-vereadores" id="foto1"></div></div>
					<div class="listafotos" style="justify-content: space-between;"><div class="foto-vereadores" id="foto2"></div></div>
					<div class="listafotos" style="justify-content: space-between;"><div class="foto-vereadores" id="foto3"></div></div>
					<div class="listafotos" style="justify-content: space-between;"><div class="foto-vereadores" id="foto4"></div></div>
				</div>
				</div>
				<div style="display: flex; flex-direction: row; width: 95%;  justify-content: space-between;">
					<div class="titulonoticia"> <a href="profile-alderman.php?id=1&nome=ANTONIO LINO DA SILVA" style="text-decoration: none; color: #6c6c6c;"> ANTONIO LINO DA SILVA </a> </div>
					<div class="titulonoticia"> <a href="profile-alderman.php?id=2&nome=BENEDITO FAUSTINO TAUBATÉ GUIMARÃES" style="text-decoration: none; color: #6c6c6c;"> BENEDITO FAUSTINO TAUBATÉ GUIMARÃES </a> </div>
					<div class="titulonoticia"><a href="profile-alderman.php?id=3&nome=CAIO CESAR MACHADO DA CUNHA" style="text-decoration: none; color: #6c6c6c;"> CAIO CESAR MACHADO DA CUNHA </a> </div>
					<div class="titulonoticia"> <a href="profile-alderman.php?id=4&nome= CARLOS EVARISTO DA SILVA" style="text-decoration: none; color: #6c6c6c;"> CARLOS EVARISTO DA SILVA </a> </div>
				</div>
			</div>

				<br><br>
			<a href="profile-alderman.php?id=1&nome=ANTONIO LINO DA SILVA"><button class="ListaCompleta" style="cursor: pointer;"> VER LISTA COMPLETA </button></a>
		</div>
			<!-- SESSION 2 - noticias -->
		<div id="session2" class="noticias-lista"> 
			<div class="toticias">
				ÚLTIMAS NOTÍCIAS - MOGI DAS CRUZES 
			</div>
			<div class="titulonoticia"> 
				Mogi das Cruzes inicia campanha de vacinação contra o sarampo nesta quarta
			</div>
			<div class="corponoticia" style="margin-left: 6%;">
				A Secretaria Municipal de Saúde de Mogi das Cruzes inicia, nesta quarta-feira (15), a segunda etapa da Campanha Nacional de Vacinação contra o Sarampo para o público de 6 meses a 49 anos de idade.
				A campanha prosseguirá até o dia 31 de agosto, em todas as unidades de saúde da cidade, de segunda a sexta-feira, das 8 às 16h30. É preciso comparecer munido da caderneta de vacinação e documento pessoal.
			</div>
			<div class="linknoticia">
				<a href= https://noticiasdemogi.com.br/mogi-das-cruzes-inicia-campanha-de-vacinacao-contra-o-sarampo-nesta-quarta target="_blank" style="display: flex; justify-content: center; text-align: center; margin-left: 20%; color: #6c6c6c;" />
				https://noticiasdemogi.com.br/mogi-das-cruzes-inicia-campanha-de-vacinacao-contra-o-sarampo-nesta-quarta/
				</a>
			</div>
			<div class="titulonoticia"> 
				Prefeitura de Mogi abre chamamento para 37 vagas em feiras livres e varejões
			</div>
			<div class="corponoticia" style="margin-left: 6%;">
				A Prefeitura de Mogi das Cruzes, por meio da Secretaria Municipal de Agricultura, abriu chamamento público para o preenchimento de 37 espaços disponíveis nas feiras livres e varejões, para diversos ramos de atividade e em vários locais da cidade.
				Há vagas para a feira noturna do Centro e para as feiras diurnas da Vila Industrial, Cezar de Souza, Mogi Moderno, Shangai, Jardim Maricá, Vila Nova Cintra, Jardim Esperança, Vila Nova Aparecida, Braz Cubas, Oropó, Parque Olímpico e Taiaçupeba. O horário das feiras diurnas é das 7h às 12h, e das noturnas, das 16h às 21h.
			</div>
			<div class="linknoticia" style="margin-left: 20%;">
				<a href= https://noticiasdemogi.com.br/prefeitura-de-mogi-abre-chamamento-para-37-vagas-em-feiras-livres-e-varejoes/ target="_blank" style="display: flex; justify-content: center; text-align: center; color: #6c6c6c;"/>
				https://noticiasdemogi.com.br/prefeitura-de-mogi-abre-chamamento-para-37-vagas-em-feiras-livres-e-varejoes/
				</a>
			</div>
			<div class="titulonoticia"> 
				Comitê Gestor da Retomada em Mogi se reúne com clubes para definir reabertura
			</div>
			<div class="corponoticia" style="margin-left: 6%;">
				O Comitê Gestor de Retomada Gradativa de Atividades Econômicas de Mogi das Cruzes se reuniu, na manhã desta terça-feira (14), com a Comissão Especial de Vereadores (CEV) da Retomada Econômica e representantes de clubes da cidade para o planejamento da reabertura. Estiveram presentes representantes do Clube de Campo, Kosmos, Vila Santista e Tênis Clube.
				Com o avanço de Mogi das Cruzes para a fase 3 (amarela) do Plano São Paulo, os clubes poderão retomar as atividades das academias, bares e restaurantes e outros serviços previstos nesta fase, de acordo com as condições estabelecidas pelo Governo de SP.
			</div>
			<div class="linknoticia" style="margin-left: 20%;">
				<a href= https://noticiasdemogi.com.br/comite-gestor-da-retomada-em-mogi-se-reune-com-clubes-para-definir-reabertura/ target="_blank" style="display: flex; justify-content: center; text-align: center; color: #6c6c6c;"/>
				https://noticiasdemogi.com.br/comite-gestor-da-retomada-em-mogi-se-reune-com-clubes-para-definir-reabertura/
				</a>
			</div>
		</div>
			<!-- SESSION 3 - dashboard -->
		<div id="session3" class="dashboard-lista">
			
		</div>
			<!-- SESSION 4 - rodape -->
		<div id="session4" class="rodape-lista">
			<a href="https://www.cps.sp.gov.br/"> <img src="imgs/CentroPaulaSouza.png" height="21%" width="25%" margin-left="1%"> </a> 
			<a href="https://www.fatecmogidascruzes.com.br/" style="text-decoration: none;"><div class="FATEC">
				FATEC MOGI DAS CRUZES
			</div></a>
			<div class="quemsomos">
			Estudantes de análise e desenvolvimento de sistemas na Faculdade de tecnologia estadual de
			Mogi das cruzes, tendo como projeto a realização de um web site para o acompanhamento pós eleitoral
			dos funcionários públicos de Mogi das cruzes. 
			O objetivo do seguinte projeto é a obtenção de nota parcial para aprovação da disciplina de engenharia de software II. 
			Tendo como professor orientador Leandro Luque.
			</div>
			<div class="alunos">
				<div class="email"> <div class="linkemail"> <a href="mailto:bruno.silva290@fatec.sp.gov.br?Subject=Duvidas%20sobre%20Monitoraê">  
					<img src="imgs/enviar.png" id="email" > </a> </div><div class="nomealuno"> Bruno Stevan </div></div>

				<div class="email"> <div class="linkemail"> <a href="mailto:email_que_recebe_as_mensagens@fatec.sp.gov.br?Subject=Duvidas%20sobre%20Monitoraê"> 
					<img src="imgs/enviar.png" id="email">  </a> </div><div class="nomealuno"> Ieda de Oliveira </div></div> 

				<div class="email"> <div class="linkemail">  <a href="mailto:maria.silva263@fatec.sp.gov.br?Subject=Duvidas%20 sobre%20Monitoraê"> 
					<img src="imgs/enviar.png" id="email"> </a></div><div class="nomealuno"> Maria Beatriz </div></div> 

				<div class="email"><div class="linkemail"><a href="mailto:thais.pereira15@fatec.sp.gov.br?Subject=Duvidas%20 sobre%20Monitoraê"><img src="imgs/enviar.png" id="email" ></a> </div> <div class="nomealuno">Thais Ferreira </div> </div>  
			</div>
			<div class="direitos">
				Todos os direitos reservados © MONITORAÊ 2020.
			</div>
		</div>
		<!-- POP UP relatorios -->
		<div id="bg"> </div>
		<div class="box">
			<a href="" id="close"> x </a>
			<div class="tituloRel">
				RELATÓRIOS 
			</div>
			<p>
			  Pesquise de acordo com os filtros os relatórios que desejar!
			</p>
			<div class="tipo">
				<form method="post" action="">
					<select name="relatorio" style="width:150px;" >
						<option value="selecione">Selecione</option>
						<option value="gastos">Gastos </option>
						<option value="projetos">Projetos</option>
					</select>
				</form>
			</div>

			<div class="classi">
				<form method="post" action="">
					<select name="relatorio">
						<option value="selecione">Selecione</option>
						<option value="gastos">Geral </option>
						<option value="projetos">Individual</option>
					</select>
				</form>
		     </div>

		     <div class="periodo">
				<input id="peri1" type="date" id="diaa" name="diaa">
		     	<label> á </label>
		     	<input id="peri2" type="date" id="diaa" name="diaa">
		     </div>
			<div class="rela">
				<button id="rela">Gerar Relatório</button>
			</div>
			<div class="mensagem2"> Seu relatório será gerado em formato PDF! basta clicar no botão acima.
			</div>
		</div>
		<!-- POP UP servidores -->
		<div id="bg-2"> </div>
		<div class="box-2">
			<a href="" id="close-2"> x </a>
			<div class="tituloSer">
				SERVIDORES 
			</div>
			<p>
			  Localize com a ajuda dos filtros os servidores que desejar!
			</p>
		</div>
</body>
</html>