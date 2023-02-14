<?php
	ob_start();
	// como queremos que o usuário apenas acesso a página index quando estiver logado, vamos...
	// e queremos que os dados sejam mantidos, que após reiniciar a páginas, os dados não sejam perdidos
	session_start(); // permite o uso de sessões

	$timezone = date_default_timezone_set("America/Campo_Grande");

	$con = mysqli_connect("localhost", "root", "", "cactcast");//servidor - usuário - senha - banco de dados

	if(mysqli_connect_errno()) {
		echo "Falha na conexão!" . mysqli_connect_errno();
	}
?>