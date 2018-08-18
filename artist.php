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
	$artistId = $_GET['id'];
}
else {
	header("Location: index.php");
}

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = '';
}

$artist = new Artist($con, $artistId);

?>
<section class="artist">
	<div class="artist__center-section">
		<div class="artist__info">
			<h1 class="artist__info--name"><?php echo $artist->getName(); ?></h1>
			<div class="artist__header-btn">
				<div 
					onclick="playFirstSong()" 
					style="margin: 1rem auto;"
					class="artist__header-btn--btn">
						Play
				</div>
			</div>
		</div>
	</div>
	<div class='tracks'>
		<h2 class="u-secondary-heading">Popular</h2>
		<div class='tracks__list'>
			<div class="tracks__list--item">
				<div class="tracks__list--number-header">#</div>
				<div class="tracks__list--name-header">Title</div>
				<div class="tracks__list--artist-header">album</div>
				<div class='tracks__list--more'></div>
				<div class="tracks__list--duration-header">play count</div>

			</div>

			<?php 
			$song_array = $artist->getSongIds();
			$i = 1;
			foreach($song_array as $song) {
				if($i > 5) {
					break;
				}
				$artistSong = new Song($con, $song);

				echo "
					<div class='tracks__list--item'>
						<div class='tracks__list--number'>
						<span>	
							$i
						</span>

						<svg 
							aria-label='[title]'
							onclick='setTrack(\"" . $artistSong->getId() . "\", tempPlaylist, true)'
							class='tracks__list--number-play'>
							<title>Play</title>
							<use href='public/images/icomoon/sprite.svg#icon-play2'></use>
						</svg>
						</div>
						<div class='tracks__list--name'>" . $artistSong->getTitle() . "</div>
						<div class='tracks__list--artist'>" . $artistSong->getAlbumName() . "</div>
	 					<div class='tracks__list--more'>
							<input type='hidden' class='songId' value='" . $artistSong->getId() . "'>
							<svg 
								class='options__button'
								onclick='showOptionsMenu(this)' 
								aria-label='[title]'
								<title>More</title>
								<use href='public/images/icomoon/sprite.svg#icon-more-horizontal'></use>
							</svg>
						</div>
						<div class='tracks__list--duration'>" . $artistSong->getPlayCount() . "</div>
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
	<h2 class="u-secondary-heading">Albums</h2>
	<div class="u-divider"></div>
	<div class="album-select__container">
<?php
$albumQuery = mysqli_query($con, "
  SELECT album.album_id,
		 album.title_name, 
		 album.artwork_path
	FROM albums as album 
		 WHERE album.artist_id = '$artistId'");

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
					</div>
				</span>
			</div>";
}

?>
	</div>
</section>

<div class="playlists-menu">
	<div class="menu-item">
		New Playlist
	</div>
	<div class="options-menu__divider"></div>
	<!-- placeholder for playlists -->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn); ?>
</div>
<div class="share-menu">
	<div class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Facebook
	</div>
	<div class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Twitter
	</div>
	<div class="share-menu__item">
		<svg 
			aria-label="[title]"
			<title>Share this song</title>
			<use href="public/images/icomoon/sprite.svg#icon-chain"></use>
		</svg>
		Copy Song Link
	</div>
	<div class="share-menu__item">
		<div class="share-menu__item--empty"></div>
		Copy Embed Code
	</div>
	<div class="share-menu__item">
		<div class="share-menu__item--empty"></div>
		Copy Slotify URI
	</div>
</div>
<div class="options-menu">
	<div class="menu-item">
		Add to Queue
	</div>
	<div class="options-menu__divider"></div>
	<div class="menu-item">
		Go to Artist
	</div>
	<div class="menu-item">
		Go to Album
	</div>
	<div class="options-menu__divider"></div>
	<div class="menu-item">
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
	<div class="menu-item">
		Remove from this Playlist
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
