<?php

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {

    function __autoload($class_name) {
        require_once '../coupontrump-classes/' . $class_name . '.php';
    }
    
    require_once '../coupontrump-includes/connect.inc.php';
    
    $results = new results($db);
    $output = $results->clicks_sum();
    echo $output;
}
?>