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
                            src="./assets/img/landing/logo image.png"
                            alt="CampusConnect"
                            class="logo"
                        />
                        <img
                            src="./assets/img/landing/Logo Name.png"
                            alt=""
                            class="logo_name"
                        />
                    </div>
                </div>

                <nav class="sidebar-nav">
                    <ul>
                        <li class="active">
                            <a href="#home">
                                <i class="fas fa-home"></i>
                                <span>Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="#discover">
                                <i class="fas fa-compass"></i>
                                <span>Discover</span>
                            </a>
                        </li>
                        <li>
                            <a href="#communities">
                                <i class="fas fa-users"></i>
                                <span>My Communities</span>
                            </a>
                        </li>
                        <li>
                            <a href="#events">
                                <i class="fas fa-calendar"></i>
                                <span>Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="#bookmarks">
                                <i class="fas fa-bookmark"></i>
                                <span>Saved</span>
                            </a>
                        </li>
                    </ul>
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

        <!-- <script src="../assets/js/cursor.js"></script> -->
        <script src="/assets/js/dashboard.js"></script>/
    </body>
</html>