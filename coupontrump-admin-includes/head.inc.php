<?php
if (defined('BEST_COUPON_EXPIRY'))  {
    $best_coupon_expiry = strtotime(BEST_COUPON_EXPIRY);
    $server_time = strtotime(date('Y-m-d H:i:s'));
    $server_offset = 3 * 3600;                      // Server is 3 hours ahead of Udemy
    $udemy_time = $server_time - $server_offset;
    $time_to_run = $best_coupon_expiry - $udemy_time;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $page_title; ?></title>
        <link rel="stylesheet" href="css/admin-style.css">
    </head>
    <body>
        
