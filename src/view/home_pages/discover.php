<?php
require_once __DIR__ . '/../../controllers/home_pages/discoverController.php';

?>

<div class="page-content">
    <main>
        <div class="container">
            <header class="page-header">
                <h1>Discover Communities</h1>
                <p>Find and join communities that match your interests</p>
            </header>

            
            <div class="community-grid">
                <?php if (empty($communities)): ?>
                    <h1 class="no-communities">No communities found.</h1>
                <?php else: ?>
                    <?php foreach ($communities as $community): ?>
                        <div class="community-card">
                            <div class="card-header">
                                <img src="<?= htmlspecialchars($community['profile_image']) ?>" alt="LEM FTI Logo" class="community-logo">
                                <div class="community-info">
                                    <h2><?= htmlspecialchars($community['community_name']) ?></h2>
                                    <p class="community-type"><?= ucwords(htmlspecialchars($community['community_type'])) ?></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="community-description"><?= htmlspecialchars($community['description']) ?></p>
                                <div class="community-stats">
                                    <span class="member-count"><i class="fas fa-users"></i> <?= htmlspecialchars($community['member_count']) ?> members</span>
                                    <?php if ($community['recruitment_status'] == 'open'): ?>
                                        <span class="status open">open</span>
                                    <?php else: ?>
                                        <span class="status close">close</span>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="view-btn" data-community-id="<?= htmlspecialchars($community['community_id']) ?>">View Community</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
