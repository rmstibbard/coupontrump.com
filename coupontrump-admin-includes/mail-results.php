<?php
$to = 'info@coupontrump.com';
$subject = 'New course submission';

$message = "<html><body>" . $message . "</body></html>";

$headers = 'From: info@coupontrump.com' . "\r\n" .
    'Reply-To: info@coupontrump.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";    

mail($to, $subject, $message, $headers);
?>