<?php

ini_set('max_execution_time', 0);

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%'";
$stmt = $db->prepare($query);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $course_url = $row['course_url'];
    $cat_in_dbase = $row['cat'];
    $subcat_in_dbase = $row['subcat'];
    
    $new_cat = str_replace("&amp;", "and", $cat_in_dbase);
    $new_subcat = str_replace("&amp;", "and", $subcat_in_dbase);
    
    $update_query = "UPDATE `yourls_url`
        SET `cat` = :new_cat,
        `subcat` = :new_subcat
        WHERE `course_url` = :course_url";
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':new_cat', $new_cat);
    $update_stmt->bindParam(':new_subcat', $new_subcat);
    $update_stmt->bindParam(':course_url', $course_url);
    $update_stmt->execute();
    
    echo "Setting " . $row['course_url'] . "<br>";
}

echo "<h1>Done!</h1>";

?>