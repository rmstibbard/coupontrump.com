<?php
error_reporting(E_ALL);

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

ini_set("display_errors", "1");

error_reporting(E_ALL);

set_include_path('../coupontrump-admin-includes/');

include '../coupontrump-includes/define-constants.inc.php';

$log_file = "../coupontrump-logs/tweet-log.csv";

$add_to_log = fopen($log_file, "a");

if (filesize($log_file)==0) {
    $log_output = "Time,Cat,Subcat,Author,Keyword,Minprice,Maxprice,Order,Min interval,Max interval\n";
} else {
    $log_output = "";
}


$page_title = "Tweets";
$heading = "<h1>";

require_once 'head.inc.php';
require_once 'admin-connect.inc.php';

$now = time();
$server_offset = 60 * 60 * 5;  

if (!isset($_GET['start_in'])) {
    $start_delay = 60 * 60 * 0.25;         // Delay (hours) before first tweet: 60 secs * 10 = 10 mins
} else {
    $start_in = $_GET['start_in'];
    $start_delay = 60 * 60 * $start_in;  // Use ?start_in= to set custom delay before first tweet in hours
}

if (isset($_GET['min_interval'])) {
    $min_interval = $_GET['min_interval'];    
} else {
    $min_interval = 5;
}

if (isset($_GET['max_interval'])) {
    $max_interval = $_GET['max_interval'];        
} else {
    $max_interval = 10;
}

if (isset($_GET['no_of_tweets'])) {
    $no_of_tweets = $_GET['no_of_tweets'];        
} else {
    $no_of_tweets = 500;
}

$start_time = $now + SERVER_OFFSET + $start_delay ;
$scheduled_time = $start_time;
$log_output .= date('j M Y H:i:s',$now + SERVER_OFFSET) . ",";

$query = "SELECT * FROM `yourls_url` WHERE " . COMMON_QUERY;
$query .= " AND `author` NOT LIKE '%Pablo%Navarro%' ";
$query .= " AND `twitter` NOT LIKE '%zenvatweets%' ";

if ((isset($_GET['cat']) && ($_GET['cat']!=""))) {
    $cat = $_GET['cat'];
    echo "Category set $cat<br>";
    $cat_match = "%" . $cat . "%";
    $query .= " AND `cat` LIKE '" . $cat_match . "' ";
    $heading .= "Courses in Category " . strtoupper($cat) . " - ";
    $log_output .= $cat . ",";
} else {
    $log_output .= ",";
}

if ((isset($_GET['subcat']) && ($_GET['subcat']!=""))) {
    $subcat = $_GET['subcat'];
    echo "Subcat set $subcat<br>";
    $subcat_match = "%" . $subcat . "%";
    $query .= " AND `subcat` LIKE '" . $subcat_match . "' ";
    $heading .= "Courses in Subcategory " . strtoupper($subcat) . " - ";
    $log_output .= $subcat . ",";
} else {
    $log_output .= ",";
}

if ((isset($_GET['author']) && ($_GET['author']!=""))) {
    $author = $_GET['author'];
    echo "Author set $author";
    $author_match = "%" . $author . "%";
    $query .= " AND `author` LIKE '" . $author_match . "' ";
    $heading .= "Courses by " . strtoupper($author) . " - ";
    $log_output .= $author . ",";
} else {
    $log_output .= ",";
}

if ((isset($_GET['keyword']) && ($_GET['keyword']!=""))) {
    $keyword = $_GET['keyword'];
    echo "Keyword set $keyword";
    $keyword_match = "%" . $keyword . "%";
    $query .= " AND (`title` LIKE '" . $keyword_match . "' OR `subtitle` LIKE '" . $keyword_match . "') ";
    $heading .= "Courses with keyword " . strtoupper($keyword) . " - ";
    $log_output .= $keyword . ",";
} else {
    $log_output .= ",";
}

if ( (isset($_GET['minprice'])) && (is_numeric($_GET['minprice'])) ) {
    $minprice = $_GET['minprice'];
    $query .= " AND `reduced_price` >= '" . $minprice . "'" ;
    $heading .= " - Courses priced above $" . $minprice . " - ";
    $log_output .= $minprice . ",";
} else {
    $log_output .= ",";
}

if ( (isset($_GET['maxprice'])) && (is_numeric($_GET['maxprice'])) ) {
    $maxprice = $_GET['maxprice'];
    $query .= " AND `reduced_price` <= '" . $maxprice . "'" ;
    $heading .= " - Courses priced below $" . $maxprice . " - ";
    $log_output .= $maxprice . ",";
} else {
    $log_output .= ",";
}

if (isset($_GET['order'])) {
    $order = $_GET['order'];
    $log_output .= $order . ",";
}

if ($order=="latest") {    
    $query .= " ORDER BY `added` DESC LIMIT " . $no_of_tweets . " ";
    $heading .= "Latest Additions";
}
    
if ($order=="quality") {
    $query .= " ORDER BY `calculated_quality` DESC LIMIT " . $no_of_tweets . " ";
    $heading .= "Highest Student Ratings";
}
    
if ($order=="pop") {
    $query .= " ORDER BY `clicks` DESC  LIMIT " . $no_of_tweets . " ";
    $heading .= "Most Popular";
}
    
if ($order=="deal") {
    $query .= " AND `coupon` = '" . BEST_COUPON . "' ORDER BY RAND() LIMIT " . $no_of_tweets . " ";
    $heading .= "Current Deal";
}

if ($order=="featured") {
    $query = "SELECT * FROM `yourls_url` WHERE " . COMMON_QUERY;
    $query .= " AND `author` NOT LIKE '%Pablo%Navarro%' ";
    $query .= " AND `twitter` NOT LIKE '%zenvatweets%' ";    
    $query .= " AND `featured` = 'yes' ";
    $heading = "<h1>Featured Courses</h1>";
}


$log_output .= $min_interval . ",";
$log_output .= $max_interval . "\n";


fwrite ($add_to_log, $log_output) ;

$heading .= "</h1>\n";

$stmt = $db->prepare($query);
$stmt->execute();

echo $heading;
echo "<pre>\n";
echo "<span style='font-size: 12pt'>\n";


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $tweet_interval = 60 * (rand($min_interval, $max_interval)); // Random interval 5-10 mins between tweets: 60 secs * 5 = 5 mins
    
    $scheduled_time = $scheduled_time + $tweet_interval;
    
    if ($_GET['platform']=="hootsuite") {
        $scheduled_time_csv = date('d/m/Y H:i', $scheduled_time); // Format time for Hootsuite CSV file
    }
    
    if ($_GET['platform']=="socialpilot") {
        $scheduled_time_csv = date('Y-m-d H:i', $scheduled_time); // Format time for SocialPilot CSV file
    }

    $id = $row['id'];
    $coupon=$row['coupon'];
    $clicks = $row['clicks'];

    $dbase_title = stripslashes($row['title']);
    $dbase_title = str_replace(",", "", $dbase_title);
    $dbase_title = str_replace(".", "", $dbase_title);
    
    $dbase_author = stripslashes($row['author']);
    $dbase_twitter = $row['twitter'];
    $dbase_full_price = $row['full_price'];
    $dbase_reduced_price = $row['reduced_price'];
    $dbase_keyword = $row['keyword'];
    
    if ($_GET['platform']=="hootsuite") {
        $linkString = ",http://coupontrump.com/?id=" . $id;
    }
    
    if ($_GET['platform']=="socialpilot") {
        $linkString = " http://coupontrump.com/?id=" . $id;
    }

    
    $titleString = str_replace(" - ", " ", $dbase_title);
    
    $keyword = array(
        "Angular", "Actionscript","Android", "Bootstrap", "NodeJS", "PHP", "CSS", "ExpressJS", "Apex", "PSD", 
        "HTML5", "Java", "jQuery", "MySQL", "Servlet", "Docker", "DevOps", "Django", "SAP ", "SAPUI5", 
        "iOS", "Genealogy", "Guitar", "CodeIgniter", "Flask", "WCF", "API", "LESS", "SASS", "Zend", 
        "Pentesting", "Metasploit", "Alkaline", "Linux", "Unix", "CodeIgnitor","KnockoutJS", "Captcha", 
        "LAMP","XAMPP","Amazon", "C Programming", "C Plus", "C++", "Python","Microsoft","Lumen", "Homestead",
        "Excel","Access","Agile", "Git","Entrepren", "JIRA","Responsive","RWD", "NLP", "Laravel", "RESTful", 
        "Oracle","Hadoop","R12","XSLT","Xpath","ITIL","AJAX","CCNA","CMS","XML", "Stripe", 
        "Brand","HTML","CFA","Ruby","Rails","Pascal","Stencyl","Selenium","Lightroom","Apache",
        "Camtasia","iPhone","BGP","Cisco","Wordpress","Drupal","Joomla","Ableton", "Meteor", "MongoDB", 
        "Pinterest","Facebook","Twitter","LinkedIn","Youtube","Market","Keynote","AWS",
        "Globalniche","Crowdfund","Photo","Virus","Dreamweaver","AutoCAD", "Forex","JSON", "ASP Net",
        "Body Language","Lie Detect","Social Media","SocialMedia","Adword","Copyright",
        "Copywrit","Russian", "Web Develop", "Unity", "Training", "Woo", "eCommerce","ReactJS",
        "SEO", "BlackBerry","Adobe", "Illustrator", "Teaching", "Career", "Wishlist",
        "eMember", "eStore", "Startup", "Blog", "Confiden", "NoSQL", "Design", "Logo", "Swift",
        "DISC Assessment Tool", "Business", "Backtrack", "Illustr", "Finance", "Eclipse", "InfoSec",
        "Theme", "Merger", "Acquisi", "Backbone", "Web host", "Chrome Store", "EFT", "Storytelling",
        "Trauma", "Therap", "Fiverr", "CPA", "Affiliat", "Hacking", "Bitcoin" , "Hypno",
        "Fear", "Dentist", "Instagram", "Poker", "Autis", "OrientDB", "Podcast", "Scrivener", "Dropbox",
        "Network", "Spanish", "Scraping", "Testosterone", "eLearning", "SQLite", "Accounting", "Communic",
        "Singapore", "Novel", "Statistics", "Kindle", "Neuro", "PMP", "Trading", "Stocks", "Yoga", "SQL"
        
    );
    
   
    foreach ($keyword as $hashtag) {
        $titleString = str_ireplace($hashtag, "#$hashtag", $titleString);
    }
    
    
    $titleString = str_ireplace("#C Plus Plus","#C++", $titleString);
    $titleString = str_ireplace("Splash Page","#SplashPage", $titleString);
    $titleString = str_ireplace("Big Data","#BigData", $titleString);
    $titleString = str_ireplace("Google Local","#GoogleLocal", $titleString);
    $titleString = str_ireplace("Data Mining","#DataMining", $titleString);
    $titleString = str_ireplace("Stock Trading","#Stocktrading", $titleString);
    $titleString = str_ireplace("Real Estate","#RealEstate", $titleString);
    $titleString = str_ireplace("Udemy by","by", $titleString);
    $titleString = str_ireplace("Self defen","#SelfDefen", $titleString);
    $titleString = str_ireplace("Foundation 6","#Foundation6", $titleString);
    $titleString = str_ireplace("Pay per click","#PPC", $titleString);
    $titleString = str_ireplace("Back Pain","#BackPain", $titleString);
    $titleString = str_ireplace("#Kali #Linux","#kalilinux", $titleString);
    $titleString = str_ireplace("#Mergers and #Acquisitions","#MergersandAcquisitions", $titleString);
    $titleString = str_ireplace("#Responsive #Webdesign","#RWD", $titleString);
    $titleString = str_ireplace("#Responsive #Webdevelopment","#RWD", $titleString);
    $titleString = str_ireplace("Actionscript 3","Actionscript3", $titleString);
    $titleString = str_ireplace("CCNA Security","CCNASecurity", $titleString);
    $titleString = str_ireplace("Chrome Store","#ChromeStore", $titleString);
    $titleString = str_ireplace("Emotional Intelligence","#EmotionalIntelligence", $titleString);
    $titleString = str_ireplace("Java 8","Java8", $titleString);
    $titleString = str_ireplace("Stock #Market","#StockMarket", $titleString);
    $titleString = str_ireplace("Object Oriented Programming","#OOP", $titleString);
    $titleString = str_ireplace("Penetration Testing","#Pentesting", $titleString);
    $titleString = str_ireplace("Public Relations","#PR", $titleString);
    $titleString = str_ireplace("Social Media","#SocialMedia", $titleString);
    $titleString = str_ireplace("i#","#i", $titleString);
    $titleString = str_ireplace("D#iGital","#Digital", $titleString);
    $titleString = str_ireplace("User Experience","#UX", $titleString);
    $titleString = str_ireplace("E-Commerce","#Ecommerce", $titleString);
    $titleString = str_ireplace("Web #Design","#Webdesign", $titleString);
    $titleString = str_ireplace("My#SQL","#MySQL", $titleString);
    $titleString = str_ireplace("No#SQL","#NoSQL", $titleString);
    $titleString = str_ireplace("#Microsoft #Excel","#MSExcel", $titleString);
    $titleString = str_ireplace("Web Develop","#Webdevelop", $titleString);
    $titleString = str_ireplace("Web Host","#Webhost", $titleString);
    $titleString = str_ireplace("Web Scrap","#WebScrap", $titleString);
    $titleString = str_ireplace("Whitehat #Hack","#WhitehatHack", $titleString);
    $titleString = str_ireplace("Growth #Hacking","#GrowthHacking", $titleString);
    $titleString = str_ireplace("C#APItal","#Capital", $titleString);
    
    
    
    $titleString = str_ireplace(" and "," & ", $titleString);
    $titleString = str_ireplace("the "," ", $titleString);
    $titleString = str_ireplace("   "," ", $titleString);
    $titleString = str_ireplace("  "," ", $titleString);
    $titleString = str_replace(".", "", $titleString);
    $titleString = str_replace(",", " ", $titleString);

    $titleString = trim($titleString);
    
    if ($_GET['platform']=="socialpilot") {
        $imageString = $row['image_url'];
    }
    
    
    $priceString = " Was $" . $dbase_full_price . " Now $" . $dbase_reduced_price;
    
    if ($dbase_reduced_price < $dbase_full_price) {
        $priceString = " Was $" . $dbase_full_price . " Now just $" . $dbase_reduced_price;
    }
    
    if (($dbase_full_price!=0) && ($dbase_reduced_price==0)) {
        $priceString = " Was $" . $dbase_full_price . " Now FREE!";
    }
    
    if (($dbase_reduced_price==$dbase_full_price)) {
        $priceString = " Just $" . $dbase_reduced_price;
    }
    
    if (($dbase_reduced_price==0) && ($dbase_full_price==0)) {
        $priceString = " FREE COURSE";
    }
    
    if ( ($dbase_author!="") && ($dbase_twitter!="") ) {
        $authorString = " by @$dbase_twitter";
    }
    
    if ( ($dbase_author!="") && ($dbase_twitter=="") ) {
        $authorString = " by $dbase_author";
    }
    
    if ( ($dbase_author=="") && ($dbase_twitter=="") ) {
        $authorString = "";
    }
    
    $authorString = str_replace("@@", "@", $authorString);
    $authorString = str_replace("https://twitter.com/", "", $authorString);
    $authorString = str_replace(",/", " ", $authorString);
    $authorString = str_replace(",", " ", $authorString);
    $authorString = str_replace("Patrick Howell Certified Master Trainer on Udemy", "Patrick Howell", $authorString);
    $authorString = str_replace("Online Business Systems Coach Mubarak Shah", "Mubarak Shah", $authorString);
    $authorString = str_replace("TweakCoder eLearning Solutions", "TweakCoder", $authorString);
    $authorString = str_replace("Joe Parys Academy", "", $authorString);
    
    
    $titleString = str_replace(".", "", $titleString);
    $titleString = str_replace(",", " ", $titleString);
    $titleString = str_replace("  ", " ", $titleString);
    
  
    if ( strlen($catString) + strlen($titleString) + strlen($authorString) + strlen($linkString) <= 140 ) {
        $tweetString = $catString . $titleString . $authorString . $priceString . $linkString;
    } elseif ( strlen($catString) + strlen($titleString) + strlen($linkString) <= 140 ) {
        $tweetString = $catString . $titleString . $priceString . $linkString;
    } elseif (  strlen($titleString) + strlen($linkString) <= 140 ) {
        $tweetString = $titleString . $linkString;
    }
    
    if ($_GET['platform']=="hootsuite") {
        $tweetString = $scheduled_time_csv . "," . $tweetString;
    }
    

 
    $tweetString = str_ireplace("#CFA #CFA", "#CFA", $tweetString);
    $tweetString = str_ireplace("#Excel #Excel", "#Excel", $tweetString);
    $tweetString = str_ireplace("Bootstr#Apper","#Bootstrapper", $tweetString);
    $tweetString = str_ireplace("Copy#Writing","#Copywriting", $tweetString);
    $tweetString = str_ireplace("Di#Gital","Digital", $tweetString);
    $tweetString = str_ireplace("Fl#App","#Flapp", $tweetString);
    $tweetString = str_ireplace("H#App","#Happ", $tweetString);
    $tweetString = str_ireplace("R#Estore","Restore", $tweetString);
    $tweetString = str_ireplace("Hypno#Therapy","#Hypnotherapy", $tweetString);
    $tweetString = str_ireplace("Aroma#Therapy","#Aromatherapy", $tweetString);
    
    $tweetString = str_ireplace("#Udemy", "", $tweetString);
    $tweetString = str_ireplace("Udemy", "", $tweetString);
    $tweetString = str_replace("  ", " ", $tweetString);
    $tweetString = str_replace(" ,", ", ", $tweetString);
    $tweetString = str_ireplace("##","#", $tweetString);
    
    $tweetString .= " #ad ";
    
    if ($_GET['platform']=="socialpilot") {
        $tweetString = $tweetString . "," . $imageString.  "," . $scheduled_time_csv;
    }    
    
    echo $clicks . "," . trim($tweetString) . "\n";
    
    
   

}

fclose($add_to_log);

?> 
</span></pre>

<h1><a href="admin-panel.php">Back to admin panel</a></h1>

</body>
</html> 