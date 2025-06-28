<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default for XAMPP
$database = "db_student"; // Replace with your actual DB name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
