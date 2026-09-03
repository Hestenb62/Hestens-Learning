<?php
/**
 * Hestens Learning - Home Page (index.php)
 */
require_once __DIR__ . '/includes/helpers.php';

$pageTitle = 'Hestens Learning | Pre-K through 12th Grade Accessible E-Learning';
$pageDescription = 'Accessible curriculum for Pre-K through 12th grade designed for students with dyslexia, ADHD, autism, and learning differences.';
$activePage = 'home';
$allGrades = get_all_grades();

include __DIR__ . '/includes/header.php';
?>

<!-- ================= HERO SECTION ================= -->
<section class="hero-banner" aria-labelledby="hero-title-text">
  <div class="hero-text">
    <div class="hero-badge">
      <span aria-hidden="true">✨</span> Neurodiversity-First & Accessible Learning
    </div>
    <h1 id="hero-title-text" class="hero-title">
      Education Tailored to How Your Brain Learns Best.
    </h1>
    <p class="hero-subtitle">
      Explore Pre-K through 12th Grade curriculum designed with OpenDyslexic typography, visual stress tints, text-to-speech audio, and zero-stress pacing.
    </p>

    <!-- Hero Action Buttons -->
    <div class="hero-actions-row">
      <a href="assessment.php" class="btn btn-primary btn-lg" aria-label="Start Diagnostic Assessment">
        <span>🎯</span> <span>Get Started (Diagnostic Assessment)</span>
      </a>
      <a href="about.php" class="btn btn-secondary btn-lg" aria-label="Learn more About Us">
        <span>💡</span> <span>About Our Mission</span>
      </a>
    </div>

    <!-- Quick Stats & Accommodations highlights -->
    <div class="hero-stats">
      <div class="stat-chip">
        <span aria-hidden="true">🌱</span>
        <span>Pre-K to 12th Grade</span>
      </div>
      <div class="stat-chip">
        <span aria-hidden="true">🔤</span>
        <span>OpenDyslexic & Bionic Reading</span>
      </div>
      <div class="stat-chip">
        <span aria-hidden="true">🎧</span>
        <span>Karaoke Audio Narrator</span>
      </div>
      <div class="stat-chip">
        <span aria-hidden="true">🎨</span>
        <span>Meares-Irlen Tint Support</span>
      </div>
    </div>
  </div>
</section>

<!-- ================= GRADE LEVEL CURRICULUM SECTION ================= -->
<section class="grades-section" aria-labelledby="grades-heading">
  <div class="section-header">
    <div>
      <h2 id="grades-heading" class="section-title">Select Your Grade Level</h2>
      <p style="color:var(--text-secondary); margin-top:0.25rem;">
        Each grade includes full curricula for <strong>Math</strong>, <strong>ELA (Reading)</strong>, <strong>Science</strong>, and <strong>Social Studies</strong>.
      </p>
    </div>

    <!-- Tier Filter Tabs -->
    <div class="filter-tabs" role="tablist" aria-label="Filter grade levels">
      <button class="filter-tab active" data-filter="all" role="tab" aria-selected="true">All Grades</button>
      <button class="filter-tab" data-filter="early" role="tab" aria-selected="false">Early (Pre-K - K)</button>
      <button class="filter-tab" data-filter="elementary" role="tab" aria-selected="false">Elementary (1st - 5th)</button>
      <button class="filter-tab" data-filter="middle" role="tab" aria-selected="false">Middle (6th - 8th)</button>
      <button class="filter-tab" data-filter="high" role="tab" aria-selected="false">High School (9th - 12th)</button>
    </div>
  </div>

  <!-- 14 Grade Cards Grid (Pre-K to 12th) -->
  <div class="grade-cards-grid" id="grade-cards-container">
    <?php foreach ($allGrades as $gradeId => $grade): ?>
      <article class="grade-card" data-tier="<?= htmlspecialchars($grade['tier']) ?>" aria-labelledby="card-title-<?= $gradeId ?>">
        <div class="grade-card-header">
          <div class="grade-badge-row">
            <span class="grade-pill"><?= ucfirst($grade['tier']) ?> Tier</span>
            <span class="grade-pill">4 Core Subjects</span>
          </div>
          <div class="grade-icon-large"><?= $grade['icon'] ?></div>
          <h3 id="card-title-<?= $gradeId ?>" class="grade-card-title"><?= htmlspecialchars($grade['title']) ?></h3>
          <p class="grade-card-subtitle"><?= htmlspecialchars($grade['fullName']) ?></p>
        </div>

        <div class="grade-card-body">
          <p class="grade-card-desc"><?= htmlspecialchars($grade['description']) ?></p>
          
          <div class="grade-subjects-preview">
            <?php foreach ($grade['subjects'] as $subKey => $sub): ?>
              <span class="subject-mini-chip" title="<?= htmlspecialchars($sub['title']) ?>">
                <?= $sub['icon'] ?> <?= htmlspecialchars($sub['title']) ?>
              </span>
            <?php endforeach; ?>
          </div>

          <div class="grade-card-footer">
            <a href="grade.php?level=<?= urlencode($gradeId) ?>" class="btn btn-primary grade-launch-btn" aria-label="Open <?= htmlspecialchars($grade['title']) ?> Curriculum">
              Explore <?= htmlspecialchars($grade['title']) ?> ➔
            </a>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<!-- ================= DIAGNOSTIC ASSESSMENT PROMO BANNER ================= -->
<section class="diagnostic-promo-card" aria-labelledby="promo-title">
  <div class="promo-content">
    <div class="promo-icon" aria-hidden="true">🎯</div>
    <div>
      <h3 id="promo-title" style="font-size:1.4rem; font-weight:800; margin-bottom:0.4rem;">
        Unsure which grade or lesson to begin with?
      </h3>
      <p style="color:var(--text-secondary); max-width:650px;">
        Take our gentle, low-stress diagnostic assessment. In 5 minutes, we'll discover your student's unique strengths and provide a <strong>customized downloadable report (.txt)</strong> with personalized recommendations.
      </p>
    </div>
  </div>
  <a href="assessment.php" class="btn btn-primary" style="white-space:nowrap; padding:0.8rem 1.4rem;">
    Take Diagnostic Assessment ➔
  </a>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
