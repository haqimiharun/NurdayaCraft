-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2023 at 03:48 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nurdaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'Mug', 'Y'),
(2, 'Bookmark', 'Y'),
(3, 'Brooch', 'Y'),
(4, 'Keychain', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_qty` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `addresses` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` int(5) NOT NULL,
  `states` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `tracking_no` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'P'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `product_id`, `product_qty`, `subtotal`, `user_id`, `email`, `first_name`, `last_name`, `addresses`, `address2`, `city`, `postcode`, `states`, `phone_number`, `tracking_no`, `status`) VALUES
(1, 1, 3, '30.00', 0, 'jijiskyline@gmail.com', 'MOHAMED HAZIZI', 'HAMDAN', 'LOT 330, JALAN KEJORA 2, KG MELAYU RASA TAMBAHAN', '', 'Rasa', 44200, 'Selangor', '+290 1129057189', '', 'P');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `promotion_rate` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_qty` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `promotion_id`, `promotion_rate`, `product_name`, `product_description`, `product_price`, `product_qty`, `product_image`, `product_status`) VALUES
(1, 1, NULL, NULL, 'Friendship Never End Mug', 'This is a mug can be a gift to your dedicated friends', '10.00', '7', 'mug1.jpeg', 'Y'),
(2, 1, NULL, NULL, 'Family Day Mug', 'This is a mug for an occasional event of Family Day\r\n\r\nWith the added coaster', '15.00', '20', 'mug2.jpeg', 'Y'),
(3, 1, NULL, NULL, 'Ownership Mug', 'Customize your mug to add your own personal touches to it', '7.00', '30', 'mug3.jpeg', 'Y'),
(4, 1, NULL, NULL, 'Event Thank You Mug', 'Show your gratitude toward the person attending any sort of ceremony of event you held', '12.00', '10', 'mug6.jpeg', 'Y'),
(5, 2, NULL, NULL, 'Zikir Bookmark', 'Use this bookmark to remind yourself as remembrance to Allah', '5.00', '15', 'bookmark1.jpeg', 'Y'),
(6, 2, NULL, NULL, 'Name Bookmark', 'Make a bookmark as your own when your put your name into it', '6.00', '10', 'bookmark2.jpeg', 'Y'),
(7, 3, NULL, NULL, 'Butterfly Brooch Pin', 'A beautifully well made brooch in shape of a butterfly', '5.00', '10', 'broch2.jpeg', 'Y'),
(8, 3, NULL, NULL, 'Metal Brooch', 'A unique brooch that made of steel.', '4.00', '20', 'broch3.png', 'Y'),
(9, 3, NULL, NULL, 'Wooden Brooch', 'A carved wooden brooch.', '8.00', '10', 'broch4.jpeg', 'Y'),
(10, 4, NULL, NULL, 'Ruler Keychain', 'A small keychain with the functionality of a ruler.', '2.00', '10', 'key1.jpeg', 'Y'),
(11, 4, NULL, NULL, 'Colourful Name Keychain', 'Get a keychain with your name with colourful decoration.', '6.00', '10', 'key2.jpeg', 'Y'),
(12, 4, NULL, NULL, 'Stay Solehah Keychain', 'Stay solehah always with added of your name', '4.00', '15', 'key4.jpeg', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `promotion`
--

CREATE TABLE `promotion` (
  `promotion_id` int(11) NOT NULL,
  `promotion_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotion`
--

INSERT INTO `promotion` (`promotion_id`, `promotion_type`) VALUES
(1, '%'),
(2, '-');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_type_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs DEFAULT NULL,
  `user_status` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_type_id`, `user_name`, `user_email`, `user_password`, `user_status`) VALUES
(1, 1, 'admin', 'admin@gmail.com', 'admin', 'Y'),
(2, 2, 'hazizi', 'hazizi@gmail.com', 'hazizi1234', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'ADMIN'),
(2, 'CUSTOMER');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`promotion_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `promotion`
--
ALTER TABLE `promotion`
  MODIFY `promotion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `user_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
