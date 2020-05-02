<?php

ini_set('max_execution_time', 0);

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url`" ;
$stmt = $db->prepare($query);
$stmt->execute();
$no_urls = $stmt->rowCount();

$a = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $course_url = $row['course_url'];
    
    $slug_in_dbase = $row['slug'];
    
    if (trim($slug_in_dbase)=="") {
    
        if (strpos($course_url,"udemy.com/")!=false) {
            $platform = "udemy";
        }

        if (!isset($platform)) {
            $platform = "";
        }
            
        $slug = strtolower($platform) . "-" . $course_url . "-" . substr(str_shuffle(MD5(microtime())), 0, 5);
        
        $slug = str_replace("http:", "", $slug);
        $slug = str_replace("https:", "", $slug);
        $slug = str_replace("//www.", "", $slug);
        
        $slug = str_replace("udemy.com/", "", $slug);
        $slug = str_replace("bitwisecourses.com/", "", $slug);
        $slug = str_replace("parallelbranch.usefedora.com/", "", $slug);
        $slug = str_replace("yodalearning.com/", "", $slug);
        $slug = str_replace("learntoprogram.tv/", "", $slug);
        $slug = str_replace("course/", "", $slug);
        
        $slug = str_replace("how-to-", "howww-tooo-", $slug);
        $slug = str_replace("-to-", "-", $slug);
        $slug = str_replace("howww-tooo-", "how-to-", $slug);
        
        $slug = str_replace("-the-", "-", $slug);
        $slug = str_replace("-a-", "-", $slug);
        $slug = str_replace("-an-", "-", $slug);
        $slug = str_replace("-and-", "-", $slug);
        $slug = str_replace("-by-", "-", $slug);
        $slug = str_replace("-for-", "-", $slug);
        $slug = str_replace("-in-", "-", $slug);
        $slug = rtrim($slug,"-");
                
        $slug = str_replace("_", "-", $slug);
        $slug = str_replace("--", "-", $slug);
        
        $slug = str_replace("/", "", $slug);
        
        $slug = str_replace("udemy-udemy-", "udemy-", $slug);
        
        $update_query = "UPDATE `yourls_url`
            SET `slug` = :slug
            WHERE `course_url` = :course_url";
        
        $update_stmt = $db->prepare($update_query);
        $update_stmt->bindParam(':slug', $slug);
        $update_stmt->bindParam(':course_url', $course_url);
        $update_stmt->execute();
        
        echo "Setting " . $row['course_url'] . "  as   <b>" . $slug . "</b> (" . $a . " of " . $no_urls . ")<br>";
        $a++;
    }
        
}        

echo "<h1>Done!</h1>";

?>