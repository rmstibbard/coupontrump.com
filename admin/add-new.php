<?php

// INPUT: Text file, 'add-new.txt', containing course urls with ?couponCode=CODE appended
// Adds new courses to dbase
// Checks dbase - adds courses not there already, creating random keyword
// If course already exists in dbase, replaces coupon and reduced price only if new price
// is lower than existing one

include '../coupontrump-includes/define-constants.inc.php';

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

$start_time = date('Y-m-d-H-i');
$mail_message = "";

$page_title = "Adding New Courses...";
$input_file = "../coupontrump-data/add-new.txt";

require_once "head.inc.php";

if (file_exists($input_file)) {
    if (filesize($input_file) == 0) {
        echo "<h2 class='alert'>No new courses in input file</h2>\n";
        exit;
    }
} else {
    echo "<h2 class='alert'>No input file found</h2>\n";
    exit;    
}

require_once "admin-connect.inc.php";

$search_course = new search_course();
$scrape = new scrape();
$make_aff_link = new make_aff_link();
$make_slug = new make_slug();

$formatted_output = "";
$invalid_list = "";

require_once "curl.inc.php";

require "write-log-header.php";

// Open the add-new file
$add_new_file = fopen($input_file, 'r');

// Add each line to an array
if ($add_new_file) {
   $compound_urls = explode("\n", fread($add_new_file, filesize($input_file)));
}

$invalid_url = array_search('https://www.udemy.com/courses/', $compound_urls);
if($invalid_url !== FALSE){
    unset($compound_urls[$invalid_url]);
}

$invalid_url = array_search('https://www.udemy.com/courses/featured/', $compound_urls);
if($invalid_url !== FALSE){
    unset($compound_urls[$invalid_url]);
}


$compound_urls = array_unique(array_filter($compound_urls));
$no_urls = sizeof($compound_urls);
$count = 0;
$new_courses = 0;

if ($count==1) {
    echo "<h1>Adding " . $no_urls . " course</h1><br>";
} else {
    echo "<h1>Adding " . $no_urls . " courses</h1><br>";
}

foreach ($compound_urls as $compound_url) {
    
    if (strpos($compound_url, 'http://click.linksynergy.com')!==false) {
        $compound_url = explode('RD_PARM1=', $compound_url)[1];
        $compound_url = urldecode($compound_url);
    }

    if (strpos($compound_url, '%3Fdtcode')!==false) {
        $compound_url = explode('%3Fdtcode', $compound_url)[0];
    }

    if (strpos($compound_url, '?dtcode')!==false) {
        $compound_url = explode('?dtcode', $compound_url)[0];
    }
    
    if (strpos($compound_url, '#')!==false) {
        $compound_url = explode('#', $compound_url)[0];
    }
    
    if (strpos($compound_url, '%2526')!==false) {
        $compound_url = explode('%2526', $compound_url)[0];
    }
    
    if (strpos($compound_url, '&siteID')!==false) {
        $compound_url = explode('&siteID', $compound_url)[0];
    }

    if (strpos($compound_url, '?siteID')!==false) {
        $compound_url = explode('?siteID', $compound_url)[0];
    }

    if (strpos($course, '&couponCode')!==false) {
        $course = explode('?couponCode', $course)[0];
    }    
    
    if (strpos($compound_url, '&')!==false) {
        $compound_url = explode('&', $compound_url)[0];
    }		

    if (strpos($compound_url, 'udemy.com//')!==false) {
        $compound_url = str_replace('udemy.com//', 'udemy.com/',$compound_url);
    }
    
    $compound_url = preg_replace('/\s+/', ' ', trim($compound_url));
    
    if ( ($compound_url!="")
            && (strpos($compound_url, "https://www.udemy.com") !==false)
            && (strpos($compound_url, "/draft/") === false)
            && (strpos($compound_url, "/courses/") === false)
            && (strpos($compound_url, "/courses/featured/") === false) ) {
    
        $count++;
        
        if (strpos($compound_url,"?couponCode=")!=false) {
            
            $url_parts = explode("?couponCode=",$compound_url);
            $course_url = $url_parts[0];
            $coupon = $url_parts[1];

            
            if (substr($coupon,-1)=='"') {
                $coupon = rtrim($coupon, '"');
            }

            $url = $make_aff_link->udemy_with_coupon($compound_url);
    
        } else {
            $course_url = $compound_url;
            $coupon = "";
            $url = $make_aff_link->udemy_no_coupon($course_url);
        }
        
        if (substr($course_url,-1)!="/") {
            $course_url .= "/";
        }
        
        if (substr($course_url,-7)=="/learn/") {
            $course_url = substr($course_url, 0, -7);
        }
        
      
        $results_page = curl($compound_url); // Downloading the results page using curl() function
        $scraped_data = $scrape->udemy_course_page($results_page);
        
        $data_in_dbase = $search_course->find($course_url);
        $all_course_data = array_merge($data_in_dbase, $scraped_data);
        
        if ($all_course_data['scraped_lost']=='LOST') {
           echo "<p class='alert'>COURSE NOT FOUND: " . $course_url . "</p>";
        }
    
        if ($all_course_data['scraped_reduced_price'] >= $all_course_data['scraped_full_price']) {
            $coupon = '';
            $url = $make_aff_link->udemy_no_coupon($course_url);
        } else {
            $url = $make_aff_link->udemy_with_coupon($compound_url);
        }
        
        $all_course_data['coupon'] = $coupon;
        $all_course_data['url'] = $url;
        
        if ($all_course_data['review_percent'] > 0 ) {
           $all_course_data['calculated_quality'] = ($all_course_data['review_percent'] - 50) * $all_course_data['ratings'];
        } else {
            $all_course_data['calculated_quality'] = "";
        }    
        
        if ($all_course_data['keyword_in_dbase'] != false) {
            $all_course_data['keyword'] = $all_course_data['keyword_in_dbase'];
        } else {
            $all_course_data['keyword'] = substr(str_shuffle(MD5(microtime())), 0, 8);
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
            $all_course_data['notes'] = $all_course_data['scraped_private_draft_not_found'];
            $style = "alert";
            $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
            
            if ($all_course_data['course_exists'] != "NO") {
                $update = new update($all_course_data);
                $update->inactive($course_url);
            } 
        
        } elseif ($all_course_data['course_exists'] == "NO") {  // Does not exist in dbase - use INSERT; no need for checks
            
            if (($all_course_data['scraped_full_price'] == 0 && $all_course_data['scraped_reduced_price'] == 0)) {
                $all_course_data['notes'] = "NEW COURSE - FREE";
                $style = "new";
                $all_course_data['coupon'] = "";
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($course_url);                
                $insert = new insert($all_course_data);
                $insert->active($course_url);
                $new_courses++;
                $mail_message .= "NEW COURSE - FREE: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                            
            } elseif (($all_course_data['scraped_reduced_price'] != "") && ($all_course_data['scraped_full_price'] <= 20) && ($all_course_data['scraped_reduced_price'] <= 20) ) {
                $all_course_data['notes'] = "NEW COURSE - $20 OR LESS";
                $style = "new";
                $insert = new insert($all_course_data);
                $insert->active($course_url);
                $new_courses++;
                $mail_message .= "New course - $20 or less: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                            
            } elseif ($all_course_data['scraped_reduced_price'] >= $all_course_data['scraped_full_price'] ) {
                $all_course_data['notes'] = "NEW COURSE - NO VALID COUPON";
                $style = "alert";
                $insert = new insert($all_course_data);
                $insert->inactive($course_url);
                $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
                
            } else {
                $all_course_data['notes'] = "NEW COURSE - VALID COUPON";
                $style = "new";
                $insert = new insert($all_course_data);
                $insert->active($course_url);
                $new_courses++;
                $mail_message .= "NEW COURSE - VALID COUPON: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                
            }

        
        } else { // Course EXISTS in database - need to check validity of coupon_in_dbase and reduced_price_in_dbase   
            if (($all_course_data['scraped_full_price'] == 0 && $all_course_data['scraped_reduced_price'] == 0)) {
                $all_course_data['notes'] = "EXISTING COURSE - FREE";
                $style = "ok";
                $all_course_data['coupon'] = "";
                $all_course_data['url'] = $make_aff_link->udemy_no_coupon($course_url);                
                $update = new update($all_course_data);
                $update->active($course_url);
                $mail_message .= "Existing course - Free: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                            
            } elseif (($all_course_data['scraped_reduced_price'] != "") && ($all_course_data['scraped_full_price'] <= 20) && ($all_course_data['scraped_reduced_price'] <= 20) ) {
                $all_course_data['notes'] = "EXISTING COURSE - $20 OR LESS";
                $style = "ok";
                $update = new update($all_course_data);
                $update->active($course_url);
                $mail_message .= "Existing course - $20 or less: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                            
            }  elseif ($all_course_data['scraped_reduced_price'] >= $all_course_data['scraped_full_price'] ) {
                $results_page_in_dbase = curl($data_in_dbase['url_in_dbase']);
                $scrape_in_dbase = $scrape->udemy_course_page($results_page_in_dbase);
                
                if ( ($scrape_in_dbase['scraped_reduced_price'] != "") && ($scrape_in_dbase['scraped_reduced_price'] < $all_course_data['scraped_reduced_price']) ) {
                    $all_course_data['scraped_reduced_price'] = $scrape_in_dbase['scraped_reduced_price'];
                    $all_course_data['notes'] = "EXISTING COURSE - COUPON IN DATABASE IS CHEAPER - NOT CHANGED";
                    $all_course_data['coupon'] = $data_in_dbase['coupon_in_dbase'];
                    $all_course_data['url'] = $data_in_dbase['url_in_dbase'];
                    $style = "ok";
                    $update = new update($all_course_data);
                    $update->active($course_url);
                    $mail_message .= "Existing course - Coupon in database is cheaper: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                                    
                } elseif ( ($scrape_in_dbase['scraped_reduced_price'] == "") || ($scrape_in_dbase['scraped_reduced_price'] >= $all_course_data['scraped_reduced_price']) ) {
                    $all_course_data['notes'] = "EXISTING COURSE - NO VALID COUPON";
                    $style = "alert";
                    $update = new update($all_course_data);
                    $update->inactive($course_url);
                    $invalid_list .= $course_url . "," . $all_course_data['notes'] . "<br>\n";
                    
                } else {
                    $all_course_data['notes'] = "EXISTING COURSE - VALID COUPON";
                    $style = "ok";
                    $update = new update($all_course_data);
                    $update->active($course_url);
                    $mail_message .= "EXISTING COURSE - VALID COUPON: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                                    
                }
            
            }  elseif ($all_course_data['reduced_price_in_dbase'] < $all_course_data['scraped_reduced_price'] ) {
                $results_page_in_dbase = curl($data_in_dbase['url_in_dbase']);
                $scrape_in_dbase = $scrape->udemy_course_page($results_page_in_dbase);
            
                if ( ($scrape_in_dbase['scraped_reduced_price'] != "") && ($scrape_in_dbase['scraped_reduced_price'] < $all_course_data['scraped_reduced_price']) ) {
                    $all_course_data['scraped_reduced_price'] = $scrape_in_dbase['scraped_reduced_price'];
                    $all_course_data['notes'] = "EXISTING COURSE - COUPON IN DATABASE IS CHEAPER - NOT CHANGED";
                    $all_course_data['coupon'] = $data_in_dbase['coupon_in_dbase'];
                    $all_course_data['url'] = $data_in_dbase['url_in_dbase'];
                    $style = "ok";
                    $update = new update($all_course_data);
                    $update->active($course_url);
                    $mail_message .= "EXISTING COURSE - COUPON IN DATABASE IS CHEAPER: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                                
                } elseif ( ($scrape_in_dbase['scraped_reduced_price'] == "") || ($scrape_in_dbase['scraped_reduced_price'] >= $all_course_data['scraped_reduced_price']) ) {
                    $all_course_data['notes'] = "EXISTING COURSE - CHEAPER COUPON INSERTED";
                    $style = "ok";
                    $update = new update($all_course_data);
                    $update->active($course_url);
                    $mail_message .= "EXISTING COURSE - CHEAPER COUPON INSERTED: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                                    
                }
            
            }  else {
                $all_course_data['notes'] = "EXISTING COURSE - VALID COUPON";
                $style = "ok";
                $update = new update($all_course_data);
                $update->active($course_url);
                $mail_message .= "COUPON UPDATED: http://www.coupontrump.com/?course=" . $all_course_data['slug'] . "\n";
                
            }
        }
        
        require "formatted-output.inc.php";
                
        require "write-log-data.php";
        
    }

}

if ($mail_message!="") {
    include 'mail.inc.php';
}

require "write-footers.php";

fclose($add_new_file);

$delete_contents = fopen($input_file, 'w');
fwrite ($delete_contents, '') ;
fclose ($delete_contents);

foreach (glob("../add-new*") as $filename) {
   unlink(realpath($filename));
}

?>