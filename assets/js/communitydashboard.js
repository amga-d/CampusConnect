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