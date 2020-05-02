<?php

if ( $_SERVER['REMOTE_ADDR'] == MY_IP_ADDRESS) {
    $sender = "Richard";
} else {
    $sender = $_SERVER['REMOTE_ADDR'];
}

$end_time = date('Y-m-d-H-i');
$to      = 'info@coupontrump.com';
$subject = "Add new completed at " . date('Y-m-d-H-i');
$headers = 'From: info@coupontrump.com' . "\n" . 'Reply-To: info@coupontrump.com' . "\n" . 'X-Mailer: PHP/' . phpversion();

$message = "Sender: " . $sender . "\n\n";
    
if (isset($new_courses)) {
    $message .= $mail_message;
}

mail($to, $subject, $message, $headers);
?>