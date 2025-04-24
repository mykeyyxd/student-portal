<?php 
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include_once('config/db.php');
$admin_name = 'Admin';
$admin_id = $_SESSION['admin_id'];

$query="SELECT name FROM admin where id =?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$stmt->bind_result($fetched_name);
if ($stmt->fetch()) {
    $admin_name = $fetched_name;
}
$stmt->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIEST Shibpur - Student Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <img src="" alt="University Logo" class="college-logo">
                <div>
                    <h1>University</h1>
                    <p>Student Management Portal</p>
                </div>
            </div>
            <div class="user-info">
                <span>Welcome <?php echo htmlspecialchars($admin_name); ?></span>
                <div class="avatar">A</div>
            </div>
        </header>

        <aside class="sidebar">
    <nav>
        <ul>
            <li class="active" data-section="dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</li>
            <li data-section="students"><i class="fas fa-users"></i> Students</li>
            <li data-section="add-student"><i class="fas fa-user-plus"></i> Add Student</li>
            <li data-section="modify-student"><i class="fas fa-user-edit"></i> Modify Student</li>
            <li data-section="attendance"><i class="fas fa-calendar-check"></i> Manage Attendance</li> 
            <li data-section="marksheets"><i class="fas fa-file-alt"></i> Marksheets</li>
            <li data-section="courses"><i class="fas fa-book"></i> Manage Courses</li>
            <li data-section="notifications"><i class="fas fa-bell"></i> Push Notifications</li>
            <li data-section="search"><i class="fas fa-search"></i> Search</li>
            
        </ul>
    </nav>
</aside>



        <main class="main-content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="content-section active">
                <h2><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                <div class="stats-container">
                    <div class="stat-card">
                        <div class="stat-icon bg-blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                        <?php
                            $student_count = 0;

                            $query = "SELECT COUNT(*) AS total FROM students";
                            $result = $conn->query($query);

                            if ($result && $row = $result->fetch_assoc()) {
                             $student_count = $row['total'];
                            }
                        ?>
                        <h3>Total Students</h3>
                            <p><?php echo $student_count; ?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-green">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-info">
                        <?php
                            $courses_count = 0;

                            $query = "SELECT COUNT(*) AS total FROM courses";
                            $result = $conn->query($query);

                            if ($result && $row = $result->fetch_assoc()) {
                             $courses_count = $row['total'];
                            }
                        ?>
                            <h3>Active Courses</h3>
                            <p><?php echo $courses_count;?></p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon bg-purple">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="stat-info">
                    <?php
                        $pending_notifications = 0;

                        $sql = "SELECT COUNT(*) AS total FROM notifications WHERE status = 'pending'";
                        $result = $conn->query($sql);

                        if ($result && $row = $result->fetch_assoc()) {
                        $pending_notifications = $row['total'];
                        }
                    ?>
                            <h3>Pending Notifications</h3>
                            <p><?php echo $pending_notifications;?></p>
                        </div>
                    </div>
                </div>

                <?php 
                $activities = [];
$sql = "SELECT * FROM recent_activity ORDER BY activity_time DESC LIMIT 5";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
}

function timeAgo($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) return "$diff seconds ago";
    $mins = floor($diff / 60);
    if ($mins < 60) return "$mins minutes ago";
    $hours = floor($mins / 60);
    if ($hours < 24) return "$hours hours ago";
    $days = floor($hours / 24);
    return "$days days ago";
}

?>
                <div class="recent-activity">
                    <h3><i class="fas fa-history"></i> Recent Activity</h3>
                    <ul>
<?php foreach ($activities as $activity): ?>
    <li>
        <i class="fas fa-<?= htmlspecialchars($activity['activity_type']) ?> activity-icon <?= htmlspecialchars($activity['activity_type']) ?>"></i>
        <span><?= htmlspecialchars($activity['description']) ?></span>
        <span class="activity-time"><?= timeAgo($activity['activity_time']) ?></span>
    </li>
<?php endforeach; ?>
</ul>
                </div>
            </section>

            <!-- Students Section -->
            <section id="students" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-users"></i> Students</h2>
                    <button class="btn btn-primary" id="export-students">
                        <i class="fas fa-file-export"></i> Export
                    </button>
                </div>
                <div class="table-container">
    <table class="data-table">
        <thead>
            <tr><th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Batch</th>
                <th>Degree</th>
                <th>Roll Number</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php

            // Fetch data from the student table
            $sql = "SELECT * FROM students";
            $result = $conn->query($sql);

            // Loop through the data and display it in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Roll number format is: 2023CSB051
                    $roll_no = $row['roll_no'];

                    // Extract batch, department, degree, and roll number using substr
                    $batch = substr($roll_no, 0, 4); // First 4 digits as batch year
                    $department = substr($roll_no, 4, 2); // Next 2 characters as department
                    $degree = substr($roll_no, 6, 1); // The next character for degree (B)
                    $roll_number = substr($roll_no, 7); // The remaining part as the roll number

                    // Display the row
                    echo "<tr>
    <td>$roll_no</td>
    <td>" . $row['name'] . "</td>
    <td>$department</td>
    <td>$batch</td>
    <td>$degree</td>
    <td>$roll_number</td>
    <td>" . $row['email'] . "</td>
    <td>
        <button class='btn-action edit'
            data-roll_no='" . $row['roll_no'] . "'
            data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "'
            data-email='" . $row['email'] . "'
            data-department='" . $department . "'
            data-batch='" . $batch . "'
            data-degree='" . $degree . "'
            data-rollnumber='" . $roll_number . "'>
            <i class='fas fa-edit'></i>
        </button>

        <button class='btn-action delete' 
            data-roll_no='" . $row['roll_no'] . "' 
            data-name='" . htmlspecialchars($row['name'], ENT_QUOTES) . "'>
            <i class='fas fa-trash'></i>
        </button>
    </td>
</tr>";

                }
            } else {
                echo "<tr><td colspan='8'>No students found</td></tr>";
            }

            ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Edit Student</h3>
        <form id="editForm">
            <input type="hidden" name="roll_no" id="edit-rollno">

            <label>Name:</label>
            <input type="text" name="name" id="edit-name" required>

            <label>Email:</label>
            <input type="email" name="email" id="edit-email" required>

            <!-- Add other editable fields here if needed -->

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>



                
                <div class="pagination">
                    <button class="btn-pagination" disabled><i class="fas fa-chevron-left"></i></button>
                    <span class="page-number">1</span>
                    <button class="btn-pagination"><i class="fas fa-chevron-right"></i></button>
                </div>
            </section>



<?php
require_once 'config/db.php'; // Database connection file

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
    $dob = $_POST['dob'];

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
                          VALUES ('$student_id', '$batch', '$semester', '$gender', '$phone', '$address', '$admission_date', '$dob')";

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
    $query = "SELECT roll_no FROM students WHERE roll_no LIKE '$year$departmentCode$degreeCode%' ORDER BY roll_no DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $latest_student_id = $row['roll_no'];
        $serial_number = (int) substr($latest_student_id, -3) + 1;
    } else {
        $serial_number = 1;
    }

    $serial_number = str_pad($serial_number, 3, '0', STR_PAD_LEFT);
    return $year . $departmentCode . $degreeCode . $serial_number;
}
?>

            <section id="add-student" class="content-section">
            <h2><i class="fas fa-user-plus"></i> Add New Student</h2>
        <form id="add-student-form" method="POST" action="admin-dashboard.php" class="student-form">
            <div class="form-row">
    <div class="form-group">
        <label for="student-id">Student ID</label>
        <input type="text" id="student-id" name="student_id" placeholder="Auto-generated" disabled>
    </div>
    <div class="form-group">
        <label for="admission-date">Admission Date</label>
        <input type="date" id="admission-date" name="admission_date" required>
    </div>
    <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" id="dob" name="dob" required>
    </div>
</div>


        <div class="form-row">
            <div class="form-group">
                <label for="first-name">First Name</label>
                <input type="text" id="first-name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" required>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="department">Department</label>
            <select id="department" name="department" required>
            <option value="">Select Department</option>
                                <option value="AE">Aerospace Engineering & Applied Mechanics</option>
                                <option value="CE">Civil Engineering</option>
                                <option value="CS">Computer Science & Technology</option>
                                <option value="EE">Electrical Engineering</option>
                                <option value="EC">Electronics & Telecommunication</option>
                                <option value="IT">Information Technology</option>
                                <option value="ME">Mechanical Engineering</option>
                                <option value="MT">Metallurgy & Materials Engineering</option>
            </select>
        </div>
        <div class="form-group">
            <label for="degree">Degree Program</label>
            <select id="degree" name="degree" required>
            <option value="">Select Degree Program</option>
                        <option value="B">B.Tech</option>
                        <option value="M">M.Tech</option>
                        <option value="P">PhD</option>
            </select>
        </div>
        <div class="form-group">
            <label for="batch">Batch</label>
            <select id="batch" name="batch" required>
            <option value="">Select Batch</option>
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                                <option value="2023">2023</option>
                                <option value="2022">2022</option>
                                <option value="2021">2021</option>
                                <option value="2020">2020</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="semester">Current Semester</label>
            <select id="semester" name="semester" required>
            <option value="">Select Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                            <option value="8">Semester 8</option>
            </select>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
        
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="email">University Email</label>
            <input type="email" id="email" name="email" placeholder="username@university.in" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Address</label>
        <textarea id="address" name="address" rows="3"></textarea>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Save Student
        </button>
        <button type="reset" class="btn btn-secondary">
            <i class="fas fa-undo"></i> Reset
        </button>
    </div>
</form>
</section>

<!-- Modify Student Section -->
<section id="modify-student" class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-user-edit"></i> Modify Student</h2>
    </div>
    <form id="modify-student-form" method="POST" action="modify_student.php" class="student-form">
        <div class="form-row">
            <div class="form-group">
                <label for="search-roll-no">Search by Roll Number</label>
                <input type="text" id="search-roll-no" name="roll_no" placeholder="Enter Roll Number" required>
            </div>
            <div class="form-group">
                <button type="button" id="search-student-btn" class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </div>
        <div id="modify-student-details" style="display: none;">
            <div class="form-row">
                <div class="form-group">
                    <label for="modify-name">Name</label>
                    <input type="text" id="modify-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="modify-email">Email</label>
                    <input type="email" id="modify-email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="modify-phone">Phone</label>
                    <input type="tel" id="modify-phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="modify-address">Address</label>
                    <textarea id="modify-address" name="address" rows="3"></textarea>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button type="reset" class="btn btn-secondary">
                    <i class="fas fa-undo"></i> Reset
                </button>
            </div>
        </div>
    </form>
</section>

<!-- Manage Attendance Section -->
<section id="attendance" class="content-section">
    <div class="section-header">
        <h2><i class="fas fa-calendar-check"></i> Manage Attendance</h2>
    </div>
    <form id="attendance-form" method="POST" action="manage_attendance.php" class="attendance-form">
        <div class="form-row">
            <div class="form-group">
                <label for="attendance-course">Course</label>
                <select id="attendance-course" name="course" required>
                    <option value="">Select Course</option>
                    <option value="CS301">CS301 - Data Structures</option>
                    <option value="EE201">EE201 - Circuit Theory</option>
                    <option value="ME302">ME302 - Thermodynamics Lab</option>
                </select>
            </div>
            <div class="form-group">
                <label for="attendance-semester">Semester</label>
                <select id="attendance-semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label for="attendance-date">Date</label>
                <input type="date" id="attendance-date" name="date" required>
            </div>
        </div>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Roll Number</th>
                        <th>Name</th>
                        <th>Present</th>
                    </tr>
                </thead>
                <tbody id="attendance-student-list">
                    <!-- Dynamically populated rows -->
                </tbody>
            </table>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Attendance
            </button>
        </div>
    </form>
</section>





            <!-- Marksheets Section -->
            <section id="marksheets" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-file-alt"></i> Marksheets</h2>
                    <button class="btn btn-primary" id="upload-marksheet-btn">
                        <i class="fas fa-upload"></i> Upload Marksheet
                    </button>
                </div>
                
                <div class="upload-marksheet-form" style="display: none;">
                    <form id="marksheet-upload-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="marksheet-student-id">Student ID</label>
                                <input type="text" id="marksheet-student-id" required>
                            </div>
                            <div class="form-group">
                                <label for="marksheet-semester">Semester</label>
                                <select id="marksheet-semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="marksheet-exam-type">Exam Type</label>
                                <select id="marksheet-exam-type" required>
                                    <option value="">Select Exam Type</option>
                                    <option value="Mid-Sem">Mid-Semester</option>
                                    <option value="End-Sem">End-Semester</option>
                                    <option value="Practical">Practical</option>
                                    <option value="Overall">Overall Result</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="marksheet-file">Marksheet File</label>
                                <input type="file" id="marksheet-file" accept=".pdf,.jpg,.png" required>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload
                            </button>
                            <button type="button" id="cancel-upload" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Semester</th>
                                <th>Exam Type</th>
                                <th>Upload Date</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023/CS/032</td>
                                <td>Rahul Sharma</td>
                                <td>1</td>
                                <td>End-Semester</td>
                                <td>2023-12-20</td>
                                <td>marksheet_2023CS032_S1_EndSem.pdf</td>
                                <td>
                                    <button class="btn-action view"><i class="fas fa-eye"></i></button>
                                    <button class="btn-action download"><i class="fas fa-download"></i></button>
                                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2023/EE/015</td>
                                <td>Priya Chatterjee</td>
                                <td>1</td>
                                <td>End-Semester</td>
                                <td>2023-12-21</td>
                                <td>marksheet_2023EE015_S1_EndSem.pdf</td>
                                <td>
                                    <button class="btn-action view"><i class="fas fa-eye"></i></button>
                                    <button class="btn-action download"><i class="fas fa-download"></i></button>
                                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    <button class="btn-pagination" disabled><i class="fas fa-chevron-left"></i></button>
                    <span class="page-number">1</span>
                    <button class="btn-pagination"><i class="fas fa-chevron-right"></i></button>
                </div>
            </section>

            <!-- Courses Section -->
            <section id="courses" class="content-section">
                <div class="section-header">
                    <h2><i class="fas fa-book"></i> Courses</h2>
                    <button class="btn btn-primary" id="add-course-btn">
                        <i class="fas fa-plus"></i> Add Course
                    </button>
                </div>
                
                <div class="add-course-form" style="display: none;">
                    <form id="course-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="course-code">Course Code</label>
                                <input type="text" id="course-code" placeholder="e.g. CS301" required>
                            </div>
                            <div class="form-group">
                                <label for="course-name">Course Name</label>
                                <input type="text" id="course-name" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="course-credits">Credits</label>
                                <select id="course-credits" required>
                                    <option value="">Select Credits</option>
                                    <option value="1">1 Credit</option>
                                    <option value="2">2 Credits</option>
                                    <option value="3">3 Credits</option>
                                    <option value="4">4 Credits</option>
                                    <option value="5">5 Credits</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course-department">Department</label>
                                <select id="course-department" required>
                                    <option value="">Select Department</option>
                                    <option value="AE">Aerospace Engineering</option>
                                    <option value="CE">Civil Engineering</option>
                                    <option value="CS">Computer Science & Technology</option>
                                    <option value="EE">Electrical Engineering</option>
                                    <option value="EC">Electronics & Communication</option>
                                    <option value="IT">Information Technology</option>
                                    <option value="ME">Mechanical Engineering</option>
                                    <option value="MT">Metallurgy & Materials Engineering</option>
                                    <option value="CH">Chemical Engineering</option>
                                    <option value="PH">Physics</option>
                                    <option value="MA">Mathematics</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="course-semester">Semester Offered</label>
                                <select id="course-semester" required>
                                    <option value="">Select Semester</option>
                                    <option value="1">Semester 1</option>
                                    <option value="2">Semester 2</option>
                                    <option value="3">Semester 3</option>
                                    <option value="4">Semester 4</option>
                                    <option value="5">Semester 5</option>
                                    <option value="6">Semester 6</option>
                                    <option value="7">Semester 7</option>
                                    <option value="8">Semester 8</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="course-type">Course Type</label>
                                <select id="course-type" required>
                                    <option value="">Select Type</option>
                                    <option value="Theory">Theory</option>
                                    <option value="Practical">Practical</option>
                                    <option value="Lab">Lab</option>
                                    <option value="Project">Project</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="course-description">Description</label>
                            <textarea id="course-description" rows="3"></textarea>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Course
                            </button>
                            <button type="button" id="cancel-course" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Credits</th>
                                <th>Semester</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>CS301</td>
                                <td>Data Structures & Algorithms</td>
                                <td>Computer Science</td>
                                <td>4</td>
                                <td>3</td>
                                <td>Theory</td>
                                <td>
                                    <button class="btn-action edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>EE201</td>
                                <td>Circuit Theory</td>
                                <td>Electrical Engineering</td>
                                <td>4</td>
                                <td>2</td>
                                <td>Theory</td>
                                <td>
                                    <button class="btn-action edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>ME302</td>
                                <td>Thermodynamics Lab</td>
                                <td>Mechanical Engineering</td>
                                <td>2</td>
                                <td>3</td>
                                <td>Lab</td>
                                <td>
                                    <button class="btn-action edit"><i class="fas fa-edit"></i></button>
                                    <button class="btn-action delete"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="pagination">
                    <button class="btn-pagination" disabled><i class="fas fa-chevron-left"></i></button>
                    <span class="page-number">1</span>
                    <button class="btn-pagination"><i class="fas fa-chevron-right"></i></button>
                </div>
            </section>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>