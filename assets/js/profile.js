(function () {
    console.log("successfully loaded");

    // DOM Element Selectors
    let editProfileBtn = document.getElementById("editProfileBtn");
    let editProfileOverlay = document.getElementById("edit-profile-overlay");
    let modalCloseBtn = document.querySelector(".modal-close");
    let cancelBtn = document.querySelector(".close-modal");
    let editForm = document.querySelector(".edit-form");
    let profileImageInput = document.getElementById("profile-image");
    let profileImagePreview = document.querySelector(".profile-avatar img");

    // Ensure all critical elements exist
    if (!editProfileBtn || !editProfileOverlay || !editForm) {
        console.error("Critical profile edit elements are missing.");
        // return;
    }

    // Open Modal Function
    function openEditModal(e) {
        e.preventDefault();
        editProfileOverlay.classList.add("active");
    }

    // Close Modal Function
    function closeModal() {
        editProfileOverlay.classList.remove("active");
    }

    // Profile Image Preview Handler
    if (profileImageInput) {
        profileImageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    const previewImages = document.querySelectorAll(
                        ".profile-avatar img"
                    );
                    previewImages.forEach((img) => {
                        img.src = event.target.result;
                    });
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form Submission Handler
    editForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        const formData = new FormData(this);

        try {
            const response = await fetch(
                "/src/controllers/home_pages/profileController.php",
                {
                    method: "POST",
                    body: formData,
                }
            );

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();

            if (result.success) {
                // Update UI elements
                updateProfileUI(formData, result.profileImage, result);
                showNotification(result.message, "success");
                closeModal();
            } else {
                showNotification(result.message, "error");
            }
        } catch (error) {
            console.error("Update failed:", error);
            showNotification(
                "Failed to update profile. Please try again.",
                "error"
            );
        }
    });

    // Form Validation
    function validateForm() {
        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const birthday = document.getElementById("birthday").value;
        const bio = document.getElementById("bio").value;

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showNotification("Please enter a valid email address", "error");
            return false;
        }

        // Birthday validation
        if (birthday) {
            const birthdayDate = new Date(birthday);
            const currentDate = new Date();
            if (birthdayDate > currentDate) {
                showNotification("Birthday cannot be in the future", "error");
                return false;
            }
        }

        // Bio length validation
        if (bio.length > 1000) {
            showNotification("Bio must be less than 1000 characters", "error");
            return false;
        }

        return true;
    }

    // Update Profile UI
    function updateProfileUI(formData, newProfileImage) {
        // Update name
        document.querySelector('.name').textContent = formData.get('name');
        // Update email
        document.querySelector('.info-item:nth-child(1) .info-text p:last-child').textContent = formData.get('email');
        // Update gender
        document.querySelector(
            ".info-item:nth-child(2) .info-text p:last-child"
        ).textContent = formData.get("gender");

        // Update birthday
        const birthday = formData.get("birthday");
        if (birthday) {
            const formattedDate = new Date(birthday)
                .toLocaleDateString("en-US", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                })
                .replace(/\//g, "/");
            document.querySelector(
                ".info-item:nth-child(3) .info-text p:last-child"
            ).textContent = formattedDate;
        }

        // Update bio
        document.querySelector(".bio-section p").textContent =
            formData.get("bio");

        // Update profile image if a new one was uploaded
        if (newProfileImage) {
            const profileImages = document.querySelectorAll(
                ".profile-avatar img"
            );
            profileImages.forEach((img) => {
                img.src = newProfileImage;
            });
        }
    }

    // Notification System
    function showNotification(message, type = "info") {
        // Remove any existing notifications
        const existingNotifications =
            document.querySelectorAll(".notification");
        existingNotifications.forEach((notification) => {
            notification.remove();
        });

        // Create new notification
        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.textContent = message;

        // Add notification to DOM
        document.body.appendChild(notification);

        // Remove notification after delay
        setTimeout(() => {
            notification.classList.add("fade-out");
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 300);
        }, 3000);
    }

    // Event Listeners
    editProfileBtn.addEventListener("click", openEditModal);
    modalCloseBtn.addEventListener("click", closeModal);
    cancelBtn.addEventListener("click", closeModal);

    // Close modal on outside click
    editProfileOverlay.addEventListener("click", function (e) {
        if (e.target === editProfileOverlay) {
            closeModal();
        }
    });

    // Close modal on escape key
    document.addEventListener("keydown", function (e) {
        if (
            e.key === "Escape" &&
            editProfileOverlay.classList.contains("active")
        ) {
            closeModal();
        }
    });
})();
