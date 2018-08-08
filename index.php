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

	<div class="content-wrapper">
		<div class="content">
			<nav class="nav">
				<div class="nav-bar">
					<a class="nav-bar__logo" href="index.php">
						<svg id="svg_logo" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1280 435" style="enable-background:new 0 0 1280 435;" xml:space="preserve">
							<g id="text">
								<path d="M394.6,218.9l33.6,43c14.6,17.8,20.1,33.6,13,75c-6.7,37.5-23.7,58-71.1,58c-47.4,0-57.2-20.5-50.5-58l6.7-37.5
									c1.2-5.5,4.3-8.7,9.9-8.7h16.2c5.5,0,7.9,3.2,6.7,8.7l-6.3,37.5c-3.6,19-0.4,30.4,22.1,30.4s30-11.4,33.2-30.4
									c4.7-25.3,3.9-36.7-11.1-56.1l-33.6-42.6c-14.6-17.8-20.1-33.6-13-75c6.7-37.5,23.3-58,70.7-58c47.4,0,57.2,20.5,50.5,58
									l-6.3,37.5c-1.2,5.5-4.7,8.3-10.3,8.3h-15.8c-5.5,0-7.9-2.8-7.1-8.3l6.7-37.5c3.6-19,0-30.4-22.5-30.4s-29.6,11.4-33.2,30.4
									C378.5,188.9,379.6,200,394.6,218.9z"/>
								<path d="M499.7,365.4h65.1c5.5,0,7.9,2.8,7.1,8.3l-2,10.7c-1.2,5.5-4.3,8.7-9.9,8.7h-89.2c-5.5,0-8.3-3.2-7.5-8.7l47.8-268.9
									c0.8-5.5,4.3-8.3,9.9-8.3h15.8c5.5,0,7.9,2.8,7.1,8.3L499.7,365.4z"/>
								<path d="M748.4,163.2L717.6,337c-6.7,37.5-23.3,58-70.7,58c-47.4,0-57.2-20.5-50.5-58l30.4-173.7c6.7-37.5,23.7-58,71.1-58
									C745.2,105.2,755.1,125.7,748.4,163.2z M659.9,163.2L629.1,337c-3.2,19-0.4,30.4,22.1,30.4s30-11.4,33.6-30.4l30.4-173.7
									c3.6-19,0-30.4-22.5-30.4S663.5,144.3,659.9,163.2z"/>
								<path d="M855.8,134.8l-43.8,249.5c-1.2,5.5-4.3,8.7-9.9,8.7h-15.8c-5.5,0-8.3-3.2-7.5-8.7L823,134.8h-45.4c-5.5,0-7.9-3.2-6.7-8.7
									l2-10.7c0.8-5.5,4.3-8.3,9.9-8.3h123.2c5.5,0,7.9,2.8,7.1,8.3l-2,10.7c-0.8,5.5-4.3,8.7-9.9,8.7H855.8z"/>  
								<path d="M914.6,384.3c-1.2,5.5-4.3,8.7-9.9,8.7h-15.8c-5.5,0-8.3-3.2-7.5-8.7l47.8-268.9c0.8-5.5,4.3-8.3,9.9-8.3h15.8
									c5.5,0,7.9,2.8,7.1,8.3L914.6,384.3z"/>
								<path d="M1093,107.2c5.5,0,7.9,2.8,7.1,8.3l-2,10.7c-0.8,5.5-4.3,8.7-9.9,8.7h-65.1l-17.8,101.5h49.7c5.5,0,8.3,2.8,7.5,8.3
									l-2,10.7c-1.2,5.5-4.7,8.7-10.3,8.7h-50.1l-20.9,120.4c-1.2,5.5-4.3,8.7-9.9,8.7h-15.8c-5.5,0-8.3-3.2-7.5-8.7l47.8-268.9
									c0.8-5.5,4.3-8.3,9.9-8.3H1093z"/>
								<path d="M1131.3,107.2c3.9,0,7.1,2,7.5,5.9l7.9,67.5l4.3,58.4h2.4l24.5-58.4l32-67.5c2-3.9,5.9-5.9,9.9-5.9h17.8
									c5.9,0,7.9,5.1,5.1,10.7l-80.5,163.8l-18.2,102.6c-0.8,5.5-3.9,8.7-9.5,8.7h-16.2c-5.5,0-8.3-3.2-7.1-8.7l18.2-102.6l-22.9-163.8
									c-0.8-5.5,3.2-10.7,9.1-10.7H1131.3z"/>
							</g>
							<g id="bars">
									<path d="M37.5,407c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6V127.1c0-0.9-0.7-1.6-1.6-1.6c-0.9,0-1.6,0.7-1.6,1.6V407z"/>
									<path d="M91.4,402.5c0,0.4,0.3,0.8,0.8,0.8c0.4,0,0.8-0.3,0.8-0.8V203.8c0-0.4-0.3-0.8-0.8-0.8c-0.4,0-0.8,0.3-0.8,0.8V402.5z"/>
								<path d="M147.5,404.3c0,0.9,0.7,1.6,1.6,1.6c0.9,0,1.6-0.7,1.6-1.6V124.4c0-0.9-0.7-1.6-1.6-1.6c-0.9,0-1.6,0.7-1.6,1.6V404.3z"/>
									<path d="M204.2,406.9c0,0.8,0.7,1.5,1.5,1.5s1.5-0.7,1.5-1.5V22.7c0-0.8-0.7-1.5-1.5-1.5s-1.5,0.7-1.5,1.5V406.9z"/>
									<path d="M260.9,407.6c0,0.4,0.3,0.8,0.8,0.8c0.4,0,0.8-0.3,0.8-0.8v-214c0-0.4-0.3-0.8-0.8-0.8c-0.4,0-0.8,0.3-0.8,0.8V407.6z"/>
							</g>
						</svg>
					</a>
					<div class="nav-bar__list">
						<div class="nav-bar__item">
							<a class="nav-bar__item--link" href="search.php">
								Search	
							</a>
							<svg 
								aria-label="[title]"
								<title>Search</title>
								<use xlink:href="public/images/icomoon/sprite.svg#icon-search"></use>
							</svg>

						</div>
						<div class="nav-bar__item">
							<a class="nav-bar__item--link" href="browse.php">
								Browse
							</a>
						</div>
						<div class="nav-bar__item">
							<a class="nav-bar__item--link" href="your_music.php">
								Your Music	
							</a>
						</div>
						<div class="nav-bar__item">
							<a class="nav-bar__item--link" href="radio.php">
								Radio	
							</a>
						</div>
					</div>
				</div>
			</nav>

			<div class="main">
				main
			</div>
	
		</div>

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
							<span class="album__info--track">
								<span class="album__info--track-name">
									Rubber Baby Buggy Bumpers
								</span>
								<svg 
									aria-label="[title]"
									class="album__info--track-icon">
									<title>Add to playlist</title>
									<use xlink:href="public/images/icomoon/sprite.svg#icon-plus"></use>
								</svg>
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
							class="controls__play">
							<title>Play</title>
							<use xlink:href="public/images/icomoon/sprite.svg#icon-play2"></use>
						</svg>
						<svg 
							aria-label="[title]"
							class="controls__pause">
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
