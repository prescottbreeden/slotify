<?php

class Album {

	private $con;
	private $id;
	private $title;
	private $artist_id;
	private $genre_id;
	private $artwork_path;

	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$query = mysqli_query($this->con, "SELECT * FROM albums WHERE album_id='$this->id'");
		$album = mysqli_fetch_array($query);

		$this->title = $album['title_name'];
		$this->artist_id = $album['artist_id'];
		$this->genre_id = $album['genre_id'];
		$this->artwork_path = $album['artwork_path'];
	}

	public function getTitle() {
		return $this->title;
	}

	public function getArtist() {
		return new Artist($this->con, $this->artist_id);
	}
	
	public function getGenre() {
		return $this->genre_id;
	}

	public function getArtworkPath() {
		return $this->artwork_path;
	}
	
	public function getNumberOfSongs() {
		$query = mysqli_query($this->con, "SELECT * FROM songs as s WHERE s.album_id='$this->id'");
		return mysqli_num_rows($query);
	}
	
	public function getSongIds() {
		$query = mysqli_query($this->con, "SELECT song_id FROM songs WHERE album_id='$this->id' ORDER BY album_order ASC");

		$array = array();

		while($row = mysqli_fetch_array($query)) {
			array_push($array, $row['song_id']);
		}

		return $array;
	}
}
?>

