document.addEventListener('DOMContentLoaded', function() {
    // Delegate event listener to handle dynamically loaded content
    document.body.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('view-btn')) {
            const communityId = e.target.getAttribute('data-community-id');
            loadCommunityView(communityId);
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        if (event.state && event.state.type === 'community') {
            loadCommunityView(event.state.id);
        }
    });

    // Check URL on page load for direct community access
    const hash = window.location.hash;
    if (hash.startsWith('#community/')) {
        const communityId = hash.split('/')[1];
        if (communityId) {
            loadCommunityView(communityId);
        }
    }
});

function loadCommunityView(communityId) {
    
    // Check if dynamic-styles element exists, if not create it
    let dynamicStyles = document.getElementById('dynamicStyles');
    if (!dynamicStyles) {
        dynamicStyles = document.createElement('link');
        dynamicStyles.id = 'dynamic-styles';
        dynamicStyles.rel = 'stylesheet';
        document.head.appendChild(dynamicStyles);
    }
    
    // Update the stylesheet
    dynamicStyles.href = '/assets/styles/home_pages/viewCommunity.css';

    // Update navigation active state
    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    const discoverNavItem = document.querySelector('.nav-item a[href="#discover"]').parentElement;
    if (discoverNavItem) {
        discoverNavItem.classList.add('active');
    }

    fetch(`/src/view/home_pages/viewCommunity.php?community_id=${communityId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            document.getElementById('main-content').innerHTML = html;
            // Update the navigation title
            const navTitle = document.getElementById('nav-title');
            if (navTitle) {
                navTitle.textContent = 'Community Details';
            }
            // Update URL without page reload
            if (!window.location.hash.includes(communityId)) {
                history.pushState(
                    { 
                        page: 'viewCommunity', 
                        id: communityId,
                        type: 'community'
                    }, 
                    "", 
                    `#community/${communityId}`
                );
            }
        })
        .catch(error => {
            console.error('Error loading community view:', error);
            document.getElementById('main-content').innerHTML = 
                '<div class="error-message">Failed to load community details</div>';
        });
} 