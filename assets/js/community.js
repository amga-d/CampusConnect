document.addEventListener("DOMContentLoaded", function () {
    // Delegate event listener to handle dynamically loaded content
    document.body.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("view-btn")) {
            const communityId = e.target.getAttribute("data-community-id");
            loadCommunityView(communityId);
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener("popstate", function (event) {
        if (event.state && event.state.type === "community") {
            loadCommunityView(event.state.id);
        }
    });

    // Check URL on page load for direct community access
    const hash = window.location.hash;
    if (hash.startsWith("#community/")) {
        const communityId = hash.split("/")[1];
        if (communityId) {
            loadCommunityView(communityId);
        }
    }
    
});
function setupJoinFormSubmission() {
    // document.body.addEventListener("submit", function (e) {
    //     if (e.target && e.target.classList.contains("view-btn")) {
    //         const communityId = e.target.getAttribute("data-community-id");
    //     }
    // });
    const joinCommunityForm = document.getElementById("joinCommunityForm");
    if (joinCommunityForm) {
        joinCommunityForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("/src/controllers/home_pages/joinCommunity.php", {
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
                        loadDashboard(data.community_id);
                    } else {
                        alert(data.message || "Failed to create community");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred while joining the community");
                });
        });
    }
}

function loadCommunityView(communityId) {
    // Check if dynamic-styles element exists, if not create it
    let dynamicStyles = document.getElementById("dynamicStyles");
    if (!dynamicStyles) {
        dynamicStyles = document.createElement("link");
        dynamicStyles.id = "dynamic-styles";
        dynamicStyles.rel = "stylesheet";
        document.head.appendChild(dynamicStyles);
    }

    // Update the stylesheet
    dynamicStyles.href = "/assets/styles/home_pages/viewCommunity.css";

    // Update navigation active state
    document
        .querySelectorAll(".nav-item")
        .forEach((item) => item.classList.remove("active"));
    const discoverNavItem = document.querySelector(
        '.nav-item a[href="#discover"]'
    ).parentElement;
    if (discoverNavItem) {
        discoverNavItem.classList.add("active");
    }

    fetch(`/src/view/home_pages/viewCommunity.php?community_id=${communityId}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        })
        .then((html) => {
            document.getElementById("main-content").innerHTML = html;
            // Update the navigation title
            const navTitle = document.getElementById("nav-title");
            if (navTitle) {
                navTitle.textContent = "Community Details";
            }
            // Update URL without page reload
            if (!window.location.hash.includes(communityId)) {
                history.pushState(
                    {
                        page: "viewCommunity",
                        id: communityId,
                        type: "community",
                    },
                    "",
                    `#community/${communityId}`
                );
            }
            //setupJoinFormSubmission
            setupJoinFormSubmission();
        })
        .catch((error) => {
            console.error("Error loading community view:", error);
            document.getElementById("main-content").innerHTML =
                '<div class="error-message">Failed to load community details</div>';
        });
}
function toggleReadMore(element) {
    const excerpt = element.previousElementSibling;
    const isCollapsed =
        excerpt.style.webkitLineClamp === "3" || !excerpt.style.webkitLineClamp;

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