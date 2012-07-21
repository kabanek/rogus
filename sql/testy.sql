-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 21 Lip 2012, 10:59
-- Wersja serwera: 5.5.24
-- Wersja PHP: 5.4.4-1~precise+1

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
  `code` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `config` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `config`
--

INSERT INTO `config` (`id`, `code`, `value`) VALUES
(1, 'site/name', 'System do tworzenia testow'),
(2, 'site/type', 'closed');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `weight` int(11) NOT NULL COMMENT 'ile punktów warte jest to pytanie',
  `category` int(11) DEFAULT NULL,
  `file` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_mime` varchar(255) DEFAULT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Zrzut danych tabeli `question`
--

INSERT INTO `question` (`id`, `text`, `weight`, `category`, `file`, `file_name`, `file_mime`, `user`) VALUES
(7, 'czy lubisz kabana?', 100, 5, '', '', NULL, 1),
(8, 'A rogusia lubisz?', 10, 4, '', '', NULL, 1),
(9, 'fdsfasf', 10, NULL, '', '', NULL, 1),
(10, '222', 10, 4, '', '', NULL, 1),
(11, 'lubisz placki?', 10, 4, 'question_4fde2c03c4263', '', '', 1),
(12, 'fds', 10, 4, 'question_4fde2f6d3f811', '', '', 1),
(13, 'lubie placki', 10, 4, 'question_4fde311691127', '', '', 1),
(14, 'lubisz mnie', 10, 4, 'question_4ff1d2fce7281', '3.jpg', 'image/jpeg', 1),
(15, 'lubisz mnie', 10, 4, 'question_4ff1d33aac40a', '3.jpg', 'image/jpeg', 1),
(16, 'fsdfsdfsdafsd', 10, 4, 'question_4ff1d369bbfea', '5.jpg', '', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `question_category`
--

INSERT INTO `question_category` (`id`, `name`, `user`) VALUES
(4, 'Dupa', 1),
(5, 'Lala2', 1),
(6, 'Lala', 1),
(7, 'Lala2', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Zrzut danych tabeli `question_option`
--

INSERT INTO `question_option` (`id`, `question`, `text`, `correct`) VALUES
(9, 7, 'tak', 1),
(10, 7, 'nie', 0),
(13, 10, 'Tak', 1),
(14, 10, 'nie', 0),
(23, 8, 'Tak', 0),
(24, 8, 'Nie', 1),
(25, 8, 'ani trochę', 0),
(26, 14, 'tak', 1),
(27, 14, 'nie', 0),
(28, 15, 'tak', 0),
(29, 15, 'nie', 1),
(30, 16, 'fdsa', 1),
(31, 16, 'fdsa', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `test`
--

INSERT INTO `test` (`id`, `user`, `open`, `name`, `points`, `start_at`, `end_at`, `time`, `quastions_limit`) VALUES
(6, 1, 0, 'dsfsaf', 50, '2012-07-20 19:41:51', '2012-07-20 19:41:51', 15, 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `test_category`
--

CREATE TABLE IF NOT EXISTS `test_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `test` (`test`,`category`),
  KEY `category` (`category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Zrzut danych tabeli `test_category`
--

INSERT INTO `test_category` (`id`, `test`, `category`) VALUES
(21, 6, 4);

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
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`category`) REFERENCES `question_category` (`id`),
  ADD CONSTRAINT `question_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `question_category`
--
ALTER TABLE `question_category`
  ADD CONSTRAINT `question_category_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `question_option`
--
ALTER TABLE `question_option`
  ADD CONSTRAINT `question_option_ibfk_1` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `test`
--
ALTER TABLE `test`
  ADD CONSTRAINT `test_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `test_category`
--
ALTER TABLE `test_category`
  ADD CONSTRAINT `test_category_ibfk_1` FOREIGN KEY (`test`) REFERENCES `test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_category_ibfk_2` FOREIGN KEY (`category`) REFERENCES `question_category` (`id`);

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
