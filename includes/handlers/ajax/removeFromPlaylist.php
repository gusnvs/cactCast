<?php 
include("../../config.php");

if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
	
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$query = mysqli_query($con, "DELETE FROM playlistpodcasts WHERE playlistId='$playlistId' AND podcastId='$songId'");

}else{
	echo "playlistId ou songId não foi passado na classe removeFromPlaylist.php!";
}

 ?>