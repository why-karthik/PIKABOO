-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2023 at 05:34 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `baby`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `browser_product`
-- (See below for the actual view)
--
CREATE TABLE `browser_product` (
`id` int(11)
,`cname` varchar(100)
,`product_name` varchar(40)
,`price` double
,`image_name` varchar(100)
,`description` varchar(250)
,`quantity` int(11)
,`pid` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `browser_products`
-- (See below for the actual view)
--
CREATE TABLE `browser_products` (
`id` int(11)
,`cname` varchar(100)
,`product_name` varchar(40)
,`price` double
,`description` varchar(250)
,`quantity` int(11)
,`pid` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `product_name`, `description`) VALUES
(1, 'baby bath', 'it is useful to give bath to babies');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) UNSIGNED NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` char(40) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `address` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `fname`, `email`, `pass`, `phone`, `address`) VALUES
(1, 'bhargav', 'bhargav@gmail.com', '12345', '07660004177', 'vij'),
(2, 'jhansi', 'jhansi@gmail.com', '123456', '8767888989', 'Vijayawada-10');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,2) UNSIGNED NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Shipping_Address` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `total`, `order_date`, `Shipping_Address`) VALUES
(1, 1, '324.00', '2023-04-28 03:18:23', 'Vijayawada');

-- --------------------------------------------------------

--
-- Table structure for table `order_contents`
--

CREATE TABLE `order_contents` (
  `oc_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `pid` int(10) UNSIGNED NOT NULL,
  `quantity` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(6,2) UNSIGNED NOT NULL,
  `ship_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_contents`
--

INSERT INTO `order_contents` (`oc_id`, `order_id`, `pid`, `quantity`, `price`, `ship_date`) VALUES
(1, 1, 1, 1, '300.00', NULL);


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `pid` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `price` double NOT NULL,
  `description` varchar(250) NOT NULL,
  `image_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pid`, `cid`, `product_name`, `price`, `description`, `image_name`, `quantity`) VALUES
(1, 1, 'bath tub', 300, 'This tub is easy for parents to make bath for their babies', 'BabyBath.jpg', 10);

-- --------------------------------------------------------

--
-- Structure for view `browser_product`
--
DROP TABLE IF EXISTS `browser_product`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `browser_product`  AS SELECT `categories`.`id` AS `id`, `categories`.`product_name` AS `cname`, `products`.`product_name` AS `product_name`, `products`.`price` AS `price`, `products`.`image_name` AS `image_name`, `products`.`description` AS `description`, `products`.`quantity` AS `quantity`, `products`.`pid` AS `pid` FROM (`categories` join `products`) WHERE `categories`.`id` = `products`.`cid` ORDER BY `categories`.`product_name` ASC, `products`.`product_name` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `browser_products`
--
DROP TABLE IF EXISTS `browser_products`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `browser_products`  AS SELECT `categories`.`id` AS `id`, `categories`.`product_name` AS `cname`, `products`.`product_name` AS `product_name`, `products`.`price` AS `price`, `products`.`description` AS `description`, `products`.`quantity` AS `quantity`, `products`.`pid` AS `pid` FROM (`categories` join `products`) WHERE `categories`.`id` = `products`.`cid` ORDER BY `categories`.`product_name` ASC, `products`.`product_name` ASC  ;

--
-- Indexes for dumped tables
--

--

-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `login` (`email`,`pass`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `order_date` (`order_date`);

--
-- Indexes for table `order_contents`
--
ALTER TABLE `order_contents`
  ADD PRIMARY KEY (`oc_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `print_id` (`pid`);


--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--


-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_contents`
--
ALTER TABLE `order_contents`
  MODIFY `oc_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
