-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 02:40 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `app`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `member_id`, `name`, `date_time_created`, `last_updated`) VALUES
(17, 0, 'New album', '2015-04-16 14:55:44', '0000-00-00 00:00:00'),
(18, 1, 'Second album', '2015-04-16 22:53:36', '2015-04-20 16:14:03'),
(19, 3, 'First Album', '2015-04-19 20:40:46', '2015-04-20 16:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `member_id` int(11) NOT NULL,
  `album_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `url` varchar(100) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `name`, `member_id`, `album_id`, `description`, `date`, `url`, `date_time_created`, `last_updated`) VALUES
(26, 'Double Rainbow', 3, 19, 'Double Rainbow by Bing', '2015-04-08', 'BingWallpaper-2014-08-25.jpg', '2015-04-19 20:41:30', '0000-00-00 00:00:00'),
(31, 'Castle', 3, 19, 'Castle', '2015-04-20', 'CastleDinas_EN-GB13748709795_1366x768.jpg', '2015-04-20 17:20:37', '0000-00-00 00:00:00'),
(32, 'Garden', 3, 19, 'Garden', '2015-04-20', 'garden.jpg', '2015-04-20 17:20:57', '0000-00-00 00:00:00'),
(33, 'Piano', 3, 19, 'Piano', '0000-00-00', 'Steinway Grand piano.png', '2015-04-20 17:34:05', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `date_time_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `email`, `password`, `date_time_created`, `last_updated`) VALUES
(1, 'laifany', 'choonkiat94@yahoo.com', 'abc', '2015-04-10 13:49:35', '0000-00-00 00:00:00'),
(2, 'minion', 'minion@yahoo.com', 'abc', '2015-04-16 13:53:58', '0000-00-00 00:00:00'),
(3, 'Lee', 'lee@hotmail.com', 'lee', '2015-04-19 20:40:30', '0000-00-00 00:00:00'),
(5, 'jy', 'jy@hotmail.com', 'jy', '2015-04-20 10:57:48', '0000-00-00 00:00:00'),
(7, 'king', 'king@gmail.com', 'king', '2015-04-20 13:09:31', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
