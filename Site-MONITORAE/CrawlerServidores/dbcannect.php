<?php

//ENTER YOUR DATABASE CONNECTION INFO BELOW:
  

	function connection(){
		$hostname="localhost";
		$database="bdservidores";
		$username="root";
		$password="";
		$link = mysqli_connect($hostname, $username, $password,$database);
		return $link;

	}

	function sair($link){
		mysqli_close($link);
	}
?>
