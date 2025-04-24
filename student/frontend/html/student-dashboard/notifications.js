document.addEventListener("DOMContentLoaded", function () {
    const notificationBell = document.getElementById("notificationBell");
    const notificationPanel = document.getElementById("notificationPanel");
    const notificationList = document.getElementById("notificationList");
    const notificationCount = document.getElementById("notificationCount");

    // Toggle dropdown visibility
    notificationBell.addEventListener("click", function () {
        notificationPanel.style.display = (notificationPanel.style.display === "block") ? "none" : "block";
    });

    // Fetch notifications from backend
    function fetchNotifications() {
        fetch("http://localhost/miniproject/student/backend/api/get_notifications.php")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateNotificationUI(data.notifications);
                }
            })
            .catch(error => console.error("Error fetching notifications:", error));
    }

    // Update notification UI
    function updateNotificationUI(notifications) {
        notificationList.innerHTML = "";

        if (notifications.length === 0) {
            notificationList.innerHTML = "<li>No new notifications</li>";
            notificationCount.style.display = "none";
            return;
        }

        notificationCount.textContent = notifications.length;
        notificationCount.style.display = "inline-block";

        notifications.forEach(notification => {
            const li = document.createElement("li");
            li.innerHTML = `
                <strong>${notification.title}</strong><br>
                ${notification.message}<br>
                <small>${new Date(notification.created_at).toLocaleString()}</small>
            `;
            li.style.cursor = "pointer";
            li.addEventListener("click", () => markAsRead(notification.id));
            notificationList.appendChild(li);
        });
    }

    // Mark a notification as read
    function markAsRead(notificationId) {
        fetch("http://localhost/miniproject/student/backend/api/mark_notification_read.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ notification_id: notificationId })
        }).then(() => fetchNotifications());
    }

    // Run once on load and then every 5 seconds
    fetchNotifications();
    setInterval(fetchNotifications, 5000);

    notificationBell.addEventListener("click", function () {
        console.log("Bell clicked!");
        notificationPanel.style.display = (notificationPanel.style.display === "block") ? "none" : "block";
    });
    
});
