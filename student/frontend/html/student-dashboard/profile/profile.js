document.addEventListener("DOMContentLoaded", function () {
    const background = document.querySelector('.background');

    // Example of an interactive background effect
    let colors = ['#6e7f80', '#3b4d4d', '#2c3e50', '#34495e'];
    let currentColor = 0;

    setInterval(() => {
        background.style.backgroundColor = colors[currentColor];
        currentColor = (currentColor + 1) % colors.length;
    }, 3000); // Change color every 3 seconds

    const editButton = document.getElementById("edit-button");
    const saveButton = document.getElementById("save-button");
    const phoneDisplay = document.getElementById("phone-display");
    const phoneInput = document.getElementById("phone-input");
    const addressDisplay = document.getElementById("address-display");
    const addressInput = document.getElementById("address-input");
    const profileImage = document.getElementById("profile-image");
    const profileImageInput = document.getElementById("profile-image-input");

    // Toggle edit mode
    editButton.addEventListener("click", () => {
        phoneDisplay.style.display = "none";
        phoneInput.style.display = "inline";
        addressDisplay.style.display = "none";
        addressInput.style.display = "inline";
        editButton.style.display = "none";
        saveButton.style.display = "inline";
    });

    // Save changes
    saveButton.addEventListener("click", () => {
        phoneDisplay.textContent = phoneInput.value;
        addressDisplay.textContent = addressInput.value;
        phoneDisplay.style.display = "inline";
        phoneInput.style.display = "none";
        addressDisplay.style.display = "inline";
        addressInput.style.display = "none";
        editButton.style.display = "inline";
        saveButton.style.display = "none";
    });

    // Update profile image
    profileImageInput.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                profileImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
