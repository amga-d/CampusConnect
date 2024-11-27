document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const toggleIcon = toggleBtn.querySelector('i');

    toggleBtn.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        
        if (sidebar.classList.contains('collapsed')) {
            toggleIcon.classList.remove('fa-chevron-left');
            toggleIcon.classList.add('fa-chevron-right');
        } else {
            toggleIcon.classList.remove('fa-chevron-right');
            toggleIcon.classList.add('fa-chevron-left');
        }   
    });

    // Navigation functionality
    setupNavigation();
});

function setupNavigation() {
    // Create main content container if it doesn't exist
    let mainContent = document.getElementById('main-content');
    if (!mainContent) {
        mainContent = document.createElement('main');
        mainContent.id = 'main-content';
        document.querySelector('.layout').appendChild(mainContent);
    }

    // Get all navigation items
    const navItems = document.querySelectorAll('.nav-item a');
    const dynamicStyles = document.getElementById('dynamic-styles');

    // Style mapping for each page
    const pageStyles = {
        'home': '/assets/styles/home.css',
        'discover': '/assets/styles/discover.css',
        'communities': '/assets/styles/communities.css',
        'events': '/assets/styles/events.css',
        'news': '/assets/styles/news.css'
    };

    // Function to load page content and update styles
    async function loadPage(pageId) {
        // Remove 'active' class from all nav items
        navItems.forEach(item => item.parentElement.classList.remove('active'));
        
        // Add 'active' class to clicked item
        const currentNav = document.querySelector(`a[href="#${pageId}"]`);
        if (currentNav) {
            currentNav.parentElement.classList.add('active');
        }

        // Update the dynamic stylesheet
        const stylePath = pageStyles[pageId];
        if (stylePath) {
            dynamicStyles.href = stylePath;
        }

        try {
            // Load the page content
            const response = await fetch(`/src/view/pages/${pageId}.php`);
            if (response.ok) {
                const content = await response.text();
                mainContent.innerHTML = content;
            } else {
                mainContent.innerHTML = '<p>Error loading page content</p>';
            }
        } catch (error) {
            console.error('Error loading page:', error);
            mainContent.innerHTML = '<p>Error loading page content</p>';
        }
    }

    // Add click event listeners to navigation items
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const pageId = item.getAttribute('href').substring(1); // Remove the # from href
            loadPage(pageId);
        });
    });

    // Load home page by default
    loadPage('home');
}

// Handle browser back/forward buttons
window.addEventListener('popstate', (event) => {
    const page = window.location.hash.replace('#', '') || 'home';
    const navItem = document.querySelector(`.nav-item a[href="#${page}"]`).closest('.nav-item');
    
    // Update active state
    setActiveNavItem(navItem);
    
    // Load the page content
    loadPageContent(page);
});

// Restore active state on page refresh
window.addEventListener('load', () => {
    const activeHref = sessionStorage.getItem('activeNavItem') || '#home';
    const activeItem = document.querySelector(`.nav-item a[href="${activeHref}"]`).closest('.nav-item');
    setActiveNavItem(activeItem);
});


