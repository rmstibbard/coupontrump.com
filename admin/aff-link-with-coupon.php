<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

include '../coupontrump-includes/define-constants.inc.php';

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

if (isset($_GET['coupon_to_add'])) {
   $coupon = $_GET['coupon_to_add'];
} else {
   echo "<h1 style='color: red'>Provide coupon to add</h1>";
   exit;
}

require_once 'admin-connect.inc.php';

$make_aff_link = new make_aff_link();

$query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%'";
                        
$stmt = $db->prepare($query);

$stmt->bindParam(':coupon',$coupon);
$stmt->execute();
$count = $stmt->rowCount();
$a = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $course_url = $row['course_url'];
   
   $compound_url = $course_url . "?couponCode=" . $coupon;

   $url = $make_aff_link->udemy_with_coupon($compound_url);

   
      $update_query = "UPDATE `yourls_url` SET `url` = :url WHERE `course_url` = :course_url" ;
       
       $update_stmt = $db->prepare($update_query);
       $update_stmt->bindParam(':course_url', $row['course_url']);
       $update_stmt->bindParam(':url', $url);
       $update_stmt->execute();
       
       echo $a . " of " . $count . " URLs - Adding " . $coupon . " to " . $row['course_url'] . ": <a target='_blank' href='" . $row['url'] . "'>Link</a><br>\n";
       $a++;
       
}

echo "<h1>Done!</h1>";

?>