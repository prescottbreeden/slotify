<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Slotify!</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900" rel="stylesheet">
	<link rel="stylesheet" href="public/css/styles.css">
	<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>	
	<script src="public/js/app.js"></script>
</head>
<body>
	<section class="player">
		<div class="player__play-bar">
			<div class="player__play-bar--album">
				<div class="album">
					<span class="album__link">
						<img 
							class="album__link--artwork"
							src="public/images/friends.jpg" 
							alt="album artwork">
					</span>
					<div class="album__info">
						<span class="album__info--track-name">
							<span>Rubber Baby Buggy Bumpers</span>
						</span>
						<span class="album__info--artist-name">
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
						<use xlink:href="public/images/icomoon/sprite.svg#icon-shuffle"></use>
					</svg>
					<svg 
						aria-label="[title]"
						class="controls__back">
						<title>Previous</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-previous2"></use>
					</svg>
					<svg 
						aria-label="[title]"
						class="controls__play">
						<title>Play</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-play2"></use>
					</svg>
					<svg 
						aria-label="[title]"
						class="controls__pause">
						<title>Pause</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-pause"></use>
					</svg>
					<svg 
						aria-label="[title]"
						class="controls__fwd">
						<title>Next</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-next2"></use>
					</svg>
					<svg 
						aria-label="[title]"
						class="controls__repeat">
						<title>Loop</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-loop"></use>
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
				volume
			</div>
		</div>
	</section>
</body>
</html>
