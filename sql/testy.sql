-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Sie 2012, 18:06
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
-- Struktura tabeli dla  `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `group`
--

INSERT INTO `group` (`id`, `name`, `user`) VALUES
(5, 'Grupa ankietowanych 1', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Zrzut danych tabeli `question`
--

INSERT INTO `question` (`id`, `text`, `weight`, `category`, `file`, `file_name`, `file_mime`, `user`) VALUES
(17, 'Ile to jest 2+2*2', 10, 8, 'question_502d07969ca0d', '', '', 1),
(18, 'Które działanie wykonamy jako pierwsze w równaniu 2 * 2 * (2+2)', 10, 8, 'question_502d07fca7f50', '', '', 1),
(19, 'Czy przez każde 3 punkty można przeprowadzić jedną prostą?', 10, 8, 'question_502d08245cc82', '', '', 1),
(20, 'Jeśli bok kwadratu wynosi 4, to jaka jest jego powierzchnia?', 10, 8, 'question_502d085e0a99a', '', '', 1),
(21, 'Czy wszystkie boki w prostokącie są równe?', 10, 8, 'question_502d0880714c3', '', '', 1),
(22, 'Ile wynosi suma kątów w trójkącie', 10, 8, 'question_502d08b591016', '', '', 1),
(23, 'Czy z każdych trzech odcinków można zbudować trójkąt?', 10, 8, 'question_502d08d9b1951', '', '', 1),
(24, 'Jaki jest wzór na obwód prostokąta o bokach ''a'' i ''b''?', 10, 8, 'question_502d09870ce6c', '', '', 1),
(25, 'Ala miała 10 cukierków. Zjadła 5 cukierków, a Jasiowi dała dwa. Ile cukierków zostało Ali? ', 10, 8, 'question_502d16e1ee9ef', '', '', 1),
(26, 'Które z podanych poniżej nierówności jest poprawne.', 10, 8, 'question_502d173388b7f', '', '', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `question_category`
--

INSERT INTO `question_category` (`id`, `name`, `user`) VALUES
(8, 'Podstawy matematyki', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `question_option`
--

CREATE TABLE IF NOT EXISTS `question_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` int(11) DEFAULT NULL,
  `text` text NOT NULL,
  `correct` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`question`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Zrzut danych tabeli `question_option`
--

INSERT INTO `question_option` (`id`, `question`, `text`, `correct`) VALUES
(1, 17, '8', 0),
(2, 17, '6', 1),
(3, 17, '10', 0),
(4, 18, 'Dodawanie w nawiasie', 1),
(5, 18, 'możenie 2*2', 0),
(6, 19, 'Tak', 0),
(7, 19, 'Nie', 1),
(11, 20, '4 cm ^2', 0),
(12, 20, '8 cm ^2', 0),
(13, 20, '16 cm ^2', 1),
(14, 21, 'Tak', 0),
(15, 21, 'Nie', 1),
(16, 22, '90', 0),
(17, 22, '180', 1),
(18, 22, '360', 0),
(19, 23, 'Tak', 0),
(20, 23, 'Nie', 1),
(21, 24, 'a*b', 0),
(22, 24, '2*a + 2*b', 1),
(23, 24, '2*(a + b)', 0),
(24, 25, '1', 0),
(25, 25, '2', 0),
(26, 25, '3', 1),
(27, 25, '4', 0),
(28, 25, '5', 0),
(29, 25, '6', 0),
(30, 26, '2>3', 0),
(31, 26, '5<2', 0),
(32, 26, '3<6', 1);

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
  `one_page` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Zrzut danych tabeli `test`
--

INSERT INTO `test` (`id`, `user`, `open`, `name`, `points`, `start_at`, `end_at`, `time`, `quastions_limit`, `one_page`) VALUES
(11, 1, 0, 'Test z podstaw matematyki', 60, '2012-08-16 17:52:32', '2012-08-31 00:00:00', 15, 5, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `test_category`
--

INSERT INTO `test_category` (`id`, `test`, `category`) VALUES
(1, 11, 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `test_group`
--

CREATE TABLE IF NOT EXISTS `test_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question` (`test`,`group`),
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `test_group`
--

INSERT INTO `test_group` (`id`, `test`, `group`) VALUES
(1, 11, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `admin`, `creditals`) VALUES
(1, 'admin', 'kontakt@bkielbasa.pl', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
(4, 'Jan Nowak', 'jan@nowak.pl', '4ba3b8341292d74a95e23de96d3dabcc', 0, 0),
(5, 'Karal Kowalksi', 'karol@kowalski.pl', '2e1fb8320f545f47b0528c5af6ae8f6b', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`group`),
  KEY `group` (`group`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Zrzut danych tabeli `user_group`
--

INSERT INTO `user_group` (`id`, `user`, `group`) VALUES
(17, 4, 5),
(16, 5, 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_test`
--

CREATE TABLE IF NOT EXISTS `user_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `test` int(11) NOT NULL,
  `started_at` datetime NOT NULL,
  `result` float DEFAULT NULL,
  `current_question` int(11) DEFAULT NULL,
  `finished` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`test`),
  KEY `current_question` (`current_question`),
  KEY `test` (`test`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

--
-- Zrzut danych tabeli `user_test`
--

INSERT INTO `user_test` (`id`, `user`, `test`, `started_at`, `result`, `current_question`, `finished`) VALUES
(51, 4, 11, '2012-08-16 17:53:23', 60, 5, 1),
(52, 5, 11, '2012-08-16 17:58:01', 40, 5, 1);

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
  KEY `question` (`question`),
  KEY `answer` (`answer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Zrzut danych tabeli `user_test_answer`
--

INSERT INTO `user_test_answer` (`id`, `user_test`, `question`, `answer`, `points`) VALUES
(1, 51, 17, 1, 0),
(2, 51, 18, 4, 1),
(3, 51, 20, 13, 1),
(4, 51, 23, 20, 1),
(5, 51, 24, 21, 0),
(6, 52, 17, 1, 0),
(7, 52, 18, 5, 0),
(8, 52, 19, 6, 0),
(9, 52, 20, 13, 1),
(10, 52, 24, 22, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `user_test_question`
--

CREATE TABLE IF NOT EXISTS `user_test_question` (
  `user_test` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  KEY `user_test` (`user_test`),
  KEY `question` (`question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `user_test_question`
--

INSERT INTO `user_test_question` (`user_test`, `question`) VALUES
(51, 17),
(51, 18),
(51, 20),
(51, 23),
(51, 24),
(52, 17),
(52, 18),
(52, 19),
(52, 20),
(52, 24);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `group`
--
ALTER TABLE `group`
  ADD CONSTRAINT `group_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `question_option_ibfk_3` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE;

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
-- Ograniczenia dla tabeli `test_group`
--
ALTER TABLE `test_group`
  ADD CONSTRAINT `test_group_ibfk_1` FOREIGN KEY (`test`) REFERENCES `test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `test_group_ibfk_2` FOREIGN KEY (`group`) REFERENCES `group` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `user_group_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_group_ibfk_2` FOREIGN KEY (`group`) REFERENCES `group` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_test`
--
ALTER TABLE `user_test`
  ADD CONSTRAINT `user_test_ibfk_3` FOREIGN KEY (`user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `user_test_ibfk_4` FOREIGN KEY (`test`) REFERENCES `test` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_test_answer`
--
ALTER TABLE `user_test_answer`
  ADD CONSTRAINT `user_test_answer_ibfk_3` FOREIGN KEY (`user_test`) REFERENCES `user_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answer_ibfk_4` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answer_ibfk_5` FOREIGN KEY (`answer`) REFERENCES `question_option` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_test_question`
--
ALTER TABLE `user_test_question`
  ADD CONSTRAINT `user_test_question_ibfk_1` FOREIGN KEY (`user_test`) REFERENCES `user_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_question_ibfk_2` FOREIGN KEY (`question`) REFERENCES `question` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
