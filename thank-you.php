<?php

set_include_path('coupontrump-includes/');

function __autoload($class_name) {
    require_once 'coupontrump-classes/' . $class_name . '.php';
}

require_once 'get-variables.inc.php';
require_once 'connect.inc.php';

if ( (isset($_POST['email']) )  && ($_POST['email'] != "") )  {
	$email = trim(strtolower($_POST['email']));
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		//
	} else {
		$email = "Invalid: " . $email;
	}
} else {
	$email = "Unspecified";
}

if ( (isset($_POST['url']) && (sizeof($_POST['url'])>0)  )) {
    $urls = $_POST['url'];
	$urls = str_ireplace("http://", "https://", $urls);
    
    for($i=0;$i<(sizeof($urls));$i++) {
        if (strpos($urls[$i], "https://www.udemy.com") !==false) {
			$courses[$i] = trim($urls[$i]);
        }
    }

}  

if (isset($courses)) {
    $no_in_array = sizeof($courses);
} else {
    $no_in_array = 0;
}

if ( (isset($_POST['multiple_urls']) ) && ($_POST['multiple_urls'] != "") ) {
    $multiple_urls = $_POST['multiple_urls'];
    
    $multiple_urls = str_ireplace("https://", PHP_EOL . "https://", $multiple_urls);
    $multiple_urls = str_ireplace("http://", PHP_EOL . "https://", $multiple_urls);
    
    $multiple_urls = explode(PHP_EOL , $multiple_urls);
    
    for($i=0;$i<(sizeof($multiple_urls));$i++) {
        if (strpos($multiple_urls[$i], "https://www.udemy.com") !==false) {
            $courses[$i+$no_in_array] = trim($multiple_urls[$i]);
        }
    }    
}

if (isset($courses)) {
    $courses = array_unique($courses);
    $count = sizeof($courses);
} else {
    $courses = "";
    $count = 0;
}

if ($count>0) {
    $page_title = "Thank you";
} else {
    $page_title = "No valid Udemy URLs received";
}

require_once 'head.inc.php';
require_once 'logo-social.inc.php';
require_once 'nav.inc.php';


if ((isset($courses)) && ($count>0) ) {

	$data_file = "coupontrump-data/add-new.txt";
	$email_file = "coupontrump-logs/emails.txt";
	$record_file = "coupontrump-logs/submitted.csv";
	
    $add_new_data = fopen($data_file, "a");
    $add_new_record = fopen($record_file, "a");
	$add_new_email = fopen($email_file, "a");
	
    $output = "<div class='thank_you'>";
    $output .= "<h2>Thank you - Your courses will be checked and added very soon.</h2>\n";
    $output .= "<p>Valid URLs received:</p>\n";
    $output .= "<ol>\n";	
	
    foreach ($courses as $course) {

		if (strpos($course, '?u=')!==false) {
			$course = explode('?u=', $course)[1];
			$course = urldecode($course);
		}
		
		if (strpos($course, 'RD_PARM1=')!==false) {
			$course = explode('RD_PARM1=', $course)[1];
			$course = urldecode($course);
		}

        if (strpos($course, '%3Fdtcode')!==false) {
            $course = explode('%3Fdtcode', $course)[0];
        }

        if (strpos($course, '?dtcode')!==false) {
            $course = explode('?dtcode', $course)[0];
        }
		
        if (strpos($course, '#')!==false) {
            $course = explode('#', $course)[0];
        }
		
        if (strpos($course, '%2526')!==false) {
            $course = explode('%2526', $course)[0];
        }
        
        if (strpos($course, '&siteID')!==false) {
            $course = explode('&siteID', $course)[0];
        }

        if (strpos($course, '?siteID')!==false) {
            $course = explode('?siteID', $course)[0];
        }
		
		if (strpos($course, '&couponCode')!==false) {
            $course = explode('?couponCode', $course)[0];
		}
		
		if (strpos($course, 'udemy.com//')!==false) {
			$course = str_replace('udemy.com//', 'udemy.com/',$course);
		}
		
		if ( ($email!="Unspecified") && (strpos($email, "Invalid") ==false) ) {
			if( strpos(file_get_contents($email_file),$email) === false) {
				fwrite ($add_new_email, $email . "\n");
			} 
		}
		
        $add_to_data_file = trim($course) . "\n";
        fwrite ($add_new_data, $add_to_data_file);
		
		$add_to_record_file = $email . "," . trim($course) . "\n";
        fwrite ($add_new_record, $add_to_record_file);
		
		$output .= "<li>" . $course . "</li>";
    }

    $output .= "</ol>\n";
    
    $output .= "<h3><a href='index.php'>Return to CouponTrump deals</a>";
    $output .= " or <a href='submit-courses.php'>add more courses</a></h3>";
    $output .= "</div>\n";
	
	fclose($add_new_data);
    fclose($add_new_record);
    
	if ( ($_SERVER['REMOTE_ADDR'] == MY_IP_ADDRESS) || ($_SERVER['REMOTE_ADDR'] == NAMECHEAP_IP_ADDRESS) ) {
		$sender = "Richard";
		$subject = "New course submission from Richard\n";
		$message = "Sender: Richard\n";
	} else {
		$sender = $_SERVER['REMOTE_ADDR'];
		$subject = "Your submission to CouponTrump has been received\r\n";
		$message = "Sender: " . $email . " from IP address " . $sender . "\r\n";
	}
		
	$headers = "From: info@coupontrump.com\r\n";
	$headers .= "Reply-To: info@coupontrump.com\r\n";
	if ($sender != "Richard") {
		$headers .= "CC: info@coupontrump.com\r\n";
	}
	$headers .= "X-Mailer: PHP/" . phpversion();
    
    
    foreach ($courses as $course) {
        $message .= $course . "\n"; 
    }            
    
	if ( ($email!="Unspecified") && (strpos($email,"Invalid:")==false) ) {
		$to = $email;
		
	} else {
		$to = "info@coupontrump.com";
	}
	
	mail($to, $subject, $message, $headers);
	

} else {
    $output = "<div class='thank_you'>\n";
    $output .= "<h2 class='error'>No valid URLs received</h2>\n";
    $output .= "<h3><a href='index.php'>Return to CouponTrump deals</a>";
    $output .= " or <a href='submit-courses.php'>add more courses</a></h3>\n";
    $output .= "</div>";
}

echo $output;

include 'footer.inc.php';
    
?>