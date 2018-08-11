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
			('Koji Kondo'),
			('Nobuo Uematsu'),
			('Mahito Yokota'),
			('Takashi Tateishi'),
			('Hirokazu Tanaka')
			;

--
-- Dumping data for table `albums`
--

 INSERT INTO genres
			(name)
		VALUES
			('NES'),
			('SNES'),
			('OST'),
			('Play Station');

 INSERT INTO albums 
			(title_name, artist_id, genre_id, artwork_path) 
		VALUES
			('The Legend of Zelda', 1, 1, 'public/images/artwork/zelda.jpg'),
			('Mega Man 2', 2, 1, 'public/images/artwork/megaman2.jpg'),
			('Punch Out', 1, 1, 'public/images/artwork/punchout.jpg'),
			('Metroid', 5, 1, 'public/images/artwork/metroid.jpg')
			
			
			;

--
-- Dumping data for table `Songs`
--

 INSERT INTO songs 
			(title_name, artist_id, album_id, genre_id, duration, song_path, album_order, play_count) 
		VALUES
			('Title Theme', 1, 1, 1, '3:00', 'public/music/zelda_1_title_theme.mp3', 1, 0),
			('Menu Theme', 1, 1, 1, '3:01', 'public/music/zelda_2_menu_theme.mp3', 2, 0),
			('Overworld Theme', 1, 1, 1, '3:00', 'public/music/zelda_3_overworld_theme.mp3', 3, 0),
			('Dungeon Theme', 1, 1, 1, '3:00', 'public/music/zelda_4_dungeon_theme.mp3', 4, 0),
			('Dungeon Clear', 1, 1, 1, '0:09', 'public/music/zelda_5_dungeon_clear.mp3', 5, 0),
			('Receive Item', 1, 1, 1, '0:03', 'public/music/zelda_6_receive_item.mp3', 6, 0),
			('Recorder Theme', 1, 1, 1, '0:04', 'public/music/zelda_7_recorder_theme.mp3', 7, 0),
			('Life Lost', 1, 1, 1, '0:04', 'public/music/zelda_8_life_lost.mp3', 8, 0),
			('Rescued', 1, 1, 1, '0:06', 'public/music/zelda_9_rescued.mp3', 9, 0),
			('Ganon Dungeon', 1, 1, 1, '3:00', 'public/music/zelda_10_ganon_dungeon.mp3', 10, 0),
			('Ganon Defeated', 1, 1, 1, '0:04', 'public/music/zelda_11_ganon_defeated.mp3', 11, 0),
			('Ending Theme', 1, 1, 1, '3:00', 'public/music/zelda_12_ending_theme.mp3', 12, 0),

			('Introduction', 4, 2, 1, '0:43', 'public/music/megaman2_1_introduction.mp3', 1, 0),
			('Title Screen', 4, 2, 1, '0:44', 'public/music/megaman2_2_title_screen.mp3', 2, 0),
			('Password Screen', 4, 2, 1, '0:34', 'public/music/megaman2_3_password_screen.mp3', 3, 0),
			('Stage Select', 4, 2, 1, '0:32', 'public/music/megaman2_4_stage_select.mp3', 4, 0),
			('Enemy Chosen', 4, 2, 1, '0:08', 'public/music/megaman2_5_enemy_chosen.mp3', 5, 0),
			('Quick Man', 4, 2, 1, '1:25', 'public/music/megaman2_6_quick_man.mp3', 6, 0),
			('Metal Man', 4, 2, 1, '1:27', 'public/music/megaman2_7_metal_man.mp3', 7, 0),
			('Bubble Man', 4, 2, 1, '1:23', 'public/music/megaman2_8_bubble_man.mp3', 8, 0),
			('Heat Man', 4, 2, 1, '1:01', 'public/music/megaman2_9_heat_man.mp3', 9, 0),
			('Wood Man', 4, 2, 1, '1:21', 'public/music/megaman2_10_wood_man.mp3', 10, 0),
			('Air Man', 4, 2, 1, '1:40', 'public/music/megaman2_11_air_man.mp3', 11, 0),
			('Crash Man', 4, 2, 1, '2:37', 'public/music/megaman2_12_crash_man.mp3', 12, 0),
			('Flash Man', 4, 2, 1, '2:37', 'public/music/megaman2_13_flash_man.mp3', 13, 0),
			('Boss Battle', 4, 2, 1, '2:37', 'public/music/megaman2_14_boss_battle.mp3', 14, 0),
			('Victory', 4, 2, 1, '2:37', 'public/music/megaman2_15_victory.mp3', 15, 0),
			('Weapons Ready', 4, 2, 1, '2:37', 'public/music/megaman2_16_weapons_ready.mp3', 16, 0),
			('Dr Wily\'s Map', 4, 2, 1, '2:37', 'public/music/megaman2_17_wilys_map.mp3', 17, 0),
			('Dr Wily\'s Castle', 4, 2, 1, '2:37', 'public/music/megaman2_18_wilys_castle.mp3', 18, 0),
			('Dr Wily\'s Castle2', 4, 2, 1, '2:37', 'public/music/megaman2_19_wilys_castle2.mp3', 19, 0),
			('Dr Wily Defeated', 4, 2, 1, '2:37', 'public/music/megaman2_20_wily_defeated.mp3', 20, 0),
			('Epilogue', 4, 2, 1, '2:37', 'public/music/megaman2_21_epilogue.mp3', 21, 0),
			('Credits', 4, 2, 1, '2:37', 'public/music/megaman2_22_credits.mp3', 22, 0),
			('Game Over', 4, 2, 1, '2:37', 'public/music/megaman2_23_game_over.mp3', 23, 0),

			('Fight Theme', 1, 3, 1, '3:00', 'public/music/punch_out_fight_theme.m4a', 1, 0)


			
			
			
			
			
			;
