/**
 * modules/hero-shader.js — Persistent Three.js Liquid FBM Shader + Floating 3D Chrome Object
 */
import { prefersReduced } from '../core/motion-prefs.js';
import { state, THEME_COLORS, subscribeState } from '../core/state.js';
import { checkWebGLSupport, isTouchDevice, lerp } from '../core/utils.js';

const VERT_SHADER = `
varying vec2 vUv;
void main() {
  vUv = uv;
  gl_Position = vec4(position, 1.0);
}
`;

const FRAG_SHADER = `
precision highp float;

varying vec2 vUv;
uniform float uTime;
uniform vec2 uResolution;
uniform vec2 uMouse;
uniform float uVelocity;
uniform float uScroll;
uniform vec3 uAccent;
uniform float uGlitch;

float hash(vec2 p) {
  p = fract(p * vec2(123.34, 456.21));
  p += dot(p, p + 45.32);
  return fract(p.x * p.y);
}

float noise(vec2 p) {
  vec2 i = floor(p);
  vec2 f = fract(p);
  f = f * f * (3.0 - 2.0 * f);
  float a = hash(i);
  float b = hash(i + vec2(1.0, 0.0));
  float c = hash(i + vec2(0.0, 1.0));
  float d = hash(i + vec2(1.0, 1.0));
  return mix(mix(a, b, f.x), mix(c, d, f.x), f.y);
}

float fbm(vec2 p) {
  float v = 0.0;
  float a = 0.5;
  mat2 rot = mat2(cos(0.5), sin(0.5), -sin(0.5), cos(0.5));
  for (int i = 0; i < 5; i++) {
    v += a * noise(p);
    p = rot * p * 2.02 + vec2(100.0);
    a *= 0.5;
  }
  return v;
}

void main() {
  vec2 uv = vUv;
  float aspect = uResolution.x / max(uResolution.y, 1.0);
  vec2 p = (uv - 0.5) * vec2(aspect, 1.0);
  vec2 m = (uMouse - 0.5) * vec2(aspect, 1.0);

  p *= (1.0 - clamp(uScroll, 0.0, 1.0) * 0.22);

  float dist = length(p - m);
  float ripple = sin(dist * 22.0 - uTime * 4.5) * exp(-dist * 4.5) * (0.04 + uVelocity * 0.08);
  p += normalize(p - m + 0.0001) * ripple;

  float t = uTime * 0.14;
  vec2 q = vec2(fbm(p * 1.8 + t), fbm(p * 1.8 + vec2(1.7, 9.2) - t));
  vec2 r = vec2(
    fbm(p * 2.1 + 1.8 * q + vec2(1.7, 9.2) + 0.15 * uTime),
    fbm(p * 2.1 + 1.8 * q + vec2(8.3, 2.8) + 0.126 * uTime)
  );
  float f = fbm(p * 1.6 + r * 2.2);

  vec3 voidCol = vec3(0.0196, 0.0235, 0.0392);
  vec3 plasmaCol = vec3(0.482, 0.361, 1.0);
  vec3 cyanCol = vec3(0.176, 0.886, 0.902);

  vec3 col = mix(voidCol, plasmaCol * 0.28, clamp(f * f * 2.2, 0.0, 1.0));
  col = mix(col, cyanCol * 0.24, clamp(length(q) * 0.65, 0.0, 1.0));

  float flow = smoothstep(0.48, 0.52, fract(f * 5.5 + uTime * 0.06));
  col += uAccent * flow * 0.14;

  float glow = exp(-dist * 3.6) * (0.26 + uVelocity * 0.25);
  col += uAccent * glow;

  if (uGlitch > 0.5) {
    float shift = sin(uv.y * 80.0 + uTime * 25.0) * 0.025;
    col.r += fbm(p * 4.0 + shift) * 0.35;
    col.b += fbm(p * 4.0 - shift) * 0.35;
  }

  float vig = smoothstep(1.35, 0.25, length(p));
  col *= vig * (1.0 - clamp(uScroll, 0.0, 1.0) * 0.55);

  gl_FragColor = vec4(col, 1.0);
}
`;

let initialized = false;
let uniforms = null;

export async function initHeroShader() {
  if (initialized) return;
  const canvas = document.getElementById('gl-bg');
  if (!canvas || !checkWebGLSupport() || prefersReduced()) return;

  try {
    const THREE = await import('three');
    initialized = true;

    const isMobile = isTouchDevice() || window.innerWidth < 768;
    const maxDpr = isMobile ? 1.0 : 1.75;

    const renderer = new THREE.WebGLRenderer({
      canvas,
      antialias: false,
      powerPreference: 'high-performance',
    });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, maxDpr));
    renderer.setSize(window.innerWidth, window.innerHeight);

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 100);
    camera.position.z = 5;

    const initialRgb = (THEME_COLORS[state.theme] || THEME_COLORS.acid).rgb;

    uniforms = {
      uTime: { value: 0 },
      uResolution: { value: new THREE.Vector2(window.innerWidth, window.innerHeight) },
      uMouse: { value: new THREE.Vector2(0.5, 0.5) },
      uVelocity: { value: 0 },
      uScroll: { value: 0 },
      uAccent: { value: new THREE.Vector3(initialRgb[0], initialRgb[1], initialRgb[2]) },
      uGlitch: { value: 0 },
    };

    const bgGeo = new THREE.PlaneGeometry(2, 2);
    const bgMat = new THREE.ShaderMaterial({
      vertexShader: VERT_SHADER,
      fragmentShader: FRAG_SHADER,
      uniforms,
      depthWrite: false,
      depthTest: false,
    });
    const bgMesh = new THREE.Mesh(bgGeo, bgMat);
    scene.add(bgMesh);

    // Floating 3D Wireframe Chrome Icosahedron
    const icoGeo = new THREE.IcosahedronGeometry(1.15, 1);
    const icoMat = new THREE.MeshBasicMaterial({
      color: new THREE.Color(initialRgb[0], initialRgb[1], initialRgb[2]),
      wireframe: true,
      transparent: true,
      opacity: 0.16,
    });
    const icoMesh = new THREE.Mesh(icoGeo, icoMat);
    icoMesh.position.set(1.6, 0.2, 0);
    scene.add(icoMesh);

    subscribeState((key, val) => {
      if (key === 'theme' && uniforms) {
        const rgb = (THEME_COLORS[val] || THEME_COLORS.acid).rgb;
        uniforms.uAccent.value.set(rgb[0], rgb[1], rgb[2]);
        icoMat.color.setRGB(rgb[0], rgb[1], rgb[2]);
      }
      if (key === 'glitch' && uniforms) {
        uniforms.uGlitch.value = val ? 1.0 : 0.0;
      }
    });

    canvas.addEventListener('webglcontextlost', (e) => {
      e.preventDefault();
      document.documentElement.classList.add('no-webgl');
    });

    window.addEventListener(
      'resize',
      () => {
        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        uniforms.uResolution.value.set(window.innerWidth, window.innerHeight);
      },
      { passive: true }
    );

    let lerpedX = 0.5;
    let lerpedY = 0.5;
    let lastFrameTime = 0;
    const frameInterval = isMobile ? 1000 / 30 : 0; // Cap at 30fps on mobile per docs/08

    function animate(now) {
      requestAnimationFrame(animate);
      if (document.hidden || prefersReduced()) return;
      if (frameInterval > 0 && now - lastFrameTime < frameInterval) return;
      lastFrameTime = now;

      uniforms.uTime.value = now * 0.001;

      lerpedX = lerp(lerpedX, state.mouse.x, 0.08);
      lerpedY = lerp(lerpedY, state.mouse.y, 0.08);
      uniforms.uMouse.value.set(lerpedX, lerpedY);

      const vel = Math.min(1.0, Math.hypot(state.mouse.vx, state.mouse.vy) / 25);
      uniforms.uVelocity.value = lerp(uniforms.uVelocity.value, vel, 0.1);

      const heroScroll = Math.min(1.0, window.scrollY / Math.max(window.innerHeight, 1));
      uniforms.uScroll.value = heroScroll;

      icoMesh.rotation.x += 0.0025;
      icoMesh.rotation.y += 0.0035;
      icoMesh.position.x = lerp(icoMesh.position.x, 1.5 + (lerpedX - 0.5) * 0.6, 0.05);
      icoMesh.position.y = lerp(icoMesh.position.y, 0.15 + (lerpedY - 0.5) * 0.6 - heroScroll * 0.8, 0.05);
      icoMat.opacity = Math.max(0.03, 0.16 * (1.0 - heroScroll * 0.8));

      renderer.render(scene, camera);
    }

    requestAnimationFrame(animate);
  } catch (err) {
    document.documentElement.classList.add('no-webgl');
  }
}
