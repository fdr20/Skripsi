-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 09:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_copras`
--

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `id_kepala` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `jabatan`, `id_kepala`) VALUES
(3, 'Oos', 'Kepala Teknisi', 2),
(4, 'Retni', 'Sekretaris', 2),
(5, 'Riska', 'Asisten Sekretaris', 2),
(7, 'Beni', 'QC', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kepala_bagian`
--

CREATE TABLE `kepala_bagian` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kepala_bagian`
--

INSERT INTO `kepala_bagian` (`id`, `nama`, `username`, `password`) VALUES
(2, 'M.Nazhmi', 'nazhmi', '$2y$10$2JKdscIai8DSUOU1eMNWWumBXtYYmWgncR91DChP477N827ROEeG.');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `bobot` int(11) DEFAULT NULL,
  `jenis` enum('benefit','cost') NOT NULL DEFAULT 'benefit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `kode`, `nama`, `bobot`, `jenis`) VALUES
(1, NULL, 'Kehadiran', 5, 'cost'),
(2, NULL, 'Sikap', 4, 'benefit'),
(3, NULL, 'Inisiatif', 3, 'benefit'),
(4, NULL, 'Kerjasama', 4, 'benefit'),
(5, NULL, 'Komunikasi', 4, 'benefit');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `id_sub_kriteria` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `id_admin`, `id_karyawan`, `id_sub_kriteria`, `nilai`, `tanggal`) VALUES
(36, 2, 4, 1, 5, '2025-05-27 13:53:13'),
(37, 2, 4, 4, 5, '2025-05-27 13:53:13'),
(38, 2, 4, 7, 5, '2025-05-27 13:53:13'),
(39, 2, 4, 11, 3, '2025-05-27 13:53:13'),
(40, 2, 4, 13, 5, '2025-05-27 13:53:13'),
(41, 2, 3, 1, 5, '2025-05-27 13:53:13'),
(42, 2, 3, 5, 4, '2025-05-27 13:53:13'),
(43, 2, 3, 7, 5, '2025-05-27 13:53:13'),
(44, 2, 3, 10, 5, '2025-05-27 13:53:13'),
(45, 2, 3, 13, 5, '2025-05-27 13:53:13'),
(46, 2, 5, 1, 5, '2025-05-27 13:53:13'),
(47, 2, 5, 4, 5, '2025-05-27 13:53:13'),
(48, 2, 5, 8, 3, '2025-05-27 13:53:13'),
(49, 2, 5, 11, 3, '2025-05-27 13:53:13'),
(50, 2, 5, 13, 5, '2025-05-27 13:53:13'),
(51, 2, 7, 2, 3, '2025-05-27 13:53:13'),
(52, 2, 7, 5, 4, '2025-05-27 13:53:13'),
(53, 2, 7, 7, 5, '2025-05-27 13:53:13'),
(54, 2, 7, 10, 5, '2025-05-27 13:53:13'),
(55, 2, 7, 13, 5, '2025-05-27 13:53:13'),
(56, 1, 5, 1, 5, '2025-05-27 13:53:13'),
(57, 1, 5, 5, 4, '2025-05-27 13:53:13'),
(58, 1, 5, 7, 5, '2025-05-27 13:53:13'),
(59, 1, 5, 10, 5, '2025-05-27 13:53:13'),
(60, 1, 5, 14, 3, '2025-05-27 13:53:13'),
(61, 1, 4, 1, 5, '2025-05-27 14:20:31'),
(62, 1, 4, 4, 5, '2025-05-27 14:20:31'),
(63, 1, 4, 7, 5, '2025-05-27 14:20:31'),
(64, 1, 4, 10, 5, '2025-05-27 14:20:31'),
(65, 1, 4, 13, 5, '2025-05-27 14:20:31'),
(71, 1, 3, 1, 5, '2025-05-27 14:22:32'),
(72, 1, 3, 4, 5, '2025-05-27 14:22:32'),
(73, 1, 3, 7, 5, '2025-05-27 14:22:32'),
(74, 1, 3, 10, 5, '2025-05-27 14:22:32'),
(75, 1, 3, 13, 5, '2025-05-27 14:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `id_kriteria` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `bobot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `kode`, `id_kriteria`, `nama`, `bobot`) VALUES
(1, NULL, 1, 'Selalu hadir', 5),
(2, NULL, 1, 'Izin > 4x', 3),
(4, NULL, 2, 'Disiplin', 5),
(5, NULL, 2, 'Bertanggung jawab', 4),
(6, NULL, 2, 'Sopan santun', 3),
(7, NULL, 3, 'Sering memberi ide', 5),
(8, NULL, 3, 'Kadang memberi ide', 3),
(9, NULL, 3, 'Tidak pernah memberi ide', 1),
(10, NULL, 4, 'Sangat baik dalam tim', 5),
(11, NULL, 4, 'Cukup baik', 3),
(12, NULL, 4, 'Kurang aktif', 1),
(13, NULL, 5, 'Jelas & efektif', 5),
(14, NULL, 5, 'Cukup jelas', 3),
(15, NULL, 5, 'Kurang jelas', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','kepala') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'fadra', '$2b$12$O9BQUQj55sbjv4lltDOCRO2jzNX37w9.lqrQLiIKDPfiTWPj8kZL.', 'admin'),
(2, 'irfan', '$2y$10$XcKDc8ECjIIx9IWKryNMTeV.naMjrhHLkNxlmzieAHaRfpYIac/Wu', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kepala` (`id_kepala`);

--
-- Indexes for table `kepala_bagian`
--
ALTER TABLE `kepala_bagian`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_admin` (`id_admin`),
  ADD KEY `id_karyawan` (`id_karyawan`),
  ADD KEY `id_sub_kriteria` (`id_sub_kriteria`);

--
-- Indexes for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kepala_bagian`
--
ALTER TABLE `kepala_bagian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`id_kepala`) REFERENCES `kepala_bagian` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id`),
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `sub_kriteria` (`id`);

--
-- Constraints for table `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
