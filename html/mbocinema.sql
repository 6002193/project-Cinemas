-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 16 jun 2025 om 13:40
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
-- Tabelstructuur voor tabel `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `naam` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `room` int(11) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `foto_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `movies`
--

INSERT INTO `movies` (`id`, `naam`, `rating`, `room`, `seats`, `foto_url`) VALUES
(1, 'film', 10, 2, 52, 'logo.png'),
(2, 'movie', 1, 0, 4, 'banner.png');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reserveringen`
--

CREATE TABLE `reserveringen` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefoon` varchar(20) DEFAULT NULL,
  `locatie` varchar(100) DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `tijd` time DEFAULT NULL,
  `aantal` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `movie_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bevestigingsnummer` varchar(20) DEFAULT NULL,
  `film` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `reserveringen`
--

INSERT INTO `reserveringen` (`id`, `naam`, `email`, `telefoon`, `locatie`, `datum`, `tijd`, `aantal`, `created_at`, `movie_id`, `user_id`, `bevestigingsnummer`, `film`) VALUES
(1, '1', '6002193@mborijnland.nl', '1', '1', '0000-00-00', '03:33:00', 3, '2025-06-16 11:38:41', NULL, 1, 'IBCX763GKT', 'film');

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
(1, 'Tijs', '$2y$10$H.yVJRX2t3K9YzvBXHHC8e2Sqp01/wFKPTHrbOzthDsNrTSS6DABG', NULL, 'Tijs'),
(4, 'test', '$2y$10$gkFZugKOsfVHjxuzT5uSCOFoiqHzIMq45GTanR0vIBXHCWw1ur/mm', 'test@test.nl', '123123');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

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
-- AUTO_INCREMENT voor een tabel `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `reserveringen`
--
ALTER TABLE `reserveringen`
  ADD CONSTRAINT `reserveringen_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
