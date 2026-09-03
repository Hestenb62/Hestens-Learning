/**
 * Hestens Learning - Main Application Controller (js/app.js)
 */

import { COURSES } from './course-data.js';
import { A11yEngine } from './a11y-engine.js';
import { WidgetManager } from './interactive-widgets.js';

class App {
  constructor() {
    this.a11y = new A11yEngine();
    this.widgetManager = new WidgetManager(this.a11y);
    
    this.currentCourseId = null;
    this.currentLessonIndex = 0;
    this.completedLessons = new Set(JSON.parse(localStorage.getItem('hestens_completed_lessons') || '[]'));
    
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
    this.renderCourseGrid();
    this.bindA11yDrawerControls();
    this.bindQuickBar();
    this.bindNotesDrawer();
    this.bindFocusTimer();
    this.bindModals();
    this.bindVoiceRecognition();
    this.updateStatsDisplay();
  }

  // --- Course Catalog & Navigation ---
  renderCourseGrid(filter = 'all') {
    const grid = document.getElementById('course-grid');
    if (!grid) return;

    const filtered = filter === 'all' 
      ? COURSES 
      : COURSES.filter(c => c.category.toLowerCase().includes(filter.toLowerCase()));

    grid.innerHTML = filtered.map(course => {
      const completedCount = course.lessons.filter(l => this.completedLessons.has(l.id)).length;
      const progressPercent = Math.round((completedCount / course.lessons.length) * 100);

      return `
        <article class="course-card" aria-label="${course.title}">
          <div class="course-card-banner ${course.bannerClass}">
            <div class="card-badge-row">
              <span class="card-pill"><span>${course.icon}</span> ${course.category}</span>
              <span class="card-pill">${course.timeEstimate}</span>
            </div>
            <div class="course-icon-large">${course.icon}</div>
          </div>
          <div class="course-card-body">
            <h3 class="course-card-title">${course.title}</h3>
            <p class="course-card-desc">${course.description}</p>
            <div class="course-meta-list">
              <span>📖 ${course.lessons.length} Micro-Lessons</span>
              <span>⚡ ${course.level}</span>
            </div>
            <div class="course-progress-bar" role="progressbar" aria-valuenow="${progressPercent}" aria-valuemin="0" aria-valuemax="100" aria-label="Course completion progress">
              <div class="course-progress-fill" style="width: ${progressPercent}%;"></div>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
              <span style="font-size: 0.82rem; font-weight: 700; color: var(--text-muted);">${progressPercent}% Complete</span>
              <button class="btn btn-primary start-course-btn" data-id="${course.id}" aria-label="Start course: ${course.title}">
                ${progressPercent > 0 ? 'Continue' : 'Start Learning'} ➔
              </button>
            </div>
          </div>
        </article>
      `;
    }).join('');

    // Bind Start buttons
    grid.querySelectorAll('.start-course-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        this.openCourse(btn.dataset.id);
      });
    });

    // Bind Category Filter Tabs
    document.querySelectorAll('.filter-tab').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        this.renderCourseGrid(tab.dataset.category);
        this.a11y.playChime('click');
      });
    });
  }

  openCourse(courseId, lessonIndex = 0) {
    this.currentCourseId = courseId;
    this.currentLessonIndex = lessonIndex;

    const course = COURSES.find(c => c.id === courseId);
    if (!course) return;

    document.getElementById('catalog-view').style.display = 'none';
    const playerView = document.getElementById('lesson-player-view');
    playerView.classList.add('active');

    this.renderCurrentLesson();
    window.scrollTo({ top: 0, behavior: 'smooth' });
    this.a11y.announce(`Opened course ${course.title}`);
  }

  renderCurrentLesson() {
    const course = COURSES.find(c => c.id === this.currentCourseId);
    if (!course) return;
    const lesson = course.lessons[this.currentLessonIndex];
    if (!lesson) return;

    // Set Header titles & stepper dots
    document.getElementById('current-course-name').textContent = course.title;
    document.getElementById('lesson-badge-label').textContent = lesson.badge;
    document.getElementById('lesson-title-heading').textContent = lesson.title;
    
    // Stepper dots
    const stepper = document.getElementById('lesson-stepper-dots');
    stepper.innerHTML = course.lessons.map((l, idx) => {
      const isCompleted = this.completedLessons.has(l.id);
      const isActive = idx === this.currentLessonIndex;
      return `
        <div class="step-dot ${isActive ? 'active' : ''} ${isCompleted ? 'completed' : ''}"
             data-index="${idx}"
             title="${l.title}"
             aria-label="Lesson ${idx + 1}: ${l.title} ${isCompleted ? '(Completed)' : ''}"
             role="button" tabindex="0"></div>
      `;
    }).join('');

    stepper.querySelectorAll('.step-dot').forEach(dot => {
      dot.addEventListener('click', () => {
        this.currentLessonIndex = parseInt(dot.dataset.index, 10);
        this.renderCurrentLesson();
      });
    });

    // Content & Plain Language Summary
    const proseContainer = document.getElementById('lesson-prose-container');
    proseContainer.innerHTML = lesson.contentHtml;
    proseContainer.dataset.originalHtml = lesson.contentHtml;

    document.getElementById('simple-explain-content').textContent = lesson.summary;
    document.getElementById('lesson-audio-script').textContent = lesson.audioScript;

    // Interactive embedded widget
    const widgetContainer = document.getElementById('embedded-widget-container');
    this.widgetManager.renderWidget(widgetContainer, lesson.widgetType);

    // Flashcards
    this.renderFlashcards(lesson.flashcards);

    // Quiz
    this.renderQuiz(lesson.quiz, lesson.id);

    // Navigation buttons state
    const prevBtn = document.getElementById('prev-lesson-btn');
    const nextBtn = document.getElementById('next-lesson-btn');
    prevBtn.disabled = this.currentLessonIndex === 0;
    prevBtn.style.opacity = this.currentLessonIndex === 0 ? '0.4' : '1';

    const isLast = this.currentLessonIndex === course.lessons.length - 1;
    nextBtn.innerHTML = isLast ? 'Finish Course 🎉' : 'Next Lesson ➔';

    // Apply active Bionic reading or other text transformations
    this.a11y.refreshBionicState();
  }

  renderFlashcards(cards) {
    const container = document.getElementById('flashcards-container');
    if (!cards || cards.length === 0) {
      container.style.display = 'none';
      return;
    }
    container.style.display = 'block';

    let cardIdx = 0;
    const renderCard = () => {
      const card = cards[cardIdx];
      container.innerHTML = `
        <div class="widget-title">💡 Active Recall Flashcard (${cardIdx + 1} of ${cards.length})</div>
        <div class="flashcard-wrapper">
          <div class="flashcard" id="active-flashcard" role="button" tabindex="0" aria-label="Flashcard. Click or press space to flip">
            <div id="flashcard-face-content" style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
              ${card.front}
            </div>
            <div class="flashcard-hint">🔄 Click or press Space to flip</div>
          </div>
        </div>
        <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
          <button class="btn btn-secondary" id="fc-prev-btn" ${cardIdx === 0 ? 'disabled style="opacity:0.5"' : ''}>◀ Previous</button>
          <button class="btn btn-secondary" id="fc-next-btn" ${cardIdx === cards.length - 1 ? 'disabled style="opacity:0.5"' : ''}>Next ▶</button>
        </div>
      `;

      let flipped = false;
      const cardEl = container.querySelector('#active-flashcard');
      const faceEl = container.querySelector('#flashcard-face-content');

      const toggleFlip = () => {
        flipped = !flipped;
        faceEl.textContent = flipped ? card.back : card.front;
        faceEl.style.color = flipped ? 'var(--accent-primary)' : 'var(--text-primary)';
        cardEl.style.borderColor = flipped ? 'var(--accent-primary)' : 'var(--border-subtle)';
        this.a11y.playChime('click');
      };

      cardEl.addEventListener('click', toggleFlip);
      cardEl.addEventListener('keydown', (e) => {
        if (e.key === ' ' || e.key === 'Enter') {
          e.preventDefault();
          toggleFlip();
        }
      });

      container.querySelector('#fc-prev-btn').addEventListener('click', () => {
        if (cardIdx > 0) { cardIdx--; renderCard(); }
      });
      container.querySelector('#fc-next-btn').addEventListener('click', () => {
        if (cardIdx < cards.length - 1) { cardIdx++; renderCard(); }
      });
    };

    renderCard();
  }

  renderQuiz(quizData, lessonId) {
    const container = document.getElementById('lesson-quiz-container');
    if (!quizData) {
      container.style.display = 'none';
      return;
    }
    container.style.display = 'block';

    container.innerHTML = `
      <div class="quiz-header">
        <span class="quiz-badge">Low-Stress Knowledge Check</span>
        <h3 class="quiz-question">${quizData.question}</h3>
      </div>
      <div class="quiz-options">
        ${quizData.options.map((opt, i) => `
          <button class="quiz-option" data-idx="${i}" aria-label="Option: ${opt.text}">
            <span style="display:inline-flex; width:28px; height:28px; border-radius:50%; background:var(--bg-tertiary); align-items:center; justify-content:center; font-weight:800; font-size:0.85rem;">
              ${String.fromCharCode(65 + i)}
            </span>
            <span>${opt.text}</span>
          </button>
        `).join('')}
      </div>
      <div id="quiz-feedback-box" class="quiz-feedback"></div>
    `;

    const options = container.querySelectorAll('.quiz-option');
    const feedbackBox = container.querySelector('#quiz-feedback-box');

    options.forEach(opt => {
      opt.addEventListener('click', () => {
        const choice = quizData.options[parseInt(opt.dataset.idx, 10)];
        options.forEach(o => o.className = 'quiz-option');

        if (choice.correct) {
          opt.classList.add('correct');
          feedbackBox.textContent = `🌟 ${choice.feedback}`;
          feedbackBox.className = 'quiz-feedback show correct';
          this.a11y.playChime('celebrate');
          
          // Mark lesson complete!
          this.completedLessons.add(lessonId);
          localStorage.setItem('hestens_completed_lessons', JSON.stringify([...this.completedLessons]));
          this.updateStatsDisplay();
        } else {
          opt.classList.add('incorrect');
          feedbackBox.textContent = `💡 Hint: ${choice.feedback}`;
          feedbackBox.className = 'quiz-feedback show encouraging';
          this.a11y.playChime('click');
        }
      });
    });
  }

  updateStatsDisplay() {
    const totalLessons = COURSES.reduce((acc, c) => acc + c.lessons.length, 0);
    const completedCount = this.completedLessons.size;
    const statEl = document.getElementById('stat-completed-lessons');
    if (statEl) {
      statEl.textContent = `${completedCount} / ${totalLessons} Mastered`;
    }
  }

  // --- Accessibility Drawer Binding ---
  bindA11yDrawerControls() {
    // Open/Close
    const drawer = document.getElementById('a11y-drawer');
    const backdrop = document.getElementById('drawer-backdrop');
    const openBtn = document.getElementById('open-a11y-drawer-btn');
    const closeBtn = document.getElementById('close-a11y-drawer-btn');

    openBtn?.addEventListener('click', () => this.a11y.toggleDrawer());
    closeBtn?.addEventListener('click', () => this.a11y.toggleDrawer());
    backdrop?.addEventListener('click', () => this.a11y.toggleDrawer());

    // Themes
    document.querySelectorAll('.theme-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('.theme-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.a11y.setTheme(btn.dataset.theme);
      });
    });

    // Fonts
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
    const bionicToggle = document.getElementById('toggle-bionic');
    bionicToggle?.addEventListener('change', (e) => this.a11y.setBionicReading(e.target.checked));

    const rulerToggle = document.getElementById('toggle-ruler');
    rulerToggle?.addEventListener('change', (e) => this.a11y.setReadingRuler(e.target.checked));

    const maskToggle = document.getElementById('toggle-mask');
    maskToggle?.addEventListener('change', (e) => this.a11y.setFocusMask(e.target.checked));

    const motionToggle = document.getElementById('toggle-motion');
    motionToggle?.addEventListener('change', (e) => this.a11y.setReducedMotion(e.target.checked));

    const soundToggle = document.getElementById('toggle-sound');
    soundToggle?.addEventListener('change', (e) => this.a11y.setSoundEffects(e.target.checked));
  }

  bindQuickBar() {
    // Quick Bar Buttons
    document.getElementById('quick-ruler-btn')?.addEventListener('click', (e) => {
      this.a11y.setReadingRuler(!this.a11y.prefs.readingRuler);
      e.currentTarget.classList.toggle('active', this.a11y.prefs.readingRuler);
    });

    document.getElementById('quick-bionic-btn')?.addEventListener('click', (e) => {
      this.a11y.setBionicReading(!this.a11y.prefs.bionicReading);
      e.currentTarget.classList.toggle('active', this.a11y.prefs.bionicReading);
    });

    document.getElementById('quick-tts-btn')?.addEventListener('click', () => {
      this.a11y.toggleTTS();
    });

    document.getElementById('quick-zen-btn')?.addEventListener('click', () => {
      this.a11y.setZenMode(true);
    });

    document.getElementById('exit-zen-btn')?.addEventListener('click', () => {
      this.a11y.setZenMode(false);
    });

    // TTS Header button
    document.querySelectorAll('.tts-toggle-btn').forEach(btn => {
      btn.addEventListener('click', () => this.a11y.toggleTTS());
    });

    // TTS Speed select
    document.getElementById('tts-speed-select')?.addEventListener('change', (e) => {
      this.a11y.prefs.speechRate = parseFloat(e.target.value);
    });

    // Back to catalog button
    document.getElementById('back-to-catalog-btn')?.addEventListener('click', () => {
      this.a11y.stopTTS();
      document.getElementById('lesson-player-view').classList.remove('active');
      document.getElementById('catalog-view').style.display = 'block';
      this.renderCourseGrid();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Lesson prev/next
    document.getElementById('prev-lesson-btn')?.addEventListener('click', () => {
      if (this.currentLessonIndex > 0) {
        this.a11y.stopTTS();
        this.currentLessonIndex--;
        this.renderCurrentLesson();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      }
    });

    document.getElementById('next-lesson-btn')?.addEventListener('click', () => {
      const course = COURSES.find(c => c.id === this.currentCourseId);
      if (this.currentLessonIndex < course.lessons.length - 1) {
        this.a11y.stopTTS();
        this.currentLessonIndex++;
        this.renderCurrentLesson();
        window.scrollTo({ top: 0, behavior: 'smooth' });
      } else {
        // Course Finished!
        this.a11y.playChime('celebrate');
        alert('🎉 Congratulations! You have completed this entire course module!');
        document.getElementById('back-to-catalog-btn').click();
      }
    });
  }

  // --- Voice-To-Text & Notes Drawer ---
  bindNotesDrawer() {
    const drawer = document.getElementById('notes-drawer');
    const toggleBtn = document.getElementById('open-notes-btn');
    const closeBtn = document.getElementById('close-notes-btn');
    const textarea = document.getElementById('notes-textarea');

    // Load saved notes
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
        voiceStatus.style.display = 'none';
        voiceBtn.classList.remove('btn-active');
        this.a11y.announce('Voice note dictation stopped');
      } else {
        try {
          this.recognition.start();
          this.isRecordingNotes = true;
          voiceStatus.style.display = 'flex';
          voiceBtn.classList.add('btn-active');
          this.a11y.announce('Listening: speak your notes aloud');
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
            alert('🌟 Great focus session! Time to take a gentle 5-minute stretch or sensory break.');
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

  // --- Keyboard Shortcuts Modal ---
  bindModals() {
    const shortcutsModal = document.getElementById('shortcuts-modal');
    const openShortcutsBtn = document.getElementById('open-shortcuts-btn');
    const closeShortcutsBtn = document.getElementById('close-shortcuts-btn');

    openShortcutsBtn?.addEventListener('click', () => shortcutsModal?.classList.add('open'));
    closeShortcutsBtn?.addEventListener('click', () => shortcutsModal?.classList.remove('open'));
    shortcutsModal?.addEventListener('click', (e) => {
      if (e.target === shortcutsModal) shortcutsModal.classList.remove('open');
    });
  }
}

// Instantiate on DOM load
window.addEventListener('DOMContentLoaded', () => {
  window.hestensApp = new App();
});
