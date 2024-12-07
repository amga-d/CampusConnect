<?php
require_once (__DIR__."/../../controllers/home_pages/profileController.php")
?>
<div class="page-content">
    <div class="container">
        <div class="profile-card">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <img src="<?php echo isset($user['profile_image']) ? htmlspecialchars($user['profile_image']) : '/assets/images/default-avatar.png'; ?>" alt="Profile Picture">
                </div>
                <div class="profile-sidebar-content">
                    <h1 class="name"><?php echo htmlspecialchars($user['name'] ?? 'No Name'); ?></h1>
                    <p class="profile-title">Student</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>

            <div class="profile-main-content">
                <div class="profile-navigation">
                    <a href="#" class="nav-button" id="editProfileBtn">
                        <i class="fas fa-edit"></i>
                        <span>Edit Profile</span>
                    </a>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <i class="info-icon fas fa-envelope"></i>
                        <div class="info-text">
                            <p class="info-label">Email</p>
                            <p><?php echo htmlspecialchars($user['email'] ?? 'No email'); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-male"></i>
                        <div class="info-text">
                            <p class="info-label">Gender</p>
                            <p><?php echo htmlspecialchars($user['gender'] ?? 'Not specified'); ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-birthday-cake"></i>
                        <div class="info-text">
                            <p class="info-label">Birthday</p>
                            <p><?php echo isset($user['birthdate']) ? date('Y/m/d', strtotime($user['birthdate'])) : 'Not set'; ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="info-icon fas fa-calendar-alt"></i>
                        <div class="info-text">
                            <p class="info-label">Joined CampusConnect</p>
                            <p><?php echo isset($user['created_at']) ? date('F Y', strtotime($user['created_at'])) : 'Unknown'; ?></p>
                        </div>
                    </div>
                </div>

                <section class="bio-section">
                    <h2 class="bio-title">About Me</h2>
                    <p><?php echo htmlspecialchars($user['bio'] ?? 'No bio yet.'); ?></p>
                </section>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="edit-profile-overlay" class="edit-profile-overlay">
        <div class="edit-profile-modal">
            <span class="modal-close">&times;</span>
            <form class="edit-form" method="POST" action="/update-profile" enctype="multipart/form-data">
            <form class="edit-form">
                <div class="edit-form-sidebar">
                    <div class="profile-avatar">
                        <img src="<?php echo $userProfile['profile_image'] ?? '/api/placeholder/250/250'; ?>" alt="Profile Picture">
                    </div>
                    <div class="profile-image-upload">
                        <input type="file" id="profile-image" name="profile_image" accept="image/*">
                        <label for="profile-image">
                            <i class="fas fa-upload"></i> Change Picture
                        </label>
                    </div>
                </div>
                <div class="edit-form-main">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userProfile['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="Male" <?php echo $userProfile['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $userProfile['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Birthday</label>
                        <input type="date" id="birthday" name="birthday" value="<?php echo $userProfile['birthdate']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="bio">About Me</label>
                        <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($userProfile['bio'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/assets/js/profile.js"></script>
    <script class="dynamic-script"></script>

  </body>
</div>