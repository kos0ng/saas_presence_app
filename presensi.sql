-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 28, 2021 at 02:20 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `akses_fitur`
--

CREATE TABLE `akses_fitur` (
  `akses_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fitur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_fitur`
--

INSERT INTO `akses_fitur` (`akses_id`, `user_id`, `fitur_id`) VALUES
(11, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fakultass`
--

CREATE TABLE `fakultass` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fakultass`
--

INSERT INTO `fakultass` (`id`, `nama`) VALUES
(1, 'coba');

-- --------------------------------------------------------

--
-- Table structure for table `fitur`
--

CREATE TABLE `fitur` (
  `fitur_id` int(11) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fitur`
--

INSERT INTO `fitur` (`fitur_id`, `deskripsi`) VALUES
(1, 'Mahasiswa yang memiliki persentase kehadiran perkuliahan tertentu di bawah 25%'),
(2, 'Mahasiswa yang memiliki kehadiran perkuliahan tertentu dengan presentase 100%');

-- --------------------------------------------------------

--
-- Table structure for table `jurusanss`
--

CREATE TABLE `jurusanss` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `fakultass_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jurusanss`
--

INSERT INTO `jurusanss` (`id`, `nama`, `fakultass_id`, `status`) VALUES
(1, 'coba12', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `management_id` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `management_id`) VALUES
(1, 'admin', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm', 1, 0),
(3, 'aa', '$2y$10$2UsQYM92fmmRqDw2JqJ1ROtqSwBg/PtOAP1fkJOnvpqnBLEyRIK.C', 2, 1),
(4, 'bb', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm', 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_fitur`
--
ALTER TABLE `akses_fitur`
  ADD PRIMARY KEY (`akses_id`);

--
-- Indexes for table `fakultass`
--
ALTER TABLE `fakultass`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fitur`
--
ALTER TABLE `fitur`
  ADD PRIMARY KEY (`fitur_id`);

--
-- Indexes for table `jurusanss`
--
ALTER TABLE `jurusanss`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses_fitur`
--
ALTER TABLE `akses_fitur`
  MODIFY `akses_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `fakultass`
--
ALTER TABLE `fakultass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fitur`
--
ALTER TABLE `fitur`
  MODIFY `fitur_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurusanss`
--
ALTER TABLE `jurusanss`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
