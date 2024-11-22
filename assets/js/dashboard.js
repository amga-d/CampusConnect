document.addEventListener('DOMContentLoaded', () => {
    // Initialize components
    initializeSidebar();
    populateDashboardData();
    initializeAnimations();
    initializeNotifications();
    initializeSearch();
});

function initializeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const layout = document.querySelector('.layout');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        // Update toggle button icon
        if (sidebar.classList.contains('collapsed')) {
            toggleBtn.innerHTML = '<i class="fas fa-chevron-right"></i>';
        } else {
            toggleBtn.innerHTML = '<i class="fas fa-chevron-left"></i>';
        }
    });
}

function populateDashboardData() {
    // Sample data with dummy images
    const events = [
        {
            title: 'Tech Workshop',
            date: '2024-03-25',
            time: '14:00',
            location: 'Innovation Lab',
            category: 'Workshop'
        },
        {
            title: 'Career Fair',
            date: '2024-03-28',
            time: '10:00',
            location: 'Main Hall',
            category: 'Career'
        }
    ];

    const communities = [
        {
            name: 'Programming Club',
            members: 156,
            activity: 'High',
            image: 'https://placehold.co/200x200/4A90E2/FFFFFF?text=Programming+Club'
        },
        {
            name: 'Photography Society',
            members: 89,
            activity: 'Medium',
            image: 'https://placehold.co/200x200/5C6BC0/FFFFFF?text=Photography'
        }
    ];

    const activities = [
        {
            type: 'join',
            user: 'Sarah Chen',
            target: 'AI Research Group',
            time: '2 hours ago'
        },
        {
            type: 'event',
            user: 'David Kim',
            target: 'Web Development Workshop',
            time: '4 hours ago'
        }
    ];

    // Populate events
    const eventsList = document.getElementById('eventsList');
    eventsList.innerHTML = events.map(event => `
        <div class="event-item" data-aos="fade-up">
            <div class="event-date">
                <span class="day">${new Date(event.date).getDate()}</span>
                <span class="month">${new Date(event.date).toLocaleString('default', { month: 'short' })}</span>
            </div>
            <div class="event-details">
                <h3>${event.title}</h3>
                <p><i class="fas fa-clock"></i> ${event.time}</p>
                <p><i class="fas fa-map-marker-alt"></i> ${event.location}</p>
                <span class="event-category">${event.category}</span>
            </div>
        </div>
    `).join('');

    // Populate communities
    const communitiesList = document.getElementById('communitiesList');
    communitiesList.innerHTML = communities.map(community => `
        <div class="community-item" data-aos="fade-up">
            <img src="${community.image}" alt="${community.name}">
            <div class="community-details">
                <h3>${community.name}</h3>
                <p>${community.members} members</p>
                <span class="activity-badge ${community.activity.toLowerCase()}">${community.activity} Activity</span>
            </div>
        </div>
    `).join('');

    // Populate activity feed
    const activityList = document.getElementById('activityList');
    activityList.innerHTML = activities.map(activity => `
        <div class="activity-item" data-aos="fade-left">
            <div class="activity-icon ${activity.type}">
                <i class="fas fa-${activity.type === 'join' ? 'user-plus' : 'calendar-plus'}"></i>
            </div>
            <div class="activity-details">
                <p><strong>${activity.user}</strong> ${activity.type === 'join' ? 'joined' : 'created an event in'} ${activity.target}</p>
                <span class="activity-time">${activity.time}</span>
            </div>
        </div>
    `).join('');
    
}

function initializeAnimations() {
    // Add smooth reveal animations for cards
    const cards = document.querySelectorAll('.dashboard-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease-out';
        observer.observe(card);
    });
}

function initializeNotifications() {
    const notificationBtn = document.querySelector('.notification-btn');
    
    notificationBtn.addEventListener('click', () => {
        // Add notification functionality here
        console.log('Notifications clicked');
    });
}

function initializeSearch() {
    const searchInput = document.querySelector('.search-container input');
    const searchResults = document.createElement('div');
    searchResults.className = 'search-results';
    document.querySelector('.search-container').appendChild(searchResults);

    // Sample search data
    const searchData = {
        communities: ['Programming Club', 'Photography Society', 'AI Research Group'],
        events: ['Tech Workshop', 'Career Fair', 'Alumni Meetup'],
        people: ['John Doe', 'Sarah Chen', 'David Kim']
    };

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }

        const filteredResults = {
            communities: searchData.communities.filter(item => 
                item.toLowerCase().includes(query)
            ),
            events: searchData.events.filter(item => 
                item.toLowerCase().includes(query)
            ),
            people: searchData.people.filter(item => 
                item.toLowerCase().includes(query)
            )
        };

        // Display results
        const hasResults = Object.values(filteredResults).some(arr => arr.length > 0);
        if (hasResults) {
            searchResults.innerHTML = `
                ${filteredResults.communities.length ? `
                    <div class="search-category">
                        <h4>Communities</h4>
                        ${filteredResults.communities.map(item => 
                            `<div class="search-item"><i class="fas fa-users"></i>${item}</div>`
                        ).join('')}
                    </div>
                ` : ''}
                ${filteredResults.events.length ? `
                    <div class="search-category">
                        <h4>Events</h4>
                        ${filteredResults.events.map(item => 
                            `<div class="search-item"><i class="fas fa-calendar"></i>${item}</div>`
                        ).join('')}
                    </div>
                ` : ''}
                ${filteredResults.people.length ? `
                    <div class="search-category">
                        <h4>People</h4>
                        ${filteredResults.people.map(item => 
                            `<div class="search-item"><i class="fas fa-user"></i>${item}</div>`
                        ).join('')}
                    </div>
                ` : ''}
            `;
            searchResults.style.display = 'block';
        } else {
            searchResults.innerHTML = '<div class="no-results">No results found</div>';
            searchResults.style.display = 'block';
        }
    });

    // Close search results when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.search-container')) {
            searchResults.style.display = 'none';
        }
    });



} 