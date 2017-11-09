-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 23, 2017 at 01:41 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `images_gallery_carousel`
--

-- --------------------------------------------------------

--
-- Table structure for table `featured_gallery`
--

CREATE TABLE `featured_gallery` (
  `id` int(11) NOT NULL,
  `photo_path` varchar(200) NOT NULL,
  `subtitle` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `featured_gallery`
--

INSERT INTO `featured_gallery` (`id`, `photo_path`, `subtitle`, `description`) VALUES
(1, 'img1.jpg', 'casa1', 'wdfdfggffgfgd'),
(2, 'img2.jpg', 'casa2', 'dgfgg'),
(3, 'img3.jpg', 'casa 3', 'fgdgdfgdsfg'),
(4, 'img4.jpg', 'casa4', 'gdfgdg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `featured_gallery`
--
ALTER TABLE `featured_gallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `featured_gallery`
--
ALTER TABLE `featured_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
