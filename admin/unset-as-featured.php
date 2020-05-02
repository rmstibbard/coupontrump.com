<?php

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
} else {
    echo "<h1 style='color: red'>Provide course slug</h1>";
    exit;
}

if (strpos($slug, '?course=')!==false) {
    $slug = explode('?course=', $slug)[1];
}


$updated = date('Y-m-d H:i:s');

$query = "UPDATE `yourls_url`
        SET `featured` = 'no',
        `updated` = :updated,
        `featured_expires` = NULL
        WHERE `slug` = :slug";

$stmt = $db->prepare($query);    
$stmt->bindParam(':slug', $slug);
$stmt->bindParam(':updated', $updated);
$stmt->execute();

echo "<h1>Unsetting as featured course:</h1>";

$url = "http://www.coupontrump.com?course=" . $slug;

echo "<a target='_blank' href='" . $url . "'>" . $url . "</a><br>";

?>

<p><a href="admin-panel.php">Back to admin panel</a></p>