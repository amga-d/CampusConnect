<?php
    require_once __DIR__ . '/../../controllers/home_pages/homeController.php';
?>


<div class="page-content">

<main class="main-content">
        <header class="content-header">
            <div class="welcome-section">
                <h1>Welcome Back, <?= htmlspecialchars($username); ?>! 👋</h1>
                <p>Here's what's happening in your communities</p>
            </div>
        </header>



        <div class="dashboard-stats">
    <!-- Active Communities Stat Card -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Active Communities</h3>
                <div class="stat-number">
                    12
                    <span class="stat-change">+2 this week</span>
                </div>
            </div>
        </div>
        
        <div class="embedded-cards">
            <div class="community-card">
                <div class="community-image">T</div>
                <div class="community-info">
                    <h4>Tech Enthusiasts</h4>
                    <p>Join fellow tech lovers in discussing the latest trends.</p>
                    <span class="metrics-badge">2.4k members</span>
                </div>
            </div>
            
            <div class="community-card">
                <div class="community-image">A</div>
                <div class="community-info">
                    <h4>Art Lovers</h4>
                    <p>Explore and share your passion for all forms of art.</p>
                    <span class="metrics-badge">1.8k members</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Events Stat Card -->
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-info">
                <h3>Upcoming Events</h3>
                <div class="stat-number">
                    5
                    <span class="stat-change">Next in 2 days</span>
                </div>
            </div>
        </div>
        
        <div class="embedded-cards">
            <div class="event-card">
                <div class="event-image">S</div>
                <div class="event-info">
                    <span class="event-date">May 15, 2024</span>
                    <h4>Spring Festival</h4>
                    <p>Celebrate the arrival of spring with music and food.</p>
                </div>
            </div>
            
            <div class="event-card">
                <div class="event-image">T</div>
                <div class="event-info">
                    <span class="event-date">June 20, 2024</span>
                    <h4>Tech Conference 2024</h4>
                    <p>Join industry leaders to discuss emerging technologies.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
</div> 