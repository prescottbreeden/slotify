<?php
include('includes/config.php');
include('includes/classes/Artist.php');

// session_destroy(); LOGOUT

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
}
else {
	header("Location: register.php");
}

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
						<?php include 'includes/icons/logo.html'; ?>
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
			<div class="dynamic-content">
