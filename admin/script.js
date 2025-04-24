document.addEventListener('DOMContentLoaded', function () {
    // Navigation between sections
    const navItems = document.querySelectorAll('.sidebar nav ul li');
    const contentSections = document.querySelectorAll('.content-section');

    navItems.forEach(item => {
        item.addEventListener('click', function () {
            // Remove active class from all nav items and sections
            navItems.forEach(navItem => navItem.classList.remove('active'));
            contentSections.forEach(section => section.classList.remove('active'));

            // Add active class to clicked nav item
            this.classList.add('active');

            // Show corresponding section
            const sectionId = this.getAttribute('data-section');
            document.getElementById(sectionId).classList.add('active');
        });
    });

    // Toggle forms
    const uploadMarksheetBtn = document.getElementById('upload-marksheet-btn');
    const uploadMarksheetForm = document.querySelector('.upload-marksheet-form');
    const cancelUploadBtn = document.getElementById('cancel-upload');

    uploadMarksheetBtn.addEventListener('click', function () {
        uploadMarksheetForm.style.display = 'block';
    });

    cancelUploadBtn.addEventListener('click', function () {
        uploadMarksheetForm.style.display = 'none';
    });

    const addCourseBtn = document.getElementById('add-course-btn');
    const addCourseForm = document.querySelector('.add-course-form');
    const cancelCourseBtn = document.getElementById('cancel-course');

    addCourseBtn.addEventListener('click', function () {
        addCourseForm.style.display = 'block';
    });

    cancelCourseBtn.addEventListener('click', function () {
        addCourseForm.style.display = 'none';
    });

    
    // Marksheet Upload Form Submission
    const marksheetUploadForm = document.getElementById('marksheet-upload-form');
    marksheetUploadForm.addEventListener('submit', function (e) {
        e.preventDefault();
        alert("Marksheet uploaded successfully!");
        marksheetUploadForm.reset();
        uploadMarksheetForm.style.display = 'none';
    });

    // Add Course Form Submission
    const courseForm = document.getElementById('course-form');
    courseForm.addEventListener('submit', function (e) {
        e.preventDefault();
        alert("Course added successfully!");
        courseForm.reset();
        addCourseForm.style.display = 'none';
    });

    
});
document.getElementById('search-student-btn').addEventListener('click', function () {
    const rollNo = document.getElementById('search-roll-no').value;

    fetch(`get_student.php?roll_no=${rollNo}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('modify-student-details').style.display = 'block';
                document.getElementById('modify-name').value = data.student.name;
                document.getElementById('modify-email').value = data.student.email;
                document.getElementById('modify-phone').value = data.student.phone;
                document.getElementById('modify-address').value = data.student.address;
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});
document.getElementById('attendance-course').addEventListener('change', function () {
    const course = this.value;
    const semester = document.getElementById('attendance-semester').value;

    if (course && semester) {
        fetch(`get_students_for_attendance.php?course=${course}&semester=${semester}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('attendance-student-list');
                tbody.innerHTML = '';

                data.students.forEach(student => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${student.roll_no}</td>
                        <td>${student.name}</td>
                        <td><input type="checkbox" name="attendance[${student.roll_no}]" value="present"></td>
                    `;
                    tbody.appendChild(row);
                });
            })
            .catch(error => console.error('Error:', error));
    }
});

document.querySelectorAll('.edit').forEach(button => {
    button.addEventListener('click', () => {
        document.getElementById('editModal').style.display = 'block';

        document.getElementById('edit-rollno').value = button.dataset.rollno;
        document.getElementById('edit-name').value = button.dataset.name;
        document.getElementById('edit-email').value = button.dataset.email;
        // Add more fields if needed
    });
});

document.querySelector('.close').onclick = () => {
    document.getElementById('editModal').style.display = 'none';
};

window.onclick = event => {
    if (event.target === document.getElementById('editModal')) {
        document.getElementById('editModal').style.display = 'none';
    }
};

document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('update_student.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(response => {
        alert('Student updated successfully');
        location.reload();
    })
    .catch(err => console.error(err));
});