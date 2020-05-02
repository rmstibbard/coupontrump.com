<?php

header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");

set_include_path('coupontrump-includes/');

require_once 'get-variables.inc.php';
require_once 'connect.inc.php';
require_once 'head.inc.php';
require_once 'logo-social.inc.php';
require_once 'nav.inc.php';

?>

<div style="text-align: center; margin-top: 60px">
<img src="images/not-found.gif">
<h2 style="font-size: 24px; text-align: center; margin-top: -20px; margin-bottom: 40px; line-height: 1.5em">The page you are looking for could not be found.<br>
Try <a href="index.php">returning to the homepage</a> to find great deals on Udemy courses.</h2>
</div>

<?php
require_once 'fb-conversion.inc.php';
require_once 'google-analytics.inc.php';
require_once 'statcounter.inc.php';
require_once 'mailchimp.inc.php';
require_once 'footer.inc.php';

?>