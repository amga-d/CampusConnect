<?php
require_once __DIR__ . '/../../controllers/home_pages/communityDashboardController.php';
?>

<div class="page-content">
    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($dashboardData): ?>
        <div class="community-dashboard">
            <!-- Community Header -->
            <div class="dashboard-header">
                <div class="community-banner">
                    <img src="<?= htmlspecialchars($dashboardData['community']['banner_image']) ?>" alt="Community Banner" class="banner-image">
                </div>
                <div class="community-profile">
                    <img src="<?= htmlspecialchars($dashboardData['community']['profile_image']) ?>" alt="Community Logo" class="profile-image">
                    <div class="community-info">
                        <h1><?= htmlspecialchars($dashboardData['community']['name']) ?></h1>
                        <p class="community-description"><?= htmlspecialchars($dashboardData['community']['description']) ?></p>
                    </div>
                    <?php if ($dashboardData['isAdmin']): ?>
                        <button class="edit-community-btn" onclick="openEditModal()">
                            <i class="fas fa-edit"></i> Edit Community
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Main Dashboard Content -->
            <div class="dashboard-content">
                <!-- Left Sidebar - Community Stats and Quick Actions -->
                <div class="dashboard-sidebar">
                    <div class="community-stats">
                        <div class="stat-item">
                            <span class="stat-value"><?= count($dashboardData['members']) ?></span>
                            <span class="stat-label">Members</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value"><?= count($dashboardData['activities']) ?></span>
                            <span class="stat-label">Activities</span>
                        </div>
                    </div>
                    
                    <?php if ($dashboardData['isAdmin']): ?>
                        <div class="admin-actions">
                            <h3>Admin Actions</h3>
                            <button onclick="openMemberManagement()">Manage Members</button>
                            <button onclick="openCommunitySettings()">Community Settings</button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Main Content Area -->
                <div class="dashboard-main">
                    <!-- Recent Activities -->
                    <section class="recent-activities">
                        <h2>Recent Activities</h2>
                        <div class="activity-list">
                            <?php foreach ($dashboardData['activities'] as $activity): ?>
                                <div class="activity-card">
                                    <div class="activity-header">
                                        <img src="<?= htmlspecialchars($activity['author_image']) ?>" alt="Author" class="author-image">
                                        <div class="activity-meta">
                                            <h4><?= htmlspecialchars($activity['author_name']) ?></h4>
                                            <span class="timestamp"><?= htmlspecialchars($activity['created_at']) ?></span>
                                        </div>
                                    </div>
                                    <div class="activity-content">
                                        <?= htmlspecialchars($activity['content']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                </div>

                <!-- Right Sidebar - Members List -->
                <div class="dashboard-sidebar-right">
                    <div class="members-list">
                        <h3>Community Members</h3>
                        <?php foreach ($dashboardData['members'] as $member): ?>
                            <div class="member-item">
                                <img src="<?= htmlspecialchars($member['profile_image']) ?>" alt="Member" class="member-image">
                                <div class="member-info">
                                    <span class="member-name"><?= htmlspecialchars($member['name']) ?></span>
                                    <span class="member-role"><?= htmlspecialchars($member['role']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($dashboardData['isAdmin']): ?>
            <!-- Admin Modals -->
            <div id="editCommunityModal" class="modal">
                <!-- Edit Community Form -->
            </div>

            <div id="memberManagementModal" class="modal">
                <!-- Member Management Form -->
            </div>

            <div id="communitySettingsModal" class="modal">
                <!-- Community Settings Form -->
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<script>
// Admin functionality
function openEditModal() {
    // Implementation for opening edit community modal
}

function openMemberManagement() {
    // Implementation for opening member management modal
}

function openCommunitySettings() {
    // Implementation for opening community settings modal
}

// AJAX functions for admin actions
async function updateCommunityDetails(communityId, data) {
    try {
        const response = await fetch(`/api/community/${communityId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Failed to update community');
        }
    } catch (error) {
        console.error('Error updating community:', error);
        alert('An error occurred while updating the community');
    }
}

async function manageMember(communityId, memberId, action) {
    try {
        const response = await fetch(`/api/community/${communityId}/member/${memberId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ action })
        });
        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || 'Failed to manage member');
        }
    } catch (error) {
        console.error('Error managing member:', error);
        alert('An error occurred while managing the member');
    }
}
</script>

<style>
.community-dashboard {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.dashboard-header {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.community-banner {
    height: 200px;
    overflow: hidden;
    border-radius: 8px 8px 0 0;
}

.banner-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.community-profile {
    display: flex;
    align-items: center;
    padding: 20px;
}

.profile-image {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin-right: 20px;
}

.community-info {
    flex: 1;
}

.dashboard-content {
    display: grid;
    grid-template-columns: 250px 1fr 250px;
    gap: 20px;
}

.dashboard-sidebar, .dashboard-sidebar-right {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.community-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}

.stat-item {
    text-align: center;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
}

.activity-card {
    background: #fff;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.activity-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.author-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.member-item {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.member-image {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
}

.edit-community-btn {
    padding: 8px 16px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.edit-community-btn:hover {
    background: #0056b3;
}

.admin-actions {
    margin-top: 20px;
}

.admin-actions button {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.admin-actions button:hover {
    background: #0056b3;
}
</style>
