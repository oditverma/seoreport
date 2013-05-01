-- phpMyAdmin SQL Dump
-- version 3.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2013 at 06:19 AM
-- Server version: 5.5.28
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `odit`
--

-- --------------------------------------------------------

--
-- Table structure for table `keyword`
--

CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `keyname` varchar(100) NOT NULL,
  `timeadded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pos` int(10) unsigned NOT NULL DEFAULT '1',
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `keyname_UNIQUE` (`keyname`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `keyword`
--

INSERT INTO `keyword` (`id`, `keyname`, `timeadded`, `pos`, `project_id`) VALUES
(25, 'limo for taxi', '2013-03-29 11:47:51', 5, 1),
(34, 'car for rent', '2013-04-01 06:31:53', 7, 1),
(37, 'limo assist', '2013-04-01 10:20:14', 6, 1),
(40, 'limo cars on rent', '2013-04-02 06:42:16', 4, 1),
(41, 'Minority issues', '2013-04-02 07:10:33', 1, 2),
(42, 'the project for nmrca', '2013-04-02 07:10:50', 2, 2),
(43, 'nmrca', '2013-04-02 07:13:20', 4, 2),
(45, 'the chemical industry india', '2013-04-02 07:14:22', 3, 2),
(46, 'human resource management', '2013-04-02 07:15:54', 1, 3),
(47, 'life insurance', '2013-04-02 07:56:57', 4, 9),
(48, 'health insurance', '2013-04-02 07:57:08', 2, 9),
(49, 'optimal life insurance', '2013-04-02 07:57:25', 1, 9),
(50, 'dish tv in ludhiana', '2013-04-12 02:16:08', 1, 11),
(51, 'map my india devices in ldh', '2013-04-12 02:16:22', 2, 11),
(52, 'best dish tv in cheap rates', '2013-04-12 02:16:44', 3, 11),
(53, 'health advisor and insurance', '2013-04-26 02:22:28', 3, 9),
(54, 'luxury  cars', '2013-04-26 02:24:44', 8, 1),
(55, 'Limousin cars on rent ', '2013-04-29 00:40:15', 2, 1),
(56, 'limo cars in London for rent', '2013-04-29 00:40:46', 1, 1),
(57, 'cars for occasions ', '2013-04-29 00:46:53', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `description` varchar(500) NOT NULL,
  `date_added` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `attachment` varchar(45) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `title`, `description`, `date_added`, `status`, `attachment`, `user_id`) VALUES
(1, 'limo assist', 'Limo assist is a web site to take the luxuries cars on rent ', '2013-01-02', 1, '181004_10151495233526602_1334798628_n.png', 4),
(2, 'NMRCA', 'NMRCA', '2013-02-07', 1, '601393_10151256197628783_1328402486_n.jpg', 2),
(3, 'HRM', 'HRM Manages the Industrial Manpower and their Resources', '2013-03-05', 1, 'SEO reporting tool.docx', 10),
(6, 'CRM', 'Customer Resource Management', '2013-02-28', 1, 'Untitled.png', 1),
(9, 'Optimal Life', 'Health Insurance Site', '2013-01-02', 1, '314453_10151497636336602_2137292995_n.png', 10),
(10, 'Online college Magazine', 'The Online College Magazine', '2013-03-04', 1, 'photo 1.JPG', 4),
(11, 'Smart Sales and Services', 'Smart Sales and Services desktop application', '2013-02-16', 1, 'mp.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_completed` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `added_by` varchar(80) NOT NULL,
  `assign_to` varchar(80) NOT NULL,
  `attachment` varchar(100) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id`, `title`, `description`, `time_added`, `time_completed`, `added_by`, `assign_to`, `attachment`, `project_id`) VALUES
(1, 'Limo Assist', 'please change the tooltip color', '2013-02-24 18:30:00', '2013-03-26 18:30:00', 'Anil Konsal', 'oditverma', 'google.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `gender` varchar(45) NOT NULL,
  `dob` date NOT NULL,
  `pass` varchar(45) NOT NULL DEFAULT '',
  `email` varchar(45) NOT NULL,
  `account_type` varchar(45) NOT NULL,
  `address` varchar(100) NOT NULL,
  `contact` varchar(45) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `pass_UNIQUE` (`pass`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `gender`, `dob`, `pass`, `email`, `account_type`, `address`, `contact`, `status`, `logo`) VALUES
(1, 'vikas', '', '0000-00-00', 'vikas', 'vikas@tii.co.in', 'Client', 'ludhiana', '8943273933', 1, ''),
(2, 'surinder', '', '0000-00-00', 'surinder', 'surinder@tii.co.in', 'Client', 'ludhiana', '9283928322', 1, ''),
(3, 'anil', '', '0000-00-00', 'anil', 'anil@tii.co.in', 'Admin', 'ludhiana', '9878100079', 1, 'cm.jpg'),
(4, 'tarun', '', '0000-00-00', 'tarun', 'tarundeep@tii.co.in', 'Team', 'ludhiana,punjab,141003', '9876421129', 1, 'be_right_back.png'),
(10, 'odit', '', '0000-00-00', 'odit', 'oditverma@gmail.co', 'Client', 'ludhiana,141008', '7696704032', 1, ''),
(12, 'Bal singh', '', '0000-00-00', 'bal1234', 'bal@tii.co.in', 'Team', 'Phagwara,Punjab', '9828370228', 1, ''),
(14, 'Karan', '', '0000-00-00', 'karan', 'karan@tii.co.in', 'Team', 'Ludhiana', '9888756422', 1, ''),
(15, 'rupali', '', '0000-00-00', 'rupali', 'rupali@tii.co.in', 'Team', 'ludhiana', '878973983', 1, ''),
(17, 'janu', '', '0000-00-00', 'janu', 'janu@tii.co.in', 'Team', 'ldh', '8698999986', 1, 'ONLY THE LOGO APPLE LOGO [WHITE].png'),
(18, 'gaurav', '', '0000-00-00', 'gaurav89', 'gaurav@tii.co.in', 'Team', 'phgwara', '8699500079', 1, 'photo1.JPG'),
(19, 'neha', 'Female', '1991-04-01', 'neha', 'neha.gupta@yahoo.in', 'Client', 'ludhiana', '9878358214', 1, '150452_539250236117857_895144314_n.jpg'),
(20, 'Amarpreet Singh Parmar', 'Male', '1992-01-01', 'punjaban', 'amarpreetsingh.parmar@gmail.com', 'Team', 'Rama Mandi, Jalandhar', '9855442251', 1, '207310_10151463946386696_72701965_n.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keyword`
--
ALTER TABLE `keyword`
  ADD CONSTRAINT `keyword_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
