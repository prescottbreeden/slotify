<?php

if(isset($_POST['loginButton'])) {
	/* echo "login button was pressed"; */
	$username = $_POST['loginUsername'];
	$password = $_POST['loginPassword'];

	$result = $account->login($username, $password);
	echo $result;

	if($result) {
		$_SESSION['userLoggedIn'] = $username;
		header("Location: browse.php");
	}
}

?>
