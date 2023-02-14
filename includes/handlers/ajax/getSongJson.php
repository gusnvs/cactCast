<?php
include("../../config.php");

// a ideia aqui é ir a tabela de podcasts, onde passamos o ID do podcast, e em seguida recuperamos o podcast, para depois ecoá-lo
//echo "Ola!";

if(isset($_POST['songId'])) {// vamos recuperar a variável 
	$songId = $_POST['songId'];

	$query = mysqli_query($con, "SELECT * FROM songs WHERE id='$songId'"); // esta consulta retornará um podcast
	$resultArray = mysqli_fetch_array($query);
	// agora por fim vamos ecoar, mas não apenas ecoar e sim convertê-lo para json
	echo json_encode($resultArray);
}


?>