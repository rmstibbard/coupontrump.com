<?php

ini_set('max_execution_time', 0);

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

require_once 'scrape-variables.inc.php';

$output_file = "../coupontrump-data/add-new.txt";

$scrape_file = fopen($output_file, "a");

$scrape = new scrape();

$page_title = "Scrape One Buck Courses";

echo "<h1>" . $page_title . "</h1>";

$formatted_output = "";
$invalid_list = "";

require_once 'head.inc.php';
require_once 'curl.inc.php';


$site = "onebuckcourses.com";

$endings = array ("/1-buck-udemy-courses/");

echo "<div style='margin-left: 40px;'>";

foreach ($endings as $ending ) {
    
    for ($i=$from; $i<=$to; $i++) {
    
        $url = $site . $ending . "?pagenum=" .  $i;
        
        $results_page = curl($url);
        
        $results_page = scrape_between($results_page, '<table class="gv-table-view">', '</table>');
        
        $separate_results = explode('<td class="gv-field-1-8">', $results_page);
        
        
        foreach ($separate_results as $separate_result) {
            
            if ($separate_result != "") {
            
                $base_url = trim(scrape_between($separate_result, '/udemycourse/', '">'));
                
               
                if ($base_url!="") {
                    
                    $link_url = "http://onebuckcourses.com/udemycourse/" . $base_url;
                    
                    $udemy_page = curl($link_url);
                    
                    $udemy_url = scrape_between($udemy_page, '<meta property="og:url" content="', '" />');
                    $coupon = scrape_between($udemy_page, '?couponCode=', '"');
                   
                    if ($coupon!="") {
                        $output = $udemy_url . "?couponCode=". $coupon. "\n";
                    } else {
                        $output = $udemy_url . "\n";
                    }
                    
                    if ( ($output!="?couponCode=,")
                            && ($output!="") && ($output!=",")
                            && (strpos($output, "/courses/") === false) 
                            && (strpos($output, "/courses/featured") === false) 
                            && (strpos($output, "/draft/") === false)
                            && (strpos($output, "https://www.udemy.com/") !== false) ) {
                        
                        if (strpos($output, '&amp;')!==false) {
                            $output = explode('&amp;', $output)[0];
                        }
                        
                        if (strpos($output, 'https://www.udemy.com/')!==false) {
                            echo $output . "<br>\n";
                            fwrite ($scrape_file, $output . "\n") ;
                        }
                    }
                }
    
            }
            
        }
    
    }
}

echo "</div>";

echo "<h1>Done!</h1>";

fclose($scrape_file);

?>