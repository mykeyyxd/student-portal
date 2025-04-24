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
  <title>Grades - Student Portal</title>
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2/tsparticles.bundle.min.js"></script>
  <link rel="stylesheet" href="grades.css">
</head>
<body>
  <div id="tsparticles"></div>
  <div class="container">
    <div class="menu-trigger">
      <div class="bars">
          <span></span>
          <span></span>
          <span></span>
          </div>
      <p>Dashboard</p>
  <div class="menu">

 <!-- Sidebar -->
<div class="sidebar">
          <ul>
          <li><a href="../student-dashboard-ui.php">Dashboard</a></li>
          <li><a href="../courses/courses.php">Courses</></li>
          <li><a href="../attendance/attendance.php">Attendance</></li>
          <li><a href="../profile/profile.php">Profile</></li>
          <li><a href="../../logout.php">Logout</></li>
          </ul>
      </div>
  </div>
</div>
    <h1 class="title">Your Grades</h1>
    <div class="semesters">
      <!-- Semester Cards -->
      <div class="sem-card" data-semester="1">Semester 1</div>
      <div class="sem-card" data-semester="2">Semester 2</div>
      <div class="sem-card" data-semester="3">Semester 3</div>
      <!-- Add more as needed -->
    </div>
  </div>

  <!-- Overlay Modal -->
  <div class="overlay" id="gradeOverlay">
    <div class="overlay-content">
      <span class="close-btn" onclick="closeOverlay()">×</span>
      <h2 id="overlayTitle">Semester Grades</h2>
      <div id="gradeDetails">
        <!-- Placeholder - replace with real data from server -->
        <p>Loading course and marksheet data...</p>
      </div>
    </div>
  </div>

  <script src="grades.js"></script>
</body>
</html>
