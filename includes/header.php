<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");

//session_destroy(); // para caso o usuário queira sair manualmente e não continuar logado, a sessão é destruída 

// antes de realizarmos a condição, teremos um problema por que não iniciamos a sessão ainda, então... por isso o 'include' a cima

if(isset($_SESSION['userLoggedIn'])) { // se essa variável estiver definida...
	$userLoggedIn = $_SESSION['userLoggedIn'];
	// vamos ecoar um JS difinido, no caso o userLoggedIn para usar a variável logada
	// criamos uma variável que o usuário logou e defini-la igual à sessão
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	// com isso no console mostra o usuário já logado
	echo "<script>console.log('$userLoggedIn');</script>";
	// agora que temos o usuário logado numa variável JS, quando formos fazer a mudança de página, passamos usando o JS
}
else { // se não for queremos redirecionar o usuário para a página de registro
	header("Location: register.php");
}

?>

<html>
<head>
	<title>CactCast</title>

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>

<body>

	<!--
	<script>
		var audioElement = new Audio();
		audioElement.setTrack("assets/music/bensound-acousticbreeze.mp3");
		//audioElement.audio.play(); // precisamos chamar o audio.play pois trata-se de um objeto audio, entao a partir dele eu chamo a função play desse objeto audio

		audioElement.audio.oncanplaythrough = (event) => {
	    var playedPromise = audioElement.audio.play();
	    if (playedPromise) {
	        playedPromise.catch((e) => {
	             console.log(e)
	             if (e.name === 'NotAllowedError' || e.name === 'NotSupportedError') { 
	                   console.log(e.name);
	              }
	         }).then(() => {
	              console.log("ta tocando!!!");
	         });
	     	}
		}
	</script>
	-->

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">