<?php
	include('includes/classes/Constants.php');
	include('includes/classes/Account.php');

	$account = new Account();

	include('includes/handlers/register-handler.php');
	include('includes/handlers/login-handler.php');

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Slotify!</title>
</head>
<body>
	<div id="inputContainer">

		<form id="loginForm" action="register.php" method="POST">
			<h2>Login to your account</h2>
			<p>
				<label for="loginUsername">Username</label>
				<input 
					id="loginUsername" 
					name="loginUsername" 
					placeholder="e.g. bartSimpson"
					value="<?php echo $_POST['loginUsername']; ?>"
					required
					type="text">
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input 
					id="loginPassword" 
					name="loginPassword" 
					placeholder="Your password"
					required
					type="password">
			</p>
			<button type="submit" name=loginButton>Log In</button>
		</form>

		<form id="registerForm" action="register.php" method="POST">
			<h2>Create your free account</h2>
			<p>
				<?php echo $account->getError(Constants::$error_un_len); ?>
				<label for="username">Username</label>
				<input 
					id="username" 
					name="username" 
					placeholder="e.g. bartSimpson"
					value="<?php getInputValue('username') ?>"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError(Constants::$error_fn_len); ?>
				<label for="firstName">First Name</label>
				<input 
					id="firstName" 
					name="firstName" 
					placeholder="e.g. bart"
					value="<?php getInputValue('firstName') ?>"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError(Constants::$error_ln_len); ?>
				<label for="lastName">Last Name</label>
				<input 
					id="lastName" 
					name="lastName" 
					placeholder="e.g. Simpson"
					value="<?php getInputValue('lastName') ?>"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError(Constants::$error_em_match); ?>
				<?php echo $account->getError(Constants::$error_em_valid); ?>
				<label for="email">Email</label>
				<input 
					id="email" 
					name="email" 
					placeholder="bartSimpson@gmail.com"
					value="<?php getInputValue('email') ?>"
					required
					type="email">
			</p>
			<p>
				<label for="email2">Confirm Email</label>
				<input 
					id="email2" 
					name="email2" 
					placeholder="bartSimpson@gmail.com"
					value="<?php getInputValue('email2') ?>"
					required
					type="email">
			</p>
			<p>
				<?php echo $account->getError(Constants::$error_pw_len); ?>
				<?php echo $account->getError(Constants::$error_pw_match); ?>
				<?php echo $account->getError(Constants::$error_pw_valid); ?>
				<label for="password">Password</label>
				<input 
					id="password" 
					name="password" 
					required
					placeholder="Your password"
					type="password">
			</p>
			<p>
				<label for="password2">Confirm Password</label>
				<input 
					id="password2" 
					name="password2" 
					required
					placeholder="Your password"
					type="password">
			</p>
			<button type="submit" name=registerButton>Sign Up</button>
		</form>
	</div>
</body>
</html>
