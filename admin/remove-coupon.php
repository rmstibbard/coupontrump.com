<?php

// INPUT: list of course urls to remove coupon from and set as auto_no

set_include_path('../coupontrump-admin-includes/');

$input_file = "../coupontrump-data/remove-coupon.txt";

$page_title = "Removing Coupons ...";

require_once 'head.inc.php';

if (file_exists($input_file)) {
    if (filesize($input_file) == 0) {
        echo "<h2 class='alert'>No courses in input file</h2>\n";
        exit;
    }
} else {
    echo "<h2 class='alert'>No input file found</h2>\n";
    exit;    
}

require_once 'admin-connect.inc.php';

// Open the add-new file
$add_new_file = fopen($input_file, 'r');

// Add each line to an array
if ($add_new_file) {
   $compound_urls = explode("\n", fread($add_new_file, filesize($input_file)));
}


$compound_urls = array_filter($compound_urls);
$no_urls = sizeof($compound_urls);
$count = 0;
$new_courses = 0;

foreach ($compound_urls as $compound_url) {
    
    if (strpos($compound_url,"?couponCode=")!=false) {
        $url_parts = explode("?couponCode=",$compound_url);
        $course_url = $url_parts[0];
    } else {
        $course_url = $compound_url;
    }
    
    $stmt = $db->prepare("UPDATE `yourls_url` SET `coupon` = '', `active` = 'auto_no' WHERE `course_url` = :course_url");
    $stmt->bindParam(':course_url', $course_url);
    $stmt->execute();
    
    echo "Removing coupon from $course_url <br>";
}

fclose($add_new_file);

$delete_contents = fopen($input_file, 'w');
fwrite ($delete_contents, '') ;
fclose ($delete_contents);

foreach (glob("../remove-coupon*") as $filename) {
   unlink(realpath($filename));
}

?>