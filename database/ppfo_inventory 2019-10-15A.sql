-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2019 at 07:45 AM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ppfo_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `full_name` varchar(64) NOT NULL,
  `account_type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `full_name`, `account_type`) VALUES
(1, 'ronie', 'ronie', 'Ronie Bituin', 'admin'),
(2, 'user', 'user', 'Default User', 'lab_assistant'),
(3, 'marvin', 'marvin', 'Marvin Reyes', 'admin'),
(4, 'admin', 'admin', 'Default Admin', 'admin'),
(6, 'maintenance', 'maintenance', 'Default Maintenance', 'maintenance'),
(7, 'PPFO', 'PPFO', 'Default PPFO', 'ppfo'),
(8, 'president', 'president', 'President', 'president'),
(9, 'dean', 'dean', 'Sample', 'lab_assistant');

-- --------------------------------------------------------

--
-- Table structure for table `aircon`
--

CREATE TABLE `aircon` (
  `id` int(11) NOT NULL,
  `aircon_id` int(11) NOT NULL,
  `brand` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building`
--

CREATE TABLE `building` (
  `building_id` int(11) NOT NULL,
  `building_name` varchar(128) NOT NULL,
  `building_code` varchar(32) NOT NULL,
  `building_description` text NOT NULL,
  `added_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `building`
--

INSERT INTO `building` (`building_id`, `building_name`, `building_code`, `building_description`, `added_by`) VALUES
(1, 'I.T BUILDING', 'I.TBU001', 'I.T Building in front of SPCF hehe', 'ronie'),
(2, 'CHM', 'CHM002', 'CHM at the back!', 'ronie'),
(3, 'SENIOR HIGH SCHOOL BUILDING', 'SENIO003', 'Senior High School Building at the back', 'ronie'),
(4, 'SPCF CALOOCAN', 'SPCFC004', 'Building in Manila', 'ronie'),
(5, 'MIRANDA', 'MIRAN005', 'Miranda lol', 'ronie'),
(6, 'SAINT JOSEPH', 'SAINT006', 'Saint JosephSaint Joseph', 'ronie'),
(7, 'RIZAL', 'RIZAL007', 'Rizal', 'ronie'),
(8, 'SPCF SAN FERNANDO', 'SPCFS008', 'SPCF SAN FERNANDO for the WIN', 'ronie'),
(10, 'AARON BUILDING', 'AARON0010', 'Sa likod', 'Default Admin'),
(11, 'MT. CARMEL', 'MT.CA0011', 'MT. CARMEL BUILDING', 'Default Admin');

-- --------------------------------------------------------

--
-- Table structure for table `context_logs`
--

CREATE TABLE `context_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(32) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `context_logs`
--

INSERT INTO `context_logs` (`id`, `username`, `description`, `type`, `date_added`) VALUES
(236, 'Ronie Bituin', 'Added PERIPHERALS to Unit PC with and ID: 13', 'addition', '2019-10-09 05:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE `designation` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `building_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `designation`
--

INSERT INTO `designation` (`id`, `account_id`, `building_id`) VALUES
(1, 2, 1),
(4, 2, 2),
(5, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_transfer`
--

CREATE TABLE `equipment_transfer` (
  `id` int(11) NOT NULL,
  `equipment_id` varchar(12) NOT NULL,
  `type` varchar(128) NOT NULL,
  `from_building` varchar(12) DEFAULT NULL,
  `from_lab` varchar(12) DEFAULT NULL,
  `to_building` varchar(12) DEFAULT NULL,
  `to_laboratory` varchar(12) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipment_transfer`
--

INSERT INTO `equipment_transfer` (`id`, `equipment_id`, `type`, `from_building`, `from_lab`, `to_building`, `to_laboratory`, `date_added`, `status`) VALUES
(29, '11', 'PC', '1', '13', '10', '19', '2019-10-09', 'completed'),
(32, '13', 'PC', '1', '13', '10', '19', '2019-10-15', 'completed'),
(33, '121', 'AIRCONDITIONER', '10', '19', '1', '16', '2019-10-15', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `fixture`
--

CREATE TABLE `fixture` (
  `id` int(11) NOT NULL,
  `type` text NOT NULL,
  `batch_code` varchar(64) NOT NULL,
  `serial_no` varchar(64) DEFAULT NULL,
  `building_id` int(11) NOT NULL,
  `lab_id` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_last_clean` date NOT NULL DEFAULT current_timestamp(),
  `fixture_condition` text NOT NULL DEFAULT 'working',
  `remarks` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fixture`
--

INSERT INTO `fixture` (`id`, `type`, `batch_code`, `serial_no`, `building_id`, `lab_id`, `date_added`, `date_last_clean`, `fixture_condition`, `remarks`) VALUES
(54, 'monoBlocChair', 'OFFICECHAIR1909021354', 'THERE SHOULD BE NO SC HEHE', 1, '15', '2019-09-02 13:54:56', '2019-09-02', 'paki ayus po Salamat', 'For Repair'),
(121, 'airconditioner', 'AIRCONDITIONER1909171728', '011503741', 1, '16', '2019-09-17 17:28:05', '2019-09-17', 'working', 'OK'),
(122, 'airconditioner', 'AIRCONDITIONER1909171734', 'BA-00000416', 10, '20', '2019-09-17 17:34:11', '2019-09-17', 'working', 'OK'),
(123, 'airconditioner', 'AIRCONDITIONER1909171734', 'SN 2519-020018', 10, '20', '2019-09-17 17:34:11', '2019-09-17', 'working', 'OK'),
(124, 'airconditioner', 'AIRCONDITIONER1909171737', 'MODEL: LA15ORB', 10, '21', '2019-09-17 17:37:06', '2019-09-17', 'working', 'OK'),
(125, 'airconditioner', 'AIRCONDITIONER1909171737', 'BA-00000417', 10, '21', '2019-09-17 17:37:06', '2019-09-17', 'working', 'OK'),
(126, 'airconditioner', 'AIRCONDITIONER1909171745', '51QSXRACCON19-KED H16PC-0820683', 10, '22', '2019-09-17 17:45:17', '2019-09-17', 'working', 'OK'),
(127, 'airconditioner', 'AIRCONDITIONER1909171745', 'BA-00000418', 10, '22', '2019-09-17 17:45:17', '2019-09-17', 'working', 'OK'),
(128, 'airconditioner', 'AIRCONDITIONER1909171745', 'SN 2519-020048', 10, '22', '2019-09-17 17:45:17', '2019-09-17', 'working', 'OK'),
(129, 'airconditioner', 'AIRCONDITIONER1909171747', '51QSXRACCON24-KEAB16PC-0530179', 10, '23', '2019-09-17 17:47:58', '2019-09-17', 'working', 'OK'),
(130, 'airconditioner', 'AIRCONDITIONER1909171747', 'BA-00000420', 10, '23', '2019-09-17 17:47:58', '2019-09-17', 'working', 'OK'),
(131, 'airconditioner', 'AIRCONDITIONER1909171747', 'SN 2419-020042', 10, '23', '2019-09-17 17:47:58', '2019-09-17', 'working', 'OK'),
(132, 'airconditioner', 'AIRCONDITIONER1909171749', '51QSXRACCON24-KEA B16PC-0133404', 10, '24', '2019-09-17 17:49:49', '2019-09-17', 'working', 'OK'),
(133, 'airconditioner', 'AIRCONDITIONER1909171749', 'BA-00000419', 10, '24', '2019-09-17 17:49:49', '2019-09-17', 'working', 'OK'),
(134, 'airconditioner', 'AIRCONDITIONER1909171749', 'SN 2519-020047', 10, '24', '2019-09-17 17:49:49', '2019-09-17', 'working', 'OK'),
(136, 'airconditioner', 'AIRCONDITIONER1909171751', 'BA-00000421', 10, '25', '2019-09-17 17:51:32', '2019-09-17', 'asdasd', 'Fixed'),
(137, 'airconditioner', 'AIRCONDITIONER1909171751', 'SN 2519-020030', 10, '25', '2019-09-17 17:51:32', '2019-09-17', 'working', 'OK'),
(152, 'flourescentLights', 'FLOURESCENTLIGHTS1910081604', NULL, 1, '13', '2019-10-08 16:04:09', '2019-10-08', 'working', 'OK');

-- --------------------------------------------------------

--
-- Table structure for table `fix_report`
--

CREATE TABLE `fix_report` (
  `id` int(11) NOT NULL,
  `type` varchar(64) DEFAULT NULL,
  `item_id` varchar(12) DEFAULT NULL,
  `repair_cost` decimal(12,2) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `file_name` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fix_report`
--

INSERT INTO `fix_report` (`id`, `type`, `item_id`, `repair_cost`, `date_added`, `file_name`) VALUES
(18, 'fixture', '136', '13423.00', '2019-10-12', 'ItemID-136Fixed134232019-10-12-11-01-57.png');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory`
--

CREATE TABLE `laboratory` (
  `lab_id` int(11) NOT NULL,
  `lab_code` varchar(32) NOT NULL,
  `lab_name` varchar(64) NOT NULL,
  `lab_description` text NOT NULL,
  `building_id` int(11) NOT NULL,
  `added_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `laboratory`
--

INSERT INTO `laboratory` (`lab_id`, `lab_code`, `lab_name`, `lab_description`, `building_id`, `added_by`) VALUES
(11, 'GAMIN0011', 'GAMING ROOM', 'where student play', 7, 'Marvin Reyes'),
(13, 'CISCO0013', 'CISCO LAB', 'CISCO LAB', 1, 'Default Admin'),
(14, 'OPENS0014', 'OPEN SOURCE', 'OPEN SOURCE', 1, 'Default Admin'),
(15, 'MACLA0015', 'MAC LAB', 'Mac Laboratories full of Mac', 1, 'Default Admin'),
(16, 'LABOR0016', 'LABORATORY 3', 'Lab 3', 1, 'Default Admin'),
(19, 'MEDIC0019', 'MEDIC LAB', 'medic lab ni Aaron Building', 10, 'Default Admin'),
(20, 'FACUL0020', 'FACULTY ELEM', 'RM 102', 10, 'Default Admin'),
(21, 'ALUMN0021', 'ALUMNI AND ACAP', 'RM 103', 10, 'Default Admin'),
(22, 'AB1040022', 'AB 104', 'ROOM', 10, 'Default Admin'),
(23, 'AB1050023', 'AB 105', 'ROOM', 10, 'Default Admin'),
(24, 'AB1060024', 'AB 106', 'ROOM', 10, 'Default Admin'),
(25, 'AB1070025', 'AB 107', 'ROOM', 10, 'Default Admin'),
(26, 'AB1080026', 'AB 108', 'ROOM', 10, 'Default Admin'),
(27, 'AB1090027', 'AB 109', 'ROOM', 10, 'Default Admin'),
(28, 'AB1100028', 'AB 110', 'ROOM', 10, 'Default Admin'),
(29, 'AB1110029', 'AB 111', 'ROOM', 10, 'Default Admin'),
(30, 'AB1120030', 'AB 112', 'ROOM', 10, 'Default Admin');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int(11) NOT NULL,
  `department` varchar(128) NOT NULL,
  `date_requested` date NOT NULL,
  `electrical` int(11) NOT NULL,
  `mechanical` int(11) NOT NULL,
  `carpentry` int(11) NOT NULL,
  `janitorial` int(11) NOT NULL,
  `others` int(11) NOT NULL,
  `others_text` text NOT NULL,
  `request` text NOT NULL,
  `action_taken` text NOT NULL,
  `date_action_taken` date DEFAULT NULL,
  `requested_by` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`id`, `department`, `date_requested`, `electrical`, `mechanical`, `carpentry`, `janitorial`, `others`, `others_text`, `request`, `action_taken`, `date_action_taken`, `requested_by`) VALUES
(1, 'ICTDU', '2019-09-01', 0, 0, 0, 0, 1, 'asd', 'asd', 'tapos!', '2019-09-06', 'Ronie Bituin'),
(2, 'ICTDU', '2019-08-13', 1, 0, 0, 0, 1, 'Yes yes', 'Sample Request', 'Action Taken', '2019-09-06', 'Ronie Bituin'),
(3, 'ICTDU', '2019-08-13', 1, 1, 1, 1, 1, 'Others Text', 'Request Text', 'tapos!', '2019-09-06', 'Ronie Bituin'),
(4, 'This Building hello', '2019-08-22', 1, 1, 1, 1, 1, 'asd', 'asd', 'tapos!', '2019-09-06', 'Default Lab Assistant'),
(5, 'asd', '2019-08-22', 1, 0, 0, 0, 0, '', 'asd', 'tapos!', '2019-09-06', 'Default Lab Assistant'),
(6, 'ITS', '2019-08-30', 1, 1, 1, 1, 0, 'SAmple', 'Pa yus yung whitebpard', 'tapos!', '2019-09-06', 'Default Admin'),
(7, 'ICTDU', '2019-09-06', 1, 1, 1, 1, 1, 'Yes Others', 'Sample', '', NULL, 'Ronie Bituin');

-- --------------------------------------------------------

--
-- Table structure for table `peripherals`
--

CREATE TABLE `peripherals` (
  `peripheral_id` int(11) NOT NULL,
  `peripheral_type` varchar(32) NOT NULL,
  `peripheral_brand` varchar(128) NOT NULL,
  `peripheral_description` text NOT NULL,
  `peripheral_serial_no` varchar(64) NOT NULL,
  `peripheral_date_purchased` date NOT NULL,
  `peripheral_amount` float DEFAULT NULL,
  `peripheral_date_issued` date NOT NULL,
  `peripheral_condition` text NOT NULL,
  `remarks` varchar(64) NOT NULL,
  `added_by` varchar(32) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `peripherals`
--

INSERT INTO `peripherals` (`peripheral_id`, `peripheral_type`, `peripheral_brand`, `peripheral_description`, `peripheral_serial_no`, `peripheral_date_purchased`, `peripheral_amount`, `peripheral_date_issued`, `peripheral_condition`, `remarks`, `added_by`, `unit_id`) VALUES
(1, 'Monitor', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'For Repair', 'For Repair', 'Ronie Bituin', 13),
(2, 'Keyboard', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(3, 'Mouse', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(4, 'AVR', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(5, 'Headset', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(6, 'CPU', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-09-30', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(7, 'Motherboard', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(8, 'GPU', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(9, 'RAM', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2019-10-01', 'Working', 'Not For Repair', 'Ronie Bituin', 13),
(10, 'HDD', 'ASUS', 'ASUS', 'ASUS', '2019-10-01', 1, '2018-05-30', 'Working', 'Not For Repair', 'Ronie Bituin', 13);

-- --------------------------------------------------------

--
-- Table structure for table `stock_room`
--

CREATE TABLE `stock_room` (
  `id` int(11) NOT NULL,
  `batch_id` varchar(64) NOT NULL,
  `date_added` datetime NOT NULL,
  `item` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `beg_inventory` int(12) NOT NULL,
  `request_item` int(12) NOT NULL,
  `purchased_item` int(12) NOT NULL,
  `total_qty` int(12) NOT NULL,
  `remarks` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_room`
--

INSERT INTO `stock_room` (`id`, `batch_id`, `date_added`, `item`, `description`, `beg_inventory`, `request_item`, `purchased_item`, `total_qty`, `remarks`) VALUES
(1, 'HDD190808093821', '2019-08-08 09:38:21', 'HDD', 'Hard Disk Drive', 0, 0, 5, 5, 'old'),
(2, 'HDD190808093821', '2019-08-08 09:38:34', 'HDD', 'Hard Disk Drive', 5, 1, 0, 4, 'old'),
(4, 'HDD190808172527', '2019-08-08 17:25:27', 'HDD', '', 0, 0, 1, 1, 'old'),
(5, 'HDD190808172527', '2019-08-08 17:25:50', 'HDD', 'Hard Disk Driveeee', 1, 0, 1, 2, 'old'),
(6, 'HDD190808172527', '2019-08-08 17:26:10', 'HDD', 'Hard Disk Driveeee', 2, 2, 0, 0, 'old'),
(8, 'HDD190808093821', '2019-08-23 11:10:33', 'HDD', 'Hard Disk Drive', 4, 4, 5, 5, 'old'),
(10, 'MNTR190830135129', '2019-08-30 13:51:29', 'Monitor', 'Acer', 0, 0, 4, 4, 'old'),
(12, 'MNTR190917180747', '2019-09-17 18:07:47', 'Monitor', 'Monitor', 0, 0, 5, 5, 'old'),
(13, 'MNTR190917180747', '2019-09-17 18:07:59', 'Monitor', 'Monitor', 5, 5, 0, 0, 'new'),
(14, 'MNTR190830135129', '2019-09-17 18:09:08', 'Monitor', 'Acer', 4, 4, 0, 0, 'new');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_record`
--

CREATE TABLE `transaction_record` (
  `id` int(11) NOT NULL,
  `type` varchar(128) DEFAULT NULL,
  `type_id` varchar(64) DEFAULT NULL,
  `cost` decimal(12,3) DEFAULT NULL,
  `date_added` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction_record`
--

INSERT INTO `transaction_record` (`id`, `type`, `type_id`, `cost`, `date_added`) VALUES
(22, 'vehicle', '1', '23432.000', '2019-10-12'),
(23, 'vehicle', '1', '234234.000', '2019-10-12'),
(24, 'vehicle', '1', '34343.000', '2019-10-12'),
(25, 'vehicle', '1', '234234.000', '2019-10-12'),
(26, 'vehicle', '1', '234234.000', '2019-10-12'),
(27, 'vehicle', '1', '643434.000', '2019-10-12');

-- --------------------------------------------------------

--
-- Table structure for table `unit_pc`
--

CREATE TABLE `unit_pc` (
  `unit_id` int(11) NOT NULL,
  `unit_no` int(12) NOT NULL,
  `unit_name` varchar(64) NOT NULL,
  `lab_id` varchar(64) NOT NULL,
  `building_id` int(11) NOT NULL,
  `status` varchar(32) NOT NULL,
  `added_by` varchar(32) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_pc`
--

INSERT INTO `unit_pc` (`unit_id`, `unit_no`, `unit_name`, `lab_id`, `building_id`, `status`, `added_by`, `date_added`) VALUES
(11, 1, 'PC1', '19', 10, 'working', 'Default Admin', '2019-10-09 01:38:36'),
(12, 2, 'PC2', '13', 1, 'working', 'Default Admin', '2019-09-04 09:50:01'),
(13, 3, 'PC3', '19', 10, 'working', 'Default Admin', '2019-10-15 05:11:23'),
(14, 4, 'PC4', '13', 1, 'working', 'Default Admin', '2019-09-04 08:13:11'),
(15, 5, 'PC5', '13', 1, 'working', 'Default Admin', '2019-09-04 08:13:12'),
(16, 6, 'PC6', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(17, 7, 'PC7', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(18, 8, 'PC8', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(19, 9, 'PC9', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(20, 10, 'PC10', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(21, 11, 'PC11', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(22, 12, 'PC12', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(23, 13, 'PC13', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(24, 14, 'PC14', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(25, 15, 'PC15', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(26, 16, 'PC16', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(27, 17, 'PC17', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(28, 18, 'PC18', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(29, 19, 'PC19', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(30, 20, 'PC20', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(31, 21, 'PC21', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(32, 22, 'PC22', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(33, 23, 'PC23', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(34, 24, 'PC24', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(35, 25, 'PC25', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(36, 26, 'PC26', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(37, 27, 'PC27', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(38, 28, 'PC28', '13', 1, 'working', 'Default Admin', '2019-08-30 05:39:07'),
(39, 29, 'PC29', 'stock_room', 1, 'working', 'Default Admin', '2019-09-04 10:13:42'),
(60, 1, 'PC1', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(61, 2, 'PC2', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(62, 3, 'PC3', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(63, 4, 'PC4', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(64, 5, 'PC5', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(65, 6, 'PC6', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(66, 7, 'PC7', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(67, 8, 'PC8', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(68, 9, 'PC9', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(69, 10, 'PC10', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(70, 11, 'PC11', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(71, 12, 'PC12', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(72, 13, 'PC13', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(73, 14, 'PC14', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(74, 15, 'PC15', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(75, 16, 'PC16', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(76, 17, 'PC17', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(77, 18, 'PC18', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(78, 19, 'PC19', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(79, 20, 'PC20', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(80, 21, 'PC21', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(81, 22, 'PC22', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(82, 23, 'PC23', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(83, 24, 'PC24', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(84, 25, 'PC25', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(85, 26, 'PC26', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(86, 27, 'PC27', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(87, 28, 'PC28', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(88, 29, 'PC29', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(89, 30, 'PC30', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:42'),
(90, 31, 'PC31', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(91, 32, 'PC32', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(92, 33, 'PC33', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(93, 34, 'PC34', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(94, 35, 'PC35', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(95, 36, 'PC36', '14', 1, 'working', 'Default Admin', '2019-09-02 02:07:53'),
(96, 1, 'PC1', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(97, 2, 'PC2', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(98, 3, 'PC3', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(99, 4, 'PC4', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(100, 5, 'PC5', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(101, 6, 'PC6', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(102, 7, 'PC7', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(103, 8, 'PC8', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(104, 9, 'PC9', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(105, 10, 'PC10', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(106, 11, 'PC11', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(107, 12, 'PC12', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(108, 13, 'PC13', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(109, 14, 'PC14', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(110, 15, 'PC15', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(111, 16, 'PC16', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(112, 17, 'PC17', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(113, 18, 'PC18', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(114, 19, 'PC19', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(115, 20, 'PC20', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(116, 21, 'PC21', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(117, 22, 'PC22', 'stock_room', 1, 'working', 'Default Admin', '2019-09-04 10:12:59'),
(118, 23, 'PC23', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(119, 24, 'PC24', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(120, 25, 'PC25', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(121, 26, 'PC26', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(122, 27, 'PC27', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(123, 28, 'PC28', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(124, 29, 'PC29', '15', 1, 'working', 'Default Admin', '2019-09-02 02:56:42'),
(125, 1, 'PC1', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(126, 2, 'PC2', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(127, 3, 'PC3', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(128, 4, 'PC4', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(129, 5, 'PC5', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(130, 6, 'PC6', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(131, 7, 'PC7', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(132, 8, 'PC8', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(133, 9, 'PC9', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(134, 10, 'PC10', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(135, 11, 'PC11', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(136, 12, 'PC12', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(137, 13, 'PC13', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(138, 14, 'PC14', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(139, 15, 'PC15', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(140, 16, 'PC16', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(141, 17, 'PC17', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(142, 18, 'PC18', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(143, 19, 'PC19', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(144, 20, 'PC20', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(145, 21, 'PC21', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(146, 22, 'PC22', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(147, 23, 'PC23', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(148, 24, 'PC24', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(149, 25, 'PC25', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(150, 26, 'PC26', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(151, 27, 'PC27', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(152, 28, 'PC28', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(153, 29, 'PC29', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(154, 30, 'PC30', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:05'),
(155, 31, 'PC31', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(156, 32, 'PC32', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(157, 33, 'PC33', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(158, 34, 'PC34', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(159, 35, 'PC35', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(160, 36, 'PC36', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15'),
(161, 37, 'PC37', '16', 1, 'working', 'Default Admin', '2019-09-02 06:09:15');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  `plate_no` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_expense`
--

CREATE TABLE `vehicle_expense` (
  `id` int(11) NOT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `expense_type` varchar(128) DEFAULT NULL,
  `expense_cost` decimal(12,2) DEFAULT NULL,
  `expense_description` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `file_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aircon`
--
ALTER TABLE `aircon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aircon_id` (`aircon_id`);

--
-- Indexes for table `building`
--
ALTER TABLE `building`
  ADD PRIMARY KEY (`building_id`);

--
-- Indexes for table `context_logs`
--
ALTER TABLE `context_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designation`
--
ALTER TABLE `designation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `equipment_transfer`
--
ALTER TABLE `equipment_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fixture`
--
ALTER TABLE `fixture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `building_id` (`building_id`) USING BTREE;

--
-- Indexes for table `fix_report`
--
ALTER TABLE `fix_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD PRIMARY KEY (`lab_id`),
  ADD KEY `building_id` (`building_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peripherals`
--
ALTER TABLE `peripherals`
  ADD PRIMARY KEY (`peripheral_id`),
  ADD KEY `unit_id` (`unit_id`);

--
-- Indexes for table `stock_room`
--
ALTER TABLE `stock_room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_record`
--
ALTER TABLE `transaction_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_pc`
--
ALTER TABLE `unit_pc`
  ADD PRIMARY KEY (`unit_id`),
  ADD KEY `building_id` (`building_id`),
  ADD KEY `lab_id` (`lab_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_expense`
--
ALTER TABLE `vehicle_expense`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `aircon`
--
ALTER TABLE `aircon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `building`
--
ALTER TABLE `building`
  MODIFY `building_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `context_logs`
--
ALTER TABLE `context_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `designation`
--
ALTER TABLE `designation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `equipment_transfer`
--
ALTER TABLE `equipment_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `fixture`
--
ALTER TABLE `fixture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `fix_report`
--
ALTER TABLE `fix_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `laboratory`
--
ALTER TABLE `laboratory`
  MODIFY `lab_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `peripherals`
--
ALTER TABLE `peripherals`
  MODIFY `peripheral_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `stock_room`
--
ALTER TABLE `stock_room`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `transaction_record`
--
ALTER TABLE `transaction_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `unit_pc`
--
ALTER TABLE `unit_pc`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicle_expense`
--
ALTER TABLE `vehicle_expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aircon`
--
ALTER TABLE `aircon`
  ADD CONSTRAINT `aircon_ibfk_1` FOREIGN KEY (`aircon_id`) REFERENCES `fixture` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designation`
--
ALTER TABLE `designation`
  ADD CONSTRAINT `designation_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fixture`
--
ALTER TABLE `fixture`
  ADD CONSTRAINT `fixture_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laboratory`
--
ALTER TABLE `laboratory`
  ADD CONSTRAINT `laboratory_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `peripherals`
--
ALTER TABLE `peripherals`
  ADD CONSTRAINT `peripherals_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `unit_pc` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit_pc`
--
ALTER TABLE `unit_pc`
  ADD CONSTRAINT `unit_pc_ibfk_1` FOREIGN KEY (`building_id`) REFERENCES `building` (`building_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle_expense`
--
ALTER TABLE `vehicle_expense`
  ADD CONSTRAINT `vehicle_expense_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
