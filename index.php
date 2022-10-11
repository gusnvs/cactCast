<?php

include("includes/config.php");

session_destroy(); // para caso o usuário queira sair manualmente e não continuar logado, a sessão é destruída 

// antes de realizarmos a condição, teremos um problema por que não iniciamos a sessão ainda, então... por isso o 'include' a cima

if (isset($_SESSION['userLoggedIn'])) { // se essa variável estiver definida...
	$userLoggedIn = $_SESSION['userLoggedIn']; // criamos uma variável que o usuário logou e defini-la igual à sessão
}else{ // se não for queremos redirecionar o usuário para a página de registro
	header("Location: register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CactCast</title>
</head>
<body>
	Olá mundo!!
</body>
</html>