<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$coupon_to_delete = $_GET['coupon'];

require_once 'admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url`
            WHERE `course_url` LIKE 'https://www.udemy.com/%'
            AND `coupon` = '$coupon_to_delete'";
            echo $query;
$stmt = $db->prepare($query);
$stmt->execute();
$count = $stmt->rowCount();

echo "<h1>Deleting coupon " . $coupon_to_delete . " from " . $count . " URLs</h1>";


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $make_aff_link = new make_aff_link();
    
    $url = $make_aff_link->udemy_no_coupon($course_url);
    
    $update_query = "UPDATE `yourls_url` SET
        `coupon` = '',
        `reduced_price` = :full_price,
        `url` = :url
         WHERE `course_url` = :course_url
         AND `coupon` = $coupon_to_delete";
    
    $url = $make_aff_link->udemy_no_coupon($course_url);
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':course_url', $row['course_url']);
    $update_stmt->bindParam(':url', $url);
    $update_stmt->bindParam(':full_price', $row['full_price']);
    
    $update_stmt->execute();
    
    echo "Deleting $coupon_to_delete from " . $row['course_url'] . "<br>";
    
}

echo "<h1>Done!</h1>";


?>