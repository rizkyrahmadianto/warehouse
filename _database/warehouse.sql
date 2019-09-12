-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2019 at 08:26 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `customer_id` int(11) NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `account_number` int(32) NOT NULL,
  `account_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` varchar(32) NOT NULL,
  `customer_email` varchar(32) NOT NULL,
  `customer_name` varchar(32) NOT NULL,
  `customer_phone` varchar(32) NOT NULL,
  `customer_address` text NOT NULL,
  `bank_name` varchar(128) NOT NULL,
  `bank_account_number` int(32) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_email`, `customer_name`, `customer_phone`, `customer_address`, `bank_name`, `bank_account_number`, `created_date`, `updated_date`) VALUES
('CUST-0427280919', 'qwewe@gamil.com', 'qweqweae', '123123123123', 'asdasdads', 'asdasdasd123', 2147483647, '2019-09-09 09:27:28', '2019-09-09 09:38:23');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `ship_amount` int(11) NOT NULL,
  `tax_amount` int(11) NOT NULL,
  `ship_date` datetime NOT NULL,
  `ship_address_id` int(11) NOT NULL,
  `card_type` varchar(16) NOT NULL,
  `card_number` int(16) NOT NULL,
  `card_expires` datetime NOT NULL,
  `billing_address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `item_price` decimal(7,2) NOT NULL,
  `discount_amount` float NOT NULL,
  `quantity` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` varchar(32) NOT NULL,
  `product_name` varchar(128) NOT NULL,
  `brand_id` varchar(32) NOT NULL,
  `category_id` varchar(32) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `brand_id`, `category_id`, `image`, `description`, `price`, `created_at`, `updated_at`) VALUES
('1', 'Deterjen Cair', 'BRD-1811120919', 'CAT-1811060919', '', 'asdasdasdasdasdasdasd', 5500, '2019-09-10 16:21:01', '0000-00-00 00:00:00'),
('2', 'dsadsadsadsa', 'BRD-1823050919', 'CAT-1823160919', 'dsadsadsa', '123qweasdzxcasd', 5500, '2019-09-10 16:24:54', '0000-00-00 00:00:00'),
('PROD-0814290919', 'zxcasdqwe', 'BRD-1823050919', 'CAT-1823160919', '', 'adasdasdqwe', 12300, '2019-09-12 06:15:33', '2019-09-12 13:15:33');

-- --------------------------------------------------------

--
-- Table structure for table `product_brands`
--

CREATE TABLE `product_brands` (
  `brand_id` varchar(32) NOT NULL,
  `brand_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_brands`
--

INSERT INTO `product_brands` (`brand_id`, `brand_name`) VALUES
('BRD-1811120919', 'Product Brand'),
('BRD-1823050919', 'Product Brandd');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `category_id` varchar(32) NOT NULL,
  `category_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `category_name`) VALUES
('CAT-1811060919', 'Product Category'),
('CAT-1823160919', 'Product Categoryy');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `supplier_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` varchar(32) NOT NULL,
  `supplier_name` varchar(128) NOT NULL,
  `supplier_phone` char(16) NOT NULL,
  `supplier_address` text NOT NULL,
  `credit_card_type` varchar(32) NOT NULL,
  `credit_card_number` int(32) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_address`, `credit_card_type`, `credit_card_number`, `created_at`, `updated_at`) VALUES
('SPL-1948070919', 'Product Category', '123123123', 'asdasdasd', 'asdasdasd', 1231231231, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `image` varchar(128) NOT NULL,
  `password` varchar(256) NOT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `image`, `password`, `role_id`, `is_active`, `created_at`) VALUES
(1, 'Admin Warehouse', 'r.rahmadianto@yahoo.com', 'default1.png', '$2y$10$ojVg/Mvr9wpLnHNd.9AxXOlpSEWuivT9dQDbnoZx5Hw9MLaCFjmWK', 1, 1, 20190323),
(3, 'Budiman', 'budiman@gmail.com', 'default.jpg', '$2y$10$kYvHiIKzCULCqUOVQgcz8.QowPLxheDav5B2VLYc.CPYkFYsqoi.m', 2, 1, 20190323);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `role_id`, `menu_id`) VALUES
(1, 1, 2),
(3, 1, 4),
(4, 2, 3),
(6, 2, 9),
(7, 1, 9),
(8, 2, 7),
(9, 1, 7),
(11, 2, 10),
(13, 1, 3),
(14, 0, 0),
(15, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`) VALUES
(2, 'Admin'),
(3, 'Master'),
(4, 'Menu'),
(7, 'Report'),
(9, 'Purchasing'),
(10, 'Selling');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `role`) VALUES
(1, 'Admin'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_status`
--

CREATE TABLE `user_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(128) NOT NULL,
  `status_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_status`
--

INSERT INTO `user_status` (`id`, `status_name`, `status_value`) VALUES
(2, 'Inactive', 0),
(3, 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(32) NOT NULL,
  `is_active` int(1) NOT NULL,
  `level` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `title`, `url`, `icon`, `is_active`, `level`) VALUES
(1, 2, 'Dashboard', 'admin', 'fas fa-tachometer-alt', 1, 'admin'),
(2, 4, 'Management Menu', 'menu', 'fas fa-minus', 1, 'menu'),
(4, 2, 'Role', 'admin/role', 'fa fa-user-secret', 1, 'admin'),
(5, 3, 'Customers', 'customer', 'fas fa-users', 1, 'customer'),
(6, 3, 'Product', 'product', 'fas fa-boxes', 1, 'product'),
(7, 3, 'Supplier', 'supplier', 'fas fa-people-carry', 1, 'supplier'),
(8, 2, 'User Controll', 'admin/usercontroll', 'fas fa-user-cog', 1, 'admin'),
(9, 9, 'Purchasing', 'purchasing', 'fas fa-shopping-basket', 1, 'purchasing'),
(10, 10, 'Selling', 'selling', 'fas fa-money-check-alt', 1, 'selling'),
(11, 9, 'Debt', 'debt', 'far fa-arrow-alt-circle-left', 1, 'debt'),
(12, 10, 'Accounts Receivable', 'accounts-receivable', 'far fa-arrow-alt-circle-right', 1, 'accounts-receivable'),
(13, 7, 'Purchase Report', 'purchase-report', 'fas fa-print', 1, 'purchase-report'),
(14, 7, 'Selling Report', 'sell-report', 'fas fa-print', 1, 'sell-report'),
(15, 7, 'Debt Report', 'debt-report', 'fas fa-print', 1, 'debt-report'),
(16, 7, 'Accounts Receivable Report', 'accounts-receivable-report', 'fas fa-print', 1, 'accounts-receivable-report'),
(17, 3, 'Product Category', 'category', 'fas fa-layer-group', 1, 'category'),
(18, 3, 'Product Brand', 'brand', 'fas fa-tags', 1, 'brand'),
(22, 4, 'Management Sub Menu', 'menu/submenu', 'fas fa-bars', 1, 'menu/submenu');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_products`
--

CREATE TABLE `_products` (
  `id` varchar(32) NOT NULL,
  `category_id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `quantity` int(10) NOT NULL,
  `price` varchar(32) NOT NULL,
  `discount_period` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_products_suppliers`
--

CREATE TABLE `_products_suppliers` (
  `product_id` varchar(32) NOT NULL,
  `supplier_id` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_product_categories`
--

CREATE TABLE `_product_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_product_details`
--

CREATE TABLE `_product_details` (
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `_product_stocks`
--

CREATE TABLE `_product_stocks` (
  `supplier_id` varchar(64) NOT NULL,
  `product_id` varchar(64) NOT NULL,
  `quantity` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_brands`
--
ALTER TABLE `product_brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_products`
--
ALTER TABLE `_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `_product_categories`
--
ALTER TABLE `_product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `_product_details`
--
ALTER TABLE `_product_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_product_categories`
--
ALTER TABLE `_product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
