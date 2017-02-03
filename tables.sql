-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Feb 2017 um 10:07
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `schnick-schnack`
--
CREATE DATABASE IF NOT EXISTS `schnick-schnack` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `schnick-schnack`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spieler`
--

DROP TABLE IF EXISTS `spieler`;
CREATE TABLE `spieler` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `siege` int(11) NOT NULL,
  `niederlagen` int(11) NOT NULL,
  `schere` varchar(255) NOT NULL,
  `echse` varchar(255) NOT NULL,
  `spock` varchar(255) NOT NULL,
  `stein` varchar(255) NOT NULL,
  `papier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spieler`
--
ALTER TABLE `spieler`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `spieler`
--
ALTER TABLE `spieler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

--
-- Create user for database
--
CREATE USER schnickuser@localhost IDENTIFIED BY 'schnick';
GRANT ALL PRIVILEGES ON schnick-schnack.* TO schnickuser@localhost IDENTIFIED BY 'schnick';
FLUSH PRIVILEGES;