-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Aug 21, 2024 at 03:17 PM
-- Server version: 9.0.1
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DB_SELECT_WORM`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_categories`
--

CREATE TABLE `tb_categories` (
  `category_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_categories`
--

INSERT INTO `tb_categories` (`category_id`, `name`, `type`, `created_at`) VALUES
(1, 'ค่าอาหารกลางวัน', 'รายจ่าย', '2024-08-21 09:07:19'),
(2, 'รายได้จากขายดิน', 'รายรับ', '2024-08-21 09:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `log_id` int NOT NULL,
  `log_user_by` varchar(50) DEFAULT NULL,
  `log_action_type` text,
  `log_action_detail` text,
  `log_ip` text,
  `log_create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_log`
--

INSERT INTO `tb_log` (`log_id`, `log_user_by`, `log_action_type`, `log_action_detail`, `log_ip`, `log_create_at`) VALUES
(13, 'superadmin superadmin', 'เพิ่มพนักงานเข้าระบบ', 'ทดสอบwwws superadminswwwss', '::1', '2024-02-21 08:29:16'),
(14, 'superadmin superadmin', 'แก้ไขข้อมูลพนักงาน', 'ทดสอบ ทดสอบ', '::1', '2024-02-21 08:31:03'),
(15, 'superadmin superadmin', 'ลบพนักงาน', 'ออกจากระบบ', '::1', '2024-02-21 08:32:10'),
(16, 'superadmin superadmin', 'ลบพนักงาน', 'sadfasdfasdf อินเทียน1ออกจากระบบ', '::1', '2024-02-21 08:32:50'),
(17, 'superadmin superadmin', 'เพิ่ม', 'น้ำหมักเข้าระบบ', '::1', '2024-02-21 08:36:43'),
(18, 'superadmin superadmin', 'แก้ไขสินค้า ', 'น้ำหมักป้าเฉ้ง', '::1', '2024-02-21 08:38:16'),
(19, 'superadmin superadmin', 'ลบสินค้า ', 'น้ำหมักป้าเฉ้ง ออกจากระบบ', '::1', '2024-02-21 08:42:15'),
(20, 'superadmin superadmin', 'ลบจำนวนสินค้า ', 'น้ำส้มควันไม้ ออกจากคลัง', '::1', '2024-02-21 08:51:37'),
(21, 'superadmin superadmin', 'ลบสินค้า ', 'ปู๋ยคลอก จำนวน 5 ออกจากคลัง', '::1', '2024-02-21 08:54:00'),
(22, 'superadmin superadmin', 'เพิ่มสินค้า ', 'น้ำหมักป้าเฉ้ง เข้าระบบ', '::1', '2024-02-21 08:54:34'),
(23, 'superadmin superadmin', 'เติมสินค้า ', 'น้ำหมักป้าเฉ้งจำนวน 3 เข้าคลัง', '::1', '2024-02-21 08:54:55'),
(24, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'น้ำหมักป้าเฉ้ง ในคลัง', '::1', '2024-02-21 08:55:25'),
(25, '', 'เพิ่มการผลิตในโซน ', '2 สถานะกำลังผลิต', '::1', '2024-02-21 09:06:07'),
(26, '', 'เพิ่มการผลิตในโซน ', '4 สถานะกำลังผลิต', '::1', '2024-02-21 09:06:34'),
(27, 'superadmin superadmin', 'ลบการผลิตในโซน ', '2 สถานะว่าง', '::1', '2024-02-21 09:11:44'),
(28, 'superadmin superadmin', 'เพิ่มการผลิตในโซน ', '3 สถานะกำลังผลิต', '::1', '2024-02-21 09:17:34'),
(29, 'superadmin superadmin', 'เปลี่ยนสถานะการผลิตในโซน ', '3 สถานะว่าง', '::1', '2024-02-21 09:18:16'),
(30, 'superadmin superadmin', 'แก้ไขข้อมูลการผลิตในโซน ', '5 สถานะกำลังผลิต', '::1', '2024-02-21 09:51:41'),
(31, '', 'ลบยอดขายจำนวนเงิน ', '275 บาท', '::1', '2024-02-21 15:16:21'),
(32, '', 'เพิ่มยอดขายจำนวนเงิน ', '356 บาท', '::1', '2024-02-21 15:17:50'),
(33, '', 'เพิ่มยอดขายจำนวนเงิน ', '55 บาท', '::1', '2024-02-21 15:20:11'),
(34, '', 'เพิ่มยอดขายจำนวนเงิน ', '110 บาท', '::1', '2024-02-21 15:21:00'),
(35, '', 'แก้ไขข้อมูลสินค้า ', 'น้ำหมักป้าเฉ้ง ในคลัง', '::1', '2024-02-21 15:23:19'),
(36, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 15:23:29'),
(37, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'น้ำหมักป้าเฉ้ง ในคลัง', '::1', '2024-02-21 15:23:37'),
(38, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '110 บาท', '::1', '2024-02-21 15:23:54'),
(39, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '::1', '2024-02-21 15:24:08'),
(40, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '356 บาท', '::1', '2024-02-21 15:24:36'),
(41, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 15:26:06'),
(42, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 15:26:06'),
(43, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 18:17:57'),
(44, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 18:17:58'),
(45, 'ทด ๅ', 'เข้าสู่ระบบ', 'ทด ๅ', '::1', '2024-02-21 18:18:32'),
(46, 'ทด ๅ', 'เข้าสู่ระบบ', 'ทด ๅ', '::1', '2024-02-21 18:18:33'),
(47, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 18:24:58'),
(48, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-21 18:24:59'),
(49, 'ทนงศักดิ์ อินเทียน', 'เข้าสู่ระบบ', 'ทนงศักดิ์ อินเทียน', '::1', '2024-02-22 03:12:58'),
(50, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '::1', '2024-02-22 03:14:20'),
(51, 'ทนงศักดิ์ อินเทียน', 'เข้าสู่ระบบ', 'ทนงศักดิ์ อินเทียน', '::1', '2024-02-22 03:14:46'),
(52, 'ทนงศักดิ์ อินเทียน', 'เปลี่ยนสถานะการผลิตในโซน ', '3 สถานะว่าง', '::1', '2024-02-22 03:15:09'),
(53, 'ทนงศักดิ์ อินเทียน', 'เปลี่ยนสถานะการผลิตในโซน ', '3 สถานะว่าง', '::1', '2024-02-22 03:15:13'),
(54, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '192.168.65.1', '2024-08-21 08:35:47'),
(55, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '192.168.65.1', '2024-08-21 08:36:23'),
(56, 'superadmin superadmin', 'เพิ่มขนส่ง', 'asdfเข้าระบบ', '192.168.65.1', '2024-08-21 08:55:54'),
(57, 'superadmin superadmin', 'แก้ไขข้อมูลขนส่ง', 'asdfaa', '192.168.65.1', '2024-08-21 08:56:04'),
(58, 'superadmin superadmin', 'แก้ไขข้อมูลขนส่ง', 'kerry express', '192.168.65.1', '2024-08-21 08:56:46'),
(59, 'superadmin superadmin', 'เพิ่มรายรับรายจ่าย', 'ค่าอาหารกลางวัน -> รายจ่าย 100เข้าระบบ', '192.168.65.1', '2024-08-21 09:08:51'),
(60, 'superadmin superadmin', 'เพิ่มรายรับรายจ่าย', 'รายได้จากขายดิน -> รายรับ 200เข้าระบบ', '192.168.65.1', '2024-08-21 09:09:14'),
(61, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'น้ำหมักป้าเฉ้ง', '192.168.65.1', '2024-08-21 14:13:07'),
(62, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'น้ำหมักป้าเฉ้ง', '192.168.65.1', '2024-08-21 14:16:08'),
(63, 'superadmin superadmin', 'เพิ่มสินค้า ', 'ปู๋ยขี้ไก่ เข้าระบบ', '192.168.65.1', '2024-08-21 14:17:11'),
(64, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'ปู๋ยขี้ไก่', '192.168.65.1', '2024-08-21 14:17:25'),
(65, 'superadmin superadmin', 'เติมสินค้า ', 'ปู๋ยขี้ไก่ จำนวน 20 เข้าคลัง', '192.168.65.1', '2024-08-21 14:17:50'),
(66, 'superadmin superadmin', 'แก้ไขข้อมูลสินค้า ', 'ปู๋ยขี้ไก่', '192.168.65.1', '2024-08-21 14:18:02'),
(67, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '1156 บาท', '192.168.65.1', '2024-08-21 14:19:28'),
(68, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '576 บาท', '192.168.65.1', '2024-08-21 14:20:53'),
(69, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '410 บาท', '192.168.65.1', '2024-08-21 14:29:02'),
(70, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '55 บาท', '192.168.65.1', '2024-08-21 14:30:24'),
(71, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '55 บาท', '192.168.65.1', '2024-08-21 14:32:14'),
(72, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '55 บาท', '192.168.65.1', '2024-08-21 14:33:32'),
(73, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '200 บาท', '192.168.65.1', '2024-08-21 14:37:12'),
(74, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '200 บาท', '192.168.65.1', '2024-08-21 14:37:54'),
(75, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '555 บาท', '192.168.65.1', '2024-08-21 14:55:28'),
(76, 'superadmin superadmin', 'เข้าสู่ระบบ', 'superadmin superadmin', '192.168.65.1', '2024-08-21 15:04:37'),
(77, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '100 บาท', '192.168.65.1', '2024-08-21 15:05:08'),
(78, 'superadmin superadmin', 'เติมสินค้า ', 'ปู๋ยขี้ไก่ จำนวน 12 เข้าคลัง', '192.168.65.1', '2024-08-21 15:06:36'),
(79, 'superadmin superadmin', 'เติมสินค้า ', 'น้ำหมักป้าเฉ้ง จำนวน 20 เข้าคลัง', '192.168.65.1', '2024-08-21 15:06:54'),
(80, 'superadmin superadmin', 'เติมสินค้า ', 'ปู๋ยคลอก จำนวน 12 เข้าคลัง', '192.168.65.1', '2024-08-21 15:07:12'),
(81, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '1075 บาท', '192.168.65.1', '2024-08-21 15:07:31'),
(82, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '1330 บาท', '192.168.65.1', '2024-08-21 15:12:23'),
(83, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '192.168.65.1', '2024-08-21 15:12:59'),
(84, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '192.168.65.1', '2024-08-21 15:13:10'),
(85, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '192.168.65.1', '2024-08-21 15:13:14'),
(86, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '192.168.65.1', '2024-08-21 15:13:18'),
(87, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '576 บาท', '192.168.65.1', '2024-08-21 15:13:23'),
(88, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '110 บาท', '192.168.65.1', '2024-08-21 15:13:28'),
(89, 'superadmin superadmin', 'ลบยอดขายจำนวนเงิน ', '55 บาท', '192.168.65.1', '2024-08-21 15:13:31'),
(90, 'superadmin superadmin', 'เพิ่มยอดขายจำนวนเงิน ', '378 บาท', '192.168.65.1', '2024-08-21 15:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `tb_order`
--

CREATE TABLE `tb_order` (
  `order_id` int NOT NULL,
  `payment_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `order_amount` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_order`
--

INSERT INTO `tb_order` (`order_id`, `payment_id`, `product_id`, `order_amount`) VALUES
(11, 9, 7, 2),
(12, 9, 10, 4),
(13, 10, 7, 2),
(14, 10, 10, 5),
(15, 11, 7, 2),
(16, 11, 10, 6),
(17, 12, 10, 5),
(18, 13, 7, 2),
(19, 13, 10, 2),
(20, 14, 10, 1),
(21, 15, 10, 2),
(22, 16, 10, 2),
(23, 0, 7, 2),
(24, 0, 10, 2),
(25, 0, 12, 1),
(26, 0, 13, 7),
(27, 0, 10, 2),
(28, 0, 12, 2),
(29, 0, 13, 1),
(30, 0, 10, 1),
(31, 0, 10, 1),
(32, 0, 10, 1),
(33, 0, 13, 2),
(34, 0, 13, 2),
(35, 0, 10, 1),
(36, 0, 13, 5),
(37, 22, 13, 1),
(38, 23, 10, 5),
(39, 23, 12, 4),
(40, 23, 13, 4),
(41, 24, 10, 6),
(42, 24, 12, 5),
(43, 24, 13, 5),
(44, 25, 7, 1),
(45, 25, 10, 1),
(46, 25, 12, 1),
(47, 25, 13, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `payment_id` int NOT NULL,
  `user_id` varchar(11) NOT NULL,
  `payment_total` varchar(255) DEFAULT NULL,
  `transport_number` varchar(255) NOT NULL,
  `tp_id` int NOT NULL,
  `payment_create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_payment`
--

INSERT INTO `tb_payment` (`payment_id`, `user_id`, `payment_total`, `transport_number`, `tp_id`, `payment_create_at`) VALUES
(22, '1', '100', '', 1, '2024-08-21 15:05:08'),
(23, '1', '1075', '', 1, '2024-08-21 15:07:31'),
(24, '1', '1330', 'add345g', 1, '2024-08-21 15:12:37'),
(25, '1', '378', '', 0, '2024-08-21 15:13:47');

-- --------------------------------------------------------

--
-- Table structure for table `tb_products`
--

CREATE TABLE `tb_products` (
  `product_id` int NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_amount` int DEFAULT NULL,
  `product_price` int DEFAULT NULL,
  `product_size` int DEFAULT NULL,
  `unit_id` text,
  `category_id` text,
  `product_status` int DEFAULT NULL,
  `product_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_products`
--

INSERT INTO `tb_products` (`product_id`, `product_code`, `product_name`, `product_amount`, `product_price`, `product_size`, `unit_id`, `category_id`, `product_status`, `product_type`) VALUES
(7, '65cf1db58ec42', 'น้ำส้มควันไม้', 1, 123, 1, 'ถัง', 'ปุ๋ยหมักชีวะภาพ', 1, 'ขายปลีก'),
(10, '65d0b205e4486', 'ปู๋ยคลอก', 16, 55, 1, 'kg', 'ปุ๋ยหมักชีวะภาพ', 1, 'ขายส่ง'),
(12, '65d5ba4a46a00', 'น้ำหมักป้าเฉ้ง', 13, 100, 1, 'kg', 'ปุ๋ยหมักชีวะภาพ', 1, 'ขายส่ง'),
(13, '66c5f6e7c63a5', 'ปู๋ยขี้ไก่', 22, 100, 2, 'kg', 'ปู๋ยหมักชีวภาพ', 1, 'ขายปลีก');

-- --------------------------------------------------------

--
-- Table structure for table `tb_product_log`
--

CREATE TABLE `tb_product_log` (
  `pl_id` int NOT NULL,
  `pl_amount` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `pl_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_product_log`
--

INSERT INTO `tb_product_log` (`pl_id`, `pl_amount`, `product_id`, `pl_created_at`) VALUES
(18, 2, 10, '2024-02-17 14:14:00'),
(19, 3, 10, '2024-02-05 14:16:00'),
(20, 2, 10, '2024-02-19 16:37:00'),
(21, 2, 7, '2024-02-19 10:30:00'),
(24, 3, 12, '2024-02-21 08:54:00'),
(25, 20, 13, '2024-08-21 11:11:00'),
(26, 12, 13, '2024-08-21 11:11:00'),
(27, 20, 12, '2024-08-21 22:22:00'),
(28, 12, 10, '2024-08-22 03:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock`
--

CREATE TABLE `tb_stock` (
  `stock_id` int NOT NULL,
  `stock_name` varchar(255) DEFAULT NULL,
  `stock_start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stock_end` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `stock_status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_stock`
--

INSERT INTO `tb_stock` (`stock_id`, `stock_name`, `stock_start`, `stock_end`, `stock_status`) VALUES
(1, '2', '2024-02-22 02:30:29', '2024-02-17 17:00:00', 2),
(2, '1', '2024-02-18 03:58:00', '2024-02-21 03:58:00', 0),
(5, '12', '2024-02-21 05:13:04', '2024-02-24 16:38:00', 0),
(7, '1', '2024-02-22 02:38:26', '2024-02-23 09:06:00', 2),
(8, '3', '2024-02-22 03:15:09', '2024-02-23 09:17:00', 0),
(9, '3', '2024-02-22 03:15:13', '2024-02-23 09:17:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transactions`
--

CREATE TABLE `tb_transactions` (
  `transaction_id` int NOT NULL,
  `category_id` int NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `transaction_date` timestamp NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_transactions`
--

INSERT INTO `tb_transactions` (`transaction_id`, `category_id`, `amount`, `description`, `transaction_date`, `created_at`) VALUES
(1, 1, 100, 'ทดสอบ', '2024-08-21 22:22:00', '2024-08-21 09:08:51'),
(2, 2, 200, 'ทดสอบ', '2024-08-22 11:11:00', '2024-08-21 09:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transport`
--

CREATE TABLE `tb_transport` (
  `tp_id` int NOT NULL,
  `tp_name` text NOT NULL,
  `tp_status` int NOT NULL,
  `tp_created` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_transport`
--

INSERT INTO `tb_transport` (`tp_id`, `tp_name`, `tp_status`, `tp_created`) VALUES
(0, 'รับหน้าร้าน', 1, '2024-08-21 08:55:54'),
(1, 'kerry express', 1, '2024-08-21 08:55:54');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int NOT NULL,
  `user_role` int DEFAULT NULL,
  `user_username` varchar(255) DEFAULT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `user_fname` varchar(255) DEFAULT NULL,
  `user_lname` varchar(255) DEFAULT NULL,
  `user_created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `user_last_login` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `user_status` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_role`, `user_username`, `user_password`, `user_fname`, `user_lname`, `user_created_at`, `user_updated_at`, `user_last_login`, `user_status`) VALUES
(1, 2, 'superadmin', '1', 'superadmin', 'superadmin', '2024-08-21 15:04:37', '0000-00-00 00:00:00', '2024-08-21 15:04:37', 1),
(8, 1, 'admin', '1', 'ทด', 'ๅ', '2024-02-21 18:18:33', '0000-00-00 00:00:00', '2024-02-21 18:18:33', 1),
(9, 1, '1superadmin', '1', 'ทนงศักดิ์', 'อินเทียน', '2024-02-22 03:14:46', '0000-00-00 00:00:00', '2024-02-22 03:14:46', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_categories`
--
ALTER TABLE `tb_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tb_order`
--
ALTER TABLE `tb_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tb_products`
--
ALTER TABLE `tb_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `tb_product_log`
--
ALTER TABLE `tb_product_log`
  ADD PRIMARY KEY (`pl_id`);

--
-- Indexes for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `tb_transport`
--
ALTER TABLE `tb_transport`
  ADD PRIMARY KEY (`tp_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_categories`
--
ALTER TABLE `tb_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tb_order`
--
ALTER TABLE `tb_order`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
  MODIFY `payment_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_products`
--
ALTER TABLE `tb_products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_product_log`
--
ALTER TABLE `tb_product_log`
  MODIFY `pl_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `stock_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_transactions`
--
ALTER TABLE `tb_transactions`
  MODIFY `transaction_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_transport`
--
ALTER TABLE `tb_transport`
  MODIFY `tp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
