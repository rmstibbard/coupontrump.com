
       
            <div class="instructions">
              <p class="add_courses">
                Courses submitted to CouponTrump must be complete and ready for sale and should either
                include a discount code or be priced at $20 or less. 
                By submitting courses for inclusion on CouponTrump, you verify that they meet these conditions.<br>
                CouponTrump is an affiliate site and takes a percentage of sales revenue; if you do not want to
                market your courses in this way, please do not add them to this site.<br>
                <?php
                if (basename ($_SERVER['SCRIPT_FILENAME']) == "feature-me.php")  {
                    echo "<strong>N.B.: Inclusion in the premium \"Featured Courses\" section is no guarantee of sales</strong><br>";
                } else {
                    echo "<br>";
                }

                //if (basename ($_SERVER['SCRIPT_FILENAME']) != "submit-courses.php")  {
                //    echo "<a href='submit-courses.php'>Add/remove your courses for free here</a> - it's easy - just enter the URLs!<br>";
                //} else {
                //    echo "<br>";
                //}
                
                ?>
                
                Email: contact - at - coupontrump - dot - com | 
                <a href="http://www.twitter.com/coupontrump" target="_blank">Twitter</a> | 
                <a href="https://www.facebook.com/coupontrump" target="_blank">Facebook</a>
              </p>
              <p class="cookies">
                 CouponTrump sets cookies to process discounted links to courses,
                 collect anonymous statistics, and remember your preferences. You can set your browser to reject cookies, in which case the site will still work but this personalisation will not be available.<br>
                 By using the site you are agreeing to this use of cookies and our <a href="privacy-policy.php">privacy policy</a>.
              </p>
            </div>
              
            <footer>
             <p class="disclaimer">Disclaimer: All links are affiliate links.<br>
             All course images, titles and descriptions are copyrighted by individual
             course creators and/or the platform(s) on which they are hosted.</p>
             <p class="updated">Coupon codes updated <?php echo date('j M Y') . "."; ?>
             </p>
            </footer>
        
        </div> <!-- End container-fluid  -->
    </body>
</html>