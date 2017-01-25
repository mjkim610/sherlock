-- --------------------------------------------------------
-- 호스트:                          127.0.0.1
-- 서버 버전:                        5.5.50 - MySQL Community Server (GPL)
-- 서버 OS:                        Win32
-- HeidiSQL 버전:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 테이블 sherlock-api.fingerprint 구조 내보내기
CREATE TABLE IF NOT EXISTS `fingerprint` (
  `fingerprint_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `fp_1` varchar(80) NOT NULL,
  `fp_2` varchar(80) NOT NULL,
  `fp_3` varchar(80) NOT NULL,
  `fp_4` varchar(80) NOT NULL,
  `fp_5` varchar(80) NOT NULL,
  `fp_6` varchar(80) NOT NULL,
  `fp_7` varchar(80) NOT NULL,
  `fp_8` varchar(80) NOT NULL,
  `fp_9` varchar(80) NOT NULL,
  `fp_10` varchar(80) NOT NULL,
  `fp_11` varchar(80) NOT NULL,
  `fp_12` varchar(80) NOT NULL,
  `fp_13` varchar(80) NOT NULL,
  `fp_14` varchar(80) NOT NULL,
  `fp_15` varchar(80) NOT NULL,
  `fp_16` varchar(80) NOT NULL,
  `fp_17` varchar(80) NOT NULL,
  `fp_18` varchar(80) NOT NULL,
  `fp_19` varchar(80) NOT NULL,
  `fp_20` varchar(80) NOT NULL,
  `fp_21` varchar(80) NOT NULL,
  `fp_22` varchar(80) NOT NULL,
  `fp_23` varchar(80) NOT NULL,
  `fp_24` varchar(80) NOT NULL,
  `fp_25` varchar(80) NOT NULL,
  `fp_26` varchar(80) NOT NULL,
  `fp_27` varchar(80) NOT NULL,
  `fp_28` varchar(80) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`fingerprint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
-- 테이블 sherlock-api.provider 구조 내보내기
CREATE TABLE IF NOT EXISTS `provider` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
-- 테이블 sherlock-api.service 구조 내보내기
CREATE TABLE IF NOT EXISTS `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `app_id` varchar(100) NOT NULL,
  `app_key` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `threshold_1` int(11) NOT NULL,
  `threshold_2` int(11) NOT NULL,
  `description` text,
  `mod_date` datetime DEFAULT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
-- 테이블 sherlock-api.table_1 구조 내보내기
CREATE TABLE IF NOT EXISTS `table_1` (
  `user_id` int(11) NOT NULL,
  `user_code` varchar(100) NOT NULL,
  `last_login` datetime NOT NULL,
  `reg_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
-- 테이블 sherlock-api.trial_log 구조 내보내기
CREATE TABLE IF NOT EXISTS `trial_log` (
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `result` varchar(100) NOT NULL,
  `score` int(11) NOT NULL,
  `reg_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
-- 테이블 sherlock-api.user 구조 내보내기
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
