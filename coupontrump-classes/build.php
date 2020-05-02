<?php

class build {
    
    function __construct($db) { 
        $this->db = $db;
    }
    
    public function cat_list() {
       
        $query = new query();
        $query = $query->cat_list();
       
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $count = $stmt->rowCount();
        
        $output = '';

        if ($count>0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cat = trim(strip_tags($row['cat']));
                $output .= "\t\t\t\t\t\t\t\t\t<option value='". $cat . "'>" . $cat . "</option>\n";
            }
        } else {
            $output = "";
        }
        echo $output;
    }

    
    public function subcat_list($cat) {
        
        $output = '';
        $cat = "%" . $cat . "%";

        $query = new query();
        $query = $query->subcat_list();       

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cat', $cat);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        if ($count>0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $subcat = trim(strip_tags($row['subcat']));
                $output .= ("\t\t\t\t<option value='". $subcat . "'>" . $subcat . "</option>\n");
            }
            
        } else {
                $output = ("");
            }
        echo $output;
    }
    
    
    public function afflink($id) {
        
        $stmt = $this->db->prepare("SELECT `keyword` FROM `yourls_url` WHERE `id` = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output = $row['keyword'];
        }
        echo $output;
    }
    
   
}


?>