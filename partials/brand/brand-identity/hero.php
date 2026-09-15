<?php /* DRAFT COPY — review before launch */
/* Hero — plate 00 of the specimen book, set as a type specimen. The headline runs the full measure
   between specimen rules with its setting noted in the margin; below it, the kinetic specimen sheet
   (a generic "Your brand" mark assembling on a construction grid, cycling colourway and type
   pairing) sits lower-left, and the brief reads beside it. The HTML is the finished state. */
$hero_cw = [   // [name, background token, foreground token, accent token]
    ['Ink on paper',  'paper', 'ink',   'blue'],
    ['Paper on ink',  'ink',   'paper', 'blue'],
    ['Paper on blue', 'blue',  'paper', 'ink'],
    ['Blue on stone', 'paper-3', 'blue', 'ink'],
];
$hero_tp = [   // [wordmark text, display face, text face]
    ['Your brand', 'Outfit 500', 'Montserrat 400'],
    ['YOUR BRAND', 'Montserrat 600', 'Montserrat 400'],
    ['your_brand', 'JetBrains Mono 500', 'Montserrat 400'],
];
?>
<section class="cbi-hero" id="top" aria-labelledby="hero-t">
  <span class="cbi-hero__paper" aria-hidden="true"></span>

  <div class="wrap cbi-hero__in">
    <div class="cbi-hero__top">
      <nav class="cbi-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_discipline_url($BRAND) ?>"><?= e($BRAND['name']) ?></a></li>
          <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
        </ol>
      </nav>
      <p class="cbi-hero__eb"><span class="cbi-reg" aria-hidden="true"></span><span>Specimen book · Capability <?= e($CAP['n']) ?> of <?= count($BRAND['caps']) ?> · <?= e($CAP['kicker']) ?></span></p>
    </div>

    <div class="cbi-hero__display">
      <p class="cbi-hero__set" aria-hidden="true"><span>Display</span><span>Outfit 500</span><span>Tracking −35</span><span>Leading 0.96</span></p>
      <h1 class="cbi-hero__h" id="hero-t"><?= $CAP['title'] /* trusted HTML from data/brand-design.php */ ?></h1>
      <p class="cbi-hero__set cbi-hero__set--b" aria-hidden="true"><span>Plate 00</span><span>Set once, used everywhere</span></p>
    </div>

    <div class="cbi-hero__stage">
      <div class="cbi-sheet is-grid is-parts is-set" data-cw="0" data-tp="0" aria-hidden="true">
        <span class="cbi-crop"><i></i><i></i><i></i><i></i></span>
        <span class="cbi-sheet__reg cbi-sheet__reg--l"><span class="cbi-reg"></span></span>
        <span class="cbi-sheet__reg cbi-sheet__reg--r"><span class="cbi-reg"></span></span>

        <p class="cbi-sheet__top"><span>Plate 00 · Mark</span><span class="cbi-sheet__step">Assembled</span></p>

        <svg class="cbi-sheet__svg" viewBox="0 0 400 400" fill="none">
          <g class="cbi-sheet__grid">
            <?php for ($hero_g = 50; $hero_g < 400; $hero_g += 50): ?>
              <line x1="<?= $hero_g ?>" y1="0" x2="<?= $hero_g ?>" y2="400"/><line x1="0" y1="<?= $hero_g ?>" x2="400" y2="<?= $hero_g ?>"/>
            <?php endfor; ?>
          </g>
          <g class="cbi-sheet__guides">
            <circle cx="200" cy="200" r="150"/><circle cx="150" cy="200" r="100"/>
            <line x1="50" y1="50" x2="350" y2="350"/><line x1="350" y1="50" x2="50" y2="350"/>
            <rect x="50" y="100" width="300" height="200"/>
          </g>
          <g class="cbi-sheet__parts">
            <circle class="cbi-part cbi-part--a" cx="150" cy="200" r="100"/>
            <path class="cbi-part cbi-part--b" d="M250 100h100v100h-100z"/>
            <path class="cbi-part cbi-part--c" d="M250 200h100a100 100 0 0 1-100 100z"/>
            <path class="cbi-part cbi-part--d" d="M150 150a50 50 0 0 1 0 100a50 50 0 0 1 0-100z"/>
          </g>
          <g class="cbi-sheet__dims">
            <line x1="50" y1="330" x2="350" y2="330"/><line x1="50" y1="324" x2="50" y2="336"/><line x1="350" y1="324" x2="350" y2="336"/>
            <text x="200" y="352" text-anchor="middle">6 units</text>
          </g>
        </svg>

        <div class="cbi-sheet__word">
          <?php foreach ($hero_tp as $hero_i => $hero_t): ?>
            <b class="cbi-sheet__wm cbi-sheet__wm--<?= $hero_i ?>"><?= e($hero_t[0]) ?></b>
          <?php endforeach; ?>
        </div>

        <p class="cbi-sheet__foot">
          <span class="cbi-sheet__cw"><?php foreach ($hero_cw as $hero_i => $hero_c): ?><em class="cbi-sheet__cwn cbi-sheet__cwn--<?= $hero_i ?>"><?= e($hero_c[0]) ?></em><?php endforeach; ?></span>
          <span class="cbi-sheet__tp"><?php foreach ($hero_tp as $hero_i => $hero_t): ?><em class="cbi-sheet__tpn cbi-sheet__tpn--<?= $hero_i ?>"><?= e($hero_t[1]) ?> / <?= e($hero_t[2]) ?></em><?php endforeach; ?></span>
        </p>
      </div>

      <div class="cbi-hero__ctl">
        <div class="cbi-hero__cws" role="group" aria-label="Colourway">
          <?php foreach ($hero_cw as $hero_i => $hero_c): ?>
            <button type="button" class="cbi-hero__sw" data-cw="<?= $hero_i ?>" aria-pressed="<?= $hero_i === 0 ? 'true' : 'false' ?>" style="--sw-bg:var(--<?= $hero_c[1] ?>);--sw-fg:var(--<?= $hero_c[2] ?>)">
              <span class="cbi-hero__chip" aria-hidden="true"></span><span class="bdh-sr"><?= e($hero_c[0]) ?></span>
            </button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="cbi-btn cbi-hero__tpb" data-tp-next>Next type pairing <span class="cbi-hero__tpi" aria-hidden="true">Aa</span></button>
        <button type="button" class="cbi-btn cbi-hero__play" hidden>Pause</button>
      </div>
      <p class="bdh-sr">A specimen of a generic mark for “Your brand”: a circle, a square and a quarter-disc set on a six-unit construction grid, shown in four colourways and three type pairings.</p>
    </div>

    <div class="cbi-hero__text">
      <p class="lead cbi-hero__lead"><?= e($CAP['lead']) ?></p>
      <div class="cbi-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#voice">Try the voice tuner <span class="i" aria-hidden="true">›</span></a>
      </div>
      <dl class="cbi-hero__meta">
        <?php foreach ($CAP['meta'] as $hero_i => $hero_m): ?>
          <div><dt><?= e($CAP['meta_k'][$hero_i] ?? '') ?></dt><dd><?= e($hero_m) ?></dd></div>
        <?php endforeach; ?>
      </dl>
    </div>
  </div>
</section>
