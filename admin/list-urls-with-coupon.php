<?php

require_once '../coupontrump-admin-includes/admin-connect.inc.php';

if ( (isset($_GET['inactive'])) && (($_GET['inactive']) == "on") ) {
    $inactive = "yes";
} else {
    $inactive = "no";
}

if (isset($_GET['existing_coupon'])) {
    $existing_coupon = $_GET['existing_coupon'];
}  

if (isset($_GET['exclude_urls_with_coupon'])) {
    $exclude_urls_with_coupon = $_GET['exclude_urls_with_coupon'];
}  

if (isset($_GET['new_coupon'])) {
    $new_coupon = $_GET['new_coupon'];
}  

if (isset($_GET['author'])) {
    $author = $_GET['author'];
    $author_match = "%" . $author . "%";
} 

if ($existing_coupon!="") {
    $query = "SELECT `course_url` FROM `yourls_url` WHERE `course_url` LIKE '%https://www.udemy.com/%' ";
    if ($inactive=="yes") {
        $query .= " AND `active` != 'yes' ";
    }
    $query .= " AND `coupon` = :existing_coupon ";
    $stmt = $db->prepare($query);    
    $stmt->bindParam(':existing_coupon', $existing_coupon);
    
} elseif ($author!="") {
    $query = "SELECT `course_url` FROM `yourls_url` WHERE `course_url` LIKE '%https://www.udemy.com/%'
        AND `author` LIKE :author_match ";
    if ($inactive=="yes") {
        $query .= " AND `active` != 'yes' ";
    }
    $query .= "ORDER BY id ASC ";
    $stmt = $db->prepare($query);    
    $stmt->bindParam(':author_match', $author_match);
    
} elseif ($exclude_urls_with_coupon!="") {
    $exclude_urls_with_coupon = "%" . $exclude_urls_with_coupon . "%";
    $query = "SELECT `course_url` FROM `yourls_url` WHERE `course_url` LIKE '%https://www.udemy.com/%'
        AND `coupon` NOT LIKE :exclude_urls_with_coupon ";
    if ($inactive=="yes") {
        $query .= " AND `active` != 'yes' ";
    }
    $query .= "ORDER BY id ASC ";
    $stmt = $db->prepare($query);    
    $stmt->bindParam(':exclude_urls_with_coupon', $exclude_urls_with_coupon);
    
} else {
    $query = "SELECT `course_url` FROM `yourls_url` WHERE `course_url` LIKE '%https://www.udemy.com/%' ";
    if ($inactive=="yes") {
        $query .= " AND `active` != 'yes' ";
    }
    
    $query .= " ORDER BY id ASC ";
    $stmt = $db->prepare($query);    

}

$stmt->execute();

echo "<h1>Listing course URLs ";

if ($existing_coupon!="") {
    echo "with existing coupon '" . $existing_coupon . "' ";
}

if ($author!="") {
    echo "by author '" . $author . "' ";
}

if ($inactive=="yes") {
    echo "inactive only";
}

echo " adding new coupon '" . $new_coupon . "'</h1>";

echo "<ol>";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($new_coupon!="") {
        echo "<li>" . $row['course_url'] . "?couponCode=". $new_coupon . "</li>";
    } else {
        echo "<li>" . $row['course_url'] . "</li>";
    }
}

echo "</ol>";

echo "<h1>Done!</h1>";

?>