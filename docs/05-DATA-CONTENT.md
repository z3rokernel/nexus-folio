# 05 — Data & Content

## ✍️ YOUR CONTENT (fill this before running the agent)
```yaml
name: "Your Name"
role_titles: ["Full-Stack Developer", "Creative Technologist", "AI Builder"]
tagline: "I build fast, beautiful, intelligent web products."
city: "Valence, France"
timezone: "Europe/Paris"
email: "you@domain.com"
availability: "Open to freelance & full-time"   # shows green pulse dot
socials:
  github: "https://github.com/your-username"
  linkedin: "https://linkedin.com/in/your-handle"
  x: ""
bio_short: "2–3 sentences."
bio_long: "A few paragraphs for the About page."
years_experience: 5
cv_file: "public/cv.pdf"
brand_accent: "#D4FF1F"     # optional override
```

### Projects (repeat per project)
```yaml
- title: "Project Name"
  slug: "project-name"
  subtitle: "One-line pitch"
  year: 2025
  role: "Lead Developer"
  client: "Company / Personal"
  tags: ["web", "ai"]
  stack: ["CodeIgniter 4", "MySQL", "Tailwind", "OpenAI API"]
  challenge: "…"
  approach: "…"
  solution: "…"
  results: ["−40% load time", "10k users", "…"]
  live_url: "https://…"
  repo_url: "https://github.com/…"
  cover_image: "public/assets/img/projects/project-name/cover.jpg"   # 16:9, ≥1920px
  cover_video: "public/assets/img/projects/project-name/loop.mp4"    # optional, ≤ 6s, ≤ 2MB, H.264 + WebM
  gallery: ["…/01.jpg", "…/02.jpg"]
  featured: true
```
### Skills
`category: Backend | Frontend | AI | DevOps | Design` — `name`, `level` (0–100).
### Experience
`company, role, start, end, description (2–3 bullets)`.

## If you have no assets yet
The agent must generate **procedural placeholders** (gradient + noise SVG/PNG via a PHP GD script or inline SVG) so the site looks complete, plus a `docs/ASSETS-TODO.md` listing which real images/videos to replace. Recommended media specs:
- Images: WebP/AVIF + JPG fallback, widths 640/1280/1920, `loading="lazy"`.
- Video loops: 1280×720, ≤ 6s, no audio, H.264 (mp4) + VP9 (webm).

## Seeder pattern
```php
class ProjectSeeder extends Seeder {
  public function run(): void {
    $this->db->table('projects')->insertBatch([
      ['slug'=>'project-name','title'=>'Project Name', /* ... */ 'tags'=>json_encode(['web','ai']), 'featured'=>1, 'published'=>1],
    ]);
  }
}
```
Run: `php spark migrate && php spark db:seed DatabaseSeeder`.

## Optional admin (stretch goal)
Minimal `/admin` (session login, bcrypt password from `.env`) with CRUD for projects & image upload to `writable/uploads` → `public/uploads`. Only if all core phases are done.
