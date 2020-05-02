<?php

if ( ($row['reduced_price']==0) && ($row['full_price']==0) ) {
    $full_price_output = "";
    $reduced_price_output = "FREE COURSE!";
} elseif ($row['reduced_price']==0) {
    $full_price_output = "Normal price $" . $row['full_price'];
    $reduced_price_output = "NOW FREE!";
} elseif ($row['reduced_price']==$row['full_price']) {
    $full_price_output="";
    $reduced_price_output = "Just $". $row['reduced_price'] . "!";
} else {
    $full_price_output = "Normal price $" . $row['full_price'];
    $reduced_price_output = "NOW $" . $row['reduced_price'];
}

$output .= "\t\t\t\t<div class='course_block'>";
$output .= "\t\t\t\t\t<h3>\n";
$output .= "\t\t\t\t\t<a rel='nofollow' href='?course=" . $row['slug'] . "'>";
$output .= $row['title'] . "</a>\n";
$output .= "\t\t\t\t\t</h3>\n";
$output .= "\t\t\t\t\t<p class='author'><a href='index.php?author=". urlencode($row['author']) . "'>";
$output .= $row['author'] . "</a></p>\n";
$output .= "\t\t\t\t\t<p class='subtitle'>" . $row['subtitle'] . "</p>\n";
$output .= "\t\t\t\t\t<p class='price'>" . $full_price_output;
$output .= "<span class='reduced_price'>" . $reduced_price_output . "</span>\n";
$output .= "<div id='star-ratings-sprite'><span style='width:" . $row['review_percent'] . "%' class='rating'></span></div>";
$output .= "\t\t\t\t</div>";

include 'share.inc.php';


$output .= "\t\t\t\t</figcaption>\n";
$output .= "\t\t\t</figure>\n";
?>