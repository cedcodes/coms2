-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 06:34 PM
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
-- Table structure for table `tbl_spaces`
--

CREATE TABLE `tbl_spaces` (
  `space_id` int(11) NOT NULL,
  `con_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `space_name` varchar(500) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `space_width` int(11) NOT NULL,
  `space_length` int(11) NOT NULL,
  `space_area` float GENERATED ALWAYS AS (`space_width` * `space_length`) STORED,
  `space_dimension` varchar(255) GENERATED ALWAYS AS (concat(`space_width`,' x ',`space_length`)) STORED,
  `space_coord_x` int(11) NOT NULL,
  `space_coord_y` int(11) NOT NULL,
  `space_coord_x2` int(11) NOT NULL,
  `space_coord_y2` int(11) NOT NULL,
  `space_price` float NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_spaces`
--

INSERT INTO `tbl_spaces` (`space_id`, `con_id`, `owner_id`, `tenant_id`, `space_name`, `status`, `space_width`, `space_length`, `space_coord_x`, `space_coord_y`, `space_coord_x2`, `space_coord_y2`, `space_price`, `date_added`, `date_modified`) VALUES
(1, 1, 8, 0, 'sample', 0, 0, 0, 0, 0, 0, 0, 0, '2024-02-16 07:41:33', NULL);

--
-- Triggers `tbl_spaces`
--
DELIMITER $$
CREATE TRIGGER `trg_delete_spaces` AFTER DELETE ON `tbl_spaces` FOR EACH ROW DELETE FROM tbl_tenant WHERE space_id = OLD.space_id AND con_id = OLD.con_id AND owner_id = OLD.con_id
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_modified_spaces` BEFORE UPDATE ON `tbl_spaces` FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP()
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
