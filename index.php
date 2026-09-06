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

<div class="container-xxl py-4">
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

    <!-- Doubled full-width grade cards grid with unified Aurora Mesh Background -->
    <div class="row row-cols-1 g-4 grade-cards-grid">
      <?php foreach ($allGrades as $gradeId => $grade): ?>
        <?php
        $cardTier = ($grade['tier'] === 'early' || $grade['tier'] === 'elementary') ? 'elementary' : $grade['tier'];
        ?>
        <article 
          class="col-12 grade-card aurora-card-full tier-<?= htmlspecialchars($cardTier) ?> aurora-mesh-<?= htmlspecialchars($cardTier) ?> p-4 p-md-5" 
          data-tier="<?= htmlspecialchars($cardTier) ?>"
          data-href="grade.php?level=<?= urlencode($gradeId) ?>" 
          aria-labelledby="card-title-<?= $gradeId ?>" 
          tabindex="0" 
          role="region"
          style="cursor: pointer;" 
          onclick="if(!event.target.closest('a')){ document.cookie='hestens_selected_grade=<?= urlencode($gradeId) ?>; path=/; max-age=86400'; sessionStorage.setItem('hestens_selected_grade', '<?= urlencode($gradeId) ?>'); window.location.href='grade.php?level=<?= urlencode($gradeId) ?>'; }"
        >
          <div class="row g-4 align-items-center">
            <!-- Left Column: Pill Badges, Large Icon & Title -->
            <div class="col-12 col-lg-4 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                  <span class="glass-pill"><?= htmlspecialchars($grade['title']) ?></span>
                  <span class="glass-pill" style="opacity: 0.85; font-size: 0.75rem;">4 Core Subjects</span>
                </div>
                <div class="d-flex align-items-center gap-3 my-2">
                  <div class="grade-icon-large display-3 text-white" aria-hidden="true"><?= $grade['icon'] ?></div>
                  <div>
                    <h3 id="card-title-<?= $gradeId ?>" class="h2 fw-bold text-white mb-1"><?= htmlspecialchars($grade['title']) ?></h3>
                    <p class="text-white-50 fs-6 mb-0"><?= htmlspecialchars($grade['fullName']) ?></p>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <span class="badge rounded-pill bg-black bg-opacity-30 text-white border border-white border-opacity-25 px-3 py-1">
                  <?= ucfirst($grade['tier']) ?> School Curriculum
                </span>
              </div>
            </div>

            <!-- Right Column: Description, Subject Chips & Action CTA Button -->
            <div class="col-12 col-lg-8 d-flex flex-column justify-content-between">
              <div class="mb-4">
                <p class="text-white fs-5 mb-4 lh-base" style="opacity: 0.95; text-shadow: 0 1px 2px rgba(0,0,0,0.25);">
                  <?= htmlspecialchars($grade['description']) ?>
                </p>

                <div class="d-flex flex-wrap gap-2">
                  <?php foreach ($grade['subjects'] as $subKey => $sub): ?>
                    <span class="glass-chip" title="<?= htmlspecialchars($sub['title']) ?>">
                      <span aria-hidden="true"><?= $sub['icon'] ?></span>
                      <span><?= htmlspecialchars(get_subject_display_name($subKey, $sub['title'])) ?></span>
                    </span>
                  <?php endforeach; ?>
                </div>
              </div>

              <div class="d-flex justify-content-end pt-3 border-top border-white border-opacity-25">
                <a 
                  href="grade.php?level=<?= urlencode($gradeId) ?>" 
                  class="btn action-btn-explore btn-lg px-4 py-2 d-inline-flex align-items-center gap-2" 
                  aria-label="Explore <?= htmlspecialchars($grade['title']) ?> Curriculum" 
                  onclick="document.cookie='hestens_selected_grade=<?= urlencode($gradeId) ?>; path=/; max-age=86400'; sessionStorage.setItem('hestens_selected_grade', '<?= urlencode($gradeId) ?>');"
                >
                  <span>Explore <?= htmlspecialchars($grade['title']) ?> Curriculum</span>
                  <span aria-hidden="true">➔</span>
                </a>
              </div>
            </div>
          </div>
        </article>
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