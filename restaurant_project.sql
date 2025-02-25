-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Feb 25. 13:29
-- Kiszolgáló verziója: 10.4.32-MariaDB
-- PHP verzió: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `restaurant_project`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `cart`
--

CREATE TABLE `cart` (
  `CARTID` int(11) NOT NULL,
  `ITEMID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- A tábla adatainak kiíratása `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `category`, `price`) VALUES
(7, 'BBQ Szárnyak', 'Fűszeres, mézes-barbecue szósszal, friss zöldségekkel', 'Előétel', 1500),
(8, 'Rántott Jalapeño', 'Töltött jalapeño paprikák, cheddar sajttal, házi BBQ szószban', 'Előétel', 1200),
(9, 'Sült Kacsamájas Toast', 'Fűszeres BBQ szószban sült kacsamáj, ropogós kenyéren', 'Előétel', 1800),
(10, 'Grillezett Kukorica', 'Fűszeres vajjal és barbecue pácban grillezve', 'Előétel', 900),
(11, 'Szenvedélyes BBQ Ribs', 'Túlzsúfolt rib-eye bordák, házi BBQ szósszal, körettel', 'Főétel', 3800),
(12, 'Smokehouse Brisket', 'Füstölt marhahús, lassú tűzön sült, szaftos, házi BBQ szószban', 'Főétel', 4000),
(13, 'Grillezett BBQ Csirke', 'Szaftos csirkemell, fűszeres BBQ pácban grillezve', 'Főétel', 2800),
(14, 'Pulled Pork Sandwich', 'Hosszú ideig füstölt sertéshús, BBQ szószban, friss zsemlében', 'Főétel', 2500),
(15, 'Vegán BBQ Tál', 'Füstölt zöldségek, grillezett tofuszeletek és házi BBQ szósz', 'Főétel', 2700),
(16, 'Coleslaw Saláta', 'Friss káposzta, sárgarépa és joghurtos öntet', 'Köret', 800),
(17, 'Fűszeres Párizsi Burgonya', 'Sült burgonya fokhagymás fűszerrel, BBQ szószban', 'Köret', 950),
(18, 'Grillezett Zöldségek', 'Paprika, cukkini, gomba és hagyma, grillezve', 'Köret', 1100),
(19, 'Sült Kukorica', 'Fűszeres vajjal, lime-mal', 'Köret', 900),
(20, 'BBQ Füstölt Almás Pite', 'Meleg füstölt almás pite vaníliafagylalttal', 'Desszert', 1500),
(21, 'Choco-BBQ Brownie', 'Csokis brownie BBQ karamellel és vanília krémmel', 'Desszert', 1600),
(22, 'Lemonade & Ice Tea', 'Friss házi limonádé és jeges tea', 'Ital', 600),
(23, 'Házi Üdítők', 'Házilag készített szénsavas üdítők', 'Ital', 500),
(24, 'Kézműves Sörök', 'Válogatott helyi sörök', 'Ital', 800),
(25, 'BBQ Koktélok', 'Speciális koktélok, mint például a \"Smoky Margarita\" vagy \"BBQ Mojito\"', 'Ital', 1200);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `LASTNAME` varchar(250) NOT NULL,
  `FIRSTNAME` varchar(250) NOT NULL,
  `EMAIL` varchar(300) NOT NULL,
  `PHONENUMBER` int(11) NOT NULL,
  `PASSWORD` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CARTID`),
  ADD KEY `ITEMID` (`ITEMID`),
  ADD KEY `USERID` (`USERID`);

--
-- A tábla indexei `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `cart`
--
ALTER TABLE `cart`
  MODIFY `CARTID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`ITEMID`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
