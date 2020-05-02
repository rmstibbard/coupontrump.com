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

$output .= "\t\t<figure class='course_block col-xs-12 col-sm-6 col-md-4 col-lg-3'>\n";
$output .= "\t\t\t<a rel='nofollow' href='?course=" . $row['slug'] . "'>\n";
$output .= "\t\t\t\t<img width='304' height='171' class='course_image lazy' ";
$output .= "alt='" . $row['title'] . "' data-src='" . $row['image_url'] . "' src='images/blank.gif'></a>\n";
$output .= "\t\t\t\t<figcaption>\n";
$output .= "\t\t\t\t\t<h3>\n";
$output .= "\t\t\t\t\t<a rel='nofollow' href='?course=" . $row['slug'] . "'>";
$output .= $row['title'] . "</a>\n";
$output .= "\t\t\t\t\t</h3>\n";
$output .= "\t\t\t\t\t<p class='author'><a href='index.php?author=". urlencode($row['author']) . "'>";
$output .= $row['author'] . "</a></p>\n";

if ($_SERVER['REMOTE_ADDR'] == MY_IP_ADDRESS) {
    if ( ($row['clicks']) > 1) {
        $output .= "\t\t\t\t\t<p style='font-size: 10pt'>(" .  $row['clicks'] . " clicks)</p></p>\n";
    }
    
    if ( ($row['clicks']) == 1) {
        $output .= "\t\t\t\t\t<p style='font-size: 10pt'>(" .  $row['clicks'] . " click)</p></p>\n";
    }
    
    if ($row['featured']=='yes') {
        if ($row['featured_expires'] <= date('Y-m-d-H-i') ) {
            $output .= "\t\t\t\t\t<p style='color: red; font-weight: bold'>Featured expired!</p>\n";
        } else {
            $output .= "\t\t\t\t\t<p style='color: green; font-weight: bold'>Featured until " . substr($row['featured_expires'],0,10) . "</p>\n";
        }
    }
   
}


$output .= "\t\t\t\t\t<p class='subtitle'>" . $row['subtitle'] . "</p>\n";
$output .= "\t\t\t\t\t<p class='price'>" . $full_price_output;
$output .= "<span class='reduced_price'>" . $reduced_price_output . "</span>\n";
$output .= "<div id='star-ratings-sprite'><span style='width:" . $row['review_percent'] . "%' class='rating'></span></div>";

include 'share.inc.php';

$output .= "\t\t\t\t</figcaption>\n";
$output .= "\t\t\t</figure>\n";
?>