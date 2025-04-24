<?php
require_once '../config/db.php'; // Ensure DB connection

header("Content-Type: application/json");

// Fetch unread notifications
$query = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode(["success" => true, "notifications" => $notifications]);
?>
