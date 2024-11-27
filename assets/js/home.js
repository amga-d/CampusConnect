document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality


    barbtn.addEventListener('click',function(){
        collapse();
    });
    toggleBtn.addEventListener('click', function() {
        collapse();
    });

    // Navigation functionality
    setupNavigation();
});

const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleSidebar');
const toggleIcon = toggleBtn.querySelector('i');
const barbtn = document.getElementById('bar');

collapse();

function collapse(){
    sidebar.classList.toggle('collapsed');
    
    if (sidebar.classList.contains('collapsed')) {
        toggleIcon.classList.remove('fa-chevron-left');
        toggleIcon.classList.add('fa-chevron-right');
    } else {
        toggleIcon.classList.remove('fa-chevron-right');
        toggleIcon.classList.add('fa-chevron-left');
    } 
}

function setupNavigation() {
    // Create main content container if it doesn't exist
    let mainContent = document.getElementById('main-content');
    if (!mainContent) {
        mainContent = document.createElement('main');
        mainContent.id = 'main-content';
        document.querySelector('.layout').appendChild(mainContent);
    }

    const navItems = document.querySelectorAll('.nav-item a, .profile-link');
    const dynamicStyles = document.getElementById('dynamic-styles');



    // Style mapping for each page


    // Improved loadPage function with better error handling
    async function loadPage(pageId) {
        const pageStyles = {
            'home': '/assets/styles/home_pages/home.css',
            'discover': '/assets/styles/home_pages/discover.css',
            'communities': '/assets/styles/home_pages/communities.css',
            'events': '/assets/styles/home_pages/events.css',
            'news': '/assets/styles/home_pages/news.css',
            'profile': '/assets/styles/home_pages/profile.css'
        };
        try {
            // Remove 'active' class from all nav items
            navItems.forEach(item => {
                const parent = item.parentElement;
                // Only handle nav-items, excluding profile link
                if (parent && parent.classList.contains('nav-item')) {
                    parent.classList.remove('active');
                    item.classList.remove('active');
                }
            });
            
            // Add 'active' class to clicked nav item (excluding profile)
            const currentNav = document.querySelector(`a[href="#${pageId}"]`);
            if (currentNav && currentNav.parentElement.classList.contains('nav-item')) {
                currentNav.parentElement.classList.add('active');
            }

            
            // Update the dynamic stylesheet with error handling
            const stylePath = pageStyles[pageId];
            if (stylePath && dynamicStyles) {
                dynamicStyles.href = stylePath;
                // Add error handling for stylesheet loading
                dynamicStyles.onerror = () => {
                    console.warn(`Failed to load stylesheet: ${stylePath}`);
                };
            }

            // Load the page content with timeout
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5 second timeout

            const response = await fetch(`/src/view/home_pages/${pageId}.php`, {
                signal: controller.signal
            });
            
            clearTimeout(timeoutId);

            if (response.ok) {
                const content = await response.text();
                mainContent.innerHTML = content;
                // Save current page to session storage
                sessionStorage.setItem('activeNavItem', `#${pageId}`);
            } else {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
        } catch (error) {
            console.error('Error loading page:', error);
            mainContent.innerHTML = `
                <div class="error-container">
                    <h2>Error Loading Page</h2>
                    <p>Sorry, we couldn't load the requested content. Please try again later.</p>
                    <button onclick="loadPage('home')">Return to Home</button>
                </div>`;
        }
    }

    // Add click event listeners with error handling
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            console.log(barbtn.style.display);
            if (window.innerWidth <= 425) {
                collapse();
            }
            e.preventDefault();
            const pageId = item.getAttribute('href')?.substring(1) || 'home';
            loadPage(pageId);
            // Update URL without page reload
            window.history.pushState({page: pageId}, '', `#${pageId}`);
        });
    });

    // Load initial page based on URL hash or default to home
    const initialPage = window.location.hash.substring(1) || 'home';
    loadPage(initialPage);
}
