-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2026 at 03:56 PM
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
-- Database: `cookieco`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `description`) VALUES
(1, 'Chocolate Chip Cookie', 'Cookies', 120.00, 'A soft and chewy cookie loaded with rich, melty chocolate chips in every bite'),
(2, 'Double Chocolate Cookie', 'Cookies', 130.00, 'A decadent chocolate cookie packed with gooey chocolate chunks for an intense cocoa flavor.'),
(3, 'Oat Chocolate Walnut Cookie', 'Cookies', 135.00, 'A hearty blend of oats, chocolate chips, and crunchy walnuts for a perfectly balanced bite.'),
(4, 'White Macadamia Cookie', 'Cookies', 140.00, 'A buttery cookie filled with creamy white chocolate and crunchy macadamia nuts.'),
(5, 'Pistachio Cookie', 'Cookies', 140.00, 'A nutty and aromatic cookie infused with roasted pistachios for a rich, unique flavor.'),
(6, 'Birthday Cake Cookie', 'Cookies', 130.00, 'A fun, soft cookie bursting with colorful sprinkles and sweet vanilla cake flavor.'),
(7, 'Red Velvet Cookie', 'Cookies', 140.00, 'A rich, cocoa-infused cookie with a hint of vanilla and a signature red velvet taste.'),
(8, 'White Chocolate Matcha Cookie', 'Cookies', 150.00, 'A smooth matcha-flavored cookie complemented by sweet, creamy white chocolate chunks.'),
(9, 'Chocolate Fudge Brownies', 'Brownies', 150.00, 'A dense and fudgy brownie packed with deep, rich chocolate goodness.'),
(10, 'Biscoff Brownies', 'Brownies', 160.00, 'A rich chocolate brownie swirled with creamy Biscoff spread for a caramelized, spiced twist.'),
(11, 'Red Velvet Brownies', 'Brownies', 160.00, 'A moist and velvety brownie with a hint of cocoa and a vibrant red finish.'),
(12, 'Chocolate Cheesecake Brownies', 'Brownies', 170.00, 'A luscious combination of fudgy chocolate brownie and creamy cheesecake swirls.'),
(13, 'Chocolate Cake', 'Cakes', 300.00, 'A moist and fluffy cake layered with rich, smooth chocolate frosting.'),
(14, 'Matcha Cake', 'Cakes', 320.00, 'A light and earthy matcha-infused cake with a delicate sweetness.'),
(15, 'Strawberry Shortcake', 'Cakes', 350.00, 'A soft, fluffy cake layered with fresh strawberries and lightly sweetened cream.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
