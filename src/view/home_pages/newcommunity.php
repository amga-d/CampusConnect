<div class="page-content">
    <div class="create-community-container">
        <header class="page-header">
            <h1>Create New Community</h1>
            <p>Start your own community and connect with others</p>
        </header>

        <form id="createCommunityForm" class="community-form" method="POST" enctype="multipart/form-data">
            <div class="form-section">
                <h2>Basic Information</h2>

                <div class="form-group">
                    <label for="communityName">Community Name*</label>
                    <input type="text" id="communityName" name="community_name" required
                        placeholder="Enter community name">
                </div>

                <div class="form-group">
                    <label for="communityType">Community Type*</label>
                    <select id="communityType" name="community_type" required>
                        <option value="">Select community type</option>
                        <option value="academic">Academic</option>
                        <option value="sports">Sports</option>
                        <option value="arts">Arts & Culture</option>
                        <option value="technology">Technology</option>
                        <option value="social">Social</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description*</label>
                    <textarea id="description" name="description" required
                        placeholder="Describe your community..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h2>Community Image</h2>

                <div class="form-group image-upload">
                    <label for="profileImage">Profile Image</label>
                    <div class="image-preview-container">
                        <img id="imagePreview" src="\assets\img\communities\default_community.jpeg" alt="Preview">
                        <div class="upload-overlay">
                            <i class="fas fa-camera"></i>
                            <span>Upload Image</span>
                        </div>
                    </div>
                    <input type="file" id="profileImage" name="profile_image"
                        accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="form-section">
                <h2>Additional Settings</h2>

                <div class="form-group">
                    <label for="recruitmentStatus">Recruitment Status</label>
                    <select id="recruitmentStatus" name="recruitment_status">
                        <option value="open">Open</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Privacy Settings</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="privacy" value="public" checked>
                            <span>Public</span>
                            <small>Anyone can see and join your community</small>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="privacy" value="private">
                            <span>Private</span>
                            <small>Members must be approved to join</small>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="history.back()">Cancel</button>
                <button type="submit" class="btn-primary">Create Community</button>
            </div>
        </form>
    </div>
</div>