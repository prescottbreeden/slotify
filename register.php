<?php
	include('includes/classes/Account.php');

	$account = new Account();

	include('includes/handlers/register-handler.php');
	include('includes/handlers/login-handler.php');

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
					required
					type="text">
			</p>
			<p>
				<label for="loginPassword">Password</label>
				<input 
					id="loginPassword" 
					name="loginPassword" 
					required
					placeholder="Your password"
					type="password">
			</p>
			<button type="submit" name=loginButton>Log In</button>
		</form>

		<form id="registerForm" action="register.php" method="POST">
			<h2>Create your free account</h2>
			<p>
				<?php echo $account->getError($account->un_len); ?>
				<label for="username">Username</label>
				<input 
					id="username" 
					name="username" 
					placeholder="e.g. bartSimpson"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError($account->fn_len); ?>
				<label for="firstName">First Name</label>
				<input 
					id="firstName" 
					name="firstName" 
					placeholder="e.g. bart"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError($account->ln_len); ?>
				<label for="lastName">Last Name</label>
				<input 
					id="lastName" 
					name="lastName" 
					placeholder="e.g. Simpson"
					required
					type="text">
			</p>
			<p>
				<?php echo $account->getError($account->em_match); ?>
				<label for="email">Email</label>
				<input 
					id="email" 
					name="email" 
					placeholder="bartSimpson@gmail.com"
					required
					type="email">
			</p>
			<p>
				<label for="email2">Confirm Email</label>
				<input 
					id="email2" 
					name="email2" 
					placeholder="bartSimpson@gmail.com"
					required
					type="email">
			</p>
			<p>
				<?php echo $account->getError($account->pw_len); ?>
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
