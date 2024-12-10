<?php
require_once __DIR__ . '/../../controllers/home_pages/myCommunitiesController.php';

?>

<div class="page-content">
        <?php if (empty($myCommunities)): ?>
            <div class="no-communities-container">
                <div class="no-container">
                    <div class="no-communities-card">
                        <div class="icon-container">
                            <svg class="icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17 21V19C17 16.7909 15.2091 15 13 15H5C2.79086 15 1 16.7909 1 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M23 21V19C22.9986 17.1771 21.765 15.5857 20 15.13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M16 3.13C17.7699 3.58317 19.0078 5.17799 19.0078 7.005C19.0078 8.83201 17.7699 10.4268 16 10.88" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h1>You are not part of any community</h1>
                        <p>Join and discover exciting communities or create your own to connect with like-minded individuals!</p>
                        <div class="button-container">
                            <button class="button primary" onclick="window.location.hash = '#discover'">Discover Communities</button>
                            <button class="button secondary" onclick="window.location.hash = '#newcommunity'">Create New Community</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="community-grid">
                <?php foreach ($myCommunities as $community): ?>
                    <div class="community-card">
                        <div class="card-header">
                            <img src="<?= htmlspecialchars($community['profile_image']) ?>" alt="Community Logo" class="community-logo">
                            <div class="community-info">
                                <h2><?= htmlspecialchars($community['community_name']) ?></h2>
                                <p class="community-type"><?= htmlspecialchars($community['community_type']) ?></p>

                            </div>
                        </div>
                        <div class="card-body">
                            <p class="community-description"><?= htmlspecialchars($community['description']) ?></p>
                            <div class="community-stats">
                                <span class="member-count"><i class="fas fa-users"></i> <?= htmlspecialchars($community['member_count']) ?> members</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="role"><?= htmlspecialchars($community['membership'])?></p>
                            <button class="open-btn">Open Dashboard</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>
</div>
</div>
<!-- <div class="community-grid">
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
                            </div> -->
</div>
</div>
</div>
</main>
</div>