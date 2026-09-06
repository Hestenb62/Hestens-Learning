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

<div class="container py-4">
  <div class="pb-3 border-bottom mb-4">
    <h1 class="h2 fw-bold text-body mb-1">
      <?= empty($query) ? 'Search Curriculum' : 'Search Results for "' . htmlspecialchars($query) . '"' ?>
    </h1>
    <p class="text-body-secondary mb-0">
      Found <?= count($results) ?> matching lesson<?= count($results) === 1 ? '' : 's' ?> and subject<?= count($results) === 1 ? '' : 's' ?> across Pre-K through 12th Grade.
    </p>
  </div>

  <!-- In-page Search Bar -->
  <form action="search.php" method="GET" class="mb-5 mx-auto" style="max-width: 680px;" role="search">
    <div class="input-group input-group-lg shadow-sm">
      <input type="search" name="q" value="<?= htmlspecialchars($query) ?>" class="form-control rounded-start-pill ps-4" placeholder="Search lessons, topics, or subjects..." aria-label="Search curriculum">
      <button class="btn btn-primary rounded-end-pill px-4 fw-bold" type="submit">
        Search 🔍
      </button>
    </div>
  </form>

  <?php if (!empty($results)): ?>
    <div class="d-flex flex-column gap-3 mb-5">
      <?php foreach ($results as $item): ?>
        <article class="card border rounded-4 p-4 shadow-sm">
          <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-start gap-3">
              <div class="display-6" aria-hidden="true"><?= $item['icon'] ?></div>
              <div>
                <div class="d-flex flex-wrap gap-1 mb-2">
                  <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle"><?= htmlspecialchars($item['grade']) ?></span>
                  <?php if (isset($item['subject'])): ?>
                    <span class="badge rounded-pill bg-secondary-subtle text-body-secondary border"><?= htmlspecialchars($item['subject']) ?></span>
                  <?php endif; ?>
                </div>
                <h2 class="h5 fw-bold mb-1">
                  <a href="<?= htmlspecialchars($item['url']) ?>" class="text-decoration-none text-body"><?= htmlspecialchars($item['title']) ?></a>
                </h2>
                <p class="text-body-secondary small mb-0"><?= htmlspecialchars($item['snippet']) ?></p>
              </div>
            </div>
            <div class="text-md-end pt-2 pt-md-0">
              <a href="<?= htmlspecialchars($item['url']) ?>" class="btn btn-primary text-nowrap px-4 py-2">
                Open Lesson ➔
              </a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="card bg-body-tertiary border text-center p-5 rounded-4 mx-auto" style="max-width: 650px;">
      <div class="display-3 mb-3" aria-hidden="true">🔍</div>
      <h2 class="h4 fw-bold text-body mb-2">No matching lessons found for "<?= htmlspecialchars($query) ?>"</h2>
      <p class="text-body-secondary mx-auto mb-4" style="max-width: 480px;">
        Try searching for broader keywords like <em>Math</em>, <em>Fractions</em>, <em>Phonics</em>, <em>Space</em>, <em>Science</em>, or <em>Budget</em>.
      </p>
      <div>
        <a href="index.php" class="btn btn-primary px-4 py-2">Browse All Grades</a>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
