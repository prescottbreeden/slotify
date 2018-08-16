<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}
else {
	include('includes/includedFiles.php');
	echo "<script>openPage('browse.php')</script>";
}

// session_destroy();
// consider moving the below code into an else statement to get rid of the not-logged in still showing header and footer until refresh

?>



