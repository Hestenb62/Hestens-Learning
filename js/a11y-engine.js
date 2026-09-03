/**
 * Hestens Learning - Accessibility Engine (js/a11y-engine.js)
 * Standalone Classic JS (No ES Modules for Wasmer Edge / WebAssembly PHP compatibility)
 */
(function(window) {
  'use strict';

  class A11yEngine {
    constructor() {
      this.synth = window.speechSynthesis || null;
      this.speechUtterance = null;
      this.isSpeaking = false;
      this.audioCtx = null;
      
      // Default Preferences
      this.prefs = {
        theme: 'dark', // 'dark', 'light', 'sepia', 'calm-green', 'calm-blue', 'high-contrast'
        fontFamily: 'lexend', // 'opendyslexic', 'lexend', 'atkinson', 'sans'
        fontSizeScale: 1.0,
        lineHeight: 1.65,
        letterSpacing: 0.02,
        wordSpacing: 0.05,
        bionicReading: false,
        readingRuler: false,
        rulerHeight: 52,
        focusMask: false,
        reducedMotion: false,
        soundEffects: true,
        speechRate: 1.0,
        speechPitch: 1.0,
        zenMode: false
      };

      this.loadPreferences();
      this.initElements();
      this.initAudioContext();
      this.bindEvents();
      this.applyAllPreferences();
    }

    loadPreferences() {
      try {
        const saved = localStorage.getItem('hestens_a11y_prefs');
        if (saved) {
          this.prefs = Object.assign({}, this.prefs, JSON.parse(saved));
        }
      } catch (e) {
        console.warn('Could not load stored a11y preferences', e);
      }
    }

    savePreferences() {
      try {
        localStorage.setItem('hestens_a11y_prefs', JSON.stringify(this.prefs));
        document.cookie = `hestens_theme=${this.prefs.theme}; path=/; max-age=31536000; SameSite=Lax`;
        document.cookie = `hestens_font=${this.prefs.fontFamily}; path=/; max-age=31536000; SameSite=Lax`;
      } catch (e) {
        console.warn('Could not save a11y preferences', e);
      }
    }

    initElements() {
      // Reading Ruler
      this.rulerEl = document.getElementById('reading-ruler');
      if (!this.rulerEl) {
        this.rulerEl = document.createElement('div');
        this.rulerEl.id = 'reading-ruler';
        this.rulerEl.className = 'reading-ruler';
        this.rulerEl.setAttribute('aria-hidden', 'true');
        document.body.appendChild(this.rulerEl);
      }

      // Focus Mask
      this.maskEl = document.getElementById('focus-mask');
      if (!this.maskEl) {
        this.maskEl = document.createElement('div');
        this.maskEl.id = 'focus-mask';
        this.maskEl.className = 'focus-mask';
        this.maskEl.setAttribute('aria-hidden', 'true');
        document.body.appendChild(this.maskEl);
      }

      // Screen Reader Announcer
      this.announcerEl = document.getElementById('a11y-announcer');
      if (!this.announcerEl) {
        this.announcerEl = document.createElement('div');
        this.announcerEl.id = 'a11y-announcer';
        this.announcerEl.className = 'sr-only';
        this.announcerEl.setAttribute('aria-live', 'polite');
        this.announcerEl.setAttribute('aria-atomic', 'true');
        document.body.appendChild(this.announcerEl);
      }
    }

    initAudioContext() {
      const AudioContext = window.AudioContext || window.webkitAudioContext;
      if (AudioContext) {
        this.audioCtx = new AudioContext();
      }
    }

    playChime(type = 'success') {
      if (!this.prefs.soundEffects || !this.audioCtx) return;
      try {
        if (this.audioCtx.state === 'suspended') {
          this.audioCtx.resume();
        }
        const osc = this.audioCtx.createOscillator();
        const gain = this.audioCtx.createGain();
        osc.connect(gain);
        gain.connect(this.audioCtx.destination);

        const now = this.audioCtx.currentTime;
        if (type === 'success') {
          osc.frequency.setValueAtTime(440, now);
          osc.frequency.exponentialRampToValueAtTime(880, now + 0.15);
          gain.gain.setValueAtTime(0.12, now);
          gain.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
          osc.start(now);
          osc.stop(now + 0.25);
        } else if (type === 'click') {
          osc.frequency.setValueAtTime(320, now);
          gain.gain.setValueAtTime(0.05, now);
          gain.gain.exponentialRampToValueAtTime(0.01, now + 0.08);
          osc.start(now);
          osc.stop(now + 0.08);
        } else if (type === 'celebrate') {
          [523.25, 659.25, 783.99, 1046.50].forEach((freq, i) => {
            const subOsc = this.audioCtx.createOscillator();
            const subGain = this.audioCtx.createGain();
            subOsc.connect(subGain);
            subGain.connect(this.audioCtx.destination);
            subOsc.frequency.value = freq;
            subGain.gain.setValueAtTime(0.08, now + i * 0.08);
            subGain.gain.exponentialRampToValueAtTime(0.005, now + i * 0.08 + 0.2);
            subOsc.start(now + i * 0.08);
            subOsc.stop(now + i * 0.08 + 0.2);
          });
        }
      } catch (err) {
        console.warn('Audio feedback error', err);
      }
    }

    announce(message) {
      if (!this.announcerEl) return;
      this.announcerEl.textContent = '';
      setTimeout(() => {
        this.announcerEl.textContent = message;
      }, 50);
    }

    bindEvents() {
      // Tracking for reading ruler & focus mask
      window.addEventListener('pointermove', (e) => {
        if (this.prefs.readingRuler && this.rulerEl) {
          const topPos = e.clientY - (this.prefs.rulerHeight / 2);
          this.rulerEl.style.top = `${topPos}px`;
        }
        if (this.prefs.focusMask && this.maskEl) {
          this.maskEl.style.background = `radial-gradient(ellipse 100% 140px at 50% ${e.clientY}px, transparent 0%, var(--focus-mask-bg) 100%)`;
        }
      });

      // Global Hotkeys
      window.addEventListener('keydown', (e) => {
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
          return;
        }

        if (e.altKey && e.key.toLowerCase() === 'a') {
          e.preventDefault();
          this.toggleDrawer();
        } else if (e.altKey && e.key.toLowerCase() === 'r') {
          e.preventDefault();
          this.setReadingRuler(!this.prefs.readingRuler);
          this.announce(this.prefs.readingRuler ? 'Reading ruler activated' : 'Reading ruler turned off');
        } else if (e.altKey && e.key.toLowerCase() === 's') {
          e.preventDefault();
          this.toggleTTS();
        } else if (e.altKey && e.key.toLowerCase() === 'z') {
          e.preventDefault();
          this.setZenMode(!this.prefs.zenMode);
        } else if (e.key === '?') {
          e.preventDefault();
          const modal = document.getElementById('shortcuts-modal');
          if (modal) modal.classList.toggle('open');
        }
      });
    }

    // --- Setters ---
    setTheme(themeName) {
      this.prefs.theme = themeName;
      if (themeName === 'dark') {
        document.documentElement.removeAttribute('data-theme');
      } else {
        document.documentElement.setAttribute('data-theme', themeName);
      }
      this.savePreferences();
      this.announce(`Theme set to ${themeName}`);
    }

    setFont(fontName) {
      this.prefs.fontFamily = fontName;
      document.body.setAttribute('data-font', fontName);
      this.savePreferences();
      this.announce(`Font set to ${fontName}`);
    }

    setFontSize(scale) {
      this.prefs.fontSizeScale = parseFloat(scale);
      document.documentElement.style.setProperty('--font-size-scale', scale);
      this.savePreferences();
    }

    setLineHeight(val) {
      this.prefs.lineHeight = parseFloat(val);
      document.documentElement.style.setProperty('--font-line-height', val);
      this.savePreferences();
    }

    setLetterSpacing(val) {
      this.prefs.letterSpacing = parseFloat(val);
      document.documentElement.style.setProperty('--font-letter-spacing', `${val}em`);
      this.savePreferences();
    }

    setWordSpacing(val) {
      this.prefs.wordSpacing = parseFloat(val);
      document.documentElement.style.setProperty('--font-word-spacing', `${val}em`);
      this.savePreferences();
    }

    setReadingRuler(active) {
      this.prefs.readingRuler = !!active;
      if (this.rulerEl) {
        this.rulerEl.classList.toggle('active', this.prefs.readingRuler);
      }
      this.savePreferences();
    }

    setRulerHeight(heightPx) {
      this.prefs.rulerHeight = parseInt(heightPx, 10);
      document.documentElement.style.setProperty('--ruler-height', `${heightPx}px`);
      this.savePreferences();
    }

    setFocusMask(active) {
      this.prefs.focusMask = !!active;
      if (this.maskEl) {
        this.maskEl.classList.toggle('active', this.prefs.focusMask);
      }
      this.savePreferences();
    }

    setReducedMotion(active) {
      this.prefs.reducedMotion = !!active;
      document.body.classList.toggle('reduced-motion', this.prefs.reducedMotion);
      this.savePreferences();
    }

    setSoundEffects(active) {
      this.prefs.soundEffects = !!active;
      this.savePreferences();
    }

    setBionicReading(active) {
      this.prefs.bionicReading = !!active;
      this.refreshBionicState();
      this.savePreferences();
      this.announce(this.prefs.bionicReading ? 'Bionic reading enabled' : 'Bionic reading disabled');
    }

    setZenMode(active) {
      this.prefs.zenMode = !!active;
      document.body.classList.toggle('zen-mode', this.prefs.zenMode);
      this.savePreferences();
      this.announce(this.prefs.zenMode ? 'Zen mode enabled' : 'Zen mode exited');
    }

    applyAllPreferences() {
      this.setTheme(this.prefs.theme);
      this.setFont(this.prefs.fontFamily);
      this.setFontSize(this.prefs.fontSizeScale);
      this.setLineHeight(this.prefs.lineHeight);
      this.setLetterSpacing(this.prefs.letterSpacing);
      this.setWordSpacing(this.prefs.wordSpacing);
      this.setReadingRuler(this.prefs.readingRuler);
      this.setRulerHeight(this.prefs.rulerHeight);
      this.setFocusMask(this.prefs.focusMask);
      this.setReducedMotion(this.prefs.reducedMotion);
      this.setZenMode(this.prefs.zenMode);

      const bionicToggle = document.getElementById('toggle-bionic');
      if (bionicToggle) bionicToggle.checked = this.prefs.bionicReading;

      const rulerToggle = document.getElementById('toggle-ruler');
      if (rulerToggle) rulerToggle.checked = this.prefs.readingRuler;

      const maskToggle = document.getElementById('toggle-mask');
      if (maskToggle) maskToggle.checked = this.prefs.focusMask;

      const motionToggle = document.getElementById('toggle-motion');
      if (motionToggle) motionToggle.checked = this.prefs.reducedMotion;

      const soundToggle = document.getElementById('toggle-sound');
      if (soundToggle) soundToggle.checked = this.prefs.soundEffects;

      document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.theme === this.prefs.theme);
      });

      document.querySelectorAll('.font-btn').forEach(btn => {
        btn.classList.toggle('active', btn.dataset.font === this.prefs.fontFamily);
      });
    }

    // --- Bionic Transformer ---
    formatBionic(text) {
      return text.split(/\s+/).map(word => {
        if (!word) return '';
        const cleanLen = word.replace(/[^a-zA-Z0-9]/g, '').length;
        if (cleanLen <= 1) return word;
        const splitIndex = Math.ceil(cleanLen * 0.45);
        const boldPart = word.slice(0, splitIndex);
        const restPart = word.slice(splitIndex);
        return `<span class="bionic-word"><strong>${boldPart}</strong>${restPart}</span>`;
      }).join(' ');
    }

    refreshBionicState() {
      const targets = document.querySelectorAll('.bionic-target');
      targets.forEach(el => {
        if (!el.dataset.originalHtml) {
          el.dataset.originalHtml = el.innerHTML;
        }

        if (this.prefs.bionicReading) {
          const temp = document.createElement('div');
          temp.innerHTML = el.dataset.originalHtml;
          this.transformTextNodesToBionic(temp);
          el.innerHTML = temp.innerHTML;
        } else {
          el.innerHTML = el.dataset.originalHtml;
        }
      });
    }

    transformTextNodesToBionic(node) {
      if (node.nodeType === Node.TEXT_NODE) {
        if (node.textContent.trim().length > 0) {
          const span = document.createElement('span');
          span.innerHTML = this.formatBionic(node.textContent);
          node.parentNode.replaceChild(span, node);
        }
      } else if (node.nodeType === Node.ELEMENT_NODE) {
        if (!['SCRIPT', 'STYLE', 'BUTTON'].includes(node.tagName)) {
          Array.from(node.childNodes).forEach(child => this.transformTextNodesToBionic(child));
        }
      }
    }

    // --- Web Speech API TTS Karaoke Narrator ---
    speakText(text, containerEl) {
      if (!this.synth) {
        alert('Speech synthesis is not supported on your browser.');
        return;
      }

      this.stopTTS();

      if (containerEl) {
        this.wrapWordsWithSpans(containerEl);
      }

      this.speechUtterance = new SpeechSynthesisUtterance(text);
      this.speechUtterance.rate = this.prefs.speechRate;
      this.speechUtterance.pitch = this.prefs.speechPitch;

      const wordSpans = containerEl ? containerEl.querySelectorAll('.tts-word-span') : [];

      this.speechUtterance.onboundary = (event) => {
        if (event.name === 'word') {
          if (wordSpans.length > 0) {
            wordSpans.forEach(s => s.classList.remove('tts-current-word'));
            let currentSpan = null;
            for (let span of wordSpans) {
              const charIdx = parseInt(span.dataset.charIndex, 10);
              if (charIdx <= event.charIndex) {
                currentSpan = span;
              } else {
                break;
              }
            }
            if (currentSpan) {
              currentSpan.classList.add('tts-current-word');
              currentSpan.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
          }
        }
      };

      this.speechUtterance.onend = () => {
        this.isSpeaking = false;
        if (wordSpans.length > 0) {
          wordSpans.forEach(s => s.classList.remove('tts-current-word'));
        }
        this.updateTTSButtonUI(false);
      };

      this.speechUtterance.onerror = () => {
        this.isSpeaking = false;
        this.updateTTSButtonUI(false);
      };

      this.synth.speak(this.speechUtterance);
      this.isSpeaking = true;
      this.updateTTSButtonUI(true);
      this.playChime('click');
    }

    wrapWordsWithSpans(container) {
      const paragraphs = container.querySelectorAll('p, li, h1, h2, h3, h4');
      let globalCharIndex = 0;
      paragraphs.forEach(p => {
        const words = p.innerText.split(/(\s+)/);
        p.innerHTML = words.map(chunk => {
          if (chunk.trim().length === 0) {
            globalCharIndex += chunk.length;
            return chunk;
          }
          const span = `<span class="tts-word-span" data-char-index="${globalCharIndex}">${chunk}</span>`;
          globalCharIndex += chunk.length;
          return span;
        }).join('');
      });
    }

    stopTTS() {
      if (this.synth) {
        this.synth.cancel();
      }
      this.isSpeaking = false;
      document.querySelectorAll('.tts-current-word').forEach(s => s.classList.remove('tts-current-word'));
      this.updateTTSButtonUI(false);
    }

    toggleTTS() {
      if (this.isSpeaking) {
        this.stopTTS();
      } else {
        const lessonProse = document.getElementById('lesson-prose-container');
        const audioScript = document.getElementById('lesson-audio-script');
        const textToRead = (audioScript && audioScript.innerText) || (lessonProse && lessonProse.innerText);
        if (textToRead) {
          this.speakText(textToRead, lessonProse);
        }
      }
    }

    updateTTSButtonUI(speaking) {
      const btns = document.querySelectorAll('.tts-toggle-btn');
      btns.forEach(b => {
        if (speaking) {
          b.innerHTML = `<span>⏹️</span><span>Stop Audio</span>`;
          b.classList.add('btn-active');
        } else {
          b.innerHTML = `<span>🔊</span><span>Listen (Aloud)</span>`;
          b.classList.remove('btn-active');
        }
      });
    }

    toggleDrawer() {
      const drawer = document.getElementById('a11y-drawer');
      const backdrop = document.getElementById('drawer-backdrop');
      const fabBtn = document.getElementById('a11y-fab-trigger');

      if (drawer && backdrop) {
        const isOpen = drawer.classList.contains('open');
        drawer.classList.toggle('open', !isOpen);
        backdrop.classList.toggle('open', !isOpen);
        if (fabBtn) fabBtn.setAttribute('aria-expanded', (!isOpen).toString());

        if (!isOpen) {
          const firstFocus = drawer.querySelector('button, input');
          if (firstFocus) firstFocus.focus();
          this.announce('Accommodations drawer opened');
        }
      }
    }
  }

  // Attach globally
  window.A11yEngine = A11yEngine;
})(window);
