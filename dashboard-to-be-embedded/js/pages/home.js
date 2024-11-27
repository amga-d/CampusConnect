import { fadeInUp, staggerChildren } from '../utils/animations.js';
import { createActivityChart } from '../utils/charts.js';

export function renderHome(container) {
  container.innerHTML = `
    <div class="page-header">
      <div class="welcome-section">
        <h1>Welcome Back, John! 👋</h1>
        <p class="subtitle">Here's what's happening in your communities</p>
      </div>
      <div class="quick-actions">
        <button class="button secondary">
          <span>📊</span> Analytics
        </button>
        <button class="button">
          <span>✨</span> New Post
        </button>
      </div>
    </div>
    
    <div class="stats-grid grid">
      <div class="card stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
          <h3>Active Communities</h3>
          <div class="stat">12</div>
          <div class="stat-change success">
            <span class="badge success">+2</span>
            <span>this week</span>
          </div>
        </div>
      </div>
      
      <div class="card stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-content">
          <h3>Upcoming Events</h3>
          <div class="stat">5</div>
          <div class="stat-change">
            <span class="badge primary">Next in 2 days</span>
          </div>
        </div>
      </div>
      
      <div class="card stat-card">
        <div class="stat-icon">💬</div>
        <div class="stat-content">
          <h3>New Messages</h3>
          <div class="stat">28</div>
          <div class="stat-change warning">
            <span class="badge warning">10 unread</span>
          </div>
        </div>
      </div>
    </div>
    
    <div class="activity-section">
      <div class="card">
        <h2>Community Activity</h2>
        <canvas id="activityChart"></canvas>
      </div>
    </div>
    
    <div class="recent-activity">
      <h2>Recent Activity</h2>
      <div class="activity-list">
        <div class="activity-item card">
          <div class="activity-icon">📢</div>
          <div class="activity-content">
            <div class="activity-header">
              <h4>New Announcement</h4>
              <span class="badge primary">Tech Enthusiasts</span>
            </div>
            <p>Monthly meetup scheduled for next week</p>
            <small>2 hours ago</small>
          </div>
        </div>
        
        <div class="activity-item card">
          <div class="activity-icon">🎉</div>
          <div class="activity-content">
            <div class="activity-header">
              <h4>New Event Created</h4>
              <span class="badge success">Hiking Group</span>
            </div>
            <p>Weekend Trek to Mountain Peak</p>
            <small>5 hours ago</small>
          </div>
        </div>
      </div>
    </div>
  `;

  // Initialize animations
  const header = container.querySelector('.page-header');
  const statsGrid = container.querySelector('.stats-grid');
  const activitySection = container.querySelector('.activity-section');
  
  fadeInUp(header);
  staggerChildren(statsGrid, '.stat-card', 0.1);
  fadeInUp(activitySection, 0.3);
  
  // Initialize activity chart
  const ctx = document.getElementById('activityChart');
  createActivityChart(ctx);
}