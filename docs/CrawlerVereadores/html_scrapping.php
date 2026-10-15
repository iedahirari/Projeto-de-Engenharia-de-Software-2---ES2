<?php

require_once('dbcannect.php');
$connection = connection();



include('simple_html_dom.php');

$html = file_get_html('http://cmmc.com.br/vereadores/');


$vereadores = [];
$index = 0;
$style74 = [];

foreach($html->find('.style74') as $element){    

	array_push($style74, $element);
	//echo $nomes[$index];
	//$index++;
	
}

foreach($style74 as $key => $value){
	if($key % 2 == 1){
		echo $value->plaintext;
		$vereador = new stdClass;
		$vereador->nome = $value->plaintext;
		array_push($vereadores, $vereador);
		//print_r ($vereadores);
		
	}
}

foreach($html->find('.style75') as $key => $element){    
	
	$vereador = file_get_html('http://cmmc.com.br/vereadores/' . $element->find('a')[0]->getAttribute("href"));
	
	$info = $vereador->find('.style76');
	//echo $info[1]->plaintext;
	
	//echo $info[0];
	
	$dados = explode("\n", $info[0]->plaintext);
	//print_r ($dados);
	
	$atividade = explode(":", $dados[0], 2)[1];
	echo $atividade;
	echo '<br>';
	$vereadores[$key]->atividade = $atividade;
	
	$formacao = explode(":", $dados[2], 2)[1];
	echo $formacao;
	echo '<br>';
	$vereadores[$key]->formacao = $formacao;
	
	$datanascimento = explode(":", $dados[4], 2)[1];
	echo $datanascimento;
	echo '<br>';
	$vereadores[$key]->datanascimento = $datanascimento;
	
	$estadocivil = explode(":", $dados[6], 2)[1];
	echo $estadocivil;
	echo '<br>';
	$vereadores[$key]->estadocivil = $estadocivil;
	
	$votos = explode(":", $dados[8], 2)[1];
	echo $votos;
	echo '<br>';
	$vereadores[$key]->votos = $votos;
	
	$legislatura = explode(":", $dados[10], 2)[1];
	echo $legislatura;
	echo '<br>';
	$vereadores[$key]->legislatura = $legislatura;
	
	$telefone = explode(":", $info[1]->plaintext, 2)[1];
	echo $telefone;
	echo '<br>';
	$vereadores[$key]->telefone = $telefone;
	
	$email = explode(":", $info[2]->plaintext, 2)[1];
	echo $email;
	echo '<br>';
	$vereadores[$key]->email = $email;
	echo '<br>';
	
	$st = mysqli_query($connection, "INSERT INTO `vereadores` (`NOME`, `ATIVIDADE`, `FORMACAO`, `DATANASCIMENTO`, `ESTADOCIVIL`, `VOTOS`, `LEGISLATURA`, `TELEFONE`, `EMAIL`) VALUES ('".$vereadores[$key]->nome."', '".$vereadores[$key]->atividade."', '".$vereadores[$key]->formacao."', '".$vereadores[$key]->datanascimento."', '".$vereadores[$key]->estadocivil."', '".$vereadores[$key]->votos."', '".$vereadores[$key]->legislatura."', '".$vereadores[$key]->telefone."', '".$vereadores[$key]->email."')");
}




























/*require_once('dbcannect.php'); //cAnnect AMIGA
		$connection = connection();
		$json =  file_get_contents('http://www.licitacao.pmmc.com.br/Transparencia/vencimentos2');
        $jsonTratado = iconv('UTF-8', 'UTF-8//IGNORE', $json);
        $objVencimentos=json_decode(stripslashes($jsonTratado));
       	foreach ($objVencimentos->servidores as $servidor) {
		echo $servidor->rgf.' ';	
       	echo $servidor->nome.' ';
		echo $servidor->cargo.' ';
		echo $servidor->rendimentos.'<br>';

       	
    // preparing statement for insert query
    	$st = mysqli_query($connection, "INSERT INTO tb_funcionario(rgf, nome , cargo, rendimentos) VALUES ( '".$servidor->rgf."','". $servidor->nome."','". $servidor->cargo."','". $servidor->rendimentos."')");

    // bind variables to insert query params
    	echo $st;
} sair($connection);
*/
?>
