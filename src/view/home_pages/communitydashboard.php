<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../controllers/home_pages/communityDashboardController.php';
require_once __DIR__ . '/../../controllers/home_pages/communityUsers.php';

$role = htmlspecialchars($dashboardData['role']);
// print_r($dashboardData['role']);
// print_r($dashboardData['events'][0]);
// print_r($dashboardData['community']['community_id']);





switch ($role) {

  case "member":
    break;

  case "admin":
    $controller = new communityAdmin();
    $communityId = $_GET['community_id'] ?? null; // Assuming community ID is passed via URL
    $community = $controller->getCommunityDetails($communityId);
    break;

  case "core_member";

    break;

  default;
    echo "unaotherized access";
    exit;
}

?>

<div class="page-content">

  <div class="container">
    <!-- Cover Section -->
    <header class="cover">
      <div class="cover-overlay"></div>
      <?php if ($role != "admin"): ?>
        <button class="btn leave-btn"><i class="fas fa-sign-out"></i> Leave</button>
      <?php endif; ?>
      <div class="header-content">
        <?php if ($role == "admin"): ?>
          <button class="btn invite-btn"><i class="fas fa-user-plus"></i> Invite</button>
          <button class="btn edit-btn" id=""><i class="fas fa-edit"></i> Edit</button>
        <?php endif; ?>
        <!-- <button class="btn invite-btn"><i class="fas fa-user-plus"></i> Invite</button> -->
        <!-- <button class="btn edit-btn" id=""><i class="fas fa-edit"></i> Edit</button> -->
      </div>
      <div class="avatar-wrapper">
        <img src="<?= htmlspecialchars($dashboardData['community']['profile_image']) ?>" alt="community Avatar" class="avatar" loading="lazy" />
      </div>
    </header>

    <!-- Group Info Section -->
    <div class="group-info-container">
      <div class="group-info">
        <h1 class="group-title"><?= htmlspecialchars($dashboardData['community']['community_name']) ?></h1>
        <p class="group-desc">
          <?=
          htmlspecialchars($dashboardData['community']['description'])
          ?>
        </p>
      </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar">
      <ul class="nav-menu">
        <li class="nav-item"><a href="" class="nav-link active" data-target="home-content">Home</a></li>
        <li class="nav-item"><a href="" class="nav-link" data-target="members-content">Members</a></li>
        <li class="nav-item"><a href="" class="nav-link" data-target="events-content">Events</a></li>
      </ul>
    </nav>

    <!-- Leave Confirmation Modal -->
    <form class="leave-modal-overlay" id="leaveModal" method="POST">
      <div class="leave-modal">
        <button type="button" class="modal-close-btn" id="closeLeaveModal">&times;</button>
        <h2>Leave Community</h2>
        <p>Are you sure you want to leave this community?</p>
        <div class="form-actions">
          <input type="hidden" name="role" value="<?php echo $role ?>">
          <input type="hidden" name="action" value="leaveCommunity">
          <input type="hidden" name="community_id" value="<?= $dashboardData['community']['community_id'] ?>">
          <button type="button" class="btn btn-secondary" id="cancelLeave">Cancel</button>
          <button type="submit" class="btn btn-danger" id="confirmLeave">Leave</button>
        </div>
      </div>
    </form>

    <!-- Admin -->
    <?php if ($role == "admin"): ?>
      <!-- Edit Community Modal -->
      <div class="edit-community-container" style="display: none;">
        <div class="edit-community-modal">
          <form id="edit-community-form" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="updateCommunity">
            <input type="hidden" name="role" value=<?= ($role) ?>>
            <input type="hidden" name="community_id" value="<?php echo htmlspecialchars($community['community_id']); ?>">
            <div class="edit-community-sidebar">
              <div class="community-avatar">
                <img src="<?php echo htmlspecialchars($community['profile_image'] ?? '/assets/img/default_community.png'); ?>" alt="Community Image">
              </div>
              <div class="community-image-upload">
                <input type="file" id="community-image" name="community_image" accept="image/*">
                <label for="community-image">
                  <i class="fas fa-upload"></i> Change Image
                </label>
              </div>
            </div>

            <div class="edit-community-main">
              <div class="form-group">
                <label for="community_name">Community Name</label>
                <input type="text" id="community_name" name="community_name"
                  value="<?php echo htmlspecialchars($community['community_name']); ?>" required>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($community['description'] ?? ''); ?></textarea>
              </div>

              <div class="form-group">
                <label for="community_type">Community Type</label>
                <select id="community_type" name="community_type">
                  <option value="academic" <?php echo $community['community_type'] == 'academic' ? 'selected' : ''; ?>>Academic</option>
                  <option value="hobby" <?php echo $community['community_type'] == 'Sports' ? 'selected' : ''; ?>>Sports</option>
                  <option value="professional" <?php echo $community['community_type'] == 'arts' ? 'selected' : ''; ?>>Arts & Culutre</option>
                  <option value="professional" <?php echo $community['community_type'] == 'technology' ? 'selected' : ''; ?>>Technology</option>
                  <option value="professional" <?php echo $community['community_type'] == 'social' ? 'selected' : ''; ?>>Social</option>
                  <option value="professional" <?php echo $community['community_type'] == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
              </div>

              <div class="form-group">
                <label for="community_privacy">Community Privacy</label>
                <select id="community_privacy" name="community_privacy">
                  <option value="public" <?php echo $community['community_privacy'] == 'public' ? 'selected' : ''; ?>>Public</option>
                  <option value="private" <?php echo $community['community_privacy'] == 'private' ? 'selected' : ''; ?>>Private</option>
                </select>
              </div>

              <div class="form-group">
                <label for="recruitment_status">Recruitment Status</label>
                <select id="recruitment_status" name="recruitment_status">
                  <option value="open" <?php echo $community['recruitment_status'] == 'open' ? 'selected' : ''; ?>>Open</option>
                  <option value="closed" <?php echo $community['recruitment_status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
              </div>

              <div class="form-actions">
                <button type="button" class="btn btn-secondary cancel-edit" id="cancel">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Invite Modal -->
      <div class="invite-modal-overlay" id="inviteModal">
        <div class="invite-modal">
          <button class="modal-close-btn" id="closeInviteModal">&times;</button>
          <h2>Invite a New Member</h2>
          <form id="inviteForm" method="POST">
            <div class="form-group">
              <label for="inviteEmail">Email Address</label>
              <!-- 1111 -->

              <input type="hidden" name="community_id" value="<?php echo htmlspecialchars($dashboardData['community']['community_id']);?>">
              <input type="hidden" name="role" value="<?=$role?>">
              <input type="hidden" name="action" value="invite">
              <input type="email" id="inviteEmail" name="inviteEmail" placeholder="Enter email" required>
            </div>
            <div class="form-actions">
              <button type="button" class="btn btn-secondary" id="cancelInvite">Cancel</button>
              <button type="submit" class="btn btn-primary">Invite</button>
            </div>
          </form>
        </div>
      </div>

    <?php endif; ?>
    <!-- Main Content Area -->
    <main class="main-content">
      <!-- Original Home Content -->
      <section class="home-content content-section">
        <section class="left-column">
          <!-- Post Input Section -->
          <?php if ($role == "admin" || $role  == "core_member"): ?>
            <form action="POST" id="post-Announcement">
              <div class="post-input">
                <input type="hidden" name="community_id" value="<?php echo htmlspecialchars($community['community_id']); ?>">
                <input type="hidden" name="action" value="postAnnouncement">
                <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
                <img src="<?= htmlspecialchars($dashboardData['profile']['profile_image']) ?>" alt="Your Profile" class="user-avatar" loading="lazy">
                <input type="text" name="announcementContnet" placeholder="What would you like to share today?" required>
                <button type="submit" class="btn send-btn" aria-label="Send Post">
                  <i class="fas fa-paper-plane"></i>
                </button>
              </div>
            </form>
          <?php endif; ?>

          <?php if ($dashboardData['announcements'] == null): ?>
            <h3 id="noAnnoTag" class="no-announcement">No Announcements<i class="fas fa-bell bell-icon"></i></h3>
          <?php else: ?>
            <?php foreach ($dashboardData['announcements'] as $announcement): ?>
              <article class="post">
                <div class="post-header">
                  <img src="<?= htmlspecialchars($announcement['profile_image']) ?>" alt="Akram Mohamed" class="post-avatar" loading="lazy">
                  <div class="post-info">
                    <strong><?= htmlspecialchars($announcement['name']) ?></strong><br>
                    <span><?= htmlspecialchars($announcement['membership']) ?></span>
                    <span class="post-date"><?= htmlspecialchars($announcement['created_at']) ?></span>
                  </div>
                </div>
                <div class="post-body">
                  <p><?= htmlspecialchars($announcement['content']) ?></p>
                </div>
                <div class="post-actions">
                  <button class="btn like-btn" aria-label="Like Post"><i class="fas fa-heart"></i></button>
                </div>
              </article>
            <?php endforeach; ?>
          <?php endif; ?>
        </section>

        <aside class="right-column">
          <?php $count = 0 ?>

          <h2 class="members-title">Members</h2>
          <ul class="members-list">
            <?php foreach ($dashboardData['members'] as $member): ?>
              <?php if ($count < 3): ?>
                <li class="member-item">
                  <?php if (!$member['profile_image']): ?>
                    <div class="member-avatar"><span class="avatar-initial"><?= htmlspecialchars($member['name'])[0] ?></span></div>
                  <?php else: ?>
                    <img src="<?= htmlspecialchars($member['profile_image']) ?>" alt="Amgad Al-Ameri" class="member-avatar-img" loading="lazy">
                  <?php endif; ?>
                  <span class="member-name"><?= htmlspecialchars($member['name']) ?></span>
                </li>
                <?php $count++; ?>
              <?php endif; ?>
            <?php endforeach; ?>
            <!-- Additional members can go here -->
          </ul>
          <a href="#" class="view-all-btn" id="viewAllBtn">View All</a>
        </aside>
      </section>

      <!-- Members Content (Hidden by default) -->
      <section class="members-content content-section" style="display:none;">
        <div class="members-grid">
          <?php foreach ($dashboardData['members'] as $member): ?>

            <div class="member-card">
              <div class="member-avatar-large">
                <?php if (!$member['profile_image']): ?>
                  <span class="avatar-initial"><?= htmlspecialchars($member['name'])[0] ?></span>
                <?php else: ?>
                  <img src="<?= htmlspecialchars($member['profile_image']) ?>" class="member-avatar-img-large" loading="lazy">
                <?php endif; ?>
              </div>
              <h3 class="member-fullname"><?= htmlspecialchars($member['name']) ?></h3>
              <div class="member-role owner"><?= htmlspecialchars($member['membership']) ?></div>
            </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Future Events Content (Hidden by default) -->
      <section class="events-content content-section" style="display:none;">
        <?php if ($role == "admin" || $role  == "core_member"): ?>
          <div class="event-input">
            <img src="<?= htmlspecialchars($dashboardData['profile']['profile_image']) ?>" alt="Your Profile" class="user-avatar" loading="lazy">
            <input type="text" placeholder="What do have in mind to share?" />
            <button class="btn send-btn" aria-label="Send Post">
              <i class="fas fa-paper-plane"></i>
            </button>
          </div>


          <div class="create-event-container" style="display: none;">
            <div class="create-event-modal">
              <form id="create-event-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="community_id" value="<?php echo htmlspecialchars($community['community_id']); ?>">
                <input type="hidden" name="role" value="<?= $role ?>">
                <input type="hidden" name="action" value="postEvent">
                <div class="event-image-section">
                  <div class="event-image-preview">
                    <img id="event-image-preview" src="/assets/img/default_event. " alt="Event Preview">
                  </div>
                  <div class="event-image-upload">
                    <input type="file" id="event-image" name="event_image" accept="image/*">
                    <label for="event-image">
                      <i class="fas fa-upload"></i> Upload Event Image
                    </label>
                  </div>
                </div>

                <div class="event-details-section">
                  <h2>Create New Event</h2>

                  <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <input type="text" id="event_name" name="event_name" required>
                  </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                  </div>

                  <div class="form-actions">
                    <button type="button" class="btn btn-secondary cancel-event">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <?php endif; ?>

        <div id="newsFeed">
          <?php if ($dashboardData['events'] == null): ?>
            <div class="no-events-container">
            <h2 class="no-events" id="noEventsTag" >Stay tuned! Our first event is comming soon <i class="fas fa-clock"></i></h2>
            </div>
          <?php else: ?>
            <?php foreach ($dashboardData['events'] as $event): ?>
              <div class="news-post">
                <div class="post-header">
                  <img src="<?= $event['profile_image'] ?>" alt="Post Image" class="post-avatar" loading="lazy">
                  <div class="post-info">
                    <strong><?= $event['name'] ?></strong><br>
                    <span class="post-date"><?= $event['created_at'] ?></span>
                  </div>
                  <strong class="elipse">...</strong>
                </div>
                <img src="<?= $event['image_path']?>" class="post-image" alt="News Image">
                <div class="post-description">
                  <h2 class="post-title">
                    <?= $event['event_name'] ?></h2>
                  <p class="post-excerpt"> <?= $event['description']?></p>
                  <span class="read-more" onclick="toggleReadMore(this)">Read more</span>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>
      </section>
    </main>
  </div>
</div>