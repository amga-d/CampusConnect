<?php
    include("../controllers/functions.php");
    session_start();

    if(check_login_without_redirecting()){
        header("Location: ../../index.php") ;
        die();
    }

?>



<html lang="en">
<head>
<?php include(__DIR__."/component/header.php");?>
    <title>CampusConnect - Discover Your Community</title>
    <link rel="stylesheet" href="/assets/styles/landingpage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <nav class=" nav-header " >
            <div class="logo">
                <img class="logo1" src="/assets/img/landing/logo_image.png" alt="CampusConnect Logo">
                <img class="logo2" src="/assets/img/landing/logo_name.png" alt="CampusConnect">
            </div>
            <div class="nav-links">
                <!-- <a href="#about" class="about">About</a> -->
                <a href="/src/view/auth/signup.php" class="nav-sign">Sign Up</a>
                <a href="/src/view/auth/signin.php" class="nav-log"> Login </a>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="container hero-content">
                <div class="hero-text">
                    <h1>Discover Your Campus Community</h1>
                    <p>Connect with organizations, stay informed, and make the most of your university experience.</p>
                    <a href="../user_service/auth/signup.php" class="cta-button">Get Started</a>
                </div>
                <div class="hero-image">
                    <img src="/assets/img/landing/hero.jpeg" alt="Campus life">
                </div>
            </div>
        </section>

        <section id="features" class="features">
            <div class="container">
                <h2>What Campus Connect Offers</h2>
                <div class="feature-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📱</div>
                        <h3>Easy Communication</h3>
                        <p>Connect with peers and community members effortlessly.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📅</div>
                        <h3>Event Management</h3>
                        <p>Create, promote, and manage campus events with ease.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🔍</div>
                        <h3>Community Discovery</h3>
                        <p>Find and join communities that match your interests.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h3>Efficient Management</h3>
                        <p>Streamline organization tasks, events, and member management with powerful tools.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimonials" class="testimonials">
            <div class="container">
                <h2>What Our Users Say</h2>
                <div class="testimonial-grid">
                    <div class="testimonial-card">
                        <p>"Campus Connect has revolutionized how I engage with university life!"</p>
                        <cite>- Sarah, Computer Science Student</cite>
                    </div>
                    <div class="testimonial-card">
                        <p>"Managing our club has never been easier. Highly recommended!"</p>
                        <cite>- John, Club President</cite>
                    </div>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <span class="stat-number">5,000+</span>
                        <span class="stat-label">Students Connected</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">200+</span>
                        <span class="stat-label">Active Communities</span>
                    </div>
                </div>
            </div>
        </section>

        <section id="cta" class="cta">
            <div class="container">
                <h2>Ready to Enhance Your Campus Experience?</h2>
                <a href="../user_service/auth/signup.php" class="cta-button">Join Campus Connect Today</a>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-background"></div>
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <img class="logo1" src="/assets/img/landing/logo_image.png" alt="CampusConnect Logo">
                        <img class="logo2" src="/assets/img/landing/logo_name.png" alt="CampusConnect">
                    </div>
                    <p class="footer-tagline">Empowering student connections</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#testimonials">Testimonials</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#blog">Blog</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#support">Support</a></li>
                        <li><a href="#privacy">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="footer-contact">
                    <h3>Contact Us</h3>
                    <p><i class="fas fa-envelope"></i> info@campusconnect.com</p>
                    <p><i class="fas fa-phone"></i> +62 8888888888</p>
                    <p><i class="fas fa-map-marker-alt"></i> 123 University Islam Indonesia</p>
                    <a href="#contact" class="footer-button">Get in Touch</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p>&copy; 2024 CampusConnect. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <div class="custom-cursor"></div>
    <div class="custom-cursor-dot"></div>

    <script src="/assets/js/cursor.js"></script>
</body>
</html>


