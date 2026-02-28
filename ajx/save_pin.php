<?php
require '../engine/sql.php';

// Get POST data from AJAX request and sanitize inputs
$pinID = $_POST['pin-id'];
$pinName = $_POST['pin-name'];
$pinLatitude = $_POST['pin-latitude'];
$pinLongitude = $_POST['pin-longitude'];
$selectedPin = $_POST['selected-pin'];
date_default_timezone_set('Europe/Belgrade');
$currentDateTime = date('Y-m-d H:i:s');

function sanitizeForMySQL($string, $maxLength = 50, $mysqliConnection) {
    // Step 1: Remove all non-alphanumeric characters except for whitespace
    $string = preg_replace('/[^a-zA-Z0-9 ]/', '', $string);

    // Step 2: Trim the string to the maximum length
    $string = mb_substr($string, 0, $maxLength, 'UTF-8');

    // Step 3: Ensure the string is valid UTF-8
    if (!mb_check_encoding($string, 'UTF-8')) {
        $string = mb_convert_encoding($string, 'UTF-8');
    }

    // Step 4: Escape special characters for MySQL
    return $mysqliConnection->real_escape_string($string);
}

try {
    // Ensure the latitude and longitude are numeric
    if (!is_numeric($pinLatitude) || !is_numeric($pinLongitude)) {
        throw new Exception("Invalid latitude or longitude.");
    }

    // Prepare the SELECT statement for coordinates
    $sqlSelect = "SELECT * FROM coordinate WHERE Lat = ? AND Lon = ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("dd", $pinLatitude, $pinLongitude);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the SELECT statement for pin icon
    $sqlSelectPin = "SELECT Icon FROM Pin WHERE ID = ?";
    $stmtPin = $conn->prepare($sqlSelectPin);
    $stmtPin->bind_param("i", $selectedPin);
    $stmtPin->execute();
    $resultPin = $stmtPin->get_result();
    $rowPin = $resultPin->fetch_assoc();

    if ($result->num_rows > 0) {
        // Update existing record
        $sqlUpdate = "UPDATE coordinate SET Name = ?, PinType = ? WHERE ID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $sanitizedPinName = sanitizeForMySQL($pinName, 50, $conn);
        $stmtUpdate->bind_param("sii", $sanitizedPinName, $selectedPin, $pinID);
        $stmtUpdate->execute();

        // Fetch and return updated data
        $pins = array();
        while ($row = $result->fetch_assoc()) {
            $pins[] = array(
                "ID" => $row['ID'],
                "Icon" => $rowPin["Icon"],
                "Name" => $sanitizedPinName,
                "ApproveCount" => $row['ConfirmCount']
            );
        }
        echo json_encode($pins);
    } else {
        // Insert new record
        $sqlInsert = "INSERT INTO coordinate (Name, Lat, Lon, ConfirmCount, LastConfirmTime, PinType) VALUES (?, ?, ?, 1, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $sanitizedPinName = sanitizeForMySQL($pinName, 50, $conn);
        $stmtInsert->bind_param("sddsi", $sanitizedPinName, $pinLatitude, $pinLongitude, $currentDateTime, $selectedPin);
        if ($stmtInsert->execute()) {
            $inserted_id = $conn->insert_id;

            // Return new pin data
            $pins[] = array(
                "ID" => $inserted_id,
                "Icon" => $rowPin["Icon"],
                "Name" => $sanitizedPinName,
                "ApproveCount" => 1
            );
            echo json_encode($pins);
        } else {
            throw new Exception("Error inserting pin: " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo json_encode(array("error" => $e->getMessage()));
}
 finally {
    // Close all statements and connection
    $stmt->close();
    $stmtPin->close();
    if (isset($stmtUpdate)) $stmtUpdate->close();
    if (isset($stmtInsert)) $stmtInsert->close();
    $conn->close();
}
