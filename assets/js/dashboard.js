document.addEventListener('DOMContentLoaded', () => {
    // Initialize components
    initializeSidebar();
    initializeCustomCursor();
    populateDashboardData();
    initializeAnimations();

    // Handle notifications
    initializeNotifications();
});

function initializeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        toggleBtn.querySelector('i').classList.toggle('fa-chevron-right');
        toggleBtn.querySelector('i').classList.toggle('fa-chevron-left');
    });
}

function initializeCustomCursor() {
    const cursor = document.querySelector('.custom-cursor');
    const cursorDot = document.querySelector('.custom-cursor-dot');

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
        cursorDot.style.left = e.clientX + 'px';
        cursorDot.style.top = e.clientY + 'px';
    });

    // Add hover effects for interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .stat-card, .dashboard-card');
    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1.5)';
            cursor.style.border = '2px solid var(--primary)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(0.5)';
        });

        el.addEventListener('mouseleave', () => {
            cursor.style.transform = 'translate(-50%, -50%) scale(1)';
            cursor.style.border = '2px solid var(--primary)';
            cursorDot.style.transform = 'translate(-50%, -50%) scale(1)';
        });
    });
}

function populateDashboardData() {
    // Sample data
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
            image: '../assets/img/communities/prog-club.jpg'
        },
        {
            name: 'Photography Society',
            members: 89,
            activity: 'Medium',
            image: '../assets/img/communities/photo-society.jpg'
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