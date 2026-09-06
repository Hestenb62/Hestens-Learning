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

<div class="container py-4">
  <!-- Breadcrumbs Navigation -->
  <nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($grade['title']) ?></li>
    </ol>
  </nav>

  <!-- Grade Header Hero with Aurora Mesh -->
  <?php 
    $tierMeshClass = ($grade['tier'] === 'early' || $grade['tier'] === 'elementary') ? 'aurora-mesh-elementary' : 'aurora-mesh-' . htmlspecialchars($grade['tier']); 
  ?>
  <section class="grade-hero-banner <?= $tierMeshClass ?> p-4 p-md-5 rounded-4 mb-4 text-white shadow-sm d-flex flex-column flex-md-row align-items-center gap-4" aria-labelledby="grade-page-title">
    <div class="grade-hero-icon display-2" aria-hidden="true"><?= $grade['icon'] ?></div>
    <div class="grade-hero-content text-center text-md-start">
      <div class="badge rounded-pill bg-dark bg-opacity-50 text-white border border-white border-opacity-25 px-3 py-1 mb-2">
        <?= ucfirst($grade['tier']) ?> Learning Tier
      </div>
      <h1 id="grade-page-title" class="display-6 fw-bold mb-2 text-white"><?= htmlspecialchars($grade['fullName']) ?></h1>
      <p class="lead mb-0 text-white-50" style="max-width: 720px;"><?= htmlspecialchars($grade['description']) ?></p>
    </div>
  </section>

  <!-- Subject Tabs & Lesson Directory -->
  <section class="grade-curriculum-container mb-5" aria-labelledby="subjects-heading">
    <h2 id="subjects-heading" class="visually-hidden"><?= htmlspecialchars($grade['title']) ?> Subjects</h2>

    <!-- 4 Subject Tabs using Bootstrap nav-pills -->
    <ul class="nav nav-pills nav-fill gap-2 p-2 bg-body-tertiary border rounded-3 mb-4" role="tablist" aria-label="<?= htmlspecialchars($grade['title']) ?> Subject Areas">
      <?php foreach ($grade['subjects'] as $subKey => $subject): ?>
        <?php $isSelected = ($subKey === $activeTab); ?>
        <li class="nav-item" role="presentation">
          <button 
            class="nav-link subject-tab-btn d-flex align-items-center justify-content-center gap-2 py-2 px-3 <?= $isSelected ? 'active' : '' ?>" 
            data-subject="<?= $subKey ?>" 
            role="tab" 
            aria-selected="<?= $isSelected ? 'true' : 'false' ?>"
            aria-controls="subject-panel-<?= $subKey ?>"
            id="tab-<?= $subKey ?>"
          >
            <span aria-hidden="true"><?= $subject['icon'] ?></span>
            <span class="fw-bold"><?= htmlspecialchars(get_subject_display_name($subKey, $subject['title'])) ?></span>
            <?php if (!empty($subject['lessons'])): ?>
              <span class="badge rounded-pill bg-body-secondary text-body-secondary ms-1"><?= count($subject['lessons']) ?></span>
            <?php endif; ?>
          </button>
        </li>
      <?php endforeach; ?>
    </ul>

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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-4 pb-2 border-bottom">
          <div>
            <h3 class="h4 fw-bold text-body mb-1">
              <span aria-hidden="true"><?= $subject['icon'] ?></span> <?= htmlspecialchars($subject['title']) ?>
            </h3>
            <p class="text-body-secondary mb-0"><?= htmlspecialchars($subject['description']) ?></p>
          </div>
          <div class="badge rounded-pill bg-info-subtle text-info border border-info-subtle px-3 py-2">
            <span>📖 <?= count($subject['lessons']) ?> Interactive Lesson<?= count($subject['lessons']) === 1 ? '' : 's' ?></span>
          </div>
        </div>

        <!-- Lessons Grid -->
        <?php if (!empty($subject['lessons'])): ?>
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach ($subject['lessons'] as $idx => $lesson): ?>
              <div class="col">
                <article class="card h-100 shadow-sm border p-3 d-flex flex-column lesson-card-item" data-lesson-id="<?= htmlspecialchars($lesson['id']) ?>">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"><?= htmlspecialchars($lesson['badge']) ?></span>
                    <span class="small text-body-secondary">⏱️ <?= htmlspecialchars($lesson['time'] ?? '8 min') ?></span>
                  </div>
                  <h4 class="h5 fw-bold text-body mb-2"><?= htmlspecialchars($lesson['title']) ?></h4>
                  <p class="small text-body-secondary flex-grow-1 mb-3"><?= htmlspecialchars($lesson['summary']) ?></p>
                  
                  <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                    <span class="badge bg-secondary-subtle text-body-secondary" id="status-<?= htmlspecialchars($lesson['id']) ?>">Ready to Start</span>
                    <a href="lesson.php?grade=<?= urlencode($gradeId) ?>&subject=<?= urlencode($subKey) ?>&id=<?= urlencode($lesson['id']) ?>" class="btn btn-sm btn-primary" aria-label="Start lesson: <?= htmlspecialchars($lesson['title']) ?>">
                      Start Lesson ➔
                    </a>
                  </div>
                </article>
              </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <!-- Accessible Placeholder when lessons are expanding -->
          <div class="card bg-body-tertiary border text-center p-5 rounded-4">
            <div class="display-3 mb-3">🌱</div>
            <h4 class="fw-bold text-body">Curriculum Module in Active Expansion</h4>
            <p class="text-body-secondary mx-auto mb-4" style="max-width: 500px;">
              We are actively adapting this <?= htmlspecialchars($subject['title']) ?> module with multi-sensory interactive widgets. Check back soon or explore our foundational lessons!
            </p>
            <div>
              <a href="index.php" class="btn btn-secondary">Explore Other Grades</a>
            </div>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </section>
</div>

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
        tag.classList.remove('bg-secondary-subtle');
        tag.classList.add('bg-success', 'text-white');
      }
    });
  });
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>
