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


-- CREATE SYSTEMS TABLE
CREATE TABLE IF NOT EXISTS systems (
	system_id		INTEGER			NOT NULL	AUTO_INCREMENT PRIMARY KEY,
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
	system_id		INTEGER			NOT NULL,
	artwork_path	VARCHAR(500)	NOT NULL,
	year_released	INTEGER			NOT NULL,

	FOREIGN KEY (system_id)
		REFERENCES systems(system_id)
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

INSERT INTO systems
			(name)
	 VALUES
			('NES'),
			('SNES'),
			('PS');

INSERT INTO albums 
			(year_released, system_id, title_name, artwork_path) 
	 VALUES
			(1986, 1,	'The Legend of Zelda',	'zelda.jpg'),
			(1988, 1,	'Mega Man 2',			'megaman2.jpg'),
			(1987, 1,	'Punch Out',			'punchout.jpg'),
			(1986, 1,	'Metroid',				'metroid.jpg'),
			(1987, 1,	'Contra',				'contra.jpg'),
			(1985, 1,	'Super Mario Bros.',	'supermariobros.jpg'),
			(1991, 2,	'Final Fantasy 4',		'finalfantasy4.jpg'),
			(1991, 2,	'Street Fighter 2',		'streetfighter2.jpg'),
			(1997, 3,	'Final Fantasy 7',		'finalfantasy7.jpg')
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
			(8, 7),
			(9, 5)
			;

--
-- Dumping data for table `Songs`
--

INSERT INTO songs 
			(title_name, artist_id, album_id, duration, song_path, album_order)
	 VALUES
			('Title Theme',					1, 1, '300',	'zelda/01_title_theme.mp3',				1),
			('Menu Theme',					1, 1, '301',	'zelda/02_menu_theme.mp3',				2),
			('Overworld Theme',				1, 1, '300',	'zelda/03_overworld_theme.mp3',			3),
			('Dungeon Theme',				1, 1, '300',	'zelda/04_dungeon_theme.mp3',			4),
			('Dungeon Clear',				1, 1, '9',		'zelda/05_dungeon_clear.mp3',			5),
			('Receive Item',				1, 1, '3',		'zelda/06_receive_item.mp3',			6),
			('Recorder Theme',				1, 1, '4',		'zelda/07_recorder_theme.mp3',			7),
			('Life Lost',					1, 1, '4',		'zelda/08_life_lost.mp3',				8),
			('Rescued',						1, 1, '6',		'zelda/09_rescued.mp3',					9),
			('Ganon Dungeon',				1, 1, '300',	'zelda/10_ganon_dungeon.mp3',			10),
			('Ganon Defeated',				1, 1, '4',		'zelda/11_ganon_defeated.mp3',			11),
			('Ending Theme',				1, 1, '300',	'zelda/12_ending_theme.mp3',			12),

			('Introduction',				2, 2, '43',		'megaman2/01_introduction.mp3',			1),
			('Title Screen',				2, 2, '44',		'megaman2/02_title_screen.mp3',			2),
			('Password Screen',				2, 2, '34',		'megaman2/03_password_screen.mp3',		3),
			('Stage Select',				2, 2, '32',		'megaman2/04_stage_select.mp3',			4),
			('Enemy Chosen',				2, 2, '8',		'megaman2/05_enemy_chosen.mp3',			5),
			('Quick Man',					2, 2, '125',	'megaman2/06_quick_man.mp3',			6),
			('Metal Man',					2, 2, '127',	'megaman2/07_metal_man.mp3',			7),
			('Bubble Man',					2, 2, '123',	'megaman2/08_bubble_man.mp3',			8),
			('Heat Man',					2, 2, '101',	'megaman2/09_heat_man.mp3',				9),
			('Wood Man',					2, 2, '121',	'megaman2/10_wood_man.mp3',				10),
			('Air Man',						2, 2, '140',	'megaman2/11_air_man.mp3',				11),
			('Crash Man',					2, 2, '230',	'megaman2/12_crash_man.mp3',			12),
			('Flash Man',					2, 2, '217',	'megaman2/13_flash_man.mp3',			13),
			('Boss Battle',					2, 2, '42',		'megaman2/14_boss_battle.mp3',			14),
			('Victory',						2, 2, '207',	'megaman2/15_victory.mp3',				15),
			('Weapons Ready',				2, 2, '30',		'megaman2/16_weapons_ready.mp3',		16),
			('Dr Wily\'s Map',				2, 2, '9',		'megaman2/17_wilys_map.mp3',			17),
			('Dr Wily\'s Castle',			2, 2, '238',	'megaman2/18_wilys_castle.mp3',			18),
			('Dr Wily\'s Castle2',			2, 2, '244',	'megaman2/19_wilys_castle2.mp3',		19),
			('Dr Wily Defeated',			2, 2, '11',		'megaman2/20_wily_defeated.mp3',		20),
			('Epilogue',					2, 2, '110',	'megaman2/21_epilogue.mp3',				21),
			('Credits',						2, 2, '107',	'megaman2/22_credits.mp3',				22),
			('Game Over',					2, 2, '6',		'megaman2/23_game_over.mp3',			23),

			('Fight Theme',					1, 3, '300',	'punchout/fight_theme.mp3',				1),

			('Title',						3, 4, '150',	'metroid/01_title.mp3',					1),
			('Samus Entry',					3, 4, '7',		'metroid/02_samus_entry.mp3',			2),
			('Brinstar (Rock Stage)',		3, 4, '146',	'metroid/03_brinstar.mp3',				3),
			('Mini Boss Room I - Kraid',	3, 4, '140',	'metroid/04_mini_boss_room1.mp3',		4),
			('Norfair (Flame Stage)',		3, 4, '120',	'metroid/05_norfair_flame_stage.mp3',	5),
			('Mini Boss Room II - Ridley',	3, 4, '101',	'metroid/06_mini_boss_room2.mp3',		6),
			('Silence',						3, 4, '29',		'metroid/07_silence.mp3',				7),
			('Item Acquisition Jingle',		3, 4, '6',		'metroid/08_item_jingle.mp3',			8),
			('Tourian (Base Stage)',		3, 4, '34',		'metroid/09_tourian_base_stage.mp3',	9),
			('The Lord of Zebes',			3, 4, '34',		'metroid/10_the_lord_of_zebes.mp3',		10),
			('Escape',						3, 4, '127',	'metroid/11_escape.mp3',				11),
			('Ending',						3, 4, '216',	'metroid/12_ending.mp3',				12),

			('Title',						4, 5, '7',		'contra/01_title.mp3',					1),
			('Introduction',				4, 5, '105',	'contra/02_introduction.mp3',			2),
			('Area 1 / Area 7',				4, 5, '151',	'contra/03_jungle_hanger.mp3',			3),
			('Area Clear',					4, 5, '6',		'contra/04_area_clear.mp3',				4),
			('Areas 2 & 4: Bases 1 & 2',	4, 5, '139',	'contra/05_areas_2_4_bases_1_2.mp3',	5),
			('Boss',						4, 5, '120',	'contra/06_boss.mp3',					6),
			('Area 3: Waterfall',			4, 5, '123',	'contra/07_area_3_waterfall.mp3',		7),
			('Area 5: Snow Field',			4, 5, '117',	'contra/08_area_5_snow_field.mp3',		8),
			('Area 6: Energy Zone',			4, 5, '54',		'contra/09_area_6_energy_zone.mp3',		9),
			('Area 8: Alien\'s Lair',		4, 5, '107',	'contra/10_area_8_aliens_lair.mp3',		10),
			('Area 8: Alen Dead',			4, 5, '10',		'contra/11_area_8_alien_dead.mp3',		11),
			('Credit',						4, 5, '125',	'contra/12_credit.mp3',					12),
			('Game Over',					4, 5, '7',		'contra/13_game_over.mp3',				13),

			('Overworld Theme',				1, 6, '304',	'mario/01_overworld_theme.mp3',			1),
			('Underworld Theme',			1, 6, '113',	'mario/02_underworld_theme.mp3',		2),
			('Underwater Theme',			1, 6, '200',	'mario/03_underwater_theme.mp3',		3),
			('Castle Theme',				1, 6, '109',	'mario/04_castle_theme.mp3',			4),
			('Starman Theme',				1, 6, '114',	'mario/05_starman_theme.mp3',			5),
			('Level Clear Fanfare',			1, 6, '8',		'mario/06_level_clear_fanfare.mp3',		6),
			('Castle Clear Fanfare',		1, 6, '9',		'mario/07_castle_clear_theme.mp3',		7),
			('You\'re Dead Theme',			1, 6, '6',		'mario/08_youre_dead.mp3',				8),
			('Game Over Theme',				1, 6, '7',		'mario/09_game_over.mp3',				9),
			('Game Over2 Theme',			1, 6, '6',		'mario/10_game_over2.mp3',				10),
			('Into the Tunnel Theme',		1, 6, '5',		'mario/11_into_tunnel.mp3',				11),
			('Hurry Fanfare',				1, 6, '3',		'mario/12_hurry_fanfare.mp3',			12),
			('Hurry Overworld Theme',		1, 6, '210',	'mario/13_hurry_overworld.mp3',			13),
			('Hurry Underworld Theme',		1, 6, '114',	'mario/14_hurry_underworld.mp3',		14),
			('Hurry Castle Theme',			1, 6, '112',	'mario/15_hurry_castle.mp3',			15),
			('Ending Fanfare',				1, 6, '117',	'mario/16_ending_fanfare.mp3',			16),
			
			('Prelude',						5, 7, '112',	'ff4/01_prelude.mp3',					1),
			('Red Wings',					5, 7, '206',	'ff4/02_red_wings.mp3',					2),
			('Kingdom of Baron',			5, 7, '109',	'ff4/03_kingdom_baron.mp3',				3),
			('Love Theme',					5, 7, '149',	'ff4/04_love_theme.mp3',				4),
			('Prologue',					5, 7, '111',	'ff4/05_prologue.mp3',					5),
			('Welcome to Our Town',			5, 7, '049',	'ff4/06_welcome_town.mp3',				6),
			('Main Theme',					5, 7, '133',	'ff4/07_main_theme.mp3',				7),
			('Fight 1',						5, 7, '100',	'ff4/08_fight1.mp3',					8),
			('Fanfare',						5, 7, '026',	'ff4/09_fanfare.mp3',					9),
			('Hello, Big Chocobo',			5, 7, '26',		'ff4/10_big_chocobo.mp3',				10),
			('Chocobo, Chocobo',			5, 7, '29',		'ff4/11_chocobo_chocobo.mp3',			11),
			('Into the Darkness',			5, 7, '121',	'ff4/12_into_darkness.mp3',				12),
			('Fight 2',						5, 7, '114',	'ff4/13_fight2.mp3',					13),
			('Ring of Bombs',				5, 7, '52',		'ff4/14_ring_of_bomb.mp3',				14),
			('Rydia',						5, 7, '101',	'ff4/15_rydia.mp3',						15),
			('Castle Damcyan',				5, 7, '104',	'ff4/16_castle_damcyan.mp3',			16),
			('Cry in Sorrow',				5, 7, '100',	'ff4/17_cry_in_sorrow.mp3',				17),
			('Melody of the Lute',			5, 7, '55',		'ff4/18_melody_of_lute.mp3',			18),
			('Mt Ordeals',					5, 7, '118',	'ff4/19_mt_ordeals.mp3',				19),
			('Fabul',						5, 7, '135',	'ff4/20_fabul.mp3',						20),
			('Run',							5, 7, '25',		'ff4/21_run.mp3',						21),
			('Suspicion',					5, 7, '38',		'ff4/22_suspicion.mp3',					22),
			('Golbez',						5, 7, '100',	'ff4/23_golbez.mp3',					23),
			('Hey, Cid',					5, 7, '56',		'ff4/24_hey_cid.mp3',					24),
			('Mystic Mysidia',				5, 7, '120',	'ff4/25_mysidia.mp3',					25),
			('Long Way to Go',				5, 7, '46',		'ff4/26_long_way_to_go.mp3',			26),
			('Palom & Porom',				5, 7, '36',		'ff4/27_palom_porom.mp3',				27),
			('Battle of the Four Fiends',	5, 7, '140',	'ff4/28_four_fiends.mp3',				28),
			('The Airship',					5, 7, '55',		'ff4/29_airship.mp3',					29),
			('Trojan Beauty',				5, 7, '123',	'ff4/30_trojan_beauty.mp3',				30),
			('Samba de Chocobo',			5, 7, '45',		'ff4/31_samba_chocobo.mp3',				31),
			('Tower of Babel',				5, 7, '132',	'ff4/32_tower_of_babel.mp3',			32),
			('Somewhere in the World',		5, 7, '33',		'ff4/33_somewhere.mp3',					33),
			('Land of the Dwarves',			5, 7, '53',		'ff4/34_land_of_dwarves.mp3',			34),
			('Giotto, the Great King',		5, 7, '57',		'ff4/35_giotto.mp3',					35),
			('Dancing Calcobrena',			5, 7, '32',		'ff4/36_calcobrena.mp3',				36),
			('Tower of Zot',				5, 7, '105',	'ff4/37_tower_of_zot.mp3',				37),
			('Illusionary World',			5, 7, '115',	'ff4/38_illusionary.mp3',				38),
			('The Big Whale',				5, 7, '108',	'ff4/39_big_whale.mp3',					39),
			('Another Moon',				5, 7, '106',	'ff4/40_another_moon.mp3',				40),
			('The Lunarians',				5, 7, '117',	'ff4/41_lunarians.mp3',					41),
			('Within the Giant',			5, 7, '127',	'ff4/42_within_giant.mp3',				42),
			('Final Battle',				5, 7, '155',	'ff4/43_final_battle.mp3',				43),
			('Epilogue',					5, 7, '930',	'ff4/44_epilogue.mp3',					44)

			;
