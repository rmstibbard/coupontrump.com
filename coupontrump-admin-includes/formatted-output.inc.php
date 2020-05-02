<?php

if ($all_course_data['scraped_lost']!="LOST") {
    
    $formatted_output = "<b>" . strtoupper($all_course_data['scraped_title']) . "</b> (" . $count . " of " . $no_urls . " URLs)<br>\n";
    
    $formatted_output .= "<span style='float: left'>";
    
    $formatted_output .= "<img style='border: 3px solid grey' width='304' height='171' ";
    
    $formatted_output .= "src='" . $all_course_data['scraped_image_url'] . "'>";
    
    $formatted_output .= "</span>\n";
    
    $formatted_output .= "<span style='float: left; margin-left: 20px'>\n";
    
    $formatted_output .= "\t<span class='" . $style . "'>" . $all_course_data['notes'] . "</span><br>\n";
    
    // $formatted_output .= "\tSubtitle: " . $all_course_data['subtitle'] . "<br>";
    
    $formatted_output .= "\tAuthor: <a href='http://coupontrump.com/index.php?author=" .  urlencode($all_course_data['scraped_author']) . "' target='_blank'>" . $all_course_data['scraped_author'] . "</a>\n";
    
    $formatted_output .= "\t&nbsp;&nbsp;&nbsp;Author page: <a href='https://www.udemy.com/u/" .  $all_course_data['scraped_author_page'] . "' target='_blank'>" . $all_course_data['scraped_author_page'] . "</a>\n";
    
    if ($all_course_data['scraped_twitter'] != NULL) {
        $formatted_output .= "\t&nbsp;&nbsp;&nbsp;Twitter: <a href='https://twitter.com/" .  $all_course_data['scraped_twitter'] . "' target='_blank'>" . $all_course_data['scraped_twitter'] . "</a><br>\n";
    } else {
        $formatted_output .= "<br>\n\n";
    }
    
    
    if ($all_course_data['slug'] != "") {
        $formatted_output .= "\tOn Coupontrump: <a href='http://www.coupontrump.com/index.php?course=" . $all_course_data['slug'] . "' target='_blank'>http://www.coupontrump.com/index.php?course=" . $all_course_data['slug'] . "</a><br>\n";
    }
    
    if ( (isset($all_course_data['url']))  && ($all_course_data['url'] != "") ) {
        $formatted_output .= "\n\t<a href='" . $all_course_data['url'] . "' target='_blank'>Affiliate link</a><br>";
    }
    
    if ( (isset($all_course_data['coupon']))  && ($all_course_data['coupon'] != "") ) {
        $formatted_output .= "\tCoupon: '" . $all_course_data['coupon'] . "' <br>";
    }
    
    if ($all_course_data['keyword'] != "") {
        $formatted_output .= "\tShortlink: <a href='http://coupontru.mp/" . $all_course_data['keyword'] . "' target='_blank'>coupontru.mp/" . $all_course_data['keyword'] . "</a><br>\n";
    }
    
    if ( (isset($id)) && ($id != "") ) {
        $formatted_output .= "\tID link: <a href='http://www.coupontrump.com/index.php?id=" . $id . "' target='_blank'>http://www.coupontrump.com/index.php?id=" . $id . "</a><br>\n";
    }
       
    if ($all_course_data['coupon'] != "") {
        $formatted_output .= "\tPlain link: <a href='" . $course_url . "?couponCode=" . $all_course_data['coupon'] . "' target='_blank'>" . $course_url . "?couponCode=" . $all_course_data['coupon'] . "</a><br>\n";
    }  else {
        $formatted_output .= "\tPlain link: <a href='" . $course_url . "' target='_blank'>" . $course_url . "</a><br>\n";
    }
    
    if ($all_course_data['scraped_full_price'] != "") {
        $formatted_output .= "\tFull price: $" . $all_course_data['scraped_full_price'] . "  ";
    }
    
    if ($all_course_data['scraped_reduced_price'] != "") {
        $formatted_output .= "Reduced price: $" . $all_course_data['scraped_reduced_price'] . "<br>\n";
    } else {
        $formatted_output .= "<br>";
    }
    
    if ($all_course_data['scraped_cat'] != "") {
        $formatted_output .= "\tCategory: " . $all_course_data['scraped_cat'] . " ";
    }
    
    if ($all_course_data['scraped_subcat'] != "") {
        $formatted_output .= "&nbsp;&nbsp;Subcategory: " . $all_course_data['scraped_subcat'] . "<br>\n";
    }
    
    if ($all_course_data['scraped_review_percent'] != "") {
        $formatted_output .= "\tReview percentage: " . $all_course_data['scraped_review_percent'];
    }
        
    if ($all_course_data['scraped_ratings'] != "") {
        $formatted_output .= "&nbsp;&nbsp;Ratings: " . $all_course_data['scraped_ratings'];
    }
    
    if ($all_course_data['calculated_quality'] != "") {
        $formatted_output .= "&nbsp;&nbsp;Calculated quality: " . $all_course_data['calculated_quality'] . "";
    }
    
    if ($all_course_data['scraped_student_no'] != "") {
        $formatted_output .= "&nbsp;&nbsp;Student no: " . $all_course_data['scraped_student_no'] . "<br>\n";
    }
    
    $formatted_output .= "</span>\n";
    
    $formatted_output .= "</span>\n";
    
    $formatted_output .= "\n\n<div style='clear: both; height: 30px'></div>\n\n";
    
} else {
    $formatted_output = "<p>YOU'RE LOST!</p>";
} 

$message = $formatted_output;

echo $formatted_output;

?>