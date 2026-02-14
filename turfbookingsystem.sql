-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 12, 2026 at 04:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `turfbookingsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Prince', 'Prince@123');

-- --------------------------------------------------------

--
-- Table structure for table `card_data`
--

CREATE TABLE `card_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `cardholdername` varchar(50) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expiry` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `turfs` varchar(20) NOT NULL,
  `payment_reference` varchar(50) DEFAULT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `card_data`
--

INSERT INTO `card_data` (`id`, `user_id`, `username`, `cardholdername`, `cardnumber`, `expiry`, `cvv`, `turfs`, `payment_reference`, `payment_date`) VALUES
(9, 16, 'princeantala', 'antala prince hiteshbhai', '456654234432', '09/32', '234', 'football', 'FOOTBALL58691', '2025-08-25 23:14:12'),
(10, 16, 'princeantala', 'antala prince hiteshbhai', '234554345432', '02/28', '333', 'football', 'FOOTBALL95423', '2026-02-12 18:07:30');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `user_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `message_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`user_id`, `name`, `email`, `mobile`, `message`, `message_date`) VALUES
(16, 'Prince antala', 'princeantala45@gmail', '7990972794', 'this is demo message for contact page.', '2025-08-24 14:57:49'),
(16, 'prince antala', 'princeantala45@gmail', '3465754323456', 'weiotlkfnksjzfxmcoisdljkfzm,x.c', '2026-02-12 13:41:31'),
(16, 'Prince antala', 'princeantala45@gmail', '7990972794', 'wsefdgbvfdsdcx ', '2026-02-12 16:10:06'),
(16, 'Prince antala', 'princeantala45@gmail', '7990972794', 'wsefdgbvfdsdcx ', '2026-02-12 16:11:45'),
(16, 'Infosys', 'princeantala45@gmail', '7990972794', 'demo', '2026-02-12 16:12:29'),
(16, 'Example', 'example@gmail.com', '7903235643', 'example', '2026-02-12 16:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(50) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_availability` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_price`, `product_image`, `product_availability`) VALUES
(1, 'Ceat Bat', '45000', 'product-img/1754487457_ceat-pica.png', 'In Stock'),
(2, 'SG Bat', '9999', 'product-img/sg.png', 'In Stock'),
(3, 'SS Bat', '7650', 'product-img/ss.png', 'In Stock'),
(4, 'Ton Bat', '2773', 'product-img/ton.png', 'In Stock'),
(5, 'Badminton Racket', '2500', 'product-img/racket.png', 'Low Stock'),
(6, 'Tennis Racket', '3500', 'product-img/tennis-racket.png', 'In Stock'),
(7, 'Golf Club', '4000', 'product-img/golf-bat.png', 'In Stock'),
(8, 'Baseball', '800', 'product-img/baseball.png', 'In Stock'),
(9, 'Javelin Stick', '5000', 'product-img/javelin.png', 'In Stock'),
(10, 'Hockey Stick', '1500', 'product-img/hockey.png', 'In Stock'),
(11, 'Nike Football', '1299', 'product-img/nike-football.png', 'Low Stock'),
(12, 'Nivia Football', '599', 'product-img/nivia-football.png', 'In Stock'),
(13, 'Tennis Ball', '300', 'product-img/tennis.png', 'In Stock'),
(14, 'Cricket Pink Ball', '450', 'product-img/cricket-pink-ball.png', 'In Stock'),
(15, 'Cricket Red Ball', '299', 'product-img/red-ball.png', 'Low Stock'),
(16, 'Rugby Ball', '3500', 'product-img/rugby.png', 'In Stock'),
(17, 'Cricket White Ball', '949', 'product-img/white-ball.png', 'In Stock'),
(18, 'Stumping Gloves', '649', 'product-img/stump.png', 'In Stock'),
(19, 'Batting Gloves', '499', 'product-img/gloves-pica.png', 'In Stock'),
(20, 'Puma Shoes', '15999', 'product-img/puma-shoes.png', 'In Stock'),
(21, 'DSC Shoes', '10999', 'product-img/dsc-shoes.png', 'Low Stock'),
(22, 'Cricket Pad', '2999', 'product-img/pad-pica.png', 'In Stock'),
(23, 'Sport Helmet', '5555', 'product-img/helmet.png', 'In Stock'),
(24, 'Sport Bag', '2999', 'product-img/bag.png', 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `product_card_data`
--

CREATE TABLE `product_card_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `cardholdername` varchar(100) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expiry` varchar(10) NOT NULL,
  `cvv` varchar(5) NOT NULL,
  `product` varchar(255) NOT NULL,
  `payment_ref` varchar(50) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_card_data`
--

INSERT INTO `product_card_data` (`id`, `user_id`, `username`, `cardholdername`, `cardnumber`, `expiry`, `cvv`, `product`, `payment_ref`, `payment_date`) VALUES
(3, 16, 'princeantala', 'antala prince hiteshbhai', '455432389544', '09/30', '345', 'Badminton Racket (x1), Puma Shoes (x1)', 'Product-5751', '2025-08-24 18:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_shopping`
--

CREATE TABLE `product_shopping` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `product_names` text NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `payment_ref` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_shopping`
--

INSERT INTO `product_shopping` (`id`, `user_id`, `fullname`, `email`, `mobile`, `state`, `city`, `pincode`, `address`, `product_names`, `subtotal`, `sgst`, `cgst`, `grand_total`, `payment_method`, `payment_ref`, `created_at`) VALUES
(23, 16, 'antala prince hiteshbhai', 'princeantala45@gmail.com', '7990972794', 'gujarat', 'dhoraji', '360410', 'kharawad plote , near bus station , dhoraji', 'Badminton Racket (x1), Puma Shoes (x1)', 18499.00, 1664.91, 1664.91, 21828.82, 'card', 'Product-5751', '2025-08-24 18:24:25'),
(24, 16, 'antala prince hiteshbhai', 'demo@gmail.com', '9999999999', 'gujarat', 'kadi', '333333', 'sv campus , ayodhya nagar , kadi ', 'Ceat Bat (x1), Cricket White Ball (x1)', 45949.00, 4135.41, 4135.41, 54219.82, 'upi', 'Product-8514', '2025-08-24 18:25:57'),
(25, 16, 'antala prince hiteshbhai', 'demo@gmail.com', '9898989898', 'gujarat', 'kadi', '543433', 's v campus kadi', 'Golf Club (x1), Sport Bag (x1)', 6999.00, 629.91, 629.91, 8258.82, 'cod', 'Product-2095', '2025-08-24 18:26:59'),
(35, 16, 'Prince antala', 'princeantala45@gmail.com', '3456753245', 'gujrata', 'dhoraji', '345423', 'dhoraji', 'Javelin Stick (x5), Cricket Red Ball (x4)', 26196.00, 2357.64, 2357.64, 30911.28, 'upi', 'Product-5858', '2026-02-12 18:10:37'),
(36, 16, 'Rohit Sharma', 'princeantala45@gmail.com', '7990972794', 'Gujarat', 'kathrota', '343434', 'trdghmb', 'SG Bat (x2), SS Bat (x1)', 27648.00, 2488.32, 2488.32, 32624.64, 'upi', 'Product-5253', '2026-02-12 19:19:28'),
(37, 16, 'Rohit Sharma', 'ram@gmail.com', '7990972794', 'Gujarat', 'Dhoraji', '360410', 'dhoraji rajkot', 'Golf Club (x6)', 24000.00, 2160.00, 2160.00, 28320.00, 'cod', 'Product-8691', '2026-02-12 20:48:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_upi_data`
--

CREATE TABLE `product_upi_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `upiid` varchar(50) NOT NULL,
  `product` varchar(255) NOT NULL,
  `payment_ref` varchar(50) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_upi_data`
--

INSERT INTO `product_upi_data` (`id`, `user_id`, `username`, `upiid`, `product`, `payment_ref`, `payment_date`) VALUES
(4, 16, 'princeantala', 'princeantala45@upi', 'Ceat Bat (x1), Cricket White Ball (x1)', 'Product-8514', '2025-08-24 18:25:57'),
(5, 16, 'princeantala', 'princeantala45@upi', 'Javelin Stick (x5), Cricket Red Ball (x4)', 'Product-5858', '2026-02-12 18:10:37'),
(6, 16, 'princeantala', 'princeantala45@upi', 'SG Bat (x2), SS Bat (x1)', 'Product-5253', '2026-02-12 19:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `signup`
--

CREATE TABLE `signup` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `signup`
--

INSERT INTO `signup` (`user_id`, `username`, `email`, `mobile`, `password`, `signup_date`) VALUES
(16, 'princeantala', 'princeantala45@gmail.com', '7990972794', 'Prince@123', '2025-08-24 18:16:55'),
(17, 'Demo', 'demo@gmail.com', '3456432345', 'Demo@123', '2026-02-12 18:16:41'),
(18, 'demoo', 'princeantala@gmail.com', '2345643234', 'Demo@123', '2026-02-12 18:52:13');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(20) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `state` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `turfs` varchar(50) NOT NULL,
  `base_price` decimal(10,2) NOT NULL,
  `cgst` decimal(10,2) NOT NULL,
  `sgst` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `address` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `date` varchar(100) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `booking_time` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_reference` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`booking_id`, `user_id`, `username`, `fullname`, `email`, `mobile`, `state`, `city`, `turfs`, `base_price`, `cgst`, `sgst`, `total_price`, `address`, `pincode`, `date`, `payment_method`, `booking_time`, `payment_reference`) VALUES
(54, 16, 'princeantala', 'antala prince hiteshbhai', 'princeantala45@gmail', '7990972794', 'gujarat', 'dhoraji', 'cricket', 10000.00, 900.00, 900.00, 11800.00, 'kharawad plote , near bus station , dhoraji', '360410', '2025-09-01', 'card', '2025-08-24 18:20:52', 'CRICKET60497'),
(55, 16, 'princeantala', 'antala prince hiteshbhai', 'princeantala7@gmail.', '7797979779', 'gujarat', 'dhoraji', 'tennis', 2500.00, 225.00, 225.00, 2950.00, 'kharawad plote , near bus station , dhoraji', '360410', '2025-09-03', 'upi', '2025-08-24 18:22:28', 'TENNIS92692'),
(56, 16, 'princeantala', 'antala prince hiteshbhai', 'demo@gmail.com', '9999999999', 'gujarat', 'kadi', 'football', 5000.00, 450.00, 450.00, 5900.00, 'Sv campus , ayodhya nagar , kadi', '333333', '2025-08-26', 'cod', '2025-08-24 18:23:07', 'FOOTBALL26630'),
(67, 16, 'princeantala', 'Prince antala', 'hello@gmail.com', '7875546786', 'gujarat', 'dhoraji', 'volleyball', 2000.00, 180.00, 180.00, 2360.00, 'dhoraji', '234567', '2026-02-21', 'upi', '2026-02-12 17:54:40', 'VOLLEYBALL72589'),
(68, 16, 'princeantala', 'Prince antala', 'princeantala45@gmail', '4356765456', 'gujarat', 'dhoraji', 'football', 5000.00, 450.00, 450.00, 5900.00, 'dhoraji', '345675', '2026-03-01', 'card', '2026-02-12 18:07:30', 'FOOTBALL95423'),
(69, 16, 'princeantala', 'Prince antala', 'princeantala45@gmail', '7990972794', 'Gujarat', 'rajkot', 'volleyball', 2000.00, 180.00, 180.00, 2360.00, 'dhoraji', '343434', '2026-03-09', 'cod', '2026-02-12 18:52:53', 'VOLLEYBALL61648'),
(70, 16, 'princeantala', 'Virat Kohli', 'princeantala45@gmail', '3434334345', 'edfgbcb', 'rajkot', 'volleyball', 2000.00, 180.00, 180.00, 2360.00, 'dhoraji', '360410', '2026-03-04', 'cod', '2026-02-12 18:56:29', 'VOLLEYBALL98106'),
(71, 16, 'princeantala', 'Prince antala', 'hello@gmail.com', '2456782345', 'Gujarat', 'Dhoraji', 'volleyball', 2000.00, 180.00, 180.00, 2360.00, 'dhoraji', '451234', '2026-03-03', 'cod', '2026-02-12 18:59:50', 'VOLLEYBALL30766'),
(72, 16, 'princeantala', 'Rohit Sharma', 'hello@gmail.com', '3434334234', 'Gujarat', 'Dhoraji', 'football', 5000.00, 450.00, 450.00, 5900.00, 'dhoraji', '360410', '2026-03-02', 'cod', '2026-02-12 19:07:39', 'FOOTBALL65795');

-- --------------------------------------------------------

--
-- Table structure for table `upi`
--

CREATE TABLE `upi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `upiid` varchar(50) NOT NULL,
  `turfs` varchar(20) NOT NULL,
  `payment_reference` varchar(50) DEFAULT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `upi`
--

INSERT INTO `upi` (`id`, `user_id`, `username`, `upiid`, `turfs`, `payment_reference`, `payment_date`) VALUES
(22, 16, 'princeantala', 'princeantala@upi', 'golf', 'GOLF37626', '2025-08-25 23:12:41'),
(24, 16, 'princeantala', 'princeantala45@upi', 'volleyball', 'VOLLEYBALL72589', '2026-02-12 17:54:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `card_data`
--
ALTER TABLE `card_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_card_data`
--
ALTER TABLE `product_card_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_shopping`
--
ALTER TABLE `product_shopping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_upi_data`
--
ALTER TABLE `product_upi_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `signup`
--
ALTER TABLE `signup`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `upi`
--
ALTER TABLE `upi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `card_data`
--
ALTER TABLE `card_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_card_data`
--
ALTER TABLE `product_card_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_shopping`
--
ALTER TABLE `product_shopping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `product_upi_data`
--
ALTER TABLE `product_upi_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `signup`
--
ALTER TABLE `signup`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `upi`
--
ALTER TABLE `upi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card_data`
--
ALTER TABLE `card_data`
  ADD CONSTRAINT `card_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `product_card_data`
--
ALTER TABLE `product_card_data`
  ADD CONSTRAINT `product_card_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `product_shopping`
--
ALTER TABLE `product_shopping`
  ADD CONSTRAINT `product_shopping_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `product_upi_data`
--
ALTER TABLE `product_upi_data`
  ADD CONSTRAINT `product_upi_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);

--
-- Constraints for table `upi`
--
ALTER TABLE `upi`
  ADD CONSTRAINT `upi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `signup` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
