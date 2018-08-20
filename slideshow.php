<?php
include('includes/includedFiles.php');

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {
	header("Location: register.php");
}

?>

<section class="slideshow">
	<div class="slideshow__container">
		<div id="slide1" class="slideshow__container--slide">
			<p>Slide 1</p>
		</div>
		<div id="slide2" class="slideshow__container--slide">
			<p>Slide 2</p>
		</div>
		<div id="slide3" class="slideshow__container--slide">
			<p>Slide 3</p>
		</div>
		<div id="slide4" class="slideshow__container--slide">
			<p>Slide 4</p>
		</div>
		<div id="slide5" class="slideshow__container--slide">
			<p>Slide 5</p>
		</div><div id="slide6" class="slideshow__container--slide">
			<p>Slide 6</p>
		</div>
	</div>

	<div class="slideshow__controls">
		<div id="slideshow_back" class="slideshow__controls--back">
			<span>back</span>
		</div>
		<div id="slideshow_logo" class="slideshow__controls--logo">
			<div id="mp3_player">
				<div id="audio_box"></div>
				<canvas id="analyser_render"></canvas>
			</div>
		</div>

		<div id="slideshow_forward" class="slideshow__controls--forward">
			<span>forward</span>
		</div>
	</div>
</section>

