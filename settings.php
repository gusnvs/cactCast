<?php 
include("includes/includedFiles.php");
?>

 <div class="entityInfo">
 	<div class="centerSection">
 		<div class="userInfo">
 			<h1><?php echo $userLoggedIn->getFistAndLastName(); ?></h1>
 			<h1><?php echo $userLoggedIn->getUserName(); ?></h1>
 			<img src="<?php echo $userLoggedIn->getProfilePic(); ?>">
 		</div>
 		<div class="buttonItems">
 			<button class="button orange" onclick="logout()">Sair</button>
 		</div>
 	</div>
 </div>