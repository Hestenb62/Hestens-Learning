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

<div class="container py-4">
  <!-- Breadcrumbs -->
  <nav aria-label="breadcrumb" class="mb-3">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item"><a href="grade.php?level=<?= urlencode($gradeId) ?>" class="text-decoration-none"><?= htmlspecialchars($grade['title']) ?></a></li>
      <li class="breadcrumb-item"><a href="grade.php?level=<?= urlencode($gradeId) ?>&tab=<?= urlencode($subjectId) ?>" class="text-decoration-none"><?= htmlspecialchars($subject['title']) ?></a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($lesson['title']) ?></li>
    </ol>
  </nav>

  <div class="lesson-view-wrapper">
    <!-- Lesson Header & Audio Narrator Bar -->
    <div class="card bg-body-tertiary border p-3 mb-4 rounded-3 shadow-sm">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 pb-3 border-bottom mb-3">
        <a href="grade.php?level=<?= urlencode($gradeId) ?>&tab=<?= urlencode($subjectId) ?>" class="btn btn-sm btn-secondary d-inline-flex align-items-center gap-2" aria-label="Return to <?= htmlspecialchars($subject['title']) ?> curriculum">
          <span>◀</span> <span>Back to <?= htmlspecialchars($subject['title']) ?></span>
        </a>
        <div class="text-md-end">
          <h2 class="h5 fw-bold text-body mb-0"><?= htmlspecialchars($grade['title']) ?> • <?= htmlspecialchars($subject['title']) ?></h2>
          <span class="small text-body-secondary">Interactive Step-by-Step Lesson</span>
        </div>
      </div>

      <!-- Audio Controls & Hotkeys Tip -->
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div class="d-flex align-items-center gap-2">
          <button class="btn btn-sm btn-primary tts-toggle-btn d-inline-flex align-items-center gap-2 shadow-sm" id="tts-lesson-btn" aria-label="Listen to this lesson read aloud (Alt+S)">
            <span aria-hidden="true">🔊</span> <span>Listen (Aloud)</span>
          </button>
          <div class="d-flex align-items-center gap-1">
            <label for="tts-speed-select" class="small fw-bold text-body-secondary me-1">Speed:</label>
            <select id="tts-speed-select" class="form-select form-select-sm" style="width: auto;" aria-label="Adjust voice reading rate">
              <option value="0.75">0.75x (Relaxed)</option>
              <option value="1.0" selected>1.0x (Normal)</option>
              <option value="1.25">1.25x (Brisk)</option>
              <option value="1.5">1.5x (Fast)</option>
            </select>
          </div>
        </div>
        <span class="small text-body-secondary">
          💡 Press <kbd class="badge bg-body-secondary text-body-secondary border">Alt+R</kbd> for Reading Ruler or <kbd class="badge bg-body-secondary text-body-secondary border">Alt+Z</kbd> for Zen Mode
        </span>
      </div>
    </div>

    <!-- Hidden Audio Transcript for Web Speech TTS -->
    <div id="lesson-audio-script" class="visually-hidden"><?= htmlspecialchars($lesson['audioScript'] ?? $lesson['summary']) ?></div>

    <!-- Lesson Content Card -->
    <article class="card p-4 p-md-5 border rounded-4 shadow-sm mb-4">
      <div>
        <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 mb-3"><?= htmlspecialchars($lesson['badge'] ?? 'Core Lesson') ?></span>
      </div>
      <h1 class="display-6 fw-bold text-body mb-4"><?= htmlspecialchars($lesson['title']) ?></h1>

      <!-- Lesson Prose (Bionic & TTS Karaoke target) -->
      <div id="lesson-prose-container" class="lesson-prose bionic-target fs-5 lh-lg mb-4" data-original-html="<?= htmlspecialchars($lesson['contentHtml']) ?>">
        <?= $lesson['contentHtml'] ?>
      </div>

      <!-- "Explain Simply / TL;DR" Box -->
      <?php if (!empty($lesson['summary'])): ?>
        <div class="card bg-info-subtle border-info-subtle p-3 my-4 rounded-3" role="region" aria-label="Plain language summary">
          <div class="d-flex align-items-center gap-2 fw-bold text-info-emphasis mb-2">
            <span aria-hidden="true">💡</span> <span>Explain Simply (TL;DR)</span>
          </div>
          <p class="text-body mb-0">
            <?= htmlspecialchars($lesson['summary']) ?>
          </p>
        </div>
      <?php endif; ?>

      <!-- Interactive Embedded Widget Container -->
      <?php if (!empty($lesson['widgetType'])): ?>
        <div id="embedded-widget-container" class="widget-container my-4" data-widget-type="<?= htmlspecialchars($lesson['widgetType']) ?>" role="region" aria-label="Interactive Learning Widget">
          <!-- Rendered via JS -->
        </div>
      <?php endif; ?>

      <!-- Active Recall Flashcards Section -->
      <?php if (!empty($lesson['flashcards'])): ?>
        <div id="flashcards-container" class="flashcards-section my-4" data-flashcards='<?= json_encode($lesson['flashcards']) ?>'>
          <!-- Flashcards rendered via JS -->
        </div>
      <?php endif; ?>

      <!-- Low-Stress Knowledge Check Quiz -->
      <?php if (!empty($lesson['quiz'])): ?>
        <div id="lesson-quiz-container" class="quiz-container my-4" data-quiz='<?= json_encode($lesson['quiz']) ?>' data-lesson-id="<?= htmlspecialchars($lesson['id']) ?>" role="region" aria-label="Low stress knowledge check">
          <!-- Quiz rendered via JS -->
        </div>
      <?php endif; ?>

      <!-- Lesson Navigation Footer -->
      <div class="d-flex justify-content-between align-items-center gap-3 pt-4 border-top mt-5 flex-wrap">
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
</div>

<!-- Auto-Initialize Lesson Interactive Components on Page Load -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const a11y = window.hestensApp ? window.hestensApp.a11y : new window.A11yEngine();
    const widgetMgr = new window.WidgetManager(a11y);

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
