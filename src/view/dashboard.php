<?php

?>

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
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <ul class="nav-list">
                        <li class="nav-item active">
                            <a href="#home">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#discover">
                                <i class="fas fa-compass"></i>
                                <span>Discover</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#communities">
                                <i class="fas fa-users"></i>
                                <span>My Communities</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#events">
                                <i class="fas fa-calendar"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#bookmarks">
                                <i class="fas fa-bookmark"></i>
                                <span>Saved</span>
                            </a>
                        </li>
                    </ul>

                    <div class="nav-divider"></div>
                    
                    <div class="profile-section">
                        <a href="/src/view/profile.php" class="profile-link">
                            <div class="profile-image">
                                <img src="/assets/img/avatars/default.png" alt="Profile" onerror="this.src='/assets/img/avatars/default.png'">
                            </div>
                            <div class="profile-info">
                                <span class="profile-name">Mike Tyson</span>
                                <span class="profile-status">Student</span>
                            </div>
                            <i class="fas fa-chevron-right profile-arrow"></i>
                        </a>
                    </div>
                </nav>
            </aside>

            <main>
                <div class="dashboard-content">
                    <section class="welcome-section">
                        <div class="welcome-text">
                            <h1>Welcome back, Alex! 👋</h1>
                            <p>Check what's new in your communities</p>
                        </div>
                    </section>

                    <section class="activity-section">
                        <div class="activity-card">
                            <div class="activity-header">
                                <i class="fas fa-users"></i>
                                <h2>Your Communities</h2>
                            </div>
                            <div class="activity-content">
                                <p>You're part of 5 active communities</p>
                            </div>
                        </div>
                        
                        <div class="activity-card">
                            <div class="activity-header">
                                <i class="fas fa-calendar"></i>
                                <h2>Upcoming Events</h2>
                            </div>
                            <div class="activity-content">
                                <p>3 events this week</p>
                            </div>
                        </div>
                    </section>

                    <section class="feed-section">
                        <h2>Recent Activity</h2>
                        <div class="feed-list">
                            <div class="feed-item">
                                <div class="feed-content">
                                    <h3>Photography Club</h3>
                                    <p>New photo challenge: "Campus Life"</p>
                                    <span class="feed-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="feed-item">
                                <div class="feed-content">
                                    <h3>Chess Club</h3>
                                    <p>Weekly meetup tomorrow at 5 PM</p>
                                    <span class="feed-time">5 hours ago</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>

        <script src="/assets/js/dashboard.js"></script>/
    </body>
</html>