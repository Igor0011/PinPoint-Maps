<?php
require '../engine/sql.php';

try {
    // Define the cutoff time for deletion (24 hours ago)
    $cutoffTime = date('Y-m-d H:i:s', strtotime('-24 hours'));

    // Delete coordinates older than 24 hours
    $deleteSql = "DELETE FROM coordinate WHERE LastConfirmTime < ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("s", $cutoffTime);
    $stmt->execute();
    $stmt->close();

    // Query to fetch pins data
    $sql = "SELECT coordinate.ID, Lat, Lon, coordinate.Name as CoordinateName, 
        LastConfirmTime, PinType, Pin.Icon as PinPath, ConfirmCount
        FROM coordinate JOIN Pin ON coordinate.PinType = Pin.ID WHERE 1";
    
    if (isset($_POST['pin-id'])) {
        if ($_POST['pin-id'] != 0) {
            $sql .= ' AND Pin.ID=' . $_POST['pin-id'];
        }
    }

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $pins = array();
        while ($row = $result->fetch_assoc()) {
            $pins[] = array(
                "ID" => $row["ID"],
                "lat" => $row["Lat"],
                "lng" => $row["Lon"],
                "name" => $row["CoordinateName"],
                "last" => $row["LastConfirmTime"],
                "PinType" => $row["PinType"],
                "PinPath" => $row["PinPath"],
                "ConfirmCount" => $row["ConfirmCount"]
            );
        }
        echo json_encode($pins);
    } else {
        echo "0 results";
    }
} catch (Exception $e) {
    echo 'An error occurred while fetching data: ' . $e->getMessage();
}

$conn->close();
?>
