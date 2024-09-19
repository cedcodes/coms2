-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2023 at 02:28 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new-coms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(500) DEFAULT NULL,
  `middle_name` varchar(500) DEFAULT NULL,
  `last_name` varchar(500) NOT NULL,
  `acct_type` varchar(255) NOT NULL,
  `profile_img` varchar(900) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `username` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(250) NOT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL,
  `otp_code` varchar(255) NOT NULL,
  `otp_expiration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `first_name`, `middle_name`, `last_name`, `acct_type`, `profile_img`, `is_verified`, `username`, `email`, `password`, `birthdate`, `date_added`, `date_modified`, `otp_code`, `otp_expiration`) VALUES
(1, 'Joshua Kim', 'Caraballa', 'Balanza', '1', 'test.jpg', 0, 'jokwa1', '', 'jokwa', NULL, '2023-12-15 09:26:36', NULL, '', '00:00:00'),
(2, 'Juswa', '', 'Caraballa', '0', 'test2.jpg', 0, '', '', '', NULL, '2023-12-15 09:27:50', NULL, '', '00:00:00'),
(3, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 0, 'xasxss', 'jo@s', '$2y$10$RK71H4Br6gNJ36yG1X7NZe2KqVLXi21aIT2JMIcPIcfKUu3m9LT7S', '0000-00-00', '2023-12-21 13:54:00', NULL, 'oglm476dkbic45ne0hfa1j', '06:57:00'),
(5, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 0, 'dsds', 'joyruayana@d', '$2y$10$VxHSKlV1YehWNpcE.PWsFO4pDnaDNeM7lljZC/wzFzU2aK8uUjQom', '1999-02-01', '2023-12-21 14:09:51', NULL, 'min1l4of8ce3h4akd6gbj7', '07:12:51'),
(6, 'zxc', NULL, 'zxc', 'Owner', NULL, 0, 'zcx', 'zx@d', '$2y$10$yCt7aycBpI.PpUwmbNJ97.k57p9nTjL3X9KJNFeVCBjxDfkyHwWFi', '', '2023-12-21 14:10:29', NULL, 'bhgmdoj20f4i2e4lkn5c6a', '07:13:29'),
(7, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 0, 'wewe', 'cs@d', '$2y$10$XUb9Xf5/Ny9rZzLmqgoVIu9zQVg5U.MJdf20bi5xuoMhlL.3sXBoe', '', '2023-12-21 14:19:02', NULL, 'jakhol8b9mdc9f2n8ge5i2', '07:22:02'),
(8, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 0, 'cccc', 'joyru@d', '$2y$10$BHx1xu0Gw5Y2O5fOqvLYAOatikjSXaSJuBif7K3Z4tQpFKP0mro/S', '', '2023-12-21 14:19:57', NULL, 'iefod5m9clkb3h0jag782n', '07:22:57'),
(17, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 1, 'cjruru', 'joyruayana@gmail.com', '$2y$10$PGl79mQIEGXBLdUFjrBA2eL36iwXNwSoT7FCkoskd5dcXPbE2g7Bq', '1999-02-01', '2023-12-21 20:59:36', NULL, '84519', '14:02:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
