/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP TABLE IF EXISTS `torrents`;
CREATE TABLE IF NOT EXISTS `torrents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `category_id` tinyint(4) DEFAULT NULL,
  `size` bigint(20) unsigned DEFAULT NULL,
  `hash` varchar(40) NOT NULL,
  `files_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `torrent_status` smallint(2) DEFAULT '0',
  `visible_status` smallint(2) DEFAULT '0',
  `downloads_count` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT 'umax = 16777215',
  `scrape_date` datetime DEFAULT NULL,
  `seeders` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `leechers` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `tags` varchar(500) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash` (`hash`),
  KEY `created_at` (`created_at`),
  KEY `size` (`size`),
  KEY `seeders` (`seeders`),
  KEY `category_id_torrent_status_visible_status` (`category_id`,`torrent_status`,`visible_status`)
);

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

INSERT INTO `torrents` (`name`, `description`, `category_id`, `size`, `hash`, `files_count`, `created_at`, `torrent_status`, `visible_status`, `downloads_count`, `scrape_date`, `seeders`, `leechers`, `tags`, `updated_at`) VALUES ('Gothika (2003) [XviD - Italian English Ac3 5.1 - Sub spa] MIRCrew', 'Released: 21 Nov 2003\nRated: R\nRuntime: 98 min\nGenre: Horror, Thriller\nDirector: Mathieu Kassovitz\nWriter: Sebastian Gutierrez\nActors: Halle Berry, Robert Downey Jr., Charles S. Dutton, John Carroll Lynch\nIMDB: 5.8 (79,739 Votes)\n\nDr. Miranda Grey is a psychiatrist who works in a penitentiary, in the mental institution sector. She is married with Dr. Douglas Grey, the chief of department where Dr. Pete Graham also works. Chloe Sava, a patient of Dr. Miranda formerly abused by her stepfather, claims that she is frequently raped by the devil in her cell. After leaving the asylum in a stormy night, Dr. Miranda has a car accident, and when she wakes up, she is an inmate of the institution, being accused of an horrible crime and having no memory of the incident.', 5, 1774407945, '191c5493b54c4f3c8949da29cd41f947a3f7ff42', 2, '2014-12-16 22:51:09', 0, 0, 0, NULL, 0, 0, NULL, '2014-12-16 22:51:09');
INSERT INTO `torrents` (`name`, `description`, `category_id`, `size`, `hash`, `files_count`, `created_at`, `torrent_status`, `visible_status`, `downloads_count`, `scrape_date`, `seeders`, `leechers`, `tags`, `updated_at`) VALUES ('Redirected 2014 720p HDRiP XVID AC3-MAJESTIC', 'Released: 10 Jan 2014\nRated: \nRuntime: 99 min\nGenre: Action, Drama, Thriller\nDirector: Emilis Velyvis\nWriter: Jonas Banys, Lewis Britnell (dialogue editor), Emilis Velyvis\nActors: Vinnie Jones, Scot Williams, Gil Darnell, Oliver Jackson\nIMDB: 8.8 (12,076 Votes)\n\nFour friends - John, Ben, Tim and Michael - turned first-time robbers, get stranded in Eastern Europe through a series of misadventures and have to find their way back home. To do so, they\'ll have to overcome hit men, whores, corrupt cops, smugglers and more, all while rediscovering each other as friends', 5, 2621640304, '03f2ec89a37038a4bac9daa9374c954f47633be1', 3, '2014-12-16 22:51:08', 0, 0, 0, NULL, 0, 0, NULL, '2014-12-16 22:51:08');
INSERT INTO `torrents` (`name`, `description`, `category_id`, `size`, `hash`, `files_count`, `created_at`, `torrent_status`, `visible_status`, `downloads_count`, `scrape_date`, `seeders`, `leechers`, `tags`, `updated_at`) VALUES ('High School of The Dead', 'Released: 23 Aug 2012\nRated: Not Rated\nRuntime: \nGenre: Comedy\nDirector: Hope Chapman\nWriter: Hope Chapman\nActors: Hope Chapman, Kaylyn Dicksion, Lewis Lovhaug, Joe Vargas\nIMDB: 8.1 (128 Votes)\n\n', 1, 3758227976, '51efab8e94204987afb2709b3151545dab533dcc', 12, '2014-12-16 22:51:06', 0, 0, 0, NULL, 0, 0, NULL, '2014-12-16 22:51:08');
INSERT INTO `torrents` (`name`, `description`, `category_id`, `size`, `hash`, `files_count`, `created_at`, `torrent_status`, `visible_status`, `downloads_count`, `scrape_date`, `seeders`, `leechers`, `tags`, `updated_at`) VALUES ('Reach Me 2014 720p BluRay DD5 1 x264-VietHD', 'Released: 21 Nov 2014\nRated: PG-13\nRuntime: 95 min\nGenre: Drama\nDirector: John Herzfeld\nWriter: John Herzfeld\nActors: Lauren Cohan, Kyra Sedgwick, Thomas Jane, Kevin Connolly\nIMDB: 5.8 (126 Votes)\n\nA motivational book written by a mysterious man quickly gains popularity, inspiring a group of people that includes a journalist, his editor, a former inmate, a hip-hop mogul, an actor and an undercover cop to re-evaluate their choices and decisions by confronting their fears in hopes of creating more positive lives.', 5, 7583940211, '1c633b1c24bf2276f7bf5c082f36d858fde6831f', 3, '2014-12-16 22:51:05', 0, 0, 0, NULL, 0, 0, NULL, '2014-12-16 22:51:05');
INSERT INTO `torrents` (`name`, `description`, `category_id`, `size`, `hash`, `files_count`, `created_at`, `torrent_status`, `visible_status`, `downloads_count`, `scrape_date`, `seeders`, `leechers`, `tags`, `updated_at`) VALUES ('Movavi Photo Editor v1.5.0 with Key', NULL, 2, 34659365, 'df4fe16376374f446b0a3125d31f95c39bc09e54', 2, '2014-12-16 22:46:07', 0, 0, 0, NULL, 0, 0, 'software,v1.5', '2014-12-16 22:51:09');