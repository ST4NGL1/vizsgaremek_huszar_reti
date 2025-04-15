-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Feb 27. 09:29
-- Kiszolgáló verziója: 10.4.28-MariaDB
-- PHP verzió: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `tanfolyam`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `ertekelesek`
--

CREATE TABLE `ertekelesek` (
  `id` int(11) NOT NULL,
  `tanuloid` int(11) NOT NULL,
  `tantargyid` int(11) NOT NULL,
  `jegy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `ertekelesek`
--

INSERT INTO `ertekelesek` (`id`, `tanuloid`, `tantargyid`, `jegy`) VALUES
(1, 1, 1, 3),
(2, 1, 2, 5),
(3, 2, 2, 5),
(4, 3, 2, 5),
(5, 1, 1, 5),
(6, 1, 10, 3),
(7, 1, 3, 4),
(8, 5, 1, 5),
(9, 4, 6, 1),
(10, 3, 3, 5),
(11, 2, 2, 4),
(12, 5, 1, 4),
(13, 1, 3, 3),
(14, 3, 10, 1),
(15, 1, 1, 4),
(16, 2, 3, 2);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tantargyak`
--

CREATE TABLE `tantargyak` (
  `id` int(11) NOT NULL,
  `megnevezes` varchar(100) NOT NULL,
  `tanar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tantargyak`
--

INSERT INTO `tantargyak` (`id`, `megnevezes`, `tanar`) VALUES
(1, 'Angol nyelv', 'Nemes Angéla'),
(2, 'Informatika', 'Kis Ede'),
(3, 'Magyar nyelv és irodalom ', 'Nagy Krisztina'),
(6, 'Matematika', 'Tóth Elek'),
(10, 'Kémia', 'Ka pál');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tanulok`
--

CREATE TABLE `tanulok` (
  `id` int(11) NOT NULL,
  `nev` varchar(100) NOT NULL,
  `telefonszam` varchar(20) DEFAULT NULL,
  `szuletesiido` date NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `tanulok`
--

INSERT INTO `tanulok` (`id`, `nev`, `telefonszam`, `szuletesiido`, `email`) VALUES
(1, 'Kovács Elek', '+36-70-1234567', '1991-02-28', 'elek0228@email.com'),
(2, 'Nagy Béla', '+36-55-335223', '1999-12-31', 'nagy.bela@drotposta.com'),
(3, 'Tóth Emil', '+36-55-475319', '1987-06-16', 'emil@e-level.com'),
(4, 'Tarant Ella', '+36-22-312161', '2003-06-12', 'tarantella@gmail.com'),
(5, 'Gaz Ella', '+36-30-1234567', '2000-12-12', 'gazella@gmail.com');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `ertekelesek`
--
ALTER TABLE `ertekelesek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tanuloid` (`tanuloid`,`tantargyid`),
  ADD KEY `tantargyid` (`tantargyid`);

--
-- A tábla indexei `tantargyak`
--
ALTER TABLE `tantargyak`
  ADD PRIMARY KEY (`id`),
  ADD KEY `megnevezes` (`megnevezes`);

--
-- A tábla indexei `tanulok`
--
ALTER TABLE `tanulok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `ertekelesek`
--
ALTER TABLE `ertekelesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT a táblához `tantargyak`
--
ALTER TABLE `tantargyak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `tanulok`
--
ALTER TABLE `tanulok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `ertekelesek`
--
ALTER TABLE `ertekelesek`
  ADD CONSTRAINT `ertekelesek_ibfk_1` FOREIGN KEY (`tantargyid`) REFERENCES `tantargyak` (`id`),
  ADD CONSTRAINT `ertekelesek_ibfk_2` FOREIGN KEY (`tanuloid`) REFERENCES `tanulok` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
