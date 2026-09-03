/**
 * Hestens Learning - Interactive Multi-Sensory Widgets (js/interactive-widgets.js)
 * Standalone Classic JS (Wasmer Edge / WebAssembly compatible)
 */
(function(window) {
  'use strict';

  class WidgetManager {
    constructor(a11yEngine) {
      this.a11y = a11yEngine || window.hestensApp?.a11y;
    }

    renderWidget(containerEl, widgetType) {
      if (!containerEl) return;
      containerEl.innerHTML = '';

      switch (widgetType) {
        case 'gravity-orbit':
          this.renderGravityOrbit(containerEl);
          break;
        case 'sort-planets':
          this.renderPlanetarySort(containerEl);
          break;
        case 'math-blocks-budget':
          this.renderMathBudget(containerEl);
          break;
        case 'math-discount-calc':
          this.renderDiscountCalc(containerEl);
          break;
        case 'sandwich-algorithm':
          this.renderAlgorithmSequence(containerEl);
          break;
        default:
          containerEl.innerHTML = `<p class="text-muted">Interactive demo ready for this lesson.</p>`;
      }
    }

    // --- Widget 1: Interactive Gravity Orbit Simulator ---
    renderGravityOrbit(container) {
      container.innerHTML = `
        <div class="widget-title">🪐 Interactive Orbit Balance Simulator</div>
        <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-secondary);">
          Adjust Earth's speed slider below to observe how gravity and forward momentum create a stable orbit:
        </p>
        <div style="position: relative; width: 100%; height: 260px; background: #020617; border-radius: var(--radius-md); overflow: hidden; display: flex; align-items: center; justify-content: center;">
          <div id="orbit-sun" style="width: 48px; height: 48px; background: #facc15; border-radius: 50%; box-shadow: 0 0 30px #f59e0b; z-index: 2; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">☀️</div>
          <div id="orbit-ring" style="position: absolute; width: 180px; height: 180px; border: 1.5px dashed rgba(255,255,255,0.25); border-radius: 50%; pointer-events: none;"></div>
          <div id="orbiting-planet" style="position: absolute; width: 22px; height: 22px; background: #38bdf8; border-radius: 50%; box-shadow: 0 0 12px #38bdf8; z-index: 3; display: flex; align-items: center; justify-content: center; font-size: 0.75rem;">🌍</div>
        </div>
        <div style="display: flex; gap: 1rem; align-items: center; margin-top: 1rem; flex-wrap: wrap;">
          <label for="orbit-speed-input" style="font-weight: 700; font-size: 0.9rem;">Planetary Speed:</label>
          <input type="range" id="orbit-speed-input" min="0.5" max="3" step="0.1" value="1" class="a11y-range" style="max-width: 220px;" aria-label="Adjust orbital speed">
          <span id="orbit-speed-label" style="font-weight: 700; color: var(--accent-primary);">1.0x (Stable Orbit)</span>
        </div>
      `;

      const planet = container.querySelector('#orbiting-planet');
      const ring = container.querySelector('#orbit-ring');
      const slider = container.querySelector('#orbit-speed-input');
      const label = container.querySelector('#orbit-speed-label');

      let angle = 0;
      let speed = 1.0;
      let radius = 90;

      const animateOrbit = () => {
        angle += 0.02 * speed;
        const x = Math.cos(angle) * radius;
        const y = Math.sin(angle) * radius;
        if (planet) {
          planet.style.transform = `translate(${x}px, ${y}px)`;
        }
        requestAnimationFrame(animateOrbit);
      };
      animateOrbit();

      slider.addEventListener('input', (e) => {
        speed = parseFloat(e.target.value);
        if (speed < 0.8) {
          label.textContent = `${speed.toFixed(1)}x (Too Slow - Falls toward Sun!)`;
          radius = 50;
          ring.style.width = '100px';
          ring.style.height = '100px';
        } else if (speed > 1.8) {
          label.textContent = `${speed.toFixed(1)}x (Too Fast - Flying into deep space!)`;
          radius = 120;
          ring.style.width = '240px';
          ring.style.height = '240px';
        } else {
          label.textContent = `${speed.toFixed(1)}x (Stable Orbit! Balance achieved)`;
          radius = 90;
          ring.style.width = '180px';
          ring.style.height = '180px';
        }
        if (this.a11y) this.a11y.playChime('click');
      });
    }

    // --- Widget 2: Planetary Classification Sorting ---
    renderPlanetarySort(container) {
      const items = [
        { name: "Mars 🔴", type: "rocky" },
        { name: "Jupiter 🌀", type: "gas" },
        { name: "Earth 🌍", type: "rocky" },
        { name: "Saturn 🪐", type: "gas" }
      ];

      container.innerHTML = `
        <div class="widget-title">🪐 Planet Family Organizer</div>
        <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-secondary);">
          Click any planet below to assign it to its correct celestial family:
        </p>
        <div id="planet-pool" style="display: flex; gap: 0.5rem; margin-bottom: 1rem; flex-wrap: wrap;">
          ${items.map(p => `<button class="btn btn-secondary sort-planet-btn" data-type="${p.type}" data-name="${p.name}">${p.name}</button>`).join('')}
        </div>
        <div class="sort-container">
          <div class="sort-bucket" id="rocky-bucket">
            <div class="sort-bucket-title" style="color: var(--accent-primary);">🏔️ Rocky (Terrestrial) Worlds</div>
            <div class="bucket-items"></div>
          </div>
          <div class="sort-bucket" id="gas-bucket">
            <div class="sort-bucket-title" style="color: var(--accent-secondary);">☁️ Gas & Ice Giants</div>
            <div class="bucket-items"></div>
          </div>
        </div>
        <div id="sort-feedback" class="quiz-feedback" style="margin-top: 1rem;"></div>
      `;

      const buttons = container.querySelectorAll('.sort-planet-btn');
      const rockyBucket = container.querySelector('#rocky-bucket .bucket-items');
      const gasBucket = container.querySelector('#gas-bucket .bucket-items');
      const feedback = container.querySelector('#sort-feedback');

      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          const type = btn.dataset.type;
          const targetBucket = type === 'rocky' ? rockyBucket : gasBucket;
          btn.remove();
          
          const pill = document.createElement('div');
          pill.className = 'sort-item';
          pill.textContent = btn.dataset.name;
          targetBucket.appendChild(pill);
          if (this.a11y) this.a11y.playChime('click');

          if (container.querySelectorAll('.sort-planet-btn').length === 0) {
            feedback.textContent = '🌟 Outstanding! You successfully classified all the planetary neighborhoods!';
            feedback.className = 'quiz-feedback show correct';
            if (this.a11y) this.a11y.playChime('celebrate');
          }
        });
      });
    }

    // --- Widget 3: 50/30/20 Visual Budgeting Blocks ---
    renderMathBudget(container) {
      container.innerHTML = `
        <div class="widget-title">💰 10-Block Visual Budget Builder ($1,000 Total)</div>
        <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-secondary);">
          Each colorful tile represents <strong>10% ($100)</strong> of your income. Click tiles to assign them according to the 50/30/20 rule:
        </p>
        <div class="math-counter-widget">
          <div class="math-blocks-grid" id="budget-blocks">
            ${Array.from({ length: 10 }).map((_, i) => `<div class="math-block" data-index="${i}" title="$100 Block">$100</div>`).join('')}
          </div>
          <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
            <div class="stat-chip" style="border-left: 4px solid var(--accent-primary);">Needs (50% = 5 blocks): <span id="needs-count" style="font-weight:800; margin-left:4px;">0</span></div>
            <div class="stat-chip" style="border-left: 4px solid var(--accent-secondary);">Wants (30% = 3 blocks): <span id="wants-count" style="font-weight:800; margin-left:4px;">0</span></div>
            <div class="stat-chip" style="border-left: 4px solid var(--success-color);">Savings (20% = 2 blocks): <span id="savings-count" style="font-weight:800; margin-left:4px;">0</span></div>
          </div>
          <div id="budget-feedback" class="quiz-feedback"></div>
        </div>
      `;

      const blocks = container.querySelectorAll('.math-block');
      const needsSpan = container.querySelector('#needs-count');
      const wantsSpan = container.querySelector('#wants-count');
      const savingsSpan = container.querySelector('#savings-count');
      const feedback = container.querySelector('#budget-feedback');

      const states = ['empty', 'needs', 'wants', 'savings'];
      const blockStates = Array(10).fill('empty');

      blocks.forEach((block, idx) => {
        block.addEventListener('click', () => {
          const current = states.indexOf(blockStates[idx]);
          const next = (current + 1) % states.length;
          blockStates[idx] = states[next];

          block.style.background = 
            blockStates[idx] === 'needs' ? 'var(--accent-primary)' :
            blockStates[idx] === 'wants' ? 'var(--accent-secondary)' :
            blockStates[idx] === 'savings' ? 'var(--success-color)' :
            'var(--bg-tertiary)';
          block.style.color = blockStates[idx] === 'empty' ? 'var(--text-muted)' : '#ffffff';

          const needs = blockStates.filter(s => s === 'needs').length;
          const wants = blockStates.filter(s => s === 'wants').length;
          const savings = blockStates.filter(s => s === 'savings').length;

          needsSpan.textContent = `${needs * 10}% ($${needs * 100})`;
          wantsSpan.textContent = `${wants * 10}% ($${wants * 100})`;
          savingsSpan.textContent = `${savings * 10}% ($${savings * 100})`;

          if (this.a11y) this.a11y.playChime('click');

          if (needs === 5 && wants === 3 && savings === 2) {
            feedback.textContent = '🎉 Perfect balance! Exactly 50% Needs ($500), 30% Wants ($300), and 20% Savings ($200)!';
            feedback.className = 'quiz-feedback show correct';
            if (this.a11y) this.a11y.playChime('celebrate');
          } else {
            feedback.className = 'quiz-feedback';
          }
        });
      });
    }

    // --- Widget 4: Percent Discount Slider ---
    renderDiscountCalc(container) {
      container.innerHTML = `
        <div class="widget-title">🏷️ The 10% Shift Rule Simulator</div>
        <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-secondary);">
          Choose an item price and see how shifting the decimal point instantly gives you 10% and 20%:
        </p>
        <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.25rem;">
          <label for="price-select" style="font-weight:700;">Select Item Price:</label>
          <select id="price-select" class="audio-speed-select">
            <option value="40">$40.00</option>
            <option value="60" selected>$60.00</option>
            <option value="80">$80.00</option>
            <option value="120">$120.00</option>
            <option value="250">$250.00</option>
          </select>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
          <div style="background: var(--bg-card); padding: 1.25rem; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); text-align: center;">
            <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 700;">ORIGINAL PRICE</div>
            <div id="calc-orig" style="font-size: 1.8rem; font-weight: 800; color: var(--text-primary); margin-top: 0.25rem;">$60.00</div>
          </div>
          <div style="background: var(--bg-card); padding: 1.25rem; border-radius: var(--radius-md); border: 1.5px solid var(--accent-primary); text-align: center;">
            <div style="font-size: 0.85rem; color: var(--accent-primary); font-weight: 700;">10% DISCOUNT (Shift 1 spot)</div>
            <div id="calc-10" style="font-size: 1.8rem; font-weight: 800; color: var(--accent-primary); margin-top: 0.25rem;">-$6.00</div>
          </div>
          <div style="background: var(--bg-card); padding: 1.25rem; border-radius: var(--radius-md); border: 1.5px solid var(--success-color); text-align: center;">
            <div style="font-size: 0.85rem; color: var(--success-color); font-weight: 700;">20% DISCOUNT (Double 10%)</div>
            <div id="calc-20" style="font-size: 1.8rem; font-weight: 800; color: var(--success-color); margin-top: 0.25rem;">-$12.00</div>
          </div>
        </div>
      `;

      const select = container.querySelector('#price-select');
      const origEl = container.querySelector('#calc-orig');
      const disc10El = container.querySelector('#calc-10');
      const disc20El = container.querySelector('#calc-20');

      select.addEventListener('change', (e) => {
        const val = parseFloat(e.target.value);
        origEl.textContent = `$${val.toFixed(2)}`;
        disc10El.textContent = `-$${(val * 0.1).toFixed(2)}`;
        disc20El.textContent = `-$${(val * 0.2).toFixed(2)}`;
        if (this.a11y) this.a11y.playChime('click');
      });
    }

    // --- Widget 5: Sandwich Algorithm Sequence Builder ---
    renderAlgorithmSequence(container) {
      const steps = [
        { id: 1, text: "1. Take 2 slices of bread out of the bag 🍞" },
        { id: 2, text: "2. Open the peanut butter jar 🥜" },
        { id: 3, text: "3. Spread peanut butter on one slice with a butter knife 🥄" },
        { id: 4, text: "4. Spread jelly on the second slice 🍓" },
        { id: 5, text: "5. Press both slices together! 🥪" }
      ];

      container.innerHTML = `
        <div class="widget-title">🥪 Robot Sandwich Algorithm Builder</div>
        <p style="font-size: 0.95rem; margin-bottom: 1rem; color: var(--text-secondary);">
          A robot needs exact step-by-step instructions. Click each step in proper sequential order:
        </p>
        <div id="recipe-pool" style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1rem;">
          ${[...steps].sort(() => Math.random() - 0.5).map(s => `
            <button class="btn btn-secondary step-order-btn" data-id="${s.id}" style="text-align: left; justify-content: flex-start;">
              ${s.text}
            </button>
          `).join('')}
        </div>
        <div id="recipe-result" style="background: var(--bg-card); border: 1.5px dashed var(--border-subtle); border-radius: var(--radius-md); padding: 1.25rem;">
          <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">YOUR EXECUTED ALGORITHM:</div>
          <ol id="executed-steps" style="padding-left: 1.25rem; font-weight: 600; line-height: 1.7;"></ol>
        </div>
        <div id="algorithm-feedback" class="quiz-feedback" style="margin-top: 1rem;"></div>
      `;

      const buttons = container.querySelectorAll('.step-order-btn');
      const executedList = container.querySelector('#executed-steps');
      const feedback = container.querySelector('#algorithm-feedback');
      let nextExpectedStep = 1;

      buttons.forEach(btn => {
        btn.addEventListener('click', () => {
          const id = parseInt(btn.dataset.id, 10);
          if (id === nextExpectedStep) {
            btn.remove();
            const li = document.createElement('li');
            li.textContent = btn.textContent.trim();
            li.style.color = 'var(--success-color)';
            executedList.appendChild(li);
            if (this.a11y) this.a11y.playChime('click');
            nextExpectedStep++;

            if (nextExpectedStep > steps.length) {
              feedback.textContent = '🤖 Beep boop! Sandwich successfully assembled without dropping jars! Algorithm complete.';
              feedback.className = 'quiz-feedback show correct';
              if (this.a11y) this.a11y.playChime('celebrate');
            }
          } else {
            feedback.textContent = `⚠️ Oops! The robot can't do step #${id} yet without doing step #${nextExpectedStep} first!`;
            feedback.className = 'quiz-feedback show encouraging';
          }
        });
      });
    }
  }

  // Attach globally
  window.WidgetManager = WidgetManager;
})(window);
