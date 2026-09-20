# XTERRA EDZE — website

A PHP site with no framework and no dependencies. Every page shares one head, one
navigation and one footer, so the chrome can never drift between pages.

```bash
php -S localhost:8000 router.php   # run it (router.php gives the clean URLs .htaccess gives Apache)
php build.php                # bundle the section css/js after editing a section
```

Then open <http://localhost:8000>. PHP 8+ is all it needs. (It has to be served —
opening a `.php` file from Finder will not work.)

## Structure

```
index.php                 home — includes the sections listed in $SECTIONS
industries.php  work.php  approach.php  careers.php  contact.php
services/
  index.php               the six disciplines, listed
  brand-design.php  technology-intelligence.php  campaign-content.php
  ai-design.php     product-experience.php       marketing-technology.php

partials/
  init.php                bootstraps a page: loads data, defines helpers, sets $BASE
  head.php                <head> + <body> + the intro animation
  nav.php                 the pill navigation, its mega menu and the mobile sheet
  page-hero.php           the top of every inner page
  cta.php                 the closing band, reused at the foot of inner pages
  footer.php              the footer and the closing scripts
  services/               the shared "Services & packages" catalogue (lib.php + catalogue.php)
  contact/handler.php     the contact page's query, POST and lead email

data/site.php             SINGLE SOURCE OF TRUTH — company, nav, disciplines, footer
data/services/            what each page sells: packages.php + one file per discipline
sections/                 the home page, one .php + .css + .js per section
assets/css|js|brand|fonts|imgs|animation
build.php                 bundles sections/*.css|js → assets/css|js/sections.*
docs/copy-deck.md         the approved copy, and what is still placeholder
tools/shot.py             screenshots every section against the dev server
```

## How a page is put together

```php
<?php
$BASE = '';                      // '../' for anything inside a sub-folder
require 'partials/init.php';
$page = ['key' => 'work', 'title' => 'Work', 'desc' => '…'];
$hero = ['eyebrow' => 'Selected work', 'title' => 'Delivered.', 'lead' => '…'];
include 'partials/head.php';
include 'partials/nav.php'; ?>
<main id="main">
  <?php include 'partials/page-hero.php'; ?>
  …your sections…
  <?php include 'partials/cta.php'; ?>
</main>
<?php include 'partials/footer.php'; ?>
```

`$page['key']` marks the current item in the navigation. `$BASE` is the path back to
the root — every asset and link in the chrome is written through `xe_url()`, so pages
work at any depth.

**Change the navigation, the disciplines or the footer in `data/site.php` only.** The
nav, the mega menu, the mobile sheet, the footer columns and the six service pages all
read from it.

Helpers from `partials/init.php`: `xe_url($path)`, `xe_asset($path)` (a stylesheet or
script URL stamped `?v=<file time>` — Hostinger's CDN caches assets for a week, so every
CSS/JS link must go through it or a deploy won't show), `xe_svg($name)` (inlines a brand
SVG so it inherits `currentColor`), `e($string)` (escapes), `xe_section($name)`,
`xe_discipline_url($d)`.

## Deploying

`./deploy.sh --dry` previews, `./deploy.sh` uploads only what changed (see the header of
the script). Don't upload through hPanel's File Manager — it copies `.git`, `docs/`,
`tools/`, `build.php` and this README onto the public site, which `deploy.sh` never does.

## The design system

| Token | Value | Role |
|---|---|---|
| `--blue` | `#0082FB` | **the primary** — buttons, active states, accents |
| `--paper` | `#FFFFFF` | the page |
| `--ink` | `#19191D` | type, the nav pill, a few dark panels |
| `--txt` / `--muted` / `--faint` | `#4A4A52` / `#75757E` / `#8A8A93` | body, secondary, meta |
| `--line` / `--line-2` | `#E7E7EA` / `#F0F0F1` | borders and dividers |

Three typefaces, split by role:

| Token | Face | Used for |
|---|---|---|
| `--f-h` | Outfit (`assets/fonts/`, preloaded) | **headings** — h1–h5, section and card titles, big statements |
| `--f` | JetBrains Mono (embedded in `core.css`) | **labels & figures** — eyebrows and uppercase labels, index numbers, stats, mock-UI readouts |
| `--f-b` | Montserrat (`assets/fonts/`, preloaded) | **reading** — body copy, leads, captions, descriptions, buttons, links, nav, form fields |

`body` is Montserrat and h1–h5 are Outfit, so most text needs no rule; labels and
figures opt into mono with `font-family:var(--f)`. Montserrat is Regular 400 for running
text, Medium 500 for UI labels and emphasis, Semibold 600 sparingly — never with negative
tracking. Headings are weight 500 with light negative tracking; every section title sits
above an eyebrow label. Blue never appears inside a heading — headings are ink
with a grey first phrase. `.aurora` + `.dither` give the animated blue wash used in the
hero, the brief section and the footer.

## The home page, in order

hero · brief ⇄ delivered · six disciplines · win on what compounds · signal flow ·
equip your team · AI design · industries · delivered · clients · production ·
how we work · AI runs the operation · platforms · proof · why · testimonials ·
engagements · CTA card · booking · FAQ · closing band

Re-order by editing `$SECTIONS` in `index.php`.

## The Brand Design page (`services/brand-design.php`)

A shell that includes one partial per section, in the order set by `$HUB`:

hero · capability navigator · why now · the six capabilities · inception → delivery
(programme map) · AI brand OS (live demo) · agents and people · the handover kit ·
touchpoints · industries · global scale · sustainability · measurement · how we work
with enterprises · services & packages · FAQ · closing band

(The old "ways to work together" section, `partials/brand/hub/engagement.php`, is out of
the running order: the catalogue's packages row replaced it. Its four models became
offers in the hub's "Programmes & operations" category.)

Each section is `partials/brand/hub/<id>.php` with its own
`assets/css/brand/hub/<id>.css` and `assets/js/brand/hub/<id>.js` (loaded automatically
when non-empty, cache-busted by file time). Shared primitives (`.bdh-*` grid, heads, image
frames, cards, tabs, motion utilities) live in `assets/css/brand/hub.css`; shared
behaviour (`window.BDH`: tabs, timelines, typing, count-up, scroll progress, parallax —
all pausing off-screen and respecting reduced motion) lives in `assets/js/brand/hub.js`.
Capability names, one-liners and links come from `data/site.php`; kickers, leads,
deliverables and timings from `data/brand-design.php`. Photos sit in
`assets/imgs/brand/hub/<id>/`, each folder with its own `CREDITS.md`.

## Brand capability pages (`services/brand-design/<slug>.php`)

Six pages, one per Brand Design capability, reached from the hub's capabilities section,
the mega menu and the mobile sheet. Each is a shell like the hub: an array lists the
sections in order, each section is `partials/brand/<slug>/<id>.php` with
`assets/css/brand/<slug>/<id>.css` and `assets/js/brand/<slug>/<id>.js` (loaded when
non-empty), plus a page base `assets/css/brand/<slug>.css`. A page may use the hub's
layout utilities (`hub.css`) and `window.BDH` helpers (`hub.js`), but every visible
component is its own. Copy comes from `data/brand-design.php` (`$BD[slug]`) and
`data/site.php`; new copy sits in DRAFT COPY arrays at the top of a partial. Photos are in
`assets/imgs/brand/<slug>/`, each with a `CREDITS.md`.

| Page · prefix | Concept | Signature demo | Sections |
|---|---|---|---|
| Growth Strategy · `cgs-` | The terrain: the market as ground to be read | Next-best-customer scorer: weighting sliders re-rank Segments A–F, with an agent note | hero · hides · ledger · scorer · whitespace · thesis · route · moves · kpi · pack · outcomes · services · faq · onward |
| Brand Identity · `cbi-` | The specimen book, set plate by plate | Voice and tone tuner: a context and two dials rewrite a line | hero · anatomy · offer · construct · colour · type · voice · motion · touchpoints · process · deliver · outcomes · services · onward |
| Brand Foundation · `cbf-` | The decision document: clauses, redlines, appendix | Positioning composer: an agent stress-tests the statement, a person signs it off | hero · essay · charter · tensions · composer · rules · narrative · revisions · onepage · appendix · room · services · transcript · seealso |
| Brand Systems · `cbs-` | The living system, run like a product | Live token editor: controls rewrite tokens, components re-render, export in three formats | hero · editor · manifest · flex · inventory · templates · governance · docs · process · bundle · adoption · services · faq · onward |
| Brand Architecture · `cba-` | The portfolio as structure, drawn as a drawing set | Model spectrum: a slider walks branded house → house of brands | hero · audit · offer · spectrum · lockup · naming · wayfinding · migration · process · register · outcomes · services · faq · onward |
| Brand AI Tools · `cat-` | The machine room: tooling with people in charge | Generation playground: brand-locked prompt → variants → automated brand check → review | hero · help · curate · playground · guardrails · eval · provenance · vault · deploy · registry · reports · services · man · onward |

Every page opens with a breadcrumb back to Brand Design and ends with its own onward
section (the other five capabilities, its two `$BD` pairs marked), then `partials/cta.php`.

## Services & packages (the shared catalogue)

The one component that is deliberately identical on every discipline hub and capability
page: what we sell there, grouped by category, plus the engagement packages, each leading
to the contact page with the selection already made.

**Add it to a page** — one line, placed immediately before the page's FAQ (or before its
closing onward section when it has no FAQ):

```php
<?php $svc_key = 'growth-strategy'; include __DIR__ . '/../../services/catalogue.php'; ?>
```

On the Brand pages that line lives in `partials/brand/<slug>/services.php` (hub:
`partials/brand/hub/services.php`) and `'services'` sits in the shell's running order. Also
add `assets/css/services.css` and `assets/js/services.js` to the page's css/js lists. The
component needs nothing else (no BDH); on pages that load `partials/tech/kit.php` the tools
row shows real logos through `xt_logo()`, elsewhere their names.

**Where the data lives** — `data/services/packages.php` (sprint · project · milestone ·
retainer · enterprise · squad: name, tagline, typical duration, pricing model, includes,
best for, icon) and `data/services/<discipline>.php`, keyed by page key (the discipline slug
for its hub, the capability slug for each page). Every file in `data/services/` is loaded
automatically; the schema and helpers (`svc_find()`, `svc_contact_url()` …) are documented
at the top of `partials/services/lib.php`. A service id is `<page-key>:<offer-key>`.

**How it behaves** — without JS it is a GET form: every category stacked, "Add to brief"
checkboxes, a package select and "Continue to contact". With `services.js`: category tabs
(arrows, Home/End), a brief tray that docks to the bottom of the screen, a brief that
persists across pages for the visit (sessionStorage), and "Choose <package>" links that
carry the services already picked. Styles are `.svc-*` in `assets/css/services.css`.

## Contact (`contact.php`)

Arrives pre-filled from any catalogue: `contact?service[]=<id>&package=<key>&from=<page>`
(a comma list in `?service=` works too). Ids are checked against the data, the brief card
lists each with its discipline and page, and the form offers every discipline's services
(those without a data file show their capabilities from `data/site.php`). The POST is
handled in `partials/contact/handler.php`: validation, a honeypot, a minimum fill time, one
plain-text email to `company.email` (Reply-To the visitor, subject `[Lead] …`), then a
redirect to `?sent=1`. When `mail()` fails, as on local XAMPP, the page says so and offers
a `mailto:` link holding the same brief. Nothing is stored on disk.

## PLACEHOLDERS — before this goes live

1. **The eight client logos** on the home page came from a reference site. **They are
   not Xterra Edze clients.** Replace or delete each one.
2. **All imagery** in the showcase, industries, proof, production, clients, operation
   and delivered sections is reference material.
3. **All six testimonials** are written placeholders and the portraits are stock — the
   attribution is role and sector only, so no real person is named. Replace both.
4. **Figures** — `380+ programmes`, `9 markets`, `12 industries`, `established 2012`
   came from the previous site, not the content document. Confirm each.
5. **Offices** — the two Ludhiana addresses (SCO-2 LGF and SCO-1 3rd Floor, Noble
   Enclave, Ferozepur Road) are confirmed; the New Delhi one (6 Worldmark, Aerocity)
   is carried over from the previous site. Confirm it. All three live in
   `data/site.php` → `company.studios`.
6. **Booking** collects a request and composes an email — nothing is reserved, and the
   UI never claims otherwise. Three hooks in `sections/20-booking.js` are marked for
   wiring to a real calendar.
7. **The footer legal links** (Privacy Notice, Terms of Use, Cookie Preferences,
   Accessibility, Commercial Policy) and the LinkedIn / Instagram links point at `#` —
   set them in `data/site.php` → `legal` and `social`.
8. **Brand Design page** — all copy is marked DRAFT; every photo is free Unsplash
   reference imagery (credited per folder); timings, the rollout matrix, the weight
   budget and the brand-health dashboard are illustrative and carry PLACEHOLDER comments.
9. **Brand capability pages** (the six under `services/brand-design/`) — all new copy is
   DRAFT; every photo is free Unsplash reference imagery credited in
   `assets/imgs/brand/<slug>/CREDITS.md`. Everything marked "Illustrative" on the page is
   invented and carries a PLACEHOLDER comment in its partial (`grep -rn PLACEHOLDER
   partials/brand/<slug>`): Growth Strategy's segment scores, weights, share figures, KPI
   tree, competitor positions, memo and route weeks; Brand Identity's mark proportions and
   values, motion timings and guideline page numbers; Brand Foundation's remarks (not
   client quotations), positioning statement and options, value rulings, narrative and
   version diffs; Brand Systems' flex ranges and presets, versions, changelog and content
   hashes; Brand Architecture's portfolio audit data, model scoring, navigation figures,
   migration timings and issue weeks; Brand AI Tools' command output, dataset and pipeline
   counts, guardrail policy thresholds, evaluation figures, provenance manifest, versions
   and outcome figures. Agent notes and rewrites are pre-authored, not live model output.

10. **Services & packages** — every offer is DRAFT copy; every typical timeline in
    `data/services/*.php` and every package duration in `packages.php` is marked
    PLACEHOLDER. No prices are shown anywhere, by design.
11. **Contact** — confirm where leads should go (email or a CRM) and the sending address
    (`partials/contact/handler.php`, marked PLACEHOLDER); the budget bands are in US dollars
    until the currency is confirmed; link the consent line to the Privacy Notice once it
    exists.

Nothing on the site claims a certification, or a partnership with OpenAI, Anthropic,
Google or Adobe — the platforms section only describes how the tools are used.

## Accessibility & performance

One `h1` per page, no heading-level jumps, no duplicate ids, no dead internal links.
Every control is keyboard-operable with a visible focus ring. `prefers-reduced-motion`
stops all motion and each section still reads correctly. Images carry explicit
dimensions and lazy-load; looping media pauses off screen.
