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

  // Scroll zoom & darken
  p *= (1.0 - clamp(uScroll, 0.0, 1.0) * 0.22);

  // Mouse ripple displacement
  float dist = length(p - m);
  float ripple = sin(dist * 22.0 - uTime * 4.5) * exp(-dist * 4.5) * (0.04 + uVelocity * 0.08);
  p += normalize(p - m + 0.0001) * ripple;

  // Domain-warped FBM liquid field
  float t = uTime * 0.14;
  vec2 q = vec2(fbm(p * 1.8 + t), fbm(p * 1.8 + vec2(1.7, 9.2) - t));
  vec2 r = vec2(
    fbm(p * 2.1 + 1.8 * q + vec2(1.7, 9.2) + 0.15 * uTime),
    fbm(p * 2.1 + 1.8 * q + vec2(8.3, 2.8) + 0.126 * uTime)
  );
  float f = fbm(p * 1.6 + r * 2.2);

  // Palette: Void -> Ink -> Plasma Violet -> Cyan -> Active Accent (Lime)
  vec3 voidCol = vec3(0.0196, 0.0235, 0.0392);
  vec3 plasmaCol = vec3(0.482, 0.361, 1.0);
  vec3 cyanCol = vec3(0.176, 0.886, 0.902);

  vec3 col = mix(voidCol, plasmaCol * 0.28, clamp(f * f * 2.2, 0.0, 1.0));
  col = mix(col, cyanCol * 0.24, clamp(length(q) * 0.65, 0.0, 1.0));

  // Chrome / Accent flow lines
  float flow = smoothstep(0.48, 0.52, fract(f * 5.5 + uTime * 0.06));
  col += uAccent * flow * 0.14;

  // Pointer glow pool
  float glow = exp(-dist * 3.6) * (0.26 + uVelocity * 0.25);
  col += uAccent * glow;

  // Konami Glitch Chromatic Aberration
  if (uGlitch > 0.5) {
    float shift = sin(uv.y * 80.0 + uTime * 25.0) * 0.025;
    col.r += fbm(p * 4.0 + shift) * 0.35;
    col.b += fbm(p * 4.0 - shift) * 0.35;
  }

  // Vignette & scroll attenuation
  float vig = smoothstep(1.35, 0.25, length(p));
  col *= vig * (1.0 - clamp(uScroll, 0.0, 1.0) * 0.55);

  gl_FragColor = vec4(col, 1.0);
}

