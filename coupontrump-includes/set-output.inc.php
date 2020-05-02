<?php

if ($filename=="index.php") {
    
    $page_output = '';
	
//	 $page_output .= "<div class='shoutout'>\n";
//        $page_output .= "<h2>CouponTrump.com is for sale!</h2>\n";
//        $page_output .= "<h3><a target='_blank' 
//		href='https://www.namecheap.com/domains/marketplace/buy-domains?page=&size=&keyword=coupontrump'>Buy this domain on Namecheap Marketplace</a></h3>\n";
//        $page_output .= "</div>\n";
    
    if (defined('SPECIAL_OFFER')) {
        $page_output .= "<div style='text-align: center'>";
        $page_output .= "<a href='http://coupontru.mp/" . strtolower(SPECIAL_OFFER) . "' target='_blank'><img src='" . SPECIAL_OFFER_IMAGE . "'></a>";
        $page_output .= "</div>";
    }
    
    if ($slug!="") {
        $page_output .= $results->single_course($slug)['course_list'];
        $title_string = $results->single_course($slug)['title'];
        $og_image_string = $results->single_course($slug)['og_image'];
        
    } elseif ($id!="") {
        $page_output .= $results->course_by_id($id)['course_list'];
        $title_string = $results->course_by_id($id)['title'];
        $og_image_string = $results->course_by_id($id)['og_image'];
    
    } elseif ($sort=="deal"){
        $page_output .= $results->deal($time_to_run, $expiring_time_to_run)['course_list'];
        $title_string = $results->deal($time_to_run, $expiring_time_to_run)['title'];
       
    } elseif ($sort=="latest"){
        $page_output .= $results->latest($minprice, $maxprice)['course_list'];
        $title_string = $results->latest($minprice, $maxprice)['title'];
       
    } elseif ($sort=="pop") {
        $page_output .= $results->pop($minprice, $maxprice)['course_list'];
        $title_string = $results->pop($minprice, $maxprice)['title'];
        
    } elseif ($sort=="ratings") {
        $page_output .= $results->ratings($minprice, $maxprice)['course_list'];
        $title_string = $results->ratings($minprice, $maxprice)['title'];
        
    } elseif ($trending=="yes") {
        $page_output .= $results->trending();
        $title_string = "Udemy courses trending now on CouponTrump";

    //} elseif ($recently_updated=="yes") {
    //    $page_output .= $results->recently_updated();
    //    $title_string = "Udemy courses recently updated on CouponTrump";
    //
    } elseif ( ($author=="") && ($keywords=="") && ($subcat=="") && ((is_numeric($maxprice)) && ($maxprice==0)) ) {
        $page_output .= $results->free()['course_list'];
        $title_string = $results->free()['title'];
    
    } elseif ( ($author=="") && ($keywords=="") && ($subcat=="") && ((is_numeric($minprice)) || (is_numeric($maxprice))) ) {
        $page_output .= $results->price($minprice, $maxprice)['course_list'];
        $title_string = $results->price($minprice, $maxprice)['title'];

    } elseif ($subcat!="") {
        $page_output .= $results->subcat($cat, $subcat, $order, $maxprice)['course_list'];
        $title_string = $results->subcat($cat, $subcat, $order, $maxprice)['title'];
        
    } elseif ( ($author!="") && ($keywords!="") ) {        // Author and keywords BOTH set
        $page_output .= $results->author_keywords($author, $keywords, $order, $maxprice)['course_list'];
        $title_string = $results->author_keywords($author, $keywords, $order, $maxprice)['title'];
        
    } elseif ( ($author=="") && ($keywords!="") ) {  // Keywords set - author NOT set
        $page_output .= $results->keywords($keywords, $order, $maxprice)['course_list'];
        $title_string = $results->keywords($keywords, $order, $maxprice)['title'];
    
    } elseif ( ($author!="") && ($keywords=="") ) {  // Author set - keywords NOT set
        $page_output .= $results->author($author, $order, $maxprice)['course_list'];
        $title_string = $results->author($author, $order, $maxprice)['title'];
    
    } elseif ( ($author!="") && ($keywords=="") && ($subcat=="") && ($maxprice!="") ) {
        $page_output .= $results->price($maxprice)['course_list'];
        $title_string = $results->price($maxprice)['title'];    
    
    } elseif (($author=="") || ($keywords=="") || ($subcat=="") ){
                     
        $page_output .= $results->featured()['course_list'];
        $title_string = $results->featured()['title'];
        
        if (isset($_COOKIE['featured_authors'])) {
            $page_output .= $results->featured_authors();
        }
        
        if (isset($_COOKIE['featured_subcats'])) {
            $page_output .= $results->featured_subcats();
        }
        
        if (isset($_COOKIE['featured_keywords'])) {
            $page_output .= $results->featured_keywords();
        }    
        
        
        
        $page_output .= $results->pop($minprice, $maxprice)['course_list'];
        
        if ((!isset($_COOKIE['featured_subcats'])) &&
            (!isset($_COOKIE['featured_keywords'])) &&
            (!isset($_COOKIE['featured_authors']))  ) {
                $page_output .= $results->latest($minprice, $maxprice)['course_list'];
        }
                
    }
} 
?>