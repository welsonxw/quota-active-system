<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default for XAMPP
$database = "db_student"; // Replace with your actual DB name\
$conn = new mysqli($servername, $username, $password, $database); // <== changed to $mysqli

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
