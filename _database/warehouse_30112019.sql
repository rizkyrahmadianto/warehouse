-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2019 at 05:05 AM
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
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(32) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `address` text NOT NULL,
  `service_charge_value` int(11) NOT NULL,
  `vat_charge_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `phone`, `address`, `service_charge_value`, `vat_charge_value`) VALUES
(1, 'Warehouse.co', '08123456789', 'Jl. Sesama 001/007', 20, 10);

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
  `brand_id` varchar(32) DEFAULT NULL,
  `category_id` varchar(32) DEFAULT NULL,
  `supplier_id` varchar(32) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `qty` varchar(16) NOT NULL,
  `availability` int(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `brand_id`, `category_id`, `supplier_id`, `image`, `description`, `price`, `qty`, `availability`, `created_at`, `updated_at`) VALUES
('PROD-0754100919', 'Sikat Gigi', 'BRD-1710291019', 'CAT-1709021019', 'SPL-1948070919', 'product_1573882836.png', 'Sikat gigi untuk dewasa', 11500, '200', 1, '2019-10-27 15:29:48', '2019-11-16 12:40:46'),
('PROD-0952071019', 'Minyak Wangi', 'BRD-1823050919', 'CAT-1811060919', 'SPL-1948070919', 'product_1571471527.png', 'Ini product berbau wangi', 12500, '300', 1, '2019-10-27 15:29:51', '0000-00-00 00:00:00'),
('PROD-1530291019', 'Sabun Mandi', 'BRD-1811120919', 'CAT-1823160919', 'SPL-1948070919', 'product_1571491829.jpg', 'Ini sabun mandi', 5500, '100', 1, '2019-10-27 15:29:54', '0000-00-00 00:00:00');

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
('BRD-1710291019', 'Maspion'),
('BRD-1710481019', 'Mayora'),
('BRD-1811120919', 'Indofood'),
('BRD-1823050919', 'Danone-AQUA');

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
('CAT-1709021019', 'Perabotan'),
('CAT-1709141019', 'Elektronik'),
('CAT-1811060919', 'Makanan'),
('CAT-1823160919', 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `supplier_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`supplier_id`, `product_id`, `quantity`) VALUES
('SPL-1948070919', 'PROD-0754100919', 25);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_debts`
--

CREATE TABLE `purchase_debts` (
  `purchase_debt_id` varchar(32) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `debt_paid_history` datetime NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `remaining_paid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` varchar(32) NOT NULL,
  `supplier_id` varchar(32) NOT NULL,
  `order_date` date DEFAULT current_timestamp(),
  `gross_amount` int(16) NOT NULL,
  `ship_amount` int(16) DEFAULT NULL,
  `tax_amount` int(16) DEFAULT NULL,
  `discount` int(16) DEFAULT NULL,
  `net_amount` int(16) DEFAULT NULL,
  `paid_status` int(11) NOT NULL,
  `user_create` varchar(32) NOT NULL,
  `user_update` varchar(32) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_orders`
--

INSERT INTO `purchase_orders` (`id`, `supplier_id`, `order_date`, `gross_amount`, `ship_amount`, `tax_amount`, `discount`, `net_amount`, `paid_status`, `user_create`, `user_update`, `updated_at`) VALUES
('BUY-0333341119', 'SPL-1712201019', '2019-11-08', 512500, 0, 0, 5, 486875, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 22:40:42'),
('BUY-0410531119', 'SPL-1711351019', '2019-10-03', 477500, 8000, 10, 0, 534050, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 17:54:43'),
('BUY-0509231119', 'SPL-1712201019', '2019-11-25', 11500, 0, 0, 0, 11500, 2, 'admin@admin.com', '', '0000-00-00 00:00:00'),
('BUY-0549341119', 'SPL-1712201019', '2019-11-16', 500000, 0, 0, 0, 500000, 2, 'admin@admin.com', '', '0000-00-00 00:00:00'),
('BUY-0607161119', 'SPL-1712201019', '2019-11-08', 312500, 0, 0, 0, 312500, 2, 'admin@admin.com', '', '0000-00-00 00:00:00'),
('BUY-1139311119', 'SPL-1712201019', '2019-11-11', 14000, 0, 0, 0, 14000, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 22:35:43'),
('BUY-1201091119', 'SPL-1711351019', '2019-11-18', 470500, 0, 0, 0, 470500, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-25 10:53:16'),
('BUY-1206021119', 'SPL-1711351019', '2019-10-01', 4815500, 20000, 10, 15, 4521193, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 22:41:20'),
('BUY-1825091119', 'SPL-1712201019', '2019-11-11', 14000, 0, 0, 0, 14000, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 22:35:52'),
('BUY-1835511119', 'SPL-1712201019', '2019-11-18', 14000, 0, 0, 0, 14000, 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 17:41:47'),
('BUY-1838171119', 'SPL-1712201019', '2019-11-01', 500000, 0, 0, 0, 500000, 2, 'admin@admin.com', '', '0000-00-00 00:00:00'),
('BUY-1841061119', 'SPL-1712201019', '2019-11-08', 485000, 0, 0, 5, 460750, 2, 'admin@admin.com', '', '0000-00-00 00:00:00'),
('BUY-1844071119', 'SPL-1948070919', '2019-11-08', 485000, 0, 0, 5, 460750, 2, 'admin@admin.com', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_details`
--

CREATE TABLE `purchase_order_details` (
  `order_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `unit_price` int(16) NOT NULL,
  `qty` int(16) NOT NULL,
  `amount` int(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase_order_details`
--

INSERT INTO `purchase_order_details` (`order_id`, `product_id`, `unit_price`, `qty`, `amount`) VALUES
('BUY-0549341119', 'PROD-0952071019', 20000, 25, 500000),
('BUY-0607161119', 'PROD-0952071019', 12500, 25, 312500),
('BUY-1841061119', 'PROD-0952071019', 12500, 25, 312500),
('BUY-1841061119', 'PROD-0754100919', 11500, 15, 172500),
('BUY-1844071119', 'PROD-0952071019', 12500, 25, 312500),
('BUY-1844071119', 'PROD-0754100919', 11500, 15, 172500),
('BUY-1838171119', 'PROD-0952071019', 20000, 25, 500000),
('BUY-1835511119', 'PROD-0952071019', 14000, 1, 14000),
('BUY-0410531119', 'PROD-0754100919', 11500, 15, 172500),
('BUY-0410531119', 'PROD-0952071019', 12500, 20, 250000),
('BUY-0410531119', 'PROD-1530291019', 5500, 10, 55000),
('BUY-1139311119', 'PROD-0952071019', 14000, 1, 14000),
('BUY-1825091119', 'PROD-0952071019', 14000, 1, 14000),
('BUY-0333341119', 'PROD-0952071019', 12500, 25, 312500),
('BUY-0333341119', 'PROD-0754100919', 11500, 15, 172500),
('BUY-0333341119', 'PROD-1530291019', 5500, 5, 27500),
('BUY-1206021119', 'PROD-0754100919', 11500, 154, 1771000),
('BUY-1206021119', 'PROD-0952071019', 12500, 200, 2500000),
('BUY-1206021119', 'PROD-1530291019', 5500, 99, 544500),
('BUY-1201091119', 'PROD-0952071019', 12500, 35, 437500),
('BUY-1201091119', 'PROD-1530291019', 5500, 6, 33000),
('BUY-0509231119', 'PROD-0754100919', 11500, 1, 11500);

-- --------------------------------------------------------

--
-- Table structure for table `sales_account_receivables`
--

CREATE TABLE `sales_account_receivables` (
  `sales_ar_id` varchar(32) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `ar_paid_history` datetime NOT NULL,
  `amount_paid` int(32) NOT NULL,
  `remaining_paid` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sales_orders`
--

CREATE TABLE `sales_orders` (
  `id` varchar(32) NOT NULL,
  `customer_name` varchar(32) NOT NULL,
  `customer_phone` varchar(12) NOT NULL,
  `customer_address` text NOT NULL,
  `order_date` date NOT NULL,
  `gross_amount` varchar(32) NOT NULL,
  `service_charge_rate` varchar(32) NOT NULL,
  `service_charge` varchar(32) NOT NULL,
  `vat_charge_rate` varchar(32) NOT NULL,
  `vat_charge` varchar(32) NOT NULL,
  `net_amount` varchar(32) NOT NULL,
  `discount` varchar(32) NOT NULL,
  `paid_status` int(11) NOT NULL,
  `user_create` varchar(32) NOT NULL,
  `user_update` varchar(32) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_orders`
--

INSERT INTO `sales_orders` (`id`, `customer_name`, `customer_phone`, `customer_address`, `order_date`, `gross_amount`, `service_charge_rate`, `service_charge`, `vat_charge_rate`, `vat_charge`, `net_amount`, `discount`, `paid_status`, `user_create`, `user_update`, `updated_at`) VALUES
('SELL-0604361019', 'Bambang Waluyo', '076123978345', 'Jalan Dagu Raya no.07', '2019-11-25', '171500', '20', '34300', '10', '17150', '222950', '', 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 21:22:34'),
('SELL-0618551119', 'Rudy Cahyono', '082543715913', 'Jalan kesana kemari hey no 12', '2019-11-17', '90000', '20', '18000', '10', '9000', '117000', '', 2, 'admin@admin.com', 'admin@admin.com', '2019-11-27 12:29:36'),
('SELL-1223301019', 'Mawar Merah', '81234567', 'Jalan Sesama B no.21 ', '2019-11-25', '46600', '20', '9320', '10', '4660', '60560', '20', 2, 'admin@admin.com', 'admin@admin.com', '2019-11-18 21:08:27'),
('SELL-1320221019', 'Sutrisno', '296785234', 'Jalan Cielunyi no.21a', '2019-11-25', '136000', '20', '27200', '10', '13600', '176800', '', 2, 'admin@admin.com', '', '2019-10-25 20:33:56'),
('SELL-1812051019', 'Joko Wie', '21678234', 'Jalan Baru no.12', '2019-11-25', '197500', '20', '39500', '10', '19750', '256750', '', 2, 'admin@admin.com', 'budiman@gmail.com', '2019-11-25 09:13:04'),
('SELL-1902221019', 'qweqweqwe', '123123123', 'asdasd123123asdasd', '2019-11-25', '14000', '20', '2800', '10', '1400', '18200', '', 2, 'admin@admin.com', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_order_details`
--

CREATE TABLE `sales_order_details` (
  `so_detail_id` int(11) NOT NULL,
  `order_id` varchar(32) NOT NULL,
  `product_id` varchar(32) NOT NULL,
  `qty` int(32) NOT NULL,
  `unit_price` int(32) NOT NULL,
  `amount` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_order_details`
--

INSERT INTO `sales_order_details` (`so_detail_id`, `order_id`, `product_id`, `qty`, `unit_price`, `amount`) VALUES
(1, 'SELL-1902221019', 'PROD-0952071019', 1, 14000, 14000),
(12, 'SELL-1320221019', 'PROD-0952071019', 5, 14000, 70000),
(13, 'SELL-1320221019', 'PROD-1530291019', 12, 5500, 66000),
(18, 'SELL-1223301019', 'PROD-1530291019', 2, 5500, 11000),
(19, 'SELL-1223301019', 'PROD-0754100919', 1, 7200, 7200),
(20, 'SELL-0604361019', 'PROD-0754100919', 20, 7200, 144000),
(21, 'SELL-0604361019', 'PROD-1530291019', 5, 5500, 27500),
(22, 'SELL-1812051019', 'PROD-0952071019', 10, 14000, 140000),
(23, 'SELL-1812051019', 'PROD-0754100919', 5, 11500, 57500),
(26, 'SELL-0618551119', 'PROD-0754100919', 4, 11500, 46000),
(27, 'SELL-0618551119', 'PROD-1530291019', 8, 5500, 44000);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_address`, `credit_card_type`, `credit_card_number`, `created_at`, `updated_at`) VALUES
('SPL-1711351019', 'PT. Supplier 1', '081423645789', 'Jalan Nusantara B no.66a', 'BCA', 2147483647, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('SPL-1712201019', 'PT Supplier 2', '024123987345', 'Jalan Doa Ibu II no.7', 'Mandiri', 2147483647, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('SPL-1948070919', 'PT. Supplier 3', '123123123', 'asdasdasd', 'asdasdasd', 1231231231, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
(1, 'Admin Warehouse', 'admin@admin.com', 'default1.png', '$2y$10$ojVg/Mvr9wpLnHNd.9AxXOlpSEWuivT9dQDbnoZx5Hw9MLaCFjmWK', 1, 1, 20190323),
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
(5, 3, 'Customers', 'customer', 'fas fa-users', 0, 'customer'),
(6, 3, 'Product', 'product', 'fas fa-boxes', 1, 'product'),
(7, 3, 'Supplier', 'supplier', 'fas fa-people-carry', 1, 'supplier'),
(8, 2, 'User Controll', 'admin/usercontroll', 'fas fa-user-cog', 1, 'admin'),
(9, 9, 'Purchase', 'purchase', 'fas fa-shopping-basket', 1, 'purchase'),
(10, 10, 'Selling', 'sales', 'fas fa-money-check-alt', 1, 'sales'),
(11, 9, 'Debt', 'debt', 'far fa-arrow-alt-circle-left', 1, 'debt'),
(12, 10, 'Accounts Receivable', 'accounts-receivable', 'far fa-arrow-alt-circle-right', 1, 'accounts-receivable'),
(13, 7, 'Purchase Report', 'purchase_report', 'fas fa-print', 1, 'purchase_report'),
(14, 7, 'Sales Report', 'sales_report', 'fas fa-print', 1, 'sales_report'),
(15, 7, 'Debt Report', 'debt-report', 'fas fa-print', 1, 'debt-report'),
(16, 7, 'Accounts Receivable Report', 'accounts-receivable-report', 'fas fa-print', 1, 'accounts-receivable-report'),
(17, 3, 'Product Category', 'category', 'fas fa-layer-group', 1, 'category'),
(18, 3, 'Product Brand', 'brand', 'fas fa-tags', 1, 'brand'),
(22, 4, 'Management Sub Menu', 'menu/submenu', 'fas fa-bars', 1, 'menu/submenu'),
(23, 3, 'Stock', 'stock', 'fas fa-truck-loading', 0, 'stock'),
(24, 2, 'Manage Company', 'company', 'far fa-building', 1, 'company');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `purchase_debts`
--
ALTER TABLE `purchase_debts`
  ADD PRIMARY KEY (`purchase_debt_id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_account_receivables`
--
ALTER TABLE `sales_account_receivables`
  ADD PRIMARY KEY (`sales_ar_id`);

--
-- Indexes for table `sales_orders`
--
ALTER TABLE `sales_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  ADD PRIMARY KEY (`so_detail_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `sales_order_details`
--
ALTER TABLE `sales_order_details`
  MODIFY `so_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
