<?php
include("../../config.php");

if(isset($_POST['name'])) {
	$name = $_POST['name'];
	$user_id = $_SESSION['user_id'];
	$query = mysqli_query($con, "INSERT INTO playlists (name, user_id) VALUES('$name', '$user_id')");
	$resultArray = mysqli_fetch_array($query);

	echo json_encode($resultArray);
}
else {
	echo $_POST['name'];
}


?>


