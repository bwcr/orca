-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2018 at 06:08 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orca`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` varchar(20) NOT NULL,
  `nama_admin` varchar(50) DEFAULT NULL,
  `kata_sandi` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `peminjam`
--

CREATE TABLE `peminjam` (
  `no_induk` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `kata_sandi` varchar(20) NOT NULL,
  `foto_profil` longtext NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjam`
--

INSERT INTO `peminjam` (`no_induk`, `nama`, `status`, `kata_sandi`, `foto_profil`, `last_login`) VALUES
('24010316140071', 'Difa Reynikha Fatullah', 'Mahasiswa', '123', 'dipa.jpg', '2018-10-19 01:22:25'),
('24010316140102', 'Ayu Wulandari', 'Dosen', '444', 'ruri.jpg', '2018-11-08 17:44:57');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_ruang`
--

CREATE TABLE `peminjaman_ruang` (
  `id_peminjaman` int(11) NOT NULL,
  `no_induk` varchar(20) NOT NULL,
  `id_ruang` varchar(20) NOT NULL,
  `tanggal` varchar(20) NOT NULL,
  `keterangan_pinjam` varchar(20) NOT NULL,
  `waktu_pinjam` datetime NOT NULL,
  `status_pesan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peminjaman_ruang`
--

INSERT INTO `peminjaman_ruang` (`id_peminjaman`, `no_induk`, `id_ruang`, `tanggal`, `keterangan_pinjam`, `waktu_pinjam`, `status_pesan`) VALUES
(48, '24010316140071', '04', '2018-11-22', 'Sidang Skripsi', '2018-11-06 10:27:02', 1),
(51, '24010316140071', '03', '12 November 2018', 'Langsung saja', '2018-11-11 22:13:00', 2),
(52, '24010316140071', '03', '2018-11-12', 'Masak gaboleh si mas', '2018-11-11 22:20:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ruang`
--

CREATE TABLE `ruang` (
  `id_ruang` varchar(20) NOT NULL,
  `nama_ruang` varchar(15) NOT NULL,
  `waktu_ruang` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruang`
--

INSERT INTO `ruang` (`id_ruang`, `nama_ruang`, `waktu_ruang`) VALUES
('01', 'Ruang Sidang 1', '08.00 - 09.00'),
('02', 'Ruang Sidang 1', '09.00 -10.00'),
('03', 'Ruang Sidang 1', '10.00 -11.00'),
('04', 'Ruang Sidang 1', '11.00 -12.00'),
('05', 'Ruang Sidang 1', '13.00 -14.00'),
('06', 'Ruang Sidang 2', '08.00 - 09.00'),
('07', 'Ruang Sidang 2', '09.00 -10.00'),
('08', 'Ruang Sidang 2', '10.00 -11.00'),
('09', 'Ruang Sidang 2', '11.00 -12.00'),
('10', 'Ruang Sidang 2', '13.00 -14.00'),
('11', 'Ruang Sidang 3', '08.00 - 09.00'),
('12', 'Ruang Sidang 3', '09.00 -10.00'),
('13', 'Ruang Sidang 3', '10.00 -11.00'),
('14', 'Ruang Sidang 3', '11.00 -12.00'),
('15', 'Ruang Sidang 3', '13.00 -14.00');

-- --------------------------------------------------------

--
-- Table structure for table `staff_pengelola`
--

CREATE TABLE `staff_pengelola` (
  `no_induk` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pengelola',
  `kata_sandi` varchar(20) NOT NULL,
  `foto_profil` longtext NOT NULL,
  `last_login` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_pengelola`
--

INSERT INTO `staff_pengelola` (`no_induk`, `nama`, `status`, `kata_sandi`, `foto_profil`, `last_login`) VALUES
('24010316140079', 'Ajeng Mifta', 'Pengelola', '123', 'avatar-placeholder.png', '2018-11-06 08:21:37'),
('24010316140118', 'Bayu Wicaksono', 'Pengelola', '123', 'DSC_0817.JPG', '2018-10-10 00:00:00'),
('admin', 'Administrator', 'Admin', 'admin', '', '2018-11-06 03:38:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `peminjam`
--
ALTER TABLE `peminjam`
  ADD PRIMARY KEY (`no_induk`);

--
-- Indexes for table `peminjaman_ruang`
--
ALTER TABLE `peminjaman_ruang`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_ruang` (`id_ruang`),
  ADD KEY `no_induk_peminjam` (`no_induk`);

--
-- Indexes for table `ruang`
--
ALTER TABLE `ruang`
  ADD PRIMARY KEY (`id_ruang`);

--
-- Indexes for table `staff_pengelola`
--
ALTER TABLE `staff_pengelola`
  ADD PRIMARY KEY (`no_induk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peminjaman_ruang`
--
ALTER TABLE `peminjaman_ruang`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
