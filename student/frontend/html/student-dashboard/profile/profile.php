<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: ../../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="profile.css" />
  <title>Profile Card</title>
</head>
<body>
  <!-- Sliding Sidebar Trigger -->
  <div class="menu-trigger">
    <div class="bars">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <p>Menu</p>
    <div class="menu">
      <div class="sidebar">
        <ul>
          <li><a href="../student-dashboard-ui.php">Dashboard</a></li>
          <li><a href="../courses/courses.php">Courses</a></li>
          <li><a href="../grades/grades.php">Grades</a></li>
          <li><a href="../attendance/attendance.php">Attendance</a></li>
          <li><a href="../../logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Profile Card -->
  <div class="profile-card">
    <div class="card-bg">
      <!-- SVG background animation -->
      <svg viewBox="0 0 100 100" preserveAspectRatio="xMidYMid slice">
        <defs>
          <radialGradient id="Gradient1" cx="50%" cy="50%" fx="0.441602%" fy="50%" r=".5">
            <animate attributeName="fx" dur="34s" values="0%;3%;0%" repeatCount="indefinite" />
            <stop offset="0%" stop-color="rgba(255, 0, 255, 1)" />
            <stop offset="100%" stop-color="rgba(255, 0, 255, 0)" />
          </radialGradient>
          <radialGradient id="Gradient2" cx="50%" cy="50%" fx="2.68147%" fy="50%" r=".5">
            <animate attributeName="fx" dur="23.5s" values="0%;3%;0%" repeatCount="indefinite" />
            <stop offset="0%" stop-color="rgba(255, 255, 0, 1)" />
            <stop offset="100%" stop-color="rgba(255, 255, 0, 0)" />
          </radialGradient>
          <radialGradient id="Gradient3" cx="50%" cy="50%" fx="0.836536%" fy="50%" r=".5">
            <animate attributeName="fx" dur="21.5s" values="0%;3%;0%" repeatCount="indefinite" />
            <stop offset="0%" stop-color="rgba(0, 255, 255, 1)" />
            <stop offset="100%" stop-color="rgba(0, 255, 255, 0)" />
          </radialGradient>
        </defs>
        <rect x="13.744%" y="1.18473%" width="100%" height="100%" fill="url(#Gradient1)" transform="rotate(334.41 50 50)">
          <animate attributeName="x" dur="20s" values="25%;0%;25%" repeatCount="indefinite" />
          <animate attributeName="y" dur="21s" values="0%;25%;0%" repeatCount="indefinite" />
          <animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="7s" repeatCount="indefinite" />
        </rect>
        <rect x="-2.17916%" y="35.4267%" width="100%" height="100%" fill="url(#Gradient2)" transform="rotate(255.072 50 50)">
          <animate attributeName="x" dur="23s" values="-25%;0%;-25%" repeatCount="indefinite" />
          <animate attributeName="y" dur="24s" values="0%;50%;0%" repeatCount="indefinite" />
          <animateTransform attributeName="transform" type="rotate" from="0 50 50" to="360 50 50" dur="12s" repeatCount="indefinite" />
        </rect>
        <rect x="9.00483%" y="14.5733%" width="100%" height="100%" fill="url(#Gradient3)" transform="rotate(139.903 50 50)">
          <animate attributeName="x" dur="25s" values="0%;25%;0%" repeatCount="indefinite" />
          <animate attributeName="y" dur="12s" values="0%;25%;0%" repeatCount="indefinite" />
          <animateTransform attributeName="transform" type="rotate" from="360 50 50" to="0 50 50" dur="9s" repeatCount="indefinite" />
        </rect>
      </svg>
    </div>

    <div class="profile-header">
      <label for="profile-image-input">
        <img src="pp.png.png" alt="Profile Picture" class="profile-image" id="profile-image" />
      </label>
      <input type="file" id="profile-image-input" accept="image/*" style="display: none;" />
      <h1 class="profile-name">John Doe</h1>
    </div>

    <div class="profile-details">
      <p><strong>Roll No:</strong> 123456</p>
      <p><strong>Email:</strong> johndoe@example.com</p>
      <p>
        <strong>Phone:</strong>
        <span id="phone-display">(123) 456-7890</span>
        <input type="text" id="phone-input" value="(123) 456-7890" style="display: none;" />
      </p>
      <p><strong>Department:</strong> Computer Science</p>
      <p>
        <strong>Address:</strong>
        <span id="address-display">123 Main St, City, Country</span>
        <input type="text" id="address-input" value="123 Main St, City, Country" style="display: none;" />
      </p>
      <p><strong>Year:</strong> 3rd Year</p>
    </div>

    <button id="edit-button">Edit</button>
    <button id="save-button" style="display: none;">Save</button>
  </div>

  <script src="profile.js"></script>
</body>
</html>
