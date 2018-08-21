<?php
include('includes/includedFiles.php');

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	$user = new User($con, $userLoggedIn);
	$user_id = $user->getId();

}
else {
	header("Location: register.php");
}

$playlistQuery = mysqli_query($con, "
 SELECT p.name,
		p.playlist_id,
		p.user_id,
		p.created_at,
		p.updated_at,
		u.username
   FROM playlists AS p 
		JOIN users AS u
			ON p.user_id=u.user_id
		WHERE u.user_id='$user_id'
");

$songsQuery = mysqli_query($con, "
 SELECT s.song_id 
   FROM songs AS s
		JOIN saved_songs AS ss
			ON s.song_id = ss.song_id
		WHERE user_id = '$user_id'
		ORDER BY created_at
");

$albumQuery = mysqli_query($con, "
 SELECT a.album_id,
		a.title_name, 
		a.artwork_path
   FROM albums as a
		JOIN saved_albums as sa
			ON a.album_id = sa.album_id
		WHERE sa.user_id='$user_id'
");

?>

<section class="playlists">
	<div class='album__header'>
		<div class='album__header--artwork'>
			<div class="profile__image">
				<img src="<?php echo $user->getProfilePic(); ?>" alt="profile image">
			</div>
		</div>
		<div class='album__header--details'>
			<div class='album__header--details-miniheader'>
				Your Music
			</div>
			<div class="profile__fullname">
				<?php echo $user->getFullName(); ?>
			</div>
		</div>
	</div>
		<h2 class="u-secondary-heading u-nudge-down">Playlists</h2>
		<div class="u-divider"></div>
		<div 
			onclick="createPlaylist()"
			class="playlists__btn">
			New Playlist	
		</div>
		<div class="playlists__container">

		<?php
		if(mysqli_num_rows($playlistQuery) == 0) {
			echo "<span class='playlists__noresults'>You haven't created any playlists yet.</span>"	;
		}
		while($row = mysqli_fetch_array($playlistQuery)) {
			echo	"<div class='playlists__item'>
						<span 
							role='link'
							tabindex='0'
							onclick='openPage(\"playlist.php?id=" . $row['playlist_id'] . "\")'>
							<div class='playlist__header--artwork'>
								<svg class='playlist__icon'>
									<use href='public/images/icomoon/sprite.svg#icon-videogame_asset'</use>
								</svg>	
								<div class='playlist__header--artwork-hover'>
									<svg 
										onclick='jumpToPlaylist(" . $row['playlist_id'] . ")'
										class='playlist__icon-hover'>
										<use href='public/images/icomoon/sprite.svg#icon-play2'</use>
									</svg>	
								</div>
							</div>
							<div class='album-select__container--item-details'>
								<div class='album-select__container--item-title'>	
									" . $row['name'] . "
								</div>
							</div>
						</span>
					</div>";
		}
		?>
		</div>
	<h2 class="u-secondary-heading">Songs</h2>
	<div class="u-divider"></div>
	<div class='tracks'>
		<div class='tracks__list'>

			<?php 
			if(mysqli_num_rows($songsQuery) === 0) {
				echo "<span class='noResults'>You do not have any saved songs in your library</span>";
			}
			else {
				echo "
					<div class='tracks__list--item'>
						<div class='tracks__list--number-header'>#</div>
						<div class='tracks__list--name-header'>Title</div>
						<div class='tracks__list--artist-header'>album</div>
						<div class='tracks__list--more'></div>
						<div class='tracks__list--duration-header'>play count</div>

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
				$artistSong = new Song($con, $row['song_id']);
				$albumArtist = $artistSong->getArtist();
				$playcount = $artistSong->getPlayCount();
				$formattedPlayCount = number_format($playcount);

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
	<h2 class="u-secondary-heading">Albums</h2>
	<div class="u-divider"></div>
	<div class="album-select__container">
		<?php
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

</section>
