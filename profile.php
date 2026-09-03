<?php
/**
 * Hestens Learning - Student Learning Binder & Accommodations Profile (profile.php)
 */
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'My Learning Binder & Profile | Hestens Learning';
$pageDescription = 'Track your mastered lessons, voice notes, and customize your personal learning accommodations.';
$activePage = 'profile';

include __DIR__ . '/includes/header.php';
?>

<div class="profile-container">
  <div class="profile-header-banner">
    <div class="profile-avatar">🎓</div>
    <div class="profile-header-text">
      <span class="hero-badge">Student Learning Binder</span>
      <h1 class="profile-title">Personal Learning Hub & Accommodations</h1>
      <p style="color:var(--text-secondary); margin-top:0.25rem;">
        Your progress, saved voice thoughts, and assistive accessibility profile are safely stored in your browser.
      </p>
    </div>
  </div>

  <div class="profile-grid">
    <!-- Left Column: Mastered Lessons & Notes -->
    <div class="profile-col-main">
      <!-- Mastered Lessons Section -->
      <section class="binder-card" aria-labelledby="mastered-heading">
        <div class="binder-card-header">
          <h2 id="mastered-heading" class="binder-card-title">
            <span>🏆</span> Mastered Lessons
          </h2>
          <span id="profile-completed-count" class="card-pill">0 Completed</span>
        </div>
        <div id="mastered-lessons-list" class="mastered-list">
          <!-- Populated dynamically via JS -->
          <p class="text-muted" style="padding:1rem 0;">No completed lessons yet. Explore our grades and take your first bite-sized lesson!</p>
        </div>
        <a href="index.php" class="btn btn-secondary" style="margin-top:1rem;">Explore Curriculum ➔</a>
      </section>

      <!-- Saved Notes & Audio Dictation Section -->
      <section class="binder-card" aria-labelledby="notes-heading">
        <div class="binder-card-header">
          <h2 id="notes-heading" class="binder-card-title">
            <span>📝</span> My Saved Notes & Voice Thoughts
          </h2>
          <button id="profile-clear-notes" class="btn btn-secondary" style="font-size:0.8rem; padding:0.3rem 0.7rem;">Clear Notes</button>
        </div>
        <textarea id="profile-notes-area" class="notes-textarea" style="min-height:180px;" placeholder="Your notes from lessons and voice dictation appear here..."></textarea>
        <span style="font-size:0.8rem; color:var(--text-muted); margin-top:0.5rem; display:block;">
          💡 You can also dictate notes anytime by clicking the 📝 icon in the top header.
        </span>
      </section>
    </div>

    <!-- Right Column: Accommodations Profile Checklist -->
    <div class="profile-col-side">
      <section class="binder-card" aria-labelledby="accommodations-heading">
        <div class="binder-card-header">
          <h2 id="accommodations-heading" class="binder-card-title">
            <span>⚙️</span> Active Accommodations
          </h2>
        </div>
        <p style="font-size:0.9rem; color:var(--text-secondary); margin-bottom:1rem;">
          Your current neurodiversity and sensory profile:
        </p>

        <div class="accommodation-status-list">
          <div class="acc-status-item">
            <span class="acc-icon">🔤</span>
            <div>
              <strong>Font Choice:</strong>
              <div id="acc-font-name" style="font-size:0.85rem; color:var(--accent-primary);">Lexend</div>
            </div>
          </div>

          <div class="acc-status-item">
            <span class="acc-icon">🎨</span>
            <div>
              <strong>Visual Theme:</strong>
              <div id="acc-theme-name" style="font-size:0.85rem; color:var(--accent-primary);">Calm Dark</div>
            </div>
          </div>

          <div class="acc-status-item">
            <span class="acc-icon">📏</span>
            <div>
              <strong>Reading Ruler:</strong>
              <div id="acc-ruler-state" style="font-size:0.85rem; color:var(--text-muted);">Disabled (Press Alt+R)</div>
            </div>
          </div>

          <div class="acc-status-item">
            <span class="acc-icon">👁️</span>
            <div>
              <strong>Bionic Reading:</strong>
              <div id="acc-bionic-state" style="font-size:0.85rem; color:var(--text-muted);">Disabled</div>
            </div>
          </div>
        </div>

        <button onclick="document.getElementById('a11y-fab-trigger').click()" class="btn btn-primary" style="width:100%; margin-top:1.25rem;">
          <span>⚙️</span> Adjust Accommodations (Alt+A)
        </button>
      </section>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Load notes
    const textarea = document.getElementById('profile-notes-area');
    if (textarea) {
      textarea.value = localStorage.getItem('hestens_student_notes') || '';
      textarea.addEventListener('input', () => {
        localStorage.setItem('hestens_student_notes', textarea.value);
      });
    }

    document.getElementById('profile-clear-notes')?.addEventListener('click', () => {
      if (confirm('Clear all saved notes?')) {
        localStorage.removeItem('hestens_student_notes');
        if (textarea) textarea.value = '';
      }
    });

    // Update accommodation statuses
    if (window.hestensApp?.a11y) {
      const prefs = window.hestensApp.a11y.prefs;
      document.getElementById('acc-font-name').textContent = prefs.fontFamily.toUpperCase();
      document.getElementById('acc-theme-name').textContent = prefs.theme.toUpperCase();
      document.getElementById('acc-ruler-state').textContent = prefs.readingRuler ? 'Active (Alt+R)' : 'Disabled (Alt+R)';
      document.getElementById('acc-bionic-state').textContent = prefs.bionicReading ? 'Active' : 'Disabled';
    }

    // Load completed lessons
    const completed = JSON.parse(localStorage.getItem('hestens_completed_lessons') || '[]');
    const countBadge = document.getElementById('profile-completed-count');
    const list = document.getElementById('mastered-lessons-list');
    
    if (countBadge) countBadge.textContent = `${completed.length} Completed`;

    if (completed.length > 0 && list) {
      list.innerHTML = completed.map(id => `
        <div class="mastered-item">
          <span>🌟 <strong>Lesson ID:</strong> ${id}</span>
          <span class="card-pill" style="background:var(--success-bg); color:var(--success-color);">✓ Mastered</span>
        </div>
      `).join('');
    }
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
