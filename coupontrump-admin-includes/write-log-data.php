<?php
$log_output = $count . "/" . $no_urls . " URLs,";
$log_output .= $all_course_data['notes'] . "," . $course_url . "," . $all_course_data['coupon'] . ",";
$log_output .= "http://www.coupontrump.com/?course=" . $all_course_data['slug'] . ",";
$log_output .= $all_course_data['scraped_title'] . "," . $all_course_data['scraped_author'] . "," . $all_course_data['scraped_twitter'] . ",";
$log_output .= $all_course_data['scraped_full_price'];

if ($all_course_data['scraped_reduced_price'] != $all_course_data['scraped_full_price'] ) {
    $log_output .= "," . $all_course_data['scraped_reduced_price']; 
} else {
    $log_output .= ",";
}


$log_output .= "\n";
fwrite($logfile, $log_output);

?>