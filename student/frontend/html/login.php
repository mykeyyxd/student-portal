<?php
include_once('../config/db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $roll_no = $_POST['roll_no'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM students WHERE roll_no = ?");
    $stmt->bind_param("s", $roll_no); // 's' means string type
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Password matches, proceed with login
            session_start();
            $_SESSION['student_id'] = $row['roll_no']; // Store the roll_no in session
            
            // Redirect to the student dashboard or home page
            header("Location: /miniproject/student/frontend/html/student-dashboard/student-dashboard-ui.php");
            exit();
        } else {
            // Invalid password
            echo "<script>alert('Invalid password. Please try again.');</script>";
        }
    } else {
        // No such user found
        echo "<script>alert('No account found with that roll number.');</script>";
    }

    // Close the statement
    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="../css/login.css">
    <title>Login Page</title>
</head>
<body>
    <div id="canvas-container"></div> <!-- This holds the Three.js animation -->

    <div class="login-container">
        <div class="auth-container">
            <h2>Login</h2>


            <form id="loginForm" method="POST">
                <label for="roll_no">Roll Number:</label>
                <input type="text" id="roll_no" name="roll_no" required />
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required />
                <button type="submit" class="login-button">Login</button>
            </form>

            <div class="separator">--------OR--------</div>
        </div>

        <div class="google_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="sign_in_with" data-size="large" data-logo_alignment="left"></div>

        <button id="googleSignInPlaceholder" style="width: 100%; padding: 12px; background-color: #4285F4; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 15px; display: flex; align-items: center; justify-content: center; font-size: 16px;">
            <img src="../images/google-logo.svg" alt="Google Logo" style="width: 20px; height: 20px; margin-right: 10px;">
            Sign in with Google
        </button>

        <script type="module" src="../js/main.js"></script>
    </div>
</body>
</html>
