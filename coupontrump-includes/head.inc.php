<?php
require_once 'define-constants.inc.php';

$results = new results($db);

$server_time = strtotime(date('Y-m-d H:i:s'));
$server_offset = 3 * 3600;                      // Server is 3 hours ahead of Udemy
$udemy_time = $server_time - $server_offset;

if (defined('BEST_COUPON_EXPIRY')) {
    $best_coupon_expiry = strtotime(BEST_COUPON_EXPIRY);
    $time_to_run = $best_coupon_expiry - $udemy_time;
} else {
    $time_to_run = 0;
}

if (defined('EXPIRING_COUPON_EXPIRY')) {
    $expiring_coupon_expiry = strtotime(EXPIRING_COUPON_EXPIRY);
    $expiring_time_to_run = $expiring_coupon_expiry - $udemy_time;
} else {
    $expiring_time_to_run = 0;
}

require_once 'set-output.inc.php';

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <!-- F90B8176-221D-4DFE-8563-DB18F713406C -->
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=yes, initial-scale=1, width=device-width">

    <?php

    if ($filename == "about-us.php") {
        $title_string = "About CouponTrump";
    }

    if ($filename == "privacy-policy.php") {
        $title_string = "CouponTrump Privacy Policy";
    }

    if ($filename == "submit-courses.php") {
        $title_string = "Submit your online courses to CouponTrump";
    }

    if ($filename == "thank-you.php") {
        $title_string = $page_title;
    }

    if ($filename == "not-found.php") {
        $title_string = "Page not found";
    }

    if (!isset($og_image_string)) {
        $og_image_string = "\t\t<meta property='og:image' content='http://www.coupontrump.com/images/fb-og-image.png'>";
    }

    if (!isset($title_string)) {
        $title_string = DEFAULT_TITLE;
    }


    echo "\n\t\t<meta property='og:title' content='" . trim($title_string) . "'>\n";
    echo "\t\t<meta property='og:description' content='" . trim($title_string) . "'>\n";
    echo "\t\t<title>" . trim($title_string) . "</title>\n\n";
    echo $og_image_string;

    ?>

    <meta property="og:type" content="website" />
    <meta property="og:locale" content="en_GB" />
    <meta property="og:url" content="http://www.coupontrump.com/" />
    <meta property="og:site_name" content="CouponTrump" />
    <meta property="fb:admins" content="100000498390332" />

    <link rel="canonical" href="http://www.coupontrump.com/" />
    <link rel="icon" type="img/ico" href="images/favicon.ico">

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script src="scripts/jquery.lazy.min.js"></script>
    <script src="scripts/lazy.js"></script>
    <script src="scripts/cat-lists.js"></script>
    <script src="scripts/cat-results.js"></script>
    <script src="scripts/author-keywords.js"></script>
    <script src="scripts/afflink.js"></script>
    <!-- script src="scripts/clicks-sum.js"></script -->

    <?php
    require_once 'statcounter.inc.php';
    require_once 'twitter.inc.php';
    require_once 'fb-pixel.inc.php';
    require_once 'cmp.inc.php';
    //require_once 'mixpanel.inc.php';
    ?>

</head>

<body>