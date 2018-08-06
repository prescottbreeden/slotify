$(document).ready(function() {
	console.log('power overwhelming...');

	$('#registerForm').hide();
	$('#loginForm').show();

	$('#register_submit').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	})

	$('#login_submit').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	})

	$('#hideLogin').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	})

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	})
})
