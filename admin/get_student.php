<?php
include_once('config/db.php');

if (isset($_GET['roll_no'])) {
    $roll_no = $_GET['roll_no'];
    
    $stmt = $conn->prepare("SELECT s.name, s.email, sp.phone, sp.address FROM students s JOIN student_profile sp ON s.roll_no = sp.roll_no WHERE s.roll_no = ?");
    $stmt->bind_param("s", $roll_no);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'student' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Student not found']);
    }

    $stmt->close();
}
?>