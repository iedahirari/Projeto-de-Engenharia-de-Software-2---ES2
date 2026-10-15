<?php


	include './conexao.php';
    $conn = getConnection();
	$nome = $_POST['nome'];

    $sql = "SELECT * FROM tb_servidores WHERE rgf like '%$nome%'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

	foreach ($result as $newresult) {
		 echo '
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


				<tr>
					<td>'.$newresult["codigo"].'</td>
					<td>'.$newresult["rgf"].'</td>
					<td>'.$newresult["nome"].'</td>
					<td>'.$newresult["cargo"].'</td>
					<td>'.$newresult["rendimentos"].'</td>
				</tr>
			</table>

		 ';
	}
