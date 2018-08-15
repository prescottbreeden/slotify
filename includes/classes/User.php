<?php

class User {

	private $con;
	private $id;
	private $username;

	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;

		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
		$album = mysqli_fetch_array($query);

		$this->id = $album['id'];
	}

	public function getId() {
		return $this->user_id;
	}

	public function getUsername() {
		return $this->username;
	}
}

?>
