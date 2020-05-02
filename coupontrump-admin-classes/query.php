<?php

class query {
    
    
    public function insert() {
        
        $query = "INSERT INTO `yourls_url`
            (`course_id`,
            `course_url`,
            `url`,
            `slug`,
            `keyword`,
            `title`,
            `cat`,
            `subcat`,
            `subtitle`,
            `description`,
            `image_url`,
            `author`,
            `author_id`,
            `author_page`,
            `author_description`,
            `twitter`,
            `ratings`,
            `calculated_quality`,
            `review_percent`,
            `student_no`,
            `coupon`, 
            `full_price`,
            `reduced_price`,
            `notes`,
            `added`,
            `updated`,
            `active`)
           VALUES
            (:course_id,
            :course_url,
            :url,
            :slug,
            :keyword,
            :title,
            :cat,
            :subcat,
            :subtitle,
            :description,
            :image_url,
            :author,
            :author_id,
            :author_page,
            :author_description,
            :twitter,
            :ratings,
            :calculated_quality,
            :review_percent,
            :student_no,
            :coupon, 
            :full_price,
            :reduced_price,
            :notes,
            :added,
            :updated,
            :active)";
            
        return $query;
        
    }
    
    
    
    
    

    public function update() {
    
        $query = "UPDATE `yourls_url`
                    SET `course_id`=:course_id,
                        `url`=:url,
                        `slug`=:slug,
                        `title`=:title,
                        `cat`=:cat,
                        `subcat`=:subcat,
                        `subtitle`=:subtitle,
                        `description`=:description,
                        `image_url`=:image_url,
                        `author`=:author,
                        `author_id`=:author_id,
                        `author_page`=:author_page,
                        `author_description`=:author_description,
                        `twitter`=:twitter,
                        `review_percent`=:review_percent,
                        `ratings`=:ratings,
                        `calculated_quality`=:calculated_quality,
                        `student_no`=:student_no,
                        `coupon`=:coupon,
                        `full_price`=:full_price,
                        `reduced_price`=:reduced_price,
                        `notes`=:notes,
                        `updated`=:updated,
                        `active`=:active
                    WHERE `course_url`=:course_url";
                    
        return $query;
    }
    
    
}
?>