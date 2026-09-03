<?php
/**
 * Hestens Learning - Accessibility Floating Action Button (FAB) & Accommodations Suite
 */
?>
<!-- Floating Action Button (FAB) Trigger (Bottom-Right) -->
<div class="a11y-fab-container" role="region" aria-label="Accessibility Accommodations FAB">
  <button 
    id="a11y-fab-trigger" 
    class="a11y-fab-button" 
    aria-label="Open Accessibility & Accommodations Suite (Shortcut: Alt+A)"
    aria-haspopup="dialog"
    aria-expanded="false"
    title="Accessibility & Accommodations (Alt+A)"
  >
    <span class="fab-icon" aria-hidden="true">♿</span>
    <span class="fab-text">a11y Tools (Alt+A)</span>
  </button>
</div>

<!-- Backdrop Overlay for Drawer -->
<div id="drawer-backdrop" class="drawer-backdrop" aria-hidden="true"></div>

<!-- Slide-Over Accessibility Accommodations Drawer -->
<section 
  id="a11y-drawer" 
  class="a11y-drawer" 
  aria-labelledby="drawer-title-heading" 
  aria-modal="true" 
  role="dialog"
>
  <div class="drawer-header">
    <div id="drawer-title-heading" class="drawer-title">
      <span aria-hidden="true">⚙️</span> Accommodations Center
    </div>
    <button id="close-a11y-drawer-btn" class="btn btn-secondary btn-icon-only" aria-label="Close Accessibility Accommodations">
      ✕
    </button>
  </div>

  <div class="drawer-body">
    <!-- Section 1: Typography Selection -->
    <div class="drawer-section">
      <div class="drawer-section-title">
        <span>🔤</span> Font Selection (Dyslexia-Optimized)
      </div>
      <div class="control-grid">
        <button class="control-pill font-btn" data-font="opendyslexic" aria-label="Set font to OpenDyslexic">
          <span>📖</span> OpenDyslexic
        </button>
        <button class="control-pill font-btn active" data-font="lexend" aria-label="Set font to Lexend">
          <span>✨</span> Lexend (Clean)
        </button>
        <button class="control-pill font-btn" data-font="atkinson" aria-label="Set font to Atkinson Hyperlegible">
          <span>👁️</span> Atkinson Hyper
        </button>
        <button class="control-pill font-btn" data-font="sans" aria-label="Set font to Modern Sans">
          <span>📐</span> Modern Sans
        </button>
      </div>
    </div>

    <!-- Section 2: Sensory Themes & Color Tints -->
    <div class="drawer-section">
      <div class="drawer-section-title">
        <span>🎨</span> Sensory Themes & Visual Stress (Irlen) Tints
      </div>
      <div class="control-grid">
        <button class="control-pill theme-btn active" data-theme="dark" aria-label="Set theme to Calm Dark">
          <span>🌙</span> Calm Dark
        </button>
        <button class="control-pill theme-btn" data-theme="light" aria-label="Set theme to Crisp Light">
          <span>☀️</span> Crisp Light
        </button>
        <button class="control-pill theme-btn" data-theme="sepia" aria-label="Set theme to Warm Sepia Irlen Tint">
          <span>📜</span> Warm Sepia (Irlen)
        </button>
        <button class="control-pill theme-btn" data-theme="calm-green" aria-label="Set theme to Sage Green">
          <span>🌿</span> Sage Green
        </button>
        <button class="control-pill theme-btn" data-theme="calm-blue" aria-label="Set theme to Serene Blue">
          <span>🌊</span> Serene Blue
        </button>
        <button class="control-pill theme-btn" data-theme="high-contrast" aria-label="Set theme to High Contrast AAA">
          <span>⚡</span> High Contrast AAA
        </button>
      </div>
    </div>

    <!-- Section 3: Fine Typography Tuning -->
    <div class="drawer-section">
      <div class="drawer-section-title">
        <span>📏</span> Text Spacing & Sizing
      </div>

      <div class="slider-group">
        <div class="slider-header">
          <span>Font Size Scale</span>
          <span id="font-size-val">100%</span>
        </div>
        <input type="range" id="font-size-slider" min="0.8" max="1.6" step="0.05" value="1.0" class="a11y-range" aria-label="Font Size Scale">
      </div>

      <div class="slider-group">
        <div class="slider-header">
          <span>Line Height Spacing</span>
          <span id="line-height-val">1.65x</span>
        </div>
        <input type="range" id="line-height-slider" min="1.3" max="2.4" step="0.1" value="1.65" class="a11y-range" aria-label="Line Height Spacing">
      </div>

      <div class="slider-group">
        <div class="slider-header">
          <span>Letter Spacing</span>
          <span id="letter-spacing-val">0.02em</span>
        </div>
        <input type="range" id="letter-spacing-slider" min="0" max="0.15" step="0.01" value="0.02" class="a11y-range" aria-label="Letter Spacing">
      </div>
    </div>

    <!-- Section 4: Assistive Focus & Cognitive Aids -->
    <div class="drawer-section">
      <div class="drawer-section-title">
        <span>🧠</span> Cognitive & Focus Aids
      </div>

      <div class="toggle-row">
        <div>
          <strong>Bionic Reading Mode</strong>
          <p style="font-size:0.8rem; color:var(--text-muted);">Bolds word starts for easier eye fixations</p>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="toggle-bionic" aria-label="Toggle Bionic Reading">
          <span class="toggle-slider"></span>
        </label>
      </div>

      <div class="toggle-row">
        <div>
          <strong>Reading Line Ruler (Alt+R)</strong>
          <p style="font-size:0.8rem; color:var(--text-muted);">Tinted guide that follows your reading line</p>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="toggle-ruler" aria-label="Toggle Reading Ruler">
          <span class="toggle-slider"></span>
        </label>
      </div>

      <div class="toggle-row">
        <div>
          <strong>Focus Mask Dimmer</strong>
          <p style="font-size:0.8rem; color:var(--text-muted);">Dims screen outside active reading zone</p>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="toggle-mask" aria-label="Toggle Focus Mask">
          <span class="toggle-slider"></span>
        </label>
      </div>

      <div class="toggle-row">
        <div>
          <strong>Reduced Motion</strong>
          <p style="font-size:0.8rem; color:var(--text-muted);">Disables animations and transitions</p>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="toggle-motion" aria-label="Toggle Reduced Motion">
          <span class="toggle-slider"></span>
        </label>
      </div>

      <div class="toggle-row">
        <div>
          <strong>Gentle Sound Feedback</strong>
          <p style="font-size:0.8rem; color:var(--text-muted);">Calm audio cues for achievements & clicks</p>
        </div>
        <label class="toggle-switch">
          <input type="checkbox" id="toggle-sound" checked aria-label="Toggle Gentle Sound Effects">
          <span class="toggle-slider"></span>
        </label>
      </div>
    </div>
  </div>
</section>

<!-- Learning Notes Drawer -->
<aside id="notes-drawer" class="notes-drawer" aria-labelledby="notes-heading" role="complementary">
  <div class="drawer-header">
    <div id="notes-heading" class="drawer-title">
      <span aria-hidden="true">📝</span> My Learning Notes
    </div>
    <button id="close-notes-btn" class="btn btn-secondary btn-icon-only" aria-label="Close Notes Drawer">
      ✕
    </button>
  </div>
  <div class="notes-editor">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <button id="voice-dictate-btn" class="btn btn-secondary" aria-label="Dictate thoughts with your voice (Speech to Text)">
        <span>🎙️</span> <span>Dictate (Voice)</span>
      </button>
      <div id="voice-status-indicator" class="voice-recording-status" style="display:none;">
        <div class="voice-pulsing-dot"></div>
        <span>Listening...</span>
      </div>
    </div>
    <textarea id="notes-textarea" class="notes-textarea" placeholder="Jot down questions, key takeaways, or voice thoughts. Notes save automatically to your browser..."></textarea>
    <span style="font-size: 0.8rem; color: var(--text-muted);">💾 Notes automatically save to your local browser storage.</span>
  </div>
</aside>

<!-- Floating Focus Pomodoro Timer -->
<aside id="focus-timer-widget" class="focus-timer-floating" aria-labelledby="timer-heading" role="complementary">
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <strong id="timer-heading" style="font-size: 0.95rem;">⏱️ Focus Session</strong>
    <button class="btn btn-secondary btn-icon-only" style="min-width:32px; min-height:32px; padding:0;" onclick="document.getElementById('focus-timer-widget').classList.remove('active')" aria-label="Close Timer">✕</button>
  </div>
  <div id="timer-display-text" class="timer-display">25:00</div>
  <div class="timer-controls">
    <button id="timer-start-pause-btn" class="btn btn-primary" style="font-size:0.85rem; padding:0.4rem 0.8rem;">▶ Start Focus</button>
    <button id="timer-reset-btn" class="btn btn-secondary" style="font-size:0.85rem; padding:0.4rem 0.8rem;">Reset</button>
  </div>
</aside>

<!-- Keyboard Shortcuts Modal -->
<div id="shortcuts-modal" class="modal-backdrop" aria-hidden="true" role="dialog" aria-labelledby="shortcuts-modal-title">
  <div class="modal-content">
    <div class="modal-header">
      <h3 id="shortcuts-modal-title" style="font-size: 1.3rem; font-weight: 800;">⌨️ Accessibility Hotkeys & Shortcuts</h3>
      <button id="close-shortcuts-btn" class="btn btn-secondary btn-icon-only" aria-label="Close Shortcuts Modal">✕</button>
    </div>
    <table class="shortcut-table">
      <tbody>
        <tr>
          <td><kbd class="kbd-badge">Alt</kbd> + <kbd class="kbd-badge">A</kbd></td>
          <td>Open / Close Accessibility FAB Accommodations Drawer</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">Alt</kbd> + <kbd class="kbd-badge">R</kbd></td>
          <td>Toggle Reading Line Ruler</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">Alt</kbd> + <kbd class="kbd-badge">S</kbd></td>
          <td>Start / Stop Text-to-Speech Audio Narration</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">Alt</kbd> + <kbd class="kbd-badge">Z</kbd></td>
          <td>Toggle Zen Distraction-Free Focus Mode</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">Tab</kbd> / <kbd class="kbd-badge">Shift+Tab</kbd></td>
          <td>Navigate interactive elements with high-visibility focus ring</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">Space</kbd> / <kbd class="kbd-badge">Enter</kbd></td>
          <td>Flip active recall flashcard / Activate buttons</td>
        </tr>
        <tr>
          <td><kbd class="kbd-badge">?</kbd></td>
          <td>Open this keyboard shortcuts cheatsheet</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
