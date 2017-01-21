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


-- sherlock-api 데이터베이스 구조 내보내기
CREATE DATABASE IF NOT EXISTS `sherlock-api` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sherlock-api`;

-- 테이블 sherlock-api.fingerprint 구조 내보내기
CREATE TABLE IF NOT EXISTS `fingerprint` (
  `fingerprint_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `a` varchar(80) NOT NULL,
  `b` varchar(80) NOT NULL,
  `c` varchar(80) NOT NULL,
  `d` varchar(80) NOT NULL,
  `e` varchar(80) NOT NULL,
  `f` varchar(80) NOT NULL,
  `g` varchar(80) NOT NULL,
  `h` varchar(80) NOT NULL,
  `i` varchar(80) NOT NULL,
  `j` varchar(80) NOT NULL,
  `k` varchar(80) NOT NULL,
  `l` varchar(80) NOT NULL,
  `m` varchar(80) NOT NULL,
  `n` varchar(80) NOT NULL,
  `o` varchar(80) NOT NULL,
  `p` varchar(80) NOT NULL,
  `q` varchar(80) NOT NULL,
  `r` varchar(80) NOT NULL,
  `s` varchar(80) NOT NULL,
  `t` varchar(80) NOT NULL,
  `u` varchar(80) NOT NULL,
  `v` varchar(80) NOT NULL,
  `w` varchar(80) NOT NULL,
  `x` varchar(80) NOT NULL,
  `y` varchar(80) NOT NULL,
  `a_a` varchar(80) NOT NULL,
  `a_b` varchar(80) NOT NULL,
  `a_c` varchar(80) NOT NULL,
  `a_d` varchar(80) NOT NULL,
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`fingerprint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 내보낼 데이터가 선택되어 있지 않습니다.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
