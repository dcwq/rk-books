-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 11 Gru 2017, 16:50
-- Wersja serwera: 5.7.19-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `dev_bold`
--
DELIMITER ;;;
CREATE DEFINER=`root`@`` FUNCTION `LEVENSHTEIN`(s1 VARCHAR(255) CHARACTER SET utf8, s2 VARCHAR(255) CHARACTER SET utf8) RETURNS int(11) DETERMINISTIC
BEGIN
    DECLARE s1_len, s2_len, i, j, c, c_temp, cost INT;
    DECLARE s1_char CHAR;
    DECLARE cv0, cv1 VARBINARY(256);
    SET s1_len = CHAR_LENGTH(s1), s2_len = CHAR_LENGTH(s2), cv1 = 0x00, j = 1, i = 1, c = 0;
    IF s1 = s2 THEN
        RETURN 0;
    ELSEIF s1_len = 0 THEN
        RETURN s2_len;
    ELSEIF s2_len = 0 THEN
        RETURN s1_len;
    ELSE
        WHILE j <= s2_len DO
            SET cv1 = CONCAT(cv1, UNHEX(HEX(j))), j = j + 1;
        END WHILE;
        WHILE i <= s1_len DO
            SET s1_char = SUBSTRING(s1, i, 1), c = i, cv0 = UNHEX(HEX(i)), j = 1;
            WHILE j <= s2_len DO
                SET c = c + 1;
                IF s1_char = SUBSTRING(s2, j, 1) THEN SET cost = 0; ELSE SET cost = 1; END IF;
                SET c_temp = CONV(HEX(SUBSTRING(cv1, j, 1)), 16, 10) + cost;
                IF c > c_temp THEN SET c = c_temp; END IF;
                SET c_temp = CONV(HEX(SUBSTRING(cv1, j+1, 1)), 16, 10) + 1;
                IF c > c_temp THEN SET c = c_temp; END IF;
                SET cv0 = CONCAT(cv0, UNHEX(HEX(c))), j = j + 1;
            END WHILE;
            SET cv1 = cv0, i = i + 1;
        END WHILE;
    END IF;
    RETURN c;
END;;;


DELIMITER ;;;
CREATE FUNCTION `LEVENSHTEIN_RATIO`(s1 VARCHAR(255) CHARACTER SET utf8, s2 VARCHAR(255) CHARACTER SET utf8) RETURNS int(11) DETERMINISTIC
BEGIN
    DECLARE s1_len, s2_len, max_len INT;
    SET s1_len = LENGTH(s1), s2_len = LENGTH(s2);
    IF s1_len > s2_len THEN SET max_len = s1_len; ELSE SET max_len = s2_len; END IF;
    RETURN ROUND((1 - LEVENSHTEIN(s1, s2) / max_len) * 100);
END;;;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(56) NOT NULL,
  `book_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `books`
--

INSERT INTO `books` (`id`, `name`, `book_date`) VALUES
(1, 'Zielona Mila', '2012-01-03'),
(2, 'Harry Potter', '2011-05-18'),
(3, 'Zielona Żabka', '2011-07-05'),
(4, 'Tajemnica', '2011-09-30'),
(5, 'Policja', '2011-12-06'),
(6, 'Na szafocie', '2011-12-28'),
(7, 'Co nam zostało', '2011-11-16');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` enum('m','f') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `reviews`
--

INSERT INTO `reviews` (`id`, `book_id`, `age`, `sex`) VALUES
(1, 2, 16, 'm'),
(2, 2, 29, 'f'),
(3, 4, 14, 'f'),
(4, 4, 16, 'm'),
(5, 1, 56, 'm'),
(6, 1, 58, 'm'),
(7, 3, 15, 'f'),
(8, 2, 15, 'm'),
(9, 2, 13, 'm'),
(10, 7, 29, 'f'),
(11, 7, 12, 'm'),
(12, 1, 38, 'f'),
(13, 6, 19, 'm'),
(14, 4, 17, 'f'),
(15, 3, 54, 'm'),
(16, 2, 52, 'f'),
(17, 1, 58, 'f');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `books` ADD FULLTEXT KEY `name` (`name`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT dla tabeli `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
