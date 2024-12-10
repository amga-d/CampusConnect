<div class="page-content">
  <div class="container">
    <!-- Cover Section -->
    <header class="cover">
      <div class="cover-overlay"></div>
      <div class="header-content">
        <button class="btn leave-btn"><i class="fas fa-sign-out"></i> Leave</button>
        <!-- <button class="btn invite-btn"><i class="fas fa-user-plus"></i> Invite</button>
        <button class="btn edit-btn"><i class="fas fa-edit"></i> Edit</button> -->
      </div>
      <!-- Avatar Wrapper Positioned to Overlap -->
      <div class="avatar-wrapper">
        <img src="avatar.png" alt="UII Global Group Avatar" class="avatar" loading="lazy"/>
      </div>
    </header>
    
    <!-- Group Info Section Below Cover -->
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
        <li class="nav-item"><a href="#" class="nav-link active">Home</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Events</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Members</a></li>
      </ul>
    </nav>
    
    <!-- Main Content Area -->
    <main class="main-content">
      <section class="left-column">
        <!-- Post Input Section -->
        <div class="post-input">
          <img src="profile-user.jpg" alt="Your Profile" class="user-avatar" loading="lazy">
          <input type="text" placeholder="What would you like to share today?" />
          <button class="btn send-btn" aria-label="Send Post">
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
        
        <!-- Example Post -->
        <article class="post">
          <div class="post-header">
            <img src="profile-akram.jpg" alt="Akram Mohamed" class="post-avatar" loading="lazy">
            <div class="post-info">
              <strong>Akram Mohamed</strong><br>
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
        
        <!-- Additional posts can be added here -->
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
            <img src="profile-amgad.jpg" alt="Amgad Al-Ameri" class="member-avatar-img" loading="lazy">
            <span class="member-name">Amgad Al-Ameri</span>
          </li>
          <!-- Additional members can be added here -->
        </ul>
        <a href="#" class="view-all-btn">View All</a>
      </aside>
    </main>
  </div>
  
  <!-- Optional JavaScript for Like Button Functionality -->
  <script>
    document.querySelectorAll('.like-btn').forEach(button => {
      button.addEventListener('click', () => {
        button.classList.toggle('liked');
      });
    });
  </script>
</div>