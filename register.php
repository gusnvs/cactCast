<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	$account = new Account($con);
	include("includes/classes/Constants.php");
	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	// função com intuito apenas de deixar salvo a informação no campo caso o registro falhe por algum erro
	function getValorPassado($name){
		if (isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bem vindo ao CactCast!</title>
</head>
<body>

	<div id="input-container">
		<form id="login-form" action="register.php" method="POST">
			<h1>Bem Vindo ao CactCast</h1>
			<h2>Faça seu Login</h2>
			<p>
				<?php echo $account->getError(Constants::$loginFailed); ?>
				<label for="login-user">Usuário</label>
				<input id="login-user" type="text" name="loginUserName" placeholder="Login" required>
			</p>
			<p>
				<label for="login-password">Senha</label>
				<input id="login-password" type="password" name="loginPassword" required>
			</p>
			
			<button type="submit" name="loginButton">Entrar</button>

		</form>

		<form id="register-form" action="register.php" method="POST">
			<h2>Crie sua conta</h2>
			<p>
				<?php echo $account->getError(Constants::$tamanhoUsername); ?>
				<?php echo $account->getError(Constants::$usernameExist); ?>
				<label for="name-user">Usuário</label>
				<input id="name-user" type="text" name="userName" placeholder="meninoNey" value="<?php getValorPassado('userName') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$tamanhoNome); ?>
				<label for="first-name">Primeiro nome</label>
				<input id="first-namer" type="text" name="firstName" placeholder="Neymar" value="<?php getValorPassado('firstName') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$tamanhoSobrenome); ?>
				<label for="last-name">Sobrenome</label>
				<input id="last-name" type="text" name="lastName" placeholder="Júnior" value="<?php getValorPassado('lastName') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$naoCorrespondeEmail); ?>
				<?php echo $account->getError(Constants::$invalidoEmail); ?>
				<?php echo $account->getError(Constants::$emailExist); ?>
				<label for="email">E-mail</label>
				<input id="email" type="email" name="email" placeholder="neymar@brasil.com.br" value="<?php getValorPassado('email') ?>" required>
			</p>
			<p>
				<label for="email-confirm">Confirmação de e-mail</label>
				<input id="email-confirm" type="email" name="emailConfirm" placeholder="neymar@brasil.com.br" value="<?php getValorPassado('emailConfirm') ?>" required>
			</p>
			<p>
				<?php echo $account->getError(Constants::$naoCorrespondeSenha); ?>
				<?php echo $account->getError(Constants::$alfanumericoSenha); ?>
				<?php echo $account->getError(Constants::$tamanhoSenha); ?>
				<label for="password">Senha</label>
				<input id="password" type="password" name="password" placeholder="sua senha" required>
			</p>
			<p>
				<label for="password-confirm">Confirmação de senha</label>
				<input id="password-confirm" type="password" name="passwordConfirm" placeholder="sua senha" required>
			</p>
			
			<button type="submit" name="registerButton">Criar</button>

		</form>
	</div>

</body>
</html>