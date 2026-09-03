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
      <h2 id="grades-heading" class="section-title">Explore Curriculum by Learning Tier</h2>
      <p style="color:var(--text-secondary); margin-top:0.25rem;">
        Complete multi-sensory curriculum for <strong>Math</strong>, <strong>ELA</strong>, <strong>Science</strong>, and <strong>Social Studies</strong> across all grade levels.
      </p>
    </div>

    <!-- Tier Filter Tabs -->
    <div class="filter-tabs" role="tablist" aria-label="Filter grade levels">
      <button class="filter-tab active" data-filter="all" role="tab" aria-selected="true">All Tiers</button>
      <button class="filter-tab" data-filter="elementary" role="tab" aria-selected="false">Elementary (Pre-K - 5th)</button>
      <button class="filter-tab" data-filter="middle" role="tab" aria-selected="false">Middle School (6th - 8th)</button>
      <button class="filter-tab" data-filter="high" role="tab" aria-selected="false">High School (9th - 12th)</button>
    </div>
  </div>

  <!-- CLUSTER 1: Elementary School (Pre-K to 5th) -->
  <div class="tier-cluster-block tier-elementary-cluster" data-tier-cluster="elementary">
    <div class="tier-cluster-header aurora-mesh-elementary">
      <div class="tier-cluster-icon">🎒</div>
      <div class="tier-cluster-info">
        <span class="cluster-badge">Foundational Tier</span>
        <h3 class="tier-cluster-title">Early & Elementary Learning (Pre-K – 5th Grade)</h3>
        <p class="tier-cluster-desc">Sensory counting, phonemic awareness, visual arithmetic, place values, and discovery science.</p>
      </div>
    </div>
    <div class="grade-cards-grid">
      <?php foreach ($allGrades as $gradeId => $grade): ?>
        <?php if ($grade['tier'] === 'early' || $grade['tier'] === 'elementary'): ?>
          <article class="grade-card tier-elementary" data-tier="elementary" aria-labelledby="card-title-<?= $gradeId ?>">
            <div class="grade-card-header aurora-card-elementary">
              <div class="grade-badge-row">
                <span class="grade-pill"><?= htmlspecialchars($grade['title']) ?></span>
                <span class="grade-pill">4 Core Subjects</span>
              </div>
              <div class="grade-icon-large"><?= $grade['icon'] ?></div>
              <h4 id="card-title-<?= $gradeId ?>" class="grade-card-title"><?= htmlspecialchars($grade['title']) ?></h4>
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
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- CLUSTER 2: Middle School (6th to 8th) -->
  <div class="tier-cluster-block tier-middle-cluster" data-tier-cluster="middle" style="margin-top: 3rem;">
    <div class="tier-cluster-header aurora-mesh-middle">
      <div class="tier-cluster-icon">🔬</div>
      <div class="tier-cluster-info">
        <span class="cluster-badge" style="background:rgba(245,158,11,0.25); color:#f59e0b;">Intermediate Tier</span>
        <h3 class="tier-cluster-title">Middle School Curriculum (6th – 8th Grade)</h3>
        <p class="tier-cluster-desc">Pre-algebra visual models, literary themes, genetics, cells, chemistry basics, and constitutional civics.</p>
      </div>
    </div>
    <div class="grade-cards-grid">
      <?php foreach ($allGrades as $gradeId => $grade): ?>
        <?php if ($grade['tier'] === 'middle'): ?>
          <article class="grade-card tier-middle" data-tier="middle" aria-labelledby="card-title-<?= $gradeId ?>">
            <div class="grade-card-header aurora-card-middle">
              <div class="grade-badge-row">
                <span class="grade-pill"><?= htmlspecialchars($grade['title']) ?></span>
                <span class="grade-pill">4 Core Subjects</span>
              </div>
              <div class="grade-icon-large"><?= $grade['icon'] ?></div>
              <h4 id="card-title-<?= $gradeId ?>" class="grade-card-title"><?= htmlspecialchars($grade['title']) ?></h4>
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
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- CLUSTER 3: High School (9th to 12th) -->
  <div class="tier-cluster-block tier-high-cluster" data-tier-cluster="high" style="margin-top: 3rem;">
    <div class="tier-cluster-header aurora-mesh-high">
      <div class="tier-cluster-icon">🎓</div>
      <div class="tier-cluster-info">
        <span class="cluster-badge" style="background:rgba(99,102,241,0.25); color:#818cf8;">Advanced Tier</span>
        <h3 class="tier-cluster-title">High School Curriculum (9th – 12th Grade)</h3>
        <p class="tier-cluster-desc">Practical financial mastery, algebra & geometry, astrophysics, rhetoric, ecology, and modern economics.</p>
      </div>
    </div>
    <div class="grade-cards-grid">
      <?php foreach ($allGrades as $gradeId => $grade): ?>
        <?php if ($grade['tier'] === 'high'): ?>
          <article class="grade-card tier-high" data-tier="high" aria-labelledby="card-title-<?= $gradeId ?>">
            <div class="grade-card-header aurora-card-high">
              <div class="grade-badge-row">
                <span class="grade-pill"><?= htmlspecialchars($grade['title']) ?></span>
                <span class="grade-pill">4 Core Subjects</span>
              </div>
              <div class="grade-icon-large"><?= $grade['icon'] ?></div>
              <h4 id="card-title-<?= $gradeId ?>" class="grade-card-title"><?= htmlspecialchars($grade['title']) ?></h4>
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
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
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
