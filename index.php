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

<div class="container py-4">
  <!-- ================= HERO SECTION ================= -->
  <section class="hero-banner p-4 p-md-5 mb-5 rounded-4 shadow-sm border position-relative overflow-hidden" aria-labelledby="hero-title-text">
    <div class="hero-text position-relative" style="z-index: 1;">
      <div class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-3 py-2 mb-3 d-inline-flex align-items-center gap-2 fs-6">
        <span aria-hidden="true">✨</span> Neurodiversity-First & Accessible Learning
      </div>
      <h1 id="hero-title-text" class="display-5 fw-bolder mb-3 text-body">
        Education Tailored to How Your Brain Learns Best.
      </h1>
      <p class="lead text-body-secondary mb-4" style="max-width: 780px;">
        Explore Pre-K through 12th Grade curriculum designed with OpenDyslexic typography, visual stress tints, text-to-speech audio, and zero-stress pacing.
      </p>

      <!-- Hero Action Buttons -->
      <div class="d-flex flex-wrap gap-3 mb-4">
        <a href="assessment.php" class="btn btn-primary btn-lg px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm" aria-label="Start Diagnostic Assessment">
          <span>🎯</span> <span>Get Started (Diagnostic Assessment)</span>
        </a>
        <a href="about.php" class="btn btn-secondary btn-lg px-4 py-2 d-inline-flex align-items-center gap-2" aria-label="Learn more About Us">
          <span>💡</span> <span>About Our Mission</span>
        </a>
      </div>

      <!-- Quick Stats & Accommodations highlights -->
      <div class="d-flex flex-wrap gap-2 pt-2">
        <div class="badge rounded-pill bg-body-secondary text-body-secondary border px-3 py-2 fs-6 d-inline-flex align-items-center gap-2">
          <span aria-hidden="true">🌱</span>
          <span>Pre-K to 12th Grade</span>
        </div>
        <div class="badge rounded-pill bg-body-secondary text-body-secondary border px-3 py-2 fs-6 d-inline-flex align-items-center gap-2">
          <span aria-hidden="true">🔤</span>
          <span>OpenDyslexic & Bionic Reading</span>
        </div>
        <div class="badge rounded-pill bg-body-secondary text-body-secondary border px-3 py-2 fs-6 d-inline-flex align-items-center gap-2">
          <span aria-hidden="true">🎧</span>
          <span>Karaoke Audio Narrator</span>
        </div>
        <div class="badge rounded-pill bg-body-secondary text-body-secondary border px-3 py-2 fs-6 d-inline-flex align-items-center gap-2">
          <span aria-hidden="true">🎨</span>
          <span>Meares-Irlen Tint Support</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ================= GRADE LEVEL CURRICULUM SECTION ================= -->
  <section class="grades-section mb-5" aria-labelledby="grades-heading">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-4 pb-2 border-bottom">
      <div>
        <h2 id="grades-heading" class="h2 fw-bold text-body mb-1">Explore Curriculum by Learning Tier</h2>
        <p class="text-body-secondary mb-0">
          Complete multi-sensory curriculum for <strong>Math</strong>, <strong>ELA</strong>, <strong>Science</strong>, and <strong>Social Studies</strong> across all grade levels.
        </p>
      </div>

      <!-- Tier Filter Tabs (Bootstrap Buttons) -->
      <div class="btn-group filter-tabs shadow-sm" role="tablist" aria-label="Filter grade levels">
        <button class="btn btn-outline-secondary filter-tab active px-3 py-2" data-filter="all" role="tab" aria-selected="true">All Tiers</button>
        <button class="btn btn-outline-secondary filter-tab px-3 py-2" data-filter="elementary" role="tab" aria-selected="false">Elementary</button>
        <button class="btn btn-outline-secondary filter-tab px-3 py-2" data-filter="middle" role="tab" aria-selected="false">Middle School</button>
        <button class="btn btn-outline-secondary filter-tab px-3 py-2" data-filter="high" role="tab" aria-selected="false">High School</button>
      </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 grade-cards-grid">
      <?php foreach ($allGrades as $gradeId => $grade): ?>
        <?php
        $cardTier = ($grade['tier'] === 'early' || $grade['tier'] === 'elementary') ? 'elementary' : $grade['tier'];
        ?>
        <div class="col grade-card tier-<?= htmlspecialchars($cardTier) ?>" data-tier="<?= htmlspecialchars($cardTier) ?>">
          <article class="card h-100 shadow-sm border-0 overflow-hidden" data-href="grade.php?level=<?= urlencode($gradeId) ?>" aria-labelledby="card-title-<?= $gradeId ?>" style="cursor: pointer;" onclick="if(!event.target.closest('a')){ document.cookie='hestens_selected_grade=<?= urlencode($gradeId) ?>; path=/; max-age=86400'; sessionStorage.setItem('hestens_selected_grade', '<?= urlencode($gradeId) ?>'); window.location.href='grade.php?level=<?= urlencode($gradeId) ?>'; }">
            <div class="card-header border-0 aurora-card-<?= htmlspecialchars($cardTier) ?> p-4 position-relative">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="badge rounded-pill bg-light text-dark fw-bold px-3 py-1"><?= htmlspecialchars($grade['title']) ?></span>
                <span class="badge rounded-pill bg-dark-subtle text-light px-2 py-1 small">4 Core Subjects</span>
              </div>
              <div class="grade-icon-large display-4 mb-2" aria-hidden="true"><?= $grade['icon'] ?></div>
              <h3 id="card-title-<?= $gradeId ?>" class="h4 fw-bold text-white mb-1"><?= htmlspecialchars($grade['title']) ?></h3>
              <p class="text-white-50 small mb-0"><?= htmlspecialchars($grade['fullName']) ?></p>
            </div>

            <div class="card-body d-flex flex-column p-4">
              <p class="text-body-secondary small mb-3 flex-grow-1"><?= htmlspecialchars($grade['description']) ?></p>

              <div class="d-flex flex-wrap gap-1 mb-4">
                <?php foreach ($grade['subjects'] as $subKey => $sub): ?>
                  <span class="badge rounded-pill bg-body-secondary text-body-secondary border px-2 py-1 small" title="<?= htmlspecialchars($sub['title']) ?>">
                    <?= $sub['icon'] ?> <?= htmlspecialchars($sub['title']) ?>
                  </span>
                <?php endforeach; ?>
              </div>

              <div class="mt-auto pt-2">
                <a href="grade.php?level=<?= urlencode($gradeId) ?>" class="btn btn-primary w-100 py-2 d-flex align-items-center justify-content-center gap-2" aria-label="Open <?= htmlspecialchars($grade['title']) ?> Curriculum" onclick="document.cookie='hestens_selected_grade=<?= urlencode($gradeId) ?>; path=/; max-age=86400'; sessionStorage.setItem('hestens_selected_grade', '<?= urlencode($gradeId) ?>');">
                  <span>Explore <?= htmlspecialchars($grade['title']) ?></span> <span>➔</span>
                </a>
              </div>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ================= DIAGNOSTIC ASSESSMENT PROMO BANNER ================= -->
  <section class="card bg-body-tertiary border shadow-sm p-4 p-md-5 my-5 rounded-4" aria-labelledby="promo-title">
    <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
      <div class="d-flex align-items-start gap-3">
        <div class="display-5" aria-hidden="true">🎯</div>
        <div>
          <h3 id="promo-title" class="h3 fw-bold text-body mb-2">
            Unsure which grade or lesson to begin with?
          </h3>
          <p class="text-body-secondary mb-0" style="max-width: 680px;">
            Take our gentle, low-stress diagnostic assessment. In 5 minutes, we'll discover your student's unique strengths and provide a <strong>customized downloadable report (.txt)</strong> with personalized recommendations.
          </p>
        </div>
      </div>
      <a href="assessment.php" class="btn btn-primary btn-lg text-nowrap px-4 py-3 shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
        <span>Take Diagnostic Assessment</span> <span>➔</span>
      </a>
    </div>
  </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>