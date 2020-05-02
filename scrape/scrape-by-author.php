<?php

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$output_file = "../coupontrump-data/add-new.txt";
$log = "../coupontrump-logs/scrape-by-author.csv";

require_once 'admin-connect.inc.php';

$scrape_file = fopen($output_file, "a");
$log_file = fopen($log, "a");

$scrape = new scrape();

if (isset($_GET['add_coupon'])) {
    $add_coupon = $_GET['add_coupon'];
} else {
    $add_coupon = "";
}

if ( (isset($_GET['author_page']))  && ($_GET['author_page'] != "") )   {
    $author_pages[] = $_GET['author_page'];
    fwrite ($log_file, "Search for author page " . $_GET['author_pages'] . "\n") ;
    
} elseif ( (isset($_GET['author']))  && ($_GET['author'] != "") )   {
    $author_match = "%" . $_GET['author'] . "%";
    fwrite ($log_file, "Search for author " . $_GET['author'] . "\n") ;
        
    $query = "SELECT * FROM `yourls_url` WHERE `author` LIKE :author_match";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':author_match', $author_match);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $author_pages[] = $row['author_page'];
        $author[] = $row['author'];
    }
        
} else {
    $query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $author_pages[] = $row['author_page'];
    }

}
$page_title = "Finding courses by author " . $_GET['author'];

require_once 'head.inc.php';
require_once 'curl.inc.php';

echo "<h1>" . $page_title . "</h1>";

$author_pages = array_unique($author_pages);

if (sizeof($author_pages)>0) {

    foreach ($author_pages as $author_page) {
 
    echo "<h2>Scraping author page " . $author_page . "</h2>\n";
    
        for ($page_no=1; $page_no<=1000; $page_no++)  {
    
            if ($page_no==1) {
                $url = "https://www.udemy.com/u/" . $author_page;
            } else {
                $url = "https://www.udemy.com/u/" . $author_page . "?taught_courses=" . $page_no . "&key=taught_courses";
            }
            
            echo "\t<div style='margin-left: 30px;'><strong>Scraping page " . $url . "  <a target='_blank' href='" . $url . "'>Link</a></strong><br>";
                
            $results_page = curl($url);
          
            $results_page = scrape_between($results_page, '<ul class="course-cards-container"', '</ul>');
            
            $separate_results = explode('<li', $results_page);
            
            foreach ($separate_results as $separate_result) {
                    
                if ($separate_result != "") {
                
                    $base_url = trim(scrape_between($separate_result, '<a href="/', '"><div class="card__image">'));
                    
                    if ($base_url!="") {
                        
                        $check_url = "https://www.udemy.com/" . $base_url;
                        
                        if (strpos($check_url,'/draft/')===false) {
                            $check_query = "SELECT * FROM `yourls_url` WHERE `course_url` = :check_url";
                            $stmt = $db->prepare($check_query);
                            $stmt->bindParam(':check_url', $check_url);
                            $stmt->execute();
                            $count = $stmt->rowCount();
                            
                            if ($add_coupon!="") {
                                $output = $check_url . "?couponCode=" . $add_coupon;
                            } else {
                                $output = $check_url;
                            }
            
                            if ($count==0) {
                                echo "\t\t<div style='margin-left: 30px; color: green;'>\n";
                                echo "New course: " . $output . "  <a target='_blank' href='" . $output .  "'>Link</a><br>";
                                echo "\t\t</div>\n\n";
                                fwrite ($scrape_file, $output . "\n") ;
                                fwrite ($log_file, ",New course," . $output . "\n") ;
                            } else {
                                echo "\t\t<div style='margin-left: 30px; color: grey;'>\n";
                                echo "Already in database: " . $output . "  <a target='_blank' href='" . $output .  "'>Link</a><br>";
                                echo "\t\t</div>\n\n";
                                fwrite ($log_file, ",Already in database, " . $output . "\n") ;
                            }
                        }
                    }
                }
            }
            
            echo "\t</div>";
        
            $pagination = curl($url);
            $pagination = scrape_between($pagination, 'ul class="pagination"', '</ul>');
            
            if (strpos($pagination, 'Next')===false) {
                $page_no = 10001;
            }
        
        }

    }
  
}

echo "</div>";

echo "<h1>Done!</h1>";
echo "<h2><a href='../admin/add-new.php'>Add new</a></h2>";
echo "<h2><a href='../admin/admin-panel.php'>Back to admin panel</a></h2>";

fclose($scrape_file);
fclose($log_file);

?>

