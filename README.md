# XTERRA EDZE — website

A PHP site with no framework and no dependencies. Every page shares one head, one
navigation and one footer, so the chrome can never drift between pages.

```bash
php -S localhost:8000        # run it
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

data/site.php             SINGLE SOURCE OF TRUTH — company, nav, disciplines, footer
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

Helpers from `partials/init.php`: `xe_url($path)`, `xe_svg($name)` (inlines a brand SVG
so it inherits `currentColor`), `e($string)` (escapes), `xe_section($name)`,
`xe_discipline_url($d)`.

## The design system

| Token | Value | Role |
|---|---|---|
| `--blue` | `#0082FB` | **the primary** — buttons, active states, accents |
| `--paper` | `#FFFFFF` | the page |
| `--ink` | `#19191D` | type, the nav pill, a few dark panels |
| `--txt` / `--muted` / `--faint` | `#4A4A52` / `#75757E` / `#8A8A93` | body, secondary, meta |
| `--line` / `--line-2` | `#E7E7EA` / `#F0F0F1` | borders and dividers |

JetBrains Mono throughout, embedded in `core.css` so it renders identically anywhere.
Headings are weight 500 with tight negative tracking; every section title is the same
size, above an eyebrow label. Blue never appears inside a heading — headings are ink
with a grey first phrase. `.aurora` + `.dither` give the animated blue wash used in the
hero, the brief section and the footer.

## The home page, in order

hero · brief ⇄ delivered · six disciplines · win on what compounds · signal flow ·
equip your team · AI design · industries · delivered · clients · production ·
how we work · AI runs the operation · platforms · proof · why · testimonials ·
engagements · CTA card · booking · FAQ · closing band

Re-order by editing `$SECTIONS` in `index.php`.

## PLACEHOLDERS — before this goes live

1. **The eight client logos** on the home page came from a reference site. **They are
   not Xterra Edze clients.** Replace or delete each one.
2. **All imagery** in the showcase, industries, proof, production, clients, operation
   and delivered sections is reference material.
3. **All six testimonials** are written placeholders and the portraits are stock — the
   attribution is role and sector only, so no real person is named. Replace both.
4. **Figures** — `380+ programmes`, `9 markets`, `12 industries`, `established 2012`
   came from the previous site, not the content document. Confirm each.
5. **The Ludhiana studio has no street address**, and the New Delhi one
   (6 Worldmark, Aerocity) is carried over. Confirm both.
6. **Booking** collects a request and composes an email — nothing is reserved, and the
   UI never claims otherwise. Three hooks in `sections/20-booking.js` are marked for
   wiring to a real calendar.
7. **Careers, Privacy, Terms and the social links** point at `#`.

Nothing on the site claims a certification, or a partnership with OpenAI, Anthropic,
Google or Adobe — the platforms section only describes how the tools are used.

## Accessibility & performance

One `h1` per page, no heading-level jumps, no duplicate ids, no dead internal links.
Every control is keyboard-operable with a visible focus ring. `prefers-reduced-motion`
stops all motion and each section still reads correctly. Images carry explicit
dimensions and lazy-load; looping media pauses off screen.
