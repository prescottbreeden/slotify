<?php
include("../../config.php");

if(isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
	$playlist_id = $_POST['playlist_id'];
	$song_id = $_POST['song_id'];

	$query = mysqli_query($con, "
		 DELETE 
		   FROM pl_songs 
				WHERE playlist_id='$playlist_id'
				AND song_id='$song_id'	
		");
}
else {
	echo "playlistId or SongID was not passed into ajax";
}

?>