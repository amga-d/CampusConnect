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
                
                <div class="hero-images">
                    <div class="image-grid">
                        <div class="image-item">
                            <img class="hero-image" src="<?= htmlspecialchars($community['profile_image']) ?>" alt="Community Image">
                        </div>
                    </div>
                </div>
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
        
        <section class="events" id="events">
            <div class="container">
                <h2 class="section-title">Upcoming Events</h2>
                <div class="card-grid">
                <div class="card event-card">
                    <div class="event-date">
                        <div class="event-date-container">
                            <div class="event-date-icon">
                                <span class="day">15</span>
                                <span class="month">SEP</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div>
                            <h3>Welcome Mixer</h3>
                            <p>Join us for an exciting evening of networking and fun!</p>
                        </div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Student Center</span>
                        </div>
                    </div>
                </div>
                <div class="card event-card">
                    <div class="event-date">
                        <div class="event-date-container">
                            <div class="event-date-icon">
                                <span class="day">15</span>
                                <span class="month">SEP</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div>
                            <h3>Welcome Mixer</h3>
                            <p>Join us for an exciting evening of networking and fun!</p>
                        </div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Student Center</span>
                        </div>
                    </div>
                </div>
                <div class="card event-card">
                    <div class="event-date">
                        <div class="event-date-container">
                            <div class="event-date-icon">
                                <span class="day">15</span>
                                <span class="month">SEP</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div>
                            <h3>Welcome Mixer</h3>
                            <p>Join us for an exciting evening of networking and fun!</p>
                        </div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Student Center</span>
                        </div>
                    </div>
                </div>
                <div class="card event-card">
                    <div class="event-date">
                        <div class="event-date-container">
                            <div class="event-date-icon">
                                <span class="day">15</span>
                                <span class="month">SEP</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div>
                            <h3>Welcome Mixer</h3>
                            <p>Join us for an exciting evening of networking and fun!</p>
                        </div>
                        <div class="event-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Student Center</span>
                        </div>
                    </div>
                </div>           
            </div>
        </div>
    </section>
</main>
</div> 