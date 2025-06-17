<?php
// Turn on error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load config.php from the root folder
require_once __DIR__ . '/../config.php';

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Handle connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
