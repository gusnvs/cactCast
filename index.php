<?php

include("includes/config.php");

//session_destroy(); // para caso o usuário queira sair manualmente e não continuar logado, a sessão é destruída 

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
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CactCast</title>
</head>
<body>
	

	<div id="nowPlayBarContainer">
		<div id="nowPlayBar">
			<div id="nowPlayLeft">
				<div class="content">
					<span class="albumLink">
						<img src="https://yt3.ggpht.com/ytc/AMLnZu9VTkgTp2RbpDE_3taaNpj454_yvg_CZPtyVb-3Ew=s900-c-k-c0x00ffffff-no-rj" class="albumArt">
					</span>
					<div class="trackInfo">
						<span class="trackTitle">
							<span>PRIMO RICO - Flow #122</span>
						</span>
						<span class="trackChannel">
							<span>Flow Podcast</span>
						</span>
					</div>
				</div>
			</div>
			<div id="nowPlayCenter">
				
				<div class="content playerControls">
					<div class="buttons">
						<button class="controlButton shuffle" title="Shuffle Button">
							<img src="assets/images/icons/shuffle.png" alt="Shuffle">
						</button>
						<button class="controlButton previous" title="Previous Button">
							<img src="assets/images/icons/previous.png" alt="Previous">
						</button>
						<button class="controlButton play" title="Play Button">
							<img src="assets/images/icons/play.png" alt="Play">
						</button>
						<button class="controlButton pause" title="Pause Button" style="display: none;">
							<img src="assets/images/icons/pause.png" alt="Pause">
						</button>
						<button class="controlButton next" title="Next Button">
							<img src="assets/images/icons/next.png" alt="Next">
						</button>
						<button class="controlButton repeat" title="Repeat Button">
							<img src="assets/images/icons/repeat.png" alt="Repeat">
						</button>
					</div>
					<div class="playbackBar">
						<span class="progressTime current">0.00</span>
						<div class="progressBar">
							<div class="progressBarBackground"><div class="progress"></div></div>
						</div>
						<span class="progressTime remaining">0.00</span>
					</div>
				</div>
			</div>
			<div id="nowPlayRight">
				<div class="volumeBar">
					<button class="controlButton volume" title="Volume button">
						<img src="assets/images/icons/volume.png" alt="Volume">
					</button>
					<div class="progressBar">
						<div class="progressBarBackground"><div class="progress"></div></div>
					</div>
				</div>
			</div>
		</div>
	</div>



</body>
</html>