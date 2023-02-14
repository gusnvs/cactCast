<?php
include("../../config.php");


if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
	$playlistId = $_POST['playlistId'];
	$songId = $_POST['songId'];

	$orderIdQuery = mysqli_query($con, "SELECT IFNULL(MAX(plalistOrder) + 1, 1) as plalistOrder FROM playlistpodcasts WHERE playlistId='$playlistId'");
	$row = mysqli_fetch_array($orderIdQuery);
	$order = $row['plalistOrder'];

	$query = mysqli_query($con, "INSERT INTO playlistpodcasts VALUES('', '$songId', '$playlistId', '$order')");

}
else {
	echo "PlaylistId or songId was not passed into addToPlaylist.php";
}



?>