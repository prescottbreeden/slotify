<?php
include("../../config.php");
include("../../classes/User.php");

if(isset($_POST['playlistId'])) {
	$playlistId = $_POST['playlistId'];

	$playlistquery = mysqli_query($con, "
		 DELETE 
				FROM playlists 
				WHERE playlist_id ='$playlistId'");
	$songsQuery = mysqli_query($con, "
		 DELETE 
				FROM pl_songs 
				WHERE playlist_id ='$playlistId'");
}
else {
	echo "um.... can't do boss - i needz an id";
}


?>


