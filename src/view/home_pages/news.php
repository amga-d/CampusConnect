<?php require_once __DIR__ . '/../../controllers/home_pages/newsController.php'; ?>


<div class="page-content">
    <main class="app-container">
        <div class="community-header">
            <h1 class="community-title">University News</h1>
            <p class="community-subtitle">Stay informed about the latest developments, events, and stories from our local community</p>
        </div>
        
        <?php if (empty($news)): ?>
            <h1 class="no-news">No news found.</h1>
        <?php else: ?>
            <?php foreach ($news as $newsItem): ?>
        <div id="newsFeed">
            <div class="news-post">
                <div class="post-header">
                    <img src="\public\uploads\news\Logo-UII.webp" alt="UII Logo" class="post-avatar" loading="lazy">
                    <div class="post-info">
                        <strong>Universtas Islam Indonesia</strong><br>
                        <span class="post-date"><?= htmlspecialchars($newsItem['created_at'])?></span>
                    </div>
                    <strong class="elipse">...</strong>
                </div>
                <img src="<?= htmlspecialchars($newsItem['news_image']) ?>" class="post-image news-image" alt="News Image">
                <div class="post-description">
                    <h2 class="post-title"><?= htmlspecialchars($newsItem['news_name'])?></h2>
                    <p class="post-excerpt"><?= htmlspecialchars($newsItem['description'])?></p>
                    <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </main>
</div>