-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 09:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project oop`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikelen`
--

CREATE TABLE `artikelen` (
  `ArtikelID` int(11) NOT NULL,
  `Naam` varchar(100) DEFAULT NULL,
  `Beschrijving` text DEFAULT NULL,
  `Prijs` decimal(10,2) DEFAULT NULL,
  `Voorraad` int(11) DEFAULT NULL,
  `Categorie` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artikelen`
--

INSERT INTO `artikelen` (`ArtikelID`, `Naam`, `Beschrijving`, `Prijs`, `Voorraad`, `Categorie`) VALUES
(1, 'Laptop', '15-inch laptop', 799.99, 10, 'Elektronica'),
(2, 'Muismat', 'Comfortabele muismat', 9.99, 100, 'Accessoires'),
(3, 'Toetsenbord', 'Mechanisch toetsenbord', 59.99, 50, 'Accessoires'),
(4, 'Monitor', '24-inch monitor', 149.99, 20, 'Elektronica'),
(5, 'USB-kabel', '1 meter USB-C kabel', 5.99, 200, 'Accessoires'),
(6, 'Headset', 'Draadloze headset', 89.99, 30, 'Elektronica');

-- --------------------------------------------------------

--
-- Table structure for table `klanten`
--

CREATE TABLE `klanten` (
  `KlantID` int(11) NOT NULL,
  `Naam` varchar(100) DEFAULT NULL,
  `Adres` varchar(255) DEFAULT NULL,
  `Postcode` varchar(10) DEFAULT NULL,
  `Plaats` varchar(100) DEFAULT NULL,
  `Land` varchar(50) DEFAULT NULL,
  `Telefoonnummer` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Registratiedatum` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klanten`
--

INSERT INTO `klanten` (`KlantID`, `Naam`, `Adres`, `Postcode`, `Plaats`, `Land`, `Telefoonnummer`, `Email`, `Registratiedatum`) VALUES
(1, 'Jan Jansen', 'Hoofdstraat 1', '1234 AB', 'Amsterdam', 'Nederland', '0612345678', 'jan.jansen@example.com', '2023-01-15'),
(2, 'Piet Pieters', 'Kerklaan 2', '5678 CD', 'Utrecht', 'Nederland', '0698765432', 'piet.pieters@example.com', '2023-02-20'),
(3, 'Marie Vermeer', 'Dorpsweg 5', '3456 EF', 'Rotterdam', 'Nederland', '0611122233', 'marie.vermeer@example.com', '2023-03-10'),
(4, 'Hans de Vries', 'Bakkerstraat 8', '6789 GH', 'Den Haag', 'Nederland', '0622233444', 'hans.de.vries@example.com', '2023-04-01'),
(5, 'Anna van Dijk', 'Lindelaan 7', '7890 IJ', 'Eindhoven', 'Nederland', '0633344555', 'anna.van.dijk@example.com', '2023-05-15'),
(6, 'Tom Bakker', 'Rivierweg 12', '8901 KL', 'Maastricht', 'Nederland', '0644455666', 'tom.bakker@example.com', '2023-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `OrderDetailID` int(11) NOT NULL,
  `OrderID` int(11) DEFAULT NULL,
  `ArtikelID` int(11) DEFAULT NULL,
  `Aantal` int(11) DEFAULT NULL,
  `PrijsPerStuk` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`OrderDetailID`, `OrderID`, `ArtikelID`, `Aantal`, `PrijsPerStuk`) VALUES
(15, 1, 1, 1, 799.99),
(16, 1, 2, 2, 9.99),
(17, 2, 2, 20, 9.99),
(18, 3, 3, 3, 59.99),
(19, 4, 4, 1, 149.99),
(20, 5, 5, 5, 5.99),
(21, 6, 6, 1, 89.99);

-- --------------------------------------------------------

--
-- Table structure for table `verkooporders`
--

CREATE TABLE `verkooporders` (
  `OrderID` int(11) NOT NULL,
  `KlantID` int(11) DEFAULT NULL,
  `OrderDatum` date DEFAULT NULL,
  `VerzendDatum` date DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `TotaalBedrag` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verkooporders`
--

INSERT INTO `verkooporders` (`OrderID`, `KlantID`, `OrderDatum`, `VerzendDatum`, `Status`, `TotaalBedrag`) VALUES
(1, 1, '2023-03-01', '2023-03-03', 'Verzonden', 150.75),
(2, 2, '2023-03-02', '2023-03-05', 'In behandeling', 200.00),
(3, 3, '2023-04-15', '2023-04-18', 'Verzonden', 300.50),
(4, 4, '2023-05-20', '2023-05-22', 'Geannuleerd', 400.00),
(5, 5, '2023-06-10', '2023-06-12', 'Verzonden', 250.00),
(6, 6, '2023-07-01', '2023-07-03', 'In behandeling', 100.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikelen`
--
ALTER TABLE `artikelen`
  ADD PRIMARY KEY (`ArtikelID`);

--
-- Indexes for table `klanten`
--
ALTER TABLE `klanten`
  ADD PRIMARY KEY (`KlantID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ArtikelID` (`ArtikelID`);

--
-- Indexes for table `verkooporders`
--
ALTER TABLE `verkooporders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `KlantID` (`KlantID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikelen`
--
ALTER TABLE `artikelen`
  MODIFY `ArtikelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `klanten`
--
ALTER TABLE `klanten`
  MODIFY `KlantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `verkooporders`
--
ALTER TABLE `verkooporders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `orderdetails_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `verkooporders` (`OrderID`),
  ADD CONSTRAINT `orderdetails_ibfk_2` FOREIGN KEY (`ArtikelID`) REFERENCES `artikelen` (`ArtikelID`);

--
-- Constraints for table `verkooporders`
--
ALTER TABLE `verkooporders`
  ADD CONSTRAINT `verkooporders_ibfk_1` FOREIGN KEY (`KlantID`) REFERENCES `klanten` (`KlantID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
