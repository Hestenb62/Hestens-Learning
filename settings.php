<?php
/**
 * Hestens Learning - Site Settings & Storage Management (settings.php)
 */
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'Settings & Preferences | Hestens Learning';
$pageDescription = 'Manage your sensory preferences, cookie storage, and saved learning progress.';
$activePage = 'settings';

include __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
  <div class="pb-3 border-bottom mb-4">
    <h1 class="h2 fw-bold text-body mb-1">⚙️ Site Settings & Data Storage</h1>
    <p class="text-body-secondary mb-0">
      Customize how your preferences and lesson progress are stored.
    </p>
  </div>

  <div class="row g-4">
    <!-- Storage & Privacy Card -->
    <div class="col-12 col-md-6">
      <section class="card border rounded-4 p-4 h-100 shadow-sm">
        <h2 class="h4 fw-bold text-body mb-3">
          🔒 Localhost & Cookie Storage
        </h2>
        <p class="text-body-secondary mb-4 lh-base">
          Hestens Learning stores your accessibility preferences (font choice, visual tints, line spacing) and completed lessons locally in your browser (Cookies & LocalStorage) for instant zero-latency loading.
        </p>

        <div class="d-flex flex-column gap-2 mt-auto">
          <button id="clear-progress-btn" class="btn btn-outline-warning text-start d-flex align-items-center gap-2">
            <span>🗑️</span> <span>Reset Completed Lessons Progress</span>
          </button>
          <button id="clear-all-data-btn" class="btn btn-outline-danger text-start d-flex align-items-center gap-2">
            <span>⚠️</span> <span>Clear All Local Preferences & Stored Notes</span>
          </button>
        </div>
      </section>
    </div>

    <!-- Quick Shortcuts Card -->
    <div class="col-12 col-md-6">
      <section class="card border rounded-4 p-4 h-100 shadow-sm d-flex flex-column">
        <h2 class="h4 fw-bold text-body mb-3">
          ⌨️ Accessibility Quick Shortcuts
        </h2>
        <p class="text-body-secondary mb-3">
          Anticipate quick hotkeys to operate the learning platform seamlessly:
        </p>
        <ul class="list-group list-group-flush mb-4 rounded-3 border">
          <li class="list-group-item d-flex justify-content-between align-items-center py-2 bg-transparent">
            <span>Open Accommodations Suite (FAB)</span>
            <kbd class="badge bg-body-secondary text-body-secondary border">Alt + A</kbd>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center py-2 bg-transparent">
            <span>Toggle Reading Line Ruler</span>
            <kbd class="badge bg-body-secondary text-body-secondary border">Alt + R</kbd>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center py-2 bg-transparent">
            <span>Toggle Text-to-Speech Audio</span>
            <kbd class="badge bg-body-secondary text-body-secondary border">Alt + S</kbd>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center py-2 bg-transparent">
            <span>Toggle Zen Distraction-Free Mode</span>
            <kbd class="badge bg-body-secondary text-body-secondary border">Alt + Z</kbd>
          </li>
        </ul>

        <button data-bs-toggle="modal" data-bs-target="#shortcuts-modal" class="btn btn-primary w-100 mt-auto py-2">
          View Full Keyboard Cheatsheet (?)
        </button>
      </section>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('clear-progress-btn')?.addEventListener('click', () => {
      if (confirm('Are you sure you want to reset your completed lessons?')) {
        localStorage.removeItem('hestens_completed_lessons');
        alert('Lesson progress has been reset.');
        location.reload();
      }
    });

    document.getElementById('clear-all-data-btn')?.addEventListener('click', () => {
      if (confirm('This will reset your custom fonts, themes, notes, and progress to default. Continue?')) {
        localStorage.clear();
        document.cookie = 'hestens_theme=; Max-Age=0; path=/';
        document.cookie = 'hestens_font=; Max-Age=0; path=/';
        alert('All local data cleared.');
        location.href = 'index.php';
      }
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
