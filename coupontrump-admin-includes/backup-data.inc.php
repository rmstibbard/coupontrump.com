<?php

$output .= "\t\t(";
$output .= $row['id'] . ",";
$output .= $row['course_id'] . ",'";
$output .= $row['course_url'] . "','";
$output .= $row['slug'] . "','";
$output .= $row['keyword'] . "','";
$output .= $row['url'] . "','";
$output .= $row['prev_url'] . "','";
$output .= $row['image_url'] . "','";
$output .= str_replace("'","''",$row['title']) . "','";
$output .= $row['cat'] . "','";
$output .= $row['subcat'] . "','";
$output .= $row['author'] . "','";
$output .= $row['author_description'] . "','";
$output .= $row['twitter'] . "','";
$output .= $row['review_percent'] . "','";
$output .= $row['ratings'] . "','";
$output .= $row['coupon'] . "','";
$output .= $row['prev_coupon'] . "','";
$output .= $row['notes'] . "','";
$output .= $row['full_price'] . "','";
$output .= $row['reduced_price'] . "','";
$output .= $row['prev_reduced_price'] . "','";
$output .= str_replace("'","''",$row['subtitle']) . "','";
$output .= str_replace("'","''",$row['description']) . "','";
$output .= $row['timestamp'] . "','";
$output .= $row['added'] . "','";
$output .= $row['ip'] . "','";
$output .= $row['clicks'] . "','";
$output .= $row['active'] . "','";
$output .= $row['updated'] . "','";
$output .= "')";

?>