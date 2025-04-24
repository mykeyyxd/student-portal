<?php
// Database configuration
$servername = "localhost"; // Database server
$username = "root";        // Database username
$password = "root";            // Database password
$dbname = "student_portal"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>