<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
} else {
	header("Location: index.php");
}

$albumQuery = mysqli_query($con, "SELECT title_name AS title FROM albums WHERE album_id='$albumId'");
$album = mysqli_fetch_array($albumQuery);
echo $album['title'];

?>

<?php include('includes/templates/header.php'); ?>
<?php include('includes/templates/top-bar.php'); ?>
<section class="album">
	<div class="album__header">
		<div class="album__header--artwork">
			picture of balls
		</div>
		<div class="album__header--details">
			<div class="album__header--details-miniheader">
				Album from your library
			</div>
			<div class="album__header--details-title">
				For lack of a better sack of balls
			</div>
			<div class="album__header--details-artist">
				deadball5
			</div>
			<div class="misc">
				2009, 2 songs, 15min - View full album
			</div>
			<div class="buttons">
				<button>Pause</button>
				<button>Save</button>
				<button>...</button>
			</div>
		</div>
	</div>
	<div class="album__tracks">
		Track stuff
	</div>



</section>
<?php include('includes/templates/footer.php'); ?>

