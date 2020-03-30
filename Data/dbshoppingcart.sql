-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2020 at 03:08 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbshoppingcart`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `user` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `date`, `user`) VALUES
(56, '2020-01-02', 'havietphuong'),
(55, '2020-01-01', 'vn02782878'),
(54, '2020-01-01', 'vn02782878'),
(53, '2020-01-01', 'vn02782878'),
(50, '2020-01-01', 'vn02782878'),
(51, '2020-01-01', 'vn02782878'),
(52, '2020-01-01', 'vn02782878');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `orderid` int(11) NOT NULL,
  `productname` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`orderid`, `productname`, `quantity`, `price`) VALUES
(0, 'Hydrating body lotion with green tea', 1, 16),
(0, 'Enriching body lotion', 2, 40),
(0, 'Hydrating body lotion with green tea', 6, 96),
(0, 'Moisturizing body oil', 1, 21),
(0, 'Hydrating body lotion with green tea', 6, 96),
(0, 'Moisturizing body oil', 2, 42),
(0, 'My Lip And Cheek (Airy) 3.8g', 1, 8.2),
(0, 'Bija Cica S.O.S. Kit 1 box', 1, 22.88),
(0, 'Moisturizing body oil', 3, 63),
(54, 'My Lip And Cheek (Airy) 3.8g', 1, 8.2),
(54, 'Bija Cica S.O.S. Kit 1 box', 1, 22.88),
(54, 'Moisturizing body oil', 6, 126),
(55, 'Moisturizing body oil', 1, 21),
(56, 'Enriching body lotion', 1, 20),
(56, 'My Lip And Cheek (Airy) 3.8g', 1, 8.2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `image`, `price`) VALUES
(1, 'Green Tea Mist 50ml', 'skin_moisturizing', '27877_l.png', 6.02),
(2, 'No sebum lotion 100ml', 'skin_moisturizing', '23692_l.png', 8.64),
(3, 'Bija Cica S.O.S. Kit 1 box', 'skin_moisturizing', '29733_l.png', 22.88),
(4, 'My Lip And Cheek (Airy) 3.8g', 'makeup_lips', '27739_l.png', 8.20),
(5, 'Mineral Stick Concealer 2g', 'makeup_lips', '30378_l.png', 9.07),
(6, 'My Concealer Dark Circle Cover 7g', 'makeup_lips', '30975_l.png', 11.23),
(7, 'Hydrating body lotion with green tea', 'body_lotion', '231170088.jpg', 16.00),
(8, 'Enriching body lotion', 'body_lotion', '270670204.jpg', 20.00),
(9, 'Moisturizing body oil', 'body_lotion', '270670199.jpg', 21.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `phone`, `address`, `user_type`, `password`) VALUES
(1, 'havietphuong', 'havietphuog95@gmail.com', 794891986, 'Cao Thang Q10', 'admin', '2c5131fe8a17f70957fec233e8ba7306'),
(2, 'test', 'test@gmail.com', 123456789, 'qwewqdsa3d5sa6d', 'user', '202cb962ac59075b964b07152d234b70'),
(4, 'vn02782878', 'vn02782878@gmail.com', 794891986, '392/8/114 Cao Thang street, ward 12, district 10', 'user', '202cb962ac59075b964b07152d234b70'),
(5, '123', 'vn02782878@gmail.com', 794891986, '392/8/114 Cao Thang street, ward 12, district 10', 'user', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
