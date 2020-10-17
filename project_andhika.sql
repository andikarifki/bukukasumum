-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2020 at 11:24 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_andhika`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(11) NOT NULL,
  `username` varchar(11) NOT NULL,
  `password` text NOT NULL,
  `level` char(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `level`) VALUES
(1, 'andika', 'andikarifki', 'e5a85482d8b9bedbd68c39cb22aea751', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `buku_kas_umum`
--

CREATE TABLE `buku_kas_umum` (
  `id` int(11) NOT NULL,
  `no_reg` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `bagian` varchar(255) NOT NULL,
  `uraian` varchar(255) NOT NULL,
  `kd_rek` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buku_kas_umum`
--

INSERT INTO `buku_kas_umum` (`id`, `no_reg`, `tanggal`, `bagian`, `uraian`, `kd_rek`) VALUES
(1, '', '2020-08-12', 'Seksi Ekobang', 'PANJAR', ''),
(2, '1', '2020-08-12', 'Seksi Ekobang', 'belanja makan', '0550025223104'),
(3, '2', '2020-08-12', 'Seksi Ekobang', 'belanja rapat', '0550025223104'),
(4, '', '2020-08-12', 'KEUANGAN', 'PANJAR', '');

-- --------------------------------------------------------

--
-- Table structure for table `kode_rekening`
--

CREATE TABLE `kode_rekening` (
  `kd_rek` varchar(30) NOT NULL,
  `nama_bagian` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kode_rekening`
--

INSERT INTO `kode_rekening` (`kd_rek`, `nama_bagian`) VALUES
('0550025223104', 'Seksi Ekobang');

-- --------------------------------------------------------

--
-- Table structure for table `panjar`
--

CREATE TABLE `panjar` (
  `id_buku_kas_umum` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `panjar`
--

INSERT INTO `panjar` (`id_buku_kas_umum`, `jumlah`) VALUES
(1, 900000),
(4, 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `panjar_transfer`
--

CREATE TABLE `panjar_transfer` (
  `id_buku_kas_umum` int(11) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `id_seksi` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `panjar_transfer`
--

INSERT INTO `panjar_transfer` (`id_buku_kas_umum`, `nominal`, `id_seksi`, `date`) VALUES
(3, 1100000, 1, '2020-08-11');

-- --------------------------------------------------------

--
-- Table structure for table `spj_tunai`
--

CREATE TABLE `spj_tunai` (
  `id_buku_kas_umum` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spj_tunai`
--

INSERT INTO `spj_tunai` (`id_buku_kas_umum`, `jumlah`) VALUES
(6, 300000),
(7, 200000),
(8, 200000),
(2, 230000);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id_buku_kas_umum` int(11) NOT NULL,
  `jumlah` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`id_buku_kas_umum`, `jumlah`) VALUES
(4, 550000),
(3, 550000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `bagian` varchar(225) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `bagian`, `username`, `password`) VALUES
(1, 'Suhardi, S.IP, M.Si', 'Seksi Perekonomian dan Pembangunan', 'suhardi', '9e0f18916d63b2226fd5ed341c614a3a'),
(2, 'Agatha Ari Wulandari, S.IP, M.Dev', 'Seksi Pelayanan, Informasi, dan Pengaduan', 'agata', 'ed4ddfab802ae253a4b96e91fa48daa7'),
(3, 'Avo Dito Hendra, S.H', 'Sub Bagian Umum dan Kepegawaian', 'avodito', 'f39e6c89f09efb7bf0ed4010e9ed3205'),
(4, 'Diah Hernastiti, A.md', 'Bendahara Bagian Keuangan Perencanaan Evaluasi dan Pelaporan Kecamatan', 'diah', 'a4151d4b2856ec63368a7c784b1f0a6e'),
(5, 'Suhardi, S.IP, M.Si', 'Seksi Pemerintahan dan Tramtib', 'Suhardi', '76d6078ad9f20dee934959f1f5341658');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buku_kas_umum`
--
ALTER TABLE `buku_kas_umum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kode_rekening`
--
ALTER TABLE `kode_rekening`
  ADD PRIMARY KEY (`kd_rek`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `buku_kas_umum`
--
ALTER TABLE `buku_kas_umum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
