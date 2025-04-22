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
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `created_at`, `image`, `module_id`, `user_id`, `updated_at`) VALUES
(8, 'hicvb', '2025-04-02 03:50:58', 'uploads/posts/post_1_1743562900.png', 1, 1, '2025-04-02 03:50:58'),
(10, 'gixfcgh vjbkn', '2025-04-02 02:03:25', 'uploads/posts/post_1_1743559405.png', 1, 1, NULL),
(11, 'hi', '2025-04-02 02:03:39', 'uploads/posts/post_1_1743559419.png', 1, 1, NULL),
(13, 'ghj', '2025-04-02 02:07:07', NULL, 1, 1, NULL),
(14, 's', '2025-04-02 02:09:30', 'uploads/posts/post_1_1743559770.png', 1, 1, NULL),
(15, 'x', '2025-04-02 02:14:56', 'uploads/posts/post_1_1743560096.png', 1, 1, NULL),
(17, 'ba', '2025-04-02 02:18:17', 'uploads/posts/post_1_1743560297.png', 1, 1, NULL),
(18, 'ghjklghjmk', '2025-04-02 03:00:27', 'uploads/posts/post_1_1743562827.png', 1, 1, '2025-04-02 03:00:27'),
(19, 'Ginaggggg kkkk', '2025-04-02 03:50:30', 'uploads/posts/post_1_1743565816.png', 1, 1, '2025-04-02 03:50:30'),
(22, 'hi monday hi', '2025-04-04 01:29:27', 'uploads/posts/post_1_1743730167.png', 1, 1, '2025-04-04 01:40:43'),
(23, 'hi ba bo bi', '2025-04-04 05:20:10', 'uploads/posts/post_1_1743733820.jpg', NULL, 1, '2025-04-04 05:20:10'),
(26, 'a jvm', '2025-04-06 02:22:13', 'uploads/posts/post_1_1743906133.png', 3, 1, '2025-04-17 02:41:50'),
(44, 'kd', '2025-04-20 02:22:05', NULL, NULL, 22, NULL),
(45, 'dm va', '2025-04-21 03:16:16', 'uploads/posts/post_23_1745205376.png', 5, 23, '2025-04-21 03:16:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`module_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
