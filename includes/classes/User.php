<?php

class User {

	private $con;
	private $id;
	private $username;
	private $created_at;
	private $updated_at;

	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;

		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
		$user = mysqli_fetch_array($query);

		$this->id = $user['user_id'];
		$this->created_at = $user['created_date'];
		$this->updated_at = $user['updated_date'];
	}

	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}
}

?>
