document.addEventListener("DOMContentLoaded", () => {
  const courseListContainer = document.querySelector(".course-list");

  // Clear any existing hardcoded content
  courseListContainer.innerHTML = "";

  // Check if coursesData is available
  if (typeof coursesData !== 'undefined' && Array.isArray(coursesData)) {
      // Dynamically generate course cards
      coursesData.forEach((course, index) => {
          const courseCard = document.createElement("div");
          courseCard.classList.add("course-card");

          courseCard.innerHTML = `
              <h2>${course.course_name}</h2>
              <p><strong>Professor:</strong> ${course.professor_name}</p>
              <p><strong>Time:</strong> ${course.course_timing || 'Not specified'}</p>
              <button class="view-btn" data-index="${index}">View Course</button>
          `;

          // Append the course card to the course list
          courseListContainer.appendChild(courseCard);
      });

      // Add click listeners to view buttons
      const viewButtons = document.querySelectorAll(".view-btn");
      viewButtons.forEach((btn) => {
          btn.addEventListener("click", (event) => {
              const courseIndex = event.target.getAttribute("data-index");
              openModal(courseIndex);
          });
      });
  } else {
      courseListContainer.innerHTML = "<p>No courses found.</p>";
  }
});

console.log("Courses data:", coursesData);


// Function to open the modal and display the course data dynamically
function openModal(courseIndex) {
  const course = coursesData[courseIndex];
  document.getElementById("modalCourseTitle").textContent = course.course_name;
  document.getElementById("modalCourseOverview").innerHTML = `<strong>Overview:</strong> ${course.coursescol || 'No description available.'}`;
  document.getElementById("modalProfessor").innerHTML = `<strong>Professor:</strong> ${course.professor_name}`;
  document.getElementById("modalTiming").innerHTML = `<strong>Class Timing:</strong> ${course.course_timing || 'Not specified'}`;
  document.getElementById("courseModal").style.display = "flex";
}

function closeModal() {
  document.getElementById("courseModal").style.display = "none";
}
console.log("Courses Data:", coursesData);
