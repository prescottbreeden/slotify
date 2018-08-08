-- CREATE SCHEMA

CREATE SCHEMA IF NOT EXISTS slotify
				DEFAULT CHARACTER SET utf8;

USE slotify;

-- CREATE USERS TABLE

CREATE TABLE IF NOT EXISTS users (
	user_id			INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	username		VARCHAR(25)		NOT NULL,
	first_name		VARCHAR(25)		NOT NULL,
	last_name		VARCHAR(25)		NOT NULL,
	email			VARCHAR(200)	NOT NULL,
	password		VARCHAR(32)		NOT NULL,
	created_date	DATETIME		NOT NULL	DEFAULT NOW(),
	updated_date	DATETIME		NOT NULL	DEFAULT NOW() ON UPDATE NOW(),
	profile_pic		VARCHAR(500)
);

-- CREATE ARTISTS TABLE
CREATE TABLE IF NOT EXISTS artists (
	artist_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	name			VARCHAR(50)		NOT NULL
);

-- CREATE GENRE TABLE
CREATE TABLE IF NOT EXISTS genres (
	genre_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	name			VARCHAR(50)		NOT NULL
);

-- CREATE ALBUMS TABLE
CREATE TABLE IF NOT EXISTS albums (
	album_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	title_name		VARCHAR(250)	NOT NULL,
	artist_id		INTEGER			NOT NULL,
	genre_id		INTEGER			NOT NULL,
	artwork_path	VARCHAR(500)	NOT NULL,

	FOREIGN KEY (artist_id)
		REFERENCES artists(artist_id),
	FOREIGN KEY (genre_id)
		REFERENCES genres(genre_id)
);

-- CREATE SONGS TABLE
CREATE TABLE IF NOT EXISTS songs (
	song_id			INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	title_name		VARCHAR(250)	NOT NULL,
	artist_id		INTEGER			NOT NULL,
	album_id		INTEGER			NOT NULL,
	genre_id		INTEGER			NOT NULL,
	duration		VARCHAR(8)		NOT NULL,
	song_path		VARCHAR(500)	NOT NULL,
	album_order		INTEGER			NOT NULL,
	play_count		INTEGER			NOT NULL,

	FOREIGN KEY (artist_id)
		REFERENCES artists(artist_id),
	FOREIGN KEY (genre_id)
		REFERENCES genres(genre_id),
	FOREIGN KEY (album_id)
		REFERENCES albums(album_id)
);

--
-- Dumping data for table `artists`
--

 INSERT INTO artists 
			(name) 
		VALUES
			('Mickey Mouse'),
			('Goofy'),
			('Bart Simpson'),
			('Homer'),
			('Bruce Lee');

--
-- Dumping data for table `albums`
--

 INSERT INTO genres
			(name)
		VALUES
			('Rock'),
			('Pop'),
			('Hip-hop'),
			('Rap'),
			('R&B'),
			('Classical'),
			('Techno'),
			('Jazz'),
			('Folk'),
			('Country');

 INSERT INTO albums 
			(title_name, artist_id, genre_id, artwork_path) 
		VALUES
			('Bacon and Eggs', 2, 4, 'public/images/artwork/clearday.jpg'),
			('Pizza head', 5, 10, 'public/images/artwork/energy.jpg'),
			('Summer Hits', 3, 1, 'public/images/artwork/goinghigher.jpg'),
			('The movie soundtrack', 2, 9, 'public/images/artwork/funkyelement.jpg'),
			('Best of the Worst', 1, 3, 'public/images/artwork/popdance.jpg'),
			('Hello World', 3, 6, 'public/images/artwork/ukulele.jpg'),
			('Best beats', 4, 7, 'public/images/artwork/sweet.jpg');

--
-- Dumping data for table `Songs`
--

 INSERT INTO songs 
			(title_name, artist_id, album_id, genre_id, duration, song_path, album_order, play_count) 
		VALUES
			('Acoustic Breeze', 1, 5, 8, '2:37', 'public/music/bensound-acousticbreeze.mp3', 1, 0),
			('A new beginning', 1, 5, 1, '2:35', 'public/music/bensound-anewbeginning.mp3', 2, 0),
			('Better Days', 1, 5, 2, '2:33', 'public/music/bensound-betterdays.mp3', 3, 0),
			('Buddy', 1, 5, 3, '2:02', 'public/music/bensound-buddy.mp3', 4, 0),
			('Clear Day', 1, 5, 4, '1:29', 'public/music/bensound-clearday.mp3', 5, 0),
			('Going Higher', 2, 1, 1, '4:04', 'public/music/bensound-goinghigher.mp3', 1, 0),
			('Funny Song', 2, 4, 2, '3:07', 'public/music/bensound-funnysong.mp3', 2, 0),
			('Funky Element', 2, 1, 3, '3:08', 'public/music/bensound-funkyelement.mp3', 2, 0),
			('Extreme Action', 2, 1, 4, '8:03', 'public/music/bensound-extremeaction.mp3', 3, 0),
			('Epic', 2, 4, 5, '2:58', 'public/music/bensound-epic.mp3', 3, 0),
			('Energy', 2, 1, 6, '2:59', 'public/music/bensound-energy.mp3', 4, 0),
			('Dubstep', 2, 1, 7, '2:03', 'public/music/bensound-dubstep.mp3', 5, 0),
			('Happiness', 3, 6, 8, '4:21', 'public/music/bensound-happiness.mp3', 5, 0),
			('Happy Rock', 3, 6, 9, '1:45', 'public/music/bensound-happyrock.mp3', 4, 0),
			('Jazzy Frenchy', 3, 6, 10, '1:44', 'public/music/bensound-jazzyfrenchy.mp3', 3, 0),
			('Little Idea', 3, 6, 1, '2:49', 'public/music/bensound-littleidea.mp3', 2, 0),
			('Memories', 3, 6, 2, '3:50', 'public/music/bensound-memories.mp3', 1, 0),
			('Moose', 4, 7, 1, '2:43', 'public/music/bensound-moose.mp3', 5, 0),
			('November', 4, 7, 2, '3:32', 'public/music/bensound-november.mp3', 4, 0),
			('Of Elias Dream', 4, 7, 3, '4:58', 'public/music/bensound-ofeliasdream.mp3', 3, 0),
			('Pop Dance', 4, 7, 2, '2:42', 'public/music/bensound-popdance.mp3', 2, 0),
			('Retro Soul', 4, 7, 5, '3:36', 'public/music/bensound-retrosoul.mp3', 1, 0),
			('Sad Day', 5, 2, 1, '2:28', 'public/music/bensound-sadday.mp3', 1, 0),
			('Sci-fi', 5, 2, 2, '4:44', 'public/music/bensound-scifi.mp3', 2, 0),
			('Slow Motion', 5, 2, 3, '3:26', 'public/music/bensound-slowmotion.mp3', 3, 0),
			('Sunny', 5, 2, 4, '2:20', 'public/music/bensound-sunny.mp3', 4, 0),
			('Sweet', 5, 2, 5, '5:07', 'public/music/bensound-sweet.mp3', 5, 0),
			('Tenderness ', 3, 3, 7, '2:03', 'public/music/bensound-tenderness.mp3', 4, 0),
			('The Lounge', 3, 3, 8, '4:16', 'public/music/bensound-thelounge.mp3 ', 3, 0),
			('Ukulele', 3, 3, 9, '2:26', 'public/music/bensound-ukulele.mp3 ', 2, 0),
			('Tomorrow', 3, 3, 1, '4:54', 'public/music/bensound-tomorrow.mp3 ', 1, 0);

