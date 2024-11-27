import { renderHome } from './pages/home.js';
import { renderEvents } from './pages/events.js';
import { renderDiscover } from './pages/discover.js';
import { renderCommunities } from './pages/communities.js';

const mainContent = document.getElementById('main-content');
const navLinks = document.querySelectorAll('.nav-links li');

// Page rendering map
const pages = {
  home: renderHome,
  events: renderEvents,
  discover: renderDiscover,
  communities: renderCommunities
};

// Navigation handling
function handleNavigation(event) {
  const target = event.currentTarget;
  const page = target.dataset.page;
  
  // Update active state
  navLinks.forEach(link => link.classList.remove('active'));
  target.classList.add('active');
  
  // Render the selected page
  if (pages[page]) {
    pages[page](mainContent);
  }
}

// Add click handlers to navigation items
navLinks.forEach(link => {
  link.addEventListener('click', handleNavigation);
});

// Initialize with home page
renderHome(mainContent);