<?php

set_include_path('../coupontrump-admin-includes/');

include '../coupontrump-includes/define-constants.inc.php';

function __autoload($class_name) {
    require_once '../coupontrump-admin-classes/' . $class_name . '.php';
}

require_once 'admin-connect.inc.php';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} else {
    echo "<h1 style='color: red'>Provide course slug</h1>";
    exit;
}

if (strpos($slug, '?course=')!==false) {
    $slug = explode('?course=', $slug)[1];
}

$now = time();
//$expires = $now + (60 * 60 * 24 * 7 ); // One week
$expires = $now + (60 * 60 * 24 * FEATURED_DAYS ); // FEATURED_DAYS constant set in define-constants.inc.php

$updated = date('Y-m-d H:i:s');
$expires = date('Y-m-d H:i:s', $expires);

$query = "UPDATE `yourls_url`
        SET `featured` = 'yes',
        `updated` = :updated,
        `featured_expires` = :expires
        WHERE `slug` = :slug";

$stmt = $db->prepare($query);    
$stmt->bindParam(':slug', $slug);
$stmt->bindParam(':updated', $updated);
$stmt->bindParam(':expires', $expires);

$stmt->execute();

echo "<h1>Setting as featured course:</h1>";

$url = "http://www.coupontrump.com?course=" . $slug;

echo "<a target='_blank' href='" . $url . "'>" . $url . "</a><br>";

?>

<p><a href="admin-panel.php">Back to admin panel</a></p>