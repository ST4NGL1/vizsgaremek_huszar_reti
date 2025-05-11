-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 11, 2025 at 05:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CARTID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `ITEMID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `ITEMID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `CATEGORY` varchar(100) NOT NULL,
  `PRICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ITEMID`, `NAME`, `DESCRIPTION`, `CATEGORY`, `PRICE`) VALUES
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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDERID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `ORDERDATE` datetime NOT NULL DEFAULT current_timestamp(),
  `TOTALPRICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ORDERID`, `USERID`, `ORDERDATE`, `TOTALPRICE`) VALUES
(76, 10, '2025-05-11 17:34:34', 900);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `ORDERITEMID` int(11) NOT NULL,
  `ORDERID` int(11) NOT NULL,
  `ITEMID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `PRICE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`ORDERITEMID`, `ORDERID`, `ITEMID`, `QUANTITY`, `PRICE`) VALUES
(69, 76, 19, 1, 900);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `LASTNAME` varchar(250) NOT NULL,
  `FIRSTNAME` varchar(250) NOT NULL,
  `EMAIL` varchar(300) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USERID`, `LASTNAME`, `FIRSTNAME`, `EMAIL`, `PASSWORD`) VALUES
(10, 'teszt', 'teszt', 'teszt@teszt.com', '$2y$10$tQVrIKQ8IOmF6VZUDdgUEeo/YGkZI/hDui1woyqDSITh3mB5B1i2O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CARTID`),
  ADD KEY `USERID` (`USERID`),
  ADD KEY `ITEMID` (`ITEMID`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`ITEMID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDERID`),
  ADD KEY `USERID` (`USERID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`ORDERITEMID`),
  ADD KEY `ORDERID` (`ORDERID`),
  ADD KEY `ITEMID` (`ITEMID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`),
  ADD UNIQUE KEY `EMAIL` (`EMAIL`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CARTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `ITEMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `ORDERITEMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ITEMID`) REFERENCES `menu` (`ITEMID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`ORDERID`) REFERENCES `orders` (`ORDERID`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`ITEMID`) REFERENCES `menu` (`ITEMID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
