<?php

include(__DIR__ . '/../lib/simple_html_dom.php');

$html = file_get_html('http://cmmc.com.br/vereadores/');

/*echo file_get_html('http://cmmc.com.br/vereadores/');*/

echo $html-> find ('table', 10);

foreach($html->find('table') as $element)
       echo $element->src . '<br>';


foreach( $html->find('a') as $element)
{
	echo $element->plaintext;
	echo "<br>";
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
