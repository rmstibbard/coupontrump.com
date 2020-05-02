<?php

if (isset($_GET['backup_file']) && $_GET['backup_file']!="") {
    $backup_file = $_GET['backup_file'] . '.sql';
} else {
    echo "No backup file name provided!";
    exit;
}

$backup_path = '../db-backups/';
$backup_time = date('Y-m-d-H-i',filemtime($backup_path . $backup_file));

rename($backup_path . $backup_file, $backup_path . $backup_time . "-" . $backup_file);

?>
