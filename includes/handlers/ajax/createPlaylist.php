<?php
include("../../config.php");
include("../../classes/User.php");

if(isset($_POST['user']) && isset($_POST['name'])) {
	$user = new User($con, $_POST['user']);
	$user_id = $user->getId();
	$name = $_POST['name'];
	$query = mysqli_query($con, 
		"INSERT INTO playlists 
					(name, user_id) 
			VALUES	('$name', '$user_id')");
}
else {
	echo "um.... sure?";
}


?>


