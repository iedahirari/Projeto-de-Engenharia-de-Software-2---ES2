<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-png" href="./imgs/Icon.png"/>
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
						<a href="index.php#session2">Notícias</a>
					</li>
					<li>
						<a href="index.php#session3">Dashboard</a>
					</li>
					<li>
						<a href="index.php#bg">Relatórios</a>
					</li>
				</ul>
			 </div>
			 <div class="busca">
					<input type="text" placeholder="O que você procura?                        " value="" tabindex="1" autocomplete="off">
			 </div>
		</div>
		<div class="dadosPrefeito">
			<div class="foto">
				<img src="imgs/prefeito.jpg" height="100%" width="70%" id="perfilfoto" style="border:3px solid #ffb230;border-radius: 100%;"> 
			</div>
			<br>
			<div class="nome">
				MARCUS MELO
			</div>
			<div class="dadosPessoais">
				 DADOS  PESSOAIS 
			</div>
			<div class="plenario">
				 ATUAÇÃO NO PLENÁRIO E COMISSÕES 
			</div>
			<div class="deshboardPerfil">
				 DESHBOARD 
			</div>
			<div class="projetos">
				PROJETOS 
			</div>
			<div class="comentarios">
				 COMENTÁRIOS
			</div>
			<div class="titulo" style="background-color:#fff;z-index: 999;">
				PREFEITO(A) DE MOGI DAS CRUZES
			</div>
		</div>
		<div class="dados" style="z-index: -1;">
			<div class="bloco1" id="bloco1">
				<img src="imgs/user.png" height="15%" width="2%"> DADOS PESSOAIS 
				<div class="descricao">
					<br>
				 	 Marcus Melo nasceu em Mogi das Cruzes, tem 47 anos, é formado em Direito pela Universidade de Mogi das Cruzes, pós-graduado em Administração Estratégica pela Universidade Braz Cubas e possui MBA pela Fundação Getúlio Vargas. Antes de ingressar na Administração Pública, Marcus Melo construiu uma carreira sólida na iniciativa privada. É proprietário e administrador de uma das maiores e mais tradicionais escolas de Mogi das Cruzes. Em 2000, iniciou uma forte ligação com a Associação Comercial da cidade. Foi coordenador do Núcleo de Jovens Empreendedores e em 2008 chegou à vicepresidência da instituição. Durante todo o período esteve à frente de várias campanhas em defesa do setor e em 2009 foi eleito presidente da Associação Comercial de Mogi das Cruzes e vice-presidente da Facesp – Federação das Associações Comerciais do Estado de São Paulo. Ainda em 2009, Marcus Melo iniciou sua carreira na Administração Pública, como secretário-adjunto de Gabinete da Prefeitura de Mogi das Cruzes. Em 2011 assumiu a direção geral do Serviço Municipal de Águas e Esgotos, autarquia responsável pelo saneamento básico do município. Deixou o cargo em 2016 para disputar seu primeiro cargo eletivo, sendo eleito prefeito de Mogi das Cruzes em primeiro turno, com 129.763 votos, correspondentes a 64,34% dos votos válidos.
				 	 <br>
				 	 <br> Email:  gabinete@pmmc.com.br
				 	 <br> Telefone: 4798-5028
				 	 <br> Nascimento: 1 de setembro de 1972 (47 anos)
					 <br>Nacionalidade:	brasileiro
					 <br> Partido: PSDB
					 <br> Ocupação: Empresário
					 <br> Salário: 	R$ 27.520,30
				 </div>
			</div>

			<?php 
				include './conexao.php';
			    $conn = getConnection();

			    $sql = "SELECT * FROM tb_projetoslei WHERE AUTOR='PREFEITO'";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $result = $stmt->fetchAll();
			    echo '<div class="bloco4" id="bloco4">';
			    echo '<img src="imgs/project.png" height="15%" width="2%">  PROJETOS <br>';
			    foreach ($result as $newresult) {
			    	echo"<div class='toticias'> NÚMERO DO PROJETO <br> </div> <div class='corponoticia'>".$newresult['NUMERO']."</div><br>";
			    	echo" <div class='corponoticia'> ASSUNTO:".$newresult['ASSUNTO']."</div><br>";
			    	echo" <div class='corponoticia'> ANOTAÇÃO:".$newresult['ANOTACAO']."</div><br>";
			   	}
			    echo '</div>';
			?>
			
			<div class="bloco5" id="bloco5">
				<img src="imgs/comment.png" height="15%" width="2%">  COMENTÁRIOS 
			</div>
		</div>
	</body>
</html>