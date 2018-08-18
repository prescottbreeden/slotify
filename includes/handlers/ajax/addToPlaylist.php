
<?php
include("../../config.php");
include("../../classes/Playlist.php");

if(isset($_POST['playlist_id']) && isset($_POST['song_id'])) {
	$playlist_id = $_POST['playlist_id'];
	$song_id = $_POST['song_id'];
	$playlist = new Playlist($con, $_POST['playlist_id']);

	$orderIdQuery = mysqli_query($con, "
		 SELECT 
				CASE
					WHEN MAX(playlist_order) IS NULL
						THEN 1
					ELSE MAX(playlist_order) + 1
				END AS pl_order
		   FROM pl_songs 
				WHERE playlist_id='$playlist_id'");
	
	$row = mysqli_fetch_array($orderIdQuery);
	$order = $row['pl_order'];

	$query = mysqli_query($con, "
		 INSERT INTO pl_songs 
					(song_id, playlist_id, playlist_order) 
			VALUES	('$song_id', '$playlist_id', '$order')
	");
}
else {
	echo "playlistId or SongID was not passed into ajax";
}


?>
