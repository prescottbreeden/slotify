<?php
include('includes/includedFiles.php');

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {
	header("Location: register.php");
}

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = '';
}

$songsQuery = mysqli_query($con, "
 	 SELECT song_id 
	   FROM songs 
			WHERE title_name LIKE '%$term%' 
			ORDER BY play_count DESC
			LIMIT 10 
");

$artistsQuery = mysqli_query($con, "
	 SELECT artist_id 
	   FROM artists
			WHERE name LIKE '%$term%'
			LIMIT 10
");

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
			WHERE album.title_name LIKE '%$term%'"
);

?>
<section class="search-page">
	<div class="searchContainer">
		<div 
			readonly
			class="searchInput">
	</div>
	<div class="search-page__searching"></div>
	<div class="search-page__results">
		<div class='tracks'>
			<h2 class="u-secondary-heading">Popular Songs</h2>
			<div class='tracks__list'>
				<?php 
				if(mysqli_num_rows($songsQuery) === 0) {
					echo "<span class='noResults'>No songs found matching " . $term . "</span>";
				}
				else {
					echo "
						<div class='tracks__list--item'>
							<div class='tracks__list--number-header'>#</div>
							<div class='tracks__list--name-header'>Title</div>
							<div class='tracks__list--artist-header'>artist</div>
							<div class='tracks__list--artist-header'>album</div>
							<div class='tracks__list--more'></div>
							<div class='tracks__list--duration'></div>

						</div>
					";
				}
				$song_array = array();
				$i = 1;
				while($row = mysqli_fetch_array($songsQuery)) {
					if($i > 15) {
						break;
					}
					array_push($song_array, $row['song_id']);

					$song = new Song($con, $row['song_id']);
					$songArtist = $song->getArtist();
					$playcount = $song->getPlayCount();
					$formattedPlayCount = number_format($playcount);

					echo "
						<div class='tracks__list--item'>
							<div class='tracks__list--number'>
								<span>	
									$i
								</span>
								<svg 
									aria-label='[title]'
									onclick='setTrack(\"" . $song->getId() . "\", tempPlaylist, true)'
									class='tracks__list--number-play'>
									<title>Play</title>
									<use href='public/images/icomoon/sprite.svg#icon-play2'></use>
								</svg>
							</div>
							<div class='tracks__list--name'>" . $song->getTitle() . "</div>
							<div 
								onclick='openPage(\"artist.php?id=" . $song->getArtistId() . "\")'
								class='tracks__list--artist'>" . $songArtist->getName() . "
							</div>
							<div 
								onclick='openPage(\"album.php?id=" . $song->getAlbumId() . "\")'
								class='tracks__list--artist'>" . $song->getAlbumName() . "
							</div>
							<div class='tracks__list--more'>
								<input type='hidden' class='songId' value='" . $song->getId() . "'>
								<input type='hidden' class='albumId' value='" . $song->getAlbumId() . "'>
								<input type='hidden' class='artistId' value='" . $song->getArtistId() . "'>
								<svg 
									class='options__button'
									onclick='showOptionsMenu(this)' 
									aria-label='[title]'
									<title>More</title>
									<use href='public/images/icomoon/sprite.svg#icon-more-horizontal'></use>
								</svg>
							</div>
							<div class='tracks__list--duration'>" . $formattedPlayCount . "</div>
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

		<div class="artistsContainer">
			<h2>Artists</h2>
			<?php
			if(mysqli_num_rows($artistsQuery) === 0) {
				echo "<span class='noResults'>No artists found matching " . $term . "</span>";
			}
			while($row = mysqli_fetch_array($artistsQuery)) {
				$artistFound = new Artist($con, $row['artist_id']);

				echo "<div class='searchResultRow'>
						<svg class='artistName__icon'>
							<use href='public/images/icomoon/sprite.svg#icon-videogame_asset'</use>
						</svg>	
						<div class='artistName'>
							<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
								" . $artistFound->getName()  . "	
							</span>
						</div>
					
					
					</div>";
			}
			?>
		</div>
		<h2>Albums</h2>
		<div class='album-select__container'>
			<?php
			if(mysqli_num_rows($albumQuery) === 0) {
				echo "<span class='noResults'>No albums found matching " . $term . "</span>";
			}

			while($row = mysqli_fetch_array($albumQuery)) {

				echo	"
						<div class='album-select__container--item'>
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
</section>

<!-- dropdown menus --> 
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
</div>
<div class="options-menu">
	<div class="menu-item">
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
