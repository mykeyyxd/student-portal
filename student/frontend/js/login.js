document.addEventListener("DOMContentLoaded", function () {
    console.log("✅ JS loaded and DOM is ready!");

    const form = document.getElementById('loginForm');

    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Stop page from reloading
        console.log("📩 Form submitted!");

        const roll_number = document.getElementById('roll_no').value;
        const password = document.getElementById('password').value;

        console.log("📝 Sending:", roll_number, password);

        fetch('http://localhost/miniproject/student/backend/api/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ roll_number, password })
        })
        .then(response => response.json())
        .then(data => {
            console.log("📥 API Response:", data);
            if (data.success) {
                console.log("✅ Login Successful! Redirecting...");
                window.location.href = '/miniproject/student/frontend/html/student-dashboard/student-dashboard-ui.php';
            } else {
                console.error("❌ Login Failed:", data.message);
                alert(data.message || 'Login failed');
            }
        })
        .catch(error => {
            console.error("🚨 Fetch Error:", error);
            alert('Failed to connect to the server.');
        });
    });
});
