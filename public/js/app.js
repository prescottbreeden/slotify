let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let repeat = false;
let shuffle = false;
let userLoggedIn;

$(document).click(function(click) {
	let target = $(click.target);
	if(!target.hasClass("options-menu__item") && !target.hasClass("options__button")) {
		hideOptionsMenu();
		console.log('hide');
	}
})

$(window).scroll(function() {
	hideOptionsMenu();
});

function openPage(url) {

	if(url.indexOf("?") === -1) {
		url = url + "?";
	}
	var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$('.dynamic-content').load(encodedURL);
	$('body').scrollTop(0);
	history.pushState(null, null, url);
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function hideOptionsMenu() {
	let menu = $('.options-menu');
	if(menu.css('display') != "none") {
		menu.css("display", "none");
	}
}

function showOptionsMenu(button) {
	let menu = $('.options-menu');
	let menuWidth = menu.width();
	let scrollTop = $(window).scrollTop(); //distance from top of window to document
	let elementOffset = $(button).offset().top; //distance from top of document

	let top = elementOffset - scrollTop;
	let left = $(button).position().left;

	menu.css({ "top": top + "px", "left": left-menuWidth + "px", "display": "inline" });
}

// ====================================== //
//				Playlists				  //
// ====================================== //

function createPlaylist() {
	var popup = prompt("Please enter the name of your playlist");
	
	if(popup != null) {
		
		$.post("includes/handlers/ajax/createPlaylist.php", { name: popup, user: userLoggedIn })
			.done(function(error) {
				if(error != '') {
					console.log(error);
					return;
				}
				else {
					// do something when ajax returns
					openPage("yourMusic.php");
				}
		});
	}
}

function deletePlaylist(playlistId) {
	var popup = confirm("Are you sure you want to delete this playlist?");
	if(popup) {
		console.log('deleting playlist now... what did you do?!');

		$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
			.done(function(error) {
				if(error != '') {
					console.log(error);
					return;
				}
				else {
					// do something when ajax returns
					openPage("yourMusic.php");
				}
		});
	}
}

function sharePlaylist(playlistId) {
	console.log('generating playlist link');
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


// ====================================== //
//				PLAYER BAR				  //
// ====================================== //

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
	});

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	});

});
