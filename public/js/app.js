let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let repeat = false;
let shuffle = false;
let userLoggedIn;

function openPage(url) {

	if(url.indexOf("?") === -1) {
		url = url + "?";
	}
	var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$('.dynamic-content').load(encodedURL);
}


// ====================================== //
//				AUDIO CLASS				  //
// ====================================== //
function Audio() {
	
	this.currentlyPlaying;
	this.audio = document.createElement('audio');

	// ------ AUDIO EVENT LISTENERS ------ //
	this.audio.addEventListener('ended', function() {
		nextSong();	
	})

	this.audio.addEventListener("canplay", function() {
		var duration = formatTime(this.duration);
		$('.progress-bar__time.progress-bar__time--remaining').text(duration);
	});

	this.audio.addEventListener('timeupdate', function() {
		if(this.duration) {
			updateTimeProgressBar(this);
		}
	});

	this.audio.addEventListener('volumechange', function() {
		updateVolumeProgressBar(this);
	});

	// ------ AUDIO FUNCTIONS ------ //
	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.song_path;
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

function formatTime(seconds) {
	var time = Math.round(seconds);
	var minutes = Math.floor(time/60);
	var seconds = time - minutes * 60;
	var extraZero = (seconds < 10) ? "0" : "";

	return minutes + ':' + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
	$('.progress-bar__time.progress-bar__time--current').
		text(formatTime(audio.currentTime));
	$('.progress-bar__time.progress-bar__time--remaining').
		text(formatTime(audio.duration - audio.currentTime));

	var progress = audio.currentTime / audio.duration * 100;
	$('#song_progress').css('width', progress + "%");
}

function updateVolumeProgressBar(audio) {
	var volume = audio.volume * 100;
	$('#volume_bar').css('width', volume + "%");
}

// register.php behavior
$(document).ready(function() {
	console.log('power overwhelming...');

	$('#hideLogin').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	})

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	})


})
