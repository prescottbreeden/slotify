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

	</div>

</section>
