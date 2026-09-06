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

<div class="container py-4">
  <div class="card border rounded-4 shadow-sm p-4 p-md-5 mb-4 d-flex flex-column flex-md-row align-items-center gap-4">
    <div class="display-3" aria-hidden="true">🎓</div>
    <div class="text-center text-md-start">
      <div class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-1 mb-2">
        Student Learning Binder
      </div>
      <h1 class="display-6 fw-bold text-body mb-2">Personal Learning Hub & Accommodations</h1>
      <p class="lead text-body-secondary mb-0">
        Your progress, saved voice thoughts, and assistive accessibility profile are safely stored in your browser.
      </p>
    </div>
  </div>

  <div class="row g-4">
    <!-- Left Column: Mastered Lessons & Notes -->
    <div class="col-12 col-lg-8 d-flex flex-column gap-4">
      <!-- Mastered Lessons Section -->
      <section class="card border rounded-4 p-4 shadow-sm" aria-labelledby="mastered-heading">
        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
          <h2 id="mastered-heading" class="h4 fw-bold text-body mb-0">
            <span>🏆</span> Mastered Lessons
          </h2>
          <span id="profile-completed-count" class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 fs-6">0 Completed</span>
        </div>
        <div id="mastered-lessons-list" class="mastered-list py-2">
          <!-- Populated dynamically via JS -->
          <p class="text-body-secondary mb-0">No completed lessons yet. Explore our grades and take your first bite-sized lesson!</p>
        </div>
        <div class="pt-3 border-top mt-3">
          <a href="index.php" class="btn btn-secondary">Explore Curriculum ➔</a>
        </div>
      </section>

      <!-- Saved Notes & Audio Dictation Section -->
      <section class="card border rounded-4 p-4 shadow-sm" aria-labelledby="notes-heading">
        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3">
          <h2 id="notes-heading" class="h4 fw-bold text-body mb-0">
            <span>📝</span> My Saved Notes & Voice Thoughts
          </h2>
          <button id="profile-clear-notes" class="btn btn-sm btn-outline-danger">Clear Notes</button>
        </div>
        <textarea id="profile-notes-area" class="form-control" style="min-height:180px;" placeholder="Your notes from lessons and voice dictation appear here..."></textarea>
        <span class="small text-body-secondary mt-2 d-block">
          💡 You can also dictate notes anytime by clicking the 📝 icon in the top header.
        </span>
      </section>
    </div>

    <!-- Right Column: Accommodations Profile Checklist -->
    <div class="col-12 col-lg-4">
      <section class="card border rounded-4 p-4 shadow-sm" aria-labelledby="accommodations-heading">
        <div class="pb-3 border-bottom mb-3">
          <h2 id="accommodations-heading" class="h4 fw-bold text-body mb-0">
            <span>⚙️</span> Active Accommodations
          </h2>
        </div>
        <p class="small text-body-secondary mb-3">
          Your current neurodiversity and sensory profile:
        </p>

        <ul class="list-group list-group-flush mb-4 rounded-3 border">
          <li class="list-group-item d-flex align-items-center gap-3 py-3 bg-transparent">
            <span class="fs-4">🔤</span>
            <div>
              <strong class="small d-block text-body">Font Choice:</strong>
              <span id="acc-font-name" class="fw-bold text-primary">Lexend</span>
            </div>
          </li>

          <li class="list-group-item d-flex align-items-center gap-3 py-3 bg-transparent">
            <span class="fs-4">🎨</span>
            <div>
              <strong class="small d-block text-body">Visual Theme:</strong>
              <span id="acc-theme-name" class="fw-bold text-primary">Calm Dark</span>
            </div>
          </li>

          <li class="list-group-item d-flex align-items-center gap-3 py-3 bg-transparent">
            <span class="fs-4">📏</span>
            <div>
              <strong class="small d-block text-body">Reading Ruler:</strong>
              <span id="acc-ruler-state" class="small text-body-secondary">Disabled (Press Alt+R)</span>
            </div>
          </li>

          <li class="list-group-item d-flex align-items-center gap-3 py-3 bg-transparent">
            <span class="fs-4">👁️</span>
            <div>
              <strong class="small d-block text-body">Bionic Reading:</strong>
              <span id="acc-bionic-state" class="small text-body-secondary">Disabled</span>
            </div>
          </li>
        </ul>

        <button onclick="document.getElementById('a11y-fab-trigger').click()" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2">
          <span>⚙️</span> <span>Adjust Accommodations (Alt+A)</span>
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
