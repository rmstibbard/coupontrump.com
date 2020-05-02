<?php


echo "<h2><a href='admin-panel.php'>Back to admin panel</a></h2>\n";

if ($invalid_list!="") {
    echo "<h2>Invalid list</h2>\n";
    echo "<br>" . $invalid_list . "<br>\n";
} else {
    echo "<br>No invalid coupons found.";
}

$output .= "\nLog finished at " . $logtime . "\n\n";

echo "<br><h1>Done!</h1>\n";

?>

    </body>
</html>