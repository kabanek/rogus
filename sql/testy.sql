-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 13 Sie 2012, 01:55
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `group`
--

INSERT INTO `group` (`id`, `name`, `user`) VALUES
(1, 'raz :)', 1),
(2, 'test1', 1),
(3, 'test2', 1),
(4, 'test5', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

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
(31, 16, 'fdsa', 0),
(32, 12, 'tak', 1),
(33, 12, 'nie', 0),
(34, 13, 'nie', 0),
(35, 13, 'tak', 1),
(36, 11, 'tak', 1),
(37, 11, 'NIE', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `test`
--

INSERT INTO `test` (`id`, `user`, `open`, `name`, `points`, `start_at`, `end_at`, `time`, `quastions_limit`, `one_page`) VALUES
(6, 1, 0, 'dsfsaf', 50, '2012-07-20 19:41:51', '2012-07-22 19:41:51', 15, 10, 0),
(7, 1, 0, 'Test dla grupy test5', 50, '2012-07-30 00:59:43', '2012-08-31 00:59:43', 15, 5, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Zrzut danych tabeli `test_category`
--

INSERT INTO `test_category` (`id`, `test`, `category`) VALUES
(37, 6, 4),
(38, 6, 5),
(39, 6, 6),
(40, 6, 7),
(29, 7, 4),
(30, 7, 5),
(31, 7, 6),
(32, 7, 7);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `test_group`
--

INSERT INTO `test_group` (`id`, `test`, `group`) VALUES
(5, 6, 1),
(3, 7, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `admin`, `creditals`) VALUES
(1, 'admin', 'kontakt@bkielbasa.pl', '21232f297a57a5a743894a0e4a801fc3', 1, 1),
(2, 'root', 'bartlomiej.kielbasa@gmail.com', '8b4f18be4790e513ae9c7fb83199c120', 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Zrzut danych tabeli `user_group`
--

INSERT INTO `user_group` (`id`, `user`, `group`) VALUES
(14, 1, 3),
(15, 1, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Zrzut danych tabeli `user_test`
--

INSERT INTO `user_test` (`id`, `user`, `test`, `started_at`, `result`, `current_question`, `finished`) VALUES
(49, 1, 7, '2012-08-12 19:05:05', 60, 5, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Zrzut danych tabeli `user_test_answer`
--

INSERT INTO `user_test_answer` (`id`, `user_test`, `question`, `answer`, `points`) VALUES
(30, 49, 10, 13, 1),
(31, 49, 11, 37, 0),
(32, 49, 13, 34, 0),
(33, 49, 15, 28, 0),
(34, 49, 16, 30, 1);

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
(49, 10),
(49, 11),
(49, 13),
(49, 15),
(49, 16);

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
  ADD CONSTRAINT `user_test_answer_ibfk_5` FOREIGN KEY (`answer`) REFERENCES `question_option` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answer_ibfk_3` FOREIGN KEY (`user_test`) REFERENCES `user_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_answer_ibfk_4` FOREIGN KEY (`question`) REFERENCES `question` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `user_test_question`
--
ALTER TABLE `user_test_question`
  ADD CONSTRAINT `user_test_question_ibfk_1` FOREIGN KEY (`user_test`) REFERENCES `user_test` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_test_question_ibfk_2` FOREIGN KEY (`question`) REFERENCES `question` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
