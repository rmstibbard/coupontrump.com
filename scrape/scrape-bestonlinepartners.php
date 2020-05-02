<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

if (isset($_GET['url'])) {
    $first_url = "http://bestonlinepartners.com/" . $_GET['url'];
} else {
    $url = "http://bestonlinepartners.com";
}

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$output_file = "../coupontrump-data/add-new.txt";

$scrape_file = fopen($output_file, "a");

$scrape = new scrape();

$page_title = "Scrape Best Online Partners";

echo "<h1>" . $page_title . "</h1>";

$formatted_output = "";
$invalid_list = "";

require_once 'head.inc.php';
require_once 'curl.inc.php';


$site = "http://www.bestonlinepartners.com";

echo "<div style='margin-left: 40px;'>";
    
if (!isset($first_url)) {
    $page_to_scrape = curl($url);
    $first_url = scrape_between($page_to_scrape, 'class="first clearfix">', '<div class="catbox">');
    $first_url = scrape_between($first_url, '<a href="', '/">');
}

echo $first_url;

$results_page = curl($first_url);

//$results_page = scrape_between($results_page, 'show_ads.js"></script></div>', '<div class="GARD');

$results_page = scrape_between($results_page, '<ol>', '</ol>');

$separate_results = explode('<li>', $results_page);

foreach ($separate_results as $separate_result) {
    if (strpos($separate_result, "RD_PARM1=") !==false) {
        $encoded_link =  scrape_between($separate_result, 'RD_PARM1=', '" target="');
        $link_url = urldecode($encoded_link);
    } else {
        $link_url = scrape_between($separate_result, '<a href="', '" target="');
    }
    
    $udemy_page = curl($link_url);
    
    $udemy_url = scrape_between($udemy_page, '<meta property="og:url" content="', '" />');
    $coupon = scrape_between($udemy_page, '?couponCode=', '"');
    
    if ($coupon!="") {
        $output = $udemy_url . "?couponCode=". $coupon. "\n";
    } else {
        $output = $udemy_url . "\n";
    }
    
    if ( ($output!="?couponCode=,")
            && ($output!="") 
            && ($output!=",")
            && (strpos($output, "/courses/") === false) 
            && (strpos($output, "/courses/featured") === false) 
            && (strpos($output, "/draft/") === false)
            && (strpos($output, "https://www.udemy.com/") !== false) ) {
        
        if (strpos($output, '&amp;')!==false) {
            $output = explode('&amp;', $output)[0];
        }
        
        if (strpos($output, '%26') !== false) {
            $output = explode('%26' , $output)[0];
        }
        
        if (strpos($output, 'https://www.udemy.com/')!==false) {
            echo $output . "<br>\n";
            fwrite ($scrape_file, $output . "\n") ;
        }
    }

    
}


echo "</div>";

echo "<h1>Done!</h1>";

fclose($scrape_file);

?>