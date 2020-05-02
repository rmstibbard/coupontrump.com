<?php

class update {
  
    public function __construct($all_course_data){
        $this->all_course_data=$all_course_data;
        $this->updated = date('Y-m-d H:i:s');
    }

   
    function inactive($course_url) {
        
        global $db;
        $all_course_data = $this->all_course_data;
        $updated = $this->updated;
        $updated_notes = $updated . " " . $all_course_data['notes'];
        
        $query = new query();
        $query = $query->update();
        $stmt = $db->prepare($query);
        
        include '../coupontrump-admin-includes/bind-params.inc.php';

        $stmt->bindValue(':active', 'auto_no');
        $stmt->execute();   
    }
    


    function active($course_url) {
            
        global $db;
        $all_course_data = $this->all_course_data;
        $updated = $this->updated;
        $updated_notes = $updated . " " . $all_course_data['notes'];
        
        $query = new query();
        $query = $query->update();
        $stmt = $db->prepare($query);        
        
        include '../coupontrump-admin-includes/bind-params.inc.php';
        
        $stmt->bindValue(':active', 'yes');
        $stmt->execute();
        
    }    
 
 
 }
 
 
 
?>