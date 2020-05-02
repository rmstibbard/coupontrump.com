<?php

$large_image_url = str_replace('304x171', '480x270', $row['image_url']);

$title = str_ireplace(' - Udemy', '', $row['title']);
$title = str_ireplace('| Udemy', '', $title);

$description = str_replace('<', "\t<", $row['description']);
$description = str_replace('>', ">\n", $row['description']);

$output .= "\t\t<figure>\n";
$output .= "\t\t\t<img class='course_image' alt='" . $row['title'] . "' src='" . $large_image_url . "'>\n";
$output .= "\t\t\t</figure>\n";

$output .= "\t\t\t<h2>" . $title . "</h2>\n";
$output .= "\t\t\t<h3 class='author'><a href='index.php?author=". urlencode($row['author']) . "'>";

$output .= $row['author'] . "</a></h3>\n";

$output .= "\t\t\t<h4>" . $row['subtitle'] . "</h4>\n";


$output .= "\t\t\t\t<div id='star-ratings-sprite'>";
$output .= "<span style='width:" . $row['review_percent'] . "%' class='rating'></span>";
$output .= "</div>\n";

$output .= "\t\t\t<div class='ratings_stats'>\n";
$output .= "(" . $row['ratings'] . " ratings, " . $row['student_no'] . " students enrolled)\n";
$output .= "\t\t\t</div>\n";

$output .= "<div style='height:10px'></div>";

include 'share.inc.php';

if (($row['reduced_price']==0)&&($row['full_price']==0)) {
    $button_text = "Free course at Udemy!";
} elseif (($row['reduced_price']==0)&&($row['full_price']>0)) {
    $button_text = "Get this deal - Normal price $" . $row['full_price'] . " - Now Free!";
} elseif ($row['reduced_price']<$row['full_price']) {
    $button_text = "Get this deal - Normal price $" . $row['full_price'] . " - Now just $" . $row['reduced_price'] . "!";
} else {
    $button_text = "Get this deal at Udemy for just $" . $row['reduced_price'] . "!";
}

$output .= "\t\t\t<div class='get_deal_sm'>\n";
$output .= "\t\t\t\t<button class='btn btn-primary get_deal_sm' id='" . $row['id'] . "'>";
$output .= $button_text;
$output .= "</button>";
$output .= "\t\t\t</div>\n";

$output .= "\t\t\t<div class='clear'></div>\n";

if (trim($description!="")) {
    $output .= $description;
}



$output .= "\t\t\t<div class='clear space2'></div>\n";
$output .= "\t\t\t<div class='get_deal'>\n";
$output .= "\t\t\t\t<button class='btn btn-primary get_deal' id='" . $row['id'] . "'>";
$output .= $button_text;
$output .= "</button>\n";
$output .= "\t\t\t</div>\n";

$output .= "\t\t\t\t<div class='more'>";
$output .= "\t\t\t\t\t<h2>Other courses you may like</h2>";
$output .= "\t\t\t\t\t<p><a href='index.php?cat=" . $row['cat'] . "&subcat=" . $row['subcat'] . "'>Courses in this category</a> | ";
$output .= "<a href='index.php?author=" . $row['author'] . "'>Courses by " . $row['author'] . "</a></p>";
$output .= "\t\t\t\t</div>\n";

 
?>