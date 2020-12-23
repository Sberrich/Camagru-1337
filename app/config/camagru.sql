-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Dec 23, 2020 at 09:23 AM
-- Server version: 5.7.32
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `idcmnt` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `cmntdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Img`
--

CREATE TABLE `Img` (
  `imgid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `imgedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `imgurl` varchar(255) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Stand-in structure for view `img_user`
-- (See below for the actual view)
--
CREATE TABLE `img_user` (
`imgid` int(11)
,`userid` int(11)
,`text` varchar(255)
,`imgedate` timestamp
,`imgurl` varchar(255)
,`likes` int(11)
,`comments` int(11)
,`username` varchar(30)
,`email` varchar(30)
,`confirmed` int(11)
,`notification` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE `like` (
  `userid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL,
  `like` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `confirmed` int(11) NOT NULL DEFAULT '0',
  `notification` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



-- --------------------------------------------------------

--
-- Structure for view `img_user`
--
DROP TABLE IF EXISTS `img_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `img_user`  AS SELECT `i`.`imgid` AS `imgid`, `i`.`userid` AS `userid`, `i`.`text` AS `text`, `i`.`imgedate` AS `imgedate`, `i`.`imgurl` AS `imgurl`, `i`.`likes` AS `likes`, `i`.`comments` AS `comments`, `u`.`username` AS `username`, `u`.`email` AS `email`, `u`.`confirmed` AS `confirmed`, `u`.`notification` AS `notification` FROM (`img` `i` join `user` `u` on((`u`.`id` = `i`.`userid`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idcmnt`),
  ADD KEY `comment_ibfk` (`imgid`),
  ADD KEY `comment_ibfk_1` (`userid`);

--
-- Indexes for table `Img`
--
ALTER TABLE `Img`
  ADD PRIMARY KEY (`imgid`) USING BTREE,
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `like`
--
ALTER TABLE `like`
  ADD PRIMARY KEY (`userid`,`imgid`),
  ADD KEY `like_ibfk_2` (`imgid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `idcmnt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Img`
--
ALTER TABLE `Img`
  MODIFY `imgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk` FOREIGN KEY (`imgid`) REFERENCES `Img` (`imgid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `like`
--
ALTER TABLE `like`
  ADD CONSTRAINT `like_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `like_ibfk_2` FOREIGN KEY (`imgid`) REFERENCES `Img` (`imgid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
