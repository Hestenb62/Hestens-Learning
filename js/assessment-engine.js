/**
 * Hestens Learning - Diagnostic Assessment Engine (js/assessment-engine.js)
 */

export class AssessmentEngine {
  constructor(assessmentData) {
    this.data = assessmentData;
    this.currentQuestions = [];
    this.currentIndex = 0;
    this.userAnswers = [];
    this.studentName = 'Learner';
    this.selectedTier = 'elementary';
    this.selectedSubject = 'all';

    this.init();
  }

  init() {
    this.bindEvents();
  }

  bindEvents() {
    const startBtn = document.getElementById('start-assessment-btn');
    const nextBtn = document.getElementById('quiz-next-btn');
    const prevBtn = document.getElementById('quiz-prev-btn');
    const listenBtn = document.getElementById('listen-question-btn');
    const downloadBtn = document.getElementById('download-report-btn');

    startBtn?.addEventListener('click', () => {
      this.selectedTier = document.getElementById('tier-select')?.value || 'elementary';
      this.selectedSubject = document.getElementById('subject-select')?.value || 'all';
      const nameVal = document.getElementById('student-name-input')?.value.trim();
      if (nameVal) this.studentName = nameVal;

      this.loadQuestions();
      if (this.currentQuestions.length === 0) {
        alert('No questions found for this specific filter. Loading elementary assessment.');
        this.currentQuestions = this.data.questions;
      }

      this.currentIndex = 0;
      this.userAnswers = [];

      document.getElementById('assessment-setup-step').style.display = 'none';
      document.getElementById('assessment-quiz-step').style.display = 'block';
      this.renderQuestion();
      if (window.hestensApp?.a11y) window.hestensApp.a11y.playChime('click');
    });

    nextBtn?.addEventListener('click', () => {
      if (this.currentIndex < this.currentQuestions.length - 1) {
        this.currentIndex++;
        this.renderQuestion();
      } else {
        this.showResults();
      }
    });

    prevBtn?.addEventListener('click', () => {
      if (this.currentIndex > 0) {
        this.currentIndex--;
        this.renderQuestion();
      }
    });

    listenBtn?.addEventListener('click', () => {
      const q = this.currentQuestions[this.currentIndex];
      if (q && window.hestensApp?.a11y) {
        window.hestensApp.a11y.speakText(q.audioPrompt || q.question);
      }
    });

    downloadBtn?.addEventListener('click', () => {
      this.generateTxtReport();
    });
  }

  loadQuestions() {
    let list = this.data.questions;
    if (this.selectedTier !== 'all') {
      list = list.filter(q => q.tier === this.selectedTier);
    }
    if (this.selectedSubject !== 'all') {
      list = list.filter(q => q.subject === this.selectedSubject);
    }
    // Fallback if specific tier/subject has fewer questions
    if (list.length === 0) {
      list = this.data.questions;
    }
    this.currentQuestions = list;
  }

  renderQuestion() {
    const q = this.currentQuestions[this.currentIndex];
    const container = document.getElementById('active-question-body');
    const progress = document.getElementById('quiz-progress-text');
    const nextBtn = document.getElementById('quiz-next-btn');
    const prevBtn = document.getElementById('quiz-prev-btn');

    if (!q || !container) return;

    progress.textContent = `Question ${this.currentIndex + 1} of ${this.currentQuestions.length}`;
    prevBtn.style.display = this.currentIndex > 0 ? 'inline-flex' : 'none';
    nextBtn.disabled = this.userAnswers[this.currentIndex] === undefined;

    const savedAnswer = this.userAnswers[this.currentIndex];

    container.innerHTML = `
      <div style="margin-bottom: 1.5rem;">
        <span class="lesson-chunk-badge">${q.subject.toUpperCase()} • ${q.tier.toUpperCase()}</span>
        <h3 style="font-size: 1.4rem; font-weight: 800; margin-top: 0.5rem; line-height: 1.3;">
          ${q.question}
        </h3>
        ${q.visual ? `<div style="font-size: 2.2rem; margin: 1rem 0; text-align: center;">${q.visual}</div>` : ''}
      </div>
      <div class="quiz-options">
        ${q.options.map((opt, i) => `
          <button class="quiz-option ${savedAnswer === i ? 'selected' : ''}" data-idx="${i}" aria-label="Option: ${opt.text}">
            <span style="display:inline-flex; width:28px; height:28px; border-radius:50%; background:var(--bg-tertiary); align-items:center; justify-content:center; font-weight:800; font-size:0.85rem;">
              ${String.fromCharCode(65 + i)}
            </span>
            <span>${opt.text}</span>
          </button>
        `).join('')}
      </div>
    `;

    container.querySelectorAll('.quiz-option').forEach(btn => {
      btn.addEventListener('click', () => {
        const choiceIdx = parseInt(btn.dataset.idx, 10);
        this.userAnswers[this.currentIndex] = choiceIdx;
        container.querySelectorAll('.quiz-option').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        nextBtn.disabled = false;
        if (window.hestensApp?.a11y) window.hestensApp.a11y.playChime('click');
      });
    });
  }

  showResults() {
    document.getElementById('assessment-quiz-step').style.display = 'none';
    const resultsStep = document.getElementById('assessment-results-step');
    resultsStep.style.display = 'block';

    const title = document.getElementById('result-student-title');
    title.textContent = `Great job, ${this.studentName}! Here is Your Learning Profile`;

    // Calculate score
    let correctCount = 0;
    this.currentQuestions.forEach((q, i) => {
      const ansIdx = this.userAnswers[i];
      if (ansIdx !== undefined && q.options[ansIdx]?.correct) {
        correctCount++;
      }
    });

    const percent = Math.round((correctCount / this.currentQuestions.length) * 100);
    const recGrade = this.determineRecommendedGrade(percent, this.selectedTier);

    document.getElementById('summary-rec-grade').textContent = recGrade.name;
    document.getElementById('rec-grade-link').href = `grade.php?level=${recGrade.slug}`;

    if (window.hestensApp?.a11y) window.hestensApp.a11y.playChime('celebrate');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  determineRecommendedGrade(percent, tier) {
    if (tier === 'early') {
      return percent >= 70 ? { name: "Kindergarten", slug: "kindergarten" } : { name: "Pre-K", slug: "pre-k" };
    } else if (tier === 'middle') {
      return percent >= 70 ? { name: "7th Grade", slug: "7th" } : { name: "6th Grade", slug: "6th" };
    } else if (tier === 'high') {
      return percent >= 70 ? { name: "11th Grade", slug: "11th" } : { name: "9th Grade", slug: "9th" };
    } else {
      // Elementary
      if (percent >= 80) return { name: "3rd Grade", slug: "3rd" };
      if (percent >= 50) return { name: "1st Grade", slug: "1st" };
      return { name: "Kindergarten", slug: "kindergarten" };
    }
  }

  generateTxtReport() {
    const dateStr = new Date().toLocaleDateString('en-US', { dateStyle: 'full' });
    let totalScore = 0;
    let skillList = [];

    this.currentQuestions.forEach((q, i) => {
      const ans = this.userAnswers[i];
      const opt = q.options[ans];
      if (opt?.correct) {
        totalScore += 10;
        skillList.push(`  [✓] Strong Mastery: ${opt.skill || q.question}`);
      } else {
        skillList.push(`  [~] Growth Opportunity: ${opt?.skill || q.question}`);
      }
    });

    const percent = Math.round((totalScore / (this.currentQuestions.length * 10)) * 100);
    const rec = this.determineRecommendedGrade(percent, this.selectedTier);

    const reportContent = `================================================================================
                    HESTENS LEARNING - DIAGNOSTIC LEARNING REPORT
                    Universal Design for Learning (UDL) Assessment
================================================================================
Student Name:        ${this.studentName}
Assessment Date:     ${dateStr}
Target Tier:         ${this.selectedTier.toUpperCase()}
Assessment Focus:    ${this.selectedSubject.toUpperCase()}
Overall Readiness:   ${percent}% Mastery
Recommended Starting Grade: ${rec.name} (https://hestenslearning.org/grade.php?level=${rec.slug})

--------------------------------------------------------------------------------
1. COGNITIVE SKILL BREAKDOWN & OBSERVATIONS
--------------------------------------------------------------------------------
${skillList.join('\n')}

--------------------------------------------------------------------------------
2. PERSONALIZED ACCESSIBILITY & ACCOMMODATIONS RECOMMENDATIONS
--------------------------------------------------------------------------------
Based on universal accessibility design for neurodivergent minds (Dyslexia, ADHD,
Autism, Meares-Irlen syndrome, and Executive Dysfunction):

[✓] Typography:
    - Recommended Font: OpenDyslexic or Lexend with 1.65x Line Height.
    - Letter Spacing: +0.02em to prevent visual crowding and character flipping.
    - Bionic Reading Guide: Enable to assist saccadic eye tracking.

[✓] Visual Comfort & Sensory Accommodation:
    - Warm Sepia / Amber Tint: Recommended for reduced visual stress / glare.
    - Sage Green or Serene Blue: Ideal for sensory overload and calm focus.
    - Reading Line Ruler: Use (Alt+R) to maintain line tracking without fatigue.

[✓] Audio & Multi-Modal Reinforcement:
    - Text-to-Speech (TTS) Karaoke Narrator: Listen at 1.0x with word highlight.
    - Voice Notes & Dictation: Enable for free-form spoken thoughts.

[✓] Executive Functioning & Pacing:
    - Chunking: Maximum 8-12 minute bite-sized lessons.
    - Focus Pomodoro: 25-minute focus intervals followed by 5-minute sensory breaks.
    - Supportive Assessments: Low-stress, non-punitive knowledge checks.

--------------------------------------------------------------------------------
3. RECOMMENDED CURRICULUM ROADMAP
--------------------------------------------------------------------------------
Step 1: Begin with ${rec.name} - Mathematics & ELA foundational micro-lessons.
Step 2: Engage with tactile interactive simulators and active recall flashcards.
Step 3: Review the 'Explain Simply (TL;DR)' summaries for instant clarity.
Step 4: Track mastered milestones in the Student Learning Binder (profile.php).

================================================================================
Generated by Hestens Learning | E-Learning Built for Diverse Minds
Website: https://hestenslearning.org | WCAG 2.2 AAA Compliant
================================================================================
`;

    // Trigger download
    const blob = new Blob([reportContent], { type: 'text/plain;charset=utf-8' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = `Hestens_Learning_Report_${this.studentName.replace(/\s+/g, '_')}.txt`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);

    if (window.hestensApp?.a11y) window.hestensApp.a11y.playChime('celebrate');
  }
}
