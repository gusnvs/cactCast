<?php

// vamos criar uma playlist
$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}

// agora vamos converter o $resultArray que é um php para um JS
	// vamos usar o JSON

$jsonArray = json_encode($resultArray);
?>

<script>

$(document).ready(function() {
	var newPlaylist = <?php echo $jsonArray; ?>; // lembrando que é um array de ids
	// temos uma playlist agora convertida em json, onde ele busca o id dos podcasts
	//console.log(newPlaylist);
	audioElement = new Audio();
	setTrack(newPlaylist[0], newPlaylist, false); // o falso é por que isso acontece quando a página é recarregada, e então não queremos que execute um podcast logo de cara, nós só queremos definir a lista visualmente, e só toque se for clicado
	updateVolumeProgressBar(audioElement.audio); // para o volume já começar no máximo


	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
		e.preventDefault();
	});


	$(".playbackBar .progressBar").mousedown(function() { // quando o mouse é pressionado, então faça
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(e) { // quando o mouse for movido faça, e vamos passar no objeto de click do mouse
		if(mouseDown == true) {
			// vamos definir o tempo do podcast dependendo da posição do mouse
			timeFromOffset(e, this);  // o this é o ".playbackBar . progressBar"
		}
	});

	$(".playbackBar .progressBar").mouseup(function(e) {
		timeFromOffset(e, this);
	});



	//------------------



	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {

			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	});



	//------------------


	$(document).mouseup(function() {
		mouseDown = false;
	});




});

function timeFromOffset(mouse, progressBar) {// uma função que saiba o deslocamento de acordo com a porcentagem da barra, e calcular o tempo usando offset
	var percentage = mouse.offsetX / $(progressBar).width() * 100;
	// o X é o caminho da horizontal, eixo X
		// o $(this) é um objeto jquery que está usando o elemento HTML ".playbackBar . progressBar"      o *100 é para sabermos a porcentagem
	var seconds = audioElement.audio.duration * (percentage / 100);
	// ele está pegando a porcentagem e está dividindo pelo numero de segundos
	// ex, se for 50%, está definindo o numero de segundos para ser 50 % da duração total
	audioElement.setTime(seconds);
}

function prevSong() {
	if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	}
	else {
		currentIndex = currentIndex - 1;
		setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
	}
}

function nextSong() {
	if(repeat == true) {
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex == currentPlaylist.length - 1) {
		currentIndex = 0;
	}
	else {
		currentIndex++;
	}

	var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
	repeat = !repeat;
	var imageName = repeat ? "repeat-active.png" : "repeat.png";
	$(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
	$(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

function setShuffle() {
	shuffle = !shuffle;
	var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
	$(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

	if(shuffle == true) {
		//Randomize playlist
		shuffleArray(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
	}
	else {
		//shuffle has been deactivated
		//go back to regular playlist
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
	}

}

function shuffleArray(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
}

// vamos criar uma função publica para setTrack
function setTrack(trackId, newPlaylist, play) {

	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
		shufflePlaylist = currentPlaylist.slice();
		shuffleArray(shufflePlaylist);
	}

	if(shuffle == true) {
		currentIndex = shufflePlaylist.indexOf(trackId);
	}
	else {
		currentIndex = currentPlaylist.indexOf(trackId);
	}
	pauseSong();


	// essa função basicamente vai fazer com que caso eu queria dar play em um podcast de algum canal, ele deve manter a playlist em ordem desse canal
	// se eu apenas acessar outro canal mas nao der play em algum podcast, ele deve continuar com a playlist anterior, que já esté em reprodução e seguir a ordem de podcasts daquele canal
	// apenas quando eu clicar em play de algum podcast de um novo canal, que ele deverá resetar a playlist que está tocando para que seja reajustada uma nova, e que depois haja continuidade em ordem da playlist com os podcasts desse novo canal

	//audioElement.setTrack("assets/music/bensound-acousticbreeze.mp3"); ---> teste

	// vamos usar a ideia de faixa que foi passada como parâmetro e utilizar o ajax
	// vamos recuperar os podcast do banco dae dados pelo id

	$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {// os dados que são retornados do ajax

		var track = JSON.parse(data);// vamos converter para um objeto os dados que foram passados do ajax
		$(".trackName span").text(track.title);

		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
			var artist = JSON.parse(data);
			$(".artistName span").text(artist.name);
		});

		$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
			var album = JSON.parse(data);
			$(".albumLink img").attr("src", album.artworkPath);
		});

		audioElement.setTrack(track);

		// eu pûs dentro do $.post por que antes, quando estava fora, ele não reproduzia o podcat automaticamente quando pressionado no botão play
		if(play == true) {
			// mas agora o botão play não atualiza quando dou o play (ERRO)
			playSong(); // FUNCIONOU
		}
	});
}

// agora vamos para a barra de reprodução com funçoes que utilizamos
function playSong() {

	if(audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
	}

	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

function pauseSong() {
	$(".controlButton.play").show();
	$(".controlButton.pause").hide();
	audioElement.pause();
}

</script>


<div id="nowPlayingBarContainer">

	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img src="" class="albumArtwork">
				</span>

				<div class="trackInfo">

					<span class="trackName">
						<span></span>
					</span>

					<span class="artistName">
						<span></span>
					</span>

				</div>



			</div>
		</div>

		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">

					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button" onclick="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>

				</div>


				<div class="playbackBar">

					<span class="progressTime current">0.00</span>

					<div class="progressBar">
						<div class="progressBarBg">
							<div class="progress"></div>
						</div>
					</div>

					<span class="progressTime remaining">0.00</span>


				</div>


			</div>


		</div>

		<div id="nowPlayingRight">
			<div class="volumeBar">

				<button class="controlButton volume" title="Volume button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>

			</div>
		</div>




	</div>

</div>