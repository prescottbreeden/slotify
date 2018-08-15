<?php
include("../../config.php");

if(isset($_POST['name'])) {
	$name = $_POST['name'];
	$query = mysqli_query($con, "INSERT INTO playlists (name, user_id) VALUES('$name', 1)");
	$resultArray = mysqli_fetch_array($query);

	echo json_encode($resultArray);
}
else {
	echo $_POST['name'];
	echo $_POST['username'];
}


?>


