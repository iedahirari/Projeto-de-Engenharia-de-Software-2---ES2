<?php


	include './conexao.php';
    $conn = getConnection();
	$nome = $_POST['nome'];

    $sql = "SELECT * FROM tb_vereadores WHERE NOME like '%$nome%' OR Partido = '$nome'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();

	foreach ($result as $newresult) {
		 echo "<div style='display:flex;align-items:center;'><img src=".$newresult['imagem']." style='width:64px;height:64px;border-radius:100%;margin-right:10px;border:3px solid #ffb230;'><div style='width:100%;'><a href='profile-alderman.php?id=".$newresult['codigo']."&nome=".$newresult['NOME']."' style='color:#111;text-decoration:none;font-size:14px;text-align:center;'>".$newresult['NOME']."</a></div></div><br>";
	}
