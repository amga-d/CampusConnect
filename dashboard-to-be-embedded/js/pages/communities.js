export function renderCommunities(container) {
  container.innerHTML = `
    <div class="page-header">
      <h1>My Communities</h1>
      <div class="view-controls">
        <button class="button">Grid View</button>
        <button class="button">List View</button>
      </div>
    </div>
    
    <div class="communities-grid grid">
      <div class="community-card card">
        <div class="community-header">
          <img src="/assets/tech-community.svg" alt="Tech Community" class="community-image">
          <div class="community-stats">
            <span>👥 1.2k members</span>
            <span>📢 5 new posts</span>
          </div>
        </div>
        <h3>Tech Enthusiasts</h3>
        <p>Your go-to place for all things tech</p>
        <div class="community-actions">
          <button class="button">View Community</button>
        </div>
      </div>
      
      <div class="community-card card">
        <div class="community-header">
          <img src="/assets/hiking-community.svg" alt="Hiking Community" class="community-image">
          <div class="community-stats">
            <span>👥 856 members</span>
            <span>📢 3 new posts</span>
          </div>
        </div>
        <h3>Hiking Group</h3>
        <p>Explore nature with fellow adventurers</p>
        <div class="community-actions">
          <button class="button">View Community</button>
        </div>
      </div>
    </div>
  `;
}