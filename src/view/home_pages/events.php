<?php 
require_once(__DIR__."/../../controllers/home_pages/eventsController.php");

?>
<div class="page-content">
<main class="app-container">
        <div class="community-header">
            <h1 class="community-title">Community Events</h1>
            <p class="community-subtitle">Stay informed about the latest developments, events, and stories from our local community</p>
        </div>
        <div id="newsFeed">
            <?php foreach($events as $event):?>
            <div class="news-post">
                <div class="post-header">
                    <img src="<?= $event['profile_image']?>" alt="Post Image" class="post-avatar" loading="lazy">
                    <div class="post-info">
                        <strong><?= $event['community_name']?></strong><br>
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
            <?php endforeach;?>
        </div>
    </main>
</div>