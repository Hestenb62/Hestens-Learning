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

              <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 border-top border-white border-opacity-25">
                <button 
                  type="button" 
                  class="btn btn-outline-light btn-lg px-3 py-2 rounded-pill d-inline-flex align-items-center gap-2 glass-pill shadow-sm"
                  data-bs-toggle="modal" 
                  data-bs-target="#curriculumOutlineModal-<?= htmlspecialchars($gradeId) ?>" 
                  onclick="event.stopPropagation();"
                  aria-label="View <?= htmlspecialchars($grade['title']) ?> Curriculum Outline"
                >
                  <span aria-hidden="true">📋</span>
                  <span>Curriculum Outline</span>
                </button>
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

  <!-- ================= CURRICULUM OUTLINE MODALS ================= -->
  <?php foreach ($allGrades as $gradeId => $grade): ?>
    <?php
    $modalTier = ($grade['tier'] === 'early' || $grade['tier'] === 'elementary') ? 'elementary' : $grade['tier'];
    ?>
    <div class="modal fade" id="curriculumOutlineModal-<?= htmlspecialchars($gradeId) ?>" tabindex="-1" aria-labelledby="curriculumOutlineModalLabel-<?= htmlspecialchars($gradeId) ?>" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
          <!-- Modal Header with Tier Aurora Gradient -->
          <div class="modal-header aurora-card-<?= htmlspecialchars($modalTier) ?> text-white p-4 border-0">
            <div class="d-flex align-items-center gap-3">
              <div class="display-5" aria-hidden="true"><?= $grade['icon'] ?></div>
              <div>
                <div class="badge rounded-pill bg-black bg-opacity-35 text-white border border-white border-opacity-25 px-3 py-1 mb-1">
                  <?= ucfirst($grade['tier']) ?> School • 4 Core Subjects
                </div>
                <h3 class="h3 fw-bold text-white mb-0" id="curriculumOutlineModalLabel-<?= htmlspecialchars($gradeId) ?>">
                  <?= htmlspecialchars($grade['title']) ?> Curriculum Outline
                </h3>
                <p class="text-white-50 small mb-0"><?= htmlspecialchars($grade['fullName']) ?></p>
              </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close Outline Modal"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body p-4 bg-body">
            <p class="lead fs-6 text-body-secondary mb-4 pb-3 border-bottom">
              <?= htmlspecialchars($grade['description']) ?>
            </p>

            <h4 class="h6 text-uppercase fw-bold text-body-secondary mb-3">
              📚 Core Subject Standards & Learning Outline
            </h4>

            <!-- Subjects Accordion -->
            <div class="accordion accordion-flush rounded-3 border overflow-hidden mb-3" id="outlineAccordion-<?= htmlspecialchars($gradeId) ?>">
              <?php foreach ($grade['subjects'] as $subKey => $subject): ?>
                <div class="accordion-item">
                  <h5 class="accordion-header" id="heading-<?= $gradeId ?>-<?= $subKey ?>">
                    <button class="accordion-button <?= $subKey !== 'math' ? 'collapsed' : '' ?> fw-bold d-flex align-items-center gap-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $gradeId ?>-<?= $subKey ?>" aria-expanded="<?= $subKey === 'math' ? 'true' : 'false' ?>" aria-controls="collapse-<?= $gradeId ?>-<?= $subKey ?>">
                      <span class="fs-5" aria-hidden="true"><?= $subject['icon'] ?></span>
                      <span class="fs-6"><?= htmlspecialchars(get_subject_display_name($subKey, $subject['title'])) ?></span>
                      <span class="badge rounded-pill bg-body-secondary text-body-secondary ms-auto me-2">
                        <?= count($subject['lessons'] ?? []) ?> Lesson<?= count($subject['lessons'] ?? []) === 1 ? '' : 's' ?>
                      </span>
                    </button>
                  </h5>
                  <div id="collapse-<?= $gradeId ?>-<?= $subKey ?>" class="accordion-collapse collapse <?= $subKey === 'math' ? 'show' : '' ?>" aria-labelledby="heading-<?= $gradeId ?>-<?= $subKey ?>" data-bs-parent="#outlineAccordion-<?= htmlspecialchars($gradeId) ?>">
                    <div class="accordion-body bg-body-tertiary">
                      <p class="small text-body-secondary mb-3">
                        <?= htmlspecialchars($subject['description']) ?>
                      </p>

                      <?php if (!empty($subject['lessons'])): ?>
                        <div class="list-group list-group-flush rounded-3 border bg-body shadow-sm">
                          <?php foreach ($subject['lessons'] as $idx => $lesson): ?>
                            <?php $lessonStds = get_lesson_standards($lesson, $subKey, $gradeId); ?>
                            <div class="list-group-item p-3 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                              <div>
                                <div class="d-flex align-items-center gap-2 mb-1">
                                  <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle small"><?= htmlspecialchars($lesson['badge']) ?></span>
                                  <span class="small text-body-secondary">⏱️ <?= htmlspecialchars($lesson['time'] ?? '8 min') ?></span>
                                </div>
                                <h6 class="fw-bold text-body mb-1"><?= htmlspecialchars($lesson['title']) ?></h6>
                                <p class="small text-body-secondary mb-1"><?= htmlspecialchars($lesson['summary']) ?></p>
                                <?php if (!empty($lessonStds)): ?>
                                  <div class="d-flex flex-wrap gap-1 align-items-center mt-1">
                                    <?php foreach ($lessonStds as $std): ?>
                                      <span class="badge bg-body-secondary text-body-secondary border px-2 py-0 small" title="<?= htmlspecialchars($std['description']) ?>">
                                        <span class="fw-bold text-primary">🏛️ <?= htmlspecialchars($std['framework']) ?>:</span> <code class="text-body-emphasis"><?= htmlspecialchars($std['code']) ?></code>
                                      </span>
                                    <?php endforeach; ?>
                                  </div>
                                <?php endif; ?>
                              </div>
                              <div class="flex-shrink-0">
                                <a href="lesson.php?grade=<?= urlencode($gradeId) ?>&subject=<?= urlencode($subKey) ?>&id=<?= urlencode($lesson['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                  Start ➔
                                </a>
                              </div>
                            </div>
                          <?php endforeach; ?>
                        </div>
                      <?php else: ?>
                        <p class="text-body-secondary small fst-italic mb-0">Interactive lessons currently in active development.</p>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer bg-body-tertiary d-flex justify-content-between">
            <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
            <a href="grade.php?level=<?= urlencode($gradeId) ?>" class="btn btn-primary rounded-pill px-4 d-inline-flex align-items-center gap-2">
              <span>Open Full <?= htmlspecialchars($grade['title']) ?> Curriculum</span>
              <span aria-hidden="true">➔</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>

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