-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 10, 2012 at 11:22 AM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Boostbloom`
--

-- --------------------------------------------------------

--
-- Table structure for table `emaillogs`
--

CREATE TABLE IF NOT EXISTS `emaillogs` (
  `id` int(11) NOT NULL auto_increment,
  `email_to` varchar(255) NOT NULL,
  `email_from` varchar(255) NOT NULL,
  `email_type` enum('A','B','C','D','E','F','G','H','I','J','K') NOT NULL default 'A',
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `active` tinyint(11) NOT NULL default '1',
  `deleted` tinyint(11) NOT NULL,
  `created` int(11) NOT NULL,
  `modified` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
