<?php
include('includes/header.php');

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
} 
else {
	header("Location: index.php");
}

$album = new Album($con, $albumId);
$artist = $album->getArtist();
$artwork_path = $album->getArtworkPath();
$artist_name = $artist->getName();
$album_name =  $album->getTitle();
$total_songs = $album->getNumberOfSongs();

?>

<?php include('includes/top-bar.php'); ?>

<section class='album'>
	<div class='album__header'>
		<div class='album__header--artwork'>
		<img src="<?php echo $artwork_path; ?>" alt='album art'>
		</div>
		<div class='album__header--details'>
			<div class='album__header--details-miniheader'>
				Album from your library
			</div>
			<div class='album__header--details-title'>
				<?php echo $album_name; ?> 
			</div>
			<div class='album__header--details-artist'>
				<?php echo $artist_name; ?> 
			</div>
			<div class='album__header--misc'>
				<?php echo $total_songs; ?> songs, 
				15min 
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
	<div class='tracks'>
		<ul class='tracks__list'>
			<li class="tracks__list--item">
				<div class="tracks__list--number-header">#</div>
				<div class="tracks__list--name-header">Title</div>
				<div class="tracks__list--duration">
					<svg 
						aria-label="[title]"
						<title>Duration</title>
						<use xlink:href="public/images/icomoon/sprite.svg#icon-clock"></use>
					</svg>
				</div>

			</li>
			<?php 
			$song_array = $album->getSongIds();
			$i = 1;
			foreach($song_array as $song) {
				$albumSong = new Song($con, $song);
				$albumArtist = $albumSong->getArtist();

				echo "
					<li class='tracks__list--item'>
						<div class='tracks__list--number'>
						<span>	
							$i
						</span>

						<svg 
							aria-label='[title]'
							class='tracks__list--number-play'>
							<title>Play</title>
							<use xlink:href='public/images/icomoon/sprite.svg#icon-play2'></use>
						</svg>
						</div>
						<div class='tracks__list--name'>" . $albumSong->getTitle() . "</div>
						<div class='tracks__list--duration'>" . $albumSong->getDuration() . "</div>
					</li>

					";

				$i = $i+1;
			}

			?>

		</ul>
	</div>
</section>

<?php include('includes/footer.php'); ?>
