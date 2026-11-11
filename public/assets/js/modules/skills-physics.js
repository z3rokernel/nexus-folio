/**
 * modules/skills-physics.js — Matter.js 2D Rigid-Body Skills Playground
 */
import { prefersReduced } from '../core/motion-prefs.js';
import { state, THEME_COLORS } from '../core/state.js';

let rafId = null;
let engine = null;
let world = null;
let cleanupFn = null;

export function initSkillsPhysics(container = document) {
  destroySkillsPhysics();

  const arena = container.querySelector('#skills-physics-arena');
  const canvas = container.querySelector('#skills-physics-canvas');
  if (!arena || !canvas) return;

  if (prefersReduced() || !window.Matter) {
    arena.style.display = 'none';
    return;
  }

  const Matter = window.Matter;
  const { Engine, World, Bodies, Body, Mouse, MouseConstraint, Composite } = Matter;

  let skills = [];
  try {
    skills = JSON.parse(arena.getAttribute('data-skills') || '[]');
  } catch (_) {}
  if (skills.length === 0) return;

  const rect = arena.getBoundingClientRect();
  const width = Math.max(320, Math.floor(rect.width));
  const height = Math.max(340, Math.floor(rect.height));
  canvas.width = width;
  canvas.height = height;

  engine = Engine.create();
  world = engine.world;
  engine.gravity.y = 0.85;

  const wallThickness = 60;
  const ground = Bodies.rectangle(width / 2, height + wallThickness / 2 - 4, width + 200, wallThickness, { isStatic: true });
  const roof = Bodies.rectangle(width / 2, -wallThickness * 2, width + 200, wallThickness, { isStatic: true });
  const leftWall = Bodies.rectangle(-wallThickness / 2 + 4, height / 2, wallThickness, height * 2, { isStatic: true });
  const rightWall = Bodies.rectangle(width + wallThickness / 2 - 4, height / 2, wallThickness, height * 2, { isStatic: true });

  World.add(world, [ground, roof, leftWall, rightWall]);

  const chipBodies = skills.map((sk, idx) => {
    const label = `${sk.name} · ${sk.level}%`;
    const bw = Math.min(240, Math.max(125, label.length * 8.5 + 34));
    const bh = 42;
    const x = 80 + ((idx * 137) % Math.max(160, width - 160));
    const y = -20 - idx * 18;

    const body = Bodies.rectangle(x, y, bw, bh, {
      chamfer: { radius: 20 },
      restitution: 0.55,
      friction: 0.15,
      density: 0.0015,
    });
    body.skillMeta = { label, category: sk.category, w: bw, h: bh };
    return body;
  });

  World.add(world, chipBodies);

  // Mouse Drag & Throw Constraint
  const mouse = Mouse.create(canvas);
  const mouseConstraint = MouseConstraint.create(engine, {
    mouse,
    constraint: {
      stiffness: 0.2,
      render: { visible: false },
    },
  });
  World.add(world, mouseConstraint);

  // Gravity Impulse Button
  const impulseBtn = container.querySelector('#physics-gravity-btn');
  const onImpulse = () => {
    chipBodies.forEach((b) => {
      Body.setVelocity(b, {
        x: (Math.random() - 0.5) * 14,
        y: -8 - Math.random() * 10,
      });
      Body.setAngularVelocity(b, (Math.random() - 0.5) * 0.18);
    });
  };
  if (impulseBtn) {
    impulseBtn.addEventListener('click', onImpulse);
  }

  const ctx = canvas.getContext('2d');

  function render() {
    if (!document.hidden && !prefersReduced()) {
      Engine.update(engine, 1000 / 60);

      ctx.clearRect(0, 0, width, height);
      const accentHex = (THEME_COLORS[state.theme] || THEME_COLORS.acid).hex;

      chipBodies.forEach((b) => {
        const { x, y } = b.position;
        const { w, h, label, category } = b.skillMeta;

        ctx.save();
        ctx.translate(x, y);
        ctx.rotate(b.angle);

        // Pill background
        ctx.beginPath();
        ctx.roundRect(-w / 2, -h / 2, w, h, 20);
        ctx.fillStyle = 'rgba(21, 25, 37, 0.92)';
        ctx.fill();
        ctx.lineWidth = 1.25;
        ctx.strokeStyle = category === 'AI' ? '#2DE2E6' : category === 'Frontend' ? accentHex : 'rgba(255,255,255,0.22)';
        ctx.stroke();

        // Dot indicator
        ctx.beginPath();
        ctx.arc(-w / 2 + 18, 0, 3.5, 0, Math.PI * 2);
        ctx.fillStyle = accentHex;
        ctx.fill();

        // Monospace Label
        ctx.font = '600 11px "JetBrains Mono", monospace';
        ctx.fillStyle = '#EDEFF5';
        ctx.textAlign = 'left';
        ctx.textBaseline = 'middle';
        ctx.fillText(label.toUpperCase(), -w / 2 + 28, 1);

        ctx.restore();
      });
    }
    rafId = requestAnimationFrame(render);
  }

  rafId = requestAnimationFrame(render);

  cleanupFn = () => {
    if (impulseBtn) impulseBtn.removeEventListener('click', onImpulse);
    if (world) Composite.clear(world, false);
    if (engine) Engine.clear(engine);
  };
}

export function destroySkillsPhysics() {
  if (rafId) {
    cancelAnimationFrame(rafId);
    rafId = null;
  }
  if (cleanupFn) {
    cleanupFn();
    cleanupFn = null;
  }
  engine = null;
  world = null;
}
