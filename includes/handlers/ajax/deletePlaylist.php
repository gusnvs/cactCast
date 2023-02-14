<?php
include("../../config.php");

if(isset($_POST['playlistId'])) {
	$playlistId = $_POST['playlistId'];

	echo "entra aqui deletePlaylist.php"

	$playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId'");
	$podcastQuery = mysqli_query($con, "DELETE FROM playlistpodcasts WHERE playlistId='$playlistId'");
}
else {
	echo "PlaylistId não foi passado no deletePlaylist.php";
}

?>
