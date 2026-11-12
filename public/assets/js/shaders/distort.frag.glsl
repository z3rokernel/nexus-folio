precision highp float;
varying vec2 vUv;
uniform sampler2D uTexture;
uniform vec2 uMouse;
uniform float uHover;
uniform float uTime;

void main() {
  vec2 uv = vUv;
  float dist = distance(uv, uMouse);
  float wave = sin(dist * 28.0 - uTime * 6.0) * exp(-dist * 5.0) * uHover * 0.035;
  vec2 dispUv = uv + normalize(uv - uMouse + 0.0001) * wave;

  float r = texture2D(uTexture, dispUv + vec2(wave * 0.4, 0.0)).r;
  float g = texture2D(uTexture, dispUv).g;
  float b = texture2D(uTexture, dispUv - vec2(wave * 0.4, 0.0)).b;

  gl_FragColor = vec4(r, g, b, 1.0);
}

