precision highp float;
varying vec2 vUv;
uniform float uTime;
uniform vec2 uMouse;
uniform vec3 uAccent;

void main() {
  float d = distance(vUv, uMouse);
  float ring = smoothstep(0.18, 0.0, d) * (0.5 + 0.5 * sin(uTime * 3.0));
  gl_FragColor = vec4(uAccent * ring, ring * 0.65);
}
