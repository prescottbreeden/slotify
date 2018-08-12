
<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<?php include('includes/includedFiles.php'); ?>

<section class="top-bar">
	<div class="top-bar__empty-space"></div>
	<div title="Profile" class="top-bar__user-info">
		<img class="top-bar__user-info--avatar" src="public/images/profile-pics/head_emerald.png" alt="user avatar">
		<p class="top-bar__user-info--username"><?php echo $_SESSION['userLoggedIn']?></p>
	</div>
</section>
<div class="main">
	<div class="main__content">
		<h2 class="main__content--heading">Browse</h2>
		<h4 class="main__content--sub-heading">Soundtrack for your day</h4>
	</div>
	<div class="album-select__container">

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
			ORDER BY RAND()");

while($row = mysqli_fetch_array($albumQuery)) {

	echo	"<div class='album-select__container--item'>
				<span 
					role='link'
					tabindex='0'
					onclick='openPage(\"album.php?id=" . $row['album_id'] . "\")'>
					<img src='" . $row['artwork_path'] . "'>	
					<div class='album-select__container--item-details'>
						<div class='album-select__container--item-title'>	
							" . $row['title_name'] . "
						</div>
						<div class='album-select__container--item-artist'>	
							" . $row['name'] . "
						</div>
					</div>
				</span>
			</div>";
}

?>
	</div>
</div>

