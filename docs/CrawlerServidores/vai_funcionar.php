<?php

		require_once('dbcannect.php'); //cAnnect AMIGA
		$connection = connection();
		$json =  file_get_contents('http://www.licitacao.pmmc.com.br/Transparencia/vencimentos2');
        $jsonTratado = iconv('UTF-8', 'UTF-8//IGNORE', $json);
        $objVencimentos=json_decode(stripslashes($jsonTratado));
       	foreach ($objVencimentos->servidores as $servidor) {
       	echo $servidor->nome.'<br>';

       	
    // preparing statement for insert query
    	$st = mysqli_query($connection, "INSERT INTO tb_servidores(rgf, nome , cargo, rendimentos) VALUES ( '".$servidor->rgf."','". $servidor->nome."','". $servidor->cargo."','". $servidor->rendimentos."')");

    // bind variables to insert query params
    	echo $st;
} sair($connection);