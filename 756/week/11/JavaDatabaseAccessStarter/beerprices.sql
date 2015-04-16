-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2014 at 06:23 PM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `beerprices`
--

-- --------------------------------------------------------

--
-- Table structure for table `beers`
--

CREATE TABLE `beers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `beername` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `beerprice` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `beers`
--

INSERT INTO `beers` (`id`, `beername`, `beerprice`) VALUES
(1, 'Bud', 5.67),
(2, 'Coors', 8.49),
(3, 'Corona', 13.99),
(4, 'Genesee', 4.99),
(5, 'Guiness Draught', 12.99),
(6, 'Labatt', 7.99),
(7, 'Sam Adams', 12.49);
