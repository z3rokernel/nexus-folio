<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->table('project_media')->truncate();
        $this->db->table('projects')->truncate();

        $now = date('Y-m-d H:i:s');

        $projects = [
            [
                'slug'        => 'aether-engine',
                'title'       => 'AETHER ENGINE',
                'subtitle'    => 'Real-time generative video synthesis & node-based shader director in the browser',
                'year'        => 2026,
                'role'        => 'Lead Creative Technologist & Architect',
                'client'      => 'Aether Labs AI',
                'summary'     => 'A browser-native generative visual workstation combining WebGL2 compute pipelines with low-latency diffusion frame interpolation at 60fps.',
                'challenge'   => 'AI video tools felt like slow web forms: users submitted a prompt and waited 90 seconds for a static MP4. Aether Labs needed an immediate, tactile film-director interface where lighting, camera vectors, and shader post-processing respond in real time while diffusion keyframes stream in.',
                'approach'    => 'We architected a hybrid rendering pipeline: a CodeIgniter 4 + Redis orchestration API manages distributed GPU worker streams over WebSockets, while a custom Three.js multi-pass compositor blends live GLSL displacement fields with incoming latent frames.',
                'solution'    => 'Delivered a zero-install studio interface featuring magnetic timeline scrubbing, real-time optical flow morphing between keyframes, custom LUT shader racks, and deterministic seed locking for commercial film directors.',
                'results'     => json_encode([
                    '-68% frame preview latency',
                    '60 FPS viewport compositing',
                    '42k+ active studio creators',
                    '99.94% pipeline uptime',
                ]),
                'body'        => 'Aether Engine redefines how directors interact with generative media—replacing static prompt boxes with a physical, timeline-driven WebGL control room.',
                'cover_image' => '/assets/img/projects/aether-engine/cover.svg',
                'cover_video' => '',
                'accent'      => '#D4FF1F',
                'tags'        => json_encode(['ai', 'webgl', 'web']),
                'stack'       => json_encode(['CodeIgniter 4', 'Three.js', 'GLSL', 'WebSockets', 'Tailwind CSS', 'Redis']),
                'live_url'    => 'https://aether-engine.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/aether-engine',
                'featured'    => 1,
                'sort_order'  => 1,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'kronos-neural-hud',
                'title'       => 'KRONOS TELEMETRY',
                'subtitle'    => 'Autonomous fleet telemetry & spatial anomaly detection command center',
                'year'        => 2025,
                'role'        => 'Principal Full-Stack Engineer',
                'client'      => 'Kronos Robotics',
                'summary'     => 'Mission-critical spatial telemetry platform visualizing 120,000+ sensor events per second across autonomous industrial drones.',
                'challenge'   => 'Operators monitoring autonomous drone fleets suffered from alert fatigue and sluggish DOM-heavy dashboards that dropped below 12fps during high-frequency telemetry bursts.',
                'approach'    => 'Replaced legacy chart widgets with an instanced WebGL spatial radar and a high-throughput PHP 8.2 stream aggregator backed by time-series partitioning and binary ring buffers.',
                'solution'    => 'Engineered a neo-noir HUD interface with sub-millisecond scrubbable black-box replay, predictive anomaly heatmaps, and keyboard-first command dispatch (`Ctrl+K` tactical macros).',
                'results'     => json_encode([
                    '120k events/sec ingested',
                    '4.2x faster incident triage',
                    '0 DOM layout thrashing',
                    '98 Lighthouse Performance',
                ]),
                'body'        => 'Designed for zero-margin operational environments, Kronos Telemetry pairs industrial reliability with cinema-grade spatial visualization.',
                'cover_image' => '/assets/img/projects/kronos-neural-hud/cover.svg',
                'cover_video' => '',
                'accent'      => '#2DE2E6',
                'tags'        => json_encode(['web', 'ai', 'webgl']),
                'stack'       => json_encode(['PHP 8.2', 'CodeIgniter 4', 'Three.js', 'GSAP', 'PostgreSQL', 'Docker']),
                'live_url'    => 'https://kronos.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/kronos-telemetry',
                'featured'    => 1,
                'sort_order'  => 2,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'synapse-rag-os',
                'title'       => 'SYNAPSE RAG OS',
                'subtitle'    => 'Enterprise multi-agent knowledge graph & citations workbench',
                'year'        => 2025,
                'role'        => 'AI Systems Architect',
                'client'      => 'Synapse Intelligence',
                'summary'     => 'Hybrid vector + graph retrieval operating system that turns millions of technical PDFs and schematics into verifiable, cited answers.',
                'challenge'   => 'Enterprise engineering teams could not trust standard LLM chat wrappers due to hallucinated specifications and opaque retrieval steps.',
                'approach'    => 'Built a deterministic multi-hop retrieval pipeline in PHP & Python microservices with live citation bounding-box highlighting and an interactive force-directed knowledge graph.',
                'solution'    => 'Users watch the reasoning graph light up in real time as agents cross-verify schematics, tables, and revision logs before synthesizing a response with 1-click PDF deep links.',
                'results'     => json_encode([
                    '99.2% citation accuracy',
                    '-75% spec lookup time',
                    '1.8M indexed schematics',
                    'SOC2 compliant architecture',
                ]),
                'body'        => 'Synapse transforms black-box AI retrieval into an inspectable, high-contrast glass cockpit built for staff engineers.',
                'cover_image' => '/assets/img/projects/synapse-rag-os/cover.svg',
                'cover_video' => '',
                'accent'      => '#7B5CFF',
                'tags'        => json_encode(['ai', 'web']),
                'stack'       => json_encode(['CodeIgniter 4', 'OpenAI API', 'Qdrant', 'MySQL', 'Tailwind CSS', 'GSAP']),
                'live_url'    => 'https://synapse.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/synapse-rag-os',
                'featured'    => 1,
                'sort_order'  => 3,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'hyperion-synth',
                'title'       => 'HYPERION AUDIO LAB',
                'subtitle'    => 'Spatial WebAudio modular synthesizer with reactive ferrofluid shaders',
                'year'        => 2025,
                'role'        => 'Creative Developer',
                'client'      => 'Hyperion Soundworks',
                'summary'     => 'An interactive flag-ship product launch experience featuring a playable polyphonic WebAudio synth coupled to a 3D ferrofluid acoustic visualizer.',
                'challenge'   => 'Hyperion needed a web launch for their hardware synthesizer that let sound designers experience the filter character directly in the browser without audio crackle or frame drops.',
                'approach'    => 'Wrote custom AudioWorklet DSP oscillators and state-variable filters, feeding real-time FFT frequency bins into a vertex-displaced Three.js ferrofluid sphere with iridescent PBR materials.',
                'solution'    => 'Visitors patch virtual cables, sculpt presets, and share serialized patch URLs—turning a product landing page into a viral musical instrument.',
                'results'     => json_encode([
                    '6m 40s avg session duration',
                    '310% pre-order conversion lift',
                    '< 4ms audio buffer latency',
                    'Featured on Awwwards / FWA',
                ]),
                'body'        => 'Where DSP mathematics meets liquid chrome: Hyperion proves the browser can rival native audio-visual instruments.',
                'cover_image' => '/assets/img/projects/hyperion-synth/cover.svg',
                'cover_video' => '',
                'accent'      => '#D4FF1F',
                'tags'        => json_encode(['webgl', 'web', 'open-source']),
                'stack'       => json_encode(['Three.js', 'WebAudio API', 'GLSL', 'GSAP', 'Barba.js', 'CodeIgniter 4']),
                'live_url'    => 'https://hyperion.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/hyperion-synth',
                'featured'    => 1,
                'sort_order'  => 4,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'void-commerce',
                'title'       => 'VOID ARCHIVE 09',
                'subtitle'    => 'Headless luxury technical-apparel flagship with 3D garment inspection',
                'year'        => 2024,
                'role'        => 'Lead Full-Stack & Motion Developer',
                'client'      => 'VOID//09 Tokyo',
                'summary'     => 'Sub-second server-rendered technical commerce platform with seamless Flip transitions, cloth-simulation previews, and instant global checkout.',
                'challenge'   => 'Luxury streetwear drops suffer from bot traffic spikes that crash SPA storefronts while heavy 3D assets ruin mobile Core Web Vitals.',
                'approach'    => 'Combined CodeIgniter 4 edge-cached HTML responses and strict rate-limiting filters with progressive WebGL enhancement and Barba.js shared-element transitions.',
                'solution'    => 'Achieved instant First Contentful Paint under heavy drop traffic while delivering a seamless filmic runway experience on desktop and mobile.',
                'results'     => json_encode([
                    '0.9s LCP on 4G mobile',
                    '15,000 concurrent drop users',
                    '+44% mobile checkout rate',
                    '100% zero-downtime drops',
                ]),
                'body'        => 'Built like a high-frequency trading desk disguised as an avant-garde Tokyo fashion lookbook.',
                'cover_image' => '/assets/img/projects/void-commerce/cover.svg',
                'cover_video' => '',
                'accent'      => '#FF3B5C',
                'tags'        => json_encode(['web', 'mobile', 'webgl']),
                'stack'       => json_encode(['CodeIgniter 4', 'MySQL', 'GSAP Flip', 'Lenis', 'Tailwind CSS', 'Stripe']),
                'live_url'    => 'https://void09.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/void-archive-09',
                'featured'    => 1,
                'sort_order'  => 5,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'slug'        => 'prism-shader-kit',
                'title'       => 'PRISM GLSL KIT',
                'subtitle'    => 'Open-source library of 40+ production GLSL post-processing & fluid shaders',
                'year'        => 2024,
                'role'        => 'Creator & Maintainer',
                'client'      => 'Open Source Community',
                'summary'     => 'Zero-dependency collection of modular GLSL fragment shaders, ping-pong FBO fluid solvers, and accessibility-aware WebGL wrappers.',
                'challenge'   => 'Creative developers repeatedly rewrite boilerplate for FBM domain warping, optical flow ripples, chromatic aberration, and reduced-motion fallbacks.',
                'approach'    => 'Packaged battle-tested shader chunks with automatic DPR scaling, IntersectionObserver pause hooks, and one-line vanilla ESM integration.',
                'solution'    => 'Adopted by hundreds of portfolios and studio sites worldwide, with an interactive live uniform playground and benchmark suite.',
                'results'     => json_encode([
                    '3.4k+ GitHub Stars',
                    '18 KB gzipped core',
                    '45+ modular GLSL nodes',
                    'MIT Licensed',
                ]),
                'body'        => 'Prism empowers web creators to ship cinema-grade shaders without sacrificing battery life or accessibility.',
                'cover_image' => '/assets/img/projects/prism-shader-kit/cover.svg',
                'cover_video' => '',
                'accent'      => '#2DE2E6',
                'tags'        => json_encode(['open-source', 'webgl', 'web']),
                'stack'       => json_encode(['GLSL', 'Three.js', 'Vanilla ESM', 'WebGL2', 'Vite']),
                'live_url'    => 'https://prism.demo.nexus-folio.dev',
                'repo_url'    => 'https://github.com/aminebdeir/prism-shader-kit',
                'featured'    => 1,
                'sort_order'  => 6,
                'published'   => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        $this->db->table('projects')->insertBatch($projects);

        $inserted = $this->db->table('projects')->get()->getResultArray();
        $mediaRows = [];
        foreach ($inserted as $proj) {
            $slug = $proj['slug'];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/cover.svg",
                'caption'    => "{$proj['title']} — Primary Control Room & Viewport Interface",
                'sort_order' => 1,
            ];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/detail-01.svg",
                'caption'    => "{$proj['title']} — Real-Time Shader & Telemetry Pipeline Breakdown",
                'sort_order' => 2,
            ];
            $mediaRows[] = [
                'project_id' => $proj['id'],
                'type'       => 'image',
                'path'       => "/assets/img/projects/{$slug}/detail-02.svg",
                'caption'    => "{$proj['title']} — Responsive Mobile Architecture & HUD System",
                'sort_order' => 3,
            ];
        }

        if (! empty($mediaRows)) {
            $this->db->table('project_media')->insertBatch($mediaRows);
        }
    }
}
