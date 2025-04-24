<?php
session_start();

if (!isset($_SESSION['student_id'])) {
    header("Location: ../../login.php");
    exit;
}

// Assuming student_id is already stored in the session
$student_id = $_SESSION['student_id'];

// Database connection
include("../../../config/db.php");

// Query to fetch courses for the logged-in student
$query = "SELECT * FROM courses WHERE student_id = '$student_id'";
$result = $conn->query($query);

$courses = [];
if ($result->num_rows > 0) {
    // Fetch each row and add to the $courses array
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Courses</title>
  <link rel="stylesheet" href="courses.css" />
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
                        <li><a href="../student-dashboard-ui.php">Dashboard</a></li>
                        <li><a href="grades/grades.php">Grades</a></li>
                        <li><a href="attendance/attendance.php">Attendance</a></li>
                        <li><a href="profile/profile.php">Profile</a></li>
                        <li><a href="../logout.php">Logout</a></li>
                    </ul>
        </div>
    </div>
</div>


  <div class="main-content">
    <h1 class="page-title">My Courses</h1>

    <div class="course-actions" id="courseActions">
      <button class="add-btn" id="addCourseBtn">Add Course</button>
      <button class="remove-btn">Remove Course</button>
    </div>

    <div class="course-list">
      
      <!-- Add more course cards as needed -->
    </div>
    <!-- Course Details Modal -->
<div class="modal-overlay" id="courseModal">
    <div class="modal-content">
      <span class="close-btn" onclick="closeModal()">&times;</span>
      <h2 id="modalCourseTitle">Course Title</h2>
      <p id="modalCourseOverview"><strong>Overview:</strong> Loading...</p>
      <p id="modalProfessor"><strong>Professor:</strong> Loading...</p>
      <p id="modalTiming"><strong>Class Timing:</strong> Loading...</p>
    </div>
  </div>
  
  </div>
  <script>
    const coursesData = <?php echo json_encode($courses); ?>;
    console.log("Courses from PHP:", coursesData);

</script>
<script src="courses.js"></script>
</body>
</html>
