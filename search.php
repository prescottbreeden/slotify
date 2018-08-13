<?php
include('includes/includedFiles.php');

if(isset($_GET['term'])) {
	$term = urldecode($_GET['term']);
}
else {
	$term = '';
}

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
				$songsQuery = mysqli_query($con, "
					SELECT song_id 
					FROM songs 
							WHERE title_name 
							LIKE '%$term%' 
							ORDER BY play_count DESC
							LIMIT 10 
				");

				if(mysqli_num_rows($songsQuery) === 0) {
					echo "<span class='noResults'>No songs found matching " . $term . "</span>";
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
								<svg 
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

		<div class="artistsContainer u-border-bottom">
			<h2>Artists</h2>
			
		<?php
		$artistsQuery = mysqli_query($con, "
			SELECT artist_id 
			FROM artists
					WHERE name
					LIKE '%$term%'
					LIMIT 10
		");

		if(mysqli_num_rows($artistsQuery) === 0) {
			echo "<span class='noResults'>No artists found matching " . $term . "</span>";
		}

		while($row = mysqli_fetch_array($artistsQuery)) {
			$artistFound = new Artist($con, $row['artist_id']);

			echo "<div class='searchResultRow'>
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
		<div class="albumsContainer u-border-bottom">

		<?php
		$albumQuery = mysqli_query($con, "
			 SELECT *
			   FROM albums  
					Where title_name
					LIKE '%$term%'"
		);

		if(mysqli_num_rows($albumQuery) === 0) {
			echo "<span class='noResults'>No albums found matching " . $term . "</span>";
		}

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
</section>
