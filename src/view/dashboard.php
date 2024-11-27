<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debug information
echo "<pre>";
echo "Current file: " . __FILE__ . "\n";
echo "Functions file path: " . __DIR__ . "/../controllers/functions.php\n";
echo "Functions file exists: " . (file_exists(__DIR__ . "/../controllers/functions.php") ? "Yes" : "No") . "\n";
echo "Session data: \n";
print_r($_SESSION);
echo "</pre>";

require_once __DIR__ . "/../controllers/functions.php";

// Check if user is logged in
if (!check_login()) {
    header("Location: /src/view/auth/signin.php");
    exit();
}

// Get user data from session
$username = isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]) : "User";
$user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Campus Connect</title>
    <link rel="stylesheet" href="/assets/styles/dashboard.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Dashboard</h2>
            </div>
            
            <nav class="sidebar-nav">
                <a href="#" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-calendar"></i>
                    <span>Events</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-search"></i>
                    <span>Discover</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-users"></i>
                    <span>My Communities</span>
                </a>
            </nav>

            <div class="sidebar-profile">
                <div class="profile-info">
                    <img src="/assets/img/default-avatar.png" alt="Profile" class="profile-avatar">
                    <div class="profile-details">
                        <h3><?php echo htmlspecialchars($username); ?></h3>
                        <span>Premium Member</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
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

    <script src="/assets/js/dashboard.js"></script>
</body>
</html> 