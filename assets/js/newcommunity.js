document.addEventListener('DOMContentLoaded', function() {
    const profileImageInput = document.getElementById('profileImage');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const createCommunityForm = document.getElementById('createCommunityForm');

    // Check if elements are found
    if (!profileImageInput || !imagePreview || !imagePreviewContainer || !createCommunityForm) {
        console.error('One or more elements not found');
        return;
    }

    // Handle image preview container click
    imagePreviewContainer.addEventListener('click', function() {
        profileImageInput.click();
    });

    // Handle image preview
    profileImageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    // Handle form submission
    createCommunityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Creating...';
        submitButton.disabled = true;
        
        fetch('/src/controllers/home_pages/createCommunityController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Community created successfully!');
                window.location.hash = `#community/${data.community_id}`;
            } else {
                alert(data.message || 'Failed to create community');
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the community');
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
    });
}); 