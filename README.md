# 🚀 NEXUS-FOLIO Kit — Antigravity Starter Pack

A spec kit for building a **cinematic, futuristic, WebGL-powered portfolio** with **CodeIgniter 4**, ready to be driven by agents in **Antigravity IDE** and pushed to **GitHub**.

## How to use (3 minutes)

1. Create an empty folder: `portfolio` and open it in **Antigravity** (File → Open Folder).
2. Copy **everything in this kit** into the folder root, keeping the structure:
   ```
   portfolio/
   ├── AGENTS.md                  ← read automatically by the agent
   ├── PROMPT.md                  ← the master prompt (paste into Agent Manager)
   ├── .agent/
   │   ├── rules/                 ← always-on rules (workspace rules)
   │   └── workflows/             ← slash-commands: /bootstrap /build-feature /ship-to-github
   └── docs/                      ← the full specs (design, motion, architecture, ...)
   ```
3. Open **Agent Manager**, choose **Planning mode**, paste the content of `PROMPT.md`.
4. Review the agent's **Implementation Plan artifact** → approve → let it run.
5. When the site works locally, run the workflow: type `/ship-to-github` in the agent chat.

> Tip: in Antigravity, set **Terminal policy** to "Request review" so the agent asks before running risky commands (git push, composer, npm installs).

## Kit map

| File | Purpose |
|---|---|
| `PROMPT.md` | The one prompt to kick off everything |
| `AGENTS.md` | Project brief + non-negotiables for any agent |
| `.agent/rules/*` | Always-on rules: stack, motion, backend |
| `.agent/workflows/*` | Repeatable procedures (`/bootstrap`, `/build-feature`, `/ship-to-github`) |
| `docs/01-VISION-DESIGN-SYSTEM.md` | Theme, colors, type, layout language |
| `docs/02-ARCHITECTURE-CI4.md` | CI4 structure, routes, controllers, models, views |
| `docs/03-ANIMATION-SPEC.md` | Every animation, library, and technique |
| `docs/04-PAGES-COMPONENTS.md` | Page-by-page + component specs |
| `docs/05-DATA-CONTENT.md` | DB schema, seeders, your content template |
| `docs/06-GITHUB-DEPLOY.md` | Git flow, CI, Docker, deployment |
| `docs/07-ROADMAP-CHECKLIST.md` | Phased tasks the agent ticks off |
| `docs/08-PERFORMANCE-A11Y-QA.md` | Budgets, reduced-motion, testing |

**Before you start**, fill in your personal info in `docs/05-DATA-CONTENT.md` (section "YOUR CONTENT").
