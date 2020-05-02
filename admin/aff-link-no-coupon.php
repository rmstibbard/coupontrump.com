<?php
error_reporting(E_ALL);
ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

if (isset($_GET['coupon_to_remove']) && ($_GET['coupon_to_remove'] != "")) {
   $coupon_to_remove = "%" . $_GET['coupon_to_remove'] . '%';
} else {
   echo "<h1 style='color: red'>Provide coupon to remove</h1>";
   exit;
}

require_once 'admin-connect.inc.php';

$make_aff_link = new make_aff_link();

$query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%' AND `url` LIKE :coupon_to_remove";
      
$stmt = $db->prepare($query);

$stmt->bindParam(':coupon_to_remove',$coupon_to_remove);
$stmt->execute();
$count = $stmt->rowCount();
echo $count;
$a = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $course_url = $row['course_url'];
   $url = $make_aff_link->udemy_no_coupon($course_url);
   
   $update_query = "UPDATE `yourls_url` SET `url` = :url, `coupon` = '' WHERE `course_url` = :course_url" ;
       
   $update_stmt = $db->prepare($update_query);
   $update_stmt->bindParam(':course_url', $row['course_url']);
   $update_stmt->bindParam(':url', $url);
   $update_stmt->execute();
    
   echo $a . " of " . $count . " URLs - removing old coupon <b>" . $_GET['coupon_to_remove'] . "</b> from " . $row['course_url'] . "<br>\n";
   $a++;
       
}

echo "<h1>Done!</h1>";

?>