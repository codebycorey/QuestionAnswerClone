-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2015 at 07:41 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `parentid`, `body`, `ownerid`, `score`, `commentcount`, `creationdate`) VALUES
(4, 1, 'Sed dapibus eu odio non laoreet. Morbi vitae maximus ligula, id scelerisque massa. Vestibulum non nisi accumsan nunc molestie rutrum ut sit amet augue. Curabitur a mi nulla. Vestibulum tempor purus neque, ut varius mi maximus et. Vestibulum sem massa, mollis vitae ante at, hendrerit tincidunt.', 6, 2, 0, '2015-02-09 22:57:12'),
(5, 1, 'Phasellus sed diam urna. Vivamus libero lectus, hendrerit nec dui et, aliquet elementum lacus. Vivamus congue faucibus dolor, in ultricies purus cursus a. Praesent fringilla dolor risus, quis dapibus erat lacinia ut. Suspendisse leo velit, pellentesque rutrum mauris quis, consectetur varius justo.', 6, 4, 0, '2015-02-09 23:14:33'),
(9, 2, 'Duis nec dignissim sem. Pellentesque non aliquet neque. Pellentesque sed luctus ipsum. Suspendisse vitae condimentum arcu. Etiam lacinia placerat fermentum. Ut congue risus libero, vitae molestie tortor scelerisque et.', 6, 0, 0, '2015-02-09 23:36:39'),
(10, 9, 'Phasellus sed diam urna. Vivamus libero lectus, hendrerit nec dui et, aliquet elementum lacus. Vivamus congue faucibus dolor, in ultricies purus cursus a. Praesent fringilla dolor risus, quis dapibus erat lacinia ut. Suspendisse leo velit, pellentesque rutrum mauris quis, consectetur varius justo. Etiam viverra sapien eu augue efficitur eleifend. Nam ac leo ac quam semper vehicula. Proin tortor urna, vestibulum eu dolor vitae, tristique suscipit lorem. Vestibulum vitae enim a nibh fringilla suscipit.', 6, 1, 0, '2015-02-09 23:40:38'),
(11, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras nec aliquet lectus, sed aliquam urna. Cras suscipit odio ut ultricies rhoncus. Nulla vestibulum semper malesuada. Nunc porttitor tortor nec fringilla blandit. Nullam interdum tellus enim, eu maximus turpis vulputate et. ', 4, 6, 0, '2015-03-15 22:27:49');

-- --------------------------------------------------------

--
-- Table structure for table `avatar`
--

CREATE TABLE IF NOT EXISTS `avatar` (
`id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `avatar`
--

INSERT INTO `avatar` (`id`, `filename`) VALUES
(0, 'default.jpg'),
(2, 'Coupon_11.png'),
(3, 'Coupon_12.png'),
(4, 'Coupon_13.png'),
(5, 'Coupon_14.png'),
(6, 'Coupon_15.png'),
(7, 'Coupon.png'),
(8, 'default_0.jpg'),
(9, 'Coupon_0.png'),
(10, 'default_1.jpg'),
(11, 'D04.png');

-- --------------------------------------------------------

--
-- Table structure for table `posttags`
--

CREATE TABLE IF NOT EXISTS `posttags` (
  `postid` int(11) NOT NULL,
  `tagid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posttags`
--

INSERT INTO `posttags` (`postid`, `tagid`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 3),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(25, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `body`, `ownerid`, `correctanswer`, `score`, `viewcount`, `answercount`, `commentcount`, `creationdate`) VALUES
(1, 'Test Question one', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin at viverra elit. Fusce ornare felis turpis, in efficitur mi pellentesque a. Cras ornare non sapien eget porta. Proin sed laoreet ipsum, non interdum tortor. Nunc tortor ex, accumsan vitae lectus sit amet, euismod lobortis felis. Morbi massa libero, semper vel velit quis, vehicula lacinia lorem. Vestibulum et orci pretium, vestibulum lacus quis, cursus ante. Pellentesque finibus semper magna eget suscipit. Fusce pretium purus nec ligula aliquam ullamcorper. Sed in risus id augue malesuada fermentum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 3, 11, 505, 0, 0, 0, '2015-02-09 03:31:03'),
(2, 'Test Question 2', 'Nunc sed egestas nibh. In risus leo, vehicula ac maximus sed, lacinia at urna. Duis eleifend nulla id ipsum mattis rhoncus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Suspendisse purus purus, pulvinar vel vulputate non, lacinia eu tortor. Cras condimentum malesuada ante, ac dignissim libero pharetra ut. Vestibulum pharetra cursus tortor eu mattis. Praesent sit amet dignissim ex. Morbi eget fermentum elit. In vel massa congue, semper tellus in, dapibus lorem. Nulla facilisi. Curabitur tempor ex in nunc dignissim, quis feugiat felis mollis. Suspendisse sodales finibus turpis, id vehicula nunc aliquam eu. Donec vitae vestibulum ligula. Nam gravida nisi non bibendum viverra.', 2, 0, 100, 0, 0, 0, '2015-02-09 03:32:27'),
(9, 'Test Question 3', 'There is going to be a small body but hopefully makes it look like there is a problem', 6, 0, 604, 0, 0, 0, '2015-02-09 07:38:30'),
(10, 'Mauris commodo imperdiet sapien, a porta justo sodales eu.', ' Curabitur non dui lacinia, malesuada eros id, eleifend purus. Mauris posuere magna non est efficitur bibendum. Sed dapibus, neque in ultricies rhoncus, enim nisl euismod augue, eget porta velit dolor eget felis. Donec sit amet nisl in elit congue gravida ', 2, 0, 0, 0, 0, 0, '2015-04-02 00:01:00'),
(11, 'Pellentesque aliquam justo augue, in vulputate ex dictum nec.', 'Morbi non fringilla arcu. Donec id neque at arcu laoreet blandit id eget elit. Interdum et malesuada fames ac ante ipsum primis in faucibus.', 3, 0, 0, 0, 0, 0, '2015-04-02 00:01:00'),
(12, 'Nullam tempor velit quis molestie tempor. ', 'non laoreet at, porttitor eget libero. Aenean vulputate, massa sed ornare vulputate, tellus justo feugiat ante, malesuada vestibulum nunc dolor at mi. Pellentesque aliquet id ante non ultricies. Aenean quam enim, ullamcorper et euismod ut, ornare ac odio. Morbi dictum sapien condimentum sem rhoncus, pellentesque interdum diam porta. Nam gravida, massa sed iaculis dictum, dolor dolor maxi', 4, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(13, 'Vivamus eleifend diam sem, vitae consequat lorem venenatis quis.', 'Aliquam erat volutpat. Phasellus feugiat dolor vitae tellus ullamcorper, sit amet dictum lorem egestas. Fusce pharetra porttitor arcu eget faucibus. Proin a mauris ut urna convallis consequat nec et turpis. Ut euismod, odio eget luctus vestibulum, ante enim dapibus leo, ut rhoncus magna justo a risus.', 5, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(14, 'Curabitur aliquam accumsan dignissim. ', 'Donec luctus nunc nec odio bibendum lacinia. Suspendisse ullamcorper, dolor nec posuere sodales, libero tortor posuere quam, et auctor ex ante ut metus. Duis nec egestas mauris. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus varius, nibh et gravida hendrerit, nisl tortor scelerisque ante', 6, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(15, ' neque in ultricies rhoncus, enim nisl euismod augue, eget porta velit dolor eget felis.', 'Nullam tempor velit quis molestie tempor. Nam laoreet, nunc fringilla congue bibendum, nunc massa lacinia tortor, sit amet dignissim nunc ligula eget ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Maecenas metus lorem, congue non laoreet', 7, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(16, 'Pellentesque aliquet id ante non ultricies. Aenean quam enim, ullamcorper et euismod ut, ornare ac odio. Mor', ' sapien condimentum sem rhoncus, pellentesque interdum diam porta. Nam gravida, massa sed iaculis dictum, dolor dolor maximus sem, eget lacinia ligula lacus in odio. Aenean a ipsum efficitur, tempus est id, condimentum tellus. Sed velit nulla, interdum at justo ut, commodo lobortis magna. Duis id magna quis erat consectetur elementum id quis leo. Ut in massa velit.', 8, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(17, ' In vitae vehicula erat. Cras vel odio augue. Proin condimentum venenatis neque, eget ullamcorper magna port', 'Pellentesque orci diam, volutpat at urna vitae, tincidunt dignissim neque. Nullam vel arcu id ante ornare interdum et vitae ligula. Donec faucibus eros non velit luctus congue. Donec ac sapien quis ligula tincidunt ultrices.', 9, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(18, 'Nam laoreet, nunc fringilla congue bibendum, nunc massa lacinia tortor, sit amet dignissim nunc ligula eget ', 'eget libero. Aenean vulputate, massa sed ornare vulputate, tellus justo feugiat ante, malesuada vestibulum nunc dolor at mi. ', 10, 0, 0, 0, 0, 0, '2015-04-02 00:03:50'),
(19, 'tagtest', 'just testing the tag insert', 4, 0, 0, 0, 0, 0, '2015-04-05 04:32:22'),
(20, 'tagtest', 'just testing the tag insert', 4, 0, 0, 0, 0, 0, '2015-04-05 04:32:39'),
(21, 'test tags2', 'testing the tags again', 4, 0, 0, 0, 0, 0, '2015-04-05 04:35:17'),
(22, 'test tags2', 'testing the tags again', 4, 0, 0, 0, 0, 0, '2015-04-05 04:36:14'),
(23, 'test tags2', 'testing the tags again', 4, 0, 0, 0, 0, 0, '2015-04-05 04:37:16'),
(24, 'testing tags3', 'test', 4, 0, 0, 0, 0, 0, '2015-04-05 04:37:38'),
(25, 'testing tags3', 'test', 4, 0, 0, 0, 0, 0, '2015-04-05 04:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
`id` int(11) NOT NULL,
  `tagname` varchar(24) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `tagname`) VALUES
(1, 'tag1'),
(2, 'tag2'),
(3, 'tag3'),
(4, 'tag4'),
(5, 'tag5'),
(7, 'testtag');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(24) NOT NULL,
  `admin` int(1) NOT NULL,
  `displayname` varchar(24) NOT NULL,
  `aboutme` varchar(280) NOT NULL,
  `creationdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `admin`, `displayname`, `aboutme`, `creationdate`, `avatar_id`) VALUES
(2, 'pallen', 'm$ftw', 0, '', '', '2015-02-09 02:46:10', 0),
(3, 'tblee', '0mGth3WeB!', 0, '', '', '2015-02-09 02:46:10', 8),
(4, 'bourne', 'bash_$', 1, '', '', '2015-02-09 02:46:10', 11),
(5, 'edsger', 'st1ll1l11lG0O2', 0, '', '', '2015-02-09 02:46:10', 0),
(6, 'wgates', '5il3M4X_m$4L', 0, '', '', '2015-02-09 02:46:10', 0),
(7, 'hopper', 'im4usn', 0, '', '', '2015-02-09 02:46:10', 0),
(8, 'dknuth', 'tek!tex', 0, '', '', '2015-02-09 02:46:10', 0),
(9, 'ada', 'wtf15b4b', 0, '', '', '2015-02-09 02:46:10', 0),
(10, 'cmoore', 'moreM00R3!', 0, '', '', '2015-02-09 02:46:10', 0),
(11, 'jresig', 'In0JS', 0, '', '', '2015-02-09 02:46:10', 0),
(12, 'atanen', 'minix!minix', 0, '', '', '2015-02-09 02:46:10', 0),
(13, 'linus', 'ilUvP3nGu1n5', 0, '', '', '2015-02-09 02:46:10', 0),
(14, 'aturing', '1nfin1t3TAp3', 0, '', '', '2015-02-09 02:46:10', 0),
(15, 'lwall', 'oysters&camels', 0, '', '', '2015-02-09 02:46:10', 0),
(16, 'thewoz', '4daK1d5', 0, '', '', '2015-02-09 02:46:10', 0),
(21, 'username', 'asdf', 0, '', '', '2015-03-12 04:12:30', 0),
(25, 'rcodonnell', 'asdf', 0, '', '', '2015-03-16 04:29:19', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `avatar`
--
ALTER TABLE `avatar`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `tagname` (`tagname`);

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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `avatar`
--
ALTER TABLE `avatar`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
