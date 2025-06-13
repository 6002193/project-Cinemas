-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 02 jun 2025 om 13:05
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbocinema`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `UserName` varchar(255) DEFAULT NULL,
  `UserPassword` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telefoonnumer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`ID`, `UserName`, `UserPassword`, `email`, `telefoonnumer`) VALUES
(1, 'Tijs', '$2y$10$H.yVJRX2t3K9YzvBXHHC8e2Sqp01/wFKPTHrbOzthDsNrTSS6DABG', NULL, NULL);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`) USING BTREE,
  ADD UNIQUE KEY `UserName` (`UserName`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- voor de 2 tables voor reserveringen en films

CREATE TABLE movies (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255),
    rating INT(11),
    room INT(11),
    seats INT(11),
    foto_url TEXT
);

CREATE TABLE reserveringen (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(100),
    email VARCHAR(100),
    telefoon VARCHAR(20),
    locatie VARCHAR(100),
    datum DATE,
    tijd TIME,
    aantal INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    movie_id INT(11),
    user_id INT(11),
    bevestigingsnummer VARCHAR(20),
    FOREIGN KEY (movie_id) REFERENCES movies(id)
);
