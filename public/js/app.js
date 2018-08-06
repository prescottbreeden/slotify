$(document).ready(function() {
	console.log('power overwhelming...');

	$('#registerForm').hide();
	$('#loginForm').show();

	$('#hideLogin').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	})

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	})
})
