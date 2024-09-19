-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2024 at 01:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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
-- Table structure for table `tbl_billing_setup`
--

CREATE TABLE `tbl_billing_setup` (
  `ID` int(11) NOT NULL,
  `billing_code` varchar(500) NOT NULL,
  `billing_name` varchar(500) NOT NULL,
  `amount` float NOT NULL,
  `date_as_of` datetime NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_billing_setup`
--

INSERT INTO `tbl_billing_setup` (`ID`, `billing_code`, `billing_name`, `amount`, `date_as_of`, `date_added`, `date_modified`) VALUES
(1, 'WB-RATE', 'Water Bill Rate', 5, '2023-12-15 03:28:17', '2023-12-15 10:29:21', NULL),
(2, 'EB-RATE', 'Electricity Bill Rate', 13, '2023-12-15 03:29:31', '2023-12-15 10:29:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_concourse`
--

CREATE TABLE `tbl_concourse` (
  `con_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `con_name` varchar(500) NOT NULL,
  `con_layout` varchar(900) NOT NULL,
  `con_image` varchar(500) NOT NULL,
  `con_lat` varchar(500) DEFAULT NULL,
  `con_long` varchar(500) DEFAULT NULL,
  `con_address` varchar(500) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_concourse`
--

INSERT INTO `tbl_concourse` (`con_id`, `owner_id`, `con_name`, `con_layout`, `con_image`, `con_lat`, `con_long`, `con_address`, `date_added`, `date_modified`) VALUES
(11, 1, 'Phoebe Kate Resort', '65b644beb149d.jpg', '65b644beb1483.jpg', '14.423292316333436', '120.54735660552979', 'CGFW+8W Mariveles, Bataan, Philippines', '2024-01-28 20:12:46', NULL),
(12, 1, 'Testing', '65b647263e039.png', '65b647263df4b.png', '14.387945212084704', '120.91734323730472', '9WQ8+5W Imus, Cavite, Philippines', '2024-01-28 20:23:02', NULL),
(13, 1, 'Test', '65b6473ae1c5d.jpg', '65b6473ae1b0c.jpg', '14.636556798143125', '121.09999094238285', '1 Cirma, Marikina, 1800 Metro Manila, Philippines', '2024-01-28 20:23:22', NULL),
(14, 1, 'test', '65b647c74a6bc.jpg', '65b647c74a56c.jpg', '14.768962546912626', '121.04042114323676', '175 Sitio matarik, Barangay 175, Caloocan, North, Barangay 175, Caloocan, Metro Manila, Philippines', '2024-01-28 20:25:43', NULL),
(15, 1, 'Sari Shop', '65b647e5c4bac.jpg', '65b647e5c4b8c.jpg', '14.768985410549767', '121.04057788482606', '2434 Block 2 Sitio matarik Baranggay 175 Camarin, Barangay 175, Caloocan, Metro Manila, Philippines', '2024-01-28 20:26:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_credentials`
--

CREATE TABLE `tbl_credentials` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(900) NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification`
--

CREATE TABLE `tbl_notification` (
  `notif_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `notif_title` varchar(500) NOT NULL,
  `notif_details` varchar(500) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_shown` tinyint(1) NOT NULL DEFAULT 1,
  `notif_type` int(11) NOT NULL DEFAULT 0,
  `notif_to_all` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_notification`
--

INSERT INTO `tbl_notification` (`notif_id`, `user_id`, `notif_title`, `notif_details`, `is_read`, `is_shown`, `notif_type`, `notif_to_all`, `date_added`, `date_modified`) VALUES
(3, 2, 'New Applicant - Joshua Kim Balanza', 'Hi, Juswa, you have a new application for your space (space1), for your review.', 1, 0, 1, 0, '2023-12-15 19:48:13', NULL),
(4, 1, 'New Applicant - Juswa Caraballa', 'Hi, Joshua Kim, you have a new application for your space (space2), for your review.', 0, 1, 1, 0, '2023-12-15 20:02:33', NULL),
(5, 1, 'Your Application is Approved', 'Hi, Joshua Kim, WELCOME! we would like to inform you that your application has been now approved.', 0, 1, 2, 0, '2023-12-15 20:03:15', NULL),
(6, 1, 'Your Application is Rejected', 'Hi, Juswa, your application has been rejected, owner remarks - \"no requirements found!\", you can freely retry to application again until it is available, thank you.', 0, 1, 3, 0, '2023-12-15 20:04:39', NULL),
(7, 2, 'Your Application has been Approved', 'Hi, Juswa, WELCOME! we would like to inform you that your application has been now approved.', 1, 0, 0, 0, '2023-12-15 20:08:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_spaces`
--

CREATE TABLE `tbl_spaces` (
  `space_id` int(11) NOT NULL,
  `con_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `space_name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `space_width` int(11) NOT NULL,
  `space_length` int(11) NOT NULL,
  `space_area` float GENERATED ALWAYS AS (`space_width` * `space_length`) STORED,
  `space_dimension` varchar(255) GENERATED ALWAYS AS (concat(`space_width`,' x ',`space_length`)) STORED,
  `space_coord_x` int(11) NOT NULL,
  `space_coord_y` int(11) NOT NULL,
  `space_coord_h` int(11) NOT NULL,
  `space_coord_w` int(11) NOT NULL,
  `space_price` float NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_spaces`
--

INSERT INTO `tbl_spaces` (`space_id`, `con_id`, `owner_id`, `space_name`, `status`, `space_width`, `space_length`, `space_coord_x`, `space_coord_y`, `space_coord_h`, `space_coord_w`, `space_price`, `date_added`, `date_modified`) VALUES
(1, 1, 1, 'space1', 2, 12, 12, 12, 12, 12, 12, 1200, '2023-12-15 09:30:54', '2023-12-15 20:03:15'),
(2, 1, 1, 'space2', 2, 12, 14, 12, 12, 12, 12, 1500, '2023-12-15 09:35:12', '2023-12-15 20:08:59');

--
-- Triggers `tbl_spaces`
--
DELIMITER $$
CREATE TRIGGER `trg_modified_spaces` BEFORE UPDATE ON `tbl_spaces` FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tenant`
--

CREATE TABLE `tbl_tenant` (
  `ID` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `con_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_tenant`
--

INSERT INTO `tbl_tenant` (`ID`, `tenant_id`, `space_id`, `con_id`, `owner_id`, `is_active`, `date_added`, `date_modified`) VALUES
(1, 1, 1, 1, 2, 1, '2023-12-15 20:03:15', NULL),
(2, 2, 2, 1, 1, 1, '2023-12-15 20:08:59', NULL);

--
-- Triggers `tbl_tenant`
--
DELIMITER $$
CREATE TRIGGER `trg_modified_tenant` BEFORE UPDATE ON `tbl_tenant` FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_notification_welcome` AFTER INSERT ON `tbl_tenant` FOR EACH ROW INSERT INTO tbl_notification(
    user_id, 
    notif_title, 
    notif_details, 
    date_added
)
VALUES(
    NEW.tenant_id,
    CONCAT('Your Application has been Approved'),
    CONCAT('Hi, ', (SELECT first_name FROM tbl_user WHERE user_id = NEW.tenant_id), ', WELCOME! we would like to inform you that your application has been approved.'),
    CURRENT_TIMESTAMP()
)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tenant_application`
--

CREATE TABLE `tbl_tenant_application` (
  `application_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `con_id` int(11) NOT NULL,
  `space_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT 0,
  `requirements_file` varchar(900) NOT NULL,
  `owner_remarks` varchar(500) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_tenant_application`
--

INSERT INTO `tbl_tenant_application` (`application_id`, `tenant_id`, `con_id`, `space_id`, `owner_id`, `is_approved`, `requirements_file`, `owner_remarks`, `date_added`, `date_modified`) VALUES
(4, 1, 1, 1, 2, 1, 'Test', NULL, '2023-12-15 19:48:13', '2023-12-15 20:03:15'),
(5, 2, 1, 2, 1, 1, 'test', 'no requirements found!', '2023-12-15 20:02:33', '2023-12-15 20:08:59');

--
-- Triggers `tbl_tenant_application`
--
DELIMITER $$
CREATE TRIGGER `trg_approved_application` AFTER UPDATE ON `tbl_tenant_application` FOR EACH ROW IF NEW.is_approved = 1
THEN
	INSERT INTO tbl_tenant(tenant_id, space_id, owner_id, con_id) VALUES(NEW.tenant_id, NEW.space_id, NEW.owner_id, NEW.con_id);
    
    UPDATE tbl_spaces SET status = 2 WHERE space_id = NEW.space_id AND con_id = NEW.con_id;
    
ELSEIF NEW.is_approved = 2
THEN
	UPDATE tbl_spaces SET status = 0 WHERE space_id = NEW.space_id AND con_id = NEW.con_id;
    
    INSERT INTO tbl_notification(
    user_id, 
    notif_title, 
    notif_details, 
    date_added
	)
	VALUES(
    NEW.owner_id,
    CONCAT('Your Application has been Rejected'),
    CONCAT('Hi, ', (SELECT first_name FROM tbl_user WHERE user_id = NEW.tenant_id), ', your application has been rejected, owner remarks - "', NEW.owner_remarks, '", if you wish to retry? just submit a new application, until your target space is available, thank you.'),
    CURRENT_TIMESTAMP()
	);

END IF
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_modified_application` BEFORE UPDATE ON `tbl_tenant_application` FOR EACH ROW SET NEW.date_modified = CURRENT_TIMESTAMP()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_new_application` AFTER INSERT ON `tbl_tenant_application` FOR EACH ROW IF NEW.is_approved = 0
THEN

	UPDATE tbl_spaces SET status = 1 WHERE space_id = NEW.space_id AND con_id = NEW.con_id;

	INSERT INTO tbl_notification(
    	user_id, 
    	notif_title, 
    	notif_details, 
    	date_added
	)
	VALUES(
    	NEW.owner_id,
    	CONCAT('New Applicant - ', (SELECT first_name FROM tbl_user WHERE user_id = NEW.tenant_id), ' ', (SELECT last_name FROM tbl_user WHERE user_id = NEW.tenant_id)),
    	CONCAT('Hi, ', (SELECT first_name FROM tbl_user WHERE user_id = NEW.owner_id), ', you have a new application for your space (',(SELECT space_name FROM tbl_spaces WHERE space_id = NEW.space_id), '), for your review.'),
    	CURRENT_TIMESTAMP()
	);

END IF
$$
DELIMITER ;

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
(17, 'Carla Joy', NULL, 'Ruayana', 'Owner', NULL, 1, 'cjruru', 'joyruayana@gmail.com', '$2y$10$PGl79mQIEGXBLdUFjrBA2eL36iwXNwSoT7FCkoskd5dcXPbE2g7Bq', '1999-02-01', '2023-12-21 20:59:36', NULL, '84519', '14:02:31'),
(18, 'Joshua Kim', NULL, 'Balanza', 'Owner', NULL, 1, 'jkbalanza', 'joshuabalanza@gmail.com', '$2y$10$n6qYTIScGY/ThD8ZV3Cr1uZLwheuBVdmI0n767WZL/hMzhixYaSvK', '1997-11-08', '2023-12-22 18:24:35', NULL, '38097', '11:27:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_billing_setup`
--
ALTER TABLE `tbl_billing_setup`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_concourse`
--
ALTER TABLE `tbl_concourse`
  ADD PRIMARY KEY (`con_id`);

--
-- Indexes for table `tbl_credentials`
--
ALTER TABLE `tbl_credentials`
  ADD UNIQUE KEY `userid` (`user_id`);

--
-- Indexes for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `tbl_spaces`
--
ALTER TABLE `tbl_spaces`
  ADD PRIMARY KEY (`space_id`);

--
-- Indexes for table `tbl_tenant`
--
ALTER TABLE `tbl_tenant`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbl_tenant_application`
--
ALTER TABLE `tbl_tenant_application`
  ADD PRIMARY KEY (`application_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_billing_setup`
--
ALTER TABLE `tbl_billing_setup`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_concourse`
--
ALTER TABLE `tbl_concourse`
  MODIFY `con_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_notification`
--
ALTER TABLE `tbl_notification`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_spaces`
--
ALTER TABLE `tbl_spaces`
  MODIFY `space_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_tenant`
--
ALTER TABLE `tbl_tenant`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_tenant_application`
--
ALTER TABLE `tbl_tenant_application`
  MODIFY `application_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
