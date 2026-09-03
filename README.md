# Hestens Learning 🌟
> **Accessible, Neurodiversity-Centered E-Learning Platform (Pre-K to 12th Grade)**
> *Modular PHP Architecture • Universal Design for Learning (UDL) • WCAG 2.2 AAA Compliant*

---

## 🚀 Key Features & Architectural Capabilities

### 1. ♿ Accessibility Floating Action Button (FAB)
- All assistive accommodations are tucked into a sleek **FAB** at the bottom-right corner.
- Instantly openable via <kbd>Alt</kbd> + <kbd>A</kbd> or clicking the button.
- **Font Selection**: OpenDyslexic (Regular, Bold, Italic), Lexend, Atkinson Hyperlegible, and Inter Sans.
- **Sensory & Visual Stress Tints**: Calm Dark, Crisp Light, Warm Sepia (Irlen Tint), Sage Green, Serene Blue, and High Contrast AAA.
- **Assistive Tools**: Interactive Reading Ruler (<kbd>Alt</kbd>+<kbd>R</kbd>), Focus Mask Dimmer, Bionic Reading Mode, TTS Karaoke Audio (<kbd>Alt</kbd>+<kbd>S</kbd>), and Zen Distraction-Free Mode (<kbd>Alt</kbd>+<kbd>Z</kbd>).

### 2. 🏠 Hero Section & 14 Grade Cards (Pre-K through 12th)
- **Hero Banner**: Neurodiversity-affirming overview with direct links to:
  - **"Get Started"** ➔ Diagnostic Assessment (`assessment.php`).
  - **"About Us"** ➔ Mission and pedagogy (`about.php`).
- **14 Grade Cards**:
  - Pre-K, Kindergarten, 1st, 2nd, 3rd, 4th, 5th, 6th, 7th, 8th, 9th, 10th, 11th, and 12th Grade.
  - Interactive tier filter tabs (All, Early, Elementary, Middle, High School).

### 3. 📚 4-Subject Grade Curriculum (`grade.php`)
- Each grade contains 4 core subject tabs:
  - 🔢 **Mathematics**
  - 📖 **ELA (English Language Arts & Phonics)**
  - 🔬 **Science & Nature**
  - 🏛️ **Social Studies & Civics**
- Dynamically displays lesson directory with time estimates and mastery status.

### 4. 🧩 Dynamic Reusable Single-File Lesson Viewer (`lesson.php`)
- Content is loaded dynamically from `data/curriculum.json`—only one PHP file is maintained for all courses and lessons!
- Multi-sensory features:
  - Text-to-Speech audio reader with word-by-word visual highlight.
  - "Explain Simply (TL;DR)" plain-language summary cards.
  - Tactile embedded widgets (e.g. 50/30/20 budget builder, solar gravity orbit simulator, sorting sorters).
  - Active recall flashcards (<kbd>Space</kbd> / <kbd>Enter</kbd> to flip).
  - Low-stress, non-punitive knowledge checks.

### 5. 🎯 Diagnostic Assessment & Downloadable Report (`assessment.php`)
- Multi-sensory evaluation categorized by grade tiers and subjects.
- Audio narration for every question with zero stressful countdowns.
- Instant on-screen summary + **"Download Detailed Learning Plan & Report (.txt)"** button.

### 6. 🔍 Global Search & Student Hub
- **Working Global Search Bar** (`search.php`): Searches across all grades, subjects, lessons, and topics.
- **Student Learning Binder** (`profile.php`): Track completed milestones, voice notes, and active accommodations checklist.
- **Voice Dictation Notes**: Speech-to-Text for free-form thoughts with local browser persistence.
- **Resource-Rich Footer**: Curated links to IDA, CHADD, Understood.org, Irlen Institute, and W3C WAI.

---

## ⌨️ Global Keyboard Shortcuts

| Shortcut | Action |
| :--- | :--- |
| <kbd>Alt</kbd> + <kbd>A</kbd> | Open / Close Accessibility Accommodations FAB Drawer |
| <kbd>Alt</kbd> + <kbd>R</kbd> | Toggle Reading Line Ruler |
| <kbd>Alt</kbd> + <kbd>S</kbd> | Start / Stop Text-to-Speech Karaoke Narration |
| <kbd>Alt</kbd> + <kbd>Z</kbd> | Toggle Zen Distraction-Free Mode |
| <kbd>Tab</kbd> / <kbd>Shift</kbd>+<kbd>Tab</kbd> | High-visibility focus ring navigation |
| <kbd>Space</kbd> / <kbd>Enter</kbd> | Flip active recall flashcards / Activate controls |
| <kbd>?</kbd> | Open keyboard shortcuts modal |

---

## 🛠️ How to Run Locally

Start the PHP development server:

```powershell
# Using XAMPP PHP:
& "C:\xampp\php\php.exe" -S localhost:8000

# Or if php is in your PATH:
php -S localhost:8000
```
Then visit **`http://localhost:8000`** in your browser.

---

## 📄 License
Licensed under the [Apache License 2.0](LICENSE).
