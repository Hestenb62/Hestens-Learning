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
$allGrades = get_all_grades();
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="<?= ($currentTheme === 'dark' || $currentTheme === 'contrast') ? 'dark' : 'light' ?>" <?= ($currentTheme !== 'dark') ? 'data-theme="' . htmlspecialchars($currentTheme) . '"' : '' ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <!-- Google Fonts: Lexend, Atkinson Hyperlegible, Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Inter:wght@400;600;700;800&family=Lexend:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS (Local Distribution) -->
  <link rel="stylesheet" href="includes/bootstrap/css/bootstrap.min.css">

  <!-- Core Design System & Component CSS -->
  <link rel="stylesheet" href="css/design-system.css">
  <link rel="stylesheet" href="css/components.css">
</head>
<body data-font="<?= htmlspecialchars($currentFont) ?>" class="d-flex flex-column min-vh-100">

  <!-- WCAG Skip to Content Link -->
  <a href="#main-content" class="skip-link">Skip to Main Content (Press Enter)</a>

  <!-- ARIA Live Region for Screen Readers -->
  <div id="a11y-announcer" class="visually-hidden" aria-live="polite" aria-atomic="true"></div>

  <!-- Universal Application Header using Bootstrap 5 Navbar -->
  <header class="sticky-top app-header-wrapper" role="banner">
    <nav class="navbar navbar-expand-lg border-bottom app-navbar shadow-sm" aria-label="Primary Navigation">
      <div class="container-fluid px-3 px-lg-4">
        <!-- Brand -->
        <a href="index.php" class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" aria-label="Hestens Learning Home">
          <div class="brand-icon" aria-hidden="true">HL</div>
          <div class="brand-text d-flex flex-column">
            <span class="brand-title fw-bold fs-5 lh-1">Hestens Learning</span>
            <small class="brand-subtext" style="font-size: 0.72rem; font-weight: 500;">E-Learning Built for Diverse Minds</small>
          </div>
        </a>

        <!-- Mobile Navbar Toggler -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation menu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Collapsible Menu -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Primary Nav Links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 ps-lg-2">
            <li class="nav-item">
              <a href="index.php" class="nav-link px-3 rounded-pill <?= ($activePage === 'home') ? 'active fw-bold' : '' ?>" aria-current="<?= ($activePage === 'home') ? 'page' : 'false' ?>">
                <span aria-hidden="true">🏠</span> Home
              </a>
            </li>

            <!-- Grades Dropdown Menu -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle px-3 rounded-pill <?= ($activePage === 'grades') ? 'active fw-bold' : '' ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span aria-hidden="true">📚</span> Grades
              </a>
              <ul class="dropdown-menu shadow-sm">
                <li><h6 class="dropdown-header">Elementary (Pre-K - 5th)</h6></li>
                <li><a class="dropdown-item" href="grade.php?level=pre-k">🌱 Pre-K</a></li>
                <li><a class="dropdown-item" href="grade.php?level=kindergarten">🖍️ Kindergarten</a></li>
                <li><a class="dropdown-item" href="grade.php?level=1st">⭐ 1st Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=2nd">🚀 2nd Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=3rd">🔍 3rd Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=4th">⚡ 4th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=5th">🧭 5th Grade</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">Middle School (6th - 8th)</h6></li>
                <li><a class="dropdown-item" href="grade.php?level=6th">🔬 6th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=7th">🪐 7th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=8th">🧬 8th Grade</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><h6 class="dropdown-header">High School (9th - 12th)</h6></li>
                <li><a class="dropdown-item" href="grade.php?level=9th">📐 9th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=10th">💡 10th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=11th">🏛️ 11th Grade</a></li>
                <li><a class="dropdown-item" href="grade.php?level=12th">🎓 12th Grade</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="assessment.php" class="nav-link px-3 rounded-pill <?= ($activePage === 'assessment') ? 'active fw-bold' : '' ?>">
                <span aria-hidden="true">🎯</span> Assessment
              </a>
            </li>

            <li class="nav-item">
              <a href="profile.php" class="nav-link px-3 rounded-pill <?= ($activePage === 'profile') ? 'active fw-bold' : '' ?>">
                <span aria-hidden="true">📁</span> My Binder
              </a>
            </li>

            <li class="nav-item">
              <a href="about.php" class="nav-link px-3 rounded-pill <?= ($activePage === 'about') ? 'active fw-bold' : '' ?>">
                <span aria-hidden="true">💡</span> About
              </a>
            </li>
          </ul>

          <!-- Header Search Bar -->
          <form action="search.php" method="GET" class="d-flex my-2 my-lg-0 me-lg-3" role="search">
            <div class="input-group input-group-sm">
              <input class="form-control rounded-start-pill ps-3" type="search" name="q" placeholder="Search lessons, topics..." aria-label="Search lessons and topics">
              <button class="btn btn-primary rounded-end-pill px-3" type="submit" aria-label="Submit search">
                <span aria-hidden="true">🔍</span>
              </button>
            </div>
          </form>

          <!-- User Profile Pill -->
          <div class="d-flex align-items-center">
            <a href="profile.php" class="btn btn-outline-secondary btn-sm rounded-pill d-flex align-items-center gap-2 px-3 py-1" aria-label="Student Profile and Accommodations">
              <span class="fs-6" aria-hidden="true">🎓</span>
              <span class="fw-semibold" id="header-user-name">Learner</span>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <!-- Main Landmark Anchor -->
  <main id="main-content" class="main-content flex-grow-1" role="main">
