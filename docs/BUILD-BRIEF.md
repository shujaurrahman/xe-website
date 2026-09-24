# Xterra Edze — build brief

Everything a fresh session needs to continue building this site. `docs/` is excluded from deploy, so
this file never ships.

---

## 1. The site

Plain PHP 8. No framework, no build step for pages. Apache/LiteSpeed in production, `php -S` locally.

- **Pages**: `index.php`, `contact.php`, `services/<discipline>.php` (a discipline hub),
  `services/<discipline>/<capability>.php` (a capability subpage).
- **Sections**: each page is a shell that includes section partials.
  - Discipline pages: `partials/<discipline>/<id>.php` + `assets/css/<discipline>/<id>.css` +
    `assets/js/<discipline>/<id>.js`, over a page-level `assets/css/<discipline>.css`.
  - Home page only: `sections/<NN-name>.{php,css,js}`, listed in `$SECTIONS` in `index.php`, rendered
    by `xe_section()`. **Per-section css/js are bundled** — run `php build.php` after editing, or
    nothing changes in the browser.
- **Shared base layer** every page loads: `assets/css/core.css` (tokens) + `assets/css/brand/hub.css`
  (the `.bdh-*` layout primitives) + `assets/js/core.js` (`window.XE`, `[data-rv]` reveals) +
  `assets/js/brand/hub.js` (`window.BDH`: tabs, seq, type, count, live, loop, progress, spy,
  parallax, stagger, enter, watch, onInteract). Read the header comments of `brand/hub.css` and
  `brand/hub.js` before building anything.
- **Tech kit**: `partials/tech/kit.php` gives `xt_logo()`, `xt_stack()`, `xt_icon()`, `xt_badge()`,
  `xt_standards()`, styled by `assets/css/tech/kit.css`, with the logo manifest in
  `data/tech-stack.php`. Usable from any discipline, not just Technology.
- **Services catalogue**: one shared component, `partials/services/catalogue.php`, driven by
  `data/services/<discipline>.php` and `data/services/packages.php`. A page opts in with a one-line
  partial: `<?php $svc_key = '<key>'; include __DIR__ . '/../services/catalogue.php'; ?>`, plus
  `assets/css/services.css` and `assets/js/services.js` in the shell. **Do not restyle it** — it is
  deliberately identical everywhere. If page CSS leaks into it, scope the page CSS.
- `assets/css/core.css` embeds base64 fonts. **Never `Read` it whole** — grep it, or
  `awk 'length($0)<400' assets/css/core.css | head -300`.

### Clean URLs — non-negotiable
No URL may ever contain `.php` or `index`. `.htaccess` handles Apache/LiteSpeed; `router.php` mirrors
it for `php -S`. Always link through `xe_url('services/foo.php')`, which emits the clean form.
Never hand-write an href ending in `.php`.

---

## 2. Design system (a breach is a critical defect)

- **Colour**: only `core.css` tokens — `--paper`, `--paper-2..4`, `--ink`, `--ink-2`, `--txt`,
  `--muted`, `--faint`, `--ghost`, `--line`, `--line-2`, `--line-3`, `--dot`, `--blue`, `--blue-d`,
  `--blue-wash`, `--blue-wash-2`, `--blue-line`, `--on-ink`, `--on-ink-2`, `--on-ink-3`,
  `--on-ink-line`, `--on-ink-card`. No new hex/rgb literals, no gradients except core
  `.aurora`/`.dither` and mask fades, no `!important`. Blue is solid only and never inside a heading.
- **Type**: `var(--f-h)` Outfit for headings; `var(--f)` JetBrains Mono for eyebrows, labels, indexes,
  figures, code and mock-UI readouts; `var(--f-b)` Montserrat for reading text and buttons (never
  negative tracking). Heading pattern: `<span class="g">grey first phrase.</span> ink rest.`
- **Section shape**:
  `<section class="band [band--alt|band--ink] <prefix>-<id>" id="<id>" aria-labelledby="<id>-t">
   <div class="wrap">…`. Exactly one `h1` per page (the hero), an `h2` per section, `h3` for cards.
  Class names and PHP locals inside a partial both carry the page prefix. Never use bare
  `$c $d $i $k $item $url $current $disc $col $l $s` at partial top level — nav/cta/footer use them.
- **Motion**: purposeful and technical. Loops only while on screen (`.is-live` via `BDH.live` /
  `BDH.loop` / `BDH.seq`). `prefers-reduced-motion` shows the finished state with no loops.
  Interactive showcases behave like real software, with keyboard support and ARIA.
- **Accessibility**: decorative mocks get `aria-hidden="true"` plus a `.bdh-sr` sentence describing
  them; real controls are labelled buttons; tables use `th scope`.

### The five defect classes that keep recurring — check every one
1. **Blank without JavaScript.** The shipped HTML must always be the finished, readable state; JS only
   animates it. Never ship bare `opacity:0` on content. To animate from a hidden start, have the
   section's JS add the starting class (`.is-anim` / `.is-run`) at init. Test with JS disabled.
2. **`pathLength` + `vector-effect:non-scaling-stroke`** leaves SVG charts permanently half-drawn.
   Don't pair them.
3. **Icon accent on a blue fill.** `.xt-ico .a` is blue by default, so it vanishes on a `--blue`
   background. Any container filled with `--blue` must set `--xt-accent:currentColor`.
4. **Diagram edges drawn centre-to-centre** run through the boxes they connect. Trim each line to
   where it leaves each box, plus a small gap.
5. **Stacked cards sharing one grid cell** size the row to the tallest card, so shorter cards leave
   transparent gaps that show the cards underneath as ghost text. Keep only the current card in flow
   and absolutely position the rest, clipped to it.

### Mobile is a first-class target
Design at 1440, 1024, 768 and 390. Zero horizontal overflow at every width. On phones: wide tables and
diagrams scroll inside `.bdh-scroll-x.mask-x` with `tabindex="0"`, a role and a label; multi-column
grids collapse to one column with reading order intact; tap targets ≥ 44px; nothing clipped,
truncated mid-word, or below the site's smallest type. **Look at every section at 390 before calling
anything done.**

---

## 3. Voice and truthfulness

- Enterprise consultancy tone: calm, precise, confident; short active sentences; no exclamation
  marks; no startup hype. First line of every partial: `<?php /* DRAFT COPY — review before launch */ ?>`
- AI-native shown concretely (agents, evals, guardrails, human approval, audit logs), never merely claimed.
- **Never** use the Xterra Edze logo as the example client — mocks say "Your company" / "Your platform".
  No real client names, no fake testimonials, no case studies naming companies.
- Any claim that Xterra Edze holds a certification or partner status, or states headcount, client count
  or achieved results, needs `<!-- PLACEHOLDER: confirm … before launch -->` directly above it, or must
  be phrased as a target or typical range. Same for prices, timelines and response times.
- Technology names and logos are wanted, framed as technologies we work with — never implying a
  partnership tier. Standards are code-built badges framed as "frameworks we build to", never official
  seal artwork.
- Technical content must be correct and specific (Core Web Vitals good = LCP ≤ 2.5 s, INP ≤ 200 ms,
  CLS ≤ 0.1; SCI = ((E × I) + M) per R; OWASP LLM01 is prompt injection; and so on).
- **Sibling pages must not share a template.** Each page gets its own concept, section structure,
  components, imagery and motion. Only tokens, typography, nav/footer, the onward aid and the services
  catalogue repeat.

### Photography
Real, licensed Unsplash photos, credited in a `CREDITS.md` beside the images
(`File | Used in | Unsplash user | Unsplash page`). Unsplash's search endpoint is behind a bot check:
find ids via web search (`site:unsplash.com <subject>`), then fetch
`https://unsplash.com/photos/<id>/download?force=true&w=1800` — the redirect reveals the photographer
for the credit. Unsplash+ / `plus.unsplash.com` ids return 403; skip them. Credited photos already
exist under `assets/imgs/tech/`, `assets/imgs/brand/` and `assets/imgs/disciplines/` — copy what you
reuse into the new page's folder and credit it again. **A credit pointing at the wrong photo is a
critical defect** — verify by fetching the credited page and comparing.

---

## 4. Tooling

```bash
php -S 127.0.0.1:<PORT> router.php          # dev server WITH clean URLs (run from repo root)
php build.php                                # bundle sections/*.css|js — only needed for the home page
php -l <file.php>                            # lint
node --check <file.js>                       # lint
XE_BASE=http://127.0.0.1:<PORT> python3 tools/shot-brand.py <page.php> --out <dir>
#   one shot per section; --m (390) --w 1024 --live --reduced --full --sel <selector>
#   prints horizontal overflow, console errors, failed requests and PHP warnings
```
Playwright (Python) is available for interaction tests and JS-disabled checks. **Read the PNGs** —
judge with your eyes, not from the file list. Give every parallel agent its own port.

---

## 5. State — what is done

| Area | State |
|---|---|
| Brand Design hub + 6 capability pages | done, reviewed, polished (the benchmark) |
| Technology & Intelligence hub + 10 capability pages | done, independently reviewed, 186 fixes applied |
| Home page | 25 sections as a five-chapter story with a chapter rail; 23/24/25 built; reviewed + polished. Sections 11, 15, 18, 19 are kept as files but not rendered (real logos / fake testimonials / duplicate CTAs) — `index.php` `$HX_CHAPTERS` |
| Industries, Work, Approach, Careers, What we do (`/services/`), 404, Contact | built → critiqued → polished → verified, on `cloud/index-rebuild` |
| Legal suite (`legal/` — hub, privacy, terms, cookies + working preferences, accessibility, commercial policy, IP & trademarks, responsible AI, security, `.well-known/security.txt`) | built → critiqued → polished → verified; every identifier and legal judgement is a PLACEHOLDER for counsel |
| The 4 new discipline hubs + 24 capability pages (one template per discipline, topic-specific showcases) | built → critiqued → polished → verified, on `cloud/discipline-pages` |
| Services catalogue + lead-tagged contact | done; careers applications and the home booking form also post to `/contact` |
| Clean URLs + designed 404 | done (router.php + .htaccess final rule) |

Nothing is deployed. `docs/KIT.md` is the compact build reference agents read instead of the benchmark source.
Open owner items: real logos (s11), testimonials (s15), stock/placeholder photography, illustrative figures, legal entity details,
® registration, careers openings and benefits, response times.

---

## 6. The work queue, in priority order

### A. Four discipline hub pages — the main job
Build `services/<slug>.php` for each, to the standard of `services/technology-intelligence.php`.

| Discipline | slug | prefix | capabilities |
|---|---|---|---|
| Campaign & Content Design | `campaign-content` | `cch` | 8 |
| AI Design | `ai-design` | `aih` | 4 |
| Product & Experience Design | `product-experience` | `pxh` | 5 |
| Marketing Technology | `marketing-technology` | `mth` | 7 |

Each owns `services/<slug>.php`, `partials/<slug>/`, `assets/css/<slug>.css`, `assets/css/<slug>/`,
`assets/js/<slug>/`, `assets/imgs/<slug>/`. The content is already in `data/<slug>.php` and
`data/services/<slug>.php` — **read both in full before designing**.

- 14–17 sections, each world-class. No filler.
- Shell mirrors `services/technology-intelligence.php` (`$BASE = '../'`): loads `brand/hub.css`,
  `tech/kit.css`, `<slug>.css`, then per-section CSS; `brand/hub.js` then per-section JS, each only
  when the file exists and is non-empty. Partial variables: `$SITE`, `$DISC` (this discipline's row
  from `$SITE['disciplines']`), `$CAPS` (`require data/<slug>.php`), `$STACK`
  (`require data/tech-stack.php`); `require_once partials/tech/kit.php`. Wrap in
  `<main id="main" class="bdh <prefix>">`, include `partials/cta.php` before `</main>`, keep a
  JSON-LD Service block.
- Must include: a signature interactive showcase; the discipline's own platform stack via
  `xt_stack()`; the standards it genuinely works to via `xt_badge()` (don't attach security
  certifications to work that doesn't involve them); a concrete AI-native angle; process; deliverables;
  outcomes and how they're measured; a FAQ; and the services catalogue immediately before the FAQ.
- **Capability links**: the subpages don't exist yet. Link each capability to an anchor on the hub
  (`xe_url('<slug>.php')` + `#<capability-slug>`) and give each capability card a stable id. Never
  link to a page that doesn't exist.
- **Each hub sets the visual language for its whole discipline.** Its capability subpages will reuse
  its components with different content, so build a card system, a diagram idiom, a data-viz idiom and
  a stepper that generalise. Record which components the subpages should reuse.
- **Marketing Technology**: "Customer Relationship Strategy" is ONE capability covering journey
  mapping, segmentation & insights, engagement programmes, loyalty strategy and lifecycle marketing.
  One page with those five as its sections — never five capabilities, never five pages.

### B. Home page showcase sections
`index.php` already loads `brand/hub.css`, `tech/kit.css`, `brand/hub.js` and requires
`partials/tech/kit.php`, and `$SECTIONS` already lists `23-brand`, `24-technology`, `25-offer` in
position. Build those three `sections/<id>.{php,css,js}` files, then `php build.php`.

- **Add only.** The 22 existing sections and the hero must not be deleted, reworded, restyled or
  reordered. Prove it with `git diff --stat` — the only changed tracked file should be `index.php`.
- `23-brand`: what we make for a brand — the six capabilities from `data/brand-design.php`, linking to
  the brand hub and each capability page.
- `24-technology`: what we build and run — the ten capabilities, the stack, the standards.
- `25-offer`: concrete services by category with engagement packages, leading to contact.
- Class prefix is `s23` / `s24` / `s25`. Don't repeat what `02-showcase`, `08-disciplines`,
  `14-platforms` or `18-engagements` already say — read them first.

### C. Refine the weak existing home sections
Audit all 22 against the benchmark and score each: leave-alone (8+), light-polish (6–8),
weak-rework (<6). **Only touch the weak ones** — the owner likes the page and does not want working
sections churned. Preserve every fact, link and heading; raise the craft. A light-polish section gets
finish work only, never a component rebuild.

### D. Site-wide mobile pass
Every page — brand, tech, the four new hubs, home, contact — at 390 and 768. See the mobile rules in
§2. File each phone problem as its own finding and fix it.

### E. Contact page
Review and improve `contact.php` + `partials/contact/`. The POST pre-fill flow works; the page itself
has not had an independent design review.

### F. The 24 capability subpages (later, a large job)
8 Campaign & Content + 4 AI Design + 5 Product & Experience + 7 Marketing Technology. Each reuses its
discipline hub's UI language with its own content, exactly as the ten Technology pages do. They also
need a per-discipline "onward" aid between siblings — see `partials/tech/next.php` for the role.

---

## 7. How to run this well

The pattern that produced the quality on this site is **build → independent critique → polish**, one
page at a time, in parallel across pages:

1. **Build** — one agent per page, owning only that page's files.
2. **Critique** — a *different* agent, adversarial, editing nothing. It screenshots the page at 1440,
   1024, 768 and 390 plus `--live`, `--reduced` and JS-disabled; screenshots the benchmark for
   comparison; greps the CSS for rule breaches; drives every control with Playwright; checks every link
   resolves; and scores the page out of 10 with severity-tagged findings and evidence.
3. **Polish** — applies every critical and major finding, rebuilds whatever the reviewer called
   weakest, and re-verifies the whole page.

This is not optional ceremony. On the ten Technology pages the independent review found **186 real
defects** that the builders' own self-checks had missed — including sections that rendered blank
without JavaScript, a photo credited to the wrong photograph, and contradictory figures between
sections of the same page.

Useful practices learned here:
- Give each parallel agent its **own port** and its **own files**, and have it prove with
  `git diff --stat` that it touched nothing else.
- A reviewer finding can be wrong. Verify before changing, and record declined findings with the reason
  rather than adding dead code.
- When a defect is found, fix its **root cause in the shared file** and sweep the whole site for other
  instances, rather than patching the one page it was reported on.
- Report anything skipped or capped **by name** — never drop work silently.

---

## 8. The four-agent strategy

This is the exact pipeline that produced the quality on this site. Run it **per page**, and run
pages **in parallel** — one set of four agents per page, each set with its own dev port.

**The benchmark is the Brand Design pages**: `services/brand-design.php` and, above all,
`services/brand-design/brand-identity.php` and `services/brand-design/brand-ai-tools.php`. Every
agent below screenshots them and judges against them. `services/technology-intelligence.php` and its
ten capability pages are the second reference — they were built to beat Brand Design and were
independently reviewed.

### Agent 1 — Builder
**Owns** only its own page's files: the shell, `partials/<page>/`, `assets/css/<page>.css`,
`assets/css/<page>/`, `assets/js/<page>/`, `assets/imgs/<page>/`. Touches nothing else.

Reads the benchmark partials, CSS and JS **in full** before designing, and screenshots the benchmark
so its judgement is visual. Builds every section: partial + its own CSS + its own JS wherever it
moves. Sources and credits its own photography. Then verifies: `php -l`, `node --check`, screenshots
at 1440, 1024, 768 and 390 plus `--live`, `--reduced` and a JavaScript-disabled load. Fixes every PHP
warning, console error, failed request and overflow. **Does at least two full look-and-fix passes, one
of them entirely at 390.** Proves with `git diff --stat` that it touched only its own files.

### Agent 2 — Critic
**A different agent. Edits nothing** — scratch scripts only. Adversarial by instruction: its job is to
find what is weak, generic, wrong, broken, template-like or below the benchmark, and it assumes there
are real defects to find.

Every finding carries evidence — a screenshot path, a `file:line`, a grep hit, or a Playwright result
— a severity, and a concrete fix:
- **critical** — broken, false, a design-system breach, or blank without JavaScript
- **major** — clearly below benchmark, or a requested element missing
- **minor** — polish

It must run, as separate passes:
1. **Visual** — the page at 1440, 1024, 768, 390, `--live`, `--reduced`, read section by section,
   against screenshots of the Brand Design benchmark taken in the same run.
2. **Mobile at 390** — its own pass,each problem filed separately: overflow, clipped or truncated text,
   overlapping elements, columns that did not collapse, broken reading order, tap targets under 44px,
   type below the site's smallest size, wide tables or diagrams that neither scroll nor reflow.
3. **No-JavaScript** — every section complete and readable with JS disabled; `--reduced` shows the
   finished state, not a frozen mid-animation one.
4. **Depth and distinctness** — is every section world-class? Is the signature showcase real software?
   Has it borrowed a hero layout, showcase mechanic or card pattern from a sibling or the benchmark?
5. **Rules** — grep the page CSS for non-token colours, gradients other than mask fades, `!important`,
   stray `font-family`; one `h1`, an `h2` per section; `aria-hidden` + `.bdh-sr` on mocks; `th scope`;
   keyboard operation; duplicate ids; hrefs ending `.php`; console errors; PHP warnings.
6. **Truthfulness** — unmarked claims about certifications, partnerships, headcount, clients or
   results; real company names as clients; photo credits that do not match their photograph.
7. **Links and catalogue** — follow every link (must return 200); the services catalogue renders and
   an Enquire link pre-fills the contact page.
8. **Weight** — HTML size and DOM node count, with the cause of anything disproportionate.

It ends with a score out of 10 against the benchmark and names the weakest sections plainly.

### Agent 3 — Polisher
**Owns the same files as the builder.** Applies every critical and major finding, and the minors
unless there is a good reason not to — recorded with the reason.

Order of work: critical defects first, then **mobile findings**, then the sections the critic called
weakest — those need real design work, not a tweak: rebuild the component, deepen the content, fix
spacing and hierarchy until the section stands beside the benchmark's best. If a finding needs a
shared file it does not own, it does not change it — it records what that file needs.

**A critic finding can be wrong.** Verify before changing, and record a declined finding with the
evidence rather than adding dead code. Then re-verify the whole page exactly as the builder did,
including the 390 pass and the JavaScript-disabled load.

`pass` = no PHP warnings, no console errors, no failed requests, no overflow at any width, no section
blank without JS, and no remaining critical or major finding.

### Agent 4 — Verifier
Runs once across **all** the pages in the batch, after their polishers finish. Mechanical and
adversarial about regressions:
- every page returns 200, with exactly one `h1` and no duplicate ids
- PHP warnings, console errors, failed requests, overflow at 1440 and 390
- JavaScript disabled: list by id any section that renders blank or half-drawn
- crawl every internal link on every page: none may 404, none may contain `.php` or `index`
- nav, mega menu and mobile sheet list every page and all resolve
- no page-level CSS has leaked into the shared services catalogue or the onward aid
- `git status` / `git diff --stat`: confirm no file outside the intended set changed, and nothing was
  deleted

It fixes only small, obvious breakages; anything larger it reports.

### Rules that make the parallelism safe
- One page per agent set. **Each agent gets its own dev port** and its own files.
- Every agent proves with `git diff --stat` that it touched only what it owns.
- Never edit `data/site.php`, `partials/init.php`, `partials/head.php`, `partials/nav.php`,
  `partials/footer.php`, `partials/cta.php`, `partials/tech/kit.php`, `partials/services/*`,
  `assets/css/core.css`, `assets/js/core.js`, `assets/css/tech/kit.css`, or anything under
  `/brand/` — the Brand Design files are the read-only benchmark.
- Report anything skipped or capped **by name**. Never drop work silently.

### Why it is worth the tokens
On the ten Technology pages, the independent critic found **186 real defects** the builders' own
self-checks had passed as clean — including nine sections on one page that rendered blank without
JavaScript, a photograph credited to the wrong photographer, contradictory figures between two
sections of the same page, and a filter that silently showed all 174 items instead of the selected
layer. A builder reviewing its own work does not find these.
