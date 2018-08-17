<?php
include('includes/includedFiles.php');

if(isset($_GET['id'])) {
	$playlist_id = $_GET['id'];
}
else {
	header("Location: browse.php");
}

$playlist = new Playlist($con, $playlist_id);
$owner = new User($con, $playlist->getOwnerName());
?>


<section class='playlist'>
	<div class='playlist__header'>
		<div class='playlist__header--artwork'>
			<svg class='playlist__icon'>
				<use href='public/images/icomoon/sprite.svg#icon-videogame_asset'</use>
			</svg>	
		</div>
		<div class='playlist__header--details'>
			<div class='playlist__header--details-miniheader'>
				Playlist
			</div>
			<div class='playlist__header--details-title'>
				<?php echo $playlist->getName(); ?>
			</div>
			<div class='playlist__header--misc'>
				<span class="playlist__header--details-artist-by">Created by</span>
				<span 
					class="playlist__header--details-artist-name">
					<?php echo $playlist->getOwnerName(); ?> 
				</span>
				&bull; <?php echo $playlist->getNumberOfSongs(); ?> songs,
				<?php echo $playlist->getTotalLength(); ?> min
			</div>
			<div class='playlist__btn'>
				<div 
					
					class='playlist__btn--play'>
					<p>Play</p>
				</div>
				<div 
					onclick="sharePlaylist(4)"
					class='playlist__btn--save'>
					<p>Share</p>
				</div>
				<div class='playlist__btn--more'>
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
						class="tracks__list--duration-header"
						aria-label="[title]"
						<title>Duration</title>
						<use href="public/images/icomoon/sprite.svg#icon-clock"></use>
					</svg>
				</div>

			</div>

			<?php 
			$song_array = $playlist->getSongIds();
			$i = 1;
			foreach($song_array as $song) {
				$playlistSong = new Song($con, $song);
				$songArtist = $playlistSong->getArtist();

				echo "
					<div class='tracks__list--item'>
						<div class='tracks__list--number'>
						<span>	
							$i
						</span>

						<svg 
							aria-label='[title]'
							onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'
							class='tracks__list--number-play'>
							<title>Play</title>
							<use href='public/images/icomoon/sprite.svg#icon-play2'></use>
						</svg>
						</div>
						<div class='tracks__list--name'>" . $playlistSong->getTitle() . "</div>
						<div 
							onclick='openPage(\"artist.php?id=" . $playlistSong->getArtistId() . "\")'
							class='tracks__list--artist'>" . $songArtist->getName() . "</div>
						<div class='tracks__list--more'>
							<svg 
								aria-label='[title]'
								<title>More</title>
								<use href='public/images/icomoon/sprite.svg#icon-more-horizontal'></use>
							</svg>
						</div>
						<div class='tracks__list--duration'>" . $playlistSong->getDuration() . "</div>
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
				console.log('balls');
			</script>


		</ul>
	</div>
</section>
