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
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');

    function createPopup(imageSrc) {
        console.log('Creating popup for:', imageSrc);
        const popup = document.createElement('div');
        popup.className = 'image-popup';
        popup.innerHTML = `
            <div class="popup-content">
                <img src="${imageSrc}" alt="Popup Image">
                <button class="close-popup">&times;</button>
            </div>
        `;
        document.body.appendChild(popup);
        
        
        popup.querySelector('.close-popup').addEventListener('click', function() {
            e.stopPropagation();
            console.log('Closing popup');
            document.body.removeChild(popup);
        });

        popup.addEventListener('click', function(e) {
            if (e.target === popup) {
                console.log('Closing popup (outside click)');
                document.body.removeChild(popup);
            }
        });
    }

    function handleImageClick(e) {
        e.preventDefault();
        console.log('Image clicked:', this.src);
        createPopup(this.src);
    }

    function attachImageListeners() {
        const newsImages = document.querySelectorAll('.post-image.news-image');
        console.log('Found', newsImages.length, 'images');

        newsImages.forEach(function(img) {
            img.addEventListener('click', handleImageClick);
            console.log('Attached listener to:', img.src);
        });
    }

    // Attempt to attach listeners immediately
    attachImageListeners();

    // Also attempt to attach listeners after a short delay
    setTimeout(attachImageListeners, 1000);

    // If you're using a framework that might render content dynamically, you might want to 
    // call attachImageListeners() after the content has been updated
});

// Fallback: attach listeners to any clicks on the document
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('news-image')) {
        console.log('Image clicked via document listener:', e.target.src);
        createPopup(e.target.src);
    }
});