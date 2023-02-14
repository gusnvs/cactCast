var currentPlaylist = [];// temos uma variável de lugar atual que no momento está vazia
var shufflePlaylist = []; // a playlist aleatória
var tempPlaylist = [];
var audioElement; // o elemento de audio
var mouseDown = false; // quero dizer que eles não está sendo pressionado 
var currentIndex = 0; // indice do podcast autal para podemos passar para o próximo
var repeat = false;
var shuffle = false; 
var userLoggedIn;


$(document).click(function(click){
	var target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionsButton")){ // isso faz com que, se eu clicar em alguma coisa, que não pertence a classe optionsmenu ou item então
		//console.log("entra aqui");
		hideOptionMenu();
	}
})

$(window).scroll(function() { // se a tela for rolada pelo scroll executar a função de desaparecer a nab, opções
	hideOptionMenu();
});

$(document).on("change", "select.playlist", function(){ // quando a seleção for alterada, faremos a mudança
	var playlistId = $(this).val(); // o this contem o item q foi selecionado
	var songId = $(this).prev(".songId").val();

	console.log("playlistId: " + playlistId);
	console.log("songId: " + songId);

	$.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId: songId}).done(function(error){

		if (error!= "") {
			alert(error);
			return;
		}

		hideOptionMenu();
		$(this).val("");
	});
});


function removeFromPlaylistNow(button, playlistId) { // o button vai ser para quando o botão options for pressionado da pagina de playlist
	var songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId}).done(function(error){
		//console.log("entra aqui deletar da playlist");
		openPage("pagePlaylist.php?id=" + playlistId);
		//document.location.reload(true);
	});

}

function openPage(url) {
	// eu vou codificar a URL
	// ele subsitui na url todos os caracteres para um caractere equivalente para ficar do jeito certo

	if(url.indexOf("?") == -1) { // se na URL não tiver o ?, eu preciso colocar, pois depois dele que vem o id
		url = url + "?";
	}

	// esta variável vai condificar a url, vai ler traduzir e converter os caracteres para que não são "reconhecidos" por alguma que ele reconheça
	var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	// depois vamos dizer que o conteúdo apenas será carregado pela url
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0); // criamos um objeto Jquery em torno do body
	history.pushState(null, null, url); // com isso apagamos o histórico de url que fica, pois quando temos o primeiro acesso, a url com determinado id fica congelado na url, e mesmo atualizando ele não muda
	// então ele reseta a url
}

function playFirstPodcast() {
	// esta função é para quando clicamos no play na página de uma categoria para executar os podcast de um gênero
	setTrack(tempPlaylist[0], tempPlaylist, true);
	// isso funciona por que se eu for na classe typecategores.php, foi criado um script que contem um já a playlist que foi gerada no foreach
	//então após o fim do foreach, foi gerado uma nova playlist temporária aonde foram adcionados os podcasts que possuem aquele determinado ID
}

function creatPlaylist() {
	var namePlaylist = prompt("Digite o nome da sua nova playlist!");

	if (namePlaylist!= "" || namePlaylist!= "null") {
		//console.log(namePlaylist);
		// vamos precisar usar AJAX pois como estamos no JS não conseguimos executar SQL a partir daqui
		$.post("includes/handlers/ajax/creatPlaylist.php", {name: namePlaylist, username: userLoggedIn}).done(function(error){
			if (error!= "") {
				alert(error);
				return;
			}
			// o "" vamos especificar o nome do arquivo para o qual queremos enviar a solicitação AJAX
			// usando o .done, o código será execultado quando a chamada AJAX for feita, e dentro dos () está o código a ser executado
			// e o .done é a melhor maneira de executar as respostas do AJAX
			//console.log("Deletado. entra aqui 2");
			document.location.reload(true);
			//Location.reload();
			//openPage('youPodcast.php');

		});
	}
}

function deletePlaylist(playlistId) {
	var prompt = confirm("Tem certeza que gostaria de excluir esta playlist?");

	if(prompt == true) {

		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
		.done(function(error) {

			if(error != "") {
				alert(error);
				return;
			}

			//openPage("yourPodcast.php?");
		});
	}
}

function showOptionMenu(button) {
	var songId = $(button).prevAll(".songId").val();

	var menu = $(".optionsMenu"); // com essa variável eu estou recuperando o css optionMenu para q eu faça modificação
	var menuWidth = menu.width();

	menu.find(".songId").val(songId);

	var scrollTop = $(window).scrollTop(); // essa variável vai me retornar o tamanho, do lugar que eu estou da tela, a rolagem da tela, até o topo real do documento
	var elementOffSet = $(button).offset().top; // essa variável vai pegar a posição que está o botão, no caso a imagem que estamos passando no parametro da função, nesse caso, da parte superior
	var top = elementOffSet - scrollTop; // com isso calculamos o lugar/posição nova do nav que queremos atribuir ao botão
	var left = $(button).position().left; // essa a distancia do lado esquerdo da página

	menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline"});
}


function hideOptionMenu() {
	var menu = $(".optionsMenu");

	if (menu.css("display") != "none") {
		menu.css("display", "none");
	}
}

function logout() {
	$.post("includes/handlers/ajax/logout.php", function(){
		location.reload();
	});
}


function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time / 60); 
	var seconds = time - (minutes * 60);

	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$(".progressTime.current").text(formatTime(audio.currentTime));
	$(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	// será o tempo atual, o número de segundos atualmente dividido pela duração da queda vezes 100, com isso calculamos a porcentagem do tempo real
	$(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$(".volumeBar .progress").css("width", volume + "%");
}

function Audio() {

	// é a própria classe

	this.currentlyPlaying;
	this.audio = document.createElement('audio'); // criamos uma variável, um objeto do tipo audio

	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("canplay", function() {
		var duration = formatTime(this.duration); 
		$(".progressTime.remaining").text(duration);// o this duration refere-se ao objeto que o evento foi chamado, o elemento audio
		// a mesma coisa que seria this.audio.duration
	});

	this.audio.addEventListener("timeupdate", function(){
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener("volumechange", function() {
		updateVolumeProgressBar(this);
	});

	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
		// a propriedade source do audio, nessa função set irá receber o src que é passado como parâmetro da função
		// mudei para um objeto json o track
	}

	this.play = function() {
		this.audio.play();
	}

	this.pause = function() {
		this.audio.pause();
	}

	this.setTime = function(seconds) {
		this.audio.currentTime = seconds;
	}

}