<?php
/**
 * Hestens Learning - About Us & Mission (about.php)
 */
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'About Us & Universal Design | Hestens Learning';
$pageDescription = 'Our mission to revolutionize e-learning for students with dyslexia, ADHD, autism, and diverse learning differences.';
$activePage = 'about';

include __DIR__ . '/includes/header.php';
?>

<div class="container py-4">
  <!-- Hero Section -->
  <section class="hero-banner p-4 p-md-5 mb-5 rounded-4 border shadow-sm text-center" aria-labelledby="about-hero-title">
    <div class="mx-auto" style="max-width: 800px;">
      <div class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-3 py-2 mb-3 d-inline-flex align-items-center gap-2 fs-6">
        <span>💡</span> <span>Our Core Mission</span>
      </div>
      <h1 id="about-hero-title" class="display-5 fw-bold text-body mb-3">Education Designed for How Diverse Brains Actually Work.</h1>
      <p class="lead text-body-secondary mb-0">
        Traditional educational platforms often assume every student processes text and numbers in the exact same way. Hestens Learning was built to dismantle barriers through multi-modal pedagogy, neurodiversity affirmation, and universal accessibility.
      </p>
    </div>
  </section>

  <!-- Core Pillars Grid -->
  <section class="mb-5" aria-labelledby="pillars-heading">
    <h2 id="pillars-heading" class="visually-hidden">Our Core Pillars</h2>

    <div class="row g-4">
      <div class="col-12 col-md-6">
        <article class="card h-100 p-4 border rounded-4 shadow-sm">
          <div class="display-4 mb-3" aria-hidden="true">🔤</div>
          <h3 class="h4 fw-bold text-body mb-2">Dyslexia-First Typography</h3>
          <p class="text-body-secondary mb-0 lh-base">
            We integrate genuine OpenDyslexic typography with weighted bottoms to anchor characters and reduce letter rotation/flipping. Combined with bionic fixations and custom line spacing, readers experience smoother tracking and reduced visual fatigue.
          </p>
        </article>
      </div>

      <div class="col-12 col-md-6">
        <article class="card h-100 p-4 border rounded-4 shadow-sm">
          <div class="display-4 mb-3" aria-hidden="true">🎨</div>
          <h3 class="h4 fw-bold text-body mb-2">Meares-Irlen & Sensory Tints</h3>
          <p class="text-body-secondary mb-0 lh-base">
            High-contrast white backgrounds often cause glare and visual distortion for neurodivergent learners. We provide scientifically designed warm sepia (amber), sage green, and calming blue themes to eliminate visual stress.
          </p>
        </article>
      </div>

      <div class="col-12 col-md-6">
        <article class="card h-100 p-4 border rounded-4 shadow-sm">
          <div class="display-4 mb-3" aria-hidden="true">🧩</div>
          <h3 class="h4 fw-bold text-body mb-2">Cognitive Chunking & ADHD Pacing</h3>
          <p class="text-body-secondary mb-0 lh-base">
            Walls of text trigger executive overwhelm. Every concept is broken into 5–10 minute micro-lessons with tactile interactive simulators, plain-language summaries ("Explain Simply"), and zero stressful timers.
          </p>
        </article>
      </div>

      <div class="col-12 col-md-6">
        <article class="card h-100 p-4 border rounded-4 shadow-sm">
          <div class="display-4 mb-3" aria-hidden="true">♿</div>
          <h3 class="h4 fw-bold text-body mb-2">Universal Design for Learning (UDL)</h3>
          <p class="text-body-secondary mb-0 lh-base">
            Information is delivered across three modalities: Visual (diagrams & simulations), Auditory (synchronized text-to-speech narration), and Kinesthetic (drag-and-drop & active recall flashcards).
          </p>
        </article>
      </div>
    </div>
  </section>

  <!-- Commitment to Open Accessibility -->
  <section class="card border rounded-4 p-4 p-md-5 shadow-sm mb-4">
    <h2 class="h3 fw-bold text-body mb-3">WCAG 2.2 AAA Compliance Statement</h2>
    <p class="lead text-body-secondary mb-4" style="max-width: 850px;">
      Hestens Learning complies with the highest standards of digital accessibility, including full keyboard navigation, high-contrast states exceeding 7:1 color contrast, screen reader live regions, and assistive reading guides.
    </p>
    <div>
      <a href="assessment.php" class="btn btn-primary btn-lg shadow-sm">Take Diagnostic Assessment ➔</a>
    </div>
  </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
