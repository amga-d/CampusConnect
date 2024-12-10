// Function to handle image preview
function setupImagePreview() {
    const profileImageInput = document.getElementById('profileImage');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.querySelector('.image-preview-container');

    if (profileImageInput && imagePreview && imagePreviewContainer) {
        // Handle click on the preview container
        imagePreviewContainer.addEventListener('click', function(e) {
            profileImageInput.click();
        });

        // Handle file selection
        profileImageInput.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
}

// Function to handle form submission
function setupFormSubmission() {
    const createCommunityForm = document.getElementById('createCommunityForm');
    
    if (createCommunityForm) {
        createCommunityForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch("/src/controllers/home_pages/createCommunity.php", {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.headers.get('Content-Type')?.includes('application/json')) {
                    throw new Error('Invalid response format');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Redirect to the new community page
                    window.location.hash = `#community/${data.community_id}`;
                } else {
                    alert(data.message || 'Failed to create community');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while creating the community');
            });
        });
    }
}

// Initialize all functionality
function initNewCommunity() {
    setupImagePreview();
    setupFormSubmission();
}

// Run initialization when the script loads
initNewCommunity();

// Also run initialization when the DOM content loads (for cases where the script loads before the DOM)
document.addEventListener('DOMContentLoaded', initNewCommunity); 