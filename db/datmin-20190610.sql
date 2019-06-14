-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: mariadb
-- Generation Time: Jun 10, 2019 at 09:10 AM
-- Server version: 10.3.15-MariaDB-1:10.3.15+maria~bionic
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apps_docker`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `name`, `file`, `status`) VALUES
(1, 'Dataset Wether Golf', 'whether.csv', 0),
(6, 'Data Donor Darah', 'data_donor_darah_tensi.csv', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testing`
--

CREATE TABLE `testing` (
  `id` int(11) NOT NULL,
  `data_testing` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `testing`
--

INSERT INTO `testing` (`id`, `data_testing`) VALUES
(1, '{\"data_nama\":\"Adi Rusmanto\",\"data_alamat\":\"Jl. Peleburan Barat I No 2 Semarang\",\"data_telepon\":\"085740935740\",\"umur\":\"50\",\"golda\":\"AB+\",\"berat_badan\":\"80\",\"hb\":\"12,5\",\"sistolik\":\"100\",\"diastolik\":\"90\",\"jk\":\"Pria\"}'),
(6, '{\"data_nama\":\"Adhi Kirnant\",\"data_alamat\":\"Jl HJ Rasuna No 12\",\"data_telepon\":\"086745265412\",\"umur\":\"80\",\"golda\":\"AB+\",\"berat_badan\":\"50\",\"hb\":\"12,5\",\"sistolik\":\"100\",\"diastolik\":\"80\",\"jk\":\"Pria\",\"hasil\":\"TIDAK BOLEH\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testing`
--
ALTER TABLE `testing`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `testing`
--
ALTER TABLE `testing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
