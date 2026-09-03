<?php
/**
 * Hestens Learning - Universal Application Footer & Resource Center
 */
?>
  </main> <!-- End of #main-content -->

  <!-- Accessible Resource-Rich Footer -->
  <footer class="app-footer" role="contentinfo">
    <div class="footer-container">
      <div class="footer-grid">
        <!-- Column 1: Brand & Philosophy -->
        <div class="footer-col brand-col">
          <div class="brand-wrapper">
            <div class="brand-icon">HL</div>
            <div class="brand-text">
              <strong style="font-size:1.15rem; color:var(--text-primary);">Hestens Learning</strong>
              <p>Designed by and for students with learning differences.</p>
            </div>
          </div>
          <p class="footer-mission-text">
            Centering neurodiversity, dyslexia, ADHD, and sensory processing differences through multi-modal education and Universal Design for Learning (UDL).
          </p>
          <div class="footer-a11y-badge">
            <span>♿</span> <span>WCAG 2.2 AAA Compliant</span>
          </div>
        </div>

        <!-- Column 2: Neurodiversity & Support Resources -->
        <div class="footer-col">
          <h3 class="footer-col-title">Neurodiversity & A11y Resources</h3>
          <ul class="footer-link-list">
            <li><a href="https://dyslexiaida.org/" target="_blank" rel="noopener noreferrer">International Dyslexia Association (IDA) ↗</a></li>
            <li><a href="https://chadd.org/" target="_blank" rel="noopener noreferrer">CHADD (ADHD Support & Advocacy) ↗</a></li>
            <li><a href="https://www.understood.org/" target="_blank" rel="noopener noreferrer">Understood.org (Learning Differences) ↗</a></li>
            <li><a href="https://irlen.com/" target="_blank" rel="noopener noreferrer">Irlen Institute (Visual Stress & Glare) ↗</a></li>
            <li><a href="https://www.w3.org/WAI/" target="_blank" rel="noopener noreferrer">W3C Web Accessibility Initiative (WAI) ↗</a></li>
            <li><a href="https://opendyslexic.org/" target="_blank" rel="noopener noreferrer">OpenDyslexic Font Project ↗</a></li>
          </ul>
        </div>

        <!-- Column 3: Quick Grade Curriculum Jump -->
        <div class="footer-col">
          <h3 class="footer-col-title">Grade Levels (Pre-K - 12th)</h3>
          <div class="footer-grade-links">
            <a href="grade.php?level=pre-k" class="footer-pill">Pre-K</a>
            <a href="grade.php?level=kindergarten" class="footer-pill">Kindergarten</a>
            <a href="grade.php?level=1st" class="footer-pill">1st Grade</a>
            <a href="grade.php?level=2nd" class="footer-pill">2nd Grade</a>
            <a href="grade.php?level=3rd" class="footer-pill">3rd Grade</a>
            <a href="grade.php?level=4th" class="footer-pill">4th Grade</a>
            <a href="grade.php?level=5th" class="footer-pill">5th Grade</a>
            <a href="grade.php?level=6th" class="footer-pill">6th Grade</a>
            <a href="grade.php?level=7th" class="footer-pill">7th Grade</a>
            <a href="grade.php?level=8th" class="footer-pill">8th Grade</a>
            <a href="grade.php?level=9th" class="footer-pill">9th Grade</a>
            <a href="grade.php?level=10th" class="footer-pill">10th Grade</a>
            <a href="grade.php?level=11th" class="footer-pill">11th Grade</a>
            <a href="grade.php?level=12th" class="footer-pill">12th Grade</a>
          </div>
        </div>

        <!-- Column 4: Platform Navigation & Hotkeys -->
        <div class="footer-col">
          <h3 class="footer-col-title">Platform & Tools</h3>
          <ul class="footer-link-list">
            <li><a href="assessment.php">🎯 Diagnostic Assessment</a></li>
            <li><a href="profile.php">📁 Student Binder & Progress</a></li>
            <li><a href="about.php">💡 Mission & Methodology</a></li>
            <li><a href="settings.php">⚙️ Site Settings & Data</a></li>
            <li><a href="javascript:void(0)" onclick="document.getElementById('shortcuts-modal').classList.add('open')">⌨️ Keyboard Shortcuts (?)</a></li>
          </ul>
        </div>
      </div>

      <div class="footer-bottom-row">
        <p>&copy; <?= date('Y') ?> Hestens Learning. Built with love for curious, creative minds everywhere.</p>
        <div class="footer-bottom-links">
          <a href="about.php">Accessibility Statement</a>
          <span>•</span>
          <a href="settings.php">Privacy & Storage</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Include Accessibility FAB & Accommodations Overlay -->
  <?php include __DIR__ . '/a11y-fab.php'; ?>

  <!-- Universal Application Scripts (Wasmer Edge / WebAssembly Compatible) -->
  <script src="js/a11y-engine.js"></script>
  <script src="js/interactive-widgets.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
