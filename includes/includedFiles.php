<?php 

// neste php vamos verificar se a solicitação foi enviada pelo AJAX ou se você acessou manualmente
// pois estão sendo execultados em duplicidade o header e footer


if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
	// então isso signigica que se foi enviado pelo AJAX, o código deve acontecer
	//echo "VEIO DO AJAX"; -----> funciona

	// porém entrando nesse if, ele não excultava outros arquivos que estão presentes no header.php, então ponho manualmente
	include("includes/config.php");
	include("includes/classes/User.php");
	include("includes/classes/Artist.php");
	include("includes/classes/Album.php");
	include("includes/classes/Song.php");
	include("includes/classes/Genre.php");
	include("includes/classes/Playlist.php");

	if (isset($_GET['userLoggedIn'])) {
		$userLoggedIn = new User($con, $_GET['userLoggedIn']);
	}else{
		echo "Não conseguimos passar o userLoggedIn para está página. Olhar o openPage JS.";
		exit();
	}
}else{
	// agora se não veio uma solicitação AJAX, você digitou a url manualmente
	include("includes/header.php");
	include("includes/footer.php");
	//... mas não veio o conteúdo, então chamamos a função openPage()

	$url = $_SERVER['REQUEST_URI'];
	echo "<script>openPage('$url')</script>";

	exit(); // impedirá duplicidade do conteúdo
}

 ?>