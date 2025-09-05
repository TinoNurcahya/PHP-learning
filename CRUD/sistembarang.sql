-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 05, 2025 at 10:07 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistembarang`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `jumlah` int NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `gambar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'default.jpg',
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventaris`
--

INSERT INTO `inventaris` (`id`, `nama`, `kategori`, `jumlah`, `lokasi`, `gambar`, `waktu`) VALUES
(46, 'kopi', 'Reiciendis ipsa lab', 85, 'Aliquam odio volupta', '6894b423ac7d4_1.jpg', '2025-08-21 13:51:08'),
(47, 'bbb', 'Aut est sit omnis n', 69, 'Adipisicing officiis', '6894b431da6f7_buku-3.jpeg', '2025-08-07 14:12:01'),
(48, 'ccc', 'Ea anim eu ut est o', 41, 'Ex in accusantium mi', '6894b4538cd5e_buku-2.jpg', '2025-08-07 14:12:35'),
(49, 'romozeniji', 'Unde excepturi aliqu', 78, 'Ut maxime sint nihil', '68959462c0049_toothless.jpg', '2025-08-08 06:08:34'),
(50, 'kopi', 'Accusamus quam id qu', 37, 'Ut voluptas laboris ', 'default.jpg', '2025-08-21 13:51:26'),
(52, 's', 's', 2, 's', '6895986ab3d96_Dompet.jpg', '2025-08-08 06:25:46'),
(53, 'qiheramyz', 'Quis debitis rerum p', 87, 'Aut molestias sed pe', 'default.jpg', '2025-08-17 14:34:16'),
(54, 'putiro', 'Id autem ratione fa', 9, 'Quia in omnis aspern', 'default.jpg', '2025-08-17 14:34:21'),
(55, 'babomi', 'Ea obcaecati eius qu', 41, 'Qui et modi est aut', 'default.jpg', '2025-08-21 07:27:42'),
(56, 'badobede', 'Repellendus Non cor', 21, 'Nisi totam mollitia ', 'default.jpg', '2025-08-17 14:34:29'),
(57, 'gavybekot', 'Sunt quibusdam comm', 65, 'Veniam voluptatem t', 'default.jpg', '2025-08-21 07:17:45'),
(58, 'zusaaaaaaaaaaaaaaaaaaaaa', 'Dolorem esse sequi ', 58, 'Dolore illo pariatur', 'default.jpg', '2025-08-21 07:08:45'),
(59, 'komputer', 'alat', 2, 'jl. mawar\r\n', 'default.jpg', '2025-08-21 13:46:09'),
(60, 'kaa', 'Ad dolor aut exercit', 66, 'Aut a impedit quam ', 'default.jpg', '2025-08-21 07:13:14'),
(61, 'pywumuwe', 'Adipisicing dolorum ', 1, 'Reprehenderit molli', 'default.jpg', '2025-08-21 15:06:39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `remember_token`, `create_at`) VALUES
(5, 'f', 'f@gmail.com', '$2y$10$7xg8FO9kfccNgOaY5Jsj3.OXFOoOFBxaBovPLDKMM5bcn8WSr6IBm', NULL, '2025-08-08 07:50:46'),
(6, 'e', 'e@gmail.com', '$2y$10$LLXFvIACik3bkWfd2Np0.es1y5MScfzccwcgesf7FuL1pVUFPD672', '$2y$10$INGv.FbK9Dfsx4XI6ZnOCeYkqeryC62p2Wssp1Cyq9W5aE41Ciwf.', '2025-08-15 08:39:38'),
(7, 'a', 'a@gmail.com', '$2y$10$QCj5257eV.xyVLoPH2f8pORQ6tb/GSNTk.4WCX2GD24eiRFRNfsGa', NULL, '2025-08-17 15:09:35'),
(8, 'Tino Nurcahya', 'tino@gmail.com', '$2y$10$znDV6R3MzNicZ74B5FnpIux/Rn/hotQ9c.kMj8vG904o7koDnNQFm', '$2y$10$ls1zHoDG/yusuA5u8pzFAOcJGPhUVNjg9w7I/n2n03qgp0xUrThYu', '2025-08-21 15:08:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
