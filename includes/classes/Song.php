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
	private $playcount;
	private $path;

	public function __construct($con, $id) {
		$this->con = $con;
		$this->id = $id;

		$query = mysqli_query($this->con, "
			 SELECT song_id,
					title_name,
					artist_id,
					album_id,
					genre_id,
					CASE
						WHEN duration > 59 THEN TRIM(LEADING 0 FROM TIME_FORMAT(duration, '%i:%s')) 
						ELSE TIME_FORMAT(duration, '0:%s')
					END AS duration,
					song_path,
					album_order,
					play_count	
			   FROM songs 
					WHERE song_id='$this->id'");

		$this->mysqliData = mysqli_fetch_array($query);
		$this->title = $this->mysqliData['title_name'];
		$this->artist_id = $this->mysqliData['artist_id'];
		$this->album_id = $this->mysqliData['album_id'];
		$this->genre_id = $this->mysqliData['genre_id'];
		$this->duration = $this->mysqliData['duration'];
		$this->playcount = $this->mysqliData['play_count'];
		$this->path = $this->mysqliData['path'];
	}

	public function getId() {
		return $this->id;
	}

	public function getTitle() {
		return $this->title;
	}

	public function getArtist() {
		return new Artist($this->con, $this->artist_id);
	}
	public function getArtistId() {
		return $this->artist_id;
	}
	
	public function getAlbum() {
		return new Album($this->con, $this->album_id);
	}

	public function getAlbumName() {
		$query = mysqli_query($this->con, "
			 SELECT a.title_name
			   FROM albums as a 
					JOIN songs as s
					ON a.album_id='$this->album_id'");

		$result =  mysqli_fetch_array($query);
		return $result[0];
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

	public function getPlayCount() {
		return $this->playcount;
	}

	public function getMySqliData() {
		return $this->mysqliData;
	}
}
?>

