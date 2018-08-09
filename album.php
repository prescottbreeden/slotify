<?php
include('includes/header.php');

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
} 
else {
	header("Location: index.php");
}

$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE album_id='$albumId'");
$album = mysqli_fetch_array($albumQuery);
$artist = new Artist($con, $album['artist_id']);

echo $artist->getName();

?>

<?php include('includes/top-bar.php'); ?>

<?php

	echo	"
			<section class='album'>
				<div class='album__header'>
					<div class='album__header--artwork'>
						<img src=" . $album['artwork_path'] . " alt='album art'>
					</div>
					<div class='album__header--details'>
						<div class='album__header--details-miniheader'>
							Album from your library
						</div>
						<div class='album__header--details-title'>
							" . $album['title_name'] . "
						</div>
						<div class='album__header--details-artist'>
							" . $album['name'] . "
						</div>
						<div class='album__header--misc'>
							2009, 2 songs, 15min - View full album
						</div>
						<div class='album__btn'>
							<div class='album__btn--play'>
								<p>Play</p>
							</div>
							<div class='album__btn--save'>
								<p>Save</p>
							</div>
							<div class='album__btn--more'>
							</div>
						</div>
					</div>
				</div>
				<div class='album__tracks'>
					Track stuff
				</div>

				<div class='album-select__container--item-details'>
					<div class='album-select__container--item-title'>	
					</div>
					<div class='album-select__container--item-artist'>	
					</div>
				</div>
			</section>
			";

?>

<?php include('includes/footer.php'); ?>
