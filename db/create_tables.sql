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
	year_released	INTEGER			NOT NULL,
	game_platform	VARCHAR(20)		NOT NULL,

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
	duration		TIME			NOT NULL,
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

CREATE TABLE IF NOT EXISTS playlists (
	playlist_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	name			VARCHAR(50)		NOT NULL,
	user_id			INTEGER			NOT NULL,
	created_at		DATETIME		NOT NULL	DEFAULT NOW(),
	updated_at		DATETIME		NOT NULL	DEFAULT NOW() ON UPDATE NOW(),

	FOREIGN KEY (user_id)
		REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS pl_songs (
	pl_song_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	song_id			INTEGER			NOT NULL,
	playlist_id		INTEGER			NOT NULL,
	playlist_order	INTEGER			NOT NULL,

	FOREIGN KEY (song_id)
		REFERENCES songs(song_id),
	FOREIGN KEY (playlist_id)
		REFERENCES playlists(playlist_id)
);

--
-- Dumping data for table `artists`
--

 INSERT INTO artists 
			(name) 
		VALUES
			('Koji Kondo'),
			('Takashi Tateishi'),
			('Hirokazu Tanaka'),
			('Konami Kukeiha Club'),
			('Nobuo Uematsu')

			;

--
-- Dumping data for table `albums`
--

 INSERT INTO genres
			(name)
		VALUES
			('OST'),
			('Remix'),
			('Orchestration');

 INSERT INTO albums 
			(year_released, game_platform, title_name, artist_id, genre_id, artwork_path) 
		VALUES
			(1986, 'NES', 'The Legend of Zelda', 1, 1, 'public/images/artwork/zelda.jpg'),
			(1988, 'NES', 'Mega Man 2', 2, 1, 'public/images/artwork/megaman2.jpg'),
			(1987, 'NES', 'Punch Out', 1, 1, 'public/images/artwork/punchout.jpg'),
			(1986, 'NES', 'Metroid', 3, 1, 'public/images/artwork/metroid.jpg'),
			(1987, 'NES', 'Contra', 4, 1, 'public/images/artwork/contra.jpg')
			
			;

--
-- Dumping data for table `Songs`
--

 INSERT INTO songs 
			(title_name, artist_id, album_id, genre_id, duration, song_path, album_order, play_count) 
		VALUES
			('Title Theme', 1, 1, 1, '300', 'public/music/nes_zelda/zelda_1_title_theme.mp3', 1, 0),
			('Menu Theme', 1, 1, 1, '301', 'public/music/nes_zelda/zelda_2_menu_theme.mp3', 2, 0),
			('Overworld Theme', 1, 1, 1, '300', 'public/music/nes_zelda/zelda_3_overworld_theme.mp3', 3, 0),
			('Dungeon Theme', 1, 1, 1, '300', 'public/music/nes_zelda/zelda_4_dungeon_theme.mp3', 4, 0),
			('Dungeon Clear', 1, 1, 1, '9', 'public/music/nes_zelda/zelda_5_dungeon_clear.mp3', 5, 0),
			('Receive Item', 1, 1, 1, '3', 'public/music/nes_zelda/zelda_6_receive_item.mp3', 6, 0),
			('Recorder Theme', 1, 1, 1, '4', 'public/music/nes_zelda/zelda_7_recorder_theme.mp3', 7, 0),
			('Life Lost', 1, 1, 1, '4', 'public/music/nes_zelda/zelda_8_life_lost.mp3', 8, 0),
			('Rescued', 1, 1, 1, '6', 'public/music/nes_zelda/zelda_9_rescued.mp3', 9, 0),
			('Ganon Dungeon', 1, 1, 1, '300', 'public/music/nes_zelda/zelda_10_ganon_dungeon.mp3', 10, 0),
			('Ganon Defeated', 1, 1, 1, '4', 'public/music/nes_zelda/zelda_11_ganon_defeated.mp3', 11, 0),
			('Ending Theme', 1, 1, 1, '300', 'public/music/nes_zelda/zelda_12_ending_theme.mp3', 12, 0),

			('Introduction', 2, 2, 1, '43', 'public/music/nes_megaman2/megaman2_1_introduction.mp3', 1, 0),
			('Title Screen', 2, 2, 1, '44', 'public/music/nes_megaman2/megaman2_2_title_screen.mp3', 2, 0),
			('Password Screen', 2, 2, 1, '34', 'public/music/nes_megaman2/megaman2_3_password_screen.mp3', 3, 0),
			('Stage Select', 2, 2, 1, '32', 'public/music/nes_megaman2/megaman2_4_stage_select.mp3', 4, 0),
			('Enemy Chosen', 2, 2, 1, '8', 'public/music/nes_megaman2/megaman2_5_enemy_chosen.mp3', 5, 0),
			('Quick Man', 2, 2, 1, '125', 'public/music/nes_megaman2/megaman2_6_quick_man.mp3', 6, 0),
			('Metal Man', 2, 2, 1, '127', 'public/music/nes_megaman2/megaman2_7_metal_man.mp3', 7, 0),
			('Bubble Man', 2, 2, 1, '123', 'public/music/nes_megaman2/megaman2_8_bubble_man.mp3', 8, 0),
			('Heat Man', 2, 2, 1, '11', 'public/music/nes_megaman2/megaman2_9_heat_man.mp3', 9, 0),
			('Wood Man', 2, 2, 1, '121', 'public/music/nes_megaman2/megaman2_10_wood_man.mp3', 10, 0),
			('Air Man', 2, 2, 1, '140', 'public/music/nes_megaman2/megaman2_11_air_man.mp3', 11, 0),
			('Crash Man', 2, 2, 1, '230', 'public/music/nes_megaman2/megaman2_12_crash_man.mp3', 12, 0),
			('Flash Man', 2, 2, 1, '217', 'public/music/nes_megaman2/megaman2_13_flash_man.mp3', 13, 0),
			('Boss Battle', 2, 2, 1, '42', 'public/music/nes_megaman2/megaman2_14_boss_battle.mp3', 14, 0),
			('Victory', 2, 2, 1, '207', 'public/music/nes_megaman2/megaman2_15_victory.mp3', 15, 0),
			('Weapons Ready', 2, 2, 1, '30', 'public/music/nes_megaman2/megaman2_16_weapons_ready.mp3', 16, 0),
			('Dr Wily\'s Map', 2, 2, 1, '9', 'public/music/nes_megaman2/megaman2_17_wilys_map.mp3', 17, 0),
			('Dr Wily\'s Castle', 2, 2, 1, '238', 'public/music/nes_megaman2/megaman2_18_wilys_castle.mp3', 18, 0),
			('Dr Wily\'s Castle2', 2, 2, 1, '244', 'public/music/nes_megaman2/megaman2_19_wilys_castle2.mp3', 19, 0),
			('Dr Wily Defeated', 2, 2, 1, '11', 'public/music/nes_megaman2/megaman2_20_wily_defeated.mp3', 20, 0),
			('Epilogue', 2, 2, 1, '110', 'public/music/nes_megaman2/megaman2_21_epilogue.mp3', 21, 0),
			('Credits', 2, 2, 1, '107', 'public/music/nes_megaman2/megaman2_22_credits.mp3', 22, 0),
			('Game Over', 2, 2, 1, '6', 'public/music/nes_megaman2/megaman2_23_game_over.mp3', 23, 0),

			('Fight Theme', 1, 3, 1, '300', 'public/music/nes_punchout/punch_out_fight_theme.m4a', 1, 0),

			('Title', 3, 4, 1, '150', 'public/music/nes_metroid/metroid_1_title.mp3', 1, 0),
			('Samus Entry', 3, 4, 1, '7', 'public/music/nes_metroid/metroid_2_samus_entry.mp3', 2, 0),
			('Brinstar (Rock Stage)', 3, 4, 1, '146', 'public/music/nes_metroid/metroid_3_brinstar_rock_stage.mp3', 3, 0),
			('Mini Boss Room I - Kraid', 3, 4, 1, '140', 'public/music/nes_metroid/metroid_4_mini_boss_room1_kraid.mp3', 4, 0),
			('Norfair (Flame Stage)', 3, 4, 1, '120', 'public/music/nes_metroid/metroid_5_norfair_flame_stage.mp3', 5, 0),
			('Mini Boss Room II - Ridley', 3, 4, 1, '101', 'public/music/nes_metroid/metroid_6_mini_boss_room2_ridley.mp3', 6, 0),
			('Silence', 3, 4, 1, '29', 'public/music/nes_metroid/metroid_7_silence.mp3', 7, 0),
			('Item Acquisition Jingle', 3, 4, 1, '6', 'public/music/nes_metroid/metroid_8_item_acquisition_jingle.mp3', 8, 0),
			('Tourian (Base Stage)', 3, 4, 1, '34', 'public/music/nes_metroid/metroid_9_tourian_base_stage.mp3', 9, 0),
			('The Lord of Zebes', 3, 4, 1, '34', 'public/music/nes_metroid/metroid_10_the_lord_of_zebes.mp3', 10, 0),
			('Escape', 3, 4, 1, '127', 'public/music/nes_metroid/metroid_11_escape.mp3', 11, 0),
			('Ending', 3, 4, 1, '216', 'public/music/nes_metroid/metroid_12_ending.mp3', 12, 0),

			('Title', 4, 5, 1, '7', 'public/music/nes_contra/contra_1_title.mp3', 1, 0),
			('Introduction', 4, 5, 1, '105', 'public/music/nes_contra/contra_2_introduction.mp3', 2, 0),
			('Area 1: Jungle / Area 7: Hanger', 4, 5, 1, '151', 'public/music/nes_contra/contra_3_jungle_hanger.mp3', 3, 0),
			('Area Clear', 4, 5, 1, '6', 'public/music/nes_contra/contra_4_area_clear.mp3', 4, 0),
			('Areas 2 & 4: Bases 1 & 2', 4, 5, 1, '139', 'public/music/nes_contra/contra_5_areas_2_4_bases_1_2.mp3', 5, 0),
			('Boss', 4, 5, 1, '120', 'public/music/nes_contra/contra_6_boss.mp3', 6, 0),
			('Area 3: Waterfall', 4, 5, 1, '123', 'public/music/nes_contra/contra_7_area_3_waterfall.mp3', 7, 0),
			('Area 5: Snow Field', 4, 5, 1, '117', 'public/music/nes_contra/contra_8_area_5_snow_field.mp3', 8, 0),
			('Area 6: Energy Zone', 4, 5, 1, '54', 'public/music/nes_contra/contra_9_area_6_energy_zone.mp3', 9, 0),
			('Area 8: Alien\'s Lair', 4, 5, 1, '107', 'public/music/nes_contra/contra_10_area_8_aliens_lair.mp3', 10, 0),
			('Area 8: Alen Dead', 4, 5, 1, '10', 'public/music/nes_contra/contra_11_area_8_alien_dead.mp3', 11, 0),
			('Credit', 4, 5, 1, '125', 'public/music/nes_contra/contra_12_credit.mp3', 12, 0),
			('Game Over', 4, 5, 1, '7', 'public/music/nes_contra/contra_13_game_over.mp3', 13, 0)

			
			;
