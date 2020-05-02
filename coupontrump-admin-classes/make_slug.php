<?php

class make_slug {
    
    public function slug($course_url) {
        
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
        
        //$slug = str_replace("udemy-udemy-", "udemy-", $slug);
        $slug = str_replace("udemy-udemy-", "", $slug);
        
        return $slug;
        
    }
    
    
}


?>