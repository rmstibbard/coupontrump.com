<?php
$output = "-- Host: " . $_SERVER['SERVER_NAME'] . "\n";
$output .= "-- Generation Time: " . $start_time . "\n\n";

$output .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
$output .= "SET time_zone = '+00:00';\n\n";

$output .= "CREATE TABLE IF NOT EXISTS `yourls_url` (\n";
$output .= "  `id` int(11) NOT NULL AUTO_INCREMENT,\n";
$output .= "  `course_id` int(20) NOT NULL,\n";
$output .= "  `course_url` varchar(1000) NOT NULL,\n";
$output .= "  `slug` text NOT NULL,\n";
$output .= "  `keyword` varchar(15) NOT NULL,\n";
$output .= "  `url` text NOT NULL,\n";
$output .= "  `prev_url` text NOT NULL,\n";
$output .= "  `image_url` varchar(255) NOT NULL,\n";
$output .= "  `title` varchar(255) NOT NULL,\n";
$output .= "  `cat` varchar(100) NOT NULL,\n";
$output .= "  `subcat` varchar(200) NOT NULL,\n";
$output .= "  `author` varchar(255) NOT NULL,\n";
$output .= "  `author_description` text NOT NULL,\n";
$output .= "  `twitter` varchar(40) NOT NULL,\n";
$output .= "  `review_percent` varchar(20) NOT NULL,\n";
$output .= "  `ratings` varchar(255) NOT NULL,\n";
$output .= "  `coupon` varchar(255) NOT NULL,\n";
$output .= "  `prev_coupon` varchar(100) NOT NULL,\n";
$output .= "  `notes` varchar(1000) NOT NULL,\n";
$output .= "  `full_price` decimal(4,0) DEFAULT NULL,\n";
$output .= "  `reduced_price` decimal(4,0) NOT NULL,\n";
$output .= "  `prev_reduced_price` int(11) NOT NULL,\n";
$output .= "  `subtitle` varchar(1000) NOT NULL,\n";
$output .= "  `description` text NOT NULL,\n";
$output .= "  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n";
$output .= "  `added` datetime NOT NULL,\n";
$output .= "  `ip` varchar(41) NOT NULL,\n";
$output .= "  `clicks` int(10) NOT NULL,\n";
$output .= "  `active` varchar(7) DEFAULT NULL,\n";
$output .= "  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',\n";
$output .= "  PRIMARY KEY (`id`)\n";
$output .= ") ENGINE=InnoDB  DEFAULT CHARSET=utf8;\n\n";
$output .= "--\n";
$output .= "-- Truncate table before insert `yourls_url`\n";
$output .= "--\n";
$output .= "TRUNCATE TABLE `yourls_url`;";
$output .= "--\n";
$output .= "-- Dumping data for table `yourls_url`\n";
$output .= "--\n\n\n";
?>