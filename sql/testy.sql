-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 02 Cze 2012, 16:54
-- Wersja serwera: 5.5.22
-- Wersja PHP: 5.3.10-1ubuntu3.1

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
-- Struktura tabeli dla  `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config` (`config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `weight` int(11) NOT NULL COMMENT 'ile punktów warte jest to pytanie',
  `category` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `question_category`
--

CREATE TABLE IF NOT EXISTS `question_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `question_option`
--

CREATE TABLE IF NOT EXISTS `question_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` int(11) NOT NULL,
  `text` text NOT NULL,
  `correct` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `open` tinyint(4) NOT NULL,
  `name` varchar(255) NOT NULL,
  `points` int(11) DEFAULT NULL,
  `start_at` datetime NOT NULL,
  `end_at` datetime NOT NULL,
  `time` int(11) NOT NULL,
  `quastions_limit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `creditals` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `admin`, `creditals`) VALUES
(1, 'admin', 'kontakt@bkielbasa.pl', '21232f297a57a5a743894a0e4a801fc3', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_test`
--

CREATE TABLE IF NOT EXISTS `user_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `test` int(11) NOT NULL,
  `started_at` datetime NOT NULL,
  `result` int(11) DEFAULT NULL,
  `current_question` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`test`),
  KEY `current_question` (`current_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_test_answer`
--

CREATE TABLE IF NOT EXISTS `user_test_answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_test` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_test` (`user_test`,`question`),
  KEY `question` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`category`) REFERENCES `question_category` (`id`);

--
-- Ograniczenia dla tabeli `question_category`
--
ALTER TABLE `question_category`
  ADD CONSTRAINT `question_category_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `user_test`
--
ALTER TABLE `user_test`
  ADD CONSTRAINT `user_test_ibfk_2` FOREIGN KEY (`current_question`) REFERENCES `question` (`id`) ON DELETE SET NULL;

--
-- Ograniczenia dla tabeli `user_test_answer`
--
ALTER TABLE `user_test_answer`
  ADD CONSTRAINT `user_test_answer_ibfk_1` FOREIGN KEY (`user_test`) REFERENCES `user_test` (`id`),
  ADD CONSTRAINT `user_test_answer_ibfk_2` FOREIGN KEY (`question`) REFERENCES `question` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
