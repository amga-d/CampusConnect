<?php
    require_once __DIR__ . '/../../controllers/home_pages/homeController.php';
?>

<style>
    .community-image img, .event-image img {
        width: 100%;
        height: auto;
        max-height: 150px; /* Adjust as needed */
        object-fit: cover;
        border-radius: 8px; /* Optional: for rounded corners */
    }
    .community-card, .event-card {
        margin-bottom: 20px;
    }
</style>

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
                        <?= count($communities); ?>
                    </div>
                </div>
            </div>
            
            <div class="embedded-cards">
                <?php if (empty($communities)): ?>
                    <p>No active communities.</p>
                <?php else: ?>
                    <?php foreach ($communities as $community): ?>
                        <div class="community-card">
                            <div class="community-image">
                                <img src="<?= htmlspecialchars($community['profile_image']); ?>" alt="<?= htmlspecialchars($community['community_name']); ?>">
                            </div>
                            <div class="community-info">
                                <h4><?= htmlspecialchars($community['community_name']); ?></h4>
                                <p><?= htmlspecialchars($community['description']); ?></p>
                                <span class="metrics-badge"><?= htmlspecialchars($community['member_count']); ?> members</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Upcoming Events Stat Card -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>Upcoming Events</h3>
                    <div class="stat-number">
                        <?= count($events); ?>
                    </div>
                </div>
            </div>
            
            <div class="embedded-cards">
                <?php if (empty($events)): ?>
                    <p>No upcoming events.</p>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <div class="event-card">
                            <div class="event-image">
                                <img src="<?= htmlspecialchars($event['community_image']); ?>" alt="<?= htmlspecialchars($event['event_name']); ?>">
                            </div>
                            <div class="event-info">
                                <h4><?= htmlspecialchars($event['event_name']); ?></h4>
                                <p>Date: <?= htmlspecialchars($event['created_at']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</div>