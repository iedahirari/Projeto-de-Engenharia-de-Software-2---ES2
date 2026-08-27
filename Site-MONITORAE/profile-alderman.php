<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="shortcut icon" type="image/x-png" href="./imgs/icon.png"/>
		<link rel="stylesheet" type="text/css" href="./css/index.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
		<title> MONITORAÊ </title>
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
		<div class="lista">
			<div class="mensagem1">
				Outros vereadores
				<div class="busca2">
					<input class="perfil" type="text" placeholder="    Pesquise por um vereador" value="" tabindex="1" autocomplete="off" id="campodepesquisaveredor">
				</div>

				<script>
					$('#campodepesquisaveredor').keyup(function() {
						var campo = document.querySelector("#campodepesquisaveredor").value;
					 	pesquisa(campo);
					});

					function pesquisa(nome){
						$.ajax({
						  type: 'post',
						  url: 'pesquisa.php',
						  data: {nome: nome},
						  success: function(data){
                        	$(".quadro").html(data);
                    	  }
						});
					}
				</script>

				<!-- <script>
					function pesquisa(nome){
						$.ajax({
						  type: 'post',
						  url: 'pesquisa.php',
						  data: {nome: nome}
						});

				        $.post(url, function(result) {
				        	alert(result);
				        });
					}
				</script> -->

				<div class="quadro" style="height: 500px;overflow-y: auto;">
					<?php 
						include './conexao.php';
					    $conn = getConnection();

					    $sql = "SELECT * FROM tb_vereadores";
					    $stmt = $conn->prepare($sql);
					    $stmt->execute();
					    $result = $stmt->fetchAll();

					    foreach ($result as $newresult) {
					    	echo "<br>";
					        echo "<div style='display:flex;align-items:center;'><img src=".$newresult['imagem']." style='width:64px;height:64px;border-radius:100%;margin-right:10px;border:3px solid #ffb230;'><div style='width:100%;'><a href='profile-alderman.php?id=".$newresult['codigo']."&nome=".$newresult['NOME']."' style='color:#111;text-decoration:none;font-size:14px;text-align:center;'>".$newresult['NOME']."</a></div></div><br>";
					    } 
					?>
				</div>
				
			</div>
		</div>
		<div class="visao">
			<?php 
				// include './conexao.php';
			    // $conn = getConnection();
				$id = $_GET['id'];

			    $sql = "SELECT * FROM tb_vereadores WHERE codigo='$id'";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $result = $stmt->fetch();

				echo "
				<div class='foto'>
					<img src='".$result['imagem']."' style='width:200px;height:200px;border-radius:100%;border:3px solid #ffb230;'>
				</div>
				";

				echo "
				<div class='nome'>
					<p style='font-size:18px;color:#111;'>".$result['NOME']."</p>
				</div>
				";
			?>


			<div class="dadosPessoais">
				DADOS PESSOAIS
			</div>
			<!-- <div class="plenario">
				ATUAÇÃO NO PLENÁRIO E COMISSÕES
			</div> -->
			<div class="deshboardPerfil">
				DESHBOARD
			</div>
			<div class="projetos">
				PROJETOS
			</div>
			<div class="comentarios">
				COMENTÁRIOS
			</div>
		</div>
		<div class="dadosv">
			<?php 
				// include './conexao.php';
			    // $conn = getConnection();
				$id = $_GET['id'];

			    $sql = "SELECT * FROM tb_vereadores WHERE codigo='$id'";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $result = $stmt->fetchAll();


				echo '
				<div class="bloco1" id="bloco1">
					<img src="imgs/user.png" height="15%" width="3.5%"> DADOS PESSOAIS 
				';

				foreach ($result as $newresult) {
					echo "<br>";
					echo "<p> <div class='toticias'> ATIVIDADE <br> </div> <div class='corponoticia'>".$newresult['ATIVIDADE']."</div> </p><br>";
					echo "<p> <div class='toticias'> FORMAÇÃO <br> </div> <div class='corponoticia'>".$newresult['FORMACAO']."</div></p><br>";
					echo "<p> <div class='toticias'>  DATA DE NASCIMENTO <br> </div> <div class='corponoticia'>".$newresult['DATANASCIMENTO']."</div></p><br>";
					echo "<p> <div class='toticias'>  ESTADO CIVIL <br> </div> <div class='corponoticia'>".$newresult['ESTADOCIVIL']."</div></p><br>";
					echo "<p> <div class='toticias'> QUANTIDADE DE VOTOS <br> </div> <div class='corponoticia'>".$newresult['VOTOS']."</div></p><br>";
					echo "<p> <div class='toticias'> LEGISLATURA <br> </div> <div class='corponoticia'>".$newresult['LEGISLATURA']."</div></p><br>";
					echo "<p> <div class='toticias'> TELEFONE <br> </div> <div class='corponoticia'>".$newresult['TELEFONE']."</div></p><br>";
					echo "<p> <div class='toticias'>  EMAIL <br> </div> <div class='corponoticia'>".$newresult['EMAIL']."</div></p><br>";
					echo "<p> <div class='toticias'>  PARTIDO <br> </div> <div class='corponoticia'>".$newresult['Partido']."</div></p><br>";
					echo "<p> <div class='toticias'>  SALÁRIO LÍQUIDO <br> </div> <div class='corponoticia'> R$ ".$newresult['SALARIO']."</div></p><br>";
				}
				echo'
				</div>
				';
			?>
			
			<!-- <div class="bloco2" id="bloco2">
				<img src="imgs/calendar.png" height="15%" width="3.5%">  ATUAÇÃO NO PLENÁRIO E COMISSÕES 
			</div> -->
			<?php 
				// include './conexao.php';
			    // $conn = getConnection();
				$nome = $_GET['nome'];

			    $sql = "SELECT * FROM tb_projetoslei WHERE AUTOR='$nome'";
			    $stmt = $conn->prepare($sql);
			    $stmt->execute();
			    $result = $stmt->fetchAll();


				echo '
				<div class="bloco4" id="bloco4">
					<img src="imgs/project.png" height="15%" width="3.5%">  PROJETOS 
				';

				foreach ($result as $newresult) {
					echo "<br>";
					echo "<p> <div class='toticias'> NÚMERO DO PROJETO <br> </div> <div class='corponoticia'>".$newresult['NUMERO']."</div></p><br>";
					echo "<p> <div class='corponoticia'> ASSUNTO: ".$newresult['ASSUNTO']."</div></p><br>";
					echo "<p> <div class='corponoticia'> ANOTAÇÃO: ".$newresult['ANOTACAO']."</div></p><br>";
				}

				echo'
				</div>
				';
			?>
			
			<div class="bloco5" id="bloco5">
				<img src="imgs/comment.png" height="15%" width="3.5%">  COMENTÁRIOS 
			</div>
		</div>
	</body>
</html>