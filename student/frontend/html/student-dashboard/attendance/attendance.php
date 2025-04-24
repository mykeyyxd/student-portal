<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Attendance</title>
  <link rel="stylesheet" href="attendance.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<!-- Sliding Sidebar Trigger -->
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
        <li><p>Dashboard</p></li>
        <li><p>Grades</p></li>
        <li><p>Attendance</p></li>
        <li><p>Profile</p></li>
        <li><p>Logout</p></li>
      </ul>
    </div>
  </div>
</div>

<div class="main-content">
  <h1 class="page-title">Attendance Overview</h1>

  <!-- Overall Attendance Card -->
  <div class="overall-attendance-card">
    <h2>Overall Attendance</h2>
    <canvas id="overallChart"
            data-courses='[
              {"label": "Web Development", "attended": 22, "total": 25},
              {"label": "Data Structures", "attended": 19, "total": 25},
              {"label": "AI & ML", "attended": 20, "total": 24}
            ]'></canvas>
  </div>
  
  <h2 class="sub-title">Course-wise Attendance</h2>

  <div class="course-attendance-list">
    <!-- Course 1 -->
    <div class="course-attendance-card" onclick="toggleDetails(this)">
      <h2>Web Development</h2>
      <p><strong>Professor:</strong> Dr. Alan Cooper</p>
      <p><strong>Current Attendance:</strong> 88%</p>
      <div class="details">
        <canvas class="chart" data-attended="22" data-total="25"></canvas>
        <p><strong>Total Classes:</strong> 25</p>
        <p><strong>Attended:</strong> 22</p>
        <p><strong>Attendance:</strong> 88%</p>
      </div>
    </div>

    <!-- Course 2 -->
    <div class="course-attendance-card" onclick="toggleDetails(this)">
      <h2>Data Structures</h2>
      <p><strong>Professor:</strong> Dr. Susan Meyers</p>
      <p><strong>Current Attendance:</strong> 76%</p>
      <div class="details">
        <canvas class="chart" data-attended="19" data-total="25"></canvas>
        <p><strong>Total Classes:</strong> 25</p>
        <p><strong>Attended:</strong> 19</p>
        <p><strong>Attendance:</strong> 76%</p>
      </div>
    </div>
  </div>
</div>

<script src="attendance.js"></script>
</body>
</html>
