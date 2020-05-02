<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']=='XMLHttpRequest')) {
    $id = $_POST['id'];
    
    function __autoload($class_name) {
        require_once '../coupontrump-classes/' . $class_name . '.php';
    }
    
    require_once '../coupontrump-includes/connect.inc.php';
    
    $build = new build($db);
    $output = $build->afflink($id);
    echo $output;
}
?>