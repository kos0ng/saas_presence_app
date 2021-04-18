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
-- Database: `presensi_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambil_matakuliahs`
--

CREATE TABLE `ambil_matakuliahs` (
  `mahasiswas_id` int(11) NOT NULL,
  `jadwal_matkul_id` int(11) NOT NULL,
  `ambil_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ambil_matakuliahs`
--

INSERT INTO `ambil_matakuliahs` (`mahasiswas_id`, `jadwal_matkul_id`, `ambil_id`) VALUES
(1, 1, 1),
(1, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `dosen_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`dosen_id`, `nama`, `username`, `password`) VALUES
(1, 'aaa', 'qwe', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm'),
(2, 'zzz', 'rte', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm'),
(3, 'lala', 'lala', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm');

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` int(11) NOT NULL,
  `hari` varchar(45) NOT NULL,
  `jam_mulai` varchar(45) NOT NULL,
  `jam_selesai` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 'Senin', '08.00', '10.00'),
(2, 'Selasa', '13.00', '15.00'),
(3, 'Rabu', '10.00', '12.00');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_matakuliahs`
--

CREATE TABLE `jadwal_matakuliahs` (
  `matakuliahs_id` int(11) NOT NULL,
  `jadwal_matkul_id` int(11) NOT NULL,
  `jadwals_id` int(11) NOT NULL,
  `kode` varchar(6) NOT NULL DEFAULT '',
  `kehadiran` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jadwal_matakuliahs`
--

INSERT INTO `jadwal_matakuliahs` (`matakuliahs_id`, `jadwal_matkul_id`, `jadwals_id`, `kode`, `kehadiran`) VALUES
(1, 1, 1, '', 0),
(2, 2, 1, '', 0),
(3, 3, 2, '7UttlF', 2),
(4, 4, 3, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kehadirans`
--

CREATE TABLE `kehadirans` (
  `kehadiran_id` int(11) NOT NULL,
  `mahasiswas_id` int(11) NOT NULL,
  `jadwal_matkul_id` int(11) NOT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kehadirans`
--

INSERT INTO `kehadirans` (`kehadiran_id`, `mahasiswas_id`, `jadwal_matkul_id`, `tanggal`) VALUES
(1, 1, 3, '2021-03-28 17:27:17');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mahasiswas`
--

INSERT INTO `mahasiswas` (`id`, `nama`, `username`, `password`) VALUES
(1, 'awa', 'asd', '$2y$10$p2RtgLncvs/Ki1C20Wvx9eR6qKnptdaqQJqfmVsFM5JWaHCeUMUjm');

-- --------------------------------------------------------

--
-- Table structure for table `matakuliahs`
--

CREATE TABLE `matakuliahs` (
  `id` int(11) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `kapasitas` int(3) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matakuliahs`
--

INSERT INTO `matakuliahs` (`id`, `nama`, `dosen_id`, `kapasitas`, `status`) VALUES
(1, 'Matematika A', 1, 30, 1),
(2, 'Fisika A', 2, 30, 1),
(3, 'Matematika B', 3, 10, 0),
(4, 'Bahasa Indonesia', 2, 40, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambil_matakuliahs`
--
ALTER TABLE `ambil_matakuliahs`
  ADD PRIMARY KEY (`ambil_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`dosen_id`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jadwal_matakuliahs`
--
ALTER TABLE `jadwal_matakuliahs`
  ADD PRIMARY KEY (`jadwal_matkul_id`);

--
-- Indexes for table `kehadirans`
--
ALTER TABLE `kehadirans`
  ADD PRIMARY KEY (`kehadiran_id`);

--
-- Indexes for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `matakuliahs`
--
ALTER TABLE `matakuliahs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambil_matakuliahs`
--
ALTER TABLE `ambil_matakuliahs`
  MODIFY `ambil_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `dosen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jadwal_matakuliahs`
--
ALTER TABLE `jadwal_matakuliahs`
  MODIFY `jadwal_matkul_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kehadirans`
--
ALTER TABLE `kehadirans`
  MODIFY `kehadiran_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswas`
--
ALTER TABLE `mahasiswas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
