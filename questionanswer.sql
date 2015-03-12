-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2015 at 05:22 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `questionanswer`
--
CREATE DATABASE IF NOT EXISTS `questionanswer` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `questionanswer`;

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE IF NOT EXISTS `answer` (
`id` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `body` varchar(5600) NOT NULL,
  `ownerid` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `commentcount` int(11) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `parentid`, `body`, `ownerid`, `score`, `commentcount`, `creationdate`) VALUES
(4, 1, 'Sed dapibus eu odio non laoreet. Morbi vitae maximus ligula, id scelerisque massa. Vestibulum non nisi accumsan nunc molestie rutrum ut sit amet augue. Curabitur a mi nulla. Vestibulum tempor purus neque, ut varius mi maximus et. Vestibulum sem massa, mollis vitae ante at, hendrerit tincidunt.', 6, 1, 0, '2015-02-09 22:57:12'),
(5, 1, 'Phasellus sed diam urna. Vivamus libero lectus, hendrerit nec dui et, aliquet elementum lacus. Vivamus congue faucibus dolor, in ultricies purus cursus a. Praesent fringilla dolor risus, quis dapibus erat lacinia ut. Suspendisse leo velit, pellentesque rutrum mauris quis, consectetur varius justo.', 6, 1, 0, '2015-02-09 23:14:33'),
(9, 2, 'Duis nec dignissim sem. Pellentesque non aliquet neque. Pellentesque sed luctus ipsum. Suspendisse vitae condimentum arcu. Etiam lacinia placerat fermentum. Ut congue risus libero, vitae molestie tortor scelerisque et.', 6, 0, 0, '2015-02-09 23:36:39'),
(10, 9, 'Phasellus sed diam urna. Vivamus libero lectus, hendrerit nec dui et, aliquet elementum lacus. Vivamus congue faucibus dolor, in ultricies purus cursus a. Praesent fringilla dolor risus, quis dapibus erat lacinia ut. Suspendisse leo velit, pellentesque rutrum mauris quis, consectetur varius justo. Etiam viverra sapien eu augue efficitur eleifend. Nam ac leo ac quam semper vehicula. Proin tortor urna, vestibulum eu dolor vitae, tristique suscipit lorem. Vestibulum vitae enim a nibh fringilla suscipit.', 6, 0, 0, '2015-02-09 23:40:38');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
`id` int(11) NOT NULL,
  `title` varchar(108) NOT NULL,
  `body` longtext NOT NULL,
  `ownerid` int(11) NOT NULL,
  `correctanswer` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `viewcount` int(11) NOT NULL,
  `answercount` int(11) NOT NULL,
  `commentcount` int(11) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `body`, `ownerid`, `correctanswer`, `score`, `viewcount`, `answercount`, `commentcount`, `creationdate`) VALUES
(1, 'Test Question one', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at viverra elit. Fusce ornare felis turpis, in efficitur mi pellentesque a. Cras ornare non sapien eget porta. Proin sed laoreet ipsum, non interdum tortor. Nunc tortor ex, accumsan vitae lectus sit amet, euismod lobortis felis. Morbi massa libero, semper vel velit quis, vehicula lacinia lorem. Vestibulum et orci pretium, vestibulum lacus quis, cursus ante. Pellentesque finibus semper magna eget suscipit. Fusce pretium purus nec ligula aliquam ullamcorper. Sed in risus id augue malesuada fermentum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 3, 0, 0, 0, 0, 0, '2015-02-09 03:31:03'),
(2, 'Test Question 2', 'Nunc sed egestas nibh. In risus leo, vehicula ac maximus sed, lacinia at urna. Duis eleifend nulla id ipsum mattis rhoncus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse purus purus, pulvinar vel vulputate non, lacinia eu tortor. Cras condimentum malesuada ante, ac dignissim libero pharetra ut. Vestibulum pharetra cursus tortor eu mattis. Praesent sit amet dignissim ex. Morbi eget fermentum elit. In vel massa congue, semper tellus in, dapibus lorem. Nulla facilisi. Curabitur tempor ex in nunc dignissim, quis feugiat felis mollis. Suspendisse sodales finibus turpis, id vehicula nunc aliquam eu. Donec vitae vestibulum ligula. Nam gravida nisi non bibendum viverra.', 2, 0, 0, 0, 0, 0, '2015-02-09 03:32:27'),
(9, 'Test Question 3', 'There is going to be a small body but hopefully makes it look like there is a problem', 6, 0, 0, 0, 0, 0, '2015-02-09 07:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(24) NOT NULL,
  `displayname` varchar(24) NOT NULL,
  `aboutme` varchar(280) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `displayname`, `aboutme`, `creationdate`) VALUES
(2, 'pallen', 'm$ftw', '', '', '2015-02-09 02:46:10'),
(3, 'tblee', '0mGth3WeB!', '', '', '2015-02-09 02:46:10'),
(4, 'bourne', 'bash_$', '', '', '2015-02-09 02:46:10'),
(5, 'edsger', 'st1ll1l11lG0O2', '', '', '2015-02-09 02:46:10'),
(6, 'wgates', '5il3M4X_m$4L', '', '', '2015-02-09 02:46:10'),
(7, 'hopper', 'im4usn', '', '', '2015-02-09 02:46:10'),
(8, 'dknuth', 'tek!tex', '', '', '2015-02-09 02:46:10'),
(9, 'ada', 'wtf15b4b', '', '', '2015-02-09 02:46:10'),
(10, 'cmoore', 'moreM00R3!', '', '', '2015-02-09 02:46:10'),
(11, 'jresig', 'In0JS', '', '', '2015-02-09 02:46:10'),
(12, 'atanen', 'minix!minix', '', '', '2015-02-09 02:46:10'),
(13, 'linus', 'ilUvP3nGu1n5', '', '', '2015-02-09 02:46:10'),
(14, 'aturing', '1nfin1t3TAp3', '', '', '2015-02-09 02:46:10'),
(15, 'lwall', 'oysters&camels', '', '', '2015-02-09 02:46:10'),
(16, 'thewoz', '4daK1d5', '', '', '2015-02-09 02:46:10'),
(21, 'username', 'asdf', '', '', '2015-03-12 04:12:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
