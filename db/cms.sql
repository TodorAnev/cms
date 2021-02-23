-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for cms
CREATE DATABASE IF NOT EXISTS `cms` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `cms`;

-- Dumping structure for table cms.tbl_category
CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_category: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_category` DISABLE KEYS */;
INSERT INTO `tbl_category` (`id`, `title`) VALUES
	(5, 'Sample category');
/*!40000 ALTER TABLE `tbl_category` ENABLE KEYS */;

-- Dumping structure for table cms.tbl_comments
CREATE TABLE IF NOT EXISTS `tbl_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `com_p_id` int(11) NOT NULL,
  `com_content` text NOT NULL,
  `com_date` date NOT NULL,
  `com_author` varchar(255) NOT NULL,
  `com_status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_comments: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_comments` ENABLE KEYS */;

-- Dumping structure for table cms.tbl_likes
CREATE TABLE IF NOT EXISTS `tbl_likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_likes: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_likes` ENABLE KEYS */;

-- Dumping structure for table cms.tbl_posts
CREATE TABLE IF NOT EXISTS `tbl_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_date` date NOT NULL,
  `p_author` varchar(255) NOT NULL,
  `p_content` text NOT NULL,
  `p_comments` int(11) NOT NULL,
  `p_active` int(11) NOT NULL,
  `p_title` varchar(255) NOT NULL,
  `p_tags` varchar(255) NOT NULL,
  `p_picture` text NOT NULL,
  `cat_id` int(11) NOT NULL,
  `p_views_count` int(11) NOT NULL,
  `p_likes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_posts: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_posts` ENABLE KEYS */;

-- Dumping structure for table cms.tbl_users
CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_token` text NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_f_name` varchar(255) NOT NULL,
  `u_l_name` varchar(255) NOT NULL,
  `u_role` varchar(255) NOT NULL,
  `u_username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_users: ~0 rows (approximately)
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` (`id`, `u_token`, `u_email`, `u_password`, `u_f_name`, `u_l_name`, `u_role`, `u_username`) VALUES
	(1, '', 'admin@gmail.com', '$2y$12$rcejBGQ8oqJYCJc6GwOUsuWh.6B8IcweZq1YWZtrUDJZxJFSDiKO6', 'admin', 'admin', 'admin', 'admin');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;

-- Dumping structure for table cms.tbl_users_online
CREATE TABLE IF NOT EXISTS `tbl_users_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_time` int(11) NOT NULL,
  `u_session` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table cms.tbl_users_online: ~1 rows (approximately)
/*!40000 ALTER TABLE `tbl_users_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_users_online` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
