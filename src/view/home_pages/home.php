<?php
    require_once __DIR__ . '/../../controllers/home_pages/homeController.php';
?>


<div class="page-content">

<main class="main-content">
            <header class="content-header">
                <div class="welcome-section">
                    <h1>Welcome Back, <?php echo htmlspecialchars($username); ?>! 👋</h1>
                    <p>Here's what's happening in your communities</p>
                </div>
                <div class="header-actions">
                    <button class="btn-analytics">
                        <i class="fas fa-chart-bar"></i>
                        Analytics
                    </button>
                    <button class="btn-new-post">
                        <i class="fas fa-plus"></i>
                        New Post
                    </button>
                </div>
            </header>

            <div class="dashboard-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Communities</h3>
                        <div class="stat-number">12</div>
                        <div class="stat-change positive">
                            <span>+2</span> this week
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Upcoming Events</h3>
                        <div class="stat-number">5</div>
                        <div class="stat-change">
                            Next in 2 days
                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-info">
                        <h3>New Messages</h3>
                        <div class="stat-number">28</div>
                        <div class="stat-change">
                            10 unread
                        </div>
                    </div>
                </div>
            </div>

            <section class="community-activity">
                <h2>Community Activity</h2>
                <div class="activity-feed">
                    <!-- Activity items will be dynamically loaded here -->
                </div>
            </section>
        </main>
</div> 