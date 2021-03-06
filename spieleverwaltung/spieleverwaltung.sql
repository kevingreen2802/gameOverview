SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;

CREATE DATABASE IF NOT EXISTS `spieleverwaltung` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `spieleverwaltung`;

CREATE TABLE `developer` (
  `name` varchar(200) NOT NULL,
  `id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `developer` (`name`, `id`) VALUES
('Bethesda', 1),
('Nintendo', 2),
('Game Freak Inc.', 3),
('Rare', 4),
('Mojang', 5),
('Sickhead Games', 6),
('From Software', 7),
('Blizzard', 8),
('Ubisoft', 9),
('Insomniac Games', 10),
('Kojima Productions', 11),
('Square Enix', 12),
('Psyonix', 13),
('EA DICE', 14),
('Naughty Dog', 15),
('Team ICO', 16),
('Telltale Games', 17),
('Rockstar Games\r\n', 18),
('Guerrilla Games', 19),
('Bungie', 20),
('Sony', 21),
('Microsoft', 22),
('CD Projekt Red', 23);

CREATE TABLE `devices` (
  `id` int(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `hersteller_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `devices` (`id`, `name`, `hersteller_id`) VALUES
(1, 'SNES', 3),
(2, 'N64', 3),
(3, 'Gamecube', 3),
(4, 'Wii', 3),
(5, 'WiiU', 3),
(6, 'Playstation 4', 1),
(7, 'Xbox One', 2),
(8, 'Gameboy Advance', 3),
(9, 'PC', 2),
(10, 'Playstation 3', 1);

CREATE TABLE `company` (
  `name` varchar(100) NOT NULL,
  `id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `company` (`name`, `id`) VALUES
('Sony', 1),
('Microsoft', 2),
('Nintendo', 3);

CREATE TABLE `medium` (
  `name` varchar(200) NOT NULL,
  `id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `medium` (`name`, `id`) VALUES
('Disc', 1),
('Digital', 2),
('Cardridge', 3),
('Subscription', 4);

CREATE TABLE `games` (
  `id` int(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `geraet_id` int(200) NOT NULL,
  `entwickler_id` int(200) NOT NULL,
  `medium_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `games` (`id`, `name`, `geraet_id`, `entwickler_id`, `medium_id`) VALUES
(63, 'Fallout 4', 7, 1, 1),
(64, 'ZombiU', 5, 9, 1),
(65, 'The Division', 7, 9, 1),
(66, 'Rocket League', 6, 13, 2),
(67, 'Star Wars Battlefront', 6, 14, 2),
(68, 'Uncharted - The Nathan Drake Collection', 6, 15, 2),
(69, 'Horizon - Zero Dawn', 6, 19, 1),
(70, 'Fallout 3', 9, 1, 2),
(71, 'Fallout - New Vegas', 6, 1, 2),
(72, 'The Elder Scrolls V: Skyrim', 9, 1, 2),
(73, 'Pokemon Blau', 8, 3, 3),
(74, 'Pokemon Gold', 8, 3, 3),
(75, 'Pokemon Silber', 8, 3, 3),
(76, 'Tetris', 8, 2, 3),
(77, 'Donkey Kong Country', 1, 4, 3),
(78, 'Donkey Kong Country - Tropical Freeze', 5, 2, 1),
(79, 'Dark Souls 3', 9, 7, 2),
(80, 'Dark Souls', 9, 7, 2),
(82, 'Demons Souls', 10, 7, 1),
(83, 'The Legend of Zelda - A Link to the Past', 1, 2, 3),
(84, 'Super Mario World', 1, 2, 3),
(85, 'Gooftroop', 1, 2, 3),
(86, 'Starwing', 1, 2, 3),
(87, 'Grand Theft Auto V', 6, 18, 1),
(88, 'The Last Guardian', 6, 16, 1),
(89, 'Tales from the Borderlands', 6, 17, 1),
(90, 'Sunset Overdrive', 6, 10, 1),
(91, 'Halo - The Master Chief Collection', 7, 20, 2),
(92, 'Minecraft', 9, 5, 2),
(93, 'Minecraft', 6, 5, 2),
(94, 'Hearthstone - Heroes of Warcraft', 9, 8, 2),
(96, 'Rocket League', 9, 13, 2),
(97, 'Xbox Game Pass', 7, 22, 4),
(99, 'The Elder Scrolls V: Skyrim Special Edition', 7, 1, 1),
(100, 'The Witcher 3 - Wild Hunt', 9, 23, 2),
(101, 'Stardew Valley', 9, 6, 2),
(102, 'Far Cry Primal', 7, 9, 1),
(103, 'Assassins Creed Unity', 7, 9, 2),
(104, 'Super Mario 64', 2, 2, 3);

ALTER TABLE `developer`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hersteller_id` (`hersteller_id`);

ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `medium`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `geraet` (`geraet_id`),
  ADD KEY `entwickler_id` (`entwickler_id`),
  ADD KEY `medium_id` (`medium_id`);

ALTER TABLE `developer`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
ALTER TABLE `devices`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
ALTER TABLE `company`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `medium`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `games`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

ALTER TABLE `devices`
  ADD CONSTRAINT `a` FOREIGN KEY (`hersteller_id`) REFERENCES `company` (`id`);

ALTER TABLE `games`
  ADD CONSTRAINT `spiele_ibfk_2` FOREIGN KEY (`entwickler_id`) REFERENCES `developer` (`id`),
  ADD CONSTRAINT `spiele_ibfk_3` FOREIGN KEY (`medium_id`) REFERENCES `medium` (`id`),
  ADD CONSTRAINT `spiele_ibfk_4` FOREIGN KEY (`geraet_id`) REFERENCES `devices` (`id`);
COMMIT;

CREATE USER 'spieleverwaltungAdmin'@'localhost' IDENTIFIED BY 'dzh123';
GRANT ALL PRIVILEGES ON `spieleverwaltung`.* TO 'spieleverwaltungAdmin'@'localhost';
FLUSH PRIVILEGES;
