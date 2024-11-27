export function renderEvents(container) {
  container.innerHTML = `
    <div class="page-header">
      <h1>Events</h1>
      <button class="button">Create Event</button>
    </div>
    
    <div class="events-container">
      <div class="event-card card">
        <div class="event-date">
          <span class="day">15</span>
          <span class="month">MAR</span>
        </div>
        <div class="event-details">
          <h3>Tech Meetup 2024</h3>
          <p>Join us for an evening of networking and tech talks</p>
          <div class="event-meta">
            <span>🕒 6:00 PM</span>
            <span>📍 Tech Hub</span>
            <span>👥 50 attending</span>
          </div>
        </div>
      </div>
      
      <div class="event-card card">
        <div class="event-date">
          <span class="day">20</span>
          <span class="month">MAR</span>
        </div>
        <div class="event-details">
          <h3>Community Hackathon</h3>
          <p>24-hour coding challenge with amazing prizes</p>
          <div class="event-meta">
            <span>🕒 9:00 AM</span>
            <span>📍 Innovation Center</span>
            <span>👥 120 attending</span>
          </div>
        </div>
      </div>
    </div>
  `;
}