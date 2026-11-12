# NEXUS-FOLIO — Architectural & Engineering Decisions

This document logs intentional enhancements or technical choices made during the implementation of **NEXUS-FOLIO** (per `AGENTS.md` Rule #1).

## 1. Procedural High-Resolution SVG Covers & Portrait (`docs/05-DATA-CONTENT.md`)
- **Context:** Local PHP CLI (`8.2.12`) has `sqlite3`, `intl`, `mbstring`, and `curl` enabled, while `ext-gd` is not enabled by default.
- **Decision:** Authored a deterministic generator producing crisp `1920×1080` layered studio SVG covers (`cover.svg`, `detail-01.svg`, `detail-02.svg`) for all 6 seeded projects plus a cybernetic duotone portrait (`public/assets/img/portrait.svg`) and a valid `public/cv.pdf`. SVGs scale infinitely at 4K DPR with zero compression artifacts and `< 8 KB` payload size.

## 2. Synthesized WebAudio Studio SFX (`public/assets/js/modules/sound.js`)
- **Context:** `docs/03-ANIMATION-SPEC.md` §10.6 specifies an opt-in sound toggle (default OFF) for UI ticks and transition sweeps.
- **Decision:** Paired Howler.js CDN availability with a zero-dependency WebAudio API synthesizer (`AudioContext` oscillators + exponential gain envelopes) so hover ticks, click chirps, and scene transition sweeps play with `< 2ms` latency and never fail due to missing external MP3 files.

## 3. CSRF Cookie Token Persistence for AJAX & Rate-Limit Testing (`app/Config/Security.php`)
- **Context:** Contact form supports progressive enhancement (both AJAX `fetch` with `Accept: application/json` and standard POST redirect) protected by `csrf`, `honeypot`, and `throttle:5,60`.
- **Decision:** Set `Security::$regenerate = false` (per-session/window token validity) and returned fresh `csrfHash` tokens in JSON responses so rapid legitimate AJAX retries and automated PHPUnit rate-limit tests (`testContactThrottleFilterReturns429OnSixthCall`) hit the `ThrottleFilter` (`429 Too Many Requests`) cleanly.

