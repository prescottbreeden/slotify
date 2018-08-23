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
	lp_album		INTEGER			NOT NULL	DEFAULT 1,
	lp_album_order	INTEGER			NOT NULL	DEFAULT 1,
	created_date	DATETIME		NOT NULL	DEFAULT NOW(),
	updated_date	DATETIME		NOT NULL	DEFAULT NOW() ON UPDATE NOW(),
	profile_pic		VARCHAR(500)
);


-- CREATE GENRE TABLE
CREATE TABLE IF NOT EXISTS genres (
	genre_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	name			VARCHAR(50)		NOT NULL
);

-- CREATE ARTISTS TABLE
CREATE TABLE IF NOT EXISTS artists (
	artist_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	name			VARCHAR(50)		NOT NULL
);

-- CREATE ALBUMS TABLE
CREATE TABLE IF NOT EXISTS albums (
	album_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	title_name		VARCHAR(250)	NOT NULL,
	genre_id		INTEGER			NOT NULL,
	artwork_path	VARCHAR(500)	NOT NULL,
	year_released	INTEGER			NOT NULL,
	game_platform	VARCHAR(20)		NOT NULL,

	FOREIGN KEY (genre_id)
		REFERENCES genres(genre_id)
);


-- CREATE SONGS TABLE
CREATE TABLE IF NOT EXISTS songs (
	song_id			INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
	title_name		VARCHAR(250)	NOT NULL,
	artist_id		INTEGER			NOT NULL,
	album_id		INTEGER			NOT NULL,
	duration		TIME			NOT NULL,
	song_path		VARCHAR(500)	NOT NULL,
	album_order		INTEGER			NOT NULL,
	play_count		INTEGER			NOT NULL	DEFAULT 0,

	FOREIGN KEY (artist_id)
		REFERENCES artists(artist_id),
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

CREATE TABLE IF NOT EXISTS saved_albums (
	user_id			INTEGER			NOT NULL,
	album_id		INTEGER			NOT NULL,
	created_at		DATETIME		NOT NULL	DEFAULT NOW(),

	FOREIGN KEY (user_id)
		REFERENCES users(user_id),
	FOREIGN KEY (album_id)
		REFERENCES albums(album_id)
);

CREATE TABLE IF NOT EXISTS saved_songs (
	user_id			INTEGER			NOT NULL,
	song_id			INTEGER			NOT NULL,
	created_at		DATETIME		NOT NULL	DEFAULT NOW(),

	FOREIGN KEY (user_id)
		REFERENCES users(user_id),
	FOREIGN KEY (song_id)
		REFERENCES songs(song_id)
);

-- CREATE ARTISTS TABLE
CREATE TABLE IF NOT EXISTS album_artists (
	album_id		INTEGER			NOT NULL,
	artist_id		INTEGER			NOT NULL,

	FOREIGN KEY (album_id)
		REFERENCES albums(album_id),
	FOREIGN KEY (artist_id)
		REFERENCES artists(artist_id)
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
			('Nobuo Uematsu'),
			('Yoko Shimomura'),
			('Isao Abe')
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
			(year_released, game_platform, title_name, genre_id, artwork_path) 
	 VALUES
			(1986, 'NES', 'The Legend of Zelda', 1, 'public/images/artwork/zelda.jpg'),
			(1987, 'NES', 'Punch Out', 1, 'public/images/artwork/punchout.jpg'),
			(1988, 'NES', 'Mega Man 2', 1, 'public/images/artwork/megaman2.jpg'),
			(1986, 'NES', 'Metroid', 1, 'public/images/artwork/metroid.jpg'),
			(1987, 'NES', 'Contra', 1, 'public/images/artwork/contra.jpg'),
			(1985, 'NES', 'Super Mario Bros.', 1, 'public/images/artwork/supermariobros.jpg'),

			(1991, 'SNES', 'Final Fantasy 4', 1, 'public/images/artwork/finalfantasy4.jpg'),
			(1991, 'SNES', 'Street Fighter 2', 1, 'public/images/artwork/streetfighter2.jpg')
			;

--
-- Dumping data for table `album_artists`
--

INSERT INTO album_artists 
			(album_id, artist_id) 
	 VALUES
			(1, 1),
			(2, 1),
			(3, 1),
			(4, 2),
			(5, 3),
			(6, 4),
			(7, 5),
			(8, 6),
			(8, 7)
			;

--
-- Dumping data for table `Songs`
--

INSERT INTO songs 
			(title_name, artist_id, album_id, duration, song_path, album_order)
	 VALUES
			('Title Theme', 1, 1, '300', 'public/music/nes_zelda/zelda_1_title_theme.mp3', 1),
			('Menu Theme', 1, 1, '301', 'public/music/nes_zelda/zelda_2_menu_theme.mp3', 2),
			('Overworld Theme', 1, 1, '300', 'public/music/nes_zelda/zelda_3_overworld_theme.mp3', 3),
			('Dungeon Theme', 1, 1, '300', 'public/music/nes_zelda/zelda_4_dungeon_theme.mp3', 4),
			('Dungeon Clear', 1, 1, '9', 'public/music/nes_zelda/zelda_5_dungeon_clear.mp3', 5),
			('Receive Item', 1, 1, '3', 'public/music/nes_zelda/zelda_6_receive_item.mp3', 6),
			('Recorder Theme', 1, 1, '4', 'public/music/nes_zelda/zelda_7_recorder_theme.mp3', 7),
			('Life Lost', 1, 1, '4', 'public/music/nes_zelda/zelda_8_life_lost.mp3', 8),
			('Rescued', 1, 1, '6', 'public/music/nes_zelda/zelda_9_rescued.mp3', 9),
			('Ganon Dungeon', 1, 1, '300', 'public/music/nes_zelda/zelda_10_ganon_dungeon.mp3', 10),
			('Ganon Defeated', 1, 1, '4', 'public/music/nes_zelda/zelda_11_ganon_defeated.mp3', 11),
			('Ending Theme', 1, 1, '300', 'public/music/nes_zelda/zelda_12_ending_theme.mp3', 12),

			('Introduction', 2, 2, '43', 'public/music/nes_megaman2/megaman2_1_introduction.mp3', 1),
			('Title Screen', 2, 2, '44', 'public/music/nes_megaman2/megaman2_2_title_screen.mp3', 2),
			('Password Screen', 2, 2, '34', 'public/music/nes_megaman2/megaman2_3_password_screen.mp3', 3),
			('Stage Select', 2, 2, '32', 'public/music/nes_megaman2/megaman2_4_stage_select.mp3', 4),
			('Enemy Chosen', 2, 2, '8', 'public/music/nes_megaman2/megaman2_5_enemy_chosen.mp3', 5),
			('Quick Man', 2, 2, '125', 'public/music/nes_megaman2/megaman2_6_quick_man.mp3', 6),
			('Metal Man', 2, 2, '127', 'public/music/nes_megaman2/megaman2_7_metal_man.mp3', 7),
			('Bubble Man', 2, 2, '123', 'public/music/nes_megaman2/megaman2_8_bubble_man.mp3', 8),
			('Heat Man', 2, 2, '101', 'public/music/nes_megaman2/megaman2_9_heat_man.mp3', 9),
			('Wood Man', 2, 2, '121', 'public/music/nes_megaman2/megaman2_10_wood_man.mp3', 10),
			('Air Man', 2, 2, '140', 'public/music/nes_megaman2/megaman2_11_air_man.mp3', 11),
			('Crash Man', 2, 2, '230', 'public/music/nes_megaman2/megaman2_12_crash_man.mp3', 12),
			('Flash Man', 2, 2, '217', 'public/music/nes_megaman2/megaman2_13_flash_man.mp3', 13),
			('Boss Battle', 2, 2, '42', 'public/music/nes_megaman2/megaman2_14_boss_battle.mp3', 14),
			('Victory', 2, 2, '207', 'public/music/nes_megaman2/megaman2_15_victory.mp3', 15),
			('Weapons Ready', 2, 2, '30', 'public/music/nes_megaman2/megaman2_16_weapons_ready.mp3', 16),
			('Dr Wily\'s Map', 2, 2, '9', 'public/music/nes_megaman2/megaman2_17_wilys_map.mp3', 17),
			('Dr Wily\'s Castle', 2, 2, '238', 'public/music/nes_megaman2/megaman2_18_wilys_castle.mp3', 18),
			('Dr Wily\'s Castle2', 2, 2, '244', 'public/music/nes_megaman2/megaman2_19_wilys_castle2.mp3', 19),
			('Dr Wily Defeated', 2, 2, '11', 'public/music/nes_megaman2/megaman2_20_wily_defeated.mp3', 20),
			('Epilogue', 2, 2, '110', 'public/music/nes_megaman2/megaman2_21_epilogue.mp3', 21),
			('Credits', 2, 2, '107', 'public/music/nes_megaman2/megaman2_22_credits.mp3', 22),
			('Game Over', 2, 2, '6', 'public/music/nes_megaman2/megaman2_23_game_over.mp3', 23),

			('Fight Theme', 1, 3, '300', 'public/music/nes_punchout/punch_out_fight_theme.mp3', 1),

			('Title', 3, 4, '150', 'public/music/nes_metroid/metroid_1_title.mp3', 1),
			('Samus Entry', 3, 4, '7', 'public/music/nes_metroid/metroid_2_samus_entry.mp3', 2),
			('Brinstar (Rock Stage)', 3, 4, '146', 'public/music/nes_metroid/metroid_3_brinstar_rock_stage.mp3', 3),
			('Mini Boss Room I - Kraid', 3, 4, '140', 'public/music/nes_metroid/metroid_4_mini_boss_room1_kraid.mp3', 4),
			('Norfair (Flame Stage)', 3, 4, '120', 'public/music/nes_metroid/metroid_5_norfair_flame_stage.mp3', 5),
			('Mini Boss Room II - Ridley', 3, 4, '101', 'public/music/nes_metroid/metroid_6_mini_boss_room2_ridley.mp3', 6),
			('Silence', 3, 4, '29', 'public/music/nes_metroid/metroid_7_silence.mp3', 7),
			('Item Acquisition Jingle', 3, 4, '6', 'public/music/nes_metroid/metroid_8_item_acquisition_jingle.mp3', 8),
			('Tourian (Base Stage)', 3, 4, '34', 'public/music/nes_metroid/metroid_9_tourian_base_stage.mp3', 9),
			('The Lord of Zebes', 3, 4, '34', 'public/music/nes_metroid/metroid_10_the_lord_of_zebes.mp3', 10),
			('Escape', 3, 4, '127', 'public/music/nes_metroid/metroid_11_escape.mp3', 11),
			('Ending', 3, 4, '216', 'public/music/nes_metroid/metroid_12_ending.mp3', 12),

			('Title', 4, 5, '7', 'public/music/nes_contra/contra_1_title.mp3', 1),
			('Introduction', 4, 5, '105', 'public/music/nes_contra/contra_2_introduction.mp3', 2),
			('Area 1: Jungle / Area 7: Hanger', 4, 5, '151', 'public/music/nes_contra/contra_3_jungle_hanger.mp3', 3),
			('Area Clear', 4, 5, '6', 'public/music/nes_contra/contra_4_area_clear.mp3', 4),
			('Areas 2 & 4: Bases 1 & 2', 4, 5, '139', 'public/music/nes_contra/contra_5_areas_2_4_bases_1_2.mp3', 5),
			('Boss', 4, 5, '120', 'public/music/nes_contra/contra_6_boss.mp3', 6),
			('Area 3: Waterfall', 4, 5, '123', 'public/music/nes_contra/contra_7_area_3_waterfall.mp3', 7),
			('Area 5: Snow Field', 4, 5, '117', 'public/music/nes_contra/contra_8_area_5_snow_field.mp3', 8),
			('Area 6: Energy Zone', 4, 5, '54', 'public/music/nes_contra/contra_9_area_6_energy_zone.mp3', 9),
			('Area 8: Alien\'s Lair', 4, 5, '107', 'public/music/nes_contra/contra_10_area_8_aliens_lair.mp3', 10),
			('Area 8: Alen Dead', 4, 5, '10', 'public/music/nes_contra/contra_11_area_8_alien_dead.mp3', 11),
			('Credit', 4, 5, '125', 'public/music/nes_contra/contra_12_credit.mp3', 12),
			('Game Over', 4, 5, '7', 'public/music/nes_contra/contra_13_game_over.mp3', 13),

			('Overworld Theme', 1, 6, '304', 'public/music/nes_supermariobros/supermariobros_1_overworld_theme.mp3', 1),
			('Underworld Theme', 1, 6, '113', 'public/music/nes_supermariobros/supermariobros_2_underworld_theme.mp3', 2),
			('Underwater Theme', 1, 6, '200', 'public/music/nes_supermariobros/supermariobros_3_underwater_theme.mp3', 3),
			('Castle Theme', 1, 6, '109', 'public/music/nes_supermariobros/supermariobros_4_castle_theme.mp3', 4),
			('Starman Theme', 1, 6, '114', 'public/music/nes_supermariobros/supermariobros_5_starman_theme.mp3', 5),
			('Level Clear Fanfare', 1, 6, '8', 'public/music/nes_supermariobros/supermariobros_6_level_clear_fanfare.mp3', 6),
			('Castle Clear Fanfare', 1, 6, '9', 'public/music/nes_supermariobros/supermariobros_7_castle_clear_theme.mp3', 7),
			('You\'re Dead Theme', 1, 6, '6', 'public/music/nes_supermariobros/supermariobros_8_youre_dead.mp3', 8),
			('Game Over Theme', 1, 6, '7', 'public/music/nes_supermariobros/supermariobros_9_game_over.mp3', 9),
			('Game Over2 Theme', 1, 6, '6', 'public/music/nes_supermariobros/supermariobros_10_game_over2.mp3', 10),
			('Into the Tunnel Theme', 1, 6, '5', 'public/music/nes_supermariobros/supermariobros_11_into_tunnel.mp3', 11),
			('Hurry Fanfare', 1, 6, '3', 'public/music/nes_supermariobros/supermariobros_12_hurry_fanfare.mp3', 12),
			('Hurry Overworld Theme', 1, 6, '210', 'public/music/nes_supermariobros/supermariobros_13_hurry_overworld.mp3', 13),
			('Hurry Underworld Theme', 1, 6, '114', 'public/music/nes_supermariobros/supermariobros_14_hurry_underworld.mp3', 14),
			('Hurry Castle Theme', 1, 6, '112', 'public/music/nes_supermariobros/supermariobros_15_hurry_castle.mp3', 15),
			('Ending Fanfare', 1, 6, '117', 'public/music/nes_supermariobros/supermariobros_16_ending_fanfare.mp3', 16),
			
			('Prelude', 5, 7, '112', 'public/music/snes_finalfantasy4/ff4_1_prelude.mp3', 1),
			('Red Wings', 5, 7, '206', 'public/music/snes_finalfantasy4/ff4_2_red_wings.mp3', 2),
			('Kingdom of Baron', 5, 7, '109', 'public/music/snes_finalfantasy4/ff4_3_kingdom_baron.mp3', 3),
			('Love Theme', 5, 7, '149', 'public/music/snes_finalfantasy4/ff4_4_love_theme.mp3', 4),
			('Prologue', 5, 7, '111', 'public/music/snes_finalfantasy4/ff4_5_prologue.mp3', 5),
			('Welcome to Our Town', 5, 7, '049', 'public/music/snes_finalfantasy4/ff4_6_welcome_town.mp3', 6),
			('Main Theme', 5, 7, '133', 'public/music/snes_finalfantasy4/ff4_7_main_theme.mp3', 7),
			('Fight 1', 5, 7, '100', 'public/music/snes_finalfantasy4/ff4_8_fight1.mp3', 8),
			('Fanfare', 5, 7, '026', 'public/music/snes_finalfantasy4/ff4_9_fanfare.mp3', 9),
			('Hello, Big Chocobo', 5, 7, '26', 'public/music/snes_finalfantasy4/ff4_10_hello_big_chocobo.mp3', 10),
			('Chocobo, Chocobo', 5, 7, '29', 'public/music/snes_finalfantasy4/ff4_11_chocobo_chocobo.mp3', 11),
			('Into the Darkness', 5, 7, '121', 'public/music/snes_finalfantasy4/ff4_12_into_darkness.mp3', 12),
			('Fight 2', 5, 7, '114', 'public/music/snes_finalfantasy4/ff4_13_fight2.mp3', 13),
			('Ring of Bombs', 5, 7, '52', 'public/music/snes_finalfantasy4/ff4_14_ring_of_bomb.mp3', 14),
			('Rydia', 5, 7, '101', 'public/music/snes_finalfantasy4/ff4_15_rydia.mp3', 15),
			('Castle Damcyan', 5, 7, '104', 'public/music/snes_finalfantasy4/ff4_16_castle_damcyan.mp3', 16),
			('Cry in Sorrow', 5, 7, '100', 'public/music/snes_finalfantasy4/ff4_17_cry_in_sorrow.mp3', 17),
			('Melody of the Lute', 5, 7, '55', 'public/music/snes_finalfantasy4/ff4_18_melody_of_lute.mp3', 18),
			('Mt Ordeals', 5, 7, '118', 'public/music/snes_finalfantasy4/ff4_19_mt_ordeals.mp3', 19),
			('Fabul', 5, 7, '135', 'public/music/snes_finalfantasy4/ff4_20_fabul.mp3', 20),
			('Run', 5, 7, '25', 'public/music/snes_finalfantasy4/ff4_21_run.mp3', 21),
			('Suspicion', 5, 7, '38', 'public/music/snes_finalfantasy4/ff4_22_suspicion.mp3', 22),
			('Golbez', 5, 7, '100', 'public/music/snes_finalfantasy4/ff4_23_golbez.mp3', 23),
			('Hey, Cid', 5, 7, '56', 'public/music/snes_finalfantasy4/ff4_24_hey_cid.mp3', 24),
			('Mystic Mysidia', 5, 7, '120', 'public/music/snes_finalfantasy4/ff4_25_mystic_mysidia.mp3', 25),
			('Long Way to Go', 5, 7, '46', 'public/music/snes_finalfantasy4/ff4_26_long_way_to_go.mp3', 26),
			('Palom & Porom', 5, 7, '36', 'public/music/snes_finalfantasy4/ff4_27_palom_porom.mp3', 27),
			('Battle of the Four Fiends', 5, 7, '140', 'public/music/snes_finalfantasy4/ff4_28_four_fiends.mp3', 28),
			('The Airship', 5, 7, '55', 'public/music/snes_finalfantasy4/ff4_29_airship.mp3', 29),
			('Trojan Beauty', 5, 7, '123', 'public/music/snes_finalfantasy4/ff4_30_trojan_beauty.mp3', 30),
			('Samba de Chocobo', 5, 7, '45', 'public/music/snes_finalfantasy4/ff4_31_samba_de_chocobo.mp3', 31),
			('Tower of Babel', 5, 7, '132', 'public/music/snes_finalfantasy4/ff4_32_tower_of_babel.mp3', 32),
			('Somewhere in the World', 5, 7, '33', 'public/music/snes_finalfantasy4/ff4_33_somewhere_in_the_world.mp3', 33),
			('Land of the Dwarves', 5, 7, '53', 'public/music/snes_finalfantasy4/ff4_34_land_of_dwarves.mp3', 34),
			('Giotto, the Great King', 5, 7, '57', 'public/music/snes_finalfantasy4/ff4_35_giotto.mp3', 35),
			('Dancing Calcobrena', 5, 7, '32', 'public/music/snes_finalfantasy4/ff4_36_dancing_calcobrena.mp3', 36),
			('Tower of Zot', 5, 7, '105', 'public/music/snes_finalfantasy4/ff4_37_tower_of_zot.mp3', 37),
			('Illusionary World', 5, 7, '115', 'public/music/snes_finalfantasy4/ff4_38_illusionary_world.mp3', 38),
			('The Big Whale', 5, 7, '108', 'public/music/snes_finalfantasy4/ff4_39_big_whale.mp3', 39),
			('Another Moon', 5, 7, '106', 'public/music/snes_finalfantasy4/ff4_40_another_moon.mp3', 40),
			('The Lunarians', 5, 7, '117', 'public/music/snes_finalfantasy4/ff4_41_lunarians.mp3', 41),
			('Within the Giant', 5, 7, '127', 'public/music/snes_finalfantasy4/ff4_42_within_the_giant.mp3', 42),
			('Final Battle', 5, 7, '155', 'public/music/snes_finalfantasy4/ff4_43_final_battle.mp3', 43),
			('Epilogue', 5, 7, '930', 'public/music/snes_finalfantasy4/ff4_44_epilogue.mp3', 44)

			;
