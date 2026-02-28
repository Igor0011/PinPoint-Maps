<?php
require '../engine/sql.php';
try {
    if ($_POST['deleteType'] == 1 && $_POST['pass'] == '123') {
        $sql = "DELETE FROM coordinate";
        $stmt = $conn->prepare($sql);
        echo "All pins removed<br>";
    }
    if ($_POST['deleteType'] == 0) {
        $pinID = $_POST['pin-id'];
        // Prepare and bind SQL statement to insert pin data
        $sql = "DELETE FROM coordinate WHERE ID = $pinID";
        $stmt = $conn->prepare($sql);
        //$stmt->bind_param("sdd", $pinName, $pinLatitude, $pinLongitude);
    }
    // Execute SQL statement
    if ($stmt->execute()) {
        echo "Pin deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} catch (Exception $e) {
    echo 'ID not set.';
}
$stmt->close();
$conn->close();
