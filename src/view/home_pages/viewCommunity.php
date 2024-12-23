<?php
require_once __DIR__ . '/../../controllers/home_pages/viewCommunityController.php';
// print_r($communityData['event']);
// echo  htmlspecialchars($communityData['info']['community_id']);



?>

<div class="page-content">
    <main class="main-content">
        <section class="hero" id="about">
            <div class="hero-wrapper">
                <div class="hero-content">
                    <h2 class="hero-title"><?= htmlspecialchars($communityData['info']['community_name']) ?></h2>
                    <?php if ($communityData['info']['recruitment_status'] == "open"): ?>
                        <form id=joinCommunityForm method="POST">
                            <input type="hidden" name="community_id" value="<?= htmlspecialchars($communityData['info']['community_id']) ?>">
                            <input type="hidden" name="user_id" value="<?= htmlspecialchars(($user_id)) ?>">
                            <button type="submit" class="cta-button">Join Us</button>
                        </form>
                    <?php endif; ?>
                </div>
                <img class="hero-image" src="<?= htmlspecialchars($communityData['info']['profile_image']) ?>" alt="Community Image">
            </div>
        </section>

        <section class="description">
            <div class="container">
                <h2 class="section-title">Our Community</h2>
                <p class="hero-description"><?= htmlspecialchars($communityData['info']['description']) ?></p>
            </div>
        </section>

        <section class="leaders-members" id="members">
            <div class="container">
                <h2 class="section-title">Leaders & Members</h2>
                <div class="card-grid">
                    <?php foreach ($communityData['member'] as $member): ?>
                        <div class="card member-card">
                            <div class="card-image">
                                <img src="<?= $member['profile_image'] ?>" alt="<?= $member['name'] ?>">
                            </div>
                            <div class="card-content">
                                <h3><?= $member['name'] ?></h3>
                                <p><?= $member['membership'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        
                <h2 class="section-title">Upcoming Events</h2>


        <div class="events-posts">
            <section class="events-content content-section">
                <?php if ($communityData['event'] == null): ?>
                    <h3 class="no-events">Stay tuned! Our first event is comming soon<i class="fas fa-calendar-times calendar-icon"></i></h3>
                    <?php else: ?>
                        <div id="newsFeed">
                            <?php foreach ($communityData['event'] as $event):?>
                            <div class="news-post">
                                <div class="post-header">
                                    <img src="<?= $event['profile_image']?>" alt="<?= $event['name']?>" class="post-avatar" loading="lazy">
                                <div class="post-info">
                                    <strong><?= $event['name']?></strong><br>
                                    <span class="post-date"><?= $event['created_at']?></span>
                                </div>
                                <strong class="elipse">...</strong>
                            </div>
                            <img src="<?= $event['image_path']?>" class="post-image" alt="News Image">
                            <div class="post-description">
                                <h2 class="post-title"><?= $event['event_name']?></h2>
                                <p class="post-excerpt"><?= $event['description']?></p>
                                <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                            </div>
                        </div>
                        <?php endforeach?>           
                    </div> 
                    <?php endif ?>
                </section>
        </div>
        
    </main>
</div>