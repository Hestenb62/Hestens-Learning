<?php
/**
 * Hestens Learning - Universal Application Footer & Resource Center
 */
?>
  </main> <!-- End of #main-content -->

  <!-- Accessible Resource-Rich Footer with Bootstrap 5 Grid -->
  <footer class="app-footer border-top mt-auto py-5 bg-body-tertiary" role="contentinfo">
    <div class="container">
      <div class="row g-4">
        <!-- Column 1: Brand & Philosophy -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="d-flex align-items-center gap-2 mb-3">
            <div class="brand-icon" aria-hidden="true">HL</div>
            <div class="brand-text">
              <strong class="fs-5 text-body">Hestens Learning</strong>
              <p class="small text-body-secondary mb-0">For diverse minds everywhere.</p>
            </div>
          </div>
          <p class="small text-body-secondary mb-3 lh-base">
            Centering neurodiversity, dyslexia, ADHD, and sensory processing differences through multi-modal education and Universal Design for Learning (UDL).
          </p>
          <div class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2 d-inline-flex align-items-center gap-2">
            <span aria-hidden="true">♿</span> <span>WCAG 2.2 AAA Compliant</span>
          </div>
        </div>

        <!-- Column 2: Neurodiversity & Support Resources -->
        <div class="col-12 col-md-6 col-lg-3">
          <h3 class="fs-6 fw-bold text-body mb-3">Neurodiversity & A11y</h3>
          <ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
            <li><a href="https://dyslexiaida.org/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">International Dyslexia Association ↗</a></li>
            <li><a href="https://chadd.org/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">CHADD (ADHD Support) ↗</a></li>
            <li><a href="https://www.understood.org/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">Understood.org ↗</a></li>
            <li><a href="https://irlen.com/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">Irlen Institute (Visual Stress) ↗</a></li>
            <li><a href="https://www.w3.org/WAI/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">W3C Web Accessibility (WAI) ↗</a></li>
            <li><a href="https://opendyslexic.org/" target="_blank" rel="noopener noreferrer" class="text-decoration-none link-secondary">OpenDyslexic Font Project ↗</a></li>
          </ul>
        </div>

        <!-- Column 3: Quick Grade Curriculum Jump -->
        <div class="col-12 col-md-6 col-lg-3">
          <h3 class="fs-6 fw-bold text-body mb-3">Grade Levels (Pre-K - 12th)</h3>
          <div class="d-flex flex-wrap gap-1">
            <a href="grade.php?level=pre-k" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">Pre-K</a>
            <a href="grade.php?level=kindergarten" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">Kindergarten</a>
            <a href="grade.php?level=1st" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">1st Grade</a>
            <a href="grade.php?level=2nd" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">2nd Grade</a>
            <a href="grade.php?level=3rd" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">3rd Grade</a>
            <a href="grade.php?level=4th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">4th Grade</a>
            <a href="grade.php?level=5th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">5th Grade</a>
            <a href="grade.php?level=6th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">6th Grade</a>
            <a href="grade.php?level=7th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">7th Grade</a>
            <a href="grade.php?level=8th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">8th Grade</a>
            <a href="grade.php?level=9th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">9th Grade</a>
            <a href="grade.php?level=10th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">10th Grade</a>
            <a href="grade.php?level=11th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">11th Grade</a>
            <a href="grade.php?level=12th" class="badge rounded-pill text-decoration-none bg-body-secondary text-body-secondary px-2 py-1">12th Grade</a>
          </div>
        </div>

        <!-- Column 4: Platform Navigation & Hotkeys -->
        <div class="col-12 col-md-6 col-lg-3">
          <h3 class="fs-6 fw-bold text-body mb-3">Platform & Tools</h3>
          <ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
            <li><a href="assessment.php" class="text-decoration-none link-secondary">🎯 Diagnostic Assessment</a></li>
            <li><a href="profile.php" class="text-decoration-none link-secondary">📁 Student Binder & Progress</a></li>
            <li><a href="about.php" class="text-decoration-none link-secondary">💡 Mission & Methodology</a></li>
            <li><a href="settings.php" class="text-decoration-none link-secondary">⚙️ Site Settings & Data</a></li>
            <li><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#shortcuts-modal" class="text-decoration-none link-secondary">⌨️ Keyboard Shortcuts (?)</a></li>
          </ul>
        </div>
      </div>

      <!-- Footer Bottom Row -->
      <div class="row pt-4 mt-4 border-top text-body-secondary small align-items-center">
        <div class="col-12 col-md-6 text-center text-md-start mb-2 mb-md-0">
          &copy; <?= date('Y') ?> Hestens Learning. Built with love for curious, creative minds everywhere.
        </div>
        <div class="col-12 col-md-6 text-center text-md-end">
          <a href="about.php" class="text-decoration-none link-secondary">Accessibility Statement</a>
          <span class="mx-2">•</span>
          <a href="settings.php" class="text-decoration-none link-secondary">Privacy & Storage</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Include Accessibility FAB & Accommodations Overlay -->
  <?php include __DIR__ . '/a11y-fab.php'; ?>

  <!-- Bootstrap 5 Bundle JS (Includes Popper) -->
  <script src="includes/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Universal Application Scripts (Wasmer Edge / WebAssembly Compatible) -->
  <script src="js/a11y-engine.js"></script>
  <script src="js/interactive-widgets.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
