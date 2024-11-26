<?php

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CampusConnect Dashboard</title>
        <link rel="stylesheet" href="/assets/styles/dashboard.css" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        />
    </head>
    <body>
        <div class="custom-cursor"></div>
        <div class="custom-cursor-dot"></div>

        <div class="layout">
            <!-- Animated Sidebar -->
            <aside class="sidebar" id="sidebar">


                <div class="logo-container">
                    <button id="toggleSidebar" aria-label="Toggle Sidebar">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="image-box">
                        <img
                            src="/assets/img/landing/logo_image.png"
                            alt="CampusConnect"
                            class="logo"
                        />
                        <img
                            src="/assets/img/landing/logo_name.png"
                            alt=""
                            class="logo_name"
                        />
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <ul>
                        <li class="active">
                            <a href="#dashboard">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#communities">
                                <i class="fas fa-users"></i>
                                <span>Communities</span>
                            </a>
                        </li>
                        <li>
                            <a href="#events">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="#messages">
                                <i class="fas fa-comments"></i>
                                <span>Messages</span>
                            </a>
                        </li>
                        <li>
                            <a href="#profile">
                                <i class="fas fa-user"></i>
                                <span>Profile</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <main>
                <!-- Modern Header with Glass Effect -->
                <header class="glass-header">
                    <div class="search-container">
                        <i class="fas fa-search"></i>
                        <input
                            type="text"
                            placeholder="Search communities, events, or people..."
                        />
                    </div>

                    <div class="user-actions">
                        <button
                            class="notification-btn"
                            aria-label="Notifications"
                        >
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="user-profile">
                            <img
                                src="https://placehold.co/40x40/4A90E2/FFFFFF?text=JD"
                                alt="User Avatar"
                            />
                            <span>John Doe</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </header>

                <div class="dashboard-content">
                    <!-- Welcome Section with Stats -->
                    <section class="welcome-section">
                        <div class="welcome-text">
                            <h1>Welcome back, John! 👋</h1>
                            <p>
                                Here's what's happening in your campus community
                            </p>
                        </div>
                        <div class="stats-grid">
                            <div class="stat-card">
                                <i class="fas fa-users"></i>
                                <div class="stat-info">
                                    <h3>12</h3>
                                    <p>Active Communities</p>
                                </div>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-info">
                                    <h3>5</h3>
                                    <p>Upcoming Events</p>
                                </div>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-calendar-check"></i>
                                <div class="stat-info">
                                    <h3>5</h3>
                                    <p>Upcoming Events</p>
                                </div>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-comment-dots"></i>
                                <div class="stat-info">
                                    <h3>28</h3>
                                    <p>New Messages</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Main Grid Layout -->
                    <div class="dashboard-grid">
                        <!-- Upcoming Events Card -->
                        <section class="dashboard-card events-card">
                            <div class="card-header">
                                <h2>Upcoming Events</h2>
                                <button class="view-all">View All</button>
                            </div>
                            <div class="events-list" id="eventsList">
                                <!-- Dynamic content will be inserted here -->
                            </div>
                        </section>

                        <!-- Communities Card -->
                        <section class="dashboard-card communities-card">
                            <div class="card-header">
                                <h2>Your Communities</h2>
                                <button class="view-all">View All</button>
                            </div>
                            <div class="communities-list" id="communitiesList">
                                <!-- Dynamic content will be inserted here -->
                            </div>
                        </section>

                        <!-- Activity Feed Card -->
                        <section class="dashboard-card activity-card">
                            <div class="card-header">
                                <h2>Recent Activity</h2>
                                <button class="view-all">View All</button>
                            </div>
                            <div class="activity-list" id="activityList">
                                <!-- Dynamic content will be inserted here -->
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>

        <!-- <script src="../assets/js/cursor.js"></script> -->
        <script src="/assets/js/dashboard.js"></script>/
    </body>
</html>