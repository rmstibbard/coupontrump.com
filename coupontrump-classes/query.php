<?php
class query {
   
    public function cat_list() {
        $query = "SELECT DISTINCT (`cat`) AS `cat` FROM `yourls_url`
                    WHERE `cat` != ''
                    AND `active` = 'yes'
                    AND `keyword` != ''
                    AND `url` != ''
                    AND `title` != ''
                    AND `author` != ''
                    AND `author` NOT LIKE '%alun hill%'
                    ORDER BY `cat` ";
        return $query;
    }
    
    
    
    public function subcat_list() {
        $query = "SELECT DISTINCT (`subcat`) AS `subcat` FROM `yourls_url`
                    WHERE `cat` LIKE :cat
                    AND `active` = 'yes'
                    AND `keyword` != ''
                    AND `url` != ''
                    AND `title` != ''
                    AND `author` != ''
                    AND `author` NOT LIKE '%alun hill%'
                    ORDER BY `subcat` ASC ";
        return $query;
    }    
    
    
}  
?>