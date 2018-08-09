<?php
include('includes/config.php');
include('includes/classes/Artist.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
} else {
	header("Location: index.php");
}

$artist = new Artist($con, $album['artist']);

?>

<?php include('includes/templates/header.php'); ?>
<?php include('includes/templates/top-bar.php'); ?>

<?php
$albumQuery = mysqli_query($con, "
  SELECT album.album_id,
		 album.title_name, 
		 album.artwork_path,
		 artist.name,
		 g.name AS genre
	FROM albums as album 
		 JOIN artists as artist
			ON album.artist_id = artist.artist_id		
		 JOIN genres as g
			ON album.genre_id = g.genre_id
		 WHERE
			album_id='$albumId'");

$album = mysqli_fetch_array($albumQuery);

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
				</div>";




?>

</section>
<?php include('includes/templates/footer.php'); ?>

