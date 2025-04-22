-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 05:36 AM
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
-- Database: `questionforum_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`, `bio`, `avatar`, `gender`, `dob`) VALUES
(1, 'giang', 'imgiang', 'giang@gmail.com', '2025-04-17 02:36:15', 'dfghsdfghjmk,l\n\n\nfghjnmk\nsdfghnjmk,lư\nmmm,\n,,,\n\nds\nd', 'uploads/avatars/user_1_1744683518.png', 'Female', '2025-05-09'),
(10, 'sdh', 'giangbhi', 'giangb@gmail.com', '2025-04-06 03:29:35', NULL, NULL, NULL, NULL),
(22, 'myhr', '$2y$10$DPfyhTfASizOp.EkXb8XzumIKLSKZbQljxu.zB9HUmGjosr.oS.1S', 'my@gmail.com', '2025-04-20 05:46:10', 'ad', NULL, NULL, NULL),
(23, 'giangb', '$2y$10$AGyvGlHbcxCBuRUuq4AwAeV1za9Ys5jsZeG1OL5cWQJsXCt4J7XDW', 'giang1@gmail.com', '2025-04-21 02:50:27', 'testing', NULL, NULL, NULL),
(24, 'test', '$2y$10$TJyf5brkwlthZlcNyYMtl...leFII8U2AK6UndLDipX/HxvM2Yob2', 'test@gmail.com', '2025-04-21 05:13:37', 's', 'uploads/avatars/user_24_1745212327.jpg', 'Male', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
