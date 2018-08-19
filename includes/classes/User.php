<?php

class User {

	private $con;
	private $id;
	private $username;
	private $first_name;
	private $laste_name;
	private $email;
	private $profile_pic;
	private $password;
	private $created_at;
	private $updated_at;

	public function __construct($con, $username) {
		$this->con = $con;
		$this->username = $username;

		$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$this->username'");
		$user = mysqli_fetch_array($query);

		$this->id = $user['user_id'];
		$this->first_name = $user['first_name'];
		$this->last_name = $user['last_name'];
		$this->email = $user['email'];
		$this->profile_pic = $user['profile_pic'];
		$this->created_at = $user['created_date'];
		$this->updated_at = $user['updated_date'];
	}

	public function getId() {
		return $this->id;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getFullName() {
		return $this->first_name . ' ' . $this->last_name; 
	}

	public function getEmail() {
		return $this->email;
	}

	public function getProfilePic() {
		return $this->profile_pic;
	}
}

?>
