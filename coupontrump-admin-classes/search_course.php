<?php

class search_course {
    
    function find($course_url) {
        
        global $db, $course_url, $results_page;
        
        $query = "SELECT * from `yourls_url` WHERE `course_url` = :course_url";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':course_url', $course_url);
        $stmt->execute();
        $count = $stmt->rowCount();
            
        if ($count>0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($results as $row) {
                $coupon_in_dbase = $row['coupon'];
                $url_in_dbase = $row['url'];
                $slug_in_dbase = $row['slug'];
                $reduced_price_in_dbase = $row['reduced_price'];
                $keyword_in_dbase = $row['keyword'];
                $review_percent = $row['review_percent'];
                $ratings = $row['ratings'];
            }
            
            return array (
                'coupon_in_dbase' => $coupon_in_dbase,
                'url_in_dbase' => $url_in_dbase,
                'slug_in_dbase' => $slug_in_dbase,
                'reduced_price_in_dbase' => $reduced_price_in_dbase,
                'keyword_in_dbase' => $keyword_in_dbase,
                'review_percent' => $review_percent,
                'ratings' => $ratings,
                'course_exists' => 'YES');
        
        } else {
            return array (
                'coupon_in_dbase' => '',
                'url_in_dbase' => '',
                'slug_in_dbase' => '',
                'reduced_price_in_dbase' => '',
                'keyword_in_dbase' => '',
                'review_percent' => '',
                'ratings' => '',
                'course_exists' => 'NO');
        }
    }
    
}