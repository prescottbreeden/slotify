<?php
include('includes/includedFiles.php');

// this code doesn't really work the way it's intended
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
$total_length = $album->getTotalLength();

?>

<section class="top-bar">
	<div class="top-bar__empty-space"></div>
	<div title="Profile" class="top-bar__user-info">
		<img class="top-bar__user-info--avatar" src="public/images/profile-pics/head_emerald.png" alt="user avatar">
		<p class="top-bar__user-info--username"><?php echo $_SESSION['userLoggedIn']?></p>
	</div>
</section>

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
				<?php echo $total_length; ?>  
			</div>
			<div class='album__btn'>
				<div 
					onclick="playAlbum()"
					class='album__btn--play'>
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
		<div class='tracks__list'>
			<div class="tracks__list--item">
				<div class="tracks__list--number-header">#</div>
				<div class="tracks__list--name-header">Title</div>
				<div class="tracks__list--artist-header">artist</div>
				<div class='tracks__list--more'></div>
				<div class="tracks__list--duration">
					<svg 
						aria-label="[title]"
						<title>Duration</title>
						<use href="public/images/icomoon/sprite.svg#icon-clock"></use>
					</svg>
				</div>

			</div>

			<?php 
			$song_array = $album->getSongIds();
			$i = 1;
			foreach($song_array as $song) {
				$albumSong = new Song($con, $song);
				$albumArtist = $albumSong->getArtist();

				echo "
					<div class='tracks__list--item'>
						<div class='tracks__list--number'>
						<span>	
							$i
						</span>

						<svg 
							aria-label='[title]'
							onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'
							class='tracks__list--number-play'>
							<title>Play</title>
							<use href='public/images/icomoon/sprite.svg#icon-play2'></use>
						</svg>
						</div>
						<div class='tracks__list--name'>" . $albumSong->getTitle() . "</div>
						<div class='tracks__list--artist'>" . $albumArtist->getName() . "</div>
						<div class='tracks__list--more'>
							<svg 
								aria-label='[title]'
								<title>More</title>
								<use href='public/images/icomoon/sprite.svg#icon-more-horizontal'></use>
							</svg>
						</div>
						<div class='tracks__list--duration'>" . $albumSong->getDuration() . "</div>
					</div>

					";

				$i = $i+1;
			}

			?>

			<script>
				var tempSongIds = '<?php echo json_encode($song_array); ?>';
				tempPlaylist = JSON.parse(tempSongIds);

				function playAlbum() {
					var firstSong = tempPlaylist[0];
					setTrack(firstSong, tempPlaylist, true);
				}
			</script>

		</ul>
	</div>
</section>
