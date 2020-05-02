<?php

set_include_path('coupontrump-includes/');

function __autoload($class_name) {
    require_once 'coupontrump-classes/' . $class_name . '.php';
}

require_once 'define-constants.inc.php';
require_once 'get-variables.inc.php';
require_once 'connect.inc.php';
require_once 'head.inc.php';
require_once 'logo-social.inc.php';
require_once 'nav.inc.php';

?>

<script src="scripts/submit-courses.js"></script>

        <div class="submit_urls">
            <h2>Add your courses to CouponTrump</h2>
            
            <p>Submissions are automatically checked and added if the price is either:</p>
            
            <ul>
                <li>$20 or less original price</li>
                <li>or reduced (by any amount) with a coupon code</li>
            </ul>
			
			<p>Courses submitted to CouponTrump <strong>must be complete and ready for sale</strong>,
			should be in a relevant affiliate program, and should either include a discount code
			or be priced at $20 or less. By submitting courses for inclusion on CouponTrump,
			you verify that they meet these conditions.
			</p>
            
            <p>CouponTrump automatically selects the <strong>cheapest coupons available</strong>
			so if you submit a coupon for a higher price than is already in the database, it will not be
			updated.</p>
			
            <p>To have a cheaper coupon replaced by a more expensive one, please <strong>do not use the form below</strong>.
			Instead, send an email to <a href="mailto:info@coupontrump.com">info@coupontrump.com</a> explaining
			that this is what you want.</p>
            
			<?php
			
			// echo "<p>Submit URLs in the format: <span style='font-family: monospace'>https://www.udemy.com/your-course-url/?couponCode=";
			
			//if (defined('BEST_COUPON')) {
			//	echo BEST_COUPON;
			//} else {
			//	echo "COUPON_NAME";
			//}
			
			echo "</span></p>";
			?>
		
            
            <form class="form" role="form" id="submit_urls" class="submit_urls" action="thank-you.php" method="post">
               <div id="form-group" class="input_fields_wrap" style="margin-top: 10px;">
                    <label class="sr-only" for="url">Course URL with coupon code:</label>
                    <div><input name='url[]' id='url[]' class='form-control'></div>
                    <div><input name='url[]' id='url[]' class='form-control'></div>
                    <div><input name='url[]' id='url[]' class='form-control'></div>
                    <div><input name='url[]' id='url[]' class='form-control'></div>
                    <div><input name='url[]' id='url[]' class='form-control'></div>
                </div>
                <button class="btn add_field_button">Add more input fields</button>
                
                <p style="margin-top: 30px">And/or paste multiple URLs from a text file or spreadsheet:</p>

                <div style="margin-top: 10px;">          
                    <label class="sr-only" for="multiple_urls">Course URLs with coupon code:</label>
                    <textarea id="multiple_urls" name="multiple_urls"></textarea>
                </div>
                
               <!-- <div style="margin-top: 10px;">          
                    <label for="email" style="float: left; width: 20%">Your email address:</label>
                    <input type="text" id="email" name="email" style="float: right; width: 80%">
                </div>-->
				
                <button id="submit_urls" class="btn btn-primary">Submit your courses</button>
            </form>
			
        </div>
		
		<div class="remove_courses">
			<h2>Remove courses</h2>
			
			<p>If for any reason your courses are listed here and should not be, or you do not wish them to be,
			please send an email to <a href="mailto:info@coupontrump.com">info@coupontrump.com</a> and I will
			remove them straightaway.</p>
		</div>

<?php require_once 'footer.inc.php'; ?>