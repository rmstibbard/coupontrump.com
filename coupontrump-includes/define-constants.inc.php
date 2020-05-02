<?php

define ('LINKSHARE_ID', 'kLhF*6p1x2w');

define ('DEFAULT_TITLE', 'Valid Online Learning Discounts ' . date('F Y')) . ' | CouponTrump.com';

define ('NAMECHEAP_IP_ADDRESS', '162.213.255.30');

define ('MY_IP_ADDRESS', '86.151.87.191');

//define ('BEST_COUPON', 'JULY10310');
//define ('BEST_COUPON_PRICE', '10');
//define ('BEST_COUPON_EXPIRY', '2017-07-07 12:00:00'); 

// define ('BEST_COUPON_IMAGE','https://udemy-images.udemy.com/hellobar_banner/1440x276/4966_16f5.jpg');

define ('FEATURED_DAYS','30'); // No of days to feature a course

//define ('EXPIRING_COUPON', '');
//define ('EXPIRING_COUPON_PRICE', '');
//define ('EXPIRING_COUPON_EXPIRY', '');

//define ('SPECIAL_OFFER', '');
//define ('SPECIAL_OFFER_IMAGE' , '');

define ('COOKIE_EXPIRATION','365'); // Sets cookie lifetime in days

define('COMMON_QUERY', " `active` = 'yes'
       AND `keyword` != ''
       AND `url` != ''
       AND `course_url` != ''
       AND `image_url` != ''
       AND `title` != ''
       AND `author` != ''
       AND `slug` != ''
       AND `course_url` NOT LIKE 'https://www.udemy.com//%'
       AND `course_url` NOT LIKE 'https://www.udemy.com/courses/%'
       AND `course_url` NOT LIKE '%/draft/%'
       AND `author` NOT LIKE '%Alun Hill%'
       AND `author` NOT LIKE '%Scanlon%'
       AND `author` NOT LIKE '%Mike Pitt%'
       AND `author` NOT LIKE '%Teresa Trower%'
       AND `author` NOT LIKE '%Abi Carver%' 
       AND `author` NOT LIKE '%Tim Ernst%'
       AND `author` NOT LIKE '%Tyus%'
       AND `author` NOT LIKE '%Finance for Entrepreneurs%' ");

// ORDER_QUERY

if (!isset($order)) {
    $order = "pop";
}

switch ($order) {
    case "pop":
        define("ORDER_QUERY", " ORDER BY `clicks` DESC ");
        break;
    case "price":
        define("ORDER_QUERY", " ORDER BY `reduced_price` ASC ");
        break;
    case "ratings":
        define("ORDER_QUERY", " AND `calculated_quality` > '0' ORDER BY calculated_quality DESC ");
        break;            
    case "new":
        define("ORDER_QUERY", " ORDER BY `added` DESC ");
        break;
    case "author":
        define("ORDER_QUERY", " ORDER BY `author` ASC ");
        break;
    case "title":
        define("ORDER_QUERY", " ORDER BY `title` ASC ");
        break;
    
}

if (!defined("ORDER_QUERY")) {
    define("ORDER_QUERY", " ORDER BY `clicks` DESC ");
}

define("NUMBER_OF_FEATURED_SUBCATS", "5");   // Used for no. to be stored in featured_subcats cookie
define("NUMBER_OF_FEATURED_KEYWORDS", "5");  // Used for no. to be stored in featured_keywords cookie
define("NUMBER_OF_FEATURED_AUTHORS", "5");   // Used for no. to be stored in featured_authors cookie
    
define ("SERVER_OFFSET", "5");  // Namecheap server time offset: 60 secs * 60 mins * this constant
                                // Adds 4 or 5 hours to server time to get to UK time

