<?php
set_include_path ('coupontrump-includes/');

require_once 'get-variables.inc.php';
require_once 'connect.inc.php';

function __autoload($class_name) {
    require_once 'coupontrump-classes/' . $class_name . '.php';
}


require_once 'head.inc.php';
require_once 'logo-social.inc.php';
require_once 'nav.inc.php';

?>

<div class="about_us">

<h1>About us</h1>

<img class="profile_pic" alt="Richard" src="images/Richard-profile.jpg">

<p>CouponTrump is the creation of Dr Richard Stibbard, formerly an academic working in
linguistics/phonetics/speech sciences and now web developer, online educator and, somewhat unexpectedly,
determined affiliate marketer!
</p>

<p>You can read more about me or take my courses on my e-learning website, <a target="_blank" href="http://www.webinaction.co.uk">Webinaction.co.uk</a> or see my free video tutorials on Youtube at
<a target="_blank" href="http://www.youtube.com/webinaction">www.youtube.com/webinaction</a>.
</p>

<p>If you need to contact me you can do so by email at <a href="mailto:info@coupontrump.com">info@coupontrump.com</a> or by post at:</p>

<div style="margin-left: 30px; margin-bottom: 20px">
	Richard Stibbard<br>
	20 Beeches Road<br>
	Cheltenham<br>
	Glos.<br>
	GL53 8NQ<br>
	UK
</div>

<p>I hope you enjoy using CouponTrump and find some great deals here - where the coupons are never out of date!

</p>


</div>

<?php require_once 'footer.inc.php'; ?>