<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$page_title = "Scrape Udemy deal image";

require_once '../coupontrump-includes/define-constants.inc.php';

if (isset($_GET['coupon']))  {
    $coupon = $_GET['coupon'];
} else {
    if (defined('BEST_COUPON')) {
        $coupon = BEST_COUPON;
    }
}

$scrape = new scrape();

require_once "head.inc.php";
require_once "curl.inc.php";

if (isset($coupon)) {
    $url = "https://www.udemy.com/courses/featured?couponCode=" . $coupon . "&pmtag=" . $coupon;
} else {
    $url = "https://www.udemy.com/courses/featured";
}
 
$results_page = curl($url);
//$results_page = scrape_between($results_page, '<div id="banner-header"', '</div');

$results_page = scrape_between($results_page,'<div class="top tac usertracker-command"','</div');

$image_url = scrape_between($results_page, 'img src="', '" alt=""/>');

if (isset($coupon)) {
    echo "COUPON: " . $coupon . "<br>";
}

echo "<h1>Udemy deal image</h1>";

//echo "<a target='_blank' href='" . $image_url . "'>" . $image_url . "</a><br>";
echo "<a target='_blank' href='" . $image_url . "'><img src='" . $image_url . "'></a><br>";


?>