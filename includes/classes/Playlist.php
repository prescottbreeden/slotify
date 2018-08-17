<?php

class Playlist {

	private $con;
	private $id;
	private $name;
	private $owner_id;
	private $owner_name;
	private $created_at;
	private $updated_at;

	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$query = mysqli_query($this->con, "
			 SELECT p.name,
					p.user_id,
					u.username,
					p.created_at,
					p.updated_at
			   FROM playlists as p
					JOIN users as u
						ON u.user_id = p.user_id
					WHERE playlist_id='$this->id'
			");
		$playlist = mysqli_fetch_array($query);

		$this->name = $playlist['name'];
		$this->owner_id = $playlist['user_id'];
		$this->owner_name = $playlist['username'];
		$this->created_at = $playlist['created_at'];
		$this->updated_at = $playlist['updated_at'];

	}

	public function getId() {
		return $this->id;
	}

	public function getName() {
		return $this->name;
	}

	public function getOwnerId() {
		return $this->owner_id;
	}

	public function getOwnerName() {
		return $this->owner_name;
	}

	public function getCreatedAt() {
		return $this->created_at;
	}

	public function getUpdatedAt() {
		return $this->updated_at;
	}
}

?>
