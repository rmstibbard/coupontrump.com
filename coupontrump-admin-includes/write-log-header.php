<?php
$logtime = date('Y-m-d-H-i');
$filename = basename($_SERVER["SCRIPT_FILENAME"], '.php');
$logfilename = '../coupontrump-logs/' . $logtime . "-" .  $filename . ".csv";

$logfile = fopen($logfilename, "w");

$log_header = "URL Count,Notes,Course URL,Coupon,Slug,Title,Author,Twitter,Full price,Reduced price,Expiry date\n";

fwrite($logfile, $log_header);

$invalid_list = "";
$output = "Notes, URL, Author, Twitter, Full price, Reduced price, Expiry date\n";

?>