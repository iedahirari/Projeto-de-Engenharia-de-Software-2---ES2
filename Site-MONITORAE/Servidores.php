<?php
	include("conexao2.php");

	$consulta = "SELECT * from tb_servidores";
	$con = $mysqli->query($consulta) or die($mysqli->error);	
?>
<html>
<head>
	<meta charset="utf-8">
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
	 <link href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet">
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
					<a href="PerfilVereador.php">Vereadores</a>
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
		<p> <p> <p> <p> <p> <p>
		<div class="tituloRel"> SERVIDORES PÚBLICOS E ESTAGIÁRIOS </div>
		<p> Gastos com servidores públicos e estagiários, dentro dos limites estabelecidos pela Lei de Responsabilidade Fiscal, podem ser verificados e acompanhados periodicamente.</p>
			
			<table id="minhaTabela">
				<style >
					table{ 
						border-bottom-color: orange;
						display: flex;
						justify-content: center;
						align-items: center; 
						font-family: "Trebuchet MS", arial;

					}
					th{
						height: 20px;
						width: 20%;
						display: flex;
						justify-content: space-around;
						align-items: center;
						font-weight: bold;
						color: #03bb85;
					}
					tr{
						border-bottom: 1px solid #111;
						border-color: orange;
						height: 60px;
						width: 100%;
						display: flex;
						justify-content: space-around;
						align-items: center;
						text-align: center;
						padding: 0 25px;
					}
					td{
						height: 60px;
						width: 20%;
						display: flex;
						justify-content: center;
						align-items: center;
						text-align: center;
						padding: 0 25px;
					}
				</style>
				<tr> 
					<th > Código </th>
					<th> RGF </th>
					<th> Nome </th>
					<th> Cargo </th>
					<th> Rendimento </th>
				</tr>
				<?php while($dado = $con->fetch_array()){ ?>
				<tr>
					<td> <?php echo $dado["codigo"]; ?> </td>
					<td> <?php echo $dado["rgf"]; ?> </td>
					<td> <?php echo $dado["nome"]; ?></td>
					<td> <?php echo $dado["cargo"]; ?></td>
				    <td> R$ <?php echo $dado["rendimentos"];?></td> 
				</tr>
			<?php } ?>
			</table>

			 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
			 <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
  			 <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  			   <script>
				  $(document).ready(function(){
				      $('#minhaTabela').DataTable();
				  });
  				</script>
		</div>
</html>