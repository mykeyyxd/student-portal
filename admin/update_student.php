<?php
include_once('config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roll_no = $_POST['roll_no'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Update students table
    $stmt1 = $conn->prepare("UPDATE students SET name = ?, email = ? WHERE roll_no = ?");
    $stmt1->bind_param("sss", $name, $email, $roll_no);
    $stmt1->execute();
    $stmt1->close();

    // Update student_profile table
    $stmt2 = $conn->prepare("UPDATE student_profile SET phone = ?, address = ? WHERE roll_no = ?");
    $stmt2->bind_param("sss", $phone, $address, $roll_no);
    $stmt2->execute();
    $stmt2->close();

    echo "Student updated successfully!";
}
?>
