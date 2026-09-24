# Build kit — the compact reference (read this instead of the benchmark source)

`docs/BUILD-BRIEF.md` stays the rulebook (§2 design system + five defect classes, §3 voice/truth, §8 roles).
This file is the working digest so no agent has to read the benchmark partials in full.

## Cost discipline (the whole site must fit a small budget)
- Read BUILD-BRIEF §2, §3, §8 and this file. Do NOT read benchmark partials/CSS/JS in full; open at most one or
  two specific benchmark files by `sed -n` range when you need an exact pattern.
- Benchmark screenshots already exist — look at 4–6 of them, don't re-shoot the benchmark:
  `/tmp/claude-0/-home-user-xe-website/d6c5a1e0-89df-5cde-abe9-b19a2da46e96/scratchpad/bench/{1440,390}/`
  (`brand-design-*` = hub, `brand-design-brand-identity-*`, `brand-design-brand-ai-tools-*`).
- Never `cat` large files; use `grep -n` and `sed -n a,bp`. Never Read `assets/css/core.css` whole.
- Screenshot with purpose: one full pass at 1440 and one at 390 per page, then targeted `--sel` re-shots.
- Write each file once, well; don't rewrite whole files to change a line.

## Page shell (copy this pattern; `$BASE` is `'../'` under services/, `''` at the root)
```php
<?php
/* <Page> — concept in one line. Sections: partials/<page>/<id>.php (+ assets/css/<page>/<id>.css, assets/js/<page>/<id>.js). */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';          // only if the catalogue is used
$STACK = require __DIR__ . '/../data/tech-stack.php';
$SECTIONS = ['hero', '…'];
$pp_root = __DIR__ . '/../';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/<page>.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/<page>/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/<page>/$pp_id.js"))   $pp_js[]  = $x;
}
// catalogue last so page CSS can't win over .svc-*:  $pp_css[] = 'assets/css/services.css'; $pp_js[] = 'assets/js/services.js';
$page = ['key' => 'services', 'title' => '…', 'desc' => '…', 'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>
<main id="main" class="bdh <prefix>">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/../partials/<page>/$pp_id.php"; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([...], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
```
`$page['key']`: `services`, `industries`, `work`, `approach`, `careers`, `contact`, `home` (nav highlight).
Locals: prefix every variable with your page prefix — nav/cta/footer use `$c $d $i $k $item $url $current $disc $col $l $s`.
Services catalogue: `<?php $svc_key = '<key>'; include __DIR__ . '/../services/catalogue.php'; ?>` from `partials/<page>/`
(keys = discipline slug on a hub, capability slug on a capability page; AI Design's Brand AI Tools = `ai-brand-tools`). Never restyle `.svc-*`.

## Section skeleton
```html
<?php /* DRAFT COPY — review before launch */ ?>
<section class="band [band--alt|band--ink] <prefix>-<id>" id="<id>" aria-labelledby="<id>-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Eyebrow</p>
           <h2 class="h2" id="<id>-t"><span class="g">Grey first phrase.</span> Ink rest.</h2></div>
      <div><p class="lead">Lead…</p></div>
    </div>
    …
  </div>
</section>
```
Heads: `.bdh-head` (stack) · `.bdh-head--row` (heading left, lead right; stacks ≤860) · `.bdh-head--c` (centred; left-aligns ≤600).
One `h1` (hero, class `d1` or `d2`). `h2.h2` per section, `h3` for cards. Hero: `band` with `--bdh-hero-t` top padding.

## Tokens (core.css — the only colours allowed)
Paper `--paper --paper-2 --paper-3 --paper-4` · ink `--ink --ink-2` · text `--txt --muted --faint --ghost` ·
lines `--line --line-2 --line-3 --dot` · blue `--blue --blue-d --blue-wash --blue-wash-2 --blue-line` ·
on ink `--on-ink --on-ink-2 --on-ink-3 --on-ink-line --on-ink-card` · radii `--r-xs --r-sm --r --r-lg --r-xl --r-pill` ·
shadows `--sh-1 --sh-2` · easing `--e --e-io` · type `--t-d1 --t-d2 --t-h2 --t-h3 --t-h4 --t-lead --t-body --t-sm --t-xs --t-lbl`(11px, the floor) ·
fonts `--f-h` (Outfit, headings) `--f` (JetBrains Mono, labels/figures/readouts) `--f-b` (Montserrat, body/buttons) · layout `--wrap --gutter --nav-h --band`.
Core classes: `.wrap .band .band--alt .band--ink .band--tight .head .head--row .lbl .lbl--blue .dot .g .d1 .d2 .h2 .h3 .lead .p .sm .tl`(text link) `.btn .btn--ink`(blue) `.btn--white .btn--out .btn--dark .btn--blk .btn--sm .btn--lg .i`(chevron) `.pill .card .sr .dots .aurora .dither .mask-x`.
On `.band--ink`, core already maps h2/h3/.g/.lbl/.p/.tl/.card/.pill to on-ink colours.

## .bdh-* primitives (assets/css/brand/hub.css — needs `bdh` on `<main>`)
Grid `.bdh-grid` + `.bdh-c3…c8/.bdh-c12` spans, `.bdh-s2…s9` starts (all collapse ≤860) · `.bdh-sticky` (static ≤1023) ·
image `figure.bdh-img.bdh-img--r45|r34|r43|r169|r219|r11` (+`--xl`, `[data-bdh-parallax="0.06"]`, `.bdh-zoom`) · `.bdh-cap-chip` ·
cards `.bdh-card` `.bdh-card--ink` · type roles `.bdh-idx` (mono blue index) `.bdh-t` `--s` `--l` `.bdh-d` · `.bdh-tag` `--blue` `.bdh-tags` `.bdh-meta` `.bdh-rule` ·
mock UI `.bdh-ui` `.bdh-ui--ink` `.bdh-ro` (mono readout) `.bdh-ok` `.bdh-flag` `.bdh-pulse` ·
controls `.bdh-tabs` `.bdh-seg` `.bdh-switch` · wide content `.bdh-scroll-x.mask-x` (+ `tabindex="0" role="region" aria-label`) ·
motion `.bdh-grow` `.bdh-up` (start states only apply after JS adds `.is-in`; head.php's `<noscript>` restores them) · `.bdh-panes`/`.bdh-pane` (one grid cell, `.is-on`) · `.bdh-caret` · `.bdh-sr` screen-reader sentence for aria-hidden mocks.
Spacing on `.bdh`: `--bdh-gap --bdh-gap-l --bdh-block --bdh-head-mb --bdh-hero-t --bdh-sticky`.

## window.BDH (assets/js/brand/hub.js — loads before page scripts)
```js
(function () { 'use strict'; if (!window.BDH) return;
  var root = document.querySelector('.<prefix>-<id>'); if (!root) return;
  if (BDH.reduced) { /* finished state, no loops */ return; } … })();
```
`BDH.reduced` · `$ / $$` · `inView(el, fn)` · `enter(el,{cls,delay})` (auto `[data-bdh-in]`) · `watch(el, fn(on))` ·
`live(el, thr, fn(on))` toggles `.is-live` on screen (auto `[data-bdh-live]`) · `loop(el, ms, fn)` → {stop,pause,resume} ·
`onInteract(root, fn)` · `tabs(root,{tabs,panes,auto,orientation,initial,onChange})` → {show,stop,index} (ARIA tablist) ·
`seq(root, [[ms, fn]], {loop,stopOnInteract})` · `type(el, text)` · `count(el)` (auto `[data-bdh-count]`) · `progress(el, fn(p))` ·
`spy(els, fn)` · `parallax(root)` · `stagger(root, sel)` (auto `[data-bdh-stagger]`).
Home page only: `sections.js` loads BEFORE hub.js — defer BDH use to `DOMContentLoaded`.

## Tech kit (partials/tech/kit.php + assets/css/tech/kit.css)
`xt_stack(['figma','react',…], ['variant'=>'chips|tiles|logos|row','label'=>'…'])` · `xt_logo($slug)` (slugs = keys of data/tech-stack.php) ·
`xt_icon($name)` — names: code terminal api browser mobile git-branch layers stack cube puzzle rocket rollback database server cloud gpu chip
container cluster network edge pipeline queue vector sync plug link workflow agent brain sparkle prompt chat voice vision eval approve lightbulb
shield lock key fingerprint eye bug alert scan radar clipboard-check accessibility gauge chart trend-up dashboard log uptime latency cost clock
calendar bolt leaf filter search globe pin target flag compass doc check users handshake headset wrench dot ·
`xt_badge($key, ['variant'=>'seal|shield|hex|chip'])` — keys: iso27001 iso27701 iso42001 iso9001 iso14001 iso22301 soc2 nist-csf nist-ai-rmf
owasp-asvs owasp-top10 owasp-llm mitre-atlas cis slsa pci-dss hipaa gdpr dpdp cert-in eu-ai-act nis2 wcag22 cwv dora-metrics sci — framed
"frameworks we build to", never certification. `.xt-ico .a` is blue: on a `--blue` fill set `--xt-accent:currentColor` (defect 3).

## Rules that are checked (BUILD-BRIEF §2)
- Tokens only; no new hex/rgb (mask fades excepted); gradients only core `.aurora/.dither/.dots` + mask fades; no `!important`;
  no stray `font-family` (use the three vars); blue never in h1–h3; Montserrat never negative tracking.
- No-JS: shipped HTML is the finished state. Hide-for-animation only under a class JS adds (`.is-anim`, `.is-in`). Tab panes: add a
  `<noscript><style>` that stacks them, or render as anchors/`<details>`. `--reduced` = finished state, no loops.
- Defects 2–5: no `pathLength` + `non-scaling-stroke`; `--xt-accent:currentColor` on blue fills; diagram edges trimmed to box edges;
  stacked cards: only the current one in flow.
- Mocks `aria-hidden="true"` + a `.bdh-sr` sentence; real controls are labelled buttons; `th scope`; keyboard + ARIA for tabs.
- Mobile: zero overflow at 320–1920; tap targets ≥44px; nothing clipped/truncated mid-word; grids collapse with reading order intact;
  wide content in `.bdh-scroll-x.mask-x` (tabindex/role/label); sticky things never cover content.
- Links via `xe_url()` / `xe_discipline_url()` / `xe_cap_url()` only; never an href ending `.php`; every link 200.
- Truth: no real client names/logos/testimonials; claims about clients, headcount, results, certifications, registrations, prices,
  timelines, response times carry `<!-- PLACEHOLDER: confirm … before launch -->` or are phrased as targets/typical ranges.
- First line of every partial: `<?php /* DRAFT COPY — review before launch */ ?>`.

## Tools
`php -S 127.0.0.1:<port> router.php` (own port, background, repo root) ·
`XE_BASE=http://127.0.0.1:<port> python3 tools/shot-brand.py <path.php> --out <dir> [--m|--w 320|768|1024|1920] [--live] [--reduced] [--sel .x]`
(prints overflow, console errors, failed requests, PHP warnings) · Playwright Python 1.56 for no-JS (`java_script_enabled=False`) and keyboard ·
`php -l` · `node --check` · commit: `tools/xe-commit.sh "<msg>" <your paths…>` (only those paths; pushes the checked-out branch).
