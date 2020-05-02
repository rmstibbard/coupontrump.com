<?php

class scrape {

    public function udemy_course_page($results_page) {
        
                
        $scraped_title = scrape_between($results_page, '<title>','</title>');
        
        if ($scraped_title=="") {
            $scraped_title = scrape_between($results_page, 'data-purpose="course-title">', '</h1>');
        }
        
        if (substr($scraped_title, -8) == " - Udemy") {
            $scraped_title = substr($scraped_title, 0, -8);
        }
        
        if (substr($scraped_title, -8) == " | Udemy") {
            $scraped_title = substr($scraped_title, 0, -8);
        }
        
        $scraped_title = str_ireplace(">", "&gt;", $scraped_title);
        $scraped_title = str_ireplace("<", "&lt;", $scraped_title);
                
        if ( (strpos($scraped_title, '503')!==false) && (strpos($scraped_title, 'error')!==false) ) {
            $scraped_backend_error = "ERROR TRIGGERED!";
            $notes = "ERROR TRIGGERED!";
            continue;
        } else {
            $scraped_backend_error = "";
        }
        
        $scraped_lost = scrape_between($results_page, 'div class="seems">','</div>');
        
        if (strpos($scraped_lost, 'a bit lost')!==false) {
            $scraped_lost = 'LOST';
            return array ('scraped_lost' => trim($scraped_lost));
        }
        
        $scraped_private_course = scrape_between($results_page, '<div class="private-course-area">', '</div>');
        $scraped_draft_mode = scrape_between($results_page, '<div id="draft-notice">', '</div>');
        
        $scraped_unfinished = scrape_between($results_page,'<div class="alert alert-warning mb0" role="alert">','</div>');
        
        $scraped_unavailable = scrape_between($results_page,'<span data-purpose="course-suspended-warning">','</div>');
        
        $scraped_removed = scrape_between($results_page, '<h4 class="media-heading">', '</h4>');
        
        if (strpos($scraped_unavailable, 'This course is currently unavailable')!==false) {
            $scraped_private_draft_not_found = "UNAVAILABLE";
        }
        
        if (strpos($scraped_removed, 'the content for this course has been removed')!==false) {
            $scraped_private_draft_not_found = "REMOVED";
        }
        
        if (strpos($scraped_removed, 'is no longer available to purchase on the Udemy platform')!==false) {
            $scraped_private_draft_not_found = "REMOVED";
        }        
        
        if ($scraped_unfinished!="") {
            $scraped_private_draft_not_found = "UNFINISHED";
        }
       
        if ($scraped_draft_mode!="") {
            $scraped_private_draft_not_found = "DRAFT MODE";
        } 
        
        if ($scraped_private_course!="") {
            $scraped_private_draft_not_found = "PRIVATE COURSE";
        } 
        
        if ($scraped_title == "Page Not Found") {
            $scraped_private_draft_not_found = "COURSE NOT FOUND";
        }
        
        if (!isset($scraped_private_draft_not_found)) {
            $scraped_private_draft_not_found = "";
        }
        
                
        $scraped_password = scrape_between($results_page,'data-purpose="take-this-course-button"','</a>');
        
        if (strpos($scraped_password,"Enter Password")!==false) {
            $scraped_private_draft_not_found = "Password protected";
        }
        
        $scraped_course_id = scrape_between($results_page,'data-course-id="', '">');
        
        $scraped_image_url = scrape_between($results_page, '<meta property="og:image" content="','>');
        $scraped_image_url = str_replace('480x270','304x171',$scraped_image_url);
        $scraped_image_url = str_replace('200_H','304x171',$scraped_image_url);
        $scraped_image_url = str_replace('" /','',$scraped_image_url);
        $scraped_image_url = str_replace('"','',$scraped_image_url);
        
        $scraped_subtitle = trim(scrape_between($results_page, 'data-purpose="course-headline">','</div'));
        
        if ($scraped_subtitle == "") {
            $scraped_subtitle = trim(scrape_between($results_page, '<div class="clp-lead__headline">', '</div>'));
        }
        
        
        if ($scraped_subtitle == "") {
            $scraped_subtitle = trim(scrape_between($results_page, '<meta name="description" content="', '">'));
        }
        
      
        
        
        $scraped_author = scrape_between($results_page, '"instructor": [{"name": "', '"');
        
        if ($scraped_author == "") {
            $scraped_author = scrape_between($results_page, 'class="thb-n prox ud-popup">', '</a>');
        }

        if ($scraped_author == "") {
            $scraped_author = trim(strip_tags(scrape_between($results_page, 'Created by', '</span>')));
        }
        
        if ($scraped_author == "") {
            $scraped_author = scrape_between($results_page, '"instructor": [{' , ']}');
        }
        
        if ($scraped_author == "") {
            $scraped_author = scrape_between($results_page, 'class="instructor-links__link">' , '</a>');
        }

        $scraped_author = trim(preg_replace('/\s+/', ' ', $scraped_author));
        $scraped_author = str_replace('Created by', '', $scraped_author);
        $scraped_author = strip_tags($scraped_author);
        $scraped_author = trim($scraped_author);
                
        
        $scraped_twitter = scrape_between($results_page, '<a href="https://twitter.com/', 'target="_blank"');
        $scraped_twitter = str_replace('"','',$scraped_twitter);
        
        if (strpos($scraped_twitter, '?')!==false) {
            $scraped_twitter = explode('?', $scraped_twitter)[0];
        }
               
        if (strpos($scraped_twitter, '>')!==false) {
            $scraped_twitter = explode('>', $scraped_twitter)[1];
        }
       
        $scraped_twitter = str_replace('https://','',$scraped_twitter);
        $scraped_twitter = str_replace('twitter.com/','',$scraped_twitter);
        $scraped_twitter = str_replace('?lang=en','',$scraped_twitter);
        $scraped_twitter = str_replace('&amp;src=typd','',$scraped_twitter);
        $scraped_twitter = str_replace('rel=nofollow','',$scraped_twitter);
        $scraped_twitter = str_replace('search?q=%23','',$scraped_twitter);
        $scraped_twitter = str_replace('#%21/','',$scraped_twitter);
        $scraped_twitter = str_replace('style=','',$scraped_twitter);
        $scraped_twitter = str_replace('noreferrer','',$scraped_twitter);
        $scraped_twitter = str_replace('/','',$scraped_twitter);
        $scraped_twitter = str_replace('@','',$scraped_twitter);
        $scraped_twitter = str_replace('<a','',$scraped_twitter);

        if ($scraped_twitter == "Twitter Profile") {
            $scraped_twitter = "";
        }
       
        if (strpos($scraped_twitter,"share class=twitter-share-button")!==false) {
            $scraped_twitter="";
        }
        
        
        $scraped_author_id = scrape_between($results_page, 'u/view-popup/?userId=', '" class=');
        
        $scraped_author_page = scrape_between($results_page, '<meta property="udemy_com:instructor" content="https://www.udemy.com/user/', '/">');

        
        
        

        
        $scraped_full_price = trim(scrape_between($results_page,'>Price:</span>','</span>'));
        $scraped_full_price = str_replace('$','',$scraped_full_price);
        
        if (strpos($scraped_full_price, "Free") !== false) {
            $scraped_full_price = "0";
        }
        
        if (!is_numeric($scraped_full_price)) {
        
            $scraped_full_price = trim(scrape_between($results_page,'>Original price:</span>','</span>'));
            $scraped_full_price = str_replace('$','',$scraped_full_price);
            
            $scraped_reduced_price = trim(scrape_between($results_page,'>Current price:</span>','</span>'));
            $scraped_reduced_price = str_replace('$','',$scraped_reduced_price);
    
            
            if (strpos($scraped_reduced_price, "Free") !== false) {
                $scraped_reduced_price = "0";
            }
        }  
        
        if ( ($scraped_full_price=='') && ($scraped_reduced_price!="") ) {
            $scraped_full_price = $scraped_reduced_price;
            $scraped_reduced_price = '';
        }
        
        if ( ($scraped_full_price!='') && ($scraped_reduced_price=='') ) {
            $scraped_reduced_price=$scraped_full_price;
        }
        
        
        if ($scraped_draft_mode!="") {
            $scraped_draft_mode = "DRAFT MODE";
            $scraped_reduced_price = "";
            $scraped_full_price = "";
            
        } elseif ($scraped_private_course!="") {
            $scraped_private_course = "PRIVATE COURSE";
            $scraped_reduced_price = "";
            $scraped_full_price = "";
        }
        
        $scraped_cat = trim(scrape_between($results_page, '<a class="cd-ca" href="/courses/', '/">'));
        $scraped_cat = str_replace('&amp;', 'and', $scraped_cat);
        $scraped_cat = str_replace('-', ' ', $scraped_cat);
        $scraped_cat = trim($scraped_cat);
        
        $scraped_subcat = scrape_between($results_page, '<a class="" href="/courses/', '</a>');
        
        if (strpos($scraped_subcat, '/"')!==false) {
            $scraped_subcat = explode('/"',$scraped_subcat)[1];
        }
        
        $scraped_subcat = str_replace('>', '', $scraped_subcat);
        $scraped_subcat = str_replace('&amp;', 'and', $scraped_subcat);
        $scraped_subcat = str_replace('-', ' ', $scraped_subcat);
        $scraped_subcat = trim($scraped_subcat);
        
        $scraped_description = scrape_between($results_page, '<div data-more="Full details"','<div id="requirements"');
        
        $scraped_description = str_replace('class="js-simple-collapse"', "", $scraped_description);
        $scraped_description = str_replace('data-purpose="collapse-description-btn"', "", $scraped_description);
        $scraped_description = str_replace('style="max-height:195px"', "", $scraped_description);
        $scraped_description = str_replace(' >', "", $scraped_description);
        $scraped_description = trim(str_replace('  ', " ", $scraped_description));
        
        $scraped_reviews = scrape_between($results_page, '<span style="width: ' , '%');
        $scraped_review_percent = intval(trim($scraped_reviews));
        
        if ($scraped_review_percent== '') {
            $scraped_review_percent = 0;
        }
        
         
        $scraped_author_description = scrape_between($results_page, 'data-more="Full biography"' , '</div>');
        $scraped_author_description = trim($scraped_author_description,"\n");
        $scraped_author_description = strip_tags($scraped_author_description);
        $scraped_author_description = str_replace('>', '', $scraped_author_description);
        $scraped_author_description = str_replace('style="height:75px;"', '', $scraped_author_description);
        $scraped_author_description = str_replace('style="height:100px;"', '', $scraped_author_description);
        $scraped_author_description = str_replace('style="max-height:100px;"', '', $scraped_author_description);
        $scraped_author_description = trim($scraped_author_description);
        
        $scraped_student_no = scrape_between($results_page, 'data-purpose="course-enrollment-numbers">' , ' students enrolled');
        
        $scraped_student_no = scrape_between($results_page, 'fraudulent ratings.', ' students enrolled');
        $scraped_student_no = trim(str_ireplace('•', '', $scraped_student_no));
        $scraped_student_no = trim(strip_tags(str_replace(',', '', $scraped_student_no)));
        
        if ($scraped_student_no =='') {
            $scraped_student_no = 0;
        }
        
               
        //$scraped_ratings = scrape_between($results_page, '<meta itemprop="ratingCount" content="' , '" />');
        $scraped_ratings = scrape_between($results_page, '<span aria-label="Rating:',' ratings)');
        $scraped_ratings = explode('(', $scraped_ratings)[1];
            
        
        return array(
            'scraped_course_id' => trim($scraped_course_id),
            'scraped_private_draft_not_found' => trim($scraped_private_draft_not_found),
            'scraped_image_url' => trim($scraped_image_url),
            'scraped_title' => trim($scraped_title),
            'scraped_subtitle' => trim($scraped_subtitle),
            'scraped_author' => trim($scraped_author),
            'scraped_author_id' => trim($scraped_author_id),
            'scraped_author_page' => trim($scraped_author_page),
            'scraped_author_description' => trim($scraped_author_description),
            'scraped_twitter' => trim($scraped_twitter),
            'scraped_reduced_price' => trim($scraped_reduced_price),
            'scraped_full_price' => trim($scraped_full_price),
            'scraped_cat' => trim($scraped_cat),
            'scraped_subcat' => trim($scraped_subcat),
            'scraped_description' => trim($scraped_description),
            'scraped_review_percent' => trim($scraped_review_percent),
            'scraped_ratings' => trim($scraped_ratings),
            'scraped_student_no' => trim($scraped_student_no),
            'scraped_backend_error' => trim($scraped_backend_error),
            'scraped_lost' => trim($scraped_lost)
            );
    
    sleep(rand(4,6));
    
    }
         
}

?>