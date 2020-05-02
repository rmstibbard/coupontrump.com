<!DOCTYPE html>
    
    <html>
        <head>
            <title>Saving existing coupons</title>
        </head>
        <body>

<?php

ini_set('max_execution_time', 0);

if (isset($_GET['author'])) {
    $author = $_GET['author'];
}

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

$query = "SELECT * FROM `yourls_url` WHERE `course_url` LIKE 'https://www.udemy.com/%' ";

if (isset($author)) {
    $authormatch = "%" . $author . "%";
    $query .= " AND `author` LIKE :authormatch";
}

$stmt = $db->prepare($query);
if (isset($author)) {
    $stmt->bindParam(':authormatch', $authormatch);
}

$stmt->execute();
$count = $stmt->rowCount();
$a = 1;

?>


<h1>Saving existing coupons for <?php echo $count; ?> URLs</h1>

<table border=1 cellpadding=0 cellspacing=0>
    <tr>
        <td style="width: 150px; font-weight: bold;">Coupon</td>
        <td style="width: 900px; font-weight: bold;">Course URL</td>
        <td style="width: 100px; font-weight: bold;">Full price</td>
        <td style="width: 100px; font-weight: bold;">Reduced price</td>
        <td style="width: 100px; font-weight: bold;">x of <?php echo $count; ?></td>
    </tr>
    

<?php

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    
    $update_query = "UPDATE `yourls_url`
        SET `prev_coupon` = :coupon, `prev_url` = :url, `prev_reduced_price` = :reduced_price
        WHERE `course_url` = :course_url AND `active` = 'yes'";
    
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bindParam(':course_url', $row['course_url']);
    $update_stmt->bindParam(':url', $row['url']);
    $update_stmt->bindParam(':coupon', $row['coupon']);
    $update_stmt->bindParam(':reduced_price', $row['reduced_price']);
    $update_stmt->execute();
    
    echo "\t<tr>\n";
        echo "\t\t<td>" . $row['coupon']. "</td>\n";
        echo "\t\t<td>" . $row['course_url']. "</td>\n";
        echo "\t\t<td>$" . $row['full_price']. "</td>\n";
        echo "\t\t<td>$" . $row['reduced_price']. "</td>\n";
        echo "\t\t<td>" . $a. "/" . $count . "</td>\n";
    echo "\t</tr>\n";
    
    $a++;
}

// To do with MySQL:
// if deal set, exclude records with deal coupon:
    //UPDATE `yourls_url` SET `prev_coupon` = `coupon` , `prev_url` = `url` , `prev_reduced_price` = `reduced_price` WHERE (`active` = 'yes' AND `coupon` != 'bfearly10' AND `coupon` != '2015bf12')
//if no deal set:
    //UPDATE `yourls_url` SET `prev_coupon` = `coupon` , `prev_url` = `url` , `prev_reduced_price` = `reduced_price` WHERE `active` = 'yes'
    //
    // or
    //
    // UPDATE `yourls_url` SET `prev_coupon` = `coupon` , `prev_url` = `url` , `prev_reduced_price` = `reduced_price` WHERE `prev_coupon` !=""
//

?>

</table>

<h1>Done!</h1>

</body>
</html>