<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$output_file = "../coupontrump-data/add-new.txt";

$scrape_file = fopen($output_file, "a");

$scrape = new scrape();

$page_title = "Scrape Retail Me Not";

echo "<h1>" . $page_title . "</h1>";

$formatted_output = "";
$invalid_list = "";

require_once 'head.inc.php';
require_once 'curl.inc.php';


$site = "retailmenot.com";
$url = "http://www.retailmenot.com/view/udemy.com";

echo "<div style='margin-left: 40px;'>";

$results_page = curl($url);

$results_page = scrape_between($results_page, '<div id="wrapper" class="container clearfix parent-element">', '<div class="site-ftr">');

$separate_results = explode('<div class="offer-top clearfix">', $results_page);

foreach ($separate_results as $separate_result) {
    
    if ($separate_result != "") {
        
        $start_marker = '<a href="/out/';
        $end_marker = '" target="245269"';
        $base_url = trim(scrape_between($separate_result, $start_marker, $end_marker));
        
        $coupon_start_marker = '<span class="code-text">';
        $coupon_end_marker = '</span>';
        
        $coupon = trim(scrape_between($separate_result, $coupon_start_marker, $coupon_end_marker));
        
        $link_url = $site . "/out/" . $base_url;
        
                                       
        $udemy_page = curl($link_url);
        
        $udemy_url = scrape_between($udemy_page, '<meta property="og:url" content="', '" />');
        
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
                && (strpos($output, "https://www.udemy.com") !== false) ) {
            
            if (strpos($output, '&amp;')!==false) {
                $output = explode('&amp;', $output)[0];
            }                    
            
            echo $output . "<br>\n";
            fwrite ($scrape_file, $output . "\n") ;
        }


    }
    
}

echo "</div>";

echo "<h1>Done!</h1>";

fclose($scrape_file);

?>