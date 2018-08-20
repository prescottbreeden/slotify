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
	$playlist_id = $_GET['id'];
}
else {
	header("Location: browse.php");
}

$playlist = new Playlist($con, $playlist_id);
$owner = new User($con, $playlist->getOwnerName());
?>

<div class="warning">
	<div class="warning__text"></div>
	<div class="warning__btns">
		<div 
			onclick="deletePlaylist(<?php echo $playlist_id; ?>)" 
			id="warning_confirm" 
			class="warning__btns--confirm">
				Confirm
		</div>
		<div 
			onclick="deleteCancel()"
			id="warning_cancel" 
			class="warning__btns--cancel">
				Cancel
		</div>
	</div>
</div>


<section class='playlist'>
	<div class='playlist__header'>
		<div class='playlist__header--artwork'>
			<svg class='playlist__icon'>
				<use href='public/images/icomoon/sprite.svg#icon-videogame_asset'</use>
			</svg>	
			<div class="playlist__header--artwork-hover">
				<svg 
					onclick="playAlbum()";
					class='playlist__icon-hover'>
					<use href='public/images/icomoon/sprite.svg#icon-play2'</use>
				</svg>	
			</div>
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
					onclick="playAlbum()";
					class='playlist__btn--play'>
					<p>Play</p>
				</div>
				<div 
					onclick="deleteWarning()"
					class='playlist__btn--delete'>
					<p id="pl_delete">delete playlist</p>
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
				<div class="tracks__list--album-header">album</div>
				<div class='tracks__list--more-header'>
						
				</div>
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
			$pl_songs = $playlist->getSongIds();
			$i = 1;
			foreach($pl_songs as $song) {
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
							class='tracks__list--artist'>" . $songArtist->getName() . "
						</div>
						<div 
							onclick='openPage(\"album.php?id=" . $playlistSong->getAlbumId() . "\")'
							class='tracks__list--album'>" . $playlistSong->getAlbumName() . "
						</div>
	 					<div class='tracks__list--more'>
							<input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
							<svg 
								class='options__button'
								onclick='showOptionsMenu(this)' 
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
				var tempSongIds = '<?php echo json_encode($pl_songs); ?>';
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
	<div 
		onclick="removeFromPlaylist(<?php echo $playlist_id; ?>)"
		id="remove_pl_item" 
		class="menu-item">
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
