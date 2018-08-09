<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<?php include('includes/templates/header.php'); ?>
<?php include('includes/templates/top-bar.php'); ?>
<?php include('includes/templates/main.php'); ?>
<?php include('includes/templates/footer.php'); ?>
