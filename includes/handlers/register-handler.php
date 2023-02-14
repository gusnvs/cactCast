<?php

function formalizarUserName($inputText){ // função para transformar o usário no formato correto que queremos salvar

	$inputText = strip_tags($inputText); // caso seja digitado tags HTML e PHP serão retiradas
	$inputText = str_replace(" ", "", $inputText); // caso seja digitado espaço no input, ele retirará os espaços
	return $inputText;
}

function formalizarString($inputText){ // função para transformar a escrita(genérica) no formato correto que queremos salvar

	$inputText = strip_tags($inputText); // caso seja digitado tags HTML e PHP serão retiradas
	$inputText = str_replace(" ", "", $inputText); // caso seja digitado espaço no input, ele retirará os espaços
	$inputText = ucfirst(strtolower($inputText)); // transformo toda a string em minúculo depois retorno com primeiro caract maiúsculo
	return $inputText;
}

function formalizarPassword($inputText){ // função para transformar o usário no formato correto que queremos salvar

	$inputText = strip_tags($inputText); // caso seja digitado tags HTML e PHP serão retiradas
	return $inputText;
}

// condição para quando o botão de registro for pressionado ou inicializado
if (isset($_POST['registerButton'])) { 
	// transformação dos dados para serem salvos
	$username = formalizarUserName($_POST['userName']);
	$firstname = formalizarString($_POST['firstName']);
	$lastname = formalizarString($_POST['lastName']);
	$email = formalizarString($_POST['email']);
	$emailconfirm = formalizarString($_POST['emailConfirm']);
	$password = formalizarPassword($_POST['password']);
	$passwordconfirm = formalizarPassword($_POST['passwordConfirm']);	

	$sucessOrFalse = $account->register($username, $firstname, $lastname, $email, $emailconfirm, $password, $passwordconfirm);

	// se o registro for bem sucedido, iremos então para a página de início
	if ($sucessOrFalse) {
		$_SESSION['userLoggedIn'] = $username; // uma variável para é um sinal para quando estiver logado
		header("Location: index.php");
	}
}

?>

