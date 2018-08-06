$(document).ready(function() {
	console.log('power overwhelming...');

	$('#hideLogin').click(function() {
		$('#loginForm').hide();
		$('#registerForm').show();
	})

	$('#hideRegister').click(function() {
		$('#registerForm').hide();
		$('#loginForm').show();
	})
})
