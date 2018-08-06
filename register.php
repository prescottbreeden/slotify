<?php

include('includes/config.php');
include('includes/classes/Constants.php');
include('includes/classes/Account.php');

$account = new Account($con);

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
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,900" rel="stylesheet">
	<link rel="stylesheet" href="public/css/styles.css">
	<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>	
	<script src="public/js/app.js"></script>
</head>
<body>
	<section class="register" id="background">
		<div class="register__container" id="register_container">
			<div class="register__login" id="input_container">

				<form 
					class="register__login--form" 
					id="loginForm" 
					action="register.php" method="POST">

					<h2 class="register__login--heading">Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$error_login_failed); ?>
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
							placeholder="Your password"
							required
							type="password">
					</p>
					<button 
						id="login_submit"
						class="register__login--btn" 
						type="submit" 
						name=loginButton>
							Log In
					</button>

					<div class="register__login--has-account-text">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>
				</form>

				<form 
					class="register__login--form"
					id="registerForm" 
					action="register.php" method="POST">

					<h2 class="register__login--heading">Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$error_un_len); ?>
						<?php echo $account->getError(Constants::$error_un_taken); ?>
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
						<?php echo $account->getError(Constants::$error_em_taken); ?>
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
					<button 
						id="register_submit"
						class="register__login--btn"
						type="submit" 
						name=registerButton>
							Sign Up
					</button>

					<div class="register__login--has-account-text">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>
				</form>
			</div>
		</div>
	</section>
</body>
</html>
