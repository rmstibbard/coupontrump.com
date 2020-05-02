<?php

// INPUT: MySQL query of existing contents of dbase - make sure only Udemy courses are included
// Checks contents of dbase against Udemy and marks invalid coupons as auto_no in dbase field 'active' 

include '../coupontrump-includes/define-constants.inc.php';

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$start_time = date('Y-m-d-H-i');

require_once "admin-connect.inc.php";

$scrape = new scrape();
$make_aff_link = new make_aff_link();
$make_slug = new make_slug();
$page_title = "Check database";

require_once "head.inc.php";
require_once "curl.inc.php";

require "write-log-header.php";

$query = "SELECT * FROM `yourls_url` ";

// Input to check is MySQL query of UDEMY course URLs - NO COUPON CODES!

if ( isset($_GET['featured']) && ($_GET['featured']=="on") ) {
    $query .= " WHERE `featured` = 'yes' ";
    $stmt = $db->prepare($query);
    
} elseif ( isset($_GET['inactive']) && ($_GET['inactive']=="on") ) {
    $query .= " WHERE `active` != 'yes' ";
    $stmt = $db->prepare($query);
    
} elseif ( isset($_GET['id']) && ($_GET['id']!="") ) {
    $id = $_GET['id'];
    $query .= " WHERE `id` = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
  
} elseif ( isset($_GET['course_id']) && ($_GET['course_id']!="") ) {
    $course_id = $_GET['course_id'];
    $query .= " WHERE `course_id` = :course_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':course_id', $course_id);
    
} elseif ( isset ($_GET['coupon']) && ($_GET['coupon']!="") ) {
    $coupon = $_GET['coupon'];
    $query .= " WHERE `coupon` = :coupon";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':coupon', $coupon);
    
} elseif ( isset($_GET['title']) && ($_GET['title']!="") ) {
    $title = $_GET['title'];
    $title = "%" . $title . "%";
    $query .= " WHERE `title` LIKE :title";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':title', $title);
 
} elseif ( isset($_GET['added']) && ($_GET['added']!="") ) {
    $added = "%" . $_GET['added'] . "%";
    $query .= " WHERE `added` LIKE :added";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':added', $added);
    
} elseif ( isset($_GET['slug']) && ($_GET['slug']!="") ) {
    $slug = "%" . $_GET['slug'] . "%";
    $query .= " WHERE `slug` LIKE :slug";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':slug', $slug);
    
} elseif ( isset($_GET['updated']) && ($_GET['updated']!="") ) {
    $updated = $_GET['updated'];
    $query .= " WHERE `updated` <= :updated";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':updated', $updated);
    
} elseif ( isset($_GET['course_url']) && ($_GET['course_url']!="") ) {
    $course_url = "%" . $_GET['course_url'] . "%";
    $query .= " WHERE `course_url` LIKE :course_url";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':course_url', $course_url);
    
} elseif ( isset($_GET['author']) && ($_GET['author']!="") ) {
    $author = "%" . $_GET['author'] . "%";
    $query .= " WHERE `author` LIKE :author";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':author', $author);
    
} elseif ( isset($_GET['cat']) && ($_GET['cat']!="") ) {
    $cat = "%" . urldecode($_GET['cat']) . "%";
    $query .= " WHERE `cat` LIKE :cat";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':cat', $cat);
 
} else {
    $query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%' AND `course_id` IS NOT NULL ";
    $stmt = $db->prepare($query);
    
}

$stmt->execute();
$no_urls = $stmt->rowCount();
$count = 0;

echo "<h1>Checking $no_urls URLs...</h1><br><br>\n\n";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Start of main loop

    $count++;
    $course_url = $row['course_url'];
    $data_in_dbase['coupon_in_dbase'] = $row['coupon'];
    $data_in_dbase['slug_in_dbase'] = $row['slug'];
    $data_in_dbase['coupon'] = $row['coupon'];
    $data_in_dbase['keyword'] = $row['keyword'];
    $data_in_dbase['title_in_dbase'] = $row['title'];
    $data_in_dbase['subtitle_in_dbase'] = $row['subtitle'];
    $data_in_dbase['description_in_dbase'] = $row['description'];
    $data_in_dbase['author_in_dbase'] = $row['author'];
    $data_in_dbase['twitter_in_dbase'] = $row['twitter'];
    $data_in_dbase['review_percent_in_dbase'] = $row['review_percent'];
    $data_in_dbase['ratings_in_dbase'] = $row['ratings'];
    $data_in_dbase['student_no_in_dbase'] = $row['student_no'];
    $data_in_dbase['full_price_in_dbase'] = $row['full_price'];
    $data_in_dbase['reduced_price_in_dbase'] = $row['reduced_price'];
    $data_in_dbase['cat_in_dbase'] = $row['cat'];
    $data_in_dbase['subcat_in_dbase'] = $row['subcat'];
    $data_in_dbase['updated_in_dbase'] = $row['updated'] ;
    
    //extract($existing_data);
    
    if ($data_in_dbase['coupon_in_dbase'] == "") {
       $compound_url = $course_url;
    } else {
       $compound_url = $course_url . "?couponCode=" . $data_in_dbase['coupon_in_dbase'];
    }
    
    $compound_url = preg_replace('/\s+/', ' ', trim($compound_url));
    
    if (strpos($course_url, 'udemy.com/')!==false) {
        $platform = "Udemy";
        $results_page = curl($compound_url); // Downloading the results page using curl() function
        $scraped_data = $scrape->udemy_course_page($results_page);
    }
  
    
    $all_course_data = array_merge($scraped_data, $data_in_dbase);
    $all_course_data['updated'] = date('Y-m-d H:i:s');
    
    if ($row['review_percent'] > 0 ) {
       $all_course_data['calculated_quality'] = ($row['review_percent'] - 50) * $row['ratings'];
    } else {
        $all_course_data['calculated_quality'] = "";
    }    

   
    if ($all_course_data['slug_in_dbase']=="") {
        $all_course_data['slug'] = $make_slug->slug($course_url);
    } else {
        $all_course_data['slug'] = $all_course_data['slug_in_dbase'];
    }
    
    if ($all_course_data['scraped_backend_error'] == "ERROR TRIGGERED!") {
        $style = "alert";
        $all_course_data['notes'] = $all_course_data['scraped_backend_error'];
        $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
        $update = new update($all_course_data);
        $update->inactive($course_url);
        exit;
    }
   
    if ($all_course_data['scraped_private_draft_not_found'] != "") {
        
        $style = "alert";
        $all_course_data['notes'] = $all_course_data['scraped_private_draft_not_found'];
        $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
        $update = new update($all_course_data);
        $update->inactive($course_url);
                
    } elseif ($all_course_data['scraped_full_price'] > 20) { //  Greater than $20
        if (($all_course_data['scraped_reduced_price'] == "") || ($all_course_data['scraped_reduced_price'] >= $all_course_data['scraped_full_price']) ) {
            $style = "alert";
            $all_course_data['notes'] = "INVALID COUPON ";
            $all_course_data['coupon'] = '';
            $all_course_data['url'] = '';
            $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
            $update = new update($all_course_data);
            $update->inactive($course_url);            
             
        } elseif ($all_course_data['scraped_reduced_price'] < $all_course_data['scraped_full_price']) {
            $style = "ok";
            $all_course_data['notes'] = "VALID COUPON";
            if ($all_course_data['coupon']=="") {
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($compound_url);
            } else {
                $all_course_data['url'] = $make_aff_link->udemy_with_coupon($compound_url);
            }
            $update = new update($all_course_data);
            $update->active($course_url);
        }
        
    } else  { // $20 or less
        if ($all_course_data['scraped_full_price'] == 0) {
            $style = "ok";
            $all_course_data['notes'] = "FREE COURSE";
            if ($all_course_data['coupon']=="") {
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($compound_url);
            } else {
                $all_course_data['url'] = $make_aff_link->udemy_with_coupon($compound_url);
            }
            $update = new update($all_course_data);
            $update->active($course_url);
                
        } elseif ( ($all_course_data['scraped_reduced_price'] == $all_course_data['scraped_full_price']) ) {
            $style = "ok";
            $all_course_data['notes'] = "COURSE PRICE IS $20 OR LESS - COUPON NOT NEEDED";
            $all_course_data['coupon'] = '';
            $all_course_data['url'] = $make_aff_link->udemy_no_coupon($compound_url);
            $update = new update($all_course_data);
            $update->active($course_url);
        
        } elseif ( ($all_course_data['scraped_reduced_price'] == "") || ($all_course_data['scraped_reduced_price'] >= $all_course_data['scraped_full_price']) ) {
            $style = "ok";
            $all_course_data['notes'] = "COURSE PRICE IS $20 OR LESS";
            if ($all_course_data['coupon']=="") {
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($compound_url);
            } else {
                $all_course_data['url'] = $make_aff_link->udemy_with_coupon($compound_url);
            }            
            $update = new update($all_course_data);
            $update->active($course_url);
            
        } elseif ($all_course_data['scraped_reduced_price'] < $all_course_data['scraped_full_price'] ) {
            $style = "ok";
            $all_course_data['notes'] = "VALID COUPON";
            if ($all_course_data['coupon']=="") {
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($compound_url);
            } else {
                $all_course_data['url'] = $make_aff_link->udemy_with_coupon($compound_url);
            }
            $update = new update($all_course_data);
            $update->active($course_url);
            
        }
        
    }
    
    require "formatted-output.inc.php";
    require "write-log-data.php";
   
} // End of main loop


$cleanup_query = "UPDATE `yourls_url` SET `active` = :auto_no
    WHERE (`url` = :empty OR `keyword` = :empty OR `title` = :empty OR `author` = :empty)";

$cleanup_stmt = $db->prepare($cleanup_query);
$cleanup_stmt->bindValue(':auto_no', 'auto_no');
$cleanup_stmt->bindValue(':empty', '');
$cleanup_stmt->execute();

require "write-footers.php";

foreach (glob("../check-database*") as $filename) {
   unlink(realpath($filename));
}

unset($check_database)

?>