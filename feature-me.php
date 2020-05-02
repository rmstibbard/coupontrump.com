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

<script src="scripts/submit-courses.js"></script>

        <div class="featured">
            <h2>Feature your Udemy courses in prime position on CouponTrump</h2>
            <br>
            <p>CouponTrump's visitor count has been growing every month since our launch and has now reached
			over 7000 unique visitors per month!</p>
			
			<p>To benefit from this exposure you can have your course listed in the premium "Featured Courses"
			spot at the top of the front page on CouponTrump - One month costs just $30 per course and a
			maximum of <strong>eight courses</strong> will be accepted for this prime spot.</p>
			
			<div style="margin-left: auto; margin-right: auto; text-align: center; margin-bottom: 50px">
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="UYBTSQH5ZGTAY">
				<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
				<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
				</form>
			</div>
			
			<p>
			<span class="paypal_instructions">After logging into Paypal you will see a field
			for "Special Instructions". You MUST ENTER your valid course URL and coupon code in the format
			<span style="font-family: monospace">https://www.udemy.com/your-course-url/?couponCode=COUPON_NAME</span>
			in this box. No refund will be given if you fail to provide a valid course URL which fulfills the
			requirements for submission (see footer).</span></p>

		</div>
            

<?php require_once 'footer.inc.php'; ?>