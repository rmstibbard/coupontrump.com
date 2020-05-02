            
            <nav class="navbar navbar-inverse">
             <div class="container-fluid">
               <div class="navbar-header">
                 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                   <span class="icon-bar"></span>
                 </button>
                 <a class="navbar-brand btn-large glyphicon glyphicon-home home" href="index.php"></a>
               </div>
               <div class="collapse navbar-collapse" id="myNavbar">
                 <ul class="nav navbar-nav">

                    <?php
                    
                    if ( (defined('BEST_COUPON_PRICE')) && (!defined('EXPIRING_COUPON_PRICE')) ) {
                        $display_price = BEST_COUPON_PRICE;
                    }
                    
                    if ( (defined('BEST_COUPON_PRICE')) && (defined('EXPIRING_COUPON_PRICE')) ) {
                        if (BEST_COUPON_PRICE<=EXPIRING_COUPON_PRICE) {
                            $display_price = BEST_COUPON_PRICE;
                        }
                        if (BEST_COUPON_PRICE>EXPIRING_COUPON_PRICE) {
                            $display_price = EXPIRING_COUPON_PRICE;
                        }                        
                    }
                    
                        
                    
                    if ( (defined('BEST_COUPON')) &&  ($time_to_run >= 86400) ) {
                        // echo '<li class="deal"><a href="index.php?sort=deal">Last global $' . $display_price . ' deal!</a></li>';
                        echo '<li class="deal"><a href="index.php?sort=deal">Amazing $' . $display_price . ' deal!</a></li>';
                    }
                    
                    if ( (defined('BEST_COUPON')) &&  ($time_to_run < 86400) &&  ($time_to_run >= 0) ) {
                       // echo '<li class="deal"><a href="index.php?sort=deal">Last global $' . $display_price . ' deal - Expiring soon!</a></li>';
                       echo '<li class="deal"><a href="index.php?sort=deal">Amazing $' . $display_price . ' deal - Expiring soon!</a></li>';
                    }
                    
                    ?>
               
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle">Latest<b class="caret"></b>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?sort=latest">LATEST ADDITIONS</a></li>
                            <li><a href="index.php?sort=latest&maxprice=0">Latest free courses</a></li>
                            <li><a href="index.php?sort=latest&minprice=10&maxprice=10">Latest $10 courses</a></li>
                            <li><a href="index.php?sort=latest&minprice=11&maxprice=20">Latest $11 - $20</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle">Best rated<b class="caret"></b>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?sort=ratings">BEST STUDENT RATINGS</a></li>
                            <li><a href="index.php?sort=ratings&maxprice=0">Best rated free courses</a></li></a></li>
                            <li><a href="index.php?sort=ratings&minprice=10&maxprice=10">Best rated $10 courses</a></li>
                            <li><a href="index.php?sort=ratings&minprice=11&maxprice=20">Best rated $11 - $20</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle">Bestsellers<b class="caret"></b>
                        <ul class="dropdown-menu">
                            <li><a href="index.php?sort=pop">BESTSELLERS</a></li>
                            <li><a href="index.php?sort=pop&maxprice=0">Bestselling free courses</a></li>
                            <li><a href="index.php?sort=pop&minprice=10&maxprice=10">Bestselling $10 courses</a></li>
                            <li><a href="index.php?sort=pop&minprice=11&maxprice=20">Bestselling $11 - $20</a></li>
                        </ul>
                    </li>
					
					<li><a href="index.php?trending=yes">TRENDING NOW</a></li>

                 </ul>
                 <ul class="nav navbar-nav navbar-right">
                    <?php
                    // if (basename ($_SERVER['SCRIPT_FILENAME']) != "submit-courses.php")  {
                     //   echo "<li class='add'><a href='submit-courses.php'>Add/remove courses</a></li>";
                    // }
					?>
                   <!--li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                   <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li-->
                 </ul>
               </div>
             </div>
            </nav>
