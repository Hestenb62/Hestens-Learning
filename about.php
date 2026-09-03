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

<div class="about-container">
  <!-- Hero Section -->
  <section class="hero-banner" style="margin-bottom: 2.5rem;">
    <div class="hero-text">
      <span class="hero-badge">💡 Our Core Mission</span>
      <h1 class="hero-title">Education Designed for How Diverse Brains Actually Work.</h1>
      <p class="hero-subtitle">
        Traditional educational platforms often assume every student processes text and numbers in the exact same way. Hestens Learning was built to dismantle barriers through multi-modal pedagogy, neurodiversity affirmation, and universal accessibility.
      </p>
    </div>
  </section>

  <!-- Core Pillars Grid -->
  <section class="about-pillars-grid" aria-labelledby="pillars-heading">
    <h2 id="pillars-heading" class="sr-only">Our Core Pillars</h2>

    <article class="binder-card">
      <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🔤</div>
      <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem;">Dyslexia-First Typography</h3>
      <p style="color:var(--text-secondary); line-height:1.6;">
        We integrate genuine OpenDyslexic typography with weighted bottoms to anchor characters and reduce letter rotation/flipping. Combined with bionic fixations and custom line spacing, readers experience smoother tracking and reduced visual fatigue.
      </p>
    </article>

    <article class="binder-card">
      <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🎨</div>
      <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem;">Meares-Irlen & Sensory Tints</h3>
      <p style="color:var(--text-secondary); line-height:1.6;">
        High-contrast white backgrounds often cause glare and visual distortion for neurodivergent learners. We provide scientifically designed warm sepia (amber), sage green, and calming blue themes to eliminate visual stress.
      </p>
    </article>

    <article class="binder-card">
      <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🧩</div>
      <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem;">Cognitive Chunking & ADHD Pacing</h3>
      <p style="color:var(--text-secondary); line-height:1.6;">
        Walls of text trigger executive overwhelm. Every concept is broken into 5–10 minute micro-lessons with tactile interactive simulators, plain-language summaries ("Explain Simply"), and zero stressful timers.
      </p>
    </article>

    <article class="binder-card">
      <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">♿</div>
      <h3 style="font-size: 1.3rem; font-weight: 800; margin-bottom: 0.5rem;">Universal Design for Learning (UDL)</h3>
      <p style="color:var(--text-secondary); line-height:1.6;">
        Information is delivered across three modalities: Visual (diagrams & simulations), Auditory (synchronized text-to-speech narration), and Kinesthetic (drag-and-drop & active recall flashcards).
      </p>
    </article>
  </section>

  <!-- Commitment to Open Accessibility -->
  <section class="binder-card" style="margin-top: 2rem; background: var(--bg-card);">
    <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.75rem;">WCAG 2.2 AAA Compliance Statement</h2>
    <p style="color:var(--text-secondary); line-height:1.7; margin-bottom:1rem;">
      Hestens Learning complies with the highest standards of digital accessibility, including full keyboard navigation, high-contrast states exceeding 7:1 color contrast, screen reader live regions, and assistive reading guides.
    </p>
    <a href="assessment.php" class="btn btn-primary">Take Diagnostic Assessment ➔</a>
  </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
