-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 06:35 PM
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
-- Table structure for table `tbl_billings`
--

CREATE TABLE `tbl_billings` (
  `bill_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `rentamount` decimal(10,2) DEFAULT NULL,
  `electricbill` decimal(10,2) DEFAULT NULL,
  `waterbill` decimal(10,2) DEFAULT NULL,
  `total` varchar(255) GENERATED ALWAYS AS (ifnull(`rentamount`,0) + ifnull(`electricbill`,0) + ifnull(`waterbill`,0) + ifnull(`penaltyamount`,0)) STORED,
  `due_date` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `paymentstatus` varchar(50) DEFAULT NULL,
  `penaltyamount` decimal(10,2) DEFAULT NULL,
  `isnotified` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_billings`
--

INSERT INTO `tbl_billings` (`bill_id`, `space_id`, `tenant_id`, `owner_id`, `rentamount`, `electricbill`, `waterbill`, `due_date`, `created_at`, `paymentstatus`, `penaltyamount`, `isnotified`) VALUES
(1, 1, 1, 1, NULL, 1.00, 1.00, NULL, '2024-02-13 14:11:52', 'paid', NULL, NULL),
(3, 1, 1, 8, 1000.00, NULL, NULL, NULL, '2024-02-15 23:22:07', 'paid', NULL, NULL),
(4, 1, 0, 8, 0.00, 1.00, 1.00, '2024-03-17 00:00:00', '2024-02-17 08:31:04', 'unpaid', NULL, NULL),
(5, 1, 0, 8, 0.00, 12.60, 2.00, '2024-06-17 00:00:00', '2024-02-17 08:46:56', 'unpaid', NULL, NULL),
(6, 1, 0, 8, 0.00, 12.60, 640.00, '0000-00-00 00:00:00', '2024-02-17 08:52:10', 'unpaid', NULL, NULL),
(7, 1, 0, 8, 0.00, 12.60, 640.00, '2024-03-17 00:00:00', '2024-02-17 08:52:52', 'unpaid', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_billings`
--
ALTER TABLE `tbl_billings`
  ADD PRIMARY KEY (`bill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_billings`
--
ALTER TABLE `tbl_billings`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
