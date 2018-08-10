
			</div>
		</div>

<?php 
$songQuery = mysqli_query($con, "SELECT song_id FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['song_id']);
}

$jsonArray = json_encode($resultArray);

?>
<script>
$(document).ready(function() {
	currentPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
	setTrack(currentPlaylist[0], currentPlaylist, false);
	updateVolumeProgressBar(audioElement.audio);

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

function timeFromOffset(mouse, progressBar) {
	var percentage = mouse.offsetX / $('.player__play-bar--progress-bar .progress-bar').width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function setTrack(trackId, newPlaylist, play) {

	$.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
		var track = JSON.parse(data);
		$('#now_playing_song').text(track.title_name);

		$.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist_id}, function(data) {
			var artist = JSON.parse(data);
			$('#now_playing_artist').text(artist.name)
		});	

		$.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album_id}, function(data) {
			var album = JSON.parse(data);
			$('#now_playing_artwork').attr('src', album.artwork_path);
		});	

		audioElement.setTrack(track);
		playSong();
	});

	if(play) {
		audioElement.play();
	}
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

</script>

		<section class="player">
			<div class="player__play-bar">
				<div class="player__play-bar--album">
					<div class="player__album">
						<span class="player__album__link">
							<img 
								id="now_playing_artwork"
								class="player__album__link--artwork"
								src="" 
								alt="album artwork">
						</span>
						<div class="player__album__info">
							<span class="player__album__info--track">
								<span 
									id="now_playing_song"
									class="player__album__info--track-name">
								</span>
								<svg 
									aria-label="[title]"
									class="player__album__info--track-icon">
									<title>Add to Your Music</title>
									<use xlink:href="public/images/icomoon/sprite.svg#icon-plus"></use>
								</svg>
							</span>
							<span 
								id="now_playing_artist"
								class="player__album__info--artist-name">
								<span></span>
							</span>
						</div>
					</div>
				</div>
				<div class="player__play-bar--controls">
					<div class="controls">
						<svg 
							aria-label="[title]"
							class="controls__shuffle">
							<title>Shuffle</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-random"></use>
						</svg>
						<svg 
							aria-label="[title]"
							class="controls__back">
							<title>Previous</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-step-backward"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="playSong()"
							class="controls__play play">
							<title>Play</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-play2"></use>
						</svg>
						<svg 
							aria-label="[title]"
							onclick="pauseSong()"
							class="controls__pause pause">
							<title>Pause</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-pause2"></use>
						</svg>
						<svg 
							aria-label="[title]"
							class="controls__fwd">
							<title>Next</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-step-forward"></use>
						</svg>
						<svg 
							aria-label="[title]"
							class="controls__repeat">
							<title>Loop</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-repeat"></use>
						</svg>
					</div>
					<div class="player__play-bar--progress-bar">
						<span class="progress-bar__time progress-bar__time--current">0.00</span>
						<div class="progress-bar">
							<div class="progress-bar__bg">
								<div id="song_progress" class="progress-bar__progress"></div>
							</div>
						</div>
						<span class="progress-bar__time progress-bar__time--remaining">0.00</span>
					</div>
				</div>
				<div class="player__play-bar--volume">
					<div class="volume">
						<div class="volume__bar">
							<svg 
								aria-label="[title]"
								class="volume__bar--icon">
								<title>Mute</title>
								<use xlink:href="public/images/icomoon/sprite.svg#icon-volume-medium"></use>
							</svg>
							<div class="progress-bar">
								<div class="progress-bar__bg">
									<div id="volume_bar" class="progress-bar__progress"></div>
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
