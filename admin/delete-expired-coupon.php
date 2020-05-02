<html>
    
    <head>
        <title>Delete expired coupon</title>
    </head>
    <body>


<?php

if ( (isset($expired_coupon)) && ($expired_coupon!="") ) {
    
    $delete_query = "DELETE FROM `yourls_url` WHERE `keyword` = :expired_coupon";
    $delete_stmt = $db->prepare($delete_query);
    $delete_stmt->bindParam(':expired_coupon', $expired_coupon);
    $delete_stmt->execute();
    
    echo "<h1>Expired coupon '" . strtoupper($expired_coupon) . "' deleted</h1>";
 
} else {
    echo "<h1>No expired coupon set</h1>";
}

?>

    </body>
</html>