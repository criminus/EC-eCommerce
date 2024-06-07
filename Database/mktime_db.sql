-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 07, 2024 at 03:06 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mktime_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `basket`
--

DROP TABLE IF EXISTS `basket`;
CREATE TABLE IF NOT EXISTS `basket` (
  `basket_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`basket_id`),
  UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basket`
--

INSERT INTO `basket` (`basket_id`, `user_id`, `product_id`, `quantity`, `total`) VALUES
(3, 2, 2, 1, '225.99'),
(4, 2, 3, 1, '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feedback` text NOT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `product_id`, `user_id`, `feedback`) VALUES
(1, 2, 1, 'This is a great product, also a great feedback message for this item.'),
(2, 1, 1, 'This is a premium platinum feedback message by user 1.'),
(3, 4, 1, 'There it is ... the 3rd feedback for the watch number 4 by user 1.'),
(4, 8, 1, '4th and last feedback message by user 1 for watch number 8.'),
(5, 1, 2, 'Can I also leave my feedback here? I am user number 2!');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`) VALUES
(1, 1, '2024-06-07 03:43:46', '150.00'),
(2, 1, '2024-06-07 03:44:33', '951.98');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `order_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 3, 3, '50.00'),
(2, 2, 1, 1, '125.99'),
(3, 2, 2, 1, '225.99'),
(4, 2, 5, 1, '100.00'),
(5, 2, 8, 1, '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale` tinyint(1) DEFAULT NULL,
  `discount` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `image`, `price`, `sale`, `discount`) VALUES
(1, 'Platinum Watch', 'This is a platinum watch made with passion and skills. This is also a dummy description for this item.', '1.png', '125.99', 0, '0.00'),
(2, 'Watch #2', 'A dummy description for a watch. ', '2.png', '225.99', 0, '0.00'),
(3, 'Watch #3', 'Another description for a watch.', '3.png', '50.00', 0, '0.00'),
(4, 'Watch #4', 'Another description for a watch.', '4.png', '75.00', 0, '0.00'),
(5, 'Watch No5', 'Description for this item.', '5.png', '100.00', 0, '0.00'),
(6, 'Watch No6', 'Another description', '6.png', '88.99', 0, '0.00'),
(7, 'Watch No7', 'Item with description. This is the 7th item.', '7.png', '69.99', 0, '0.00'),
(8, 'Watch No8', 'Simple description for the 8th watch.', '8.png', '500.00', 0, '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `reg_date` date DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `pass`, `reg_date`) VALUES
(1, 'Anisor', 'Neculai', 'neculaioffi@gmail.com', 'Test123', '2024-06-06'),
(2, 'Anisor1', 'Neculai1', 'neculaioffi1@gmail.com', 'Test123', '2024-06-06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
