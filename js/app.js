/**
 * Hestens Learning - Universal Application Controller (js/app.js)
 * Standalone Classic JS (Wasmer Edge / WebAssembly compatible)
 */
(function(window) {
  'use strict';

  class App {
    constructor() {
      this.a11y = new window.A11yEngine();
      this.widgetManager = new window.WidgetManager(this.a11y);
      
      // Timer state
      this.timerInterval = null;
      this.timerSeconds = 25 * 60;
      this.isTimerRunning = false;

      // Speech Recognition for Notes
      this.recognition = null;
      this.isRecordingNotes = false;

      this.init();
    }

    init() {
      this.bindA11yFAB();
      this.bindGradeFilterTabs();
      this.bindModals();
      this.bindTTSControls();
      this.syncUserName();
    }

    syncUserName() {
      const savedName = localStorage.getItem('hestens_student_name');
      const nameEl = document.getElementById('header-user-name');
      if (nameEl && savedName) {
        nameEl.textContent = savedName;
      }
    }

    // --- Accessibility Floating Action Button (FAB) & Drawer ---
    bindA11yFAB() {
      const fabBtn = document.getElementById('a11y-fab-trigger');
      const closeBtn = document.getElementById('close-a11y-drawer-btn');
      const backdrop = document.getElementById('drawer-backdrop');

      fabBtn?.addEventListener('click', () => this.a11y.toggleDrawer());
      closeBtn?.addEventListener('click', () => this.a11y.toggleDrawer());
      backdrop?.addEventListener('click', () => this.a11y.toggleDrawer());

      // Theme buttons
      document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.theme-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          this.a11y.setTheme(btn.dataset.theme);
        });
      });

      // Font buttons
      document.querySelectorAll('.font-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          document.querySelectorAll('.font-btn').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          this.a11y.setFont(btn.dataset.font);
        });
      });

      // Sliders
      const sizeRange = document.getElementById('font-size-slider');
      sizeRange?.addEventListener('input', (e) => {
        this.a11y.setFontSize(e.target.value);
        document.getElementById('font-size-val').textContent = `${Math.round(e.target.value * 100)}%`;
      });

      const heightRange = document.getElementById('line-height-slider');
      heightRange?.addEventListener('input', (e) => {
        this.a11y.setLineHeight(e.target.value);
        document.getElementById('line-height-val').textContent = `${e.target.value}x`;
      });

      const letterRange = document.getElementById('letter-spacing-slider');
      letterRange?.addEventListener('input', (e) => {
        this.a11y.setLetterSpacing(e.target.value);
        document.getElementById('letter-spacing-val').textContent = `${e.target.value}em`;
      });

      // Assistive Toggles
      document.getElementById('toggle-bionic')?.addEventListener('change', (e) => this.a11y.setBionicReading(e.target.checked));
      document.getElementById('toggle-ruler')?.addEventListener('change', (e) => this.a11y.setReadingRuler(e.target.checked));
      document.getElementById('toggle-mask')?.addEventListener('change', (e) => this.a11y.setFocusMask(e.target.checked));
      document.getElementById('toggle-motion')?.addEventListener('change', (e) => this.a11y.setReducedMotion(e.target.checked));
      document.getElementById('toggle-sound')?.addEventListener('change', (e) => this.a11y.setSoundEffects(e.target.checked));
    }

    // --- Grade Cards Tier Filter (index.php) ---
    bindGradeFilterTabs() {
      const filterTabs = document.querySelectorAll('.filter-tab');
      const cards = document.querySelectorAll('.grade-card');

      if (filterTabs.length === 0 || cards.length === 0) return;

      filterTabs.forEach(tab => {
        tab.addEventListener('click', () => {
          const filter = tab.dataset.filter;

          filterTabs.forEach(t => {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
          });
          tab.classList.add('active');
          tab.setAttribute('aria-selected', 'true');

          cards.forEach(card => {
            if (filter === 'all' || card.dataset.tier === filter) {
              card.style.display = 'flex';
            } else {
              card.style.display = 'none';
            }
          });

          this.a11y.playChime('click');
        });
      });
    }

    // --- Text to Speech Bar ---
    bindTTSControls() {
      document.querySelectorAll('.tts-toggle-btn').forEach(btn => {
        btn.addEventListener('click', () => this.a11y.toggleTTS());
      });

      document.getElementById('tts-speed-select')?.addEventListener('change', (e) => {
        this.a11y.prefs.speechRate = parseFloat(e.target.value);
      });
    }

    // --- Voice-To-Text & Notes Drawer ---
    bindNotesDrawer() {
      const drawer = document.getElementById('notes-drawer');
      const toggleBtn = document.getElementById('open-notes-btn');
      const closeBtn = document.getElementById('close-notes-btn');
      const textarea = document.getElementById('notes-textarea');

      if (textarea) {
        textarea.value = localStorage.getItem('hestens_student_notes') || '';
        textarea.addEventListener('input', () => {
          localStorage.setItem('hestens_student_notes', textarea.value);
        });
      }

      toggleBtn?.addEventListener('click', () => {
        drawer?.classList.toggle('open');
        if (drawer?.classList.contains('open')) {
          textarea?.focus();
          this.a11y.announce('Learning notes drawer opened');
        }
      });

      closeBtn?.addEventListener('click', () => drawer?.classList.remove('open'));
    }

    bindVoiceRecognition() {
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      const voiceBtn = document.getElementById('voice-dictate-btn');
      const voiceStatus = document.getElementById('voice-status-indicator');
      const textarea = document.getElementById('notes-textarea');

      if (!SpeechRecognition) {
        if (voiceBtn) voiceBtn.style.display = 'none';
        return;
      }

      this.recognition = new SpeechRecognition();
      this.recognition.continuous = true;
      this.recognition.interimResults = true;

      this.recognition.onresult = (event) => {
        let transcript = '';
        for (let i = event.resultIndex; i < event.results.length; ++i) {
          transcript += event.results[i][0].transcript;
        }
        if (textarea) {
          textarea.value += ' ' + transcript;
          localStorage.setItem('hestens_student_notes', textarea.value);
        }
      };

      this.recognition.onerror = () => {
        this.isRecordingNotes = false;
        if (voiceStatus) voiceStatus.style.display = 'none';
        if (voiceBtn) voiceBtn.classList.remove('btn-active');
      };

      voiceBtn?.addEventListener('click', () => {
        if (this.isRecordingNotes) {
          this.recognition.stop();
          this.isRecordingNotes = false;
          if (voiceStatus) voiceStatus.style.display = 'none';
          voiceBtn.classList.remove('btn-active');
          this.a11y.announce('Voice note dictation stopped');
        } else {
          try {
            this.recognition.start();
            this.isRecordingNotes = true;
            if (voiceStatus) voiceStatus.style.display = 'flex';
            voiceBtn.classList.add('btn-active');
            this.a11y.announce('Listening: speak your thoughts');
          } catch (e) {
            console.warn('Speech recognition start failed', e);
          }
        }
      });
    }

    // --- Focus Pomodoro Timer ---
    bindFocusTimer() {
      const timerWidget = document.getElementById('focus-timer-widget');
      const toggleBtn = document.getElementById('toggle-timer-btn');
      const display = document.getElementById('timer-display-text');
      const startPauseBtn = document.getElementById('timer-start-pause-btn');
      const resetBtn = document.getElementById('timer-reset-btn');

      const updateDisplay = () => {
        const mins = Math.floor(this.timerSeconds / 60).toString().padStart(2, '0');
        const secs = (this.timerSeconds % 60).toString().padStart(2, '0');
        if (display) display.textContent = `${mins}:${secs}`;
      };

      toggleBtn?.addEventListener('click', () => {
        timerWidget?.classList.toggle('active');
        this.a11y.playChime('click');
      });

      startPauseBtn?.addEventListener('click', () => {
        if (this.isTimerRunning) {
          clearInterval(this.timerInterval);
          this.isTimerRunning = false;
          startPauseBtn.textContent = '▶ Start Focus';
        } else {
          this.isTimerRunning = true;
          startPauseBtn.textContent = '⏸ Pause';
          this.timerInterval = setInterval(() => {
            if (this.timerSeconds > 0) {
              this.timerSeconds--;
              updateDisplay();
            } else {
              clearInterval(this.timerInterval);
              this.isTimerRunning = false;
              this.a11y.playChime('celebrate');
              alert('🌟 Focus session complete! Take a gentle 5-minute stretch break.');
              this.timerSeconds = 25 * 60;
              updateDisplay();
              startPauseBtn.textContent = '▶ Start Focus';
            }
          }, 1000);
        }
      });

      resetBtn?.addEventListener('click', () => {
        clearInterval(this.timerInterval);
        this.isTimerRunning = false;
        this.timerSeconds = 25 * 60;
        updateDisplay();
        if (startPauseBtn) startPauseBtn.textContent = '▶ Start Focus';
      });

      updateDisplay();
    }

    bindModals() {
      const shortcutsModal = document.getElementById('shortcuts-modal');
      const closeShortcutsBtn = document.getElementById('close-shortcuts-btn');

      closeShortcutsBtn?.addEventListener('click', () => shortcutsModal?.classList.remove('open'));
      shortcutsModal?.addEventListener('click', (e) => {
        if (e.target === shortcutsModal) shortcutsModal.classList.remove('open');
      });
    }
  }

  window.App = App;

  // Initialize on DOM load
  window.addEventListener('DOMContentLoaded', () => {
    window.hestensApp = new App();
  });
})(window);
