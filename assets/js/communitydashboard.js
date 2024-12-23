function initializeDashboard() {
    // JavaScript to switch between sections
    const navLinks = document.querySelectorAll(".nav-link");
    const contentSections = document.querySelectorAll(".content-section");

    navLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            // Get the target content
            const target = link.getAttribute("data-target");

            // Remove 'active' class from all nav links
            navLinks.forEach((nav) => nav.classList.remove("active"));
            link.classList.add("active");

            // Hide all content sections
            contentSections.forEach(
                (section) => (section.style.display = "none")
            );

            // Show the target content section
            const targetSection = document.querySelector(`.${target}`);
            if (targetSection) {
                // Use block to maintain consistent layout
                targetSection.style.display = "grid";
            }
        });
    });

    // Like button toggle functionality
    document.querySelectorAll(".like-btn").forEach((button) => {
        button.addEventListener("click", () => {
            button.classList.toggle("liked");
        });
    });

    function toggleReadMore(element) {
        const excerpt = element.previousElementSibling;
        const isCollapsed =
            excerpt.style.webkitLineClamp === "3" ||
            !excerpt.style.webkitLineClamp;

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
    const editCommunityOverlay = document.querySelector(
        ".edit-community-container"
    );
    const modalCloseBtn = document.querySelector(".cancel-edit");
    const editCommunityForm = document.getElementById("edit-community-form");
    const communityImageInput = document.getElementById("community-image");
    const communityImagePreview = document.querySelector(
        ".community-avatar img"
    );
    const communityAnnouncementForm =
        document.getElementById("post-Announcement");

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

    // Community Announcement Form submission handler
    if (communityAnnouncementForm) {
        communityAnnouncementForm.addEventListener(
            "submit",
            async function (e) {
                e.preventDefault();
                const formData = new FormData(this);

                try {
                    const response = await fetch(
                        "/src/controllers/home_pages/communityUsers.php",
                        {
                            method: "POST",
                            body: formData,
                        }
                    );

                    if (!response.ok) {
                        throw new Error(
                            `HTTP error! status : ${response.status}`
                        );
                    }

                    const contentType = response.headers.get("content-type");
                    if (
                        !contentType ||
                        !contentType.includes("application/json")
                    ) {
                        throw new Error("Received non-JSON response");
                    }

                    const result = await response.json();
                    console.log(result);

                    if (result.success) {
                        showNotification(result.message, "success");
                        updateAnnouncements(result.newAnnouncement);
                    } else {
                        showNotification(result.message, "error");
                    }
                } catch (error) {
                    console.error("Post Announcement failed:", error);
                    showNotification(
                        "Failed to Post Announcement. Please try again.",
                        "error"
                    );
                }
            }
        );
    }
    // Edit Community Form submission handler
    if (editCommunityForm) {
        editCommunityForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            const formData = new FormData(this);

            try {
                const response = await fetch(
                    "/src/controllers/home_pages/communityUsers.php",
                    {
                        method: "POST",
                        body: formData,
                    }
                );

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
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
                showNotification(
                    "Failed to update community. Please try again.",
                    "error"
                );
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
            showNotification(
                "Description must be less than 1000 characters.",
                "error"
            );
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
            const communityAvatar = document.querySelector(
                ".avatar-wrapper img"
            );
            if (communityAvatar) {
                communityAvatar.src = newProfileImage;
            }
        }
    }

    // Notification System
    function showNotification(message, type = "info") {
        // Remove existing notifications
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
        if (
            e.key === "Escape" &&
            editCommunityOverlay.style.display === "flex"
        ) {
            closeEditModal();
        }
    });

    // Update Announcements
    function updateAnnouncements(newAnnouncement) {
        const announcementsContainer = document.querySelector(".left-column");

        if (!announcementsContainer) return;

        // Create new announcement element
        const announcementElement = document.createElement("article");
        const noAnnouncementtag = document.getElementById("noAnnoTag");

        if (noAnnouncementtag) {
            noAnnouncementtag.remove();
        }
        announcementElement.className = "post";

        announcementElement.innerHTML = `
            <div class="post-header">
                <img src="${newAnnouncement.profile_image}" alt="${
            newAnnouncement.name
        }" class="post-avatar" loading="lazy">
                <div class="post-info">
                    <strong>${newAnnouncement.name}</strong><br>
                    <span>${newAnnouncement.membership}</span>
                    <span class="post-date">${new Date().toLocaleDateString()}</span>
                </div>
            </div>
            <div class="post-body">
                <p>${newAnnouncement.content}</p>
            </div>
            <div class="post-actions">
                <button class="btn like-btn" aria-label="Like Post"><i class="fas fa-heart"></i></button>
            </div>
        `;

        // Prepend the new announcement to the top of the list
        announcementsContainer.insertBefore(
            announcementElement,
            announcementsContainer.children[1]
        );
    }
})();

(function () {
    // Function to show the invite modal
    function showInviteModal() {
        document.getElementById("inviteModal").style.display = "flex";
    }

    // Function to hide the invite modal
    function hideInviteModal() {
        document.getElementById("inviteModal").style.display = "none";
    }

    // Event listener for the Invite button

    const inviteBtn = document.querySelector(".invite-btn");
    if (inviteBtn) {
        inviteBtn.addEventListener("click", function (event) {
            event.preventDefault();
            showInviteModal();

            // Event listener for the Close button
            document
                .getElementById("closeInviteModal")
                .addEventListener("click", hideInviteModal);

            // Event listener for the Cancel button inside the modal
            document
                .getElementById("cancelInvite")
                .addEventListener("click", hideInviteModal);

            // Event listener for the Invite form submission
            document
                .getElementById("inviteForm")
                .addEventListener("submit", function (event) {
                    event.preventDefault();

                    // Get the email value
                    const email = document
                        .getElementById("inviteEmail")
                        .value.trim();

                    if (email) {
                        // Here you can add validation if needed

                        // Hide the modal
                        hideInviteModal();

                        // Show success notification
                        showNotification(
                            "Invitation sent successfully!",
                            "success"
                        );

                        // Optionally, reset the form
                        document.getElementById("inviteForm").reset();
                    }
                });
        });
    }

    // Function to show notifications
    function showNotification(message, type) {
        const notification = document.createElement("div");
        notification.classList.add("notification", type);
        notification.textContent = message;

        document.body.appendChild(notification);

        // Automatically fade out after 3 seconds
        setTimeout(() => {
            notification.classList.add("fade-out");
            // Remove the notification after the fade-out transition
            notification.addEventListener("transitionend", () => {
                notification.remove();
            });
        }, 3000);
    }

    // Function to show the leave modal
    function showLeaveModal() {
        document.getElementById("leaveModal").style.display = "flex";
    }

    // Function to hide the leave modal
    function hideLeaveModal() {
        document.getElementById("leaveModal").style.display = "none";
    }

    // Event listener for the Leave button
    document
        .querySelector(".leave-btn")
        .addEventListener("click", function (event) {
            event.preventDefault();
            showLeaveModal();
        });

    // Event listener for the Close button in Leave modal
    document
        .getElementById("closeLeaveModal")
        .addEventListener("click", hideLeaveModal);

    // Event listener for the Cancel button inside the Leave modal
    document
        .getElementById("cancelLeave")
        .addEventListener("click", hideLeaveModal);

    // Event listener for the Confirm Leave button
    document
        .getElementById("confirmLeave")
        .addEventListener("click", function () {
            hideLeaveModal();
            showNotification(
                "You have successfully left the community.",
                "info"
            );
            setTimeout(() => {
                window.loadPage("discover"); // Redirect after 1 second
            }, 600);
        });

    // Reusing the showNotification function from the Invite modal
    // Ensure this function is defined only once if both modals are present
    function showNotification(message, type) {
        const notification = document.createElement("div");
        notification.classList.add("notification", type);
        notification.textContent = message;

        document.body.appendChild(notification);

        // Automatically fade out after 3 seconds
        setTimeout(() => {
            notification.classList.add("fade-out");
            // Remove the notification after the fade-out transition
            notification.addEventListener("transitionend", () => {
                notification.remove();
            });
        }, 3000);
    }
})();


(function() {
    function initializeEventModal() {
        const eventInput = document.querySelector('.event-input input');
        const createEventContainer = document.querySelector('.create-event-container');
        const cancelEventButton = document.querySelector('.cancel-event');
        const eventImageInput = document.getElementById('event-image');
        const eventImagePreview = document.getElementById('event-image-preview');
        const createEventForm = document.getElementById('create-event-form');
        const newsFeed = document.getElementById('newsFeed');

        if (eventInput && createEventContainer) {
            // Open modal when clicking the event input
            eventInput.addEventListener('click', function() {
                createEventContainer.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Close modal when clicking cancel
            if (cancelEventButton) {
                cancelEventButton.addEventListener('click', function() {
                    createEventContainer.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }

            // Close modal when clicking outside
            createEventContainer.addEventListener('click', function(e) {
                if (e.target === createEventContainer) {
                    createEventContainer.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        }

        // Handle image preview
        if (eventImageInput && eventImagePreview) {
            eventImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        eventImagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Function to create new event HTML
        function createEventElement(eventData) {
            const newEvent = document.createElement('div');
            newEvent.className = 'news-post';

            // Format current date
            const currentDate = new Date();
            const formattedDate = currentDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            newEvent.innerHTML = `
                <div class="post-header">
                    <img src="${eventData.creatorImage || '/assets/img/default_profile.png'}" alt="${eventData.creatorName}" class="post-avatar" loading="lazy">
                    <div class="post-info">
                        <strong>${eventData.creatorName}</strong><br>
                        <span class="post-date">${formattedDate}</span>
                    </div>
                    <strong class="elipse">...</strong>
                </div>
                <img src="${eventData.imagePath || '/assets/img/default_event.png'}" class="post-image" alt="${eventData.eventName}" loading="lazy">
                <div class="post-description">
                    <h2 class="post-title">${eventData.eventName}</h2>
                    <p class="post-excerpt">${eventData.description}</p>
                    <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                </div>
            `;

            return newEvent;
        }

        // Handle form submission
        if (createEventForm) {
            createEventForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                formData.append('community_id', document.querySelector('input[name="community_id"]').value);

                try {
                    const response = await fetch('/src/controllers/home_pages/communityUsers.php', {
                        method: 'POST',
                        body: formData
                    });

                    const result = await response.json();
                    console.log(result);
                    if (result.success) {
                        console.log(result.success);
                        // Create and add new event to the top of the feed
                        const eventElement = createEventElement({
                            eventName: formData.get('event_name'),
                            description: formData.get('description'),
                            imagePath: result.imagePath,
                            creatorName: result.creatorName,
                            creatorImage: result.creatorImage
                        });

                        // Add the new event to the top of the feed
                        if (newsFeed.firstChild) {
                            newsFeed.insertBefore(eventElement, newsFeed.firstChild);
                        } else {
                            newsFeed.appendChild(eventElement);
                        }

                        // Show success notification
                        showNotification('Event created successfully!', 'success');

                        // Reset form and close modal
                        createEventContainer.style.display = 'none';
                        document.body.style.overflow = '';
                        createEventForm.reset();
                        eventImagePreview.src = '/assets/img/default_event.png';
                    } else {
                        throw new Error(result.message || 'Failed to create event');
                    }
                } catch (error) {
                    showNotification(error.message || 'Failed to create event. Please try again.', 'error');
                    // console.log(result.success);
                }
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeEventModal);
    } else {
        initializeEventModal();
    }

    // Reuse the existing notification function
    function showNotification(message, type = "info") {
        const existingNotifications = document.querySelectorAll(".notification");
        existingNotifications.forEach((notification) => {
            notification.remove();
        });

        const notification = document.createElement("div");
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add("fade-out");
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 500);
        }, 3000);
    }
})();


(function () {
    // Function to show the members-content section
    function showMembersContent() {
        // Select all navigation links and the "View All" button
        const navLinks = document.querySelectorAll(".nav-link");
        const viewAllBtn = document.getElementById("viewAllBtn");
        const contentSections = document.querySelectorAll(".content-section");

        // Remove 'active' class from all nav links
        navLinks.forEach((nav) => nav.classList.remove("active"));

        // Hide all content sections
        contentSections.forEach((section) => (section.style.display = "none"));

        // Show the members-content section
        const membersContent = document.querySelector(".members-content");
        if (membersContent) {
            membersContent.style.display = "grid"; // Adjust as per your layout (e.g., "block" or "flex")
        }

        // Optionally, add 'active' class to the "View All" button for styling
        if (viewAllBtn) {
            viewAllBtn.classList.add("active");
        }
    }

    // Function to remove 'active' class from the "View All" button when other nav links are clicked
    function removeActiveFromViewAll() {
        const viewAllBtn = document.getElementById("viewAllBtn");
        if (viewAllBtn) {
            viewAllBtn.classList.remove("active");
        }
    }

    // Initialize the "View All" button event listener
    function initializeViewAllButton() {
        const viewAllBtn = document.getElementById("viewAllBtn");
        if (viewAllBtn) {
            viewAllBtn.addEventListener("click", function (e) {
                e.preventDefault();
                showMembersContent();
            });
        }
    }

    // Initialize the existing navigation links to remove 'active' from "View All" when clicked
    function initializeNavLinks() {
        const navLinks = document.querySelectorAll(".nav-link");
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                removeActiveFromViewAll();
            });
        });
    }

    // Initialize all event listeners
    function initialize() {
        initializeViewAllButton();
        initializeNavLinks();
    }

    // Initialize when DOM is ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initialize);
    } else {
        initialize();
    }
})();
