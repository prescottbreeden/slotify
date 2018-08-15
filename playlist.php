<?php
include('includes/includedFiles.php');

if(isset($_GET['id'])) {
	$playlist_id = $_GET['id'];

}
else {
	$playlist_name = 'Current Playlist';
}

?>

<script>
	console.log(currentPlaylist);
</script>

<section class='playlist'>
	<div class='playlist__header'>
		<div class='playlist__header--details'>
			<div class='playlist__header--details-miniheader'>
				playlist
			</div>
			<div class='playlist__header--details-title'>
				<?php echo $playlist_name; ?>
			</div>
			<div class='playlist__header--details-artist'>
				<span class="playlist__header--details-artist-by">By</span>
				<span 
					class="playlist__header--details-artist-name">
						
				</span>
			</div>
			<div class='playlist__header--misc'>
				updated: 2/3/18 &bull;
				10 songs,
				32 min
			</div>
			<div class='playlist__btn'>
				<div 
					
					class='playlist__btn--play'>
					<p>Play</p>
				</div>
				<div class='playlist__btn--save'>
					<p>Save</p>
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

			?>


		</ul>
	</div>
</section>
