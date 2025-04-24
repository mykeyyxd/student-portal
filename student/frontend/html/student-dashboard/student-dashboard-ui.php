<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: ../login.php");
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="student-dashboard.css">
    <script defer src="notifications.js"></script>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar and Menu -->
        <div class="menu-trigger">
            <div class="bars">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <p>Dashboard</p>
            <div class="menu">
                <div class="sidebar">
                    <ul>
                        <li><a href="student-dashboard-ui.php">Dashboard</a></li>
                        <li><a href="grades/grades.php">Grades</a></li>
                        <li><a href="attendance/attendance.php">Attendance</a></li>
                        <li><a href="profile/profile.php">Profile</a></li>
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Welcome to Your Dashboard</h1>
                
                <div class="notification-container">
                  <span class="notification-icon" id="notificationBell">🔔</span>
                  <span class="notification-badge" id="notificationCount">0</span>
                
                  <div class="notification-dropdown" id="notificationPanel">
                    <ul id="notificationList">
                      <li>No new notifications</li>
                    </ul>
                  </div>
                </div>
                
            </header>

            <!-- Neon Cards Section -->
            <div class="container">
                <div class="box">
                    <span></span>
                    <div class="content">
                        <h2>Courses</h2>
                        <p>View and manage your enrolled courses.</p>
                        <a href="courses/courses.php">Go to Courses</a>
                    </div>
                </div>
                <div class="box">
                    <span></span>
                    <div class="content">
                        <h2>Grades</h2>
                        <p>Check your latest grades and performance.</p>
                        <a href="grades/grades.php">View Grades</a>
                    </div>
                </div>
                <div class="box">
                    <span></span>
                    <div class="content">
                        <h2>Attendance</h2>
                        <p>Monitor your class attendance records.</p>
                        <a href="attendance/attendance.php">View Attendance</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="notifications.js"></script>
   
      
</body>
</html>
