/**
 * Hestens Learning - Accessible Course Data & Multi-Sensory Content
 */

export const COURSES = [
  {
    id: "cosmic-journey",
    title: "The Cosmic Journey: Mysteries of Our Solar System",
    category: "Science & Space",
    bannerClass: "banner-space",
    icon: "🪐",
    level: "Beginner Friendly",
    timeEstimate: "15 min chunks",
    description: "Explore gravity, planetary orbits, and deep space phenomena using interactive visual orbits and audio storytelling.",
    lessons: [
      {
        id: "space-1",
        title: "1. The Gravity Anchor: Why Planets Don't Float Away",
        badge: "Core Concept",
        audioScript: "Imagine spinning a ball attached to a string around your hand. If you let go of the string, the ball flies in a straight line. Gravity acts like that invisible string, keeping Earth locked in a steady orbit around the Sun.",
        summary: "Gravity is an invisible pulling force. The massive Sun pulls all planets toward it, while their forward motion keeps them from crashing into it.",
        contentHtml: `
          <p>Have you ever wondered why Earth doesn't just wander off into cold, dark space? The secret is an invisible tug-of-war called <strong>orbital mechanics</strong>.</p>
          <p>The Sun is enormously heavy—it holds over 99.8% of all the mass in our entire solar system! Because of its colossal mass, its gravity pulls on everything around it.</p>
          <p>Meanwhile, Earth is moving forward at an astonishing speed of 67,000 miles per hour (107,000 km/h). The balance between Earth wanting to fly straight and the Sun pulling it inward creates an almost perfect, peaceful circle: an <strong>orbit</strong>.</p>
        `,
        widgetType: "gravity-orbit",
        flashcards: [
          { front: "What is an Orbit?", back: "A repeating path that an object takes around another object in space due to gravity." },
          { front: "How much mass does the Sun hold?", back: "Over 99.8% of the entire solar system's mass!" },
          { front: "What creates an orbit?", back: "The balance between forward speed and gravitational pull." }
        ],
        quiz: {
          question: "What keeps Earth from flying straight out into deep space?",
          options: [
            { text: "The gravitational pull of the massive Sun", correct: true, feedback: "Spot on! The Sun's intense gravity acts like an anchor holding Earth in place." },
            { text: "A physical energy shield around our atmosphere", correct: false, feedback: "Not quite—space is open, but the Sun's invisible gravitational field does the holding!" },
            { text: "Earth is moving too slowly to go anywhere", correct: false, feedback: "Actually, Earth travels at 67,000 mph! Gravity redirects that speed into a circle." }
          ]
        }
      },
      {
        id: "space-2",
        title: "2. The Giants vs. The Rocky Worlds",
        badge: "Planetary Science",
        audioScript: "Our solar system has two distinct neighborhoods: the inner rocky planets like Earth and Mars, and the outer gas and ice giants like Jupiter and Saturn.",
        summary: "Inner planets are small, dense, and rocky. Outer planets are massive, made of gas and ice, and boast dozens of moons and rings.",
        contentHtml: `
          <p>Astronomers divide the eight planets into two main families separated by a vast asteroid belt:</p>
          <p><strong>1. Terrestrial (Rocky) Planets:</strong> Mercury, Venus, Earth, and Mars. They have solid ground you could walk on, metallic cores, and few or no moons.</p>
          <p><strong>2. Jovian (Gas & Ice) Giants:</strong> Jupiter, Saturn, Uranus, and Neptune. They don't have a solid surface! If you tried to step on Jupiter, you would sink through thousands of miles of swirling hydrogen and helium gas.</p>
        `,
        widgetType: "sort-planets",
        flashcards: [
          { front: "What are Terrestrial Planets?", back: "Rocky worlds with solid surfaces: Mercury, Venus, Earth, and Mars." },
          { front: "What are Jovian Planets?", back: "Giant gas and ice worlds without solid surfaces: Jupiter, Saturn, Uranus, and Neptune." }
        ],
        quiz: {
          question: "Which of these planets has a solid rocky ground you could stand on?",
          options: [
            { text: "Mars", correct: true, feedback: "Correct! Mars is a terrestrial planet with solid red rock and valleys." },
            { text: "Jupiter", correct: false, feedback: "Jupiter is a gas giant with no solid ground!" },
            { text: "Saturn", correct: false, feedback: "Saturn is made mostly of hydrogen and helium gas." }
          ]
        }
      }
    ]
  },
  {
    id: "practical-math",
    title: "Visual Math & Everyday Financial Literacy",
    category: "Math & Life Skills",
    bannerClass: "banner-math",
    icon: "💡",
    level: "All Levels (Dyscalculia-Friendly)",
    timeEstimate: "10 min chunks",
    description: "Learn budgeting, percentages, and visual arithmetic without stressful formulas or time pressure.",
    lessons: [
      {
        id: "math-1",
        title: "1. The 50/30/20 Visual Budgeting Method",
        badge: "Practical Life Skill",
        audioScript: "Budgeting doesn't have to be complicated math. Think of your money as three colorful buckets: Needs, Wants, and Future Savings.",
        summary: "The 50/30/20 rule splits your income: 50% for essentials (housing, food), 30% for fun, and 20% for savings & emergencies.",
        contentHtml: `
          <p>Money can feel overwhelming when it's just endless rows of numbers. A visual framework helps you see where every dollar goes without getting lost in arithmetic.</p>
          <p><strong>The 3 Buckets:</strong></p>
          <p>• <strong>50% Needs:</strong> Rent, groceries, utility bills, medication, and transportation.</p>
          <p>• <strong>30% Wants:</strong> Hobbies, eating out with friends, streaming subscriptions, and games.</p>
          <p>• <strong>20% Savings / Safety Net:</strong> Building an emergency fund or saving for big future milestones.</p>
        `,
        widgetType: "math-blocks-budget",
        flashcards: [
          { front: "What is 50% reserved for in the 50/30/20 rule?", back: "Essential Needs (rent, groceries, utilities)." },
          { front: "What is the 30% bucket for?", back: "Wants & lifestyle (hobbies, entertainment)." },
          { front: "Why save 20%?", back: "To protect yourself with an emergency fund and invest in future dreams." }
        ],
        quiz: {
          question: "If you receive a paycheck, what category should rent and groceries come from?",
          options: [
            { text: "The 50% Needs Bucket", correct: true, feedback: "Exactly! Food and shelter are basic needs to take care of first." },
            { text: "The 30% Wants Bucket", correct: false, feedback: "Wants are for entertainment and fun, while food and shelter are essential needs." },
            { text: "The 20% Savings Bucket", correct: false, feedback: "Savings should remain untouched for emergencies and future goals." }
          ]
        }
      },
      {
        id: "math-2",
        title: "2. Visualizing Percentages & Discounts",
        badge: "Visual Arithmetic",
        audioScript: "To find 10 percent of any price, just move the decimal point one step to the left. For 20 percent, find 10 percent and double it!",
        summary: "Break tricky percentages down into friendly 10% building blocks to calculate real-world discounts in seconds.",
        contentHtml: `
          <p>Store sales often say '20% off' or '10% discount'. Here is the easiest trick that requires no calculator:</p>
          <p><strong>The 10% Superpower:</strong></p>
          <p>To find 10% of $40, just shift the zero: 10% is <strong>$4.00</strong>.</p>
          <p>Want 20%? Simply double $4 to get <strong>$8.00</strong>!</p>
          <p>Want 5%? Cut $4 in half to get <strong>$2.00</strong>!</p>
        `,
        widgetType: "math-discount-calc",
        flashcards: [
          { front: "How do you quickly find 10% of $80?", back: "Shift one place left = $8.00." },
          { front: "How do you calculate 20% from 10%?", back: "Multiply the 10% amount by 2." }
        ],
        quiz: {
          question: "A jacket costs $60. The store offers 10% off. How much discount do you get?",
          options: [
            { text: "$6.00 off", correct: true, feedback: "Great work! 10% of $60 is $6.00." },
            { text: "$12.00 off", correct: false, feedback: "$12 would be 20% off. For 10%, move the decimal point one step left to get $6." },
            { text: "$1.00 off", correct: false, feedback: "Take 60 and shift one decimal place to the left to find $6." }
          ]
        }
      }
    ]
  },
  {
    id: "creative-coding",
    title: "Creative Coding: How Computers Think",
    category: "Technology & Logic",
    bannerClass: "banner-code",
    icon: "💻",
    level: "Beginner",
    timeEstimate: "12 min chunks",
    description: "Demystify algorithms, loops, and conditions with visual flowcharts and interactive blocks.",
    lessons: [
      {
        id: "code-1",
        title: "1. Algorithms: The Recipe for Everything",
        badge: "Core Logic",
        audioScript: "An algorithm is simply a clear, step-by-step recipe. Computers are very fast, but they can only do exactly what we tell them step by step.",
        summary: "An algorithm is a step-by-step sequence of precise instructions to solve a problem or complete a task.",
        contentHtml: `
          <p>Have you ever made a peanut butter and jelly sandwich? If you tell a robot 'put jelly on bread', it might drop the whole glass jar on top of the loaf!</p>
          <p>Computers require <strong>precise step-by-step instructions</strong>. That sequence of instructions is called an <strong>Algorithm</strong>.</p>
          <p>Every app, video game, and website is built out of hundreds of small algorithms working together in harmony.</p>
        `,
        widgetType: "sandwich-algorithm",
        flashcards: [
          { front: "What is an Algorithm?", back: "A step-by-step list of clear instructions to accomplish a task." },
          { front: "Why must computer instructions be precise?", back: "Because computers follow orders literally without making assumptions." }
        ],
        quiz: {
          question: "What is an algorithm best compared to?",
          options: [
            { text: "A step-by-step recipe for baking cookies", correct: true, feedback: "Perfect! Just like a recipe tells you each step in order, an algorithm tells a computer what to do." },
            { text: "A random collection of unrelated thoughts", correct: false, feedback: "Algorithms must be structured and sequential, unlike random thoughts." },
            { text: "A physical cable inside the motherboard", correct: false, feedback: "An algorithm is a set of logical instructions, not physical hardware." }
          ]
        }
      }
    ]
  }
];
