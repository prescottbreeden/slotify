var currentPlaylist =[];
var audioElement;

function Audio() {
	
	this.currentlyPlaying;
	this.audio = document.createElement('audio');

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

}

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
