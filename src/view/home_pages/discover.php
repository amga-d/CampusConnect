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

                    <div class="search-bar">
                        <input type="text" placeholder="Search communities...">
                        <button><i class="fas fa-search"></i></button>
                    </div>

                    <div class="community-grid">
                        <div class="community-card">
                            <div class="card-header">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVFgwzpMs_KaVAW3vHVNuTiZSMU6xm1NkhOg&s" alt="LEM FTI Logo" class="community-logo">
                                <div class="community-info">
                                    <h2>LEM FTI</h2>
                                    <p class="community-type">Student Organization</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="community-description">Student Executive Board of the Faculty of Industrial Technology. Leading innovation and student development.</p>
                                <div class="community-stats">
                                    <span class="member-count"><i class="fas fa-users"></i> 42 members</span>
                                    <span class="status open">Open</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="view-btn">View Community</button>
                            </div>
                        </div>

                        <div class="community-card">
                            <div class="card-header">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRqeqUP_EkA1-rHGHdnBH87C_O1ZoTbhAP2Jg&s" alt="Computer Science Club Logo" class="community-logo">
                                <div class="community-info">
                                    <h2>Central Language Improvement</h2>
                                    <p class="community-type">Academic Community</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="community-description">A community for computer science enthusiasts to learn and grow together.</p>
                                <div class="community-stats">
                                    <span class="member-count"><i class="fas fa-users"></i> 128 members</span>
                                    <span class="status open">Open</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="view-btn">View Community</button>
                            </div>
                        </div>

                        <div class="community-card">
                            <div class="card-header">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCRtvuMsgVl5ZoeeZWFGB186t-UGBi7eewuw&s" alt="Engineering Society Logo" class="community-logo">
                                <div class="community-info">
                                    <h2>HMIF</h2>
                                    <p class="community-type">Professional Organization</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="community-description">Bridging the gap between academic knowledge and industry practice.</p>
                                <div class="community-stats">
                                    <span class="member-count"><i class="fas fa-users"></i> 85 members</span>
                                    <span class="status open">Open</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="view-btn">View Community</button>
                            </div>
                        </div>
                    </div>
                </div>
    </main>
</div>


<!-- <div class="community-grid">
<?php if (empty($communities)): ?>
                    <h1 class="no-communities">No communities found.</h1>
                <?php else: ?>
                    <?php foreach ($communities as $community): ?>
                        <div class="community-card">
                            <div class="card-header">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVFgwzpMs_KaVAW3vHVNuTiZSMU6xm1NkhOg&s" alt="LEM FTI Logo" class="community-logo">
                                <div class="community-info">
                                    <h2><?php echo htmlspecialchars($community['community_name']) ?></h2>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="community-description"><?php echo htmlspecialchars($community['description']) ?></p>
                                <div class="community-stats">
                                    <span class="member-count"><i class="fas fa-users"></i> <?php echo htmlspecialchars($community['member_count']) ?> members</span>
                                    <span class="status open">Open</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="view-btn">View Community</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
 -->




<!-- <div class="communities-grid">
    <?php if (empty($communities)): ?>
        <p class="no-communities">No communities found.</p>
    <?php else: ?>
        <?php foreach ($communities as $community): ?>
            <div class="community-card">
                <div class="community-image">
                    <img src="<?php echo htmlspecialchars($community['profile_image'] ?? 'assets/images/default-community.png'); ?>"
                        alt="<?php echo htmlspecialchars($community['community_name']); ?>"
                        class="community-profile-image">
                </div>
                <div class="community-details">
                    <h3 class="community-name"><?php echo htmlspecialchars($community['community_name']); ?></h3>
                    <p class="community-description"><?php echo htmlspecialchars($community['description']); ?></p>
                    <div class="community-meta">
                        <span class="created-by">Created by: <?php echo htmlspecialchars($community['created_by']); ?></span>
                        <span class="created-at">
                            <?php echo date('M d, Y', strtotime($community['created_at'])); ?>
                        </span>
                    </div>
                    <?php if ($community['requirement_status']): ?>
                        <span class="requirement-badge">Approval Required</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div> -->