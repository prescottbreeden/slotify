<?php

class Account {

	private $errorArray;

	// error messages
	public $un_len = 'Username must be between 5 and 25 characters';
	public $fn_len = "First name must be between 2 and 25 characters";
	public $ln_len = "Last name must be between 2 and 25 characters";
	public $em_match = "Your emails don't match";
	public $em_valid = "Please enter a valid email";
	public $pw_match = "Your passwords don't match";
	public $pw_valid = "Passwords can only contain letters and numebrs";
	public $pw_len = "Password must be between 5 and 30 characters";

	public function __construct() {
		$this->errorArray = array();
		
	}

	public function register($un, $fn, $ln, $em, $em2, $pw, $pw2) {
		$this->validateUsername($un);
		$this->validateFirstName($fn);
		$this->validateLastName($ln);
		$this->validateEmails($em, $em2);
		$this->validatePasswords($pw, $pw2);

		if(empty($this->errorArray)) {
			// Insert into DB
			return true;
		}
		else {
			return false;
		}
	}

	/* public function getError($error) { */
	/* 	if(!array_key_exists($error, array $this->errorArray)) { */
	/* 		$error = ''; */
	/* 	} */
	/* 	else { */
	/* 		$err = $this->errorArray[$error]; */
	/* 		return "<span class='errorMessage'>$error</span>"; */
	/* 	} */
	/* } */

	public function getError($error) {
		if(!in_array($error, $this->errorArray)) {
			$error = "";
		}
		return "<span class='errorMessage'>$error</span>";
	}

	private function validateUsername($un) {
		if(strlen($un) > 25 || strlen($un) < 5) {
			array_push($this->errorArray, $this->un_len);
			return;
		}

		//TODO: check if username exists;

	}

	private function validateFirstName($fn) {
		if(strlen($fn) > 25 || strlen($fn) < 2) {
			array_push($this->errorArray, $this->fn_len);
			return;
		}
	}

	private function validateLastName($ln) {
		if(strlen($ln) > 25 || strlen($ln) < 2) {
			array_push($this->errorArray, $this->ln_len);
			return;
		}
	}

	private function validateEmails($em, $em2) {
		if($em != $em2) {
			array_push($this->errorArray, $this->em_match);
			return;
		}

		if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
			array_push($this->errorArray, $this->em_valid);
			return;
		}

		//TODO: check that email hasn't already been used
	}

	private function validatePasswords($pw, $pw2) {
		if($pw != $pw2) {
			array_push($this->errorArray, $this->pw_match);
			return;
		}

		if(preg_match('/[^A-Za-z0-9]/', $pw)) {
			array_push($this->errorArray, $this->pw_valid);
			return;
		}
		if(strlen($pw) > 30 || strlen($pw) < 5) {
			array_push($this->errorArray, $this->pw_len);
			return;
		}

	}
}

?>
