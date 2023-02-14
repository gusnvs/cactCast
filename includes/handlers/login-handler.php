<?php
// condição para quando o botão de login for pressionado ou inicializado
if(isset($_POST['loginButton'])) {
	//echo "bot]ao foi pressionado";

	$username = $_POST['loginUserName'];
	$password = $_POST['loginPassword'];

	// vamos chamar a função de login

	$result = $account->login($username, $password);

	if($result == true) {
		$_SESSION['userLoggedIn'] = $username; // uma variável para é um sinal para quando estiver logado
		header("Location: index.php");
	}

}
?>