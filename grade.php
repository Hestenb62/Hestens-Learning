<?php
/**
 * Hestens Learning - Grade Curriculum Hub (grade.php)
 */
require_once __DIR__ . '/includes/helpers.php';

// 1. Extract requested grade from $_GET, $_REQUEST, REQUEST_URI, QUERY_STRING, or Cookie
$requestedGrade = $_GET['level'] ?? $_GET['grade'] ?? $_GET['id'] ?? $_GET['g'] ?? $_REQUEST['level'] ?? $_REQUEST['grade'] ?? null;

if (!$requestedGrade && !empty($_SERVER['REQUEST_URI'])) {
    $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
    if (!empty($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $qVars);
        $requestedGrade = $qVars['level'] ?? $qVars['grade'] ?? $qVars['id'] ?? $qVars['g'] ?? null;
    }
}

if (!$requestedGrade && !empty($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $qVars);
    $requestedGrade = $qVars['level'] ?? $qVars['grade'] ?? $qVars['id'] ?? $qVars['g'] ?? null;
}

if (!$requestedGrade && !empty($_COOKIE['hestens_selected_grade'])) {
    $requestedGrade = $_COOKIE['hestens_selected_grade'];
}

$normalizedGrade = normalize_grade_id($requestedGrade);
$grade = $normalizedGrade ? get_grade($normalizedGrade) : null;

// Fallback to 1st grade only if nothing matched
if (!$grade) {
    $grade = get_grade('1st');
}

$gradeId = $grade['id'];
$allGrades = get_all_grades();

$activeTab = $_GET['tab'] ?? 'math';
if (!isset($grade['subjects'][$activeTab])) {
    $activeTab = array_key_first($grade['subjects']);
}

$pageTitle = $grade['title'] . ' Curriculum | Hestens Learning';
$pageDescription = "Explore {$grade['title']} accessible curriculum for Math, ELA, Science, and Social Studies.";
$activePage = 'grades';

include __DIR__ . '/includes/header.php';
?>

<!-- Client-side query sync safeguard (for local dev servers like FiveServer/LiveServer that strip query strings from PHP) -->
<script>
  (function() {
    const params = new URLSearchParams(window.location.search);
    const clientGrade = params.get('level') || params.get('grade') || params.get('id');
    const currentGrade = <?= json_encode($gradeId) ?>;
    
    if (clientGrade && clientGrade.toLowerCase() !== currentGrade.toLowerCase()) {
      const cookieKey = 'hestens_selected_grade=' + encodeURIComponent(clientGrade);
      if (!document.cookie.includes(cookieKey)) {
        document.cookie = cookieKey + '; path=/; max-age=86400';
        sessionStorage.setItem('hestens_selected_grade', clientGrade);
        window.location.reload();
      }
    }
  })();
</script>

<!-- Breadcrumbs & Quick Grade Switcher Navigation -->
<div class="grade-top-nav-bar">
  <nav class="breadcrumb-nav" aria-label="Breadcrumb">
    <a href="index.php">Home</a>
    <span aria-hidden="true">›</span>
    <span aria-current="page"><?= htmlspecialchars($grade['title']) ?></span>
  </nav>

  <!-- Quick Grade Switcher -->
  <div class="grade-quick-switcher" role="navigation" aria-label="Quick jump to another grade level">
    <span class="switcher-title">Jump to Grade:</span>
    <div class="switcher-pills-row">
      <?php foreach ($allGrades as $gId => $g): ?>
        <a href="grade.php?level=<?= urlencode($gId) ?>" 
           class="grade-switcher-pill <?= ($gId === $gradeId) ? 'active' : '' ?>"
           onclick="document.cookie='hestens_selected_grade=<?= urlencode($gId) ?>; path=/; max-age=86400'; sessionStorage.setItem('hestens_selected_grade', '<?= urlencode($gId) ?>');"
           title="<?= htmlspecialchars($g['fullName']) ?>"
           aria-label="<?= htmlspecialchars($g['title']) ?>">
          <?= htmlspecialchars($g['title']) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- Grade Header Hero with Aurora Mesh -->
<?php 
  $tierMeshClass = ($grade['tier'] === 'early' || $grade['tier'] === 'elementary') ? 'aurora-mesh-elementary' : 'aurora-mesh-' . htmlspecialchars($grade['tier']); 
?>
<section class="grade-hero-banner <?= $tierMeshClass ?>" aria-labelledby="grade-page-title">
  <div class="grade-hero-icon"><?= $grade['icon'] ?></div>
  <div class="grade-hero-content">
    <div class="hero-badge" style="background:rgba(0,0,0,0.3); color:#ffffff; border:1px solid rgba(255,255,255,0.2);">
      <?= ucfirst($grade['tier']) ?> Learning Tier
    </div>
    <h1 id="grade-page-title" class="grade-hero-title" style="color:#ffffff;"><?= htmlspecialchars($grade['fullName']) ?></h1>
    <p class="grade-hero-desc" style="color:rgba(255,255,255,0.9);"><?= htmlspecialchars($grade['description']) ?></p>
  </div>
</section>

<!-- Subject Tabs & Lesson Directory -->
<section class="grade-curriculum-container" aria-labelledby="subjects-heading">
  <h2 id="subjects-heading" class="sr-only"><?= htmlspecialchars($grade['title']) ?> Subjects</h2>

  <!-- 4 Subject Tabs -->
  <div class="subject-tabs-nav" role="tablist" aria-label="<?= htmlspecialchars($grade['title']) ?> Subject Areas">
    <?php foreach ($grade['subjects'] as $subKey => $subject): ?>
      <?php $isSelected = ($subKey === $activeTab); ?>
      <button 
        class="subject-tab-btn <?= $isSelected ? 'active' : '' ?>" 
        data-subject="<?= $subKey ?>" 
        role="tab" 
        aria-selected="<?= $isSelected ? 'true' : 'false' ?>"
        aria-controls="subject-panel-<?= $subKey ?>"
        id="tab-<?= $subKey ?>"
      >
        <span class="tab-icon" aria-hidden="true"><?= $subject['icon'] ?></span>
        <span class="tab-label"><?= htmlspecialchars($subject['title']) ?></span>
        <?php if (!empty($subject['lessons'])): ?>
          <span class="tab-count-badge"><?= count($subject['lessons']) ?></span>
        <?php endif; ?>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- Subject Panels -->
  <?php foreach ($grade['subjects'] as $subKey => $subject): ?>
    <?php $isSelected = ($subKey === $activeTab); ?>
    <div 
      id="subject-panel-<?= $subKey ?>" 
      class="subject-panel <?= $isSelected ? 'active' : '' ?>" 
      role="tabpanel" 
      aria-labelledby="tab-<?= $subKey ?>"
      <?= !$isSelected ? 'hidden' : '' ?>
    >
      <div class="subject-panel-header">
        <div>
          <h3 class="subject-panel-title">
            <span aria-hidden="true"><?= $subject['icon'] ?></span> <?= htmlspecialchars($subject['title']) ?>
          </h3>
          <p class="subject-panel-desc"><?= htmlspecialchars($subject['description']) ?></p>
        </div>
        <div class="subject-meta-pill">
          <span>📖 <?= count($subject['lessons']) ?> Interactive Lesson<?= count($subject['lessons']) === 1 ? '' : 's' ?></span>
        </div>
      </div>

      <!-- Lessons Grid -->
      <?php if (!empty($subject['lessons'])): ?>
        <div class="lessons-list-grid">
          <?php foreach ($subject['lessons'] as $idx => $lesson): ?>
            <article class="lesson-card-item" data-lesson-id="<?= htmlspecialchars($lesson['id']) ?>">
              <div class="lesson-card-top">
                <span class="lesson-badge"><?= htmlspecialchars($lesson['badge']) ?></span>
                <span class="lesson-time">⏱️ <?= htmlspecialchars($lesson['time'] ?? '8 min') ?></span>
              </div>
              <h4 class="lesson-card-title"><?= htmlspecialchars($lesson['title']) ?></h4>
              <p class="lesson-card-summary"><?= htmlspecialchars($lesson['summary']) ?></p>
              
              <div class="lesson-card-action">
                <span class="lesson-status-tag" id="status-<?= htmlspecialchars($lesson['id']) ?>">Ready to Start</span>
                <a href="lesson.php?grade=<?= urlencode($gradeId) ?>&subject=<?= urlencode($subKey) ?>&id=<?= urlencode($lesson['id']) ?>" class="btn btn-primary" aria-label="Start lesson: <?= htmlspecialchars($lesson['title']) ?>">
                  Start Lesson ➔
                </a>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <!-- Accessible Placeholder when lessons are expanding -->
        <div class="empty-subject-state">
          <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🌱</div>
          <h4>Curriculum Module in Active Expansion</h4>
          <p style="color:var(--text-secondary); max-width:500px; margin:0.5rem auto 1.5rem;">
            We are actively adapting this <?= htmlspecialchars($subject['title']) ?> module with multi-sensory interactive widgets. Check back soon or explore our foundational lessons!
          </p>
          <a href="index.php" class="btn btn-secondary">Explore Other Grades</a>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</section>

<!-- Subject Tab Switching Script -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.subject-tab-btn');
    const panels = document.querySelectorAll('.subject-panel');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = tab.dataset.subject;
        
        tabs.forEach(t => {
          t.classList.remove('active');
          t.setAttribute('aria-selected', 'false');
        });
        panels.forEach(p => {
          p.classList.remove('active');
          p.hidden = true;
        });

        tab.classList.add('active');
        tab.setAttribute('aria-selected', 'true');

        const activePanel = document.getElementById('subject-panel-' + target);
        if (activePanel) {
          activePanel.classList.add('active');
          activePanel.hidden = false;
        }

        // Update URL param without full reload
        const url = new URL(window.location);
        url.searchParams.set('tab', target);
        window.history.replaceState({}, '', url);

        if (window.hestensApp?.a11y) {
          window.hestensApp.a11y.playChime('click');
        }
      });
    });

    // Check completed lessons in localStorage and update tags
    const completed = JSON.parse(localStorage.getItem('hestens_completed_lessons') || '[]');
    completed.forEach(id => {
      const tag = document.getElementById('status-' + id);
      if (tag) {
        tag.textContent = '✓ Mastered';
        tag.classList.add('mastered');
      }
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
