<?php
    require_once __DIR__ . '/../controllers/homeController.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CampusConnect Dashboard</title>
    <link rel="stylesheet" href="/assets/styles/home_sidebar.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link id="dynamic-styles" rel="stylesheet" href="" />
</head>

<body>
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
                        class="logo" />
                    <img
                        src="/assets/img/landing/logo_name.png"
                        alt=""
                        class="logo_name" />
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
                        <a href="#news">
                            <i class="fas fa-newspaper"></i>
                            <span>News</span>
                        </a>
                    </li>
                </ul>

                <div class="nav-divider"></div>

                <div class="profile-section">
                    <a href="#profile" class="profile-link">
                        <div class="profile-image">
                            <img src="/assets/img/home/default_profile.png" alt="Profile">
                        </div>
                        <div class="profile-info">
                            <span class="profile-name">Mike Tyson</span>
                            <!-- <span class="profile-status">Student</span> -->
                        </div>
                        <i class="fas fa-chevron-right profile-arrow"></i>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Add this after the sidebar and before the main content -->
        <div class="main-wrapper">
            <header class="top-bar">
                <div class="left-section">
                    <div class="bar" id='bar'><i class="fa-solid fa-bars"></i></div>
                    <h2 class="Nav_title">Home</h2>
                </div>

                <div class="right-section">
                    <div class="top-bar-actions">
                        <button class="notification-btn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <button class="messages-btn">
                            <i class="fas fa-envelope"></i>
                            <span class="messages-badge">5</span>
                        </button>
                        <div class="user-menu">
                            <button class="user-menu-btn">
                                <div class="user-avatar">
                                    <img src="/assets/img/home/default_profile.png" alt="User Avatar">
                                </div>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>
            <main id="main-content"></main>
        </div>
    </div>

    <script src="/assets/js/home.js"></script>
</body>

</html>