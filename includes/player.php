<?php 
$songQuery = mysqli_query($con, "SELECT song_id FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['song_id']);
}

$jsonArray = json_encode($resultArray);

?>

<script>
// ============================================= //
//			JAVASCRIPT FOR PLAYER BAR			 //
// ============================================= //

$(document).ready(function() {
	newPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
	var spacebar = false;
	currentIndex = 0;
	setTrack(newPlaylist[currentIndex], newPlaylist, false);
	updateVolumeProgressBar(audioElement.audio);

	// ============================================= //
	//				KEYBOARD EVENTS					 //
	// ============================================= //

	// space-bar pause/play
	$(document).keydown(function(e) {
		if(e.which === 32 && e.target == document.body) {
			spacebar = !spacebar;
			if(spacebar) {
				audioElement.audio.pause();
			}
			else {
				audioElement.audio.play();
			}
			return false;
		}
	});

	// right arrow to go to next track
	$(document).keydown(function(e) {
		if(e.which === 39 && e.target == document.body) {
			nextSong();

			return false;
		}
	});

	// right arrow to go to next track
	$(document).keydown(function(e) {
		if(e.which === 37 && e.target == document.body) {
			prevSong();

			return false;
		}
	});

	// ============================================= //
	//					MOUSE EVENTS				 //
	// ============================================= //

	$('.player').on('mousedown touchstart mousemove touchmove', function(e) {
		e.preventDefault();
	});

	$('.player__play-bar--progress-bar .progress-bar').mousedown(function() {
		mouseDown = true;
	});

	$('.player__play-bar--progress-bar .progress-bar').mousemove(function(e) {
		if(mouseDown) {
			timeFromOffset(e, this);
		}
	});

	$('.player__play-bar--progress-bar .progress-bar').mouseup(function(e) {
		timeFromOffset(e, this);
	});

	$('.volume__bar .progress-bar').mousedown(function() {
		mouseDown = true;
	});

	$('.volume__bar .progress-bar').mousemove(function(e) {
		if(mouseDown) {
			var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <=1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$('.volume__bar .progress-bar').mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();
			if(percentage >= 0 && percentage <=1) {
				audioElement.audio.volume = percentage;
			}
	});

	$(document).mouseup(function() {
		mouseDown = false;
	});
});

// ============================================= //
//					FUNCTIONS					 //
// ============================================= //

function setTrack(trackId, playlist, play) {

	if(playlist != currentPlaylist) {
		currentPlaylist = playlist;

		shufflePlaylist = currentPlaylist.slice();
		shuffle_list(shufflePlaylist);
	}

	pauseSong();

	// get song
	$.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
		var track = JSON.parse(data);
		$('#now_playing_song').text(track.title_name);
		$('#now_playing_song').attr('onclick', "openPage('album.php?id=" + track.album_id + "')");

		// get artist
		$.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist_id}, function(data) {
			var artist = JSON.parse(data);
			$('#now_playing_artist').text(artist.name);
			$('#now_playing_artist').attr('onclick', "openPage('artist.php?id=" + track.artist_id + "')");
		});	
		
		// get album
		$.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album_id}, function(data) {
			var album = JSON.parse(data);
			$('#now_playing_artwork').attr('src', album.artwork_path);
			$('#now_playing_artwork').attr('onclick', "openPage('album.php?id=" + track.album_id + "')");
		});	

		audioElement.setTrack(track);
		track_saved();

		if(play) {
			playSong();
		}
	});

}

function setShuffle() {
	shuffle = !shuffle;

	if(shuffle) {
		$('.controls__shuffle').addClass('button-active');
		shuffle_list(shufflePlaylist);
		currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.song_id);
	}
	else {
		$('.controls__shuffle').removeClass('button-active');
		currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.song_id);
	}
}

function prevSong() {

	if(audioElement.audio.currentTime >= 5) {
		audioElement.setTime(0);
	} 
	else if (currentIndex === 0) {
		currentIndex = currentPlaylist.length - 1;
	} 
	else {
		currentIndex--;
	}

	setTrack(currentPlaylist[currentIndex], currentPlaylist, true);

}

function playSong() {
	if(audioElement.audio.currentTime === 0) {
		$.post('includes/handlers/ajax/updatePlays.php', {songId: audioElement.currentlyPlaying.song_id });
	}
	$(".play").hide();
	$(".pause").show();
	audioElement.play();
}

function pauseSong() {
	$(".play").show();
	$(".pause").hide();
	audioElement.pause();
}

function nextSong() {
	if(repeat === true) {
		audioElement.setTime(0);
		playSong();
		return;
	}

	if(currentIndex === currentPlaylist.length - 1) {
		currentIndex = 0;
	} else {
		currentIndex++;
	}
	let trackToPlay;

	if(shuffle) {
		trackToPlay = shufflePlaylist[currentIndex];
	}
	else {
		trackToPlay = currentPlaylist[currentIndex];
	}

	setTrack(trackToPlay, currentPlaylist, true);
}

function setRepeat() {
	repeat = !repeat;

	if(repeat) {
		$('.controls__repeat').addClass('button-active');
	}
	else {
		$('.controls__repeat').removeClass('button-active');
	}
}

function setMute() {
	audioElement.audio.muted = !audioElement.audio.muted;

	if(audioElement.audio.muted) {
		$('#volume_icon').attr('href', 'public/images/icomoon/sprite.svg#icon-volume-mute')
	}
	else {
		$('#volume_icon').attr('href', 'public/images/icomoon/sprite.svg#icon-volume-medium')
	}
}

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $('.player__play-bar--progress-bar .progress-bar').width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

// Fisher-Yates Shuffle
function shuffle_list(a) {
    var j, x, i;
    for (i = a.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        x = a[i];
        a[i] = a[j];
        a[j] = x;
    }
}

</script>

<!-- =============================  -->
<!--	PLAYER HTML STARTS HERE		-->
<!-- =============================  -->

			</div>
		</div>
		<section class="player">
			<div class="player__play-bar">
				<div class="player__play-bar--album">
					<div class="player__album">
						<span 
							role="link"
							tabindex="0"
							class="player__album__link">
							<img 
								id="now_playing_artwork"
								class="player__album__link--artwork"
								src="" 
								alt="album artwork">
						</span>
						<div class="player__album__info">
							<span class="player__album__info--track">
								<span 
									role="link"
									tabindex="0"
									id="now_playing_song"
									class="player__album__info--track-name">
								</span>
								<svg 
									onclick="saveCurrentlyPlaying()"
									aria-label="[title]"
									class="player__album__info--track-icon not-saved">
									<title>Add to Your Music</title>
									<use href="public/images/icomoon/sprite.svg#icon-plus"></use>
								</svg>
								<svg 
									onclick="deleteCurrentlyPlaying()"
									aria-label="[title]"
									class="player__album__info--track-icon saved">
									<title>Remove from Your Music</title>
									<use href="public/images/icomoon/sprite.svg#icon-checkmark"></use>
								</svg>
							</span>
							<span 
								id="now_playing_artist"
								class="player__album__info--artist-name">
								<span role="link" tabindex="0"></span>
							</span>
						</div>
					</div>
				</div>
				<div class="player__play-bar--controls">
					<div class="controls">
						<svg 
							aria-label="[title]"
							onclick="setShuffle()"
							class="controls__shuffle">
							<title>Shuffle</title>
							<use href="public/images/icomoon/sprite.svg#icon-random"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="prevSong()"
							class="controls__back">
							<title>Previous</title>
							<use href="public/images/icomoon/sprite.svg#icon-step-backward"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="playSong()"
							class="controls__play play">
							<title>Play</title>
							<use href="public/images/icomoon/sprite.svg#icon-play2"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="pauseSong()"
							class="controls__pause pause">
							<title>Pause</title>
							<use href="public/images/icomoon/sprite.svg#icon-pause2"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="nextSong()"
							class="controls__fwd">
							<title>Next</title>
							<use href="public/images/icomoon/sprite.svg#icon-step-forward"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="setRepeat()"
							class="controls__repeat">
							<title>Loop</title>
							<use href="public/images/icomoon/sprite.svg#icon-repeat"></use>
						</svg>
					</div>
					<div class="player__play-bar--progress-bar">
						<span class="progress-bar__time progress-bar__time--current">0.00</span>
						<div class="progress-bar">
							<div class="progress-bar__bg">
								<div id="song_progress" class="progress-bar__progress">
									<div class="progress-bar__progress--dot u-nudge-right"></div>
								</div>
							</div>
						</div>
						<span class="progress-bar__time progress-bar__time--remaining">0.00</span>
					</div>
				</div>
				<div class="player__play-bar--volume">
					<div class="volume">
						<div class="volume__bar">
							<svg 
								onclick="setMute()"
								aria-label="[title]"
								class="volume__bar--icon">
								<title>Toggle Mute</title>
								<use 
									id="volume_icon"
									href="public/images/icomoon/sprite.svg#icon-volume-medium"></use>
							</svg>
							<div class="progress-bar">
								<div class="progress-bar__bg">
									<div id="volume_bar" class="progress-bar__progress">
										<div class="progress-bar__progress--dot"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</body>
</html>
