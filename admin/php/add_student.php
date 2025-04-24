<?php
// Assuming you already have a database connection
require_once '../config/db.php'; // Database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Capture form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $semester = $_POST['semester'];
    $batch = $_POST['batch'];
    $degree = $_POST['degree'];
    $department = $_POST['department'];
    $admission_date = $_POST['admission_date'];

    // Generate Student ID
    $student_id = generateStudentId($batch, $department, $degree, $conn);

    
    //hashing password
    $hashed_password = password_hash($student_id,PASSWORD_DEFAULT);

    // Insert data into the students table
    $query_students = "INSERT INTO students (roll_no, name, email, password, department, created_at) 
                       VALUES ('$student_id', '$first_name $last_name', '$email', '$hashed_password', '$department', NOW())";
    
    if (mysqli_query($conn, $query_students)) {
        // Insert data into the student_profile table
        $query_profile = "INSERT INTO student_profile (roll_no, batch, semester, gender, phone, address, admission_date, dob) 
                          VALUES ('$student_id', '$batch', '$semester', '$gender', '$phone', '$address', '$admission_date', NULL)";

        if (mysqli_query($conn, $query_profile)) {
            echo "Student added successfully!";
        } else {
            echo "Error adding student profile: " . mysqli_error($conn);
        }
    } else {
        echo "Error adding student: " . mysqli_error($conn);
    }
}

// Function to generate the student ID
function generateStudentId($batch, $department, $degree, $conn) {
    $departmentCode = substr($department, 0, 2);  // Example: CS for Computer Science
    $degreeCode = '';
    
    switch ($degree) {
        case 'B':
            $degreeCode = 'B';
            break;
        case 'M':
            $degreeCode = 'M';
            break;
        case 'P':
            $degreeCode = 'P';
            break;
    }
    
    $year = $batch;

    // Get the last student ID in the batch, department, and degree
    $query = "SELECT student_id FROM students WHERE student_id LIKE '$year$departmentCode$degreeCode%' ORDER BY student_id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $latest_student_id = $row['student_id'];
        $serial_number = (int) substr($latest_student_id, -3) + 1;
    } else {
        $serial_number = 1;
    }

    $serial_number = str_pad($serial_number, 3, '0', STR_PAD_LEFT);
    return $year . $departmentCode . $degreeCode . $serial_number;
}
?>
