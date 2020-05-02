<?php

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$output_file = "../coupontrump-data/udemy-urls.txt";

require_once 'admin-connect.inc.php';

$scrape_file = fopen($output_file, "a");

$scrape = new scrape();

$page_title = "Scraping Udemy";

echo "<h1>" . $page_title . "</h1>";

$formatted_output = "";
$invalid_list = "";

require_once 'head.inc.php';
require_once 'curl.inc.php';

$site = "https://www.udemy.com/";

echo "<div style='margin-left: 40px;'>";

$cat_query = "SELECT DISTINCT(`cat`) AS `cat` FROM `yourls_url`
                WHERE `course_url` LIKE 'https://www.udemy.com/%'";
                
$cat_stmt = $db->prepare($cat_query);
$cat_stmt->execute();

while ($row = $cat_stmt->fetch(PDO::FETCH_ASSOC)) { // Start of category loop
    
    $cat = urlencode(trim($row['cat']));
    
    $cat = str_replace('+','-',$cat);
    
    echo "<div style='margin-left: 40px;'>";
    
    $subcat_query = "SELECT DISTINCT(`subcat`) AS `subcat` FROM `yourls_url`
                WHERE `course_url` LIKE 'https://www.udemy.com/%' AND `cat` = :cat";
                
    $subcat_stmt = $db->prepare($subcat_query);
    $subcat_stmt->bindParam(":cat", $cat);
    $subcat_stmt->execute();
    
    while ($subrow = $subcat_stmt->fetch(PDO::FETCH_ASSOC)) { // Start of subcategory loop
        
        $subcat = urlencode(trim($subrow['subcat']));
        $subcat = str_replace('+','-',$subcat);
       
        for ($i=1; $i<=2; $i++) {
    
            $url = $site . "courses/" . $cat . "/" . $subcat . "/All-Courses/?page=" . $i;
            
            echo "<h2>" . $url . "</h2>";
            
            $results_page = curl($url);
             
            echo $results_page;
             
            $results_page = scrape_between($results_page, '<html>', '</html>');
            
            //$separate_results = explode('a href="https://www.udemy.com', $results_page);
            //
            //print_r ($separate_results);
            //
            //foreach ($separate_results as $separate_result) {
            //    if ($separate_result != "") {
            //        $base_url = trim(scrape_between($separate_result, 'href="', '</a>'));
            //        if ($base_url!="") {
            //            $link_url = "https://www.udemy.com/" . $base_url;
            //            echo $link_url . "<br>";
            //            fwrite ($scrape_file, $link_url . "\n") ;
            //        }
            //    }
            //}
    
        }
        
    } // End of subcategory loop
    
    echo "</div>";

} // End of category loop

echo "</div>";
    
fclose($scrape_file);

?>