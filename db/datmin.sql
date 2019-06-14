-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP DATABASE IF EXISTS `datmin`;
CREATE DATABASE `datmin` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `datmin`;

DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `data` (`id`, `name`, `file`, `status`) VALUES
(1,	'Dataset Wether Golf',	'whether.csv',	0),
(6,	'Data Donor Darah',	'data_donor_darah_tensi.csv',	1);

-- 2019-05-26 13:29:55
