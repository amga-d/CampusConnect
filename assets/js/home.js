document.addEventListener("DOMContentLoaded", function () {
    const userMenuBtn = document.getElementById("userMenuBtn");
    const userDropdown = document.getElementById("userDropdown");
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleSidebar");
    const toggleIcon = toggleBtn.querySelector("i");
    const barbtn = document.getElementById("bar");
    const navTitle = document.getElementById("nav-title");

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
    // Sidebar toggle functionality

    barbtn.addEventListener("click", function () {
        collapse();
    });
    toggleBtn.addEventListener("click", function () {
        collapse();
    });

    // Navigation functionality
    setupNavigation();

    collapse();

    function collapse() {
        if (window.innerWidth > 1100) {
            return; // Do not collapse if screen width is greater than 1024px
        }
        sidebar.classList.toggle("collapsed");

        if (sidebar.classList.contains("collapsed")) {
            toggleIcon.classList.remove("fa-chevron-left");
            toggleIcon.classList.add("fa-chevron-right");
        } else {
            toggleIcon.classList.remove("fa-chevron-right");
            toggleIcon.classList.add("fa-chevron-left");
        }
    }

    // Add a resize event listener to ensure sidebar is expanded on large screens
    window.addEventListener('resize', function() {
        if (window.innerWidth > 1100 && sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            toggleIcon.classList.remove("fa-chevron-right");
            toggleIcon.classList.add("fa-chevron-left");
        }
    });

    function setupNavigation() {
        // Create main content container if it doesn't exist
        let mainContent = document.getElementById("main-content");
        if (!mainContent) {
            mainContent = document.createElement("main");
            mainContent.id = "main-content";
            document.querySelector(".layout").appendChild(mainContent);
        }

        // Add click handler for new community link
        const newCommunityLink = document.querySelector('.new-community-link');
        if (newCommunityLink) {
            newCommunityLink.addEventListener('click', function(e) {
                e.preventDefault();
                loadPage('newcommunity');
                window.history.pushState(
                    { page: 'newcommunity', type: 'navigation' },
                    "",
                    '#newcommunity'
                );
            });
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
            newcommunity: "/assets/styles/home_pages/newcommunity.css"
        };

        const pageScript = {
            home: "",
            discover: "",
            myCommunities: "",
            events: "/assets/js/events.js",
            news: "/assets/js/events.js",
            profile: "/assets/js/profile.js",
            newcommunity: "/assets/js/newcommunity.js",
        };
        // Improved loadPage function with better error handling
        window.loadPage = async function(pageId) {
            try {
                // Hide the main content to prevent FOUC
                mainContent.style.visibility = "hidden";

                // Check if it's a community view URL
                if (pageId.startsWith('community/')|| pageId.startsWith('Dashboard/')) {
                    // Let the community.js handle this
                    mainContent.style.visibility = "visible";
                    return;
                }

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
                const titleMap = {
                    home: "Home",
                    discover: "Discover",
                    myCommunities: "My Communities",
                    events: "Events",
                    news: "News",
                    profile: "Profile",
                    newcommunity: "Create Community"
                };
                const title = titleMap[pageId] || pageId.charAt(0).toUpperCase() + pageId.slice(1);
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

                // Remove previously added JS file
                const existingScript = document.getElementById("dynamic-script");
                if (existingScript) {
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
                const response = await fetch(
                    `/src/view/home_pages/${pageId}.php`
                );
                const pageContent = await response.text();
                mainContent.innerHTML = pageContent;

                // Load and execute the corresponding JS file
                const scriptPath = pageScript[pageId];
                if (scriptPath) {
                    const scriptElement = document.createElement("script");
                    scriptElement.id = "dynamic-script";
                    scriptElement.src = scriptPath;
                    document.body.appendChild(scriptElement);

                    // Wait for the script file to be fully loaded
                    await new Promise((resolve, reject) => {
                        scriptElement.onload = resolve;
                        scriptElement.onerror = reject;
                    });
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
                let pageId = item.getAttribute("href")?.substring(1) || "home";
                
                // Handle the new community link click
                if (item.classList.contains('plusButton') || item.parentElement.classList.contains('new-community-link')) {
                    pageId = 'newcommunity';
                }
                
                loadPage(pageId);
                // Update URL and push state with more information
                window.history.pushState(
                    { page: pageId, type: 'navigation' }, 
                    "", 
                    `#${pageId}`
                );
            });
        });

        // Add popstate event listener to handle browser navigation
        window.addEventListener('popstate', function(event) {
            if (event.state) {
                if (event.state.type === 'navigation') {
                    loadPage(event.state.page);
                }
                // community.js will handle its own popstate events
            } else {
                // If no state exists, load the page based on hash
                const pageId = window.location.hash.substring(1) || "home";
                if (!pageId.startsWith('community/' ||!pageId.startsWith('Dashboard/'))) {
                    loadPage(pageId);
                }
            }
        });

        // Load initial page based on URL hash or default to home
        const initialPage = window.location.hash.substring(1) || "home";
        if (initialPage.startsWith('community/') || initialPage.startsWith('Dashboard/')) {
            // If it's a community page, set discover as active
            navItems.forEach((item) => {
                const parent = item.parentElement;
                if (parent.classList.contains("nav-item")) {
                    parent.classList.remove("active");
                }
            });
            const discoverNavItem = document.querySelector('.nav-item a[href="#discover"]');
            if (discoverNavItem) {
                discoverNavItem.parentElement.classList.add('active');
            }
        } else {
            loadPage(initialPage);
            // Set initial history state
            window.history.replaceState(
                { page: initialPage, type: 'navigation' },
                "",
                window.location.hash || "#home"
            );
        }
    }
});
