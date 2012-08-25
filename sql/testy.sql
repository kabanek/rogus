-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 25 Sie 2012, 09:50
-- Wersja serwera: 5.5.24
-- Wersja PHP: 5.4.4-4~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `testy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `open` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `points` int(11) DEFAULT NULL,
  `3_5` int(11) DEFAULT NULL COMMENT 'ocena 3.5',
  `4` int(11) DEFAULT NULL COMMENT 'ocena 4',
  `4_5` int(11) DEFAULT NULL COMMENT 'ocena 4.5',
  `5` int(11) DEFAULT NULL COMMENT 'ocena 5',
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `time` int(11) NOT NULL,
  `quastions_limit` int(11) NOT NULL,
  `one_page` int(11) NOT NULL,
  `ip_mask` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Zrzut danych tabeli `test`
--

INSERT INTO `test` (`id`, `user`, `open`, `name`, `description`, `points`, `3_5`, `4`, `4_5`, `5`, `start_at`, `end_at`, `time`, `quastions_limit`, `one_page`, `ip_mask`) VALUES
(11, 1, 0, 'Test z podstaw matematyki', '<p>test</p>', 60, NULL, NULL, NULL, NULL, '2012-08-16 17:52:32', '2012-08-31 00:00:00', 15, 5, 0, '127.0.1.x');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
