<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");
	// função com intuito apenas de deixar salvo a informação no campo caso o registro falhe por algum erro
	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<html>
<head>
	<title>Bem vindo ao CactCast!</title>

	<link rel="stylesheet" type="text/css" href="assets/css/register.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>
	<?php

	if(isset($_POST['registerButton'])) {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").hide();
					$("#registerForm").show();
				});
			</script>';
	}
	else {
		echo '<script>
				$(document).ready(function() {
					$("#loginForm").show();
					$("#registerForm").hide();
				});
			</script>';
	}

	?>
	

	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<h2>faça seu login</h2>
					<p>
						<span class="errorMessage"><?php echo $account->getError(Constants::$loginFailed); ?></span>
						<label for="loginUsername">Usuário</label>
						<input id="loginUsername" name="loginUserName" type="text" placeholder="Login" value="<?php getInputValue('loginUsername') ?>" required>
					</p>
					<p>
						<label for="loginPassword">Senha</label>
						<input id="loginPassword" name="loginPassword" type="password" required>
					</p>

					<button type="submit" name="loginButton">Entrar</button>

					<div class="hasAccountText">
						<span id="hideLogin">Não possui conta? Crie aqui</span>
					</div>
					
				</form>



				<form id="registerForm" action="register.php" method="POST">
					<h2>crie sua conta</h2>
					<p>
						<?php echo $account->getError(Constants::$tamanhoUsername); ?>
						<?php echo $account->getError(Constants::$usernameExist); ?>
						<label for="username">Usuário</label>
						<input id="username" name="userName" type="text" placeholder="meninoNey" value="<?php getInputValue('userName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$tamanhoNome); ?>
						<label for="firstName">Primeiro nome</label>
						<input id="firstName" name="firstName" type="text" placeholder="Neymar" value="<?php getInputValue('firstName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$tamanhoSobrenome); ?>
						<label for="lastName">Sobrenome</label>
						<input id="lastName" name="lastName" type="text" placeholder="Júnior" value="<?php getInputValue('lastName') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$naoCorrespondeEmail); ?>
						<?php echo $account->getError(Constants::$invalidoEmail); ?>
						<?php echo $account->getError(Constants::$emailExist); ?>
						<label for="email">E-mail</label>
						<input id="email" name="email" type="email" placeholder="neymar@brasil.com" value="<?php getInputValue('email') ?>" required>
					</p>

					<p>
						<label for="email2">Confirmação de e-mail</label>
						<input id="email2" name="emailConfirm" type="email" value="<?php getInputValue('emailConfirm') ?>" required>
					</p>

					<p>
						<?php echo $account->getError(Constants::$naoCorrespondeSenha); ?>
						<?php echo $account->getError(Constants::$alfanumericoSenha); ?>
						<?php echo $account->getError(Constants::$tamanhoSenha); ?>
						<label for="password">Senha</label>
						<input id="password" name="password" type="password" required>
					</p>

					<p>
						<label for="password2">Confirmação de senha</label>
						<input id="password2" name="passwordConfirm" type="password" required>
					</p>

					<button type="submit" name="registerButton">Criar</button>

					<div class="hasAccountText">
						<span id="hideRegister">Já possui conta? Entre aqui</span>
					</div>
					
				</form>


			</div>

			<div id="loginText">
				<h1 class="welcome">Bem vindo ao</h1>
				<h1 class="cactCast">CactCast</h1>
				<h2 class="welcomeInfo">O seu melhor site de podcast está aqui</h2>
				<div id="loader"></div>
			</div>
		</div>
		<img src="assets/images/cacto.png" id="logoCactCast" >
		<div id="infoGroup">Grupo 12</div>
	</div>

</body>
</html>