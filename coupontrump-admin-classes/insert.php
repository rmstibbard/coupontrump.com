<?php

class insert {
    
    public function __construct($all_course_data){
        $this->all_course_data=$all_course_data;
        $this->updated = date('Y-m-d H:i:s');
        $this->added = date('Y-m-d H:i:s');
    }    

    
    
    function active($course_url) {
        
        global $db;
        $all_course_data = $this->all_course_data;
        //if (($all_course_data['scraped_student_no'] > 200) && ($all_course_data['review_percent'] >= 90 )) {
        // does not add crap courses
            
            $added = $this->added;
            $updated = $this->updated;
            $updated_notes = $updated . " " . $all_course_data['notes'];
            
            $query = new query();
            $query = $query->insert();
            $stmt = $db->prepare($query);
            
            include '../coupontrump-admin-includes/bind-params.inc.php';
            
            $stmt->bindParam(':keyword', $all_course_data['keyword']);
            $stmt->bindValue(':active', 'yes');
            $stmt->bindParam(':added', $added);
            $stmt->execute();
            
        //}
         
    }





    function inactive($course_url) {
            
        global $db;
        $all_course_data = $this->all_course_data;
        $added = $this->added;
        $updated = $this->updated;
        $updated_notes = $updated . " " . $all_course_data['notes'];

        $query = new query();
        $query = $query->insert();
        $stmt = $db->prepare($query);
        
        include '../coupontrump-admin-includes/bind-params.inc.php';
        
        $stmt->bindParam(':keyword', $all_course_data['keyword']);
        $stmt->bindValue(':active', 'auto_no');
        $stmt->bindParam(':added', $added);
        $stmt->execute();    }
    
}


?>