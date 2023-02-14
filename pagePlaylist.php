<?php include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$playlistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner()); // temos que fazer isso por que pode não não estar logado o tempo todo, então podemos acessar a lista de outra pessoa

?>

<div class="entityInfo">

	<div class="leftSection">
		<img src="assets/images/icons/cactoplaylist.png">
	</div>

	<div class="rightSection">
		<h2><?php echo $playlist->getPlaylistName(); ?></h2>
		<p><?php echo $playlist->getOwner(); ?></p>
		<p>Podcasts favoritados: <?php echo $playlist->getNumberOfSongs(); ?></p>
		<button class="button delete" onclick="deletePlaylist('<?php $playlistId; ?>')">Excluir</button>

	</div>

</div>


<div class="tracklistContainer">
	<ul class="tracklist">
		
		<?php

		//precisamos obter uma função da classe playlist.php
		$songIdArray = $playlist->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			$playlistSong = new Song($con, $songId);
			$playlistArtist = $playlistSong->getArtist();

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $playlistSong->getTitle() . "</span>
						<span class='artistName'>" . $playlistArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $playlistSong->getDuration() . "</span>
					</div>


				</li>";

			$i = $i + 1;
		}

		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist:: getPlaylistDrop($con, $userLoggedIn->getUserName()); ?>
	<div class="item" onclick="removeFromPlaylistNow(this, '<?php echo $playlistId; ?>')">Remover</div>
</nav>


