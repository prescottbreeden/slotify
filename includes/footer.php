
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
});

function setTrack(trackId, newPlaylist, play) {
	audioElement.setTrack("public/music/bensound-acousticbreeze.mp3");

	$.post("", {songId: trackId}, function(data) {
		
	});

	if(play) {
		audioElement.play();
	}
}

function playSong() {
	audioElement.play();
	$(".play").hide();
	$(".pause").show();
}

function pauseSong() {
	audioElement.pause();
	$(".play").show();
	$(".pause").hide();
}

</script>

		<section class="player">
			<div class="player__play-bar">
				<div class="player__play-bar--album">
					<div class="player__album">
						<span class="player__album__link">
							<img 
								class="player__album__link--artwork"
								src="public/images/friends.jpg" 
								alt="player__album artwork">
						</span>
						<div class="player__album__info">
							<span class="player__album__info--track">
								<span class="player__album__info--track-name">
									Rubber Baby Buggy Bumpers
								</span>
								<svg 
									aria-label="[title]"
									class="player__album__info--track-icon">
									<title>Add to Your Music</title>
									<use xlink:href="public/images/icomoon/sprite.svg#icon-plus"></use>
								</svg>
							</span>
							<span class="player__album__info--artist-name">
								<span>Chuck Norris</span>
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
								<div class="progress-bar__progress"></div>
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
									<div class="progress-bar__progress"></div>
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
