-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 04:23 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kraken`
--

-- --------------------------------------------------------

--
-- Table structure for table `corp`
--

CREATE TABLE `corp` (
  `id_kraken` int(11) NOT NULL,
  `name` varchar(125) NOT NULL,
  `age` int(11) NOT NULL,
  `taille` int(11) NOT NULL,
  `poid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `corp`
--

INSERT INTO `corp` (`id_kraken`, `name`, `age`, `taille`, `poid`) VALUES
(11, 'test', 2, 100, 100),
(17, 'testnuméro2', 41, 25, 60),
(21, 'testnuméro3', 4600000, 2000, 600),
(22, 'testDOUBLON', 41, 100, 60),
(23, 'testDOUBLONNUMERO2', 41, 25, 600),
(24, 'test', 4600000, 25, 100),
(25, 'testDOUBLONNUMERO4', 41, 50, 100);

-- --------------------------------------------------------

--
-- Table structure for table `kraken_pouvoir`
--

CREATE TABLE `kraken_pouvoir` (
  `id` int(11) NOT NULL,
  `kraken_id` int(11) NOT NULL,
  `pouvoir_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kraken_pouvoir`
--

INSERT INTO `kraken_pouvoir` (`id`, `kraken_id`, `pouvoir_id`) VALUES
(7, 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pouvoir`
--

CREATE TABLE `pouvoir` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pouvoir`
--

INSERT INTO `pouvoir` (`id`, `name`) VALUES
(1, 'Blast'),
(2, 'Plague'),
(3, 'Mind control'),
(4, 'Ink fog'),
(5, 'Force shield'),
(6, 'Regeneration');

-- --------------------------------------------------------

--
-- Table structure for table `tentacules`
--

CREATE TABLE `tentacules` (
  `id` int(11) NOT NULL,
  `kraken_id` int(11) NOT NULL,
  `nom_tentacule` varchar(255) NOT NULL,
  `pv` int(11) NOT NULL,
  `forc` int(11) NOT NULL,
  `dex` int(11) NOT NULL,
  `con` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tentacules`
--

INSERT INTO `tentacules` (`id`, `kraken_id`, `nom_tentacule`, `pv`, `forc`, `dex`, `con`) VALUES
(23, 23, 'yoooooo', 30, 13, 13, 13),
(24, 23, 'deuxième tentacule', 7, 13, 13, 13),
(71, 11, 'nhn', 7, 13, 13, 13),
(72, 11, 'ikukuu', 6, 12, 12, 12),
(73, 11, 'jhjghgjg', 6, 12, 12, 12),
(74, 11, 'jgjghjgjg', 6, 15, 15, 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `corp`
--
ALTER TABLE `corp`
  ADD PRIMARY KEY (`id_kraken`);

--
-- Indexes for table `kraken_pouvoir`
--
ALTER TABLE `kraken_pouvoir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pouvoir_kraken` (`kraken_id`),
  ADD KEY `pouvoir_id` (`pouvoir_id`);

--
-- Indexes for table `pouvoir`
--
ALTER TABLE `pouvoir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tentacules`
--
ALTER TABLE `tentacules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kraken_tentacule` (`kraken_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `corp`
--
ALTER TABLE `corp`
  MODIFY `id_kraken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `kraken_pouvoir`
--
ALTER TABLE `kraken_pouvoir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tentacules`
--
ALTER TABLE `tentacules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kraken_pouvoir`
--
ALTER TABLE `kraken_pouvoir`
  ADD CONSTRAINT `pouvoir_id` FOREIGN KEY (`pouvoir_id`) REFERENCES `pouvoir` (`id`),
  ADD CONSTRAINT `pouvoir_kraken` FOREIGN KEY (`kraken_id`) REFERENCES `corp` (`id_kraken`);

--
-- Constraints for table `tentacules`
--
ALTER TABLE `tentacules`
  ADD CONSTRAINT `kraken_tentacule` FOREIGN KEY (`kraken_id`) REFERENCES `corp` (`id_kraken`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
