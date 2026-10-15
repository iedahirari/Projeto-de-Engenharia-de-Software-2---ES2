<?php

// Copie este arquivo para "conexao.php" (na mesma pasta) e preencha com os
// dados do seu MySQL. O conexao.php fica fora do Git (.gitignore) para que
// senhas não sejam publicadas.

	function connection(){
		$hostname="localhost";
		$database="bdservidores";
		$username="root";
		$password="";

		mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		$link = mysqli_connect($hostname, $username, $password, $database);
		mysqli_set_charset($link, 'utf8mb4');
		return $link;
	}

	function sair($link){
		mysqli_close($link);
	}
