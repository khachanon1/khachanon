-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2023 at 12:31 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_students`
--

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `fac_id` int(11) NOT NULL,
  `fac_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`fac_id`, `fac_name`) VALUES
(1, 'คณะวิทยาการสารสนเทศ'),
(2, 'คณะวิทยาศาสตร์'),
(3, 'คณะวิศวกรรมศาสตร์'),
(4, 'คณะมนุษยศาตร์');

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

CREATE TABLE `major` (
  `major_id` int(11) NOT NULL,
  `major_name` varchar(80) NOT NULL,
  `fac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `major_name`, `fac_id`) VALUES
(1, 'สาขาเทคโนโลยีสารสนเทศ', 1),
(2, 'สาขาวิทยาการคอมพิวเตอร์', 1),
(3, 'สาขานิเทศศาสตร์', 1),
(4, 'สาขาสื่อนฤมิต', 1),
(5, 'สาขาเคมี', 2),
(6, 'สาขาชีวะ', 2),
(7, 'เครื่องกล', 3),
(8, 'ไฟฟ้า', 3);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `std_code` varchar(12) NOT NULL,
  `std_name` varchar(80) NOT NULL,
  `std_gpa` float(3,2) NOT NULL DEFAULT '0.00',
  `std_pic` varchar(16) NOT NULL,
  `std_major` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `std_code`, `std_name`, `std_gpa`, `std_pic`, `std_major`) VALUES
(1, '65011212345', 'สมชาย รักดี', 0.00, '', 1),
(2, '65011212346', 'มานี มีใจ', 2.00, '', 2),
(3, '65011212347', 'ชูใจ นานา', 3.00, '', 3),
(4, '65011212348', 'ปิติ นานา', 4.00, '', 3),
(5, '65011212349', 'พาสุข มีใจ', 0.00, '', 2),
(6, '65011212350', 'พาสุข หรรษา', 0.00, '', 9),
(10, '222222222222', 'จตุภูมิ จวนชัยภูมิ', 3.00, '', 0),
(11, '65011212350', 'พาสุข หรรษา', 3.00, '', 0),
(12, '65011212350', 'พาสุข หรรษา', 2.00, '', 0),
(14, '65011212345', 'จตุภูมิ จวนชัยภูมิ', 3.00, '65011212345.png', 0),
(18, '44444444444', 'จตุภูมิ จวนชัยภูมิ', 3.00, '44444444444.png', 0),
(19, '666666', '666666', 4.00, '', 1),
(20, '65011212348', 'ทดสอบ', 4.00, '65011212348.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `login` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`login`, `password`) VALUES
('admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_student`
-- (See below for the actual view)
--
CREATE TABLE `view_student` (
`Id` int(11)
,`std_code` varchar(12)
,`std_name` varchar(80)
,`std_gpa` float(3,2)
,`std_pic` varchar(16)
,`major_name` varchar(80)
,`fac_name` varchar(80)
,`fac_id` int(11)
,`major_id` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `view_student`
--
DROP TABLE IF EXISTS `view_student`;

CREATE ALGORITHM=UNDEFINED  SQL SECURITY DEFINER VIEW `view_student`  AS  select `student`.`id` AS `Id`,`student`.`std_code` AS `std_code`,`student`.`std_name` AS `std_name`,`student`.`std_gpa` AS `std_gpa`,`student`.`std_pic` AS `std_pic`,`major`.`major_name` AS `major_name`,`faculty`.`fac_name` AS `fac_name`,`faculty`.`fac_id` AS `fac_id`,`major`.`major_id` AS `major_id` from ((`student` join `major` on((`student`.`std_major` = `major`.`major_id`))) join `faculty` on((`major`.`fac_id` = `faculty`.`fac_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`fac_id`);

--
-- Indexes for table `major`
--
ALTER TABLE `major`
  ADD PRIMARY KEY (`major_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `fac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `major`
--
ALTER TABLE `major`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
