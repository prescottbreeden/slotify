// global audio variables
let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let repeat = false;
let shuffle = false;
// global UI variables
let mouseDown = false;
let menu_open = false;
let warning_msg = false;
let edit_pw = false;
let temp_songId;
// global user variables
let userLoggedIn;


// ====================================== //
//			General Functions			  //
// ====================================== //

function openPage(url) {
	if(url.indexOf("?") === -1) {
		url = url + "?";
	}
	var encodedURL = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$('.dynamic-content').load(encodedURL);
	$('body').scrollTop(0);
	history.pushState(null, null, url);
}

function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		location.reload();
	});
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

function jumpToPlaylist(playlistId) {
	openPage('playlist.php?id=' + playlistId);
	playFirstSong();
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
//			Edit Profile				  //
// ====================================== //

function updateEmail() {
	let emailValue = $('.userdetails__input[name="email"]').val();
	$.post("includes/handlers/ajax/updateEmail.php", 
		{ email: emailValue, username: userLoggedIn }) 
		.done(function(response) {
			notification(response);
		});
}

function checkOldPassword() {
	let oldPassword = $('.userdetails__input[name="oldPassword"]').val();
	
	$.post("includes/handlers/ajax/checkOldPassword.php", 
		{ oldPassword: oldPassword, username: userLoggedIn }) 
		.done(function(response) {
			notification(response);
			if(response == 'Success: enter a new password') {
				edit_pw = true;
				$('#new_pw').show();
			}
		});
}

function updatePassword() {
	let p1 = $('.userdetails__input[name="newPassword1"]').val();
	let p2 = $('.userdetails__input[name="newPassword2"]').val();
	let re = /[^A-Za-z0-9]/;

	if(p1 != p2) {
		notification("ERROR: passwords do not match");
		return;
	};

	if(p1.match(re)) {
		notification("ERROR: password must be alphanumeric");
		return;
	};

	if(p1.length > 30 || p1.length < 5) {
		notification("ERROR: password must be between 5 and 30 characters");
		return;
	};	

	if(edit_pw) {
		$.post("includes/handlers/ajax/updatePassword.php", 
			{ pw: p1, username: userLoggedIn }) 
			.done(function(response) {
				location.reload();
				edit_pw = false;
				$('#new_pw').hide();
				notification(response);
			});
	} else {
		notification("ERROR: please confirm your old password again");
	}
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
//				Saved Music				  //
// ====================================== //

function addAlbumToSaved(albumId) {
	console.log('saving album ' + albumId);
	$.post("includes/handlers/ajax/addAlbumToSaved.php", { albumId: albumId, username: userLoggedIn })
		.done(function(response) {
			notification(response)
			// do something when ajax returns
	});
}


function addSongToSaved(songId=temp_songId) {
	console.log('saving song ' + songId);
	// $.post("includes/handlers/ajax/saveSong.php", { song: songId, username: userLoggedIn })
	// 	.done(function(error) {
	// 		openPage("your_music.php");
	// 		// do something when ajax returns
	// });
}

function removeAlbumFromSaved(albumId) {
	console.log('removing song ' + albumId);
}

function removeSongFromSaved(songId=temp_songId) {
	console.log('removing song ' + songId);
}


// ====================================== //
//				Playlists				  //
// ====================================== //

function createPlaylist() {
	var popup = prompt("Please enter the name of your playlist");
	
	if(popup != null) {
		$.post("includes/handlers/ajax/createPlaylist.php", { pl_name: popup, username: userLoggedIn })
			.done(function(error) {
				openPage("your_music.php");
				// do something when ajax returns
		});

	}
}

function deletePlaylist(pl_id) {
	warning_msg = false;
	$.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: pl_id })
		.done(function(error) {
			openPage("your_music.php");
	});
}

function deleteWarning() {
	warning_msg = true;
	$('.warning').show();
	warning("Are you sure you want to delete this playlist?", true);
}

function deleteCancel() {
	warning_msg = false;
	$('.warning').hide();
}

function addSongToPlaylist(playlistId, songId) {
	$.post("includes/handlers/ajax/addToPlaylist.php", { playlist_id: playlistId, song_id: songId })
		.done(function() {
			// do something when ajax returns
			hideOptionsMenu();
			notification('Song successfully added to playlist');
	});
}

function removeFromPlaylist(playlistId) {
	$.post("includes/handlers/ajax/removeFromPlaylist.php", { playlist_id: playlistId, song_id: temp_songId })
		.done(function() {
			// do something when ajax returns
			hideOptionsMenu();
			openPage('playlist.php?id=' + playlistId);
			notification('Song successfully removed from playlist');
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
	// initial attempt at having a change in volume automatically remove mute
	if(audioElement.audio.muted) {
		// audioElement.audio.muted = !audioElement.audio.muted;
		console.log('click');
	}
}


// ====================================== //
//				EASTER EGGS				  //
// ====================================== //
let eggs = {
	"zelda": ["Beware of hand in walls", "Always go for the Eye", "It's not a candle, it's a flamethrower"],
	"streetfighter": "Hadoooouken!",
	"megaman": "Always jump through doorways",
	"contra": "&uarr; &uarr; &darr; &darr; &larr; &rarr; &larr; &rarr; B A [start]",
	"mario": "Headbutting bricks since 1985",
	"tetris": "Oh no, not another square..."
}

// ====================================== //
//			EVENT LISTENERS				  //
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
