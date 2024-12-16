<?php
require_once __DIR__ . '/../../controllers/home_pages/viewCommunityController.php';
?>

<div class="page-content">
    <main class="main-content">
        <section class="hero" id="about">
            <div class="hero-wrapper">
                <div class="hero-content">
                    <h2 class="hero-title"><?= htmlspecialchars($community['community_name']) ?></h2>
                    <p class="hero-description"><?= htmlspecialchars($community['description']) ?></p>
                    <a href="#" class="cta-button">Join Us</a>
                </div>
                    <img class="hero-image" src="<?= htmlspecialchars($community['profile_image']) ?>" alt="Community Image">
            </div>
        </section>
        
        <section class="description">
            <div class="container">
                <h2 class="section-title">Our Community</h2>
                <p>CampusConnect is a dynamic hub for students, faculty, and staff to collaborate, share ideas, and foster meaningful connections. Our mission is to create an inclusive environment that promotes academic excellence, personal growth, and community engagement.</p>
            </div>
        </section>
        
        <section class="leaders-members" id="members">
            <div class="container">
                <h2 class="section-title">Leaders & Members</h2>
                <div class="card-grid">
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="John Doe">
                        </div>
                        <div class="card-content">
                            <h3>John Doe</h3>
                            <p>Community President</p>
                        </div>
                    </div>
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="Jane Smith">
                        </div>
                        <div class="card-content">
                            <h3>Jane Smith</h3>
                            <p>Events Coordinator</p>
                        </div>
                    </div>
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="Mike Johnson">
                        </div>
                        <div class="card-content">
                            <h3>Mike Johnson</h3>
                            <p>Treasurer</p>
                        </div>
                    </div>
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="Emily Brown">
                        </div>
                        <div class="card-content">
                            <h3>Emily Brown</h3>
                            <p>Member</p>
                        </div>
                    </div>
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="Emily Brown">
                        </div>
                        <div class="card-content">
                            <h3>Emily Brown</h3>
                            <p>Member</p>
                        </div>
                    </div>
                    <div class="card member-card">
                        <div class="card-image">
                            <img src="https://source.unsplash.com/random/300x300/?portrait" alt="Emily Brown">
                        </div>
                        <div class="card-content">
                            <h3>Emily Brown</h3>
                            <p>Member</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
                <h2 class="section-title">Upcoming Events</h2>

                <div class="events-posts">
                <section class="events-content content-section">
                    <div id="newsFeed">
                        <div class="news-post">
                            <div class="post-header">
                                <img src="https://plus.unsplash.com/premium_photo-1664474619075-644dd191935f?fm=jpg&q=60&w=3000&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8aW1hZ2V8ZW58MHx8MHx8fDA%3D" alt="Akram Mohamed" class="post-avatar" loading="lazy">
                                <div class="post-info">
                                    <strong>Akram Mohamed</strong><br>
                                    <span class="post-date">November 30, 2021</span>
                                </div>
                                <strong class="elipse">...</strong>
                            </div>
                            <img src="https://picsum.photos/700/700?random=1" class="post-image" alt="News Image">
                            <div class="post-description">
                                <h2 class="post-title">New Community Center Breaks Ground</h2>
                                <p class="post-excerpt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, sapiente eligendi, officiis recusandae soluta nam fuga placeat dolorum assumenda harum vel saepe alias libero consequatur! Cumque explicabo blanditiis modi tenetur! Our city is taking a significant step forward with the construction of a new community center. This project aims to provide a gathering space for local events, workshops, and community activities. The center will feature multipurpose rooms, a modern library, and spaces for youth programs.</p>
                                <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                            </div>
                        </div>
                        <div class="news-post">
                            <div class="post-header">
                                <img src="https://picsum.photos/700/700?random=2" alt="Post Image" class="post-avatar" loading="lazy">
                                <div class="post-info">
                                    <strong>Jane Doe</strong><br>
                                    <span class="post-date">December 5, 2021</span>
                                </div>
                                <strong class="elipse">...</strong>
                            </div>
                            <img src="https://picsum.photos/700/700?random=2" class="post-image" alt="News Image">
                            <div class="post-description">
                                <h2 class="post-title">Sustainable Urban Green Spaces Initiative</h2>
                                <p class="post-excerpt">Our city is launching an ambitious project to transform unused urban areas into green, sustainable spaces. The initiative will create parks, community gardens, and eco-friendly zones that promote biodiversity, improve air quality, and provide recreational areas for residents.</p>
                                <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                            </div>
                        </div>
                        <div class="news-post">
                            <div class="post-header">
                                <img src="https://picsum.photos/700/700?random=3" alt="Post Image" class="post-avatar" loading="lazy">
                                <div class="post-info">
                                    <strong>John Smith</strong><br>
                                    <span class="post-date">December 10, 2021</span>
                                </div>
                                <strong class="elipse">...</strong>
                            </div>
                            <img src="https://picsum.photos/700/700?random=3" class="post-image" alt="News Image">
                            <div class="post-description">
                                <h2 class="post-title">Local Arts Festival Announces Exciting Lineup</h2>
                                <p class="post-excerpt">The annual community arts festival is set to showcase local talent across various disciplines. From visual arts to performance, musicians to painters, this event celebrates the creative spirit of our community and provides a platform for emerging artists.</p>
                                <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                            </div>
                        </div>
                    </div>
                </section>

                </div>

</main>
</div> 