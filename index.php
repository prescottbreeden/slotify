<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<?php include('includes/includedFiles.php'); ?>

<script>openPage('browse.php')</script>
