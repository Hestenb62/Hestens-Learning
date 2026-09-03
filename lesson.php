<?php
/**
 * Hestens Learning - Universal Reusable Lesson Engine (lesson.php)
 * Dynamically renders any lesson from curriculum.json
 */
require_once __DIR__ . '/includes/helpers.php';

$gradeId = $_GET['grade'] ?? '1st';
$subjectId = $_GET['subject'] ?? 'math';
$lessonId = $_GET['id'] ?? '1st-math-1';

$data = get_lesson($gradeId, $subjectId, $lessonId);

if (!$data) {
    header("Location: index.php");
    exit;
}

$lesson = $data['lesson'];
$grade = $data['grade'];
$subject = $data['subject'];
$prevLesson = $data['prev'];
$nextLesson = $data['next'];

$pageTitle = $lesson['title'] . ' | ' . $grade['title'] . ' ' . $subject['title'];
$pageDescription = $lesson['summary'] ?? $lesson['title'];
$activePage = 'grades';

include __DIR__ . '/includes/header.php';
?>

<!-- Breadcrumbs -->
<nav class="breadcrumb-nav" aria-label="Breadcrumb">
  <a href="index.php">Home</a>
  <span aria-hidden="true">›</span>
  <a href="grade.php?level=<?= urlencode($gradeId) ?>"><?= htmlspecialchars($grade['title']) ?></a>
  <span aria-hidden="true">›</span>
  <a href="grade.php?level=<?= urlencode($gradeId) ?>&tab=<?= urlencode($subjectId) ?>"><?= htmlspecialchars($subject['title']) ?></a>
  <span aria-hidden="true">›</span>
  <span aria-current="page"><?= htmlspecialchars($lesson['title']) ?></span>
</nav>

<div class="lesson-view-wrapper">
  <!-- Lesson Header Bar -->
  <div class="lesson-header-bar">
    <div class="lesson-nav-info">
      <a href="grade.php?level=<?= urlencode($gradeId) ?>&tab=<?= urlencode($subjectId) ?>" class="btn btn-secondary" aria-label="Return to <?= htmlspecialchars($subject['title']) ?> curriculum">
        <span>◀</span> <span>Back to <?= htmlspecialchars($subject['title']) ?></span>
      </a>
      <div>
        <h2 style="font-size: 1.15rem; font-weight: 800;"><?= htmlspecialchars($grade['title']) ?> • <?= htmlspecialchars($subject['title']) ?></h2>
        <span style="font-size: 0.85rem; color: var(--text-muted);">Interactive Step-by-Step Lesson</span>
      </div>
    </div>
  </div>

  <!-- Audio Narration Bar -->
  <div class="audio-narrator-bar">
    <div class="audio-controls">
      <button class="btn btn-primary tts-toggle-btn" id="tts-lesson-btn" aria-label="Listen to this lesson read aloud (Alt+S)">
        <span aria-hidden="true">🔊</span> <span>Listen (Aloud)</span>
      </button>
      <label for="tts-speed-select" style="font-size: 0.85rem; font-weight: 700;">Speed:</label>
      <select id="tts-speed-select" class="audio-speed-select" aria-label="Adjust voice reading rate">
        <option value="0.75">0.75x (Relaxed)</option>
        <option value="1.0" selected>1.0x (Normal)</option>
        <option value="1.25">1.25x (Brisk)</option>
        <option value="1.5">1.5x (Fast)</option>
      </select>
    </div>
    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
      💡 Tip: Press <kbd class="kbd-badge">Alt+R</kbd> for Reading Ruler or <kbd class="kbd-badge">Alt+Z</kbd> for Zen Mode
    </span>
  </div>

  <!-- Hidden Audio Transcript for Web Speech TTS -->
  <div id="lesson-audio-script" class="sr-only"><?= htmlspecialchars($lesson['audioScript'] ?? $lesson['summary']) ?></div>

  <!-- Lesson Content Card -->
  <article class="lesson-content-card">
    <span class="lesson-chunk-badge"><?= htmlspecialchars($lesson['badge'] ?? 'Core Lesson') ?></span>
    <h1 class="lesson-chunk-title"><?= htmlspecialchars($lesson['title']) ?></h1>

    <!-- Lesson Prose (Bionic & TTS Karaoke target) -->
    <div id="lesson-prose-container" class="lesson-prose bionic-target" data-original-html="<?= htmlspecialchars($lesson['contentHtml']) ?>">
      <?= $lesson['contentHtml'] ?>
    </div>

    <!-- "Explain Simply / TL;DR" Box -->
    <?php if (!empty($lesson['summary'])): ?>
      <div class="simple-explain-box" role="region" aria-label="Plain language summary">
        <div class="simple-explain-title">
          <span aria-hidden="true">💡</span> <span>Explain Simply (TL;DR)</span>
        </div>
        <p class="simple-explain-text">
          <?= htmlspecialchars($lesson['summary']) ?>
        </p>
      </div>
    <?php endif; ?>

    <!-- Interactive Embedded Widget Container -->
    <?php if (!empty($lesson['widgetType'])): ?>
      <div id="embedded-widget-container" class="widget-container" data-widget-type="<?= htmlspecialchars($lesson['widgetType']) ?>" role="region" aria-label="Interactive Learning Widget">
        <!-- Rendered via JS -->
      </div>
    <?php endif; ?>

    <!-- Active Recall Flashcards Section -->
    <?php if (!empty($lesson['flashcards'])): ?>
      <div id="flashcards-container" class="flashcards-section" data-flashcards='<?= json_encode($lesson['flashcards']) ?>'>
        <!-- Flashcards rendered via JS -->
      </div>
    <?php endif; ?>

    <!-- Low-Stress Knowledge Check Quiz -->
    <?php if (!empty($lesson['quiz'])): ?>
      <div id="lesson-quiz-container" class="quiz-container" data-quiz='<?= json_encode($lesson['quiz']) ?>' data-lesson-id="<?= htmlspecialchars($lesson['id']) ?>" role="region" aria-label="Low stress knowledge check">
        <!-- Quiz rendered via JS -->
      </div>
    <?php endif; ?>

    <!-- Lesson Navigation Footer -->
    <div class="lesson-footer-bar">
      <?php if ($prevLesson): ?>
        <a href="lesson.php?grade=<?= urlencode($gradeId) ?>&subject=<?= urlencode($subjectId) ?>&id=<?= urlencode($prevLesson['id']) ?>" class="btn btn-secondary">
          ◀ Previous: <?= htmlspecialchars($prevLesson['title']) ?>
        </a>
      <?php else: ?>
        <a href="grade.php?level=<?= urlencode($gradeId) ?>&tab=<?= urlencode($subjectId) ?>" class="btn btn-secondary">
          ◀ Back to <?= htmlspecialchars($subject['title']) ?>
        </a>
      <?php endif; ?>

      <?php if ($nextLesson): ?>
        <a href="lesson.php?grade=<?= urlencode($gradeId) ?>&subject=<?= urlencode($subjectId) ?>&id=<?= urlencode($nextLesson['id']) ?>" class="btn btn-primary">
          Next Lesson: <?= htmlspecialchars($nextLesson['title']) ?> ➔
        </a>
      <?php else: ?>
        <a href="grade.php?level=<?= urlencode($gradeId) ?>" class="btn btn-primary">
          Complete Subject & Back to <?= htmlspecialchars($grade['title']) ?> 🎉
        </a>
      <?php endif; ?>
    </div>
  </article>
</div>

<!-- Auto-Initialize Lesson Interactive Components on Page Load -->
<script type="module">
  import { WidgetManager } from './js/interactive-widgets.js';

  document.addEventListener('DOMContentLoaded', () => {
    const a11y = window.hestensApp?.a11y;
    const widgetMgr = new WidgetManager(a11y);

    // Render Widget
    const widgetBox = document.getElementById('embedded-widget-container');
    if (widgetBox && widgetBox.dataset.widgetType) {
      widgetMgr.renderWidget(widgetBox, widgetBox.dataset.widgetType);
    }

    // Render Flashcards
    const fcBox = document.getElementById('flashcards-container');
    if (fcBox && fcBox.dataset.flashcards) {
      try {
        const cards = JSON.parse(fcBox.dataset.flashcards);
        renderFlashcardsUI(cards, fcBox);
      } catch (e) {
        console.error('Error parsing flashcards JSON', e);
      }
    }

    // Render Quiz
    const quizBox = document.getElementById('lesson-quiz-container');
    if (quizBox && quizBox.dataset.quiz) {
      try {
        const quizData = JSON.parse(quizBox.dataset.quiz);
        const lessonId = quizBox.dataset.lessonId;
        renderQuizUI(quizData, lessonId, quizBox);
      } catch (e) {
        console.error('Error parsing quiz JSON', e);
      }
    }

    function renderFlashcardsUI(cards, container) {
      if (!cards || cards.length === 0) return;
      let cardIdx = 0;

      const render = () => {
        const card = cards[cardIdx];
        container.innerHTML = `
          <div class="widget-title">💡 Active Recall Flashcard (${cardIdx + 1} of ${cards.length})</div>
          <div class="flashcard-wrapper">
            <div class="flashcard" id="active-flashcard" role="button" tabindex="0" aria-label="Flashcard. Click or press space to flip">
              <div id="flashcard-face" style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                ${card.front}
              </div>
              <div class="flashcard-hint">🔄 Click or press Space to flip</div>
            </div>
          </div>
          <div style="display: flex; justify-content: center; gap: 1rem; margin-top: 1rem;">
            <button class="btn btn-secondary" id="fc-prev" ${cardIdx === 0 ? 'disabled style="opacity:0.5"' : ''}>◀ Previous</button>
            <button class="btn btn-secondary" id="fc-next" ${cardIdx === cards.length - 1 ? 'disabled style="opacity:0.5"' : ''}>Next ▶</button>
          </div>
        `;

        let flipped = false;
        const cardEl = container.querySelector('#active-flashcard');
        const faceEl = container.querySelector('#flashcard-face');

        const toggle = () => {
          flipped = !flipped;
          faceEl.textContent = flipped ? card.back : card.front;
          faceEl.style.color = flipped ? 'var(--accent-primary)' : 'var(--text-primary)';
          cardEl.style.borderColor = flipped ? 'var(--accent-primary)' : 'var(--border-subtle)';
          if (a11y) a11y.playChime('click');
        };

        cardEl.addEventListener('click', toggle);
        cardEl.addEventListener('keydown', (e) => {
          if (e.key === ' ' || e.key === 'Enter') {
            e.preventDefault();
            toggle();
          }
        });

        container.querySelector('#fc-prev').addEventListener('click', () => {
          if (cardIdx > 0) { cardIdx--; render(); }
        });
        container.querySelector('#fc-next').addEventListener('click', () => {
          if (cardIdx < cards.length - 1) { cardIdx++; render(); }
        });
      };
      render();
    }

    function renderQuizUI(quizData, lessonId, container) {
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
        <div id="lesson-quiz-feedback" class="quiz-feedback"></div>
      `;

      const options = container.querySelectorAll('.quiz-option');
      const feedbackBox = container.querySelector('#lesson-quiz-feedback');

      options.forEach(opt => {
        opt.addEventListener('click', () => {
          const choice = quizData.options[parseInt(opt.dataset.idx, 10)];
          options.forEach(o => o.className = 'quiz-option');

          if (choice.correct) {
            opt.classList.add('correct');
            feedbackBox.textContent = `🌟 ${choice.feedback}`;
            feedbackBox.className = 'quiz-feedback show correct';
            if (a11y) a11y.playChime('celebrate');

            // Save completed lesson
            const completed = new Set(JSON.parse(localStorage.getItem('hestens_completed_lessons') || '[]'));
            completed.add(lessonId);
            localStorage.setItem('hestens_completed_lessons', JSON.stringify([...completed]));
          } else {
            opt.classList.add('incorrect');
            feedbackBox.textContent = `💡 Hint: ${choice.feedback}`;
            feedbackBox.className = 'quiz-feedback show encouraging';
            if (a11y) a11y.playChime('click');
          }
        });
      });
    }
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
