<?php
include('includes/includedFiles.php');

if(isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
	echo "<script>userLoggedIn = '$userLoggedIn';</script>";
}
else {
	header("Location: register.php");
}

?>

<section class="playlists">
	<div class="playlists__container">
		<h2 class="playlists__heading">Playlists</h2>
		<div 
			onclick="createPlaylist()"
			class="playlists__btn">
			New Playlist	
		</div>
		<div class="album-select__container">

		<?php
		$user = new User($con, $userLoggedIn);
		$user_id = $user->getId();
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

		if(mysqli_num_rows($playlistQuery) == 0) {
			echo "<span class='playlists__noresults'>You don't have any playlists yet.</span>"	;
				
		}

		while($row = mysqli_fetch_array($playlistQuery)) {

			echo	"<div class='album-select__container--item'>
						<span 
							role='link'
							tabindex='0'
							onclick='openPage(\"playlist.php?id=" . $row['playlist_id'] . "\")'>
							<svg class='playlists__icon'>
								<use href='public/images/icomoon/sprite.svg#icon-videogame_asset'</use>
							</svg>	
							<div class='album-select__container--item-details'>
								<div class='album-select__container--item-title'>	
									" . $row['name'] . "
								</div>
								<div class='album-select__container--item-artist'>	
									" . $row['username'] . "
								</div>
							</div>
						</span>
					</div>";
		}

		?>
		</div>

	</div>

</section>
