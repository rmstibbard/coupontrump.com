<?php

ob_start();

set_include_path('coupontrump-includes/');

set_time_limit(0);

require_once 'get-variables.inc.php';
require_once 'connect.inc.php';

function __autoload($class_name) {
    require_once 'coupontrump-classes/' . $class_name . '.php';
}

$build = new build($db);
$results = new results($db);

require_once 'head.inc.php';
require_once 'logo-social.inc.php';
require_once 'nav.inc.php';
require_once 'search.inc.php';

if ( ($sort=="") && ($author=="") && ($keywords=="") && ($cat=="") && ($subcat=="") && ($maxprice=="") && ($id=="") && ($slug=="") && ($trending!="yes") ) {
    // include 'affs.inc.php';
}

?>


<?php
echo $page_output;

if ( ($sort=="") && ($author=="") && ($keywords=="") && ($cat=="") && ($subcat=="") && ($maxprice=="") && ($id=="") && ($slug=="") && ($trending!="yes") ) {
    // include 'bottom-affs.inc.php';
}

require_once 'fb-conversion.inc.php';
require_once 'google-analytics.inc.php';
require_once 'statcounter.inc.php';
//require_once 'mailchimp.inc.php';
require_once 'footer.inc.php';

?>