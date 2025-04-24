<?php
header("Content-Type: application/json"); // Ensure JSON response
require_once("../config/db.php");

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit();
}

// Read the incoming JSON data
$data = json_decode(file_get_contents("php://input"), true);

// Debugging: Print what PHP is receiving
error_log(print_r($data, true)); // This logs to Apache's error.log

if (!isset($data['roll_number']) || !isset($data['password'])) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit();
}

$roll_number = $data['roll_number'];
$password = $data['password'];
$stmt = $conn->prepare("SELECT password FROM students WHERE roll_number = ?");
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Query preparation failed"]);
    exit();
}

$stmt->execute([$roll_number]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && password_verify($password, $result['password'])) {
    session_start();
    $_SESSION['roll_no'] = $roll_number; // Store roll number in session
    echo json_encode(["success" => true, "message" => "Login successful"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid roll number or password"]);
}
?>
