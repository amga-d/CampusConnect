<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../controllers/home_pages/communityDashboardController.php';
?>

<div class="page-content">

<div class="container">
  <!-- Cover Section -->
  <header class="cover">
    <div class="cover-overlay"></div>
    <div class="header-content">
      <button class="btn leave-btn"><i class="fas fa-sign-out"></i> Leave</button>
    </div>
    <div class="avatar-wrapper">
      <img src="" alt="UII Global Group Avatar" class="avatar" loading="lazy"/>
    </div>
  </header>
  
  <!-- Group Info Section -->
  <div class="group-info-container">
    <div class="group-info">
      <h1 class="group-title">UII GLOBAL</h1>
      <p class="group-desc">
        Connecting global talents in technology, fostering collaboration and innovation across borders.
      </p>
    </div>
  </div>
  
  <!-- Navigation Bar -->
  <nav class="navbar">
    <ul class="nav-menu">
      <li class="nav-item"><a href="#" class="nav-link active" data-target="home-content">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link" data-target="members-content">Members</a></li>
      <li class="nav-item"><a href="#" class="nav-link" data-target="events-content">Events</a></li>
    </ul>
  </nav>
  
  <!-- Main Content Area -->
  <main class="main-content">
    <!-- Original Home Content -->
    <section class="home-content content-section">
      <section class="left-column">
        <!-- Post Input Section -->
        <div class="post-input">
          <img src="" alt="Your Profile" class="user-avatar" loading="lazy">
          <input type="text" placeholder="What would you like to share today?" />
          <button class="btn send-btn" aria-label="Send Post">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
        
        <!-- Example Post -->
        <article class="post">
          <div class="post-header">
            <img src="" alt="Akram Mohamed" class="post-avatar" loading="lazy">
            <div class="post-info">
              <strong>Akram Mohamed</strong><br>
              <span>Admin</span>
              <span class="post-date">November 30, 2021</span>
            </div>
          </div>
          <div class="post-body">
            <p>A vibrant community for CS students to collaborate, learn, and grow together. Join us for coding challenges, workshops, and tech discussions!</p>
          </div>
          <div class="post-actions">
            <button class="btn like-btn" aria-label="Like Post"><i class="fas fa-heart"></i></button>
          </div>
        </article>
        <!-- Additional posts can go here -->
      </section>
      
      <aside class="right-column">
        <h2 class="members-title">Members</h2>
        <ul class="members-list">
          <li class="member-item">
            <div class="member-avatar"><span class="avatar-initial">A</span></div>
            <span class="member-name">Akram Surabi</span>
          </li>
          <li class="member-item">
            <div class="member-avatar"><span class="avatar-initial">B</span></div>
            <span class="member-name">Bin Qannaf</span>
          </li>
          <li class="member-item">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img" loading="lazy">
            <span class="member-name">Amgad Al-Ameri</span>
          </li>
          <!-- Additional members can go here -->
        </ul>
        <a href="#" class="view-all-btn">View All</a>
      </aside>
    </section>
    
    <!-- Members Content (Hidden by default) -->
    <section class="members-content content-section" style="display:none;">
      <div class="members-grid">
        <!-- Example Member Card -->
        <div class="member-card">
          <!-- If no image, show initial with background -->
          <div class="member-avatar-large">
            <span class="avatar-initial">a</span>
          </div>
          <h3 class="member-fullname">akram surabi</h3>
          <div class="member-role">Member</div>
        </div>
        
        <!-- Another Member Card with real image -->
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">
            <img src="" alt="Amgad Al-Ameri" class="member-avatar-img-large" loading="lazy">
          </div>
          <h3 class="member-fullname">AMGAD AL-AMERI</h3>
          <div class="member-role owner">Owner</div>
        </div>
      </div>
    </section>
    
    <!-- Future Events Content (Hidden by default) -->
    <section class="events-content content-section" style="display:none;">
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
  </main>
</div>

<script>
  // JavaScript to switch between sections
const navLinks = document.querySelectorAll('.nav-link');
const contentSections = document.querySelectorAll('.content-section');

navLinks.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();
    // Get the target content
    const target = link.getAttribute('data-target');
    
    // Remove 'active' class from all nav links
    navLinks.forEach(nav => nav.classList.remove('active'));
    link.classList.add('active');
    
    // Hide all content sections
    contentSections.forEach(section => section.style.display = 'none');
    
    // Show the target content section
    const targetSection = document.querySelector(`.${target}`);
    if(targetSection) {
      // Use block to maintain consistent layout
      targetSection.style.display = 'block';
    }
  });
});
  
  // Like button toggle functionality
  document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', () => {
      button.classList.toggle('liked');
    });
  });

  function toggleReadMore(element) {
    const excerpt = element.previousElementSibling;
    const isCollapsed = excerpt.style.webkitLineClamp === "3" || !excerpt.style.webkitLineClamp;

    if (isCollapsed) {
        excerpt.style.display = "block";
        excerpt.style.webkitLineClamp = "unset";
        element.textContent = "Read less";
    } else {
        excerpt.style.webkitLineClamp = "3";
        excerpt.style.display = "-webkit-box";
        element.textContent = "Read more";
    }
}
</script>

</div>