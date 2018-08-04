<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Slotify!</title>
</head>
<body>
	Hello!
</body>
</html>
