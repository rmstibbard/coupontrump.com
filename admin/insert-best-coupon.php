<html>
    
    <head>
        <title>Insert best coupon</title>
    </head>
    <body>


<?php
require_once '../coupontrump-admin-includes/admin-connect.inc.php';

if (isset($_GET['best_coupon'])) {
    $best_coupon = strtolower($_GET['best_coupon']);
}

if (isset($_GET['expired_coupon'])) {
    $expired_coupon = strtolower($_GET['expired_coupon']);
}

if ( (isset($best_coupon)) && ($best_coupon!="") ) {

    $url = "http://click.linksynergy.com/fs-bin/click?id=kLhF*6p1x2w&subid=&offerid=323058";
    $url .= ".1&type=10&tmpid=14537&RD_PARM1=https%3A%2F%2Fwww.udemy.com%2Fcourses%2Ffeatured%3FcouponCode%3D";
    $url .= strtoupper($best_coupon) . "%2526pmtag%3D" . strtoupper($best_coupon);
    
   
    $search_query = "SELECT * FROM `yourls_url` WHERE `keyword` = :best_coupon";
    $stmt = $db->prepare($search_query);
    $stmt->bindParam(':best_coupon', $best_coupon);
    $stmt->execute();
    $count = $stmt->rowCount();
    
    if ($count==0) {
        $insert_query = "INSERT INTO `yourls_url` (`keyword` , `url`, `slug`) VALUES (:best_coupon, :url, '')";
        $stmt2 = $db->prepare($insert_query);
    }  else {
        $update_query = "UPDATE `yourls_url` SET `url` = :url, `slug` = '' WHERE `keyword` = :best_coupon";
        $stmt2 = $db->prepare($update_query);
    }
    
    
    $stmt2->bindParam(':best_coupon', $best_coupon);
    $stmt2->bindParam(':url', $url);
    $stmt2->execute();
    
    echo "<h1>New coupon '" . strtoupper($best_coupon) . "' inserted</h1>";
    
    $display_query = "SELECT * FROM `yourls_url` WHERE `keyword` = :best_coupon";
    $display_stmt = $db->prepare($display_query);
    $display_stmt->bindParam(':best_coupon', $best_coupon);
    $display_stmt->execute();
    
    while ($row = $display_stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Coupon: " . $row['keyword'] . " ";
            echo "<a target='_blank' href=" . $row['url'] . ">Check link</a><br>";
    }
    

} else {
    echo "<h1>No best coupon set</h1>";
}

?>
    </body>
</html>