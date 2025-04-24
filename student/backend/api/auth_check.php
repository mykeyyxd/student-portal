<?php
session_start();
header("Content-Type: application/json");

if (isset($_SESSION['roll_no'])) {
    echo json_encode(["logged_in" => true, "roll_number" => $_SESSION['roll_no']]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>
