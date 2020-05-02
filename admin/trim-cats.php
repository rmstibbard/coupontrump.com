<?php

ini_set('max_execution_time', 0);

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url` WHERE `cat` LIKE '%Business%'" ;
$stmt = $db->prepare($query);
$stmt->execute();

$a = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $course_url = $row['course_url'];
    
    $cat = trim(trim($row['cat'], "\n"));
    $subcat = trim(trim($row['subcat'],"\n"));
    
    $update_query = "UPDATE `yourls_url`
        SET `cat` = :cat, 
        `subcat` = :subcat
        WHERE `course_url` = :course_url";
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':cat', $cat);
    $update_stmt->bindParam(':subcat', $subcat);
    $update_stmt->bindParam(':course_url', $course_url);
    $update_stmt->execute();
    $no_urls = $stmt->rowCount();
        
    echo "Setting " . $row['course_url'] . "  as   <b>" . $cat . " - " . $subcat . "</b>(" . $a . " of " . $no_urls . ")<br>";
    $a++;
        
}        

echo "<h1>Done!</h1>";

?>