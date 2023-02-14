<?php 
include("includes/includedFiles.php");

if(isset($_GET['id'])) {
	$genreId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$genre = new Genre($con, $genreId);

?>

<div class="entityInfo borderBottom">
	<div class="centerSection">
		<div class="genreInfo">
			<h1 class="genreName"><?php echo $genre->getType(); ?></h1>
			<div class="genrePlay">
				<button class="button" onclick="playFirstPodcast()">Play</button>
			</div>
		</div>
	</div>
</div>

<div class="tracklistContainer borderBottom">
	<ul class="tracklist">
		<h2>Podcasts</h2>
		<?php
		$songIdArray = $genre->getSongIds();

		$i = 1;
		foreach($songIdArray as $songId) {

			$albumSong = new Song($con, $songId);
			$albumArtist = $albumSong->getArtist();

			echo "<li class='tracklistRow'>
					<div class='trackCount'>
						<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
						<span class='trackNumber'>$i</span>
					</div>


					<div class='trackInfo'>
						<span class='trackName'>" . $albumSong->getTitle() . "</span>
						<span class='artistName'>" . $albumArtist->getName() . "</span>
					</div>

					<div class='trackOptions'>
						<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
						<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionMenu(this)'>
					</div>

					<div class='trackDuration'>
						<span class='duration'>" . $albumSong->getDuration() . "</span>
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

<div class="gridViewContainer">
	<h2>Canais</h2>
	<?php
		$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE genre='$genreId'");

		while($row = mysqli_fetch_array($albumQuery)) {

			echo "<div class='gridViewItem'>
					<span onclick='openPage(\"album.php?id=" . $row['id'] . "\")'>
						<img src='" . $row['artworkPath'] . "'>

						<div class='gridViewInfo'>"
							. $row['title'] .
						"</div>
					</span>

				</div>";
		}
	?>

</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist:: getPlaylistDrop($con, $userLoggedIn->getUserName()); ?>
</nav>
