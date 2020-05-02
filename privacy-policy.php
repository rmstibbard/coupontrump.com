<?php

set_include_path('coupontrump-includes/');

require 'get-variables.inc.php';
require 'connect.inc.php';

function __autoload($class_name) {
    require_once 'coupontrump-classes/' . $class_name . '.php';
}

$results = new results($db);

require 'head.inc.php';
require 'logo-social.inc.php';
require 'nav.inc.php';

?>

<div class="privacy_policy">

<h1>Privacy Policy</h1>

<p>Thank you for visiting CouponTrump. By using this web site, you agree to the terms of this privacy policy.</p>

<h2>The information we collect</h2>

<p>CouponTrump.com does not collect any personal information from you. No personal or financial information is asked for in order for you to benefit from the special offers listed.</p>

<h2>Cookies</h2>

<p>CouponTrump.com uses cookies to store information and prepare customized pages which show courses
you may be interested in based on your earlier browsing patterns. Cookies are small text files that
we transfer into your computer drive that tell us on an anonymous basis what courses visitors
have looked at on the site. Your browser software can be set to reject all cookies.</p>

<h2>Disclosure of information</h2>

We will not share your personal information with any third parties.
The only instances where we might have to release such personal information would be in order to
comply with a valid legal requirement (e.g., a regulation, a search warrant, a court order, etc.). In such
an eventuality we would notify you before releasing any information unless doing so would violate a law or
court order.</p>


<h2>Third-Party Advertising</h2>

<p>CouponTrump advertises only Udemy courses and selected online learning sites.</p>


</div>

<?php require_once 'footer.inc.php'; ?>