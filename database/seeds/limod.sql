-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2020 at 10:37 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limod`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lng` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `can_comment` tinyint(1) DEFAULT NULL,
  `can_rate` tinyint(1) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE `article_category` (
  `article_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `show_as_filter` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_groups`
--

CREATE TABLE `attribute_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_groups`
--

INSERT INTO `attribute_groups` (`id`, `title`, `order`, `created_at`, `updated_at`) VALUES
(1, 'رنگ', 0, '2020-11-25 09:45:10', '2020-11-25 09:45:10'),
(2, 'سایز', 0, '2020-11-25 09:45:35', '2020-11-25 09:45:35'),
(3, 'جنس', 0, '2020-11-25 09:45:41', '2020-11-25 09:45:41');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_items`
--

CREATE TABLE `attribute_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_item_product`
--

CREATE TABLE `attribute_item_product` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_item_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_product`
--

CREATE TABLE `attribute_product` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visibility` tinyint(1) NOT NULL DEFAULT '1',
  `variation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_variation`
--

CREATE TABLE `attribute_variation` (
  `attribute_id` bigint(20) UNSIGNED NOT NULL,
  `variation_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_item_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `en_name` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `logo` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `full_description` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `en_name`, `slug`, `logo`, `image`, `short_description`, `full_description`, `order`, `published`, `featured`, `meta_title`, `meta_description`, `views`, `created_at`, `updated_at`) VALUES
(2, 'متفرقه', NULL, 'متفرقه-1606297281', NULL, NULL, NULL, NULL, 0, 1, 0, NULL, NULL, 0, '2020-11-25 09:41:21', '2020-11-25 09:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`product_id`, `category_id`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `reply` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `general` tinyint(1) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `status` enum('disable','enable') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'disable',
  `start_date` timestamp NULL DEFAULT NULL,
  `start_clock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `end_clock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `title`, `type`, `description`, `amount`, `min_amount`, `max_amount`, `general`, `number`, `status`, `start_date`, `start_clock`, `end_date`, `end_clock`, `created_at`, `updated_at`) VALUES
(1, '90663', 'پاییزه', 'percent', NULL, '1000', '10', '10', 0, 30, 'enable', '2020-11-24 10:54:52', '14', '2020-12-01 10:54:52', '20', '2020-11-25 10:57:45', '2020-11-25 10:57:45'),
(2, '2001', 'تخفیف زمستانه', 'number', 'تخفیف زمستانه ما شروع شد', '10', '20000', '30000', 1, 10, 'disable', '2020-11-26 06:24:21', '14', '2020-11-26 06:24:21', '16', '2020-11-25 11:01:35', '2020-11-26 06:24:21'),
(3, '2012', 'کوپن زمستانه', 'percent', NULL, '15', '10000', '100000', 1, 50, 'enable', '2020-11-22 08:32:39', '14', '2020-12-20 08:32:39', '16', '2020-11-26 08:33:29', '2020-11-26 08:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `menu_itemable_id` bigint(20) UNSIGNED DEFAULT NULL,
  `menu_itemable_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `new_page` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_12_10_194000_create_smsirlaravel_log_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_07_10_182501_create_permission_tables', 1),
(6, '2020_07_10_182542_create_shoppingcart_table', 1),
(7, '2020_07_10_183832_create_pages_table', 1),
(8, '2020_07_10_184001_create_menus_table', 1),
(9, '2020_07_10_184140_create_slides_table', 1),
(10, '2020_07_10_184746_create_product_categories_table', 1),
(11, '2020_07_10_185748_create_brands_table', 1),
(12, '2020_07_10_192844_create_mobile_verifications_table', 1),
(13, '2020_07_10_193238_create_addresses_table', 1),
(14, '2020_07_10_194805_create_article_categories_table', 1),
(15, '2020_07_10_195000_create_articles_table', 1),
(16, '2020_07_10_195957_create_comments_table', 1),
(17, '2020_07_10_200415_create_products_table', 1),
(18, '2020_07_10_205352_create_category_product_table', 1),
(19, '2020_07_10_205518_create_product_images_table', 1),
(20, '2020_07_10_210619_create_attributes_table', 1),
(21, '2020_07_11_120513_create_attribute_product_table', 1),
(22, '2020_07_11_120756_create_stocks_table', 1),
(23, '2020_07_11_121239_create_tags_table', 1),
(24, '2020_07_11_121517_create_taggables_table', 1),
(25, '2020_07_11_122007_create_special_offers_table', 1),
(26, '2020_07_11_123144_create_article_category_table', 1),
(29, '2020_07_11_124800_create_contancts_table', 1),
(30, '2020_07_11_124856_create_options_table', 1),
(31, '2020_07_11_125138_create_orders_table', 1),
(32, '2020_07_11_125820_create_product_user_table', 1),
(33, '2020_07_11_130426_create_order_items_table', 1),
(34, '2020_07_13_164758_create_notifications_table', 1),
(35, '2020_07_21_213636_create_variations_table', 1),
(36, '2020_08_14_192738_create_attribute_variation_table', 1),
(37, '2020_09_01_033358_add_variation_id_to_order_items_table', 1),
(38, '2020_09_01_204207_add_show_as_filter_to_attributes_table', 1),
(39, '2020_09_01_212029_create_product_attribute_item_table', 1),
(40, '2020_09_18_135422_create_transactions_table', 1),
(41, '2020_10_12_195520_create_rates_table', 1),
(43, '2020_07_11_123939_create_coupons_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mobile_verifications`
--

CREATE TABLE `mobile_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(3, 'App\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`) VALUES
(1, 'site_information', '{\"website_name\":\"Laravel\"}'),
(2, 'shipping', '{\"free_shipping\":{\"title\":\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u0631\\u0627\\u06cc\\u06af\\u0627\\u0646\",\"is_active\":false,\"province_min_order_price\":0,\"all_min_order_price\":0,\"all_cities\":false,\"show_other_shipping\":false},\"post_shipping\":{\"title\":\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u067e\\u0633\\u062a\\u06cc\",\"is_active\":true,\"province_price\":5000,\"other_provinces_price\":12000},\"bike_shipping\":{\"title\":\"\\u0627\\u0631\\u0633\\u0627\\u0644 \\u0628\\u0627 \\u067e\\u06cc\\u06a9\",\"is_active\":false,\"price\":4000},\"in_place_delivery\":{\"title\":\"\\u062f\\u0631\\u06cc\\u0627\\u0641\\u062a \\u062d\\u0636\\u0648\\u0631\\u06cc\",\"is_active\":false,\"in_city\":false,\"in_province\":false}}');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `shipping` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_price` double NOT NULL,
  `discount` double NOT NULL DEFAULT '0',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `variation_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_description` text COLLATE utf8mb4_unicode_ci,
  `image` text COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `title`, `group_id`, `created_at`, `updated_at`) VALUES
(1, 'view panel', 'web', 'مشاهده پنل', 2, '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(2, 'view options', 'web', 'مشاهده تنظیمات', 2, '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(3, 'view file manager', 'web', 'مشاهده رسانه', 2, '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(4, 'create order', 'web', 'ایجاد سفارش', 17, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(5, 'view orders', 'web', 'مشاهده سفارش', 17, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(6, 'edit order', 'web', 'ویرایش سفارش', 17, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(7, 'delete order', 'web', 'حذف سفارش', 17, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(8, 'create tag', 'web', 'ایجاد برچسب', 18, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(9, 'view tags', 'web', 'مشاهده برچسب', 18, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(10, 'edit tag', 'web', 'ویرایش برچسب', 18, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(11, 'delete tag', 'web', 'حذف برچسب', 18, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(12, 'create contact', 'web', 'ایجاد تماس', 16, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(13, 'view contacts', 'web', 'مشاهده تماس', 16, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(14, 'edit contact', 'web', 'ویرایش تماس', 16, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(15, 'delete contact', 'web', 'حذف تماس', 16, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(16, 'create coupon', 'web', 'ایجاد کوپن تخفیف', 15, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(17, 'view coupons', 'web', 'مشاهده کوپن تخفیف', 15, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(18, 'edit coupon', 'web', 'ویرایش کوپن تخفیف', 15, '2020-11-25 07:15:43', '2020-11-25 07:15:43'),
(19, 'delete coupon', 'web', 'حذف کوپن تخفیف', 15, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(20, 'create attribute', 'web', 'ایجاد ویژگی', 14, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(21, 'view attributes', 'web', 'مشاهده ویژگی', 14, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(22, 'edit attribute', 'web', 'ویرایش ویژگی', 14, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(23, 'delete attribute', 'web', 'حذف ویژگی', 14, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(24, 'create product', 'web', 'ایجاد محصول', 13, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(25, 'view products', 'web', 'مشاهده محصول', 13, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(26, 'edit product', 'web', 'ویرایش محصول', 13, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(27, 'delete product', 'web', 'حذف محصول', 13, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(28, 'create comment', 'web', 'ایجاد نظر', 11, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(29, 'view comments', 'web', 'مشاهده نظر', 11, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(30, 'edit comment', 'web', 'ویرایش نظر', 11, '2020-11-25 07:15:44', '2020-11-25 07:15:44'),
(31, 'delete comment', 'web', 'حذف نظر', 11, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(32, 'create rate', 'web', 'ایجاد امتیاز', 12, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(33, 'view rates', 'web', 'مشاهده امتیاز', 12, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(34, 'edit rate', 'web', 'ویرایش امتیاز', 12, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(35, 'delete rate', 'web', 'حذف امتیاز', 12, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(36, 'create brand', 'web', 'ایجاد برند', 10, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(37, 'view brands', 'web', 'مشاهده برند', 10, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(38, 'edit brand', 'web', 'ویرایش برند', 10, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(39, 'delete brand', 'web', 'حذف برند', 10, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(40, 'create product category', 'web', 'ایجاد دسته بندی محصول', 9, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(41, 'view product categories', 'web', 'مشاهده دسته بندی محصول', 9, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(42, 'edit product category', 'web', 'ویرایش دسته بندی محصول', 9, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(43, 'delete product category', 'web', 'حذف دسته بندی محصول', 9, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(44, 'create slide', 'web', 'ایجاد اسلاید', 8, '2020-11-25 07:15:45', '2020-11-25 07:15:45'),
(45, 'view slides', 'web', 'مشاهده اسلاید', 8, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(46, 'edit slide', 'web', 'ویرایش اسلاید', 8, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(47, 'delete slide', 'web', 'حذف اسلاید', 8, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(48, 'create menu', 'web', 'ایجاد منو', 7, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(49, 'view menus', 'web', 'مشاهده منو', 7, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(50, 'edit menu', 'web', 'ویرایش منو', 7, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(51, 'delete menu', 'web', 'حذف منو', 7, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(52, 'create article category', 'web', 'ایجاد دسته بندی مقاله', 6, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(53, 'view article categories', 'web', 'مشاهده دسته بندی مقاله', 6, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(54, 'edit article category', 'web', 'ویرایش دسته بندی مقاله', 6, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(55, 'delete article category', 'web', 'حذف دسته بندی مقاله', 6, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(56, 'create article', 'web', 'ایجاد مقاله', 5, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(57, 'view articles', 'web', 'مشاهده مقاله', 5, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(58, 'edit article', 'web', 'ویرایش مقاله', 5, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(59, 'delete article', 'web', 'حذف مقاله', 5, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(60, 'create page', 'web', 'ایجاد صفحه', 4, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(61, 'view pages', 'web', 'مشاهده صفحه', 4, '2020-11-25 07:15:46', '2020-11-25 07:15:46'),
(62, 'edit page', 'web', 'ویرایش صفحه', 4, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(63, 'delete page', 'web', 'حذف صفحه', 4, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(64, 'create user', 'web', 'ایجاد کاربر', 1, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(65, 'view users', 'web', 'مشاهده کاربر', 1, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(66, 'edit user', 'web', 'ویرایش کاربر', 1, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(67, 'delete user', 'web', 'حذف کاربر', 1, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(68, 'edit user permissions', 'web', 'ویرایش دسترسی کاربران', 1, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(69, 'delete permission', 'web', 'حذف دسترسی ها', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(70, 'edit permission', 'web', 'ویرایش دسترسی ها', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(71, 'create permission', 'web', 'ایجاد دسترسی ها', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(72, 'view permissions', 'web', 'مشاهده دسترسی ها', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(73, 'delete permission group', 'web', 'حذف گروه های دسترسی', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(74, 'edit permission group', 'web', 'ویرایش گروه های دسترسی', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(75, 'create permission group', 'web', 'ایجاد گروه های دسترسی', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(76, 'view permission groups', 'web', 'مشاهده گروه های دسترسی', 3, '2020-11-25 07:15:47', '2020-11-25 07:15:47'),
(77, 'delete role', 'web', 'حذف نقش ها', 3, '2020-11-25 07:15:48', '2020-11-25 07:15:48'),
(78, 'edit role', 'web', 'ویرایش نقش ها', 3, '2020-11-25 07:15:48', '2020-11-25 07:15:48'),
(79, 'create role', 'web', 'ایجاد نقش ها', 3, '2020-11-25 07:15:48', '2020-11-25 07:15:48'),
(80, 'view roles', 'web', 'مشاهده نقش ها', 3, '2020-11-25 07:15:48', '2020-11-25 07:15:48');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `name`, `title`, `created_at`, `updated_at`) VALUES
(1, 'users permissions', 'مدیریت کاربران', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(2, 'other permissions', 'متفرقه', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(3, 'permissions management', 'مدیریت دسترسی ها', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(4, 'pages permissions', 'مدیریت صفحات', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(5, 'article permissions', 'مدیریت مقالات', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(6, 'article category permissions', 'مدیریت دسته بندی مقالات', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(7, 'menu permissions', 'مدیریت منو ها', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(8, 'slide permissions', 'مدیریت اسلاید ها', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(9, 'product category permissions', 'مدیریت دسته بندی محصولات', '2020-11-25 07:15:41', '2020-11-25 07:15:41'),
(10, 'brand permissions', 'مدیریت برندها', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(11, 'comment permissions', 'مدیریت نظرات', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(12, 'rate permissions', 'مدیریت امتیازات', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(13, 'product permissions', 'مدیریت محصولات', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(14, 'attribute permissions', 'مدیریت ویژگی ها', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(15, 'coupon permissions', 'مدیریت کدهای تخفیف', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(16, 'contact permissions', 'مدیریت تماس ها', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(17, 'order permissions', 'مدیریت سفارشات', '2020-11-25 07:15:42', '2020-11-25 07:15:42'),
(18, 'tag permissions', 'مدیریت  برچسب ها', '2020-11-25 07:15:42', '2020-11-25 07:15:42');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `en_title` text COLLATE utf8mb4_unicode_ci,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `can_rate` tinyint(1) DEFAULT NULL,
  `can_comment` tinyint(1) DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `full_description` longtext COLLATE utf8mb4_unicode_ci,
  `manage_stock` tinyint(1) DEFAULT NULL,
  `sold_individually` tinyint(1) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_stock` int(11) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `can_order` tinyint(1) NOT NULL DEFAULT '1',
  `min_order` int(11) DEFAULT NULL,
  `max_order` int(11) DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `regular_price` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `video` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `type`, `title`, `en_title`, `slug`, `image`, `order`, `brand_id`, `can_rate`, `can_comment`, `short_description`, `full_description`, `manage_stock`, `sold_individually`, `stock`, `stock_status`, `min_stock`, `published`, `is_featured`, `can_order`, `min_order`, `max_order`, `weight`, `regular_price`, `sale_price`, `video`, `views`, `created_at`, `updated_at`, `meta_title`, `meta_description`) VALUES
(1, '1002', 'simple-product', 'انگشتر باربد طرح ارمیس مدل عقیق لکه برفی', NULL, 'انگشتر-باربد-طرح-ارمیس-مدل-عقیق-لکه-برفی', 'images/products/2020/11/ZXLUJvtskIRM8xWlPpi98njjdsIs4Q2wudl0Xb8k.jpeg', 0, 2, NULL, NULL, '<p>انگشتر باربد طرح ارمیس مدل عقیق لکه برفی</p>', '<h1>انگشتر باربد طرح ارمیس مدل عقیق لکه برفی</h1>', 0, 0, 20, 'instock', NULL, 1, 0, 1, NULL, NULL, 2, 200000, NULL, NULL, 2, '2020-11-25 10:14:40', '2020-11-26 08:13:46', 'انگشتر باربد طرح ارمیس مدل عقیق لکه برفی', 'انگشتر باربد طرح ارمیس مدل عقیق لکه برفی');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci,
  `icon` text COLLATE utf8mb4_unicode_ci,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` text COLLATE utf8mb4_unicode_ci,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `views` bigint(20) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `image`, `icon`, `parent_id`, `order`, `description`, `meta_title`, `meta_description`, `views`, `created_at`, `updated_at`) VALUES
(1, 'اکسسوری', 'اکسسوری', NULL, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-11-25 09:32:26', '2020-11-25 09:32:26'),
(2, 'ساعت', 'ساعت', NULL, NULL, 1, 0, NULL, NULL, NULL, 0, '2020-11-25 09:32:43', '2020-11-25 09:32:43'),
(3, 'انگشتر', 'انگشتر', NULL, NULL, 1, 0, NULL, NULL, NULL, 0, '2020-11-25 09:32:57', '2020-11-25 09:32:57'),
(4, 'دستبند', 'دستبند', NULL, NULL, 1, 0, NULL, NULL, NULL, 0, '2020-11-25 09:33:13', '2020-11-25 09:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `src` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `src`, `created_at`, `updated_at`) VALUES
(1, 1, 'images/products/2020/11/MnXDKoami04HVNeNmdDz0MITbp7Hpy0dTFzCy53c.jpeg', '2020-11-25 10:14:41', '2020-11-25 10:14:41'),
(2, 1, 'images/products/2020/11/gm7uWshKrPaLXGWKwmbzl8qsDYt69woDiWQAGQa7.jpeg', '2020-11-25 10:14:41', '2020-11-25 10:14:41'),
(3, 1, 'images/products/2020/11/1LEAjugeFiZVDVMYJlQZb7qVog4WJzG8oNdFeQsG.jpeg', '2020-11-25 10:14:41', '2020-11-25 10:14:41'),
(4, 1, 'images/products/2020/11/ZsosOULyNQwHsO6AKnVhzwVVYc1vHXP0GtTrIBsT.jpeg', '2020-11-25 10:14:41', '2020-11-25 10:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_user`
--

CREATE TABLE `product_user` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rates`
--

CREATE TABLE `rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rateable_id` bigint(20) UNSIGNED NOT NULL,
  `rateable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `title`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'member', 'کاربر معمولی', 'web', '2020-11-25 07:15:48', '2020-11-25 07:15:48'),
(2, 'admin', 'مدیر', 'web', '2020-11-25 07:15:48', '2020-11-25 07:15:48'),
(3, 'superadmin', 'مدیرکل', 'web', '2020-11-25 07:15:49', '2020-11-25 07:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(13, 3),
(14, 3),
(15, 3),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 3),
(21, 3),
(22, 3),
(23, 3),
(24, 3),
(25, 3),
(26, 3),
(27, 3),
(28, 3),
(29, 3),
(30, 3),
(31, 3),
(32, 3),
(33, 3),
(34, 3),
(35, 3),
(36, 3),
(37, 3),
(38, 3),
(39, 3),
(40, 3),
(41, 3),
(42, 3),
(43, 3),
(44, 3),
(45, 3),
(46, 3),
(47, 3),
(48, 3),
(49, 3),
(50, 3),
(51, 3),
(52, 3),
(53, 3),
(54, 3),
(55, 3),
(56, 3),
(57, 3),
(58, 3),
(59, 3),
(60, 3),
(61, 3),
(62, 3),
(63, 3),
(64, 3),
(65, 3),
(66, 3),
(67, 3),
(68, 3),
(69, 3),
(70, 3),
(71, 3),
(72, 3),
(73, 3),
(74, 3),
(75, 3),
(76, 3),
(77, 3),
(78, 3),
(79, 3),
(80, 3);

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `identifier` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instance` varchar(90) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text COLLATE utf8mb4_unicode_ci,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `smsirlaravel_logs`
--

CREATE TABLE `smsirlaravel_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `from` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `response` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_offers`
--

CREATE TABLE `special_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `price` double NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `purchase_price` int(11) NOT NULL,
  `sell_price` int(11) NOT NULL,
  `offer_price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taggables`
--

CREATE TABLE `taggables` (
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_id` bigint(20) UNSIGNED NOT NULL,
  `taggable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `port` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `is_paid` tinyint(1) NOT NULL DEFAULT '0',
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `api_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` double NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `mobile`, `image`, `is_active`, `api_token`, `credit`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'محسن صفری', 'mohsen.4887@gmail.com', '09356504887', NULL, 1, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `used_at` timestamp NULL DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `conditions` text COLLATE utf8mb4_unicode_ci,
  `regular_price` double DEFAULT NULL,
  `sale_price` double DEFAULT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `manage_stock` tinyint(1) NOT NULL DEFAULT '0',
  `stock` int(11) DEFAULT NULL,
  `stock_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_groups`
--
ALTER TABLE `attribute_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_items`
--
ALTER TABLE `attribute_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_verifications`
--
ALTER TABLE `mobile_verifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_group_id_foreign` (`group_id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rates`
--
ALTER TABLE `rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `shoppingcart`
--
ALTER TABLE `shoppingcart`
  ADD PRIMARY KEY (`identifier`,`instance`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smsirlaravel_logs`
--
ALTER TABLE `smsirlaravel_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `special_offers`
--
ALTER TABLE `special_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transactions_uuid_unique` (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_mobile_unique` (`mobile`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_api_token_unique` (`api_token`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_categories`
--
ALTER TABLE `article_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute_groups`
--
ALTER TABLE `attribute_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attribute_items`
--
ALTER TABLE `attribute_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `mobile_verifications`
--
ALTER TABLE `mobile_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `rates`
--
ALTER TABLE `rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `smsirlaravel_logs`
--
ALTER TABLE `smsirlaravel_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `special_offers`
--
ALTER TABLE `special_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `permission_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
