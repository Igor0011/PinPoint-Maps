<?php
require '../engine/sql.php';
date_default_timezone_set('Europe/Belgrade');
$ID = 0;
$ID = $_POST['value'];
$currentDateTime = date('Y-m-d H:i:s');
try{
    $sqlUpdate = "UPDATE coordinate 
              SET ConfirmCount = ConfirmCount + 1, 
                  LastConfirmTime = '$currentDateTime' WHERE ID = $ID";
    $conn->query($sqlUpdate);

    $sqlSelect = "SELECT * FROM coordinate WHERE ID = $ID";
    $result = $conn->query($sqlSelect);
    $row = $result->fetch_assoc();
    echo $row['ConfirmCount'];
}
catch (Exception $e){
    echo 'ID not set.';
}
$conn->close();
