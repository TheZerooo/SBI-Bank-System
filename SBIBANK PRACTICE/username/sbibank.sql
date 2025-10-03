-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2025 at 01:17 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbibank`
--

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE `ledger` (
  `accountno` int(11) DEFAULT NULL,
  `ttype` varchar(20) DEFAULT NULL,
  `tamount` float DEFAULT NULL,
  `ttime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tstatement` varchar(100) DEFAULT NULL,
  `tid` varchar(200) DEFAULT NULL,
  `avalbalance` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ledger`
--

INSERT INTO `ledger` (`accountno`, `ttype`, `tamount`, `ttime`, `tstatement`, `tid`, `avalbalance`) VALUES
(7944, 'New', 0, '2025-06-09 13:37:48', 'New Account', 'New', 3333),
(7944, 'Debit', 1000, '2025-06-09 13:53:19', 'Debited 1000', 'Debit4978', 2333),
(1323, 'Credit', 5000, '2025-06-10 12:27:32', 'Credited 5000', 'Credit8307', 7000),
(1323, 'Debit', 3000, '2025-06-10 12:31:23', 'Debited 3000', 'Debit9437', 4000),
(1323, 'Debit', 120, '2025-06-10 12:37:41', 'Debited 120', 'Debit9164', 3880),
(1323, 'Debit', 80, '2025-06-10 12:37:46', 'Debited 80', 'Debit2604', 3800),
(1323, 'Debit', 1000, '2025-06-10 13:18:40', 'You Debited 1000 send to rakesh', 'CMN64670', 2800),
(7944, 'Credit', 1000, '2025-06-10 13:18:40', 'You Credited 1000 from rajeev', 'CMN64670', 3333),
(1323, 'Debit', 100, '2025-06-10 13:21:01', 'You Debited 100 send to rakesh', 'CMN9639', 2700),
(7944, 'Credit', 100, '2025-06-10 13:21:01', 'You Credited 100 from rajeev', 'CMN9639', 3433),
(9675, 'New', 0, '2025-06-10 13:33:41', 'New Account', 'New', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `accountno` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(39) DEFAULT NULL,
  `balance` float DEFAULT NULL,
  `registerdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isactive` tinyint(1) DEFAULT 0,
  `issuperuser` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`accountno`, `username`, `password`, `balance`, `registerdate`, `isactive`, `issuperuser`) VALUES
(1111, 'admin', 'admin', NULL, '2025-05-14 14:00:19', 1, 1),
(1323, 'rajeev', '1234', 2700, '2025-06-10 13:21:01', 1, 0),
(2051, 'alka', '1234', 5000, '2025-06-09 13:34:46', 0, 0),
(2567, 'atul', '1234', 1120, '2025-06-09 13:12:48', 0, 0),
(4418, 'shubham', '1234', 6880, '2025-06-09 13:12:52', 0, 0),
(7944, 'rakesh', '1234', 3433, '2025-06-10 13:21:01', 1, 0),
(9675, 'Chetu', '1234', 1000, '2025-08-19 11:08:29', 1, 0),
(9872, 'sunil', '1234', 10000, '2025-06-09 13:35:33', 0, 0),
(12121, 'Manisha', '1234', 5000, '2025-08-19 11:08:03', 1, 0),
(67549, 'Sonu', '1234', 1000, '2025-08-19 10:12:06', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ledger`
--
ALTER TABLE `ledger`
  ADD KEY `accountno` (`accountno`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`accountno`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ledger`
--
ALTER TABLE `ledger`
  ADD CONSTRAINT `ledger_ibfk_1` FOREIGN KEY (`accountno`) REFERENCES `useraccount` (`accountno`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
select * from ledger;
