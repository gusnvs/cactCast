<?php include("../../config.php");

// vamos apenas fazer uma consulta que insere os dados no banco de dados

if (isset($_POST['name']) && isset($_POST['username'])) {
	
	$name = $_POST['name'];
	$username = $_POST['username'];
	$date = date("Y-m-d");

	$query = mysqli_query($con, "INSERT INTO playlists VALUES('', '$name', '$username', '$date')");
}else{
	echo "Nome ou Usuário não foram passados!";
}

 ?>