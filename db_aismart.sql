-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 10, 2023 at 08:29 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_aismart`
--

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `name`) VALUES
(1, 'banner_waterpark.jpg'),
(2, 'banner_taman_kota.jpg'),
(3, 'banner_kampung_bekelir.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `name`, `created_at`) VALUES
(1, 'Tourist Places', '2022-12-26 14:02:18'),
(2, 'Couliner Places', '2022-12-26 14:02:30'),
(3, 'Educational Places', '2022-12-26 14:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `image_product`
--

CREATE TABLE `image_product` (
  `id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_product`
--

INSERT INTO `image_product` (`id`, `product_id`, `image`) VALUES
(1, 1, 'scientia_square_park_1.jpg'),
(2, 1, 'scientia_square_park_2.jpg'),
(3, 1, 'scientia_square_park_3.jpg'),
(4, 2, 'sate_taichan_8_4.jpg'),
(5, 2, 'sate_taichan_8_5.jpg'),
(6, 2, 'sate_taichan_8_2.jpg'),
(7, 2, 'sate_taichan_8_3.jpg'),
(8, 2, 'sate_taichan_8_1.jpg'),
(43, 3, 'sdn_pondok_cabe_03.jpg'),
(44, 3, 'sdn_pondok_cabe_03_1.jpg'),
(45, 3, 'sdn_pondok_cabe_03_2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `is_read` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE `points` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `point` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `address` varchar(255) DEFAULT NULL,
  `urlAddress` text,
  `isFavorit` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `description`, `address`, `urlAddress`, `isFavorit`) VALUES
(1, 1, 'Scientia Square Park', 'Complementing the needs and facilities in the Scientia Garden area, Summarecon also presents a green and modern facility, Scientia Square Park (SQP). A 7,500 m2 family recreational park, which will become a center of activity for students, university students, as well as the people of Serpong and Jakarta. The presence of the SDC Building and Scientia Square Park is a manifestation of Summarecon\'s efforts, as the main developer in Gading Serpong, to facilitate the lifestyle of city people who are very dynamic and increasingly attached to technology. This open green park is also a means of alternative entertainment for families.', 'JL. SCIENTIA BOULEVARD\r\nCURUG SANGERENG\r\nKELAPA DUA\r\nTANGERANG 15810', 'https://www.google.com/maps/place/Scientia+Square+Park/@-6.257042,106.6144061,18z/data=!3m1!4b1!4m5!3m4!1s0x2e69fc651e649223:0x3b96f2ef67285cd9!8m2!3d-6.257042!4d106.6155004', 1),
(2, 2, 'Sate Taichan 8', 'Sate Taichan 8 is located at Pasar Lama Jl. Kisamaun (Near the Clock Monument), Tangerang City, Tangerang. The average cost required is around IDR 50,000/person, opening hours are 18:00 - 23:00 and it is Indonesia in the Tangerang area. This restaurant is indeed a culinary tourism destination in the Tangerang area. There is a wide variety of delicious food available here and it is well worth a visit.', 'Pasar Lama Jl. Kisamaun (Near the Clock Monument), Tangerang City, Tangerang', 'https://www.google.com/maps/place/Sate+Taichan+8+Tangerang/@-6.1863791,106.630959,17z/data=!3m1!4b1!4m5!3m4!1s0x2e69f9fcf987efbb:0x5a0f4b97b8c0059a!8m2!3d-6.1863412!4d106.6354415', 1),
(3, 3, 'SD NEGERI PONDOK CABE UDIK 03', 'SD NEGERI PONDOK CABE UDIK 03', 'Jl. Kayu Manis Raya Kec. Pamulang, Kota Tangerang Selatan', 'https://www.google.com/maps/place/Sekolah+Dasar+Negeri+Pondok+Cabe+Udik+III/@-6.3502794,106.7648732,18z/data=!4m10!1m2!2m1!1sSd+Negeri+Pondok+Cabe+Udik+03,+Jl.+Pala+Raya+No.3,+Pd.+Cabe+Udik,+Kec.+Pamulang,+Kota+Tangerang+Selatan,+Banten+15418!3m6!1s0x2e69ef031ac7cbe9:0x5567185d5fb2bc9a!8m2!3d-6.3502794!4d106.7670619!15sCnVTZCBOZWdlcmkgUG9uZG9rIENhYmUgVWRpayAwMywgSmwuIFBhbGEgUmF5YSBOby4zLCBQZC4gQ2FiZSBVZGlrLCBLZWMuIFBhbXVsYW5nLCBLb3RhIFRhbmdlcmFuZyBTZWxhdGFuLCBCYW50ZW4gMTU0MThabyJtc2QgbmVnZXJpIHBvbmRvayBjYWJlIHVkaWsgMDMgamwgcGFsYSByYXlhIG5vIDMgcGQgY2FiZSB1ZGlrIGtlYyBwYW11bGFuZyBrb3RhIHRhbmdlcmFuZyBzZWxhdGFuIGJhbnRlbiAxNTQxOJIBEWVsZW1lbnRhcnlfc2Nob29smgEjQ2haRFNVaE5NRzluUzBWSlEwRm5TVVJyTVY5MmVFUjNFQUXgAQA!16s%2Fg%2F11cmmqbks_', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `review` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'CUSTOMER'),
(2, 'ADMIN'),
(3, 'SUPERADMIN');

-- --------------------------------------------------------

--
-- Table structure for table `uniqcode`
--

CREATE TABLE `uniqcode` (
  `id` int NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `role_id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `image` text,
  `password` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `name_voucher` varchar(255) DEFAULT NULL,
  `point` int DEFAULT NULL,
  `image` text,
  `description` varchar(255) DEFAULT NULL,
  `is_discount` int DEFAULT NULL,
  `discount_percent` varchar(255) DEFAULT NULL,
  `discount_price` int DEFAULT NULL,
  `active_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_claim`
--

CREATE TABLE `voucher_claim` (
  `id` int NOT NULL,
  `owner_id` int DEFAULT NULL,
  `user_claim` int DEFAULT NULL,
  `voucher_id` int DEFAULT NULL,
  `name_voucher` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `point_voucher` varchar(255) DEFAULT NULL,
  `image_voucher` text,
  `is_discount` int DEFAULT NULL,
  `discount_percent` int DEFAULT NULL,
  `discount_price` int DEFAULT NULL,
  `total_purchase` int DEFAULT NULL,
  `total_after_discount` int DEFAULT NULL,
  `is_claim` int DEFAULT NULL,
  `is_use` int UNSIGNED DEFAULT '0',
  `active_at` datetime DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `claim_at` datetime DEFAULT NULL,
  `use_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_product`
--
ALTER TABLE `image_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `points`
--
ALTER TABLE `points`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uniqcode`
--
ALTER TABLE `uniqcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voucher_claim`
--
ALTER TABLE `voucher_claim`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `image_product`
--
ALTER TABLE `image_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `points`
--
ALTER TABLE `points`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `uniqcode`
--
ALTER TABLE `uniqcode`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_claim`
--
ALTER TABLE `voucher_claim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
