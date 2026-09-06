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

<div class="container py-4">
  <!-- Step 1: Assessment Setup Screen -->
  <section id="assessment-setup-step" class="card border rounded-4 shadow-sm p-4 p-md-5 mb-5 mx-auto text-center" style="max-width: 820px;" aria-labelledby="setup-heading">
    <div class="mb-4">
      <div class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-3 py-2 mb-3 d-inline-flex align-items-center gap-2 fs-6">
        <span>🎯</span> <span>Low-Stress Diagnostic Tool</span>
      </div>
      <h1 id="setup-heading" class="display-6 fw-bold text-body mb-3">Discover Where to Begin Your Learning Journey</h1>
      <p class="lead text-body-secondary mx-auto" style="max-width: 650px;">
        This gentle check helps us find your student's unique strengths and learning accommodations. There are no timers, no penalties, and questions can be listened to aloud.
      </p>
    </div>

    <div class="row g-3 text-start justify-content-center my-3">
      <!-- Select Grade Tier -->
      <div class="col-12 col-md-6">
        <label for="tier-select" class="form-label fw-bold small text-body-secondary">1. Choose Grade Band:</label>
        <select id="tier-select" class="form-select form-select-lg" aria-label="Select Grade Level Band">
          <?php foreach ($assessmentData['gradeTiers'] as $tier): ?>
            <option value="<?= htmlspecialchars($tier['id']) ?>" <?= ($tier['id'] === 'elementary') ? 'selected' : '' ?>>
              <?= $tier['icon'] ?> <?= htmlspecialchars($tier['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Select Subject -->
      <div class="col-12 col-md-6">
        <label for="subject-select" class="form-label fw-bold small text-body-secondary">2. Focus Subject:</label>
        <select id="subject-select" class="form-select form-select-lg" aria-label="Select Assessment Subject">
          <?php foreach ($assessmentData['subjects'] as $sub): ?>
            <option value="<?= htmlspecialchars($sub['id']) ?>">
              <?= $sub['icon'] ?> <?= htmlspecialchars($sub['title']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <!-- Student Name (Optional for Report) -->
    <div class="text-start mx-auto my-3" style="max-width: 500px;">
      <label for="student-name-input" class="form-label fw-bold small text-body-secondary">
        Student Name / Nickname (For your personalized report):
      </label>
      <input 
        type="text" 
        id="student-name-input" 
        class="form-control form-control-lg" 
        placeholder="e.g. Alex"
      >
    </div>

    <div class="pt-3">
      <button id="start-assessment-btn" class="btn btn-primary btn-lg px-5 py-3 shadow-sm d-inline-flex align-items-center gap-2">
        <span>🚀</span> <span>Begin Diagnostic Check</span>
      </button>
    </div>
  </section>

  <!-- Step 2: Interactive Question Player -->
  <section id="assessment-quiz-step" class="card border rounded-4 shadow-sm p-4 p-md-5 mb-5 mx-auto" style="display:none; max-width: 820px;" aria-live="polite">
    <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-4">
      <div id="quiz-progress-text" class="fw-bold text-primary fs-5">Question 1 of 5</div>
      <button id="listen-question-btn" class="btn btn-sm btn-secondary d-inline-flex align-items-center gap-2" aria-label="Listen to question audio">
        <span>🔊</span> <span>Listen Aloud</span>
      </button>
    </div>

    <div id="active-question-body" class="my-4">
      <!-- Populated dynamically -->
    </div>

    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-4">
      <button id="quiz-prev-btn" class="btn btn-secondary" style="display:none;">◀ Previous</button>
      <button id="quiz-next-btn" class="btn btn-primary ms-auto" disabled>Next Question ➔</button>
    </div>
  </section>

  <!-- Step 3: Diagnostic Results & Downloadable Report Screen -->
  <section id="assessment-results-step" class="card border rounded-4 shadow-sm p-4 p-md-5 mb-5 mx-auto text-center" style="display:none; max-width: 860px;" aria-live="polite">
    <div class="mb-4">
      <div class="display-3 mb-2" aria-hidden="true">🌟</div>
      <div class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 mb-3 d-inline-flex align-items-center gap-2 fs-6">
        Diagnostic Completed!
      </div>
      <h2 id="result-student-title" class="display-6 fw-bold text-body mb-2">
        Great job, Alex! Here is Your Learning Profile
      </h2>
      <p class="lead text-body-secondary mx-auto mb-4" style="max-width: 620px;">
        We analyzed your responses to create a customized starting roadmap tailored to your cognitive strengths.
      </p>
    </div>

    <!-- Summary Highlights Cards -->
    <div class="row g-3 text-start my-4">
      <div class="col-12 col-md-4">
        <div class="card bg-body-tertiary border p-3 h-100 rounded-3">
          <span class="small text-body-secondary fw-bold">Recommended Grade</span>
          <span id="summary-rec-grade" class="h5 fw-bold text-body mt-2 mb-0">1st Grade (Elementary)</span>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card bg-body-tertiary border p-3 h-100 rounded-3">
          <span class="small text-body-secondary fw-bold">Key Strengths</span>
          <span id="summary-strengths" class="h5 fw-bold text-success mt-2 mb-0">Visual Patterns & Phonics</span>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="card bg-body-tertiary border p-3 h-100 rounded-3">
          <span class="small text-body-secondary fw-bold">Optimal Format</span>
          <span class="h5 fw-bold text-primary mt-2 mb-0">Multi-Sensory (OpenDyslexic + Audio)</span>
        </div>
      </div>
    </div>

    <!-- Download Detailed Report Action -->
    <div class="card bg-body-tertiary border p-4 text-start rounded-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
      <div>
        <h3 class="h5 fw-bold text-body mb-1">
          📥 Download Detailed Learning Plan & Profile (.txt)
        </h3>
        <p class="small text-body-secondary mb-0" style="max-width: 520px;">
          Includes a full breakdown of skill scores, recommended accommodations (visual tints, OpenDyslexic, bionic reading), and a step-by-step curriculum schedule for parents & educators.
        </p>
      </div>
      <button id="download-report-btn" class="btn btn-primary text-nowrap px-4 py-2 shadow-sm d-inline-flex align-items-center gap-2">
        <span>📄</span> <span>Download Report (.txt)</span>
      </button>
    </div>

    <!-- Next Actions -->
    <div class="d-flex gap-3 justify-content-center flex-wrap pt-2">
      <a id="rec-grade-link" href="grade.php?level=1st" class="btn btn-primary btn-lg shadow-sm">
        Go to Recommended Grade Curriculum ➔
      </a>
      <a href="index.php" class="btn btn-secondary btn-lg">
        Explore All Grades
      </a>
    </div>
  </section>
</div>

<!-- Assessment Script Logic (Universal Wasmer Edge Compatible) -->
<script src="js/assessment-engine.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    window.assessmentEngine = new window.AssessmentEngine(<?= json_encode($assessmentData) ?>);
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
