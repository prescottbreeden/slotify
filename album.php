<?php
include('includes/includedFiles.php');

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {
	header("Location: register.php");
}

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
$year_released = $album->getYearReleased();

?>
<section class='album'>
	<div class='album__header'>
		<div class='album__header--artwork'>
			<img src="<?php echo $artwork_path; ?>" alt='album art'>
			<div class="album__header--artwork-hover">
				<svg 
					onclick="playAlbum()";
					class='playlist__icon-hover'>
					<use href='public/images/icomoon/sprite.svg#icon-play2'</use>
				</svg>	
			</div>
		</div>
		<div class='album__header--details'>
			<div class='album__header--details-miniheader'>
				Album 
			</div>
			<div class='album__header--details-title'>
				<?php echo $album_name; ?> 
			</div>
			<div class='album__header--details-artist'>
				<span class="album__header--details-artist-by">By</span>
				<span 
					onclick="openPage('artist.php?id=<?php echo $artist->getId(); ?>')"
					class="album__header--details-artist-name">
					<?php echo $artist_name; ?> 
				</span>
			</div>
			<div class='album__header--misc'>
				<?php echo $year_released; ?> &bull;
				<?php echo $total_songs; ?> songs, 
				<?php echo $total_length; ?> min 
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
						class="tracks__list--duration-header"
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
				$songArtist = $albumSong->getArtist();

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
						<div 
							onclick='openPage(\"artist.php?id=" . $albumSong->getArtistId() . "\")'
							class='tracks__list--artist'>" . $songArtist->getName() . "</div>
	 					<div class='tracks__list--more'>
							<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
							<svg 
								class='options__button'
								onclick='showOptionsMenu(this)' 
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

<div class="playlists-menu">
	<div 
	onclick="createPlaylist()"
		class="menu-item">
		New Playlist
	</div>
	<div class="options-menu__divider"></div>
	<!-- placeholder for playlists -->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn); ?>
</div>
<div class="share-menu">
	<div 
		onclick="returnFacebookLink()"
		class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Facebook
	</div>
	<div 
		onclick="returnTwitterLink()"
		class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Twitter
	</div>
	<div class="options-menu__divider"></div>
	<div 
		onclick="returnWebsiteLink()"
		class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Copy Song Link
	</div>
</div>
<div class="options-menu">
	<div 
		onclick="addToQueue()"
		class="menu-item">
		Add to Queue
	</div>
	<div class="options-menu__divider"></div>
	<div 
		onclick="goToArtist()"	
		class="menu-item">
		Go to Artist
	</div>
	<div 
		onclick="goToAlbum()"	
		class="menu-item">
		Go to Album
	</div>
	<div class="options-menu__divider"></div>
	<div 
		onClick="saveToLibrary()"
		class="menu-item">
		Save to Your Music
	</div>
	<div 
		id="open_playlists_menu" 
		class="menu-item">
		Add to playlist
		<svg 
			aria-label="[title]"
			<title>Add to playlist</title>
			<use href="public/images/icomoon/sprite.svg#icon-chevron-right"></use>
		</svg>
	</div>
	<div class="options-menu__divider"></div>
	<div 
		id="open_share_menu"
		class="menu-item">
		Share
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chevron-right"></use>
		</svg>
	</div>
</div>
