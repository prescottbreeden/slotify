<?php
include('includes/config.php');
include('includes/classes/Artist.php');
include('includes/classes/Album.php');
include('includes/classes/Song.php');

// session_destroy(); LOGOUT

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script> userLoggedIn = '$userLoggedIn' </script>";
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
					<span 
						role="link"
						tabindex="0"
						onclick="openPage('index.php')"
						class="nav-bar__logo"> 
						<?php include 'includes/icons/logo.html'; ?>
					</span>
					<div class="nav-bar__list">
						<div class="nav-bar__item">
							<span 
								role="link"
								tabindex="0"
								onclick="openPage('search.php')"
								class="nav-bar__item--link">
								Search	
							</span>
							<svg 
								aria-label="[title]"
								<title>Search</title>
								<use href="public/images/icomoon/sprite.svg#icon-search"></use>
							</svg>

						</div>
						<div class="nav-bar__item">
							<span 
								role="link"
								tabindex="0"
								onclick="openPage('browse.php')"
								class="nav-bar__item--link">
								Browse
							</span>
						</div>
						<div class="nav-bar__item">
							<span 
								role="link"
								tabindex="0"
								onclick="openPage('your_music.php')"
								class="nav-bar__item--link">
								Your Music	
							</span>
						</div>
						<div class="nav-bar__item">
							<span 
								role="link"
								tabindex="0"
								onclick="openPage('radio.php')"
								class="nav-bar__item--link">
								Radio	
							</span>
						</div>
					</div>
				</div>
			</nav>
			<div class="dynamic-content">
