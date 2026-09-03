<?php
/**
 * Hestens Learning - Universal Application Header
 */
require_once __DIR__ . '/helpers.php';

$currentTheme = get_user_theme();
$currentFont = get_user_font();
$pageTitle = $pageTitle ?? 'Hestens Learning | Neurodiversity-First E-Learning';
$pageDescription = $pageDescription ?? 'Accessible e-learning for students with learning differences, dyslexia, ADHD, and sensory processing needs.';
$activePage = $activePage ?? 'home';
?>
<!DOCTYPE html>
<html lang="en" <?= ($currentTheme !== 'dark') ? 'data-theme="' . htmlspecialchars($currentTheme) . '"' : '' ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <!-- Google Fonts: Lexend, Atkinson Hyperlegible, Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@400;600;700;800&family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Core Design System & Component CSS -->
  <link rel="stylesheet" href="css/design-system.css">
  <link rel="stylesheet" href="css/components.css">
</head>
<body data-font="<?= htmlspecialchars($currentFont) ?>">

  <!-- WCAG Skip to Content Link -->
  <a href="#main-content" class="skip-link">Skip to Main Content (Press Enter)</a>

  <!-- ARIA Live Region for Screen Readers -->
  <div id="a11y-announcer" class="sr-only" aria-live="polite" aria-atomic="true"></div>

  <!-- Universal Application Header -->
  <header class="app-header" role="banner">
    <a href="index.php" class="brand-wrapper" aria-label="Hestens Learning Home">
      <div class="brand-icon" aria-hidden="true">HL</div>
      <div class="brand-text">
        <div style="font-size: 1.25rem; font-weight: 800; line-height: 1.1;">Hestens Learning</div>
        <p>E-Learning Built for Diverse Minds</p>
      </div>
    </a>

    <!-- Main Navigation Actions with User Pill -->
    <nav class="header-actions" aria-label="Primary Navigation">
      <a href="index.php" class="nav-link <?= ($activePage === 'home') ? 'active' : '' ?>">
        <span>🏠</span> <span>Home</span>
      </a>

      <a href="assessment.php" class="nav-link <?= ($activePage === 'assessment') ? 'active' : '' ?>">
        <span>🎯</span> <span>Assessment</span>
      </a>

      <a href="profile.php" class="nav-link <?= ($activePage === 'profile') ? 'active' : '' ?>">
        <span>📁</span> <span>My Binder</span>
      </a>

      <!-- User Profile Pill -->
      <a href="profile.php" class="user-pill" aria-label="Student Profile & Accommodations">
        <span class="user-pill-avatar" aria-hidden="true">🎓</span>
        <span class="user-pill-name" id="header-user-name">Learner</span>
      </a>
    </nav>
  </header>

  <!-- Main Landmark Anchor -->
  <main id="main-content" class="main-content" role="main">
