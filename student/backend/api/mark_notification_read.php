<?php
require_once '../config/db.php'; 

header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['notification_id'])) {
    echo json_encode(["success" => false, "message" => "Missing notification ID"]);
    exit();
}

$notification_id = $data['notification_id'];

$query = "UPDATE notifications SET is_read = 1 WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $notification_id);
$success = $stmt->execute();

echo json_encode(["success" => $success]);
?>
