<?php

set_include_path('../coupontrump-admin-includes/');

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}


$page_title = "Admin Panel";

require_once 'admin-connect.inc.php';
require_once '../coupontrump-includes/define-constants.inc.php';
require_once 'head.inc.php';


?>

<h1>Admin Panel</h1>

<div style="float: left; margin-left: 20px; padding-left: 15px; width: 470px; background-color: #ffffcc;
    border: 1px solid grey; border-radius: 5px">
    <h2>Server info</h2>

    <?php echo "<p>Server time: " . date('H:i:s d/m/Y') . "<br>";
    
    echo "Cron style: " . date('i G d n');
    
    if ($_SERVER['REMOTE_ADDR'] != MY_IP_ADDRESS) {
            echo "<span style='color: red'>";
    }
    if ($_SERVER['REMOTE_ADDR'] == MY_IP_ADDRESS) {
        echo "<span style='color: green'>";
    } 
    
    echo "<br>Server IP address: " . $_SERVER['REMOTE_ADDR'] . "<br>";
    echo "IP address in 'define constants': " . MY_IP_ADDRESS . "</span></p>";
    
    ?>
    
</div>

    <form action="../scrape/scrape-udemydealimage.php" method="get" style="float: left">
        <fieldset>
            <legend>Scrape Udemy deal image</legend>
            
            <label for="coupon">Coupon</label>
            <input type="text" name="coupon"><br>
          
            <button>Scrape Udemy deal image</button>
        </fieldset>
    </form>
    
     <div style="clear: both"></div>

    <form action="tweet.php" method="get" style="float: left">
        <fieldset>
            <legend>Generate tweets</legend>
        
            <label for="no_of_tweets">No. of tweets</label>
            <input type="text" name="no_of_tweets" value="500"><br>
        
            <label for="start_in">Start in (hours)</label>
            <input type="text" name="start_in" value="5.30"><br>
            
            <label for="min_interval">Min. interval (mins)</label>
            <input type="text" name="min_interval" value="5"><br>
                
            <label for="max_interval">Max. interval (mins)</label>
            <input type="text" name="max_interval" value="20"><br>
    
            <label for="author">Author</label>
            <input type="text" name="author"><br>
    
            <label for="keyword">Keywords</label>
            <input type="text" name="keyword"><br>
            
            <label for="cat">Category</label>
            <input type="text" name="cat"><br>
            
            <label for="subcat">Subcategory</label>
            <input type="text" name="subcat"><br>
            
            <label for="minprice">Min price ($)</label>
            <input type="text" name="minprice" value="0"><br>
            
            <label for="maxprice">Max price ($)</label>
            <input type="text" name="maxprice" value="10"><br>
    
            <label for="order">Type</label>
            <select name="order">
                <option value="latest">Latest</option>
                <option value="quality">Quality</option>
                <option value="pop">Popular</option>
                <option value="deal">Deal</option>
                <option value="featured">Featured</option>
            </select><br>
            
            <label for="platform">Platform</label><br>
            <input type="radio" name="platform" value="socialpilot" checked="checked">SocialPilot<br style="height: 0.25em">
            <input type="radio" name="platform" value="hootsuite">Hootsuite<br>
                
            <button>Generate tweets</button>
        </fieldset>
        
    </form>
    
    
    <form action="check-database.php" method="get" style="float: left">
        <fieldset>
            <legend>Check database</legend>
            
            <label for="coupon">By coupon</label>
            <input type="text" name="coupon"><br>
            
            <label for="added">By date added</label>
            <input type="text" name="added"><br>

            <label for="updated">Updated before</label>
            <input type="text" name="updated" value="<?php echo date('Y-m-d'); ?>"><br>
            
            <label for="id">By ID</label>
            <input type="text" name="id"><br>
            
            <label for="course_id">By course ID</label>
            <input type="text" name="course_id"><br>        
            
            <label for="course_url">By course URL</label>
            <input type="text" name="course_url"><br>        
            
            <label for="author">By author</label>
            <input type="text" name="author"><br>        

            <label for="slug">By slug</label>
            <input type="text" name="slug"><br>

            <label for="title">By title</label>
            <input type="text" name="title"><br>

            <label for="featured">Featured</label>
            <input type="checkbox" name="featured" style="width: 20px; text-align: left;"><br>            
            
            <label for="inactive">Inactive only</label>
            <input type="checkbox" name="inactive" style="width: 20px; text-align: left;"><br>
        
            <button>Check database</button>
        </fieldset>
    </form>
    
    <div style="clear: both"></div>
    
    <form action="aff-link-with-coupon.php" method="get" style="float: left">
        <fieldset>
            <legend>Add coupon to affiliate link</legend>
            
            <label for="coupon_to_add">Coupon to add</label>
            <input type="text" name="coupon_to_add"><br>

            <button>Add coupon to affiliate link</button>
        </fieldset>
    </form>
        
    
    <form action="aff-link-no-coupon.php" method="get" style="float: left">
        <fieldset>
            <legend>Remove coupon from affiliate link</legend>
            
            <label for="coupon_to_remove">Coupon to remove</label>
            <input type="text" name="coupon_to_remove"><br>

            <button>Remove coupon from affiliate link</button>
        </fieldset>
    </form>
    
    <div style="clear: both"></div>
    
    <form action="insert-best-coupon.php" method="get" style="float: left">
        <fieldset>
            <legend>Insert best coupon</legend>
            <label for="best_coupon">Insert best coupon</label>
            <input type="text" name="best_coupon"><br>        
            <button>Insert coupon</button>
        </fieldset>
    </form>        
            
    <form action="delete-expired-coupon.php" method="get" style="float: left">
        <fieldset>
            <legend>Delete expired coupon</legend>
            <label for="expired_coupon">Delete expired coupon</label>
            <input type="text" name="expired_coupon"><br>        
            <button>Delete expired coupon</button>
        </fieldset>
    </form>
            
    <div style="clear: both"></div>
            
    <form action="restore-prev-coupon.php" method="get" style="float: left">
        <fieldset>
            <legend>Restore previous coupons</legend>
            
            <label for="coupon">Invalid coupon</label>
            <input type="text" name="invalid_coupon"><br>

            <button>Restore previous coupons</button>
        </fieldset>
    </form>         

    <form action="make-json.php" method="get" style="float: left">
        <fieldset>
            <legend>Make JSON file</legend>
            <button>Make JSON file</button>
        </fieldset>
    </form>            
            
    <div style="clear: both"></div>

    <form action="set-as-featured.php" method="get" style="float: left">
        <fieldset>
            <legend>Set as featured course</legend>
            
            <label for="coupon">Slug</label>
            <input type="text" name="slug"><br>

            <button>Set as featured course</button>
        </fieldset>
    </form> 

    <form action="unset-as-featured.php" method="get" style="float: left">
        <fieldset>
            <legend>Unset as featured course</legend>
            
            <label for="coupon">Slug</label>
            <input type="text" name="slug"><br>

            <button>Unset as featured course</button>
        </fieldset>
    </form>
    
    <div style="clear: both"></div>


    
    
    <div style="clear: both"></div>
    
        <form action="list-urls-with-coupon.php" method="get"  style="float: left">
        <fieldset>
            <legend>List URLs with coupon</legend>
            
            <label for="existing_coupon">List by coupon</label>
            <input type="text" name="existing_coupon"><br>
            
            <label for="author">List by author</label>
            <input type="text" name="author"><br>        
            
            <label for="new_coupon">New coupon</label>
            <input type="text" name="new_coupon"><br>

            <label for="exclude_urls_with_coupon">Exclude w/coupon</label>
            <input type="text" name="exclude_urls_with_coupon"><br>
            
            <label for="inactive">Inactive only</label>
            <input type="checkbox" name="inactive" style="width: 20px; text-align: left;"><br>
            
            <button>List URLs</button>
        </fieldset>
    </form>

    <div style="float: left">
        <form action="../scrape/scrape-by-author.php" method="get"  style="float: left">
            <fieldset>
                <legend>Scrape by author</legend>
                
                <label for="author">Author name</label>
                <input type="text" name="author"><br>
    
                <label for="add_coupon">Add coupon</label>
                <input type="text" name="add_coupon"><br>
                
                <button>Scrape by author</button>
            </fieldset>
        </form>
        
    </div>



</body>
</html>