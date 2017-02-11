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
  `fp_1` varchar(150) NOT NULL,
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
  `fp_15` text NOT NULL,
  `fp_16` text NOT NULL,
  `fp_17` text NOT NULL,
  `fp_18` varchar(80) NOT NULL,
  `fp_19` varchar(80) NOT NULL,
  `fp_20` varchar(80) NOT NULL,
  `fp_21` varchar(80) NOT NULL,
  `fp_22` varchar(80) NOT NULL,
  `fp_23` varchar(80) NOT NULL,
  `fp_24` text NOT NULL,
  `fp_25` varchar(80) NOT NULL,
  `fp_26` varchar(80) NOT NULL,
  `fp_27` varchar(80) NOT NULL,
  `fp_28` varchar(80) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`fingerprint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.fingerprint:~0 rows (대략적) 내보내기
DELETE FROM `fingerprint`;
/*!40000 ALTER TABLE `fingerprint` DISABLE KEYS */;
/*!40000 ALTER TABLE `fingerprint` ENABLE KEYS */;

-- 테이블 sherlock-api.id_token_t 구조 내보내기
CREATE TABLE IF NOT EXISTS `id_token_t` (
  `unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_token` varchar(100) NOT NULL,
  `app_id` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.id_token_t:~0 rows (대략적) 내보내기
DELETE FROM `id_token_t`;
/*!40000 ALTER TABLE `id_token_t` DISABLE KEYS */;
/*!40000 ALTER TABLE `id_token_t` ENABLE KEYS */;

-- 테이블 sherlock-api.provider 구조 내보내기
CREATE TABLE IF NOT EXISTS `provider` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.provider:~1 rows (대략적) 내보내기
DELETE FROM `provider`;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` (`provider_id`, `email`, `password`, `name`, `phone`, `reg_date`) VALUES
	(1, 'frog2427@gmail.com', '$2y$10$tCme2eML5jpC/Yv./FIghu6xYGQKk/XRFTc71ov6PU9RMg1Z8MLay', 'asdfasfd', '010-123-12311', '2017-01-21 22:38:18');
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;

-- 테이블 sherlock-api.service 구조 내보내기
CREATE TABLE IF NOT EXISTS `service` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `app_id` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `threshold_1` int(11) NOT NULL,
  `threshold_2` int(11) unsigned NOT NULL,
  `service_name` varchar(50) DEFAULT NULL,
  `description` text,
  `mod_date` datetime DEFAULT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.service:~1 rows (대략적) 내보내기
DELETE FROM `service`;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` (`service_id`, `provider_id`, `app_id`, `token`, `table_name`, `url`, `threshold_1`, `threshold_2`, `service_name`, `description`, `mod_date`, `reg_date`) VALUES
	(1, 1, 'asd23fgasdgasf32', 'TokeASDGJdasdh2h12', 'table_1', 'http://localhost/sherlock/sherlock/auth_complete', 90, 60, 'Sherlock', 'Browser Fingerprint Authentication System', '2017-02-09 14:44:15', '2017-02-09 14:44:15');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;

-- 테이블 sherlock-api.table_1 구조 내보내기
CREATE TABLE IF NOT EXISTS `table_1` (
  `unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_code` varchar(100) NOT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.table_1:~0 rows (대략적) 내보내기
DELETE FROM `table_1`;
/*!40000 ALTER TABLE `table_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `table_1` ENABLE KEYS */;

-- 테이블 sherlock-api.trial_log 구조 내보내기
CREATE TABLE IF NOT EXISTS `trial_log` (
  `unique_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `fp_1` varchar(150) NOT NULL,
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
  `fp_15` text NOT NULL,
  `fp_16` text NOT NULL,
  `fp_17` text NOT NULL,
  `fp_18` varchar(80) NOT NULL,
  `fp_19` varchar(80) NOT NULL,
  `fp_20` varchar(80) NOT NULL,
  `fp_21` varchar(80) NOT NULL,
  `fp_22` varchar(80) NOT NULL,
  `fp_23` varchar(80) NOT NULL,
  `fp_24` text NOT NULL,
  `fp_25` varchar(80) NOT NULL,
  `fp_26` varchar(80) NOT NULL,
  `fp_27` varchar(80) NOT NULL,
  `fp_28` varchar(80) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`unique_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.trial_log:~0 rows (대략적) 내보내기
DELETE FROM `trial_log`;
/*!40000 ALTER TABLE `trial_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `trial_log` ENABLE KEYS */;

-- 테이블 sherlock-api.user 구조 내보내기
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `pin` varchar(100) NOT NULL,
  `reg_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- 테이블 데이터 sherlock-api.user:~1 rows (대략적) 내보내기
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `email`, `password`, `pin`, `reg_date`) VALUES
	(1, 'jhoney7374@gmail.com', '$2y$10$YhQCqNxEi2ziwitZZLS5cOuwr9NeC6gYGkpgJy/Y0QVWPVCCKHwvC', '$2y$10$uuTm7gorVpup965jOJgD8.2WS4JlfPTjZX2VKps8RudwqQNFvUUGq', '2017-01-25 22:15:00');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
