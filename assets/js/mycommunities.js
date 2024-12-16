document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("open-dashboard")) {
            const communityId = e.target.getAttribute("data-community-id");
            loadDashboard(communityId);
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener("popstate", function (event) {
        if (event.state && event.state.type === "Dashboard") {
            loadDashboard(event.state.id);
        }
    });

    // Check URL on page load for direct community access
    const hash = window.location.hash;
    if (hash.startsWith("#Dashboard/")) {
        const communityId = hash.split("/")[1];
        if (communityId) {
            loadDashboard(communityId);
        }
    }
});
function loadDashboard(communityId) {
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
            let dynamicScript = document.getElementById("dynamic-script");
            if (!dynamicScript) {
                dynamicScript = document.createElement("script");
                dynamicScript.id = "dynamic-script";
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
