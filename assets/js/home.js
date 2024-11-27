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

    // Add click event listeners to each nav link
    navItems.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Get the href value
            const href = link.getAttribute('href');
            const page = href.replace('#', '');

            // Update active state
            const navItem = link.closest('.nav-item');
            setActiveNavItem(navItem);

            // Load the corresponding content
            loadPageContent(page);
        });
    });

    // Set initial active state based on URL hash or default to home
    const currentHash = window.location.hash || '#home';
    const initialNavItem = document.querySelector(`.nav-item a[href="${currentHash}"]`).closest('.nav-item');
    setActiveNavItem(initialNavItem);
    loadPageContent(currentHash.replace('#', ''));
}

function setActiveNavItem(activeItem) {
    // First, remove active class from all items
    const allItems = document.querySelectorAll('.nav-item');
    allItems.forEach(item => item.classList.remove('active'));

    // Add active class to the clicked item
    activeItem.classList.add('active');

    // Store active state in sessionStorage
    const href = activeItem.querySelector('a').getAttribute('href');
    sessionStorage.setItem('activeNavItem', href);
}

async function loadPageContent(page) {
    const mainContent = document.getElementById('main-content');

    try {
        // Show loading state
        mainContent.innerHTML = '<div class="loading">Loading...</div>';

        // Update URL
        window.history.pushState({ page }, '', `#${page}`);

        // Fetch the page content
        const response = await fetch(`/src/view/pages/${page}.php`);
        
        if (!response.ok) {
            throw new Error('Page not found');
        }

        const content = await response.text();
        mainContent.innerHTML = content;

    } catch (error) {
        console.error('Error loading page:', error);
        mainContent.innerHTML = `
            <div class="error-container">
                <h2>Error Loading Page</h2>
                <p>Sorry, we couldn't load the requested page.</p>
            </div>
        `;
    }
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


