document.addEventListener("DOMContentLoaded", function () {
    // Sidebar toggle functionality

    barbtn.addEventListener("click", function () {
        collapse();
    });
    toggleBtn.addEventListener("click", function () {
        collapse();
    });

    // Navigation functionality
    setupNavigation();
});

document.addEventListener("DOMContentLoaded", function () {
    const userMenuBtn = document.getElementById("userMenuBtn");
    const userDropdown = document.getElementById("userDropdown");

    userMenuBtn.addEventListener("click", function (event) {
        event.stopPropagation();
        userDropdown.classList.toggle("show");
    });

    // Close the dropdown when clicking outside
    document.addEventListener("click", function (event) {
        if (
            !userMenuBtn.contains(event.target) &&
            !userDropdown.contains(event.target)
        ) {
            userDropdown.classList.remove("show");
        }
    });
});

const sidebar = document.getElementById("sidebar");
const toggleBtn = document.getElementById("toggleSidebar");
const toggleIcon = toggleBtn.querySelector("i");
const barbtn = document.getElementById("bar");
const navTitle = document.getElementById("nav-title");

collapse();

function collapse() {
    sidebar.classList.toggle("collapsed");

    if (sidebar.classList.contains("collapsed")) {
        toggleIcon.classList.remove("fa-chevron-left");
        toggleIcon.classList.add("fa-chevron-right");
    } else {
        toggleIcon.classList.remove("fa-chevron-right");
        toggleIcon.classList.add("fa-chevron-left");
    }
}

function setupNavigation() {
    // Create main content container if it doesn't exist
    let mainContent = document.getElementById("main-content");
    if (!mainContent) {
        mainContent = document.createElement("main");
        mainContent.id = "main-content";
        document.querySelector(".layout").appendChild(mainContent);
    }

    const navItems = document.querySelectorAll(
        ".nav-item a, .profile-link, .profile-link2"
    );

    // Style mapping for each page

    const pageStyles = {
        home: "/assets/styles/home_pages/home.css",
        discover: "/assets/styles/home_pages/discover.css",
        myCommunities: "/assets/styles/home_pages/myCommunities.css",
        events: "/assets/styles/home_pages/events.css",
        news: "/assets/styles/home_pages/news.css",
        profile: "/assets/styles/home_pages/profile.css",
        createCommunity: "/assets/styles/home_pages/newcommunity.css",
    };

    const pageScript = {
        home: "",
        discover: "",
        myCommunities: "",
        events: "/assets/js/events.js",
        news: "/assets/js/events.js",
        profile: "/assets/js/profile.js",
        createCommunity: "",
    };
    // Improved loadPage function with better error handling
    async function loadPage(pageId) {
        try {
            // Hide the main content to prevent FOUC
            mainContent.style.visibility = "hidden";

            // Remove 'active' class from all nav items
            navItems.forEach((item) => {
                const parent = item.parentElement;
                if (parent.classList.contains("nav-item")) {
                    parent.classList.remove("active");
                }
            });

            // Add 'active' class to the current nav item
            const currentNavItem = document.querySelector(
                `.nav-item a[href="#${pageId}"]`
            );
            if (currentNavItem) {
                currentNavItem.parentElement.classList.add("active");
            }

            // Update the Nav-title
            const title = pageId.charAt(0).toUpperCase() + pageId.slice(1);
            navTitle.textContent = title;

            // Remove previously added CSS files
            const existingLinks = document.querySelectorAll(
                'link[rel="stylesheet"]'
            );
            existingLinks.forEach((link) => {
                if (link.href.includes("/assets/styles/home_pages/")) {
                    link.remove();
                }
            });

            // Remove previously added js file
            const existingScript = document.getElementById("dynamic-script");
            if (
                existingScript != null &&
                existingScript.src.includes("/assets/js/")
            ) {
                existingScript.remove();
            }

            // Load the corresponding CSS file
            const cssFilePath = pageStyles[pageId];
            if (cssFilePath) {
                const linkElement = document.createElement("link");
                linkElement.id = "dynamicStyles";
                linkElement.rel = "stylesheet";
                linkElement.href = cssFilePath;
                document.head.appendChild(linkElement);

                // Wait for the CSS file to be fully loaded
                await new Promise((resolve, reject) => {
                    linkElement.onload = resolve;
                    linkElement.onerror = reject;
                });
            }

            // Load the corresponding page content
            const response = await fetch(`/src/view/home_pages/${pageId}.php`);
            const pageContent = await response.text();
            mainContent.innerHTML = pageContent;

            //load the corresponding js file
            const scriptPath = pageScript[pageId];
            if (scriptPath) {
                const dynamicScript = document.createElement("script");
                dynamicScript.src = scriptPath;
                dynamicScript.id = "dynamic-script";
                document.body.appendChild(dynamicScript);

                // Wait for the js file to be fully loaded
            }
            // Show the main content after everything is loaded
            mainContent.style.visibility = "visible";
        } catch (error) {
            console.error("Error loading page:", error);
            mainContent.style.visibility = "visible"; // Ensure content is visible in case of error
        }
    }

    // Add click event listeners with error handling
    navItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            if (window.innerWidth <= 425) {
                collapse();
            }
            e.preventDefault();
            const pageId = item.getAttribute("href")?.substring(1) || "home";
            loadPage(pageId);
            // Update URL without page reload
            window.history.pushState({ page: pageId }, "", `#${pageId}`);
        });
    });

    // Load initial page based on URL hash or default to home
    const initialPage = window.location.hash.substring(1) || "home";
    loadPage(initialPage);
}
