<?php

if (isset($_GET['invalid_coupon'])) {
   $invalid_coupon = $_GET['invalid_coupon'];
} else {
   echo "<h1 style='color: red'>Use <strong>?invalid_coupon=</strong> in URL!</h1>";
   exit;
}



ini_set('max_execution_time', 0);


require_once '../coupontrump-admin-includes/admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url`
            WHERE `course_url` LIKE 'https://www.udemy.com/%'
            AND `coupon` = '" . $invalid_coupon . "'";
            
$stmt = $db->prepare($query);
$stmt->execute();
$no_urls = $stmt->rowCount();

$a = 1;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $update_query = "UPDATE `yourls_url`
        SET `coupon` = :prev_coupon,
        `url` = :prev_url,
        `reduced_price` = :prev_reduced_price
        WHERE `course_url` = :course_url
        AND `coupon` = '" . $invalid_coupon . "'" ;
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':course_url', $row['course_url']);
    $update_stmt->bindParam(':prev_url', $row['prev_url']);
    $update_stmt->bindParam(':prev_coupon', $row['prev_coupon']);
    $update_stmt->bindParam(':prev_reduced_price', $row['prev_reduced_price']);
    $update_stmt->execute();
    
    echo "Setting " . $row['course_url'] . " Changing coupon from <strong>" . $invalid_coupon . "</strong> back to <strong>" . $row['prev_coupon'] . "</strong>\t\t(". $a . " of " . $no_urls . ")<br>";
    $a++;
    
}

echo "<h1>Done!</h1>";

// SQL: UPDATE `yourls_url` SET `coupon` = `prev_coupon`, `url` = `prev_url`, `reduced_price` = `prev_reduced_price` WHERE `course_url` LIKE 'https://www.udemy.com/%' AND `coupon` = 'cyberm15' AND `prev_coupon` != ''



?>