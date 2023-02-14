<?php 
include("includes/includedFiles.php");
?>

<div class="playlistContainer">
	<div class="gridViewContainer">
		<h1>Favoritos</h1>
		<div class="buttonItems">
			<button class="button orange" onclick="creatPlaylist()">Nova Playlist</button>
		</div>


		<?php

			$username = $userLoggedIn->getUserName();
			$playlistQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

			if (mysqli_num_rows($playlistQuery) == 0) {
				echo "<span class='noResults'>Você não possui nenhuma playlist!</span>";
			}


			while($row = mysqli_fetch_array($playlistQuery)) {


				$playlist = new Playlist($con, $row);

				echo "<div class='gridViewItem' onclick='openPage(\"pagePlaylist.php?id=" . $playlist->getId() . "\")'>

						<div class='playlistImage'>
							<img src='assets/images/icons/cactoplaylist.png'>
						</div>

						<div class='gridViewInfo'>"
								. $playlist->getPlaylistName() .
						"</div>
					</div>";
			}
		?>








	</div>
</div>