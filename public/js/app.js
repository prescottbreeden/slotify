let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let mouseDown = false;
let repeat = false;
let shuffle = false;
let userLoggedIn;
let temp_songId;
let menu_open = false;
let warning_msg = false;

$(document).click(function(click) {
	let target = $(click.target);
	if(menu_open) {
		if(!target.hasClass("menu-item") && !target.hasClass("options__button")) {
			hideOptionsMenu();
		}
	} 
	else if(warning_msg) {
		if(!target.is("#warning_cancel") && !target.is("#warning_confirm")) {
			shake();
		}
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
	console.log(encodedURL);
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function notification(msg) {
	$('.msg-box').show();
	$('.msg-box__btns').hide();
	$('.msg-box__text').text(msg);
	$('.msg-box').css({'color': 'green'});
	$('.msg-box').css({"opacity": "1"});
	setTimeout(function() {
		msgBoxHide($('.msg-box'));
	}, 3000);
}

function warning(msg) {
	$('.warning__text').text(msg);
	$('.warning').css({'color': 'red'});
	$('.warning').css({"opacity": "1"});
	$('.warning__btns').show();
}

function msgBoxHide(box) {
	box.css('opacity', '0');
	setTimeout(() => {
		box.hide();
	}, 1000);

}

function shake() {
	$('.msg-box').addClass('shake');
	setTimeout(function() {
		$('.msg-box').removeClass('shake');
	}, 1000);
}

// ====================================== //
//			DropDown Menus				  //
// ====================================== //

function hideOptionsMenu() {
	let dropDownMenu = $('.dropdown-menu');
	let optionsMenu = $('.options-menu');
	let playlistMenu = $('.playlists-menu');
	let shareMenu = $('.share-menu');
	if(dropDownMenu.css('display') != "none") {
		dropDownMenu.css("display", "none");
		optionsMenu.css("display", "none");
		playlistMenu.css("display", "none");
		shareMenu.css("display", "none");
	}
	menu_open = false;
}

function showOptionsMenu(button) {
	let dropDownMenu = $('.dropdown-menu');
	let optionsMenu = $('.options-menu');
	let playlistsMenu = $('.playlists-menu');
	let menuWidth = optionsMenu.width();
	let scrollTop = $(window).scrollTop(); //distance from top of window to document
	let elementOffset = $(button).offset().top; //distance from top of document

	let top = elementOffset - scrollTop;
	let left = $(button).position().left;

	dropDownMenu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline-block" });
	optionsMenu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline-block" });

	let songId = $(button).prevAll(".songId").val();
	temp_songId = songId;	

	menu_open = true;
}

function showPlaylistsMenu(ele) {
	let playlistsMenu = $('.playlists-menu');
	let menuWidth = playlistsMenu.width();

	let scrollTop = $(window).scrollTop(); //distance from top of window to document
	let elementOffset = $('#open_playlists_menu').offset().top; //distance from top of document

	let top = elementOffset - scrollTop;
	let left = $(ele).offset().left;

	playlistsMenu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline-block" });
}

function showShareMenu(ele) {
	let shareMenu = $('.share-menu');
	let menuWidth = shareMenu.width();
	let scrollTop = $(window).scrollTop(); //distance from top of window to document
	let elementOffset = $('#open_share_menu').offset().top; //distance from top of document

	let top = elementOffset - scrollTop;
	let left = $(ele).offset().left;

	shareMenu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline-block" });
}


// ====================================== //
//				Playlists				  //
// ====================================== //

function createPlaylist() {
	var popup = prompt("Please enter the name of your playlist");
	
	if(popup != '') {
		
		$.post("includes/handlers/ajax/createPlaylist.php", { pl_name: popup, username: userLoggedIn })
			.done(function(error) {
				console.log(error);
				openPage("your_music.php");
				// do something when ajax returns
		});
	}
}

function deleteWarning() {
	warning_msg = true;
	warning("Are you sure you want to delete this playlist?", true);
}

function deleteCancel() {
	warning_msg = false;
}

function deletePlaylist(pl_id) {
	warning_msg = false;
	$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: pl_id })
		.done(function(error) {
			console.log(error);
			openPage("your_music.php");
	});
}

function addSongToPlaylist(playlistId, songId) {
	$.post("includes/handlers/ajax/addToPlaylist.php", { playlist_id: playlistId, song_id: songId })
		.done(function() {
			// do something when ajax returns
			hideOptionsMenu();
			notification('Song successfully added to playlist');
	});
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

// ====================================== //
//			DOCUMENT READY				  //
// ====================================== //


$(document).ready(function() {
	console.log('power overwhelming...');

	// register.php behavior
	$('#hideLogin').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	});

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	});

	// show additional option menus
	$(document).on('mouseenter', '#open_playlists_menu', function() {
		showPlaylistsMenu($(this));
		$('.share-menu').hide();
	}); 

	$(document).on('mouseenter', '#open_share_menu', function() {
		showShareMenu($(this));
		$('.playlists-menu').hide();
	}); 

	$(document).on('click', '.playlist-item', function() {
		let playlistId = $(this).prevAll(".playlistId").val();
		addSongToPlaylist(playlistId, temp_songId);
	});

	$(document).on('click', '.msg-box', function() {
		if(!warning_msg) {
			msgBoxHide($(this));
		}
	});


});
