<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to your MySQL database (replace with your actual credentials)
$servername = "localhost";
$username = "igorj";
$password = "igorj";
$dbname = "mape";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>