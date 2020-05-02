<?php

$logtime = date('Y-m-d-H-i');

set_include_path('../coupontrump-admin-includes/');

require_once 'admin-connect.inc.php';

$page_title = "Generating JSON data";

require_once 'head.inc.php';

$jsonfilename = '../coupontrump-logs/' . $logtime . "-coupontrump.json";

$jsonfile = fopen($jsonfilename, "w");
$json_header = "courses:[\n";
fwrite($jsonfile, $json_header);

//echo "<pre>";
//echo $json_header;

echo "Creating JSON file... ";

$query = "SELECT * FROM `yourls_url`
            WHERE `active`= 'yes'
            AND `url` != ''
            AND`course_url` LIKE '%udemy.com/%'
            ORDER BY `added` DESC";

$stmt = $db->prepare($query);
$stmt->execute();

$count = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { // Start of main loop
    
       
    //if ($row['reduced_price'] < $row['full_price'] ) {
        
        $added = substr($row['added'], 0, 10);

        $json_output = "\t{\n";
        $json_output .= "\t\t'__class': 'course',\n";
       // $json_output .= "\t\t'count': " . $count . ",\n";

        if ($added!="0000-00-00") {
            $json_output .= "\t\t'date_added': '" . $added . "',\n";
        } else {
            $json_output .= "\t\t'date_added': '',\n";
        }

        if (strpos($row['notes'], "NEW COURSE") != "") {
            $json_output .= "\t\t'new_course': 'yes',\n";
        } else {
            $json_output .= "\t\t'new_course': 'no',\n";
        }

        $json_output .= "\t\t'id': " . $row['course_id'] . ",\n";
        $json_output .= "\t\t'title': '" . $row['title'] . "',\n";
        $json_output .= "\t\t'subtitle': '" . $row['subtitle'] . "',\n";
        $json_output .= "\t\t'author': '" . $row['author'] . "',\n";
        $json_output .= "\t\t'full_price': " . $row['full_price'] . ",\n";
        $json_output .= "\t\t'reduced_price': " . $row['reduced_price'] . ",\n";
        
        if ($row['reduced_price'] == 0) {
            $json_output .= "\t\t'free_course': 'yes',\n";
        } else {
            $json_output .= "\t\t'free_course': 'no',\n";
        }
        
        $json_output .= "\t\t'coupon': '" . $row['coupon'] . "'\n";
        $json_output .= "\t},\n";
        
        // echo $json_output;
        
        fwrite($jsonfile, $json_output);
        
        $count++;
    //}

}

$json_footer = "]";

//echo $json_footer;
//echo "</pre>";


fwrite($jsonfile, $json_footer);
fclose($jsonfile);

echo "<br><br>JSON file created and saved in " . $jsonfilename . "<br><br>";
echo "<h1><a href='admin-panel.php'>Back to admin panel</a></h1>";


?>