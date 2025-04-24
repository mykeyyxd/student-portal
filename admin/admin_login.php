<?php
session_start();
include_once('config/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['adminEmail']);
    $password = $_POST['adminPassword'];

    // Prepare statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['password'])) {
            // Successful login
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: admin-dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('No admin account found with that email.');</script>";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Login</title>
  <link rel="stylesheet" href="admin_login.css" />
</head>
<body>
  <div class="gradient"></div>

  <div class="login-container">
    <form method="POST" action="admin_login.php">
      <h2>Admin Login</h2>

      <div class="input-group">
        <label for="adminEmail">Email</label>
        <input type="email" name="adminEmail" id="adminEmail" placeholder="Enter your email" required />
      </div>

      <div class="input-group">
        <label for="adminPassword">Password</label>
        <input type="password" name="adminPassword" id="adminPassword" placeholder="Enter your password" required />
      </div>

      <button class="login-button" type="submit">
        Login
      </button>

      <div class="separator">or</div>

      <div id="googleSignInPlaceholder">
        <span>Sign in with Google</span>
      </div>
    </form>
  </div>
</body>
</html>
