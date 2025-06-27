-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2025 at 07:59 AM
-- Server version: 5.7.23-23
-- PHP Version: 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e5g2wad_freshcery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `adminname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mypassword` varchar(200) NOT NULL,
  `position` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `adminname`, `email`, `mypassword`, `position`, `status`, `created_at`) VALUES
(1, 'Panharith51', 'panharithkosal51@gmail.com', '$2y$10$XfnGO0hyAUBvGeuycV7mOewOXzw75guInAtrNF/jwahA8OdRT7waO', 'IT', 1, '2025-03-13 07:06:30'),
(2, 'Kosal Panharith', 'kosalpanharith123@gmail.com', '$2y$10$YdKWEfDNmDRf/T9HAU7A1eagKSm0hgI4rIwLO1SopcVI2AAR1sPvS', 'User', 1, '2025-03-13 08:37:41'),
(4, 'Choun Phirom', 'phirom389@gmail.com', '$2y$10$8hhgLA2fhmW.cNK9cx/XBuDdm2NtaA2t4FJUqekHJaz/jrcjoliUu', 'User', 1, '2025-03-21 11:34:22'),
(5, 'Sovanara', 'pozzliik1280@gmail.com', '$2y$10$eb2ohs6P2/jsi0Ml8iGynufDSX3iKWZAhz0qrghqbk3gHYYCfAAMS', 'IT', 1, '2025-03-28 10:17:02'),
(6, 'Chamreun Vorn', 'chamreun.vorn@gmail.com', '$2y$10$VfEQ4iNNX.pAWJEOsn7LQO.MjxgrSmPG0GpmLXR26iLBVDkt19YYS', 'User', 1, '2025-03-31 04:28:51'),
(7, 'Ravey', 'rack.cute2050@gmail.com', '$2y$10$QUWSuhAhYeMO78YRd.NcIewEawCs.z5YKe0swsviEyENV6JSk4NUu', 'User', 1, '2025-03-31 11:15:25'),
(8, 'Vatey Heng', 'teyv0996@gmail.com', '$2y$10$L6wScKYg5QkT7tMQk1S0V.9X/N.XbeJ2O0kbhwXhxSxqV4SsAw1Ee', 'User', 1, '2025-04-08 14:10:58'),
(9, 'Mut Tola', 'mut.tola@freshceryapp.com', '$2y$10$oJ5x/d4y9/1j02JnxWlcCuYzy3rjwTxAeGpuBANNjO2fqpJsOfgZ2', 'IT', 1, '2025-05-24 02:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_title` varchar(200) NOT NULL,
  `pro_image` varchar(200) NOT NULL,
  `pro_price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `pro_qty` int(11) NOT NULL,
  `pro_subtotal` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `icon` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_by` varchar(200) DEFAULT NULL,
  `update_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `icon`, `description`, `created_at`, `update_by`, `update_at`) VALUES
(1, 'Vegetables', 'vegetables.jpg', 'sb-bistro-carrot', 'Protein Rich Ingredients From Local Farmers', '2025-03-05 02:40:59', 'Panharith51', '2025-03-22 07:42:52'),
(2, 'Meat', 'meats.jpg', 'sb-bistro-roast-leg', 'Protein Rich Ingredients From Local Farmers', '2025-03-05 02:40:59', '', ''),
(3, 'Fruit', 'fruits.jpg', 'sb-bistro-apple', 'Variety of Fruits From Local Growers', '2025-03-05 04:25:25', '', ''),
(4, 'Fish', 'fish.jpg', 'sb-bistro-fish-1', 'Protein Rich Ingridients From Local Farmers', '2025-03-05 04:25:25', '', ''),
(5, 'Frozen Foods', 'frozen.jpg', 'sb-bistro-french-fries', 'Rich Protein Product From Local Farmer', '2025-03-13 10:52:52', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `lname` varchar(200) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(200) NOT NULL,
  `country` varchar(200) NOT NULL,
  `zip_code` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `order_noteds` text NOT NULL,
  `status` varchar(200) NOT NULL DEFAULT 'sent to admins',
  `is_paid` int(11) NOT NULL DEFAULT '0',
  `price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_by` varchar(200) DEFAULT NULL,
  `update_at` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `name`, `lname`, `company_name`, `address`, `city`, `country`, `zip_code`, `email`, `phone_number`, `order_noteds`, `status`, `is_paid`, `price`, `user_id`, `created_at`, `update_by`, `update_at`) VALUES
(30, 'Kosal', 'Panharith', 'Sorya Center Point', 'Faked Address', 'Phnom Penh', 'Cambodia', 123456, 'panharithkosal51@gmail.com', 77703721, 'blah blah blah', 'sent to admins', 1, 119, 1, '2025-05-24 02:24:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `careated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`cart_id`, `user_id`, `pro_id`, `pro_name`, `quantity`, `price`, `discount`, `sub_total`, `status`, `careated_at`, `order_id`) VALUES
(74, 1, 1, 'Vegetables', 1, 10, 10, 9, 1, '2025-05-24 02:17:22', 30),
(75, 1, 28, 'Steak', 3, 10, 0, 30, 1, '2025-05-24 02:17:35', 30),
(76, 1, 26, 'Seer Anjal', 6, 10, 0, 60, 1, '2025-05-24 02:17:45', 30);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(10) NOT NULL,
  `discount` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `exp_date` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_by` varchar(200) DEFAULT NULL,
  `update_at` varchar(200) DEFAULT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `description`, `price`, `discount`, `quantity`, `exp_date`, `category_id`, `status`, `created_at`, `update_by`, `update_at`, `image`) VALUES
(1, 'Vegetables', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\r\n                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\r\n                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\r\n                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\r\n                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\r\n                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 10, 99, '2025', 1, 1, '2025-03-05 06:28:43', 'Panharith51', '2025-04-11 08:25:21', 'vegetables.jpg'),
(2, 'Meat', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\n                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\n                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\n                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '20', 0, 100, '2026', 2, 1, '2025-03-05 06:28:43', '', '', 'meats.jpg'),
(3, 'Fruit', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\n                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\n                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\n                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '5', 0, 100, '2026', 3, 1, '2025-03-05 06:31:37', '', '', 'fruits.jpg'),
(4, 'Fish', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\n                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\n                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\n                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '15', 0, 100, '2026', 4, 1, '2025-03-05 06:31:37', '', '', 'fish.jpg'),
(5, 'Frozen Foods', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\n                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\n                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\n                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\n                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non\n                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '12', 0, 100, '2026', 5, 1, '2025-03-05 06:32:51', '', '', 'frozen.jpg'),
(17, 'Cheese', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '5', 0, 100, '2026', 5, 1, '2025-03-18 03:16:43', '', '', 'Cheese.jpg'),
(18, 'Chicken', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '5', 0, 100, '2026', 2, 1, '2025-03-18 12:27:52', 'Panharith51', '2025-03-28 11:13:56', 'chickens.jpg'),
(19, 'Tuna', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 20, 100, '2026', 4, 1, '2025-03-18 13:06:46', 'Panharith51', '2025-03-24 03:58:25', 'tuna.jpg'),
(20, 'Apple', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '5', 0, 100, '2025', 3, 1, '2025-03-18 13:07:49', '', '', 'apple.jpg'),
(23, 'Strawberyy', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '15', 0, 100, '2024', 3, 1, '2025-03-19 06:34:16', 'Kosal Panharith', '2025-04-08 16:35:39', 'strawberry.jpg'),
(24, 'Orange', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '3', 0, 100, '2024', 3, 1, '2025-03-19 06:36:02', '', '', 'orange.jpg'),
(25, 'Phong', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '8', 0, 100, '2025', 4, 1, '2025-03-19 06:38:29', '', '', 'Phong.jpg'),
(26, 'Seer Anjal', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 0, 94, '2026', 4, 1, '2025-03-19 06:39:08', '', '', 'Seer Anjal (Small) - Whole Cleaned.jpg'),
(27, 'Kansas City Steak', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 0, 100, '2025', 2, 1, '2025-03-19 06:41:04', '', '', 'Kansas City Steak Company.jpg'),
(28, 'Steak', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 0, 97, '2025', 2, 1, '2025-03-19 06:41:49', 'Panharith51', '2025-04-11 06:43:50', 'Steak.jpg'),
(29, 'Tomato', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '3', 0, 100, '2024', 1, 1, '2025-03-19 06:42:53', '', '', 'tomato.jpg'),
(30, 'cucumber', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '3', 0, 100, '2025', 1, 1, '2025-03-19 06:43:28', '', '', 'cucumber.jpg'),
(32, 'carrot', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '3', 0, 100, '2025', 1, 1, '2025-03-19 06:44:14', '', '', 'carrot.jpg'),
(33, 'Farm-Rich', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 0, 100, '2025', 5, 1, '2025-03-19 07:32:42', '', '', 'farm-rich.jpg'),
(34, 'Corn-dog', '                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod                             tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                             quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                             consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse                             cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non                             proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '10', 0, 100, '2025', 5, 1, '2025-03-19 07:33:54', '', '', 'corn-dog.jpg'),
(41, 'custard apple', 'this is custard apple', '2.4', 0, 100, '2025', 3, 1, '2025-03-28 10:47:30', 'Panharith51', '2025-03-31 09:09:33', 'Custard Apple.jpg'),
(44, 'Papaya', 'Blah Blah Blah', '10', 10, 100, '2024', 3, 1, '2025-04-09 08:33:48', 'Panharith51', '2025-04-09 10:40:05', 'Papaya.avif');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `mypassword` varchar(200) NOT NULL,
  `image` varchar(200) NOT NULL,
  `address` text,
  `city` varchar(200) DEFAULT NULL,
  `country` varchar(200) DEFAULT NULL,
  `zip_code` int(11) DEFAULT NULL,
  `phone_number` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `username`, `mypassword`, `image`, `address`, `city`, `country`, `zip_code`, `phone_number`, `created_at`) VALUES
(1, 'Panharith Kosal ', 'panharithkosal51@gmail.com', 'Cosmic_roar', '$2y$10$H0O3wm9y/2nvPa8zM6DfLeVu88eeiLRurwMj0ouAVmnWyFzaj/TuW', 'user.png', '', 'Phnom Penh', 'Cambodia', 123456, 77703721, '2025-03-04 16:01:37'),
(2, 'Phom Kosal', 'phomkosal85@gmail.com', 'Father', '$2y$10$PLepqOK4tRTFCFber.7d4e6hysg5gCFBcJLtnj9CYP9NGw0LRmxIK', 'user.png', 'Faked Address', 'Phnom Penh', 'Cambodia', 123456, 89267209, '2025-03-04 16:05:49'),
(3, 'MOEURN SOVANARA', 'liip28369@gmail.com', 'sovanara', '$2y$10$RBzRA.KRHa2FcdEzUXfbOOd8eUfqydDwIyRNzJ4hBAd0JUjHJwKu2', 'user.png', NULL, NULL, NULL, NULL, NULL, '2025-03-28 10:24:43'),
(4, 'Heoun Ravey', 'rack.cute2050@gmail.com', 'RaveyHeoun', '$2y$10$zq0yGGJaRvoNzdE0YlzqeeFU/9uV1CbzVX8FwN1g7BOwLVIXXzyG6', 'user.png', NULL, NULL, NULL, NULL, NULL, '2025-03-31 11:17:58'),
(5, 'Chamreun Vorn', 'chamreun.vorn@gmail.com', 'Chamreun Vorn', '$2y$10$ccqRhJhWQ02NIZ29AHIsduNTa1oSZ6HXvaXXF8wDiCOmuLsWHBDq2', 'user.png', NULL, NULL, NULL, NULL, NULL, '2025-04-22 07:53:56'),
(6, 'Vattey Heng', 'teyv0996@gmail.com', 'VatteyHeng', '$2y$10$PfC9HwOPZWHpIQpnMaKPvur9XzOCoE76VFOv2C4FyCiA2zR6X389i', 'user.png', NULL, NULL, NULL, NULL, NULL, '2025-04-22 07:54:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_product` (`pro_id`),
  ADD KEY `fk_cart_user` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_user` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD KEY `fk_orderdetail_product` (`pro_id`),
  ADD KEY `fk_orderdetail_user` (`user_id`),
  ADD KEY `fk_orderdetail_order` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_product` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_orderdetail_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `fk_orderdetail_product` FOREIGN KEY (`pro_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_orderdetail_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
