
document.addEventListener("DOMContentLoaded", function () {
    const newsItems = document.querySelectorAll(".news-item.expandable");

    newsItems.forEach(function(item) {
        const newsArticle = item.querySelector(".news-article");
        const newsImage = item.querySelector(".news-image img");
        const expandButton = item.querySelector(".expand-overlay-button");

        // Function to set line clamp based on image height
        function setLineClamp() {
            if (newsImage.complete) {
                const imageHeight = newsImage.clientHeight;
                const lineHeight = parseFloat(getComputedStyle(newsArticle).lineHeight);
                const availableTextHeight = imageHeight - 200;
                const lineClampValue = Math.max(1, Math.floor(availableTextHeight / lineHeight));
                
                newsArticle.style.setProperty('-webkit-line-clamp', String(lineClampValue));
            }
        }

        // Set initial line clamp when image loads
        newsImage.addEventListener('load', setLineClamp);
        setLineClamp();
        window.addEventListener('resize', setLineClamp);

        // Handle expand/collapse with overlay button
        expandButton.addEventListener("click", function(event) {
            event.stopPropagation();
            const isCollapsed = newsArticle.classList.contains("collapsed-text");
            
            if (isCollapsed) {
                newsArticle.classList.remove("collapsed-text");
                newsArticle.classList.add("expanded-text");
                expandButton.textContent = "Click to collapse";
            } else {
                newsArticle.classList.add("collapsed-text");
                newsArticle.classList.remove("expanded-text");
                expandButton.textContent = "Click to expand";
            }
        });

        // Image modal functionality
        newsImage.addEventListener("click", function (event) {
            event.stopPropagation();
            const modal = document.getElementById("imageModal");
            const modalImg = document.getElementById("fullImage");
            modal.style.display = "block";
            modalImg.src = newsImage.src;
        });
    });

    // Modal click handler
    const modal = document.getElementById("imageModal");
    modal.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    }
});
