<?php
/**
 * Hestens Learning - Curriculum Search Page (search.php)
 */
require_once __DIR__ . '/includes/helpers.php';

$query = $_GET['q'] ?? '';
$results = search_curriculum($query);

$pageTitle = 'Search Results for "' . htmlspecialchars($query) . '" | Hestens Learning';
$pageDescription = 'Search accessible lessons, topics, and subjects across Pre-K to 12th grade.';
$activePage = 'search';

include __DIR__ . '/includes/header.php';
?>

<div class="search-page-container">
  <div class="section-header" style="margin-bottom: 2rem;">
    <div>
      <h1 class="section-title">
        <?= empty($query) ? 'Search Curriculum' : 'Search Results for "' . htmlspecialchars($query) . '"' ?>
      </h1>
      <p style="color:var(--text-secondary); margin-top:0.25rem;">
        Found <?= count($results) ?> matching lesson<?= count($results) === 1 ? '' : 's' ?> and subject<?= count($results) === 1 ? '' : 's' ?> across Pre-K through 12th Grade.
      </p>
    </div>
  </div>

  <?php if (!empty($results)): ?>
    <div class="search-results-list">
      <?php foreach ($results as $item): ?>
        <article class="search-result-card">
          <div class="result-icon-box"><?= $item['icon'] ?></div>
          <div class="result-info">
            <div class="result-tags">
              <span class="card-pill"><?= htmlspecialchars($item['grade']) ?></span>
              <?php if (isset($item['subject'])): ?>
                <span class="card-pill"><?= htmlspecialchars($item['subject']) ?></span>
              <?php endif; ?>
            </div>
            <h2 class="result-title">
              <a href="<?= htmlspecialchars($item['url']) ?>"><?= htmlspecialchars($item['title']) ?></a>
            </h2>
            <p class="result-snippet"><?= htmlspecialchars($item['snippet']) ?></p>
          </div>
          <a href="<?= htmlspecialchars($item['url']) ?>" class="btn btn-primary" style="align-self:center;">
            Open ➔
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-search-box">
      <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
      <h2 style="font-size: 1.4rem; font-weight: 800;">No matching lessons found for "<?= htmlspecialchars($query) ?>"</h2>
      <p style="color:var(--text-secondary); max-width: 500px; margin: 0.5rem auto 1.5rem;">
        Try searching for broader keywords like <em>Math</em>, <em>Fractions</em>, <em>Phonics</em>, <em>Space</em>, <em>Science</em>, or <em>Budget</em>.
      </p>
      <a href="index.php" class="btn btn-primary">Browse All Grades</a>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
