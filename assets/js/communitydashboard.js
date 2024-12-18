function initializeDashboard(){
    // JavaScript to switch between sections
    const navLinks = document.querySelectorAll('.nav-link');
    const contentSections = document.querySelectorAll('.content-section');
  
    navLinks.forEach(link => {
      link.addEventListener('click', e => {
        e.preventDefault();
        // Get the target content
        const target = link.getAttribute('data-target');
        
        // Remove 'active' class from all nav links
        navLinks.forEach(nav => nav.classList.remove('active'));
        link.classList.add('active');
        
        // Hide all content sections
        contentSections.forEach(section => section.style.display = 'none');
        
        // Show the target content section
        const targetSection = document.querySelector(`.${target}`);
        if(targetSection) {
          // Use block to maintain consistent layout
          targetSection.style.display = 'grid';
        }
      });
    });
  
    // Like button toggle functionality
    document.querySelectorAll('.like-btn').forEach(button => {
      button.addEventListener('click', () => {
        button.classList.toggle('liked');
      });
    });
  
  function toggleReadMore(element) {
    const excerpt = element.previousElementSibling;
    const isCollapsed = excerpt.style.webkitLineClamp === "3" || !excerpt.style.webkitLineClamp;
  
    if (isCollapsed) {
      excerpt.style.display = "block";
      excerpt.style.webkitLineClamp = "unset";
      element.textContent = "Read less";
    } else {
      excerpt.style.webkitLineClamp = "3";
      excerpt.style.display = "-webkit-box";
      element.textContent = "Read more";
    }
  }
}
initializeDashboard();

// communitydashboard.js
(function () {
    console.log("Community Dashboard JS loaded successfully");

    // DOM Element Selectors
    const editCommunityBtn = document.querySelector(".edit-btn");
    const editCommunityOverlay = document.querySelector(".edit-community-container");
    const modalCloseBtn = editCommunityOverlay.querySelector(".cancel-edit");
    const editCommunityForm = document.getElementById("edit-community-form");
    const communityImageInput = document.getElementById("community-image");
    const communityImagePreview = editCommunityOverlay.querySelector(".community-avatar img");

    // Function to open the edit community modal
    function openEditModal(e) {
        e.preventDefault();
        editCommunityOverlay.style.display = "flex";
    }

    // Function to close the edit community modal
    function closeEditModal() {
        editCommunityOverlay.style.display = "none";
    }

    // Handle community image preview
    if (communityImageInput) {
        communityImageInput.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    communityImagePreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Form submission handler
    if (editCommunityForm) {
        editCommunityForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch("/src/controllers/home_pages/updateCommunityController.php", {
                    method: "POST",
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                console.log(response);
                const contentType = response.headers.get("content-type");
                if (!contentType || !contentType.includes("application/json")) {
                    throw new Error("Received non-JSON response");
                }

                const result = await response.json();

                if (result.success) {
                    // Update UI elements with new data
                    updateCommunityUI(formData, result.profileImage);
                    showNotification(result.message, "success");
                    closeEditModal();
                } else {
                    showNotification(result.message, "error");
                }
            } catch (error) {
                console.error("Update failed:", error);
                showNotification("Failed to update community. Please try again.", "error");
            }
        });
    }

    // Form validation
    function validateForm() {
        const name = document.getElementById("community_name").value.trim();
        const description = document.getElementById("description").value.trim();

        if (name === "") {
            showNotification("Community name is required.", "error");
            return false;
        }

        if (description.length > 1000) {
            showNotification("Description must be less than 1000 characters.", "error");
            return false;
        }

        return true;
    }

    // Update community UI after successful edit
    function updateCommunityUI(formData, newProfileImage) {
        // Update community name
        const groupTitle = document.querySelector(".group-title");
        if (groupTitle) {
            groupTitle.textContent = formData.get("community_name");
        }

        // Update description
        const groupDesc = document.querySelector(".group-desc");
        if (groupDesc) {
            groupDesc.textContent = formData.get("description");
        }

        // Update community type, privacy, recruitment status if displayed on UI
        // Add code here if these are displayed

        // Update community profile image if new one is uploaded
        if (newProfileImage) {
            const communityAvatar = document.querySelector(".avatar-wrapper img");
            if (communityAvatar) {
                communityAvatar.src = newProfileImage;
            }
        }
    }

    // Notification System
    function showNotification(message, type = "info") {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll(".notification");
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
    if (editCommunityBtn) {
        editCommunityBtn.addEventListener("click", openEditModal);
    }

    if (modalCloseBtn) {
        modalCloseBtn.addEventListener("click", closeEditModal);
    }

    // Close modal when clicking outside the modal content
    window.addEventListener("click", function (e) {
        if (e.target === editCommunityOverlay) {
            closeEditModal();
        }
    });

    // Close modal on Escape key
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && editCommunityOverlay.style.display === "flex") {
            closeEditModal();
        }
    });
})();