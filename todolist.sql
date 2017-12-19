-- phpMyAdmin SQL Dump
-- version 4.6.6deb1+deb.cihar.com~xenial.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 19 Gru 2017, 21:18
-- Wersja serwera: 5.7.20-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `todolist`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `category`
--

INSERT INTO `category` (`id`, `user_id`, `name`) VALUES
(1, 1, 'Osobiste'),
(2, 1, 'Praca'),
(3, 1, 'Zakupy'),
(4, 1, 'Super ważne'),
(5, 2, 'Pierwsza'),
(6, 1, 'Nowa'),
(7, 1, 'Ciekawe'),
(8, 1, 'Kolejna'),
(9, 1, 'niedziela'),
(10, 3, 'nowa'),
(11, 1, 'super'),
(12, 1, 'xx'),
(13, 1, 'jkbjn');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `comment`
--

INSERT INTO `comment` (`id`, `task_id`, `description`, `user_id`) VALUES
(21, 46, 'nowe\n', 1),
(22, 47, 'nowy komentarz', 1),
(23, 46, 'nowosc', 1),
(24, 46, 'nowsc2', 1),
(25, 46, 'nowenowe', 1),
(26, 46, 'nowo', 1),
(27, 47, 'nowo', 1),
(28, 46, 'non', 1),
(29, 48, 'sjsjssjs', 1),
(30, 47, 'sjsjssjs', 1),
(31, 46, 'sjsjssjs', 1),
(32, 48, 'sjsjssjs', 1),
(33, 46, 'sjsjssjs', 1),
(34, 51, 'fdfadsa', 1),
(35, 51, 'vjhvj', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fos_user`
--

CREATE TABLE `fos_user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `fos_user`
--

INSERT INTO `fos_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `firstname`, `lastname`) VALUES
(1, 'admin', 'admin', 'admin@todolist.pl', 'admin@todolist.pl', 1, NULL, '$2y$13$Yef0xtcC8kpLKDSuGFw2feoHNJD1qxAUwMYiXCou8DPDVmwn7YV0m', '2017-12-09 13:43:11', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', '', ''),
(2, 'kubus', 'kubus', 'jakub.k.paluszkiewicz@gmail.com', 'jakub.k.paluszkiewicz@gmail.com', 1, NULL, '$2y$13$lCox30PkvjsNCb3Byv7YUuA94YIFmicBSPrsYl63wPUcQQA5AZaui', '2017-12-09 13:39:37', NULL, NULL, 'a:0:{}', 'Jakub', 'Paluszkiewicz'),
(3, 'kuba2', 'kuba2', 'kuba@kuba.pl', 'kuba@kuba.pl', 1, NULL, '$2y$13$HxqqekJanYSLP0fmTzWpz.attg1Jfzw1dRFv2KiB/5k6ktfxS9Q1W', '2017-12-05 17:42:42', NULL, NULL, 'a:0:{}', 'Kuba', 'Kuba');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `priority`
--

CREATE TABLE `priority` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `priority`
--

INSERT INTO `priority` (`id`, `name`, `value`) VALUES
(1, 'Important', 5),
(2, 'Medium', 3),
(3, 'Low', 2),
(4, 'vbjvjbh', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `name` longtext COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `inputDate` datetime NOT NULL,
  `dateToDone` datetime DEFAULT NULL,
  `isDone` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `task`
--

INSERT INTO `task` (`id`, `category_id`, `priority_id`, `name`, `description`, `inputDate`, `dateToDone`, `isDone`) VALUES
(11, 1, 3, 'nowe', 'sss', '2017-12-02 11:58:17', '2017-12-18 00:00:00', 1),
(29, 1, 1, 'nowy', 'lll', '2017-12-03 11:44:38', '2017-12-19 00:00:00', 1),
(31, 5, 1, 'cos', 'cos', '2017-12-03 12:43:53', '2017-12-20 00:00:00', 0),
(32, 7, 1, 'fdsasc', 'sa', '2017-12-03 13:00:16', '2017-12-13 00:00:00', 1),
(33, 1, 1, 'w', 'w', '2017-12-03 14:52:17', '2017-12-12 00:00:00', 1),
(34, 1, 1, 'fdssff', 'dss', '2017-12-03 14:58:23', '2017-12-06 00:00:00', 1),
(35, 1, 1, 'dsfsda', 'fdsasf', '2017-12-03 14:58:50', '2017-12-22 00:00:00', 1),
(36, 1, 1, 'nowa', 'kkk', '2017-12-03 14:59:57', '2017-12-13 00:00:00', 1),
(37, 1, 1, 'dsfsaf', 'sdaasf', '2017-12-03 15:10:54', '2017-12-04 00:00:00', 1),
(42, 10, 1, 'poniedzialek', 'cos', '2017-12-05 17:45:32', '2017-12-13 00:00:00', 0),
(43, 10, 1, 'wtorek', 'kkk', '2017-12-05 17:46:14', '2017-12-20 00:00:00', 1),
(44, 8, 1, 'nowe', 'sss', '2017-12-05 18:08:05', '2017-12-21 00:00:00', 0),
(46, 1, 1, 'nowe', 'sss', '2017-12-05 18:28:09', '2017-12-13 00:00:00', 1),
(47, 1, 1, 'trzcie', 'kk', '2017-12-05 18:30:02', '2017-12-19 00:00:00', 0),
(48, 1, 1, 'nowwww', 'sss', '2017-12-05 19:26:40', '2017-12-13 00:00:00', 0),
(49, 1, 1, 'jivsvcdszv', 'dszvfdcsfd', '2017-12-09 10:01:40', '2017-12-20 09:55:00', 0),
(50, 5, 1, 'nowe', 'sss', '2017-12-09 10:05:57', '2017-12-12 10:05:00', 0),
(51, 1, 1, 'ciekawe', 'sss', '2017-12-09 10:51:03', '2017-12-14 10:51:00', 0),
(52, 7, 2, 'nowe', 'ssqdda', '2017-12-09 13:37:34', '2017-12-18 13:37:00', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_64C19C1A76ED395` (`user_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526C8DB60186` (`task_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Indexes for table `fos_user`
--
ALTER TABLE `fos_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`);

--
-- Indexes for table `priority`
--
ALTER TABLE `priority`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB2512469DE2` (`category_id`),
  ADD KEY `IDX_527EDB25497B19F9` (`priority_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT dla tabeli `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT dla tabeli `fos_user`
--
ALTER TABLE `fos_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `priority`
--
ALTER TABLE `priority`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `FK_64C19C1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`);

--
-- Ograniczenia dla tabeli `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C8DB60186` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user` (`id`);

--
-- Ograniczenia dla tabeli `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB2512469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_527EDB25497B19F9` FOREIGN KEY (`priority_id`) REFERENCES `priority` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
