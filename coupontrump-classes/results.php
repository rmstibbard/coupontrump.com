<?php

class results {

    function __construct($db) { 
        $this->db = $db;
    }


    public function featured() {
        
        $today = date('Y-m-d-H-i');

        $query = "SELECT * FROM `yourls_url` WHERE `featured` = 'yes' AND `featured_expires` >= :today ";        
        $query .= "AND " . COMMON_QUERY;
        $query .= " ORDER BY RAND() LIMIT 24";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':today', $today);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        if ($count>0) {
            $output = "<h2 class='results'>Featured courses</h2>";
            $output .= "\t\t<div class='course_list'>\n";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                include 'coupontrump-includes/course-list.inc.php';
            }
            $output .= "</div>\n";
            $title = DEFAULT_TITLE;
            return array ('course_list' => $output, 'title' => $title);
        }
    }
    
  
    public function subcat($cat, $subcat, $order, $maxprice) {
        
        if (!isset($_COOKIE['featured_subcats'])) {
            if ($subcat!="Select subcategory") {
                setcookie('featured_subcats', $subcat, time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
            }
        } else {
            if (strpos($_COOKIE['featured_subcats'], $subcat) === false ) {
                if ($subcat!="Select subcategory") {
                    setcookie('featured_subcats', $_COOKIE["featured_subcats"] . ',' . $subcat , time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
                }
            }
        }
        
        if ($subcat!="Select subcategory") {
            
            $cat_match = "%" . $cat . "%";
            $subcat_match = "%" . $subcat . "%";
            
            $query = "SELECT * FROM `yourls_url` WHERE `cat` LIKE :cat AND `subcat` LIKE :subcat ";        
            $query .= "AND " . COMMON_QUERY;
            $query .= ((is_numeric($maxprice)) && ($maxprice!="")) ? " AND `reduced_price` <= :maxprice " : "";
            $query .= ORDER_QUERY;
                       
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cat', $cat_match);
            $stmt->bindParam(':subcat', $subcat_match);
            if ((is_numeric($maxprice)) && ($maxprice!="")) {
                $stmt->bindParam(':maxprice', $maxprice);
            }
            $stmt->execute();
            $count = $stmt->rowCount();
            
            if ($count>0) {
                
                $output = "\t\t<h2 class='results'>". $count . " ";
                $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? " free " : "";
                $output .= ($order=="ratings") ? " rated " : "";
                $output .= ($count>1) ? "courses" : "course";
                $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
                
                if ($cat!="") {
                    $output .= " found on <strong>" . $subcat . "</strong> in <strong>" . $cat . "</strong>";
                    $title = $count . " online video courses found on " . $subcat . " in " . $cat;
                } else {
                    $output .= " found on <strong>" . $subcat . "</strong>";
                    $title = $count . " online video courses found on " . $subcat;
                }
                
                $output .= "</h2>\n";
                $output .= "\t\t<div class='course_list'>\n";

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    include 'coupontrump-includes/course-list.inc.php';
                }

                $output .= "</div>\n";

            } else {
                $output = "\t\t<h2 class='no_results'>No matching courses found</h2>\n";
                $title = DEFAULT_TITLE;
            }
        } else {
            $output = "\t\t<h2 class='error'>No categories chosen</h2>\n";
            $title = DEFAULT_TITLE;
        }
        return array ('course_list' => $output, 'title' => $title);
    }
    
      
    
    public function featured_subcats() {

        $featured_subcats = $_COOKIE["featured_subcats"];
        $featured_subcats = explode(',', $featured_subcats);
        $featured_subcats = array_unique(array_filter($featured_subcats));
        $featured_subcats = array_values(array_slice($featured_subcats, -NUMBER_OF_FEATURED_SUBCATS, NUMBER_OF_FEATURED_SUBCATS, true));
        $featured_subcats = array_reverse($featured_subcats);
        
        $count_featured_subcats = sizeof($featured_subcats);
        
        if ($count_featured_subcats>0) {
            
            $output = ($count_featured_subcats>1)
                ? $output = "<h2 class=featured>Featured categories</h2>"
                : $output = "<h2 class=featured>Featured category</h2>"; 
           
            $output .= "\t\t<div class='course_list'>\n";
            
            foreach ($featured_subcats as $featured_subcat) {
                
                $featured_subcat_match = "%" . $featured_subcat . "%";
                
                $query = "SELECT * FROM `yourls_url` WHERE (`subcat` LIKE :featured_subcat_match) ";
                $query .= " AND " . COMMON_QUERY . " AND `featured` != 'yes'" ;
                $query .= " ORDER BY RAND() LIMIT 12";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':featured_subcat_match', $featured_subcat_match);
                $stmt->execute();
                $count = $stmt->rowCount();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    include 'coupontrump-includes/course-list.inc.php';
                }
                
            }
            $output .= "</div>\n";
            if ($count>0) {
                return $output;
            }
        }
    }

    
    
    
    public function author($author, $order, $maxprice) {

        $query = "SELECT * FROM `yourls_url` WHERE `author` LIKE :author ";
        $query .= "AND " . COMMON_QUERY;
        $query .= ((is_numeric($maxprice)) && ($maxprice!="")) ? " AND `reduced_price` <= :maxprice " : "";
        $query .= ORDER_QUERY;   
        
        $stmt = $this->db->prepare($query);
        $author_match = "%" . $author . "%";
        $stmt->bindParam(':author', $author_match);
        if ((is_numeric($maxprice)) && ($maxprice!="")) {
            $stmt->bindParam(':maxprice', $maxprice);
        }        
        $stmt->execute();
        $count = $stmt->rowCount();
        
        $output = '';
           
        if ($count>0) {
            
            if ($count<500) {
   
                $query = "SELECT `author` FROM `yourls_url` WHERE `author` LIKE :author AND " . COMMON_QUERY;
                
                $author_stmt = $this->db->prepare($query);
                $author_stmt->bindParam(':author' , $author_match);
                $author_stmt->execute();
                
                while ($row = $author_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $author_list = $row['author'];   
                    $authors_list[] = $author_list;
                    $authors_list = array_unique(array_filter($authors_list));
                }
                
                $output = "\t\t<h2 class='results'>". $count . " ";
                $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? " free " : "";
                $output .= ($order=="ratings") ? " rated " : "";
                $output .= ($count>1) ? "courses" : "course";
                $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
            
    
                if ( (sizeof($authors_list)==1) ) {
                    $current_author = ucwords($authors_list[0]);
                    $output = "\t\t<h2 class='results'>Found " . $count . " ";
                    $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? "free " : "";
                    $output .= ($order=="ratings") ? "rated " : "";
                    $output .= ($count>1) ? "courses" : "course";
                    $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
                    $output .= " by <strong>" . $current_author . "</strong> ";
                    $title = $current_author . "'s online courses | Discounts valid " .  date('F Y');
                }
                
                if ( (sizeof($authors_list)>1) ) { 
                    $output = "\t\t<h2 class='results'>Found " . $count . " ";
                    $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? "free " : "";
                    $output .= ($order=="ratings") ? "rated " : "";
                    $output .= ($count>1) ? "courses" : "course";
                    $output .= " by authors named " . ucwords($author);
                    $title = DEFAULT_TITLE;
                }
                
                $output .= "</h2>\n";
                $output .= "\t\t<div class='course_list'>\n";
    
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   include 'coupontrump-includes/course-list.inc.php';
                }
    
                $output .= "</div>\n";
                
                if ( (sizeof($authors_list)==1) ) { // One author only - author description
                    $results = new results($this->db);
                    $output .= $results->author_description($current_author);
                } elseif ( (sizeof($authors_list) > 1 ) ) {
                    $results = new results($this->db);
                } else {
                    $output .= "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching courses found</h2>";
                    $output .= "\t</div>\n";
                    $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
                    $title = DEFAULT_TITLE;
                }                
                
            } else {
                $output = "<h2 class='results alert'>Too many results - Please set a more exact instructor's name</h2>";
                $title = DEFAULT_TITLE;
            }

        } else {
            $output .= "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching courses found</h2>";
            $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
            $title = DEFAULT_TITLE;
        }
        return array ('course_list' => $output, 'title' => $title);
    }
    

    
    public function featured_authors() {

        $featured_authors = $_COOKIE["featured_authors"];
        $featured_authors = explode(',', $featured_authors);
        $featured_authors = array_unique(array_filter($featured_authors));
        $featured_authors = array_values(array_slice($featured_authors, -NUMBER_OF_FEATURED_AUTHORS, NUMBER_OF_FEATURED_AUTHORS, true));
        $featured_authors = array_reverse($featured_authors);
        
        $count_featured_authors = sizeof($featured_authors);
        
        if ($count_featured_authors>0) {
            
            $output = ($count_featured_authors>1)
                ? $output = "<h2 class=featured>Featured instructors</h2>"
                : $output = "<h2 class=featured>Featured instructor</h2>"; 
            
            $output .= "\t\t<div class='course_list'>\n";
            
            foreach ($featured_authors as $featured_author) {
                
                $featured_author_match = "%" . $featured_author . "%";
                
                $query = "SELECT * FROM `yourls_url` WHERE (`author` LIKE :featured_author_match) ";
                $query .= " AND " . COMMON_QUERY . " AND `featured` != 'yes'" ;
                $query .= " ORDER BY RAND() LIMIT 12";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':featured_author_match', $featured_author_match);
                $stmt->execute();
                $count = $stmt->rowCount();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    include 'coupontrump-includes/course-list.inc.php';
                }
                
                }
                $output .= "</div>\n";
                if ($count>0) {
                    return $output;
                }
            } 
            
        }






    
    
    
    
    public function keywords($keywords, $order, $maxprice) {
        
        if (!isset($_COOKIE['featured_keywords'])) {
            setcookie('featured_keywords', $keywords, time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
        } else {
            if (strpos($_COOKIE['featured_keywords'], $keywords) === false ) {
                setcookie('featured_keywords', $_COOKIE["featured_keywords"] . ',' . $keywords , time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
            }
        }
        
        $keywords = str_ireplace('&','',$keywords);
        $keywords = str_replace('&amp;','',$keywords);
        $keywords = str_replace('the ','',$keywords);
        $keywords = str_replace(' a ','',$keywords);
        $keywords = str_replace(' an ','',$keywords);
        $keywords = str_replace(':','',$keywords);
        $keywords = str_replace(',','',$keywords);          
            
        
        $keywords = array_values(array_unique(array_filter(explode(" ", $keywords))));
        $count_keywords = sizeof($keywords);

        $query = "SELECT * FROM `yourls_url` WHERE ";
        
        $a = 0;
        while ($a < $count_keywords) {
            $query .= "(`title` LIKE :keyword" . $a . " ";
            $query .= "OR `subtitle` LIKE :keyword" . $a . ") ";
            $a++;
            if ($a < $count_keywords) {
                $query = $query . " AND ";
            }
        }
        
        $query .= " AND " . COMMON_QUERY;
        $query .= ((is_numeric($maxprice)) && ($maxprice!="")) ? " AND `reduced_price` <= :maxprice " : "";
        $query .= ORDER_QUERY;
        
        $stmt = $this->db->prepare($query);
        
        for ($a=0; $a<$count_keywords; $a++) {
            $keyword[$a] = "%" . $keywords[$a] . "%";
            $stmt->bindParam(':keyword'.$a, $keyword[$a]);
        }
        
        if ((is_numeric($maxprice)) && ($maxprice!="")) {
            $stmt->bindParam(':maxprice', $maxprice);
        }
        
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count>0) {
            
            if ($count<500) {
        
                $title = "Found " . $count . " "; 
                $title .= ($count>1) ? "courses on " : "course on ";
                
                $output = "\t\t<h2 class='results'>Found " . $count . " ";
                $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? "free " : "";
                $output .= ($order=="ratings") ? "rated " : "";
                $output .= ($count>1) ? "courses " : "course ";
                $output .= ($count_keywords>1) ? "with keywords " : "with keyword ";
                $output .= "<strong>";
                
                foreach($keywords as $keyword) {
                    $output .=  strtoupper($keyword). " ";
                    $title .= $keyword . " ";
                }
                
                $output .= "</strong>";
                $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice . " " : " ";
                $output .= "</h2>";
                
                $title .= " | Best prices at CouponTrump.com";
                $output .= "\t\t<div class='course_list'>\n";
            
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   include 'coupontrump-includes/course-list.inc.php';
                }
                
                $output .= "</div>\n";
                
            } else {
                $output = "<h2 class='results alert'>Too many results - Please set more exact keywords</h2>";
                $title = DEFAULT_TITLE;
            }
        
        } else {
            $output .= "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching courses found</h2>";
            $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
            $title = DEFAULT_TITLE;
        }
        
        return array ('course_list' => $output, 'title' => $title);
        
    }
    
    
    
    
    public function featured_keywords() {
        
        $featured_keywords = $_COOKIE["featured_keywords"];
        $featured_keywords = explode(',', $featured_keywords);
        $featured_keywords = array_unique(array_filter($featured_keywords));
        $featured_keywords = array_values(array_slice($featured_keywords, -NUMBER_OF_FEATURED_KEYWORDS, NUMBER_OF_FEATURED_KEYWORDS, true));
        $featured_keywords = array_reverse($featured_keywords);
        $count_featured_keywords = sizeof($featured_keywords);

        if ($count_featured_keywords>0) {
           
            $output = ($count_featured_keywords>1)
                ? $output = "<h2 class=featured>Featured keywords</h2>"
                : $output = "<h2 class=featured>Featured keyword</h2>"; 

            $output .= "\t\t<div class='course_list'>\n";
            
            foreach ($featured_keywords as $featured_keyword) {
                
                $featured_keyword_match = "%" . $featured_keyword . "%";
                
                $query = "SELECT * FROM `yourls_url` WHERE (`title` LIKE :featured_keyword_match OR `subtitle` LIKE :featured_keyword_match) ";
                $query .= " AND " . COMMON_QUERY . " AND `featured` != 'yes'" ;
                $query .= " ORDER BY RAND() LIMIT 12";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':featured_keyword_match', $featured_keyword_match);
                $stmt->execute();
                $count = $stmt->rowCount();
                
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    include 'coupontrump-includes/course-list.inc.php';
                }
                
            }
            $output .= "</div>\n";
            if ($count>0) {
                return $output;
            }
            
        } 
    }

 

    
    

    public function author_keywords($author, $keywords, $order, $maxprice) {
        
        if (!isset($_COOKIE['featured_keywords'])) {
            setcookie('featured_keywords', $keywords, time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
        } else {
            
            if (strpos($_COOKIE['featured_keywords'], $keywords) === false ) {
                setcookie('featured_keywords', $_COOKIE["featured_keywords"] . ',' . $keywords , time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
            }
        }
        
        $keywords = array_unique(array_filter(explode(" ", $keywords)));
        $count_keywords = sizeof($keywords);
            
        if (!isset($_COOKIE['featured_authors'])) {
            setcookie('featured_authors', $author, time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
        } else {
            if (strpos($_COOKIE['featured_authors'], $author) === false ) {
                setcookie('featured_authors', $_COOKIE["featured_authors"] . ',' . $author , time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
            }
        }

        $query = "SELECT * FROM `yourls_url` WHERE ";
        
        if ($count_keywords != 0)  {
            $a = 0;
            while ($a < $count_keywords) {
                $query .= "(`title` LIKE :keyword" . $a . " ";
                $query .= "OR `subtitle` LIKE :keyword" . $a . ") ";
                $a++;
                if ($a < $count_keywords) {
                    $query = $query . " AND ";
                }
            }
            if ($author!=null) {
                $query .= " AND `author` LIKE :author ";
            }
            
        } else {
            $query .= " `author` LIKE :author ";
        }

        $query .= " AND " . COMMON_QUERY;
        $query .= ((is_numeric($maxprice)) && ($maxprice!="")) ? " AND `reduced_price` <= :maxprice " : "";
        $query .= ORDER_QUERY;
        
        $stmt = $this->db->prepare($query);
        
        for ($a=0; $a<$count_keywords; $a++) {
            $keyword[$a] = "%" . $keywords[$a] . "%";
            $stmt->bindParam(':keyword'.$a, $keyword[$a]);
        }
        
        if ((is_numeric($maxprice)) && ($maxprice!="")) {
            $stmt->bindParam(':maxprice', $maxprice);
        }                
        
        $author_match = "%" . $author . "%";
        
        $stmt->bindParam(':author', $author_match);
        $stmt->execute();
        $count = $stmt->rowCount();
        
           
        if ($count>0) {
            
            if ($count<500) {
                $query = "SELECT `author` FROM `yourls_url` WHERE `author` LIKE :author AND " . COMMON_QUERY;
                
                $author_stmt = $this->db->prepare($query);
                $author_stmt->bindParam(':author' , $author_match);
                $author_stmt->execute();
                
                while ($row = $author_stmt->fetch(PDO::FETCH_ASSOC)) {
                    $author_list = $row['author'];   
                    $authors_list[] = $author_list;
                    $authors_list = array_unique(array_filter($authors_list));
                }
                
                $output = '';
                $title = $count . " ";
                $title .= ((is_numeric($maxprice)) && ($maxprice==0)) ? "free " : "";
                $title .= ($count>1) ? "courses " : "course ";
                $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
                
                if (sizeof($authors_list)==1) {   // One author only
                    $current_author = ucwords($authors_list[0]);
                    
                    $title = "Courses on " ;
                    
                    $output = "\t\t<h2 class='results'>Found " . $count . " ";
                    $output .= ((is_numeric($maxprice)) && ($maxprice)==0) ? "free " : "";
                    $output .= ($order=="ratings") ? "rated " : "";
                    $output .= ($count>1) ? "courses " : "course ";
                    $output .= (sizeof($keywords)>1) ? "with keywords " : "with keyword ";
                    $output .= "<strong>";
                    
                    foreach($keywords as $keyword) {
                        $output .= strtoupper($keyword) . " ";
                        $title .= $keyword . " ";
                    }
                    
                    $output .= "</strong>"; 
                    $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
                    $output .= "</strong> by <strong>" . $current_author . "</strong>";
                    
                    $title .= " by " . $current_author;
                    $title .= " | Best prices at CouponTrump.com";
                }
                
                if (sizeof($authors_list)>1)  {   // More than one author
                    $title = ($count>1) ? $count . " courses found on " : $count . "course found on ";
                    
                    $output = "\t\t<h2 class='results'>" . $count . " ";
                    $output .= ((is_numeric($maxprice)) && ($maxprice==0)) ? "free " : "";
                    $output .= ($order=="ratings") ? "rated " : "";
                    $output .= ($count>1) ? "courses " : "course ";
                    $output .= ((is_numeric($maxprice)) && ($maxprice>0)) ? " priced up to $" . $maxprice : "";
                    $output .= (sizeof($keywords)>1) ? " with keywords " : " with keyword ";
                    $output .= "<strong>";
                    
                    foreach($keywords as $keyword) {
                        $output .= strtoupper($keyword) . " ";
                        $title .= $keyword . " ";
                    }
                    
                    $output .= "</strong>";
                    $title .= " | Best prices at CouponTrump.com";
                    
                if (str_ireplace("%", "", $author_match)!="") {
                        $output .= "</strong> by authors named <strong>" . ucwords(str_replace("%", "", $author_match)) . "</strong> ";
                    } else {
                        $output .= "</strong>";
                    }
                }
                
                $output .= "</h2>\n";
                $output .= "\t\t<div class='course_list'>\n";
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                   include 'coupontrump-includes/course-list.inc.php';
                }
                $output .= "</div>\n";
                
                if ( (sizeof($authors_list)==1) ) { // One author only - author description
                    $results = new results($this->db);
                    $output .= $results->author_description($current_author);
                }
            } else {
                $output = "<h2 class='results alert'>Too many results - Please set more exact author/keyword search terms</h2>";
                $title = DEFAULT_TITLE;
            }
    
        } else {                                        
            $output = "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching courses found</h2>";
            $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
            $title = DEFAULT_TITLE;
                                        
    } 
    
    return array ('course_list' => $output, 'title' => $title);
}




    
    
    public function author_description($current_author) {
        

        if (!isset($_COOKIE['featured_authors'])) {
            setcookie('featured_authors', $current_author, time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
        } else {
            if (strpos($_COOKIE['featured_authors'], $current_author) === false ) {
                setcookie('featured_authors', $_COOKIE["featured_authors"] . ',' . $current_author , time() + (86400 * COOKIE_EXPIRATION), "/"); // 86400 = 1 day
            }
        }        
       
        $query = "SELECT * FROM `yourls_url` WHERE `author` = :current_author AND `author_description` != '' LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":current_author", $current_author);
        $stmt->execute();
    
        $count = $stmt->rowCount();
        
        $output = '';
        
        if ($count>0) {
            $output = "\t\t\t\t\t<div class='author_description'>\n";
            $output .= "\t\t\t\t\t<h4>About " . ucwords($current_author) . "</h4>\n";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $output .= "\t\t\t\t\t<p class='author_description'>" . $row['author_description'] . "</p>\n";
            }
            $output .= "\t\t\t\t\t</div>\n";
         }     
         return $output;
    }
    
    
    
    
    
    
    
    public function single_course($slug) {
    
        $query = "SELECT * FROM `yourls_url` WHERE `slug` = :slug AND " . COMMON_QUERY;
            
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        $output = "\n\t\t<div class='single_course'>\n";
        
        if ($count>0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               include 'coupontrump-includes/single-course.inc.php';
                $large_image = str_replace("304x171", "480x270", $row['image_url']);
                $og_image = "\t\t<meta property='og:image' content='" . $large_image . "'>\n";
                $title = str_ireplace(' - Udemy', '', trim($row['title']));
                $title = str_ireplace('| Udemy', '', trim($title));
                if ($row['reduced_price']>0) {
                    $title = $title .= " by " . trim($row['author']) . " | Just $" . $row['reduced_price'] . " on CouponTrump";
                } else {
                    $title = $title .= " by " . trim($row['author']) . " | FREE on CouponTrump";
                }
            }
            
        } else {
            $output .= "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching course found</h2>";
            $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
            $title = DEFAULT_TITLE;
        }
        
        $output .= "\n\t\t</div>\n";        
        
        return array ('course_list' => $output, 'og_image' => $og_image, 'title' => $title);
    }
    
    
    
    
    
  
    public function course_by_id($id) {

        $query = "SELECT * FROM `yourls_url` WHERE `id` = :id AND " . COMMON_QUERY;
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        if ($count>0) {
            $output = "\n\t\t<div class='single_course'>\n";
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                include 'coupontrump-includes/single-course.inc.php';
                $large_image = str_replace("304x171", "480x270", $row['image_url']);
                $og_image = "\t\t<meta property='og:image' content='" . $large_image . "'>\n";
                $title .= " by " . $row['author'] . " | Best price on CouponTrump";
            }        
               
        } else {
            $output .= "<h2 style='text-align: center; margin-top: 30px; margin-bottom: 30px'>No matching course found</h2>";
            $output .= "\t</div>\n";
            $og_image = "\t\t<meta property='og:image' content='images/fb-og-image.png'>\n";
            $title = DEFAULT_TITLE;
        }
        
        $output .= "\t\t</div>\n"; 
        return array ('course_list' => $output, 'og_image' => $og_image, 'title' => $title);
    }
      
  
    

  

    public function price($minprice, $maxprice) {
        
        $query = "SELECT * FROM yourls_url WHERE ";
        $query .= (is_numeric($minprice)) ? "`reduced_price` >= :minprice " : "";
        $query .= ((is_numeric($minprice)) && (is_numeric($maxprice)) ) ? " AND " : "";
        $query .= (is_numeric($maxprice)) ? "`reduced_price` <= :maxprice " : "";
        $query .= " AND " . COMMON_QUERY . " ORDER BY RAND()";
        
        $stmt = $this->db->prepare($query);
        
        if (is_numeric($minprice)) {
            $stmt->bindParam(':minprice', $minprice);
        }
        if (is_numeric($maxprice)) {
            $stmt->bindParam(':maxprice', $maxprice);
        }
        
        $stmt->execute();
        $no_courses = $stmt->rowCount();
        

        if ( (is_numeric($minprice)) && (is_numeric($maxprice)) && ($minprice != $maxprice)  )  {
            $output = "\t\t<h2 class='results'>" . $no_courses . " courses priced from $" . $minprice;
            $output .= " to $" . $maxprice  . "</h2>\n";
            $title = $no_courses . " courses priced from $" . $minprice . " to $" . $maxprice . " on CouponTrump";
        }
        
        if ( (is_numeric($minprice)) && (is_numeric($maxprice)) && ($minprice == $maxprice)  )  {
            $output = "\t\t<h2 class='results'>" . $no_courses . " courses priced at $" . $maxprice . "</h2>\n";
            $title = $no_courses . " courses priced at $" . $maxprice . " on CouponTrump";
        }
        
        
        if ( (!is_numeric($minprice)) && (is_numeric($maxprice)) ) {
            $output = "\t\t<h2 class='results'>". $no_courses . " courses priced up to $" . $minprice . "</h2>\n";
            $title = $no_courses . " courses priced up to $" . $maxprice . " on CouponTrump";
        }
        
        if ( (is_numeric($minprice)) && (!is_numeric($maxprice)) ) {
            $output = "\t\t<h2 class='results'>". $no_courses . " courses priced over $" . ($minprice-1) . "</h2>\n";
            $title = $no_courses . " courses priced over $" . ($minprice -1) . " on CouponTrump";
        }
        
        $output .= "\t\t<div class='course_list'>\n";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            include 'coupontrump-includes/course-list.inc.php';
        }
        $output .= "</div>\n";
        return array ('course_list' => $output, 'title' => $title);
    }  
  



    public function free() {
        
        $query = "SELECT * FROM yourls_url WHERE `reduced_price` = '0' AND " . COMMON_QUERY . " ORDER BY RAND()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $no_courses = $stmt->rowCount();
        
        $output = "\t\t<h2 class='results'>" . $no_courses . " <strong>free</strong> courses on CouponTrump</h2>\n";
        $title = "Free courses - Learn new skills with CouponTrump";
        
        $output .= "\t\t<div class='course_list'>\n";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            include 'coupontrump-includes/course-list.inc.php';
        }
        
        $output .= "</div>\n";
        
        return array ('course_list' => $output, 'title' => $title);
    }  


    public function trending() {
        
        $outer_query = "SELECT * FROM `yourls_log` ";
        $outer_query .= "WHERE `referrer` LIKE 'http://www.coupontrump.com/index.php?course=%' ";
        $outer_query .= "ORDER BY click_time DESC LIMIT 100";
        $outer_stmt = $this->db->prepare($outer_query);
        $outer_stmt->execute();
        $recent_slugs = '';
        
        while ($row = $outer_stmt->fetch(PDO::FETCH_ASSOC)) {
            $url = explode('?course=', $row['referrer'])[1];
            if ($url!=""){
                $recent_slugs .= $url . ",";
            }
        }
        
        $recent_slugs = array_slice(array_unique(explode(",", $recent_slugs)),0,64);
        
        $output = "\t\t<h2 class='results trending'>Online courses trending now on CouponTrump</h2>";
        $output .= "\t\t<div class='course_list'>\n";        
        foreach ($recent_slugs as $recent_slug) {
            
            $query = "SELECT * FROM `yourls_url` WHERE `slug` = '". $recent_slug . "' ";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($recent_slug!="") {
                   include 'coupontrump-includes/course-list.inc.php';
                }
            }
        }
        $output .= "\t\t</div>\n";
        return $output;
    }


  
    public function pop($minprice, $maxprice) {
        
        $query = "SELECT * FROM `yourls_url` WHERE `clicks` >= '0' AND " . COMMON_QUERY;
        
        if ((is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>=$minprice)) ) {
            $query .= " AND `reduced_price` >= :minprice AND `reduced_price` <= :maxprice ";
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $query .= " AND `reduced_price` >= :minprice ";
        } elseif (is_numeric($maxprice) && (!is_numeric($minprice))) {
            $query .= " AND `reduced_price` <= :maxprice ";
        }        
        
        $query .= " AND `featured` != 'yes' ORDER BY clicks DESC LIMIT 64";
        // $query .= " ORDER BY clicks DESC LIMIT 128";
        
        $stmt = $this->db->prepare($query);
        
        if ((is_numeric($minprice) && (is_numeric($maxprice)) ) ) {
            $stmt->bindParam(':minprice', $minprice);
            $stmt->bindParam(':maxprice', $maxprice);
        } elseif ( is_numeric($minprice) && (!is_numeric($maxprice)) ) {
            $stmt->bindParam(':minprice', $minprice);
        } elseif ( is_numeric($maxprice) && (!is_numeric($minprice)) ) {
            $stmt->bindParam(':maxprice', $maxprice);
        }
        
        $stmt->execute();
        
        $output = "\t\t<h2 class='results'>";
        $title = "";
        
        if (is_numeric($maxprice) && ($maxprice=="0")) {
            $output .= "<strong>Free</strong> ";
            $title .= "Free ";
        }            
        
        $output .= "Bestsellers on CouponTrump ";
        $title .= "Bestsellers on CouponTrump" ;
        
        if (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>$minprice) ) {
            $output .= "priced from $" . $minprice . " to $" . $maxprice;
        } elseif (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice==$minprice) ) {
            $output .= "priced at $" . $maxprice;
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $output .= "priced $" . $minprice . " and over";
        } elseif (is_numeric($maxprice) && ($maxprice!=0) && (!is_numeric($minprice))) {
            $output .= "priced up to $" . $maxprice;
        }        
        
        $output .= "</h2>\n";        
        
        $output .= "\t\t<div class='course_list'>\n";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            include 'coupontrump-includes/course-list.inc.php';
        }
        $output .= "</div>\n";
        return array ('course_list' => $output, 'title' => $title);
    }  
  



    public function ratings($minprice, $maxprice) {
        
        $query = "SELECT * FROM `yourls_url` WHERE `calculated_quality` >= '0' AND " . COMMON_QUERY;
        
        if ((is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>=$minprice)) ) {
            $query .= " AND `reduced_price` >= :minprice AND `reduced_price` <= :maxprice ";
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $query .= " AND `reduced_price` >= :minprice ";
        } elseif (is_numeric($maxprice) && (!is_numeric($minprice))) {
            $query .= " AND `reduced_price` <= :maxprice ";
        }
        
        $query .= " ORDER BY calculated_quality DESC LIMIT 256";
        $stmt = $this->db->prepare($query);
        
        if ((is_numeric($minprice) && (is_numeric($maxprice)) ) ) {
            $stmt->bindParam(':minprice', $minprice);
            $stmt->bindParam(':maxprice', $maxprice);
        } elseif ( is_numeric($minprice) && (!is_numeric($maxprice)) ) {
            $stmt->bindParam(':minprice', $minprice);
        } elseif ( is_numeric($maxprice) && (!is_numeric($minprice)) ) {
            $stmt->bindParam(':maxprice', $maxprice);
        }        
        
        $stmt->execute();
        
        $output = "\t\t<h2 class='results'>Highest rated ";
        $title = "Highest rated ";
        
        if (is_numeric($maxprice) && ($maxprice=="0")) {
            $output .= "<strong>free</strong> ";
            $title .= "free ";
        }         
        
        $output .= "Online courses ";
        $title .= "Online courses on CouponTrump" ;
        
        if (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>$minprice) ) {
            $output .= "priced from $" . $minprice . " to $" . $maxprice;
        } elseif (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice==$minprice) ) {
            $output .= "priced at $" . $maxprice;
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $output .= "priced $" . $minprice . " and over";
        } elseif (is_numeric($maxprice) && ($maxprice!=0) && (!is_numeric($minprice))) {
            $output .= "priced up to $" . $maxprice;
        }
        
        $output .= "</h2>\n";
        
        $output .= "\t\t<div class='course_list'>\n";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            include 'coupontrump-includes/course-list.inc.php';
        }
        $output .= "</div>\n";
        return array ('course_list' => $output, 'title' => $title);
    }  

  
  
  
    public function latest($minprice, $maxprice) {
        
        $query = "SELECT * FROM yourls_url WHERE " . COMMON_QUERY . " ";

        if ((is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>=$minprice)) ) {
            $query .= " AND `reduced_price` >= :minprice AND `reduced_price` <= :maxprice ";
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $query .= " AND `reduced_price` >= :minprice ";
        } elseif (is_numeric($maxprice) && (!is_numeric($minprice))) {
            $query .= " AND `reduced_price` <= :maxprice ";
        }
        
        $query .= " ORDER BY `added` DESC LIMIT 256";
        
        $stmt = $this->db->prepare($query);
        
        if ((is_numeric($minprice) && (is_numeric($maxprice)) ) ) {
            $stmt->bindParam(':minprice', $minprice);
            $stmt->bindParam(':maxprice', $maxprice);
        } elseif ( is_numeric($minprice) && (!is_numeric($maxprice)) ) {
            $stmt->bindParam(':minprice', $minprice);
        } elseif ( is_numeric($maxprice) && (!is_numeric($minprice)) ) {
            $stmt->bindParam(':maxprice', $maxprice);
        }
       
        $stmt->execute();
        
        $output = "\t\t<h2 class='results'>Latest ";
        $title = "Latest ";
        
        if (is_numeric($maxprice) && ($maxprice=="0")) {
            $output .= "<strong>free</strong> ";
            $title .= "free ";
        } 
        
        $output .= "additions to CouponTrump ";
        
        if (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice>$minprice) ) {
            $output .= "priced from $" . $minprice . " to $" . $maxprice;
        } elseif (is_numeric($minprice) && (is_numeric($maxprice)) && ($maxprice==$minprice) ) {
            $output .= "priced at $" . $maxprice;
        } elseif (is_numeric($minprice) && (!is_numeric($maxprice))) {
            $output .= "priced $" . $minprice . " and over";
        } elseif (is_numeric($maxprice) && ($maxprice!=0) && (!is_numeric($minprice))) {
            $output .= "priced up to $" . $maxprice;
        }
        
        $output .= "</h2>\n";
        
        $title .= "Courses recently added to CouponTrump";
      
        $output .= "\t\t<div class='course_list'>\n";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            include 'coupontrump-includes/course-list.inc.php';
        }
        $output .= "</div>\n";
        
        return array ('course_list' => $output, 'title' => $title);
    }   
  

  
    //public function recently_updated() {
    //    
    //    $query = "SELECT * FROM yourls_url WHERE " . COMMON_QUERY . " ORDER BY `updated` DESC LIMIT 256";
    //    $stmt = $this->db->prepare($query);
    //    $stmt->execute();
    //    
    //    $output = "\t\t<h2 class='results'>Recently updated</h2>";
    //    $title = "Courses recently updated on CouponTrump";
    //  
    //    $output .= "\t\t<div class='course_list'>\n";
    //    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //        include 'coupontrump-includes/course-list.inc.php';
    //    }
    //    $output .= "</div>\n";
    //    
    //    return array ('course_list' => $output, 'title' => $title);
    //}   

  
  
  
    public function deal($time_to_run, $expiring_time_to_run) {
        
        //$query = "SELECT * FROM yourls_url WHERE `coupon` = '" . BEST_COUPON . "'";
        //$query .= " AND " . COMMON_QUERY . " ORDER BY RAND() LIMIT 256";
        // Put this back after BF deal
        
        $query = "SELECT * FROM yourls_url WHERE `reduced_price` = '" . BEST_COUPON_PRICE . "'";
        $query .= " AND " . COMMON_QUERY . " ORDER BY RAND() LIMIT 256";
        
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        
        $output = '';
        
        if ( (defined('BEST_COUPON')) &&  ($time_to_run >= 0) ) {
            $title = "Find the latest online learning discounts on CouponTrump.com";

            $output = "\t\t<h2 class='results'>";
            $output .= "The current best discount coupon is <a target='_blank' href='http://coupontru.mp/" . strtolower(BEST_COUPON) . "'>" . BEST_COUPON . "</a><br>";
            $output .= "</h2>\n";
            
            if ( (defined('BEST_COUPON_IMAGE')) )  {
                $output .= "<div class='best_coupon_image'>\n";
                $output .= "\t\t<a target='_blank' href='http://coupontru.mp/" . strtolower(BEST_COUPON) . "'><img src='" . BEST_COUPON_IMAGE ."' style='width:100%'></a>\n";
                $output .= "</div>\n";
            }
            
            $output .= "<p class='deal'>";
            $output .= "Choose the courses you want using the search tools above or click the course links to go straight to the courses with the discount applied.<br><br>\n";
         
            if ($count>32) {
                $output .= "\t\t<div class='course_list'>\n";
           
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    include 'coupontrump-includes/course-list.inc.php';
                }
                
                $output .= "</div>\n";
            }
            
        }
        
        else {
            $results= new results($this->db);
            $output=$results->latest()['course_list'];
            $title = DEFAULT_TITLE;
        }
       
        return array ('course_list' => $output, 'title' => $title);
    }

  
  
    public function clicks_sum() {
        $query = "SELECT SUM(`clicks`) AS TotalClicks FROM `yourls_url`";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $output = 655530 + $row['TotalClicks'];
            //$output = number_format($row['TotalClicks']);
            $output = number_format($output);
        }
        return ": " . $output . " clicks and counting!";
    }

    
}
    
?>