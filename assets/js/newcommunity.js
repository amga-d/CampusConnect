// Function to handle image preview
function setupImagePreview() {
    const profileImageInput = document.getElementById("profileImage");
    const imagePreview = document.getElementById("imagePreview");
    const imagePreviewContainer = document.querySelector(
        ".image-preview-container"
    );

    if (profileImageInput && imagePreview && imagePreviewContainer) {
        // Handle click on the preview container
        imagePreviewContainer.addEventListener("click", function (e) {
            profileImageInput.click();
        });

        // Handle file selection
        profileImageInput.addEventListener("change", function (e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
}

// Function to handle form submission
function setupFormSubmission() {
    const createCommunityForm = document.getElementById("createCommunityForm");

    if (createCommunityForm) {
        createCommunityForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("/src/controllers/home_pages/createCommunity.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => {
                    if (
                        !response.headers
                            .get("Content-Type")
                            ?.includes("application/json")
                    ) {
                        throw new Error("Invalid response format");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        // Redirect to the new community page
                        loadNewDashboard(data.community_id);
                    } else {
                        alert(data.message || "Failed to create community");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred while creating the community");
                });
        });
    }
}

// Initialize all functionality
function initNewCommunity() {
    setupImagePreview();
    setupFormSubmission();
}

function loadNewDashboard(communityId) {
    // Check if dynamic-styles element exists, if not create it
    let dynamicStyles = document.getElementById("dynamicStyles");
    if (!dynamicStyles) {
        dynamicStyles = document.createElement("link");
        dynamicStyles.id = "dynamicStyles";
        dynamicStyles.rel = "stylesheet";
        document.head.appendChild(dynamicStyles);
    }
    // Update the stylesheet
    dynamicStyles.href = "/assets/styles/home_pages/communitydashboard.css";

    // Update navigation active state
    document
        .querySelectorAll(".nav-item")
        .forEach((item) => item.classList.remove("active"));
    const discoverNavItem = document.querySelector(
        '.nav-item a[href="#myCommunities"]'
    ).parentElement;
    if (discoverNavItem) {
        discoverNavItem.classList.add("active");
    }

    fetch(
        `/src/view/home_pages/communitydashboard.php?community_id=${communityId}`
    )
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then((html) => {
            document.getElementById("main-content").innerHTML = html;
            const navTitle = document.getElementById("nav-title");
            if (navTitle) {
                navTitle.textContent = "Community Dashboard";
            }
            // Check if dynamic-script element exists, if not create is
            let dynamicScript = document.getElementById("dynamicscript");
            if (!dynamicScript) {
                dynamicScript = document.createElement("script");
                dynamicScript.id = "dynamicscript";
                document.body.appendChild(dynamicScript);
            }
            dynamicScript.src = "/assets/js/communitydashboard.js";
            // Update URL without page reload
            if (!window.location.hash.includes(communityId)) {
                history.pushState(
                    {
                        page: "Dashboard",
                        id: communityId,
                        type: "Dashboard",
                    },
                    "",
                    `#Dashboard/${communityId}`
                );
            }
        })
        .catch((error) => {
            console.error("Error loading community dashboard:", error);
            document.getElementById("main-content").innerHTML =
                '<div class="error-message">Failed to load Community Dashboard </div>';
        });
}

// Run initialization when the script loads
initNewCommunity();

// Also run initialization when the DOM content loads (for cases where the script loads before the DOM)
document.addEventListener("DOMContentLoaded", initNewCommunity);
