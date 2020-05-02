<?php
$output .= "\t\t\t\t\t<div class='share'>\n";

$output .= "<a id ='" . $row['id'] . "' onclick=\"window.open('http://www.facebook.com/sharer/sharer.php";
$output .= "?title=" . urlencode($row['title']);
$output .= "&u=http://www.coupontrump.com/index.php?course=" . $row['slug'];
$output .= "' , '_blank', 'location=yes,height=300,width=960,scrollbars=yes,status=yes');\">";
$output .= "<div class='facebook'></div></a>\n";

$output .= "\t\t\t\t\t\t<a onclick=\"window.open('https://twitter.com/intent/tweet?text=";
$output .= urlencode($row['title']);

if ($row['twitter']!="") {
    $output .=  " by @" . $row['twitter'];
} else {
    $output .=  " by " . $row['author'];
}
$output .= "&amp;url=http://www.coupontrump.com/index.php?id=" . $row['id'];
$output .= "' , '_blank', 'location=yes,height=300,width=960,scrollbars=yes,status=yes');\">";
$output .= "<div class='twitter'></div></a>\n";

$output .= "\t\t\t\t\t\t<a onclick=\"window.open('https://plus.google.com/share?url=";
$output .= "?u=http://www.coupontrump.com/index.php?course=" . $row['slug'];
$output .= "&title=" . urlencode($row['title']);
$output .= "' , '_blank', 'location=yes,height=300,width=960,scrollbars=yes,status=yes');\">";
$output .= "<div class='google-plus'></div></a>\n";

$output .= "\t\t\t\t\t\t<a onclick=\"window.open('http://www.linkedin.com/shareArticle?mini=true&ro=true";
$output .= "&title=" . urlencode($row['title']);
$output .= "&url=http://www.coupontrump.com/index.php?course=" . $row['slug'];
$output .= "' , '_blank', 'location=yes,height=300,width=960,scrollbars=yes,status=yes');\">";
$output .= "<div class='linkedin'></div></a>\n";

$output .= "\t\t\t\t\t</div>\n";


?>