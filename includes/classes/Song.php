<?php

class Song {

	private $con;
	private $id;
	private $mysqliData;

	private $title;
	private $artist_id;
	private $album_id;
	private $genre_id;
	private $duration;
	private $path;

	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$query = mysqli_query($this->con, "SELECT * FROM songs WHERE song_id='$this->id'");
		$this->mysqliData = mysqli_fetch_array($query);
		$this->title = $this->mysqliData['title_name'];
		$this->artist_id = $this->mysqliData['artist_id'];
		$this->album_id = $this->mysqliData['album_id'];
		$this->genre_id = $this->mysqliData['genre_id'];
		$this->duration = $this->mysqliData['duration'];
		$this->path = $this->mysqliData['path'];
	}

	public function getTitle() {
		return $this->title;
	}

	public function getArtist() {
		return new Artist($this->con, $this->artist_id);
	}
	
	public function getAlbum() {
		return new Album($this->con, $this->album_id);
	}

	public function getGenre() {
		return $this->genre_id;
	}

	public function getPath() {
		return $this->path;
	}
	
	public function getDuration() {
		return $this->duration;
	}

	public function getMySqliData() {
		return $this->mysqliData;
	}
}
?>
