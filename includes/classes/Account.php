<?php

	class Account{

		private $con;
		private $errorArray;

		public function __construct($con){
			$this->con = $con;
			$this->errorArray = array();
		}

		public function login($un, $pw){
			// as senhas são encriptadas pois no banco de dados elas são armazedas encriptadas também, apenas assim para fazer a comparação
			$pw = md5($pw);
			// ele vai fazer a busca, encontrar e retornar a linha caso exista o usuário e senha já cadastrado
			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");
			// agora vamos verificar na busca, se foi encontrado
			if (mysqli_num_rows($query) == 1) {
				return true; // se tiver '1' é por que existe
			}else{ // caso contrário, está errado
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $emc, $pw, $pwd){
			// validações
			// $this-> é como se fosse no Java = this.validar..
			$this->validarUserName($un);
			$this->validarFirstName($fn);
			$this->validarLastName($ln);
			$this->validarEmails($em, $emc);
			$this->validarPasswords($pw, $pwd);

			if (empty($this->errorArray)) {
				// se o meu vetor de erros estiver vazio, não houve erros, então eu posso adicionar dentro do banco de dados
				return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
			}else{
				return false;
			}
		}

		// função apenas para verificar se houve algum erro
		public function getError($error){
			// a condição é de.. verifica se o erro que for recebida no parâmetro não existir dentro do array de erros, então
			if (!in_array($error, $this->errorArray)) {
				$error = "";
			}
			// com isso, retornamos a string, seja ela vazia ou contendo a mensagem de erro
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw){
			// vamos criptografar a senha, e o método a ser utilizado é o MD5
			$encriptyPW = md5($pw); // a senha colocada como paramâmetro será transforamda em uma sequência de número e letras
			$profilePic = "assets/images/profile-pics/austin.png"; //link para nossa foto de perfil
			$date = date("Y-m-d");
			$result = mysqli_query($this->con, "INSERT INTO users VALUES ('0','$un','$fn','$ln','$em','$encriptyPW','$date','$profilePic')"); // o ID é 0 pois será autocompletado no banco de dados

			return $result;
		}

		// as funções são 'private' pois elas só podem ser chamdas dentro dessa classe
		private function validarUserName($un){
			// vamos validar o tamanho em caracteres que o usuário irá digitar
			if (strlen($un) > 25 || strlen($un) < 5) {
				array_push($this->errorArray, Constants::$tamanhoUsername);
				return;
			}
			// caso não, apenas verificar se o nome de usuário já existe
			$checkUserNameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if (mysqli_num_rows($checkUserNameQuery) != 0) {
				array_push($this->errorArray, Constants::$usernameExist);
				return;
			}

		}

		private function validarFirstName($fn){

			if (strlen($fn) > 20 || strlen($fn) < 2) { 
				array_push($this->errorArray, Constants::$tamanhoNome);
				return;
			}
			
		}

		private function validarLastName($ln){

			if (strlen($ln) > 20 || strlen($ln) < 2) { 
				array_push($this->errorArray, Constants::$tamanhoSobrenome);
				return;
			}
			
		}

		private function validarEmails($em, $emc){
			// se os emails forem diferentes, é um erro
			if ($em != $emc) {
				array_push($this->errorArray, Constants::$naoCorrespondeEmail);
				return;
			}
			// vamos fazer uma verificação para ver se está no formato correto
			if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$invalidoEmail);
				return;
			}
			// verificar caso já exista este email cadastrado
			$checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if (mysqli_num_rows($checkEmailQuery) != 0) {
				array_push($this->errorArray, Constants::$emailExist);
				return;
			}
		}

		private function validarPasswords($pw, $pwc){
			// verificar se as senhas correspondem
			if ($pw != $pwc) {
				array_push($this->errorArray, Constants::$naoCorrespondeSenha);
				return;
			}
			// vamos verificar se possui caracteres além de alfanuméricos
			if (preg_match('/[^A-Za-z0-9]/', $pw)) { // a verificação consiste em.. se possuir caracteres além de a-z tanto maiúsculo quando minúculo e numerais de 0 a 9, se isso for falso, então faça -- representado pelo ^ que significa 'not'
				array_push($this->errorArray, Constants::$alfanumericoSenha);
				return;
			}
			// por fim verificamos o tamanho da senha
			if (strlen($pw) > 30 || strlen($pwc) < 5) {
				array_push($this->errorArray, Constants::$tamanhoSenha);
				return;
			}
		}


	}





?>