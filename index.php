<?php
include('includes/config.php');

if(!isset($_SESSION['userLoggedIn'])) {
	header("Location: register.php");
}

// session_destroy();

?>

<?php include('includes/templates/head.php'); ?>
<body>
	<div class="content-wrapper">
		<div class="content">
			<?php include('includes/templates/nav.php'); ?>
			<?php include('includes/templates/main.php'); ?>
		</div>
		<?php include('includes/templates/play-bar.php'); ?>
	</div>
</body>
</html>
