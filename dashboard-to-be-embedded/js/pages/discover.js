export function renderDiscover(container) {
  container.innerHTML = `
    <div class="page-header">
      <h1>Discover</h1>
      <div class="search-container">
        <input type="search" placeholder="Search communities..." class="search-input">
      </div>
    </div>
    
    <div class="categories-grid grid">
      <div class="category-card card">
        <span class="category-icon">💻</span>
        <h3>Technology</h3>
        <p>142 communities</p>
      </div>
      
      <div class="category-card card">
        <span class="category-icon">🎨</span>
        <h3>Art & Design</h3>
        <p>98 communities</p>
      </div>
      
      <div class="category-card card">
        <span class="category-icon">🎮</span>
        <h3>Gaming</h3>
        <p>215 communities</p>
      </div>
      
      <div class="category-card card">
        <span class="category-icon">📚</span>
        <h3>Education</h3>
        <p>167 communities</p>
      </div>
    </div>
    
    <div class="trending-section">
      <h2>Trending Communities</h2>
      <div class="trending-grid grid">
        <div class="community-card card">
          <img src="/assets/community1.svg" alt="Community" class="community-image">
          <h3>Web Developers United</h3>
          <p>A community for web developers to share knowledge</p>
          <button class="button">Join Community</button>
        </div>
        
        <div class="community-card card">
          <img src="/assets/community2.svg" alt="Community" class="community-image">
          <h3>Digital Artists Hub</h3>
          <p>Share your artwork and get inspired</p>
          <button class="button">Join Community</button>
        </div>
      </div>
    </div>
  `;
}