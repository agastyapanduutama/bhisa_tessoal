-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2026 at 12:55 PM
-- Server version: 10.11.10-MariaDB-log
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bhisa_tessoal`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_barang`
--

CREATE TABLE `t_barang` (
  `id` int(11) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `harga_barang` varchar(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_barang`
--

INSERT INTO `t_barang` (`id`, `id_satuan`, `kode_barang`, `nama_barang`, `keterangan`, `harga_barang`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'PR001', 'Ban Luar', '', '2300000', 1, '2026-06-23 06:40:07', '2026-06-23 06:43:36', 0, 0),
(2, 3, 'PR002', 'Baut Ukuran 18', '', '110000', 1, '2026-06-23 06:41:50', '2026-06-23 06:43:53', 0, 0),
(3, 4, 'PR003', 'Oli Mesin', '', '125000', 1, '2026-06-23 06:42:13', '2026-06-23 06:44:05', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_jabatan`
--

CREATE TABLE `t_jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `is_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_jabatan`
--

INSERT INTO `t_jabatan` (`id`, `nama_jabatan`, `keterangan`, `status`, `is_admin`) VALUES
(1, 'Administrator', '', 1, 1),
(2, 'Purchasing', 'Untuk admin Purchasing', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_satuan`
--

CREATE TABLE `t_satuan` (
  `id` int(11) NOT NULL,
  `nama_satuan` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_satuan`
--

INSERT INTO `t_satuan` (`id`, `nama_satuan`, `keterangan`, `status`) VALUES
(1, 'PCS', '', 1),
(2, 'KARTON', '', 1),
(3, 'BOX', '', 1),
(4, 'LITER', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `t_transaksi`
--

CREATE TABLE `t_transaksi` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL COMMENT 'penanda tangan transaksi',
  `nomor_transaksi` varchar(100) NOT NULL,
  `nama_customer` varchar(100) NOT NULL,
  `alamat_customer` text NOT NULL,
  `penerima_customer` varchar(100) NOT NULL,
  `waktu_diterima` date NOT NULL,
  `keterangan` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_transaksi`
--

INSERT INTO `t_transaksi` (`id`, `id_user`, `nomor_transaksi`, `nama_customer`, `alamat_customer`, `penerima_customer`, `waktu_diterima`, `keterangan`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'TRX-20260623-0001', 'Telkom University', ' Jl. Telekomunikasi No.1, Sukapura, Kec. Dayeuhkolot, Kabupaten Bandung, Jawa Barat 40257', 'Obi Zakaria', '2026-06-16', '', 1, 1, '2026-06-23 12:43:01', '2026-06-23 12:43:01'),
(2, 2, 'TRX-20260623-0002', 'Agastya Pandu', 'Bandung', 'Pandu', '2026-06-19', '', 2, 2, '2026-06-23 12:45:10', '2026-06-23 12:48:43');

-- --------------------------------------------------------

--
-- Table structure for table `t_transaksi_barang`
--

CREATE TABLE `t_transaksi_barang` (
  `id` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_transaksi_barang`
--

INSERT INTO `t_transaksi_barang` (`id`, `id_barang`, `id_transaksi`, `id_user`, `jumlah_barang`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 1, 0, 10, '2026-06-23 12:43:01', '2026-06-23 12:43:01', 1, 1),
(2, 2, 1, 0, 5, '2026-06-23 12:43:01', '2026-06-23 12:43:01', 1, 1),
(3, 3, 1, 0, 19, '2026-06-23 12:43:01', '2026-06-23 12:43:01', 1, 1),
(5, 2, 2, 2, 10, '2026-06-23 12:48:43', '2026-06-23 06:48:43', 2, 0),
(6, 3, 2, 2, 2, '2026-06-23 12:48:43', '2026-06-23 06:48:43', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `id` int(11) NOT NULL,
  `id_jabatan` varchar(100) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`id`, `id_jabatan`, `nama_user`, `username`, `password`, `keterangan`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'Administrator', 'admin', '4cacff929fe1e82a1614bcb72122fa8c', '', 1, '2026-06-23 06:35:29', '2026-06-23 06:36:58'),
(2, '2', 'Admin Purchasing', 'purchasing', '74ba4e8291e8b2e40a31a50505f8b72e', '', 1, '2026-06-23 06:37:17', '2026-06-23 06:37:17'),
(3, '2', 'Admin Purchasing 2', 'purchasing2', '0a84486c9a356092ed5b504564d6e3a6', '', 1, '2026-06-23 06:48:05', '2026-06-23 06:48:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_barang`
--
ALTER TABLE `t_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_jabatan`
--
ALTER TABLE `t_jabatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_satuan`
--
ALTER TABLE `t_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_transaksi`
--
ALTER TABLE `t_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_transaksi_barang`
--
ALTER TABLE `t_transaksi_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_barang`
--
ALTER TABLE `t_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_jabatan`
--
ALTER TABLE `t_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_satuan`
--
ALTER TABLE `t_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_transaksi`
--
ALTER TABLE `t_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `t_transaksi_barang`
--
ALTER TABLE `t_transaksi_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
