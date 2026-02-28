<?php
require '../engine/sql.php';
try {
    $sqlSelect = "SELECT * FROM Pin";
    $result = $conn->query($sqlSelect);

    if ($result->num_rows > 0) {
        $pins = array();
        while ($row = $result->fetch_assoc()) {
            $pins[] = array("ID" => $row["ID"], "Name" => $row["Name"], "Icon" => $row["Icon"]);
        }
        echo json_encode($pins);
    } else {
        echo "0 results";
    }
} catch (Exception $e) {
    echo 'An error ocurred while fetching data.';
}


$conn->close();
