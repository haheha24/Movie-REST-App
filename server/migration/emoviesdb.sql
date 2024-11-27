-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2020 at 05:53 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emoviesdb`
--
CREATE DATABASE IF NOT EXISTS `emoviesdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `emoviesdb`;
-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  `genre` varchar(30) NOT NULL,
  `length` int(11) NOT NULL,
  `director` varchar(50) NOT NULL,
  `lead_actor` varchar(50) NOT NULL,
  `filename` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_date`, `genre`, `length`, `director`, `lead_actor`, `filename`) VALUES
(1, 'Avengers Endgame', '2019-04-24', 'Action', 182, 'The Russo Brothers', 'Robert Downey Jr, Chris Evans', 'endgame.jpg'),
(2, 'Green Book', '2019-01-24', 'Comedy/Drama', 130, 'Peter Farrelly', 'Mahershala Ali, Viggo Mortensen', 'greenbook.jpg'),
(3, 'Moonlight', '2017-01-26', 'Drama', 111, 'Barry Jenkins', 'Mahershala Ali', 'moonlight.jpg'),
(4, 'Prisoners', '2013-10-17', 'Thriller', 154, 'Denis Villeneuve', 'Jake Gyllenhaal', 'prisoners.jpg'),
(5, 'Avengers Infinity War', '2018-04-24', 'Action', 160, 'The Russo Brothers', 'The Russo Brothers', 'infinitywar.jpg'),
(6, 'Spider-Man 2', '2004-06-30', 'Action', 135, 'Sam Raimi', 'Tobey Maguire', 'spiderman2.jpg'),
(7, 'Bohemian Rhapsody', '2018-09-01', 'Musical/Drama', 133, 'Bryan Singer', 'Rami Malek', 'bohemianrhapsody.jpg'),
(8, 'La La Land', '2016-01-13', 'Musical/Romance', 128, 'Damien Chazelle', 'Ryan Gosling, Emma Stone', 'lalaland.jpg'),
(9, 'Back to the Future', '1985-08-15', 'Sci-Fi', 116, 'Robert Zemeckis', 'Michael J. Fox', 'backtothefuture.jpg'),
(10, 'Pulp Fiction', '1994-09-24', 'Crime', 178, 'Quentin Tarantino', 'Samuel L. Jackson', 'pulpfiction.jpg'),
(11, 'Titanic', '1997-12-17', 'Romance', 210, 'James Cameron', 'Kate Winslet', 'titanic.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
