<?php include("includes/includedFiles.php");

//a primeira coisa que vamos fazer é obter o ID do album da URL
//depois vamos ao banco de dados e buscar a linha que tem o ID da URL

if(isset($_GET['id'])) { // o $GET é como recuperamos as variáveis da URL
	$albumId = $_GET['id']; // atribuimos a uma variável
}
else {
	header("Location: index.php");
}

$album = new Album($con, $albumId);
$artist = $album->getArtist();

//echo $album->getTitle() . "<br>"; --- apenas para teste
?>

<div class="entityInfo">

	<div class="leftSection">
		<img src="<?php echo $album->getArtworkPath(); ?>">
	</div>

	<div class="rightSection">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>Apresentado por <?php echo $artist->getName(); ?></p>
		<p>Podcasts postados: <?php echo $album->getNumberOfSongs(); ?></p>

	</div>

</div>


<div class="tracklistContainer">
	<ul class="tracklist">
		
		<?php // aqui dentro vamos colocar os podcasts

		// precisamos pegar todos os podcasts desse album, então
		$songIdArray = $album->getSongIds(); // essa função retorna uma array de todos os dados(id) de podcasts do album

		$i = 1;
		foreach($songIdArray as $songId) {

			//echo $songId . "<br>"; ----- funciona

			// vamos criar agora objetos apresentáveis para a apresentação da lista dos podcasts

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
			var tempSongIds = '<?php echo json_encode($songIdArray); ?>'; // transformamos um array php em formato json
			tempPlaylist = JSON.parse(tempSongIds); // depois usamos o formato json transformando para objeto
		</script> 

	</ul>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId">
	<?php echo Playlist:: getPlaylistDrop($con, $userLoggedIn->getUserName()); ?>
</nav>
