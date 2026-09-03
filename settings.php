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

<div class="settings-container">
  <div class="section-header" style="margin-bottom: 2rem;">
    <div>
      <h1 class="section-title">⚙️ Site Settings & Data Storage</h1>
      <p style="color:var(--text-secondary); margin-top:0.25rem;">
        Customize how your preferences and lesson progress are stored.
      </p>
    </div>
  </div>

  <div class="settings-grid">
    <!-- Storage & Privacy Card -->
    <section class="binder-card">
      <h2 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.75rem;">
        🔒 Localhost & Cookie Storage
      </h2>
      <p style="color:var(--text-secondary); line-height:1.6; margin-bottom:1rem;">
        Hestens Learning stores your accessibility preferences (font choice, visual tints, line spacing) and completed lessons locally in your browser (Cookies & LocalStorage) for instant zero-latency loading.
      </p>

      <div style="display:flex; flex-direction:column; gap:0.75rem; margin-top:1.5rem;">
        <button id="clear-progress-btn" class="btn btn-secondary" style="color:var(--warning-color); border-color:var(--warning-color); justify-content:flex-start;">
          <span>🗑️</span> <span>Reset Completed Lessons Progress</span>
        </button>
        <button id="clear-all-data-btn" class="btn btn-secondary" style="color:var(--warning-color); border-color:var(--warning-color); justify-content:flex-start;">
          <span>⚠️</span> <span>Clear All Local Preferences & Stored Notes</span>
        </button>
      </div>
    </section>

    <!-- Quick Shortcuts Card -->
    <section class="binder-card">
      <h2 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 0.75rem;">
        ⌨️ Accessibility Quick Shortcuts
      </h2>
      <p style="color:var(--text-secondary); line-height:1.6; margin-bottom:1rem;">
        Anticipate quick hotkeys to operate the learning platform seamlessly:
      </p>
      <ul style="list-style:none; display:flex; flex-direction:column; gap:0.6rem; font-weight:600;">
        <li><kbd class="kbd-badge">Alt + A</kbd> : Open Accommodations Suite (FAB)</li>
        <li><kbd class="kbd-badge">Alt + R</kbd> : Toggle Reading Line Ruler</li>
        <li><kbd class="kbd-badge">Alt + S</kbd> : Toggle Text-to-Speech Audio</li>
        <li><kbd class="kbd-badge">Alt + Z</kbd> : Toggle Zen Distraction-Free Mode</li>
      </ul>

      <button onclick="document.getElementById('shortcuts-modal').classList.add('open')" class="btn btn-primary" style="margin-top:1.5rem; width:100%;">
        View Full Keyboard Cheatsheet (?)
      </button>
    </section>
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
