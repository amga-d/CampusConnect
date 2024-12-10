document.addEventListener("DOMContentLoaded", function () {
    document.body.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('open-dashboard')) {
            const community_name = e.target.getAttribute('data-community-name');
            const communityId = e.target.getAttribute('data-community-id');
            loadDashboard(communityId , community_name);
        }
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function (event) {
        if (event.state && event.state.type === 'Dashboard') {
            loadDashboard(event.state.id);//////////////////////
        }
    });

    // Check URL on page load for direct community access
    const hash = window.location.hash;
    if (hash.startsWith('#Dashboard/')) {
        const communityId = hash.split('/')[1];
        if (communityId) {
            loadCommunityView(communityId);
        }
    }

});
function loadDashboard(communityId, community_name) {
    //delete mycommunities.css
    const myCommunitiesStyles = document.getElementById('dynamicStyles');
    if(myCommunitiesStyles) {
        myCommunitiesStyles.remove();
    }

    // Check if dynamic-styles element exists, if not create it
    let dynamicStyles = document.getElementById('dynamic-styles');
    if (!dynamicStyles) {
        dynamicStyles = document.createElement('link');
        dynamicStyles.id = 'dynamic-styles';
        dynamicStyles.rel = 'stylesheet';
        document.head.appendChild(dynamicStyles);
    }
    // Update the stylesheet
    dynamicStyles.href = '/assets/styles/home_pages/communitydashboard.css';

    // Update navigation active state
    document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
    const discoverNavItem = document.querySelector('.nav-item a[href="#myCommunities"]').parentElement;
    if (discoverNavItem) {
        discoverNavItem.classList.add('active');
    }

    fetch(`/src/view/home_pages/communitydashboard.php?community_id=${communityId}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(html => {
        document.getElementById('main-content').innerHTML = html;
        const navTitle = document.getElementById('nav-title');
        if (navTitle) {
            navTitle.textContent = 'Community Dashboard > ' + community_name;
        }
        // Update URL without page reload
        if (!window.location.hash.includes(communityId)) {
            history.pushState(
                { 
                    page: 'Dashboard', 
                    id: communityId,
                    type: 'Dashboard'
                }, 
                "", 
                `#Dashboard/${communityId}`
            );
        }
    })
    .catch(error => {
        console.error('Error loading community dashboard:', error);
        document.getElementById('main-content').innerHTML = 
        '<div class="error-message">Failed to load community details</div>';
    });
}
