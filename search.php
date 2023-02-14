<?php
include("includes/includedFiles.php"); 

//precisamos do termo de pesquisa, que vem da url

if (isset($_GET['term'])) {
	$term = urldecode($_GET['term']); // preciso do encode pois quando pesquisamos com algum espaço ou algum caractere que não é reconhecido, ele adiciona o %20, então temos que decoficar para o %20 voltar a ser um espaço na hora da pesquisa
	//echo $term; ---> funciona
}else{
	$term = "";
}
?>

<div class="searchContainer">
	<h4>pesquise por um canal, categoria ou apresentador</h4>
	<input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="digite aqui...">
</div>

<script>

	$(".searchInput").focus(); // eu preciso desse focus por quando há um tempo grande, maior do que um segundo para continuar digitando, ele perde o foco do input e vai pra url, e assim não consigo mais digitar
	// então a solução é colocar o foco sempre no input
	//---------- mas agora o volta para o começo do input e não aonde foi terminado de digitar



	$(function() {
		// vamos criar um evento toda a vez que o usuário digitar uma letra
		var timer;

		// usando um objeto jquery
		$(".searchInput").keyup(function(){ // deixando tudo minusculo, e vamos limpar o tempo limite 
			clearTimeout(timer);
			// precisamos desse clear pois quando se está digitando e termina, ele começa a contar um tempo, e quando eu parar de digitar e for digitar novamente, ele cancela o cronômetro e define um outro novo

			timer = setTimeout(function() {
				//console.log("funciona");
				var val = $(".searchInput").val(); // ele vai capturar o próprio valor do campo 
				openPage("search.php?term=" + val);
			}, 1000); // ele vai execultar depois de um certo tempo, em milisegundos
			// no caso, depois de um segundo após digitar, vamos execultar uma página
		});

	});
</script>

<div class="tracklistContainer borderBottom">
	<ul class="tracklist">
		<h2>Podcasts</h2>
		<?php

		$podcastQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '%$term%'");

		if (mysqli_num_rows($podcastQuery) == 0) {
			echo "<span class='noResults'>" . $term . " não foi um resultado encontrado!</span>";
		}

		$songIdArray = array();

		$i = 1;
		while($row =  mysqli_fetch_array($podcastQuery)) {

			array_push($songIdArray, $row['id']);

			$albumSong = new Song($con, $row['id']);
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

<div class="genresContainer borderBottom">
	<h2>Categorias</h2>

	<?php 
	$genreQuery = mysqli_query($con, "SELECT id FROM genres WHERE name LIKE '$term%'");

	if (mysqli_num_rows($genreQuery) == 0) {
		echo "<span class='noResults'>" . $term . " não foi uma categoria encontrada!</span>";
	}

	while ($row = mysqli_fetch_array($genreQuery)) {
		$genreFound = new Genre($con, $row['id']);

		echo "<div class='searchResultRow'>
					<div class='genreName'>
						<span onclick='openPage(\"typecategores.php?id=" . $genreFound->getId() . "\")'>
							<div class='typeCategoresFound'>" . $genreFound->getType() . "
						</span>
					</div>
				</div>";
	}
	?>
</div>

<div class="gridViewContainer">
	<h2>Apresentador</h2>
	<?php
		$artistQuery = mysqli_query($con, "SELECT albums.* FROM artists JOIN albums ON (albums.artist = artists.id) WHERE artists.name LIKE '$term%'");

		//
		//$artistQueryRow = mysqli_fetch_array($artistQuery);

		//$artistQuery = mysqli_query($con, "SELECT alm");


		//$artistAlbumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist ='$artistQuery['id']'");


		if (mysqli_num_rows($artistQuery) == 0) {
			echo "<span class='noResults'>" . $term . " não foi um apresentador encontrado!</span>";
		}


		while($row = mysqli_fetch_array($artistQuery)) {

			//var_dump($row);
			//exit;

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