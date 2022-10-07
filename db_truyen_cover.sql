-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.25-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for heroku_9545e73caaf405a
DROP DATABASE IF EXISTS `heroku_9545e73caaf405a`;
CREATE DATABASE IF NOT EXISTS `heroku_9545e73caaf405a` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `heroku_9545e73caaf405a`;

-- Dumping structure for table heroku_9545e73caaf405a.chapter
DROP TABLE IF EXISTS `chapter`;
CREATE TABLE IF NOT EXISTS `chapter` (
  `chapter_id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_so` int(10) unsigned NOT NULL,
  `chapter_ten` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `chapter_ngay_cap_nhat` datetime NOT NULL,
  `chapter_trang_thai` tinyint(4) NOT NULL COMMENT '#1: Hiện, #2: Ẩn',
  `truyen_id` int(11) NOT NULL,
  PRIMARY KEY (`chapter_id`),
  KEY `FK_truyen_chapter` (`truyen_id`),
  CONSTRAINT `FK_truyen_chapter` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`truyen_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.chapter_noi_dung
DROP TABLE IF EXISTS `chapter_noi_dung`;
CREATE TABLE IF NOT EXISTS `chapter_noi_dung` (
  `chapter_noi_dung_id` int(11) NOT NULL AUTO_INCREMENT,
  `chapter_noi_dung` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Lưu nội dung chap truyện hoặc hình ảnh của chap',
  `chapter_id` int(11) NOT NULL,
  PRIMARY KEY (`chapter_noi_dung_id`),
  KEY `FK_chapter_chapter-noi-dung` (`chapter_id`),
  CONSTRAINT `FK_chapter_chapter-noi-dung` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`chapter_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1188 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.tai_khoan
DROP TABLE IF EXISTS `tai_khoan`;
CREATE TABLE IF NOT EXISTS `tai_khoan` (
  `tai_khoan_id` int(11) NOT NULL AUTO_INCREMENT,
  `ten_hien_thi` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ten_tai_khoan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mat_khau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `phan_quyen` tinyint(4) NOT NULL COMMENT '#1: admin, #2: mod, #3: user',
  `trang_thai` tinyint(4) NOT NULL COMMENT '#1: kích hoạt, #2: khóa',
  PRIMARY KEY (`tai_khoan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.the_loai
DROP TABLE IF EXISTS `the_loai`;
CREATE TABLE IF NOT EXISTS `the_loai` (
  `the_loai_id` int(11) NOT NULL AUTO_INCREMENT,
  `the_loai_ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `the_loai_mo_ta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`the_loai_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.truyen
DROP TABLE IF EXISTS `truyen`;
CREATE TABLE IF NOT EXISTS `truyen` (
  `truyen_id` int(11) NOT NULL AUTO_INCREMENT,
  `truyen_ma` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `truyen_ten` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `truyen_tac_gia` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `truyen_mo_ta` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `truyen_anh_dai_dien` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `truyen_tinh_trang` tinyint(4) DEFAULT NULL COMMENT '#1: Đang cập nhật, #2: Đã hoàn thành, #3: Tạm ngừng',
  `truyen_luot_xem` int(11) NOT NULL,
  `truyen_ngay_dang` datetime NOT NULL DEFAULT current_timestamp(),
  `truyen_trang_thai` tinyint(4) NOT NULL COMMENT '#1: Hiện, #2: Ẩn',
  PRIMARY KEY (`truyen_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.truyen_the_loai
DROP TABLE IF EXISTS `truyen_the_loai`;
CREATE TABLE IF NOT EXISTS `truyen_the_loai` (
  `truyen_the_loai_id` int(11) NOT NULL AUTO_INCREMENT,
  `truyen_id` int(11) NOT NULL,
  `the_loai_id` int(11) NOT NULL,
  PRIMARY KEY (`truyen_the_loai_id`),
  KEY `FK_truyen_truyen-the-loai` (`truyen_id`),
  KEY `FK_the-loai_truyen-the-loai` (`the_loai_id`),
  CONSTRAINT `FK_the-loai_truyen-the-loai` FOREIGN KEY (`the_loai_id`) REFERENCES `the_loai` (`the_loai_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_truyen_truyen-the-loai` FOREIGN KEY (`truyen_id`) REFERENCES `truyen` (`truyen_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table heroku_9545e73caaf405a.tuong_tac
DROP TABLE IF EXISTS `tuong_tac`;
CREATE TABLE IF NOT EXISTS `tuong_tac` (
  `tuong_tac_id` int(11) NOT NULL AUTO_INCREMENT,
  `tuong_tac_noi_dung` mediumint(9) DEFAULT NULL,
  `tuong_tac_loai` tinyint(4) NOT NULL COMMENT '#1: đã xem, #2: thích, #3: theo dõi, #4: bình luận',
  `chapter_id` int(11) NOT NULL,
  `tai_khoan_id` int(11) NOT NULL,
  PRIMARY KEY (`tuong_tac_id`) USING BTREE,
  KEY `FK_tai-khoan_tuong-tac` (`tai_khoan_id`),
  KEY `FK_chapter_tuong-tac` (`chapter_id`) USING BTREE,
  CONSTRAINT `FK_chapter_tuong-tac` FOREIGN KEY (`chapter_id`) REFERENCES `chapter` (`chapter_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tai-khoan_tuong-tac` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoan` (`tai_khoan_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
