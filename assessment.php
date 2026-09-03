<?php
/**
 * Hestens Learning - Diagnostic Assessment Engine (assessment.php)
 * Evaluates student readiness and generates downloadable .txt learning reports
 */
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'Diagnostic Learning Assessment | Hestens Learning';
$pageDescription = 'Discover your student’s starting level with our low-stress, multi-sensory diagnostic assessment.';
$activePage = 'assessment';

$assessmentData = get_assessments_data();

include __DIR__ . '/includes/header.php';
?>

<div class="assessment-container">
  <!-- Step 1: Assessment Setup Screen -->
  <section id="assessment-setup-step" class="assessment-card" aria-labelledby="setup-heading">
    <div class="assessment-header">
      <span class="hero-badge">🎯 Low-Stress Diagnostic Tool</span>
      <h1 id="setup-heading" class="assessment-main-title">Discover Where to Begin Your Learning Journey</h1>
      <p style="color:var(--text-secondary); max-width:650px; margin:0.5rem auto 1.5rem; font-size:1.05rem;">
        This gentle check helps us find your student's unique strengths and learning accommodations. There are no timers, no penalties, and questions can be listened to aloud.
      </p>
    </div>

    <div class="setup-grid">
      <!-- Select Grade Tier -->
      <div class="setup-col">
        <label for="tier-select" class="setup-label">1. Choose Grade Band:</label>
        <select id="tier-select" class="setup-select" aria-label="Select Grade Level Band">
          <?php foreach ($assessmentData['gradeTiers'] as $tier): ?>
            <option value="<?= htmlspecialchars($tier['id']) ?>" <?= ($tier['id'] === 'elementary') ? 'selected' : '' ?>>
              <?= $tier['icon'] ?> <?= htmlspecialchars($tier['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Select Subject -->
      <div class="setup-col">
        <label for="subject-select" class="setup-label">2. Focus Subject:</label>
        <select id="subject-select" class="setup-select" aria-label="Select Assessment Subject">
          <?php foreach ($assessmentData['subjects'] as $sub): ?>
            <option value="<?= htmlspecialchars($sub['id']) ?>">
              <?= $sub['icon'] ?> <?= htmlspecialchars($sub['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <!-- Student Name (Optional for Report) -->
    <div style="max-width: 480px; margin: 1.5rem auto 2rem; text-align: left;">
      <label for="student-name-input" style="font-weight: 700; font-size: 0.95rem; display: block; margin-bottom: 0.4rem;">
        Student Name / Nickname (For your personalized report):
      </label>
      <input 
        type="text" 
        id="student-name-input" 
        class="search-input" 
        placeholder="e.g. Alex" 
        style="width: 100%; border: 1.5px solid var(--border-subtle); padding: 0.75rem 1rem;"
      >
    </div>

    <button id="start-assessment-btn" class="btn btn-primary btn-lg" style="margin: 0 auto;">
      <span>🚀</span> <span>Begin Diagnostic Check</span>
    </button>
  </section>

  <!-- Step 2: Interactive Question Player -->
  <section id="assessment-quiz-step" class="assessment-card" style="display:none;" aria-live="polite">
    <div class="quiz-nav-top">
      <div id="quiz-progress-text" style="font-weight: 700; color: var(--accent-primary);">Question 1 of 5</div>
      <button id="listen-question-btn" class="btn btn-secondary" aria-label="Listen to question audio">
        <span>🔊</span> <span>Listen Aloud</span>
      </button>
    </div>

    <div id="active-question-body" style="margin: 2rem 0;">
      <!-- Populated dynamically -->
    </div>

    <div class="quiz-nav-bottom">
      <button id="quiz-prev-btn" class="btn btn-secondary" style="display:none;">◀ Previous</button>
      <button id="quiz-next-btn" class="btn btn-primary" disabled>Next Question ➔</button>
    </div>
  </section>

  <!-- Step 3: Diagnostic Results & Downloadable Report Screen -->
  <section id="assessment-results-step" class="assessment-card" style="display:none;" aria-live="polite">
    <div class="results-header">
      <div style="font-size: 3rem; margin-bottom: 0.5rem;">🌟</div>
      <span class="hero-badge">Diagnostic Completed!</span>
      <h2 id="result-student-title" style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;">
        Great job, Alex! Here is Your Learning Profile
      </h2>
      <p style="color:var(--text-secondary); max-width:600px; margin:0 auto 1.5rem;">
        We analyzed your responses to create a customized starting roadmap tailored to your cognitive strengths.
      </p>
    </div>

    <!-- Summary Highlights Card -->
    <div class="result-summary-box">
      <div class="summary-metric">
        <span class="metric-label">Recommended Starting Grade</span>
        <span id="summary-rec-grade" class="metric-value">1st Grade (Elementary)</span>
      </div>
      <div class="summary-metric">
        <span class="metric-label">Key Strengths Identified</span>
        <span id="summary-strengths" class="metric-value" style="font-size:1.1rem; color:var(--success-color);">
          Visual Patterns, Spatial Intuition & Phonics
        </span>
      </div>
      <div class="summary-metric">
        <span class="metric-label">Optimal Learning Format</span>
        <span class="metric-value" style="font-size:1.1rem; color:var(--accent-primary);">
          Multi-Sensory (OpenDyslexic + Audio Narrator)
        </span>
      </div>
    </div>

    <!-- Download Detailed Report Action -->
    <div class="report-download-card">
      <div>
        <h3 style="font-size: 1.2rem; font-weight: 800; margin-bottom: 0.3rem;">
          📥 Download Detailed Learning Plan & Profile (.txt)
        </h3>
        <p style="font-size: 0.92rem; color: var(--text-secondary); max-width: 520px;">
          Includes a full breakdown of skill scores, recommended accommodations (visual tints, OpenDyslexic, bionic reading), and a step-by-step curriculum schedule for parents & educators.
        </p>
      </div>
      <button id="download-report-btn" class="btn btn-primary" style="padding: 0.9rem 1.5rem; font-size: 1rem;">
        <span>📄</span> <span>Download Detailed Report (.txt)</span>
      </button>
    </div>

    <!-- Next Actions -->
    <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem; flex-wrap: wrap;">
      <a id="rec-grade-link" href="grade.php?level=1st" class="btn btn-primary btn-lg">
        Go to Recommended Grade Curriculum ➔
      </a>
      <a href="index.php" class="btn btn-secondary btn-lg">
        Explore All Grades
      </a>
    </div>
  </section>
</div>

<!-- Assessment Script Logic -->
<script type="module">
  import { AssessmentEngine } from './js/assessment-engine.js';

  document.addEventListener('DOMContentLoaded', () => {
    window.assessmentEngine = new AssessmentEngine(<?= json_encode($assessmentData) ?>);
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
