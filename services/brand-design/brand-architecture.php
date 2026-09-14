<?php
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
$BD  = require __DIR__ . '/../../data/brand-design.php';
$cap = $BD['brand-architecture'];

$page = [
    'key'   => 'services',
    'title' => $cap['name'] . ' · Brand Design',
    'desc'  => $cap['lead'],
    'css'   => ['assets/css/brand.css', 'assets/css/brand/brand-architecture.css'],
    'js'    => ['assets/js/brand.js', 'assets/js/brand/brand-architecture.js'],
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';

$mark = xe_svg('xe-mark');

/* the three models — name, the four trade-offs (1–5), when it fits */
$models = [
    'branded'  => ['Branded house',   [5, 2, 2, 1], 'One promise covers every product.'],
    'endorsed' => ['Endorsed',        [4, 4, 3, 3], 'Sub-brands need their own voice and the parent’s trust.'],
    'house'    => ['House of brands', [2, 5, 5, 5], 'The brands serve customers who should never meet.'],
];
$metrics = ['Recognition', 'Flexibility', 'Risk contained', 'Cost to run'];

/* ---- the hero stage: one portfolio, three architecture models, the tree re-lays out ---- */
ob_start(); ?>
<div class="bd-stage ba-arch" data-bd-live data-bd-arch data-model="branded">
  <div class="bd-stage__bar">
    <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
    <span class="bd-stage__title">Portfolio map<i>›</i>Xterra Edze</span>
    <span class="ba-arch__count num" aria-hidden="true"><b data-ba-idx>01</b> / 03</span>
  </div>
  <div class="bd-stage__body ba-arch__body">
    <div class="ba-seg" role="group" aria-label="Architecture model">
      <span class="ba-seg__thumb" aria-hidden="true"><i></i></span>
      <?php $n = 0; foreach ($models as $key => $m): ?>
        <button type="button" class="ba-seg__b" data-bd-model="<?= $key ?>" aria-pressed="<?= $n === 0 ? 'true' : 'false' ?>"><?= e($m[0]) ?></button>
      <?php $n++; endforeach; ?>
    </div>

    <div class="ba-tree" aria-hidden="true">
      <svg class="ba-tree__svg" viewBox="0 0 600 340" fill="none">
        <g class="ba-tree__solid">
          <path class="ba-tree__w" pathLength="1" d="M300 44 V106 H100 V170"/>
          <path class="ba-tree__w" pathLength="1" d="M300 44 V170"/>
          <path class="ba-tree__w" pathLength="1" d="M300 44 V106 H500 V170"/>
        </g>
        <g class="ba-tree__dash">
          <path d="M300 44 V106 H100 V170"/>
          <path d="M300 44 V170"/>
          <path d="M300 44 V106 H500 V170"/>
        </g>
        <g class="ba-tree__leafw">
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M100 170 V240 H50 V300"/>
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M100 170 V240 H150 V300"/>
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M300 170 V240 H250 V300"/>
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M300 170 V240 H350 V300"/>
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M500 170 V240 H450 V300"/>
          <path class="ba-tree__w ba-tree__w--2" pathLength="1" d="M500 170 V240 H550 V300"/>
        </g>
        <g class="ba-tree__pk">
          <path pathLength="1" d="M300 44 V106 H100 V170"/>
          <path pathLength="1" d="M300 44 V170"/>
          <path pathLength="1" d="M300 44 V106 H500 V170"/>
        </g>
      </svg>

      <div class="ba-tree__root">
        <span class="ba-tree__rmark"><?= $mark ?></span>
        <span class="ba-tree__txt"><b>Xterra Edze</b><em>master brand</em></span>
      </div>

      <?php foreach ([['Cloud', 'Nimbus', 'N', 16.6667], ['Studio', 'Atelier', 'A', 50], ['Labs', 'Forge', 'F', 83.3333]] as $i => $k): ?>
        <div class="ba-tree__kid ba-tree__kid--<?= $i + 1 ?>" style="--x:<?= $k[3] ?>%">
          <span class="ba-tree__id">
            <span class="ba-tree__mark"><?= $mark ?></span>
            <span class="ba-tree__mono"><?= e($k[2]) ?></span>
          </span>
          <span class="ba-tree__txt">
            <b class="ba-tree__name"><i class="ba-tree__pre">XE&nbsp;</i><span class="ba-tree__nms"><span class="ba-tree__nm ba-tree__nm--xe"><?= e($k[0]) ?></span><span class="ba-tree__nm ba-tree__nm--own"><?= e($k[1]) ?></span></span></b>
            <em class="ba-tree__by"><span>by Xterra Edze</span></em>
          </span>
        </div>
      <?php endforeach; ?>

      <?php foreach (['Pro', 'Go', 'Teams', 'Solo', 'Beta', 'Kit'] as $i => $leaf): ?>
        <i class="ba-tree__leaf" style="--x:<?= round(8.3333 + $i * 16.6667, 3) ?>%"><?= e($leaf) ?></i>
      <?php endforeach; ?>
    </div>

    <div class="ba-arch__legends">
      <?php $n = 0; foreach ($models as $key => $m): $n++; ?>
        <div class="ba-arch__legend" data-for="<?= $key ?>">
          <div class="ba-arch__lhd">
            <p class="ba-arch__lh"><span class="num"><?= str_pad((string) $n, 2, '0', STR_PAD_LEFT) ?></span><?= e($m[0]) ?></p>
            <p class="ba-arch__fit">Fits when <?= e(lcfirst($m[2])) ?></p>
          </div>
          <ul class="ba-arch__metrics">
            <?php foreach ($metrics as $j => $label): ?>
              <li><span><?= e($label) ?></span><i class="ba-dots" style="--v:<?= $m[1][$j] ?>" role="img" aria-label="<?= $m[1][$j] ?> of 5"></i></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="sr" aria-live="polite" data-ba-say></p>
  </div>
</div>
<?php $mockHtml = ob_get_clean(); ?>

<main id="main" class="bd" data-bd="architecture">
  <?php include __DIR__ . '/../../partials/brand/phero.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/rail.php'; ?>
  <?php include __DIR__ . '/../../partials/brand/offer.php'; ?>

  <!-- ===== signature · choose the model on evidence ===== -->
  <section class="band band--alt ba-compare" aria-labelledby="compare-t">
    <div class="wrap">
      <div class="head head--c ba-compare__head" data-rv>
        <p class="lbl lbl--blue"><span class="dot"></span>Three models</p>
        <h2 class="h2" id="compare-t"><span class="g">Chosen on evidence,</span><br>with the trade-offs written down</h2>
        <p class="lead">There is no right model, only the one that fits how your customers buy and how you plan to grow.</p>
      </div>

      <div class="ba-compare__frame" data-rv data-rv-d="80">
        <p class="ba-compare__cue" aria-hidden="true">Swipe to compare <i>›</i></p>
        <div class="ba-compare__scroll" tabindex="0" role="region" aria-label="Model comparison, scrolls sideways" data-ba-scroll>
          <div class="ba-compare__table" role="table" aria-label="The three architecture models compared">
            <div class="ba-compare__row ba-compare__row--hd" role="row">
              <span class="ba-compare__crit" role="columnheader"><span class="ba-compare__key">Criterion</span><span class="ba-compare__legend" aria-hidden="true"><i class="ba-dots ba-dots--sm" style="--v:1"></i>low <i class="ba-dots ba-dots--sm" style="--v:5"></i>high</span></span>
              <?php
              $glyphs = [
                  'branded'  => '<circle cx="36" cy="7" r="5" fill="currentColor"/><path d="M36 12v6M12 18h48M12 18v6M36 18v6M60 18v6" stroke="currentColor" stroke-width="1.3"/><rect x="6" y="25" width="12" height="9" rx="2" fill="currentColor"/><rect x="30" y="25" width="12" height="9" rx="2" fill="currentColor"/><rect x="54" y="25" width="12" height="9" rx="2" fill="currentColor"/>',
                  'endorsed' => '<circle cx="36" cy="7" r="5" fill="currentColor"/><path d="M36 12v6M12 18h48M12 18v6M36 18v6M60 18v6" stroke="currentColor" stroke-width="1.3"/><rect x="6.65" y="25.65" width="10.7" height="7.7" rx="2" stroke="currentColor" stroke-width="1.3"/><rect x="30.65" y="25.65" width="10.7" height="7.7" rx="2" stroke="currentColor" stroke-width="1.3"/><rect x="54.65" y="25.65" width="10.7" height="7.7" rx="2" stroke="currentColor" stroke-width="1.3"/><circle cx="12" cy="29.5" r="1.6" fill="currentColor"/><circle cx="36" cy="29.5" r="1.6" fill="currentColor"/><circle cx="60" cy="29.5" r="1.6" fill="currentColor"/>',
                  'house'    => '<circle cx="36" cy="7" r="4.35" stroke="currentColor" stroke-width="1.3" opacity=".45"/><path d="M36 12v6M12 18h48M12 18v6M36 18v6M60 18v6" stroke="currentColor" stroke-width="1.3" stroke-dasharray="2 2.4" opacity=".45"/><circle cx="12" cy="29.5" r="4.85" stroke="currentColor" stroke-width="1.3"/><rect x="31.15" y="24.65" width="9.7" height="9.7" rx="1" stroke="currentColor" stroke-width="1.3"/><path d="M60 24.5 65 34H55Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/>',
              ];
              $subs = ['branded' => 'One brand, many products', 'endorsed' => 'Own brands, parent’s trust', 'house' => 'Separate brands, one owner'];
              foreach ($models as $key => $m): ?>
                <span class="ba-compare__model" role="columnheader">
                  <svg class="ba-compare__glyph" viewBox="0 0 72 36" fill="none" aria-hidden="true"><?= $glyphs[$key] ?></svg>
                  <b><?= e($m[0]) ?></b><i><?= e($subs[$key]) ?></i>
                </span>
              <?php endforeach; ?>
            </div>
            <?php
            $rows = [
                ['Recognition builds',        5, 4, 2],
                ['Room for a sub-brand',      2, 4, 5],
                ['Risk stays contained',      2, 3, 5],
                ['Cost to maintain',          1, 3, 5, true],
                ['Speed to launch a product', 5, 3, 2],
            ];
            foreach ($rows as $r): ?>
              <div class="ba-compare__row" role="row">
                <span class="ba-compare__crit" role="rowheader"><?= e($r[0]) ?><?php if (!empty($r[4])): ?><i class="ba-compare__hint">more dots, more cost</i><?php endif; ?></span>
                <?php for ($c = 1; $c <= 3; $c++): ?>
                  <span class="ba-compare__cell" role="cell"><i class="ba-dots ba-dots--lg" style="--v:<?= $r[$c] ?>" role="img" aria-label="<?= $r[$c] ?> of 5"></i></span>
                <?php endfor; ?>
              </div>
            <?php endforeach; ?>
            <div class="ba-compare__row ba-compare__row--fit" role="row">
              <span class="ba-compare__crit" role="rowheader">Fits when</span>
              <?php foreach ($models as $m): ?>
                <span class="ba-compare__cell" role="cell"><?= e($m[2]) ?></span>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
      <p class="ba-compare__note" data-rv><i class="chev" aria-hidden="true">›</i> Most portfolios end up a hybrid. The relationship rules say which model applies where.</p>
    </div>
  </section>

  <!-- ===== from today to the structure ===== -->
  <section class="band ba-migrate" aria-labelledby="migrate-t">
    <div class="wrap">
      <div class="head--row ba-migrate__head" data-rv>
        <div>
          <p class="lbl lbl--blue"><span class="dot"></span>Migration</p>
          <h2 class="h2" id="migrate-t"><span class="g">From what grew</span><br>to what was designed</h2>
        </div>
        <p class="lead">Most portfolios were never designed. They accumulated. The migration plan moves every brand to its place, in an order that never confuses a customer.</p>
      </div>

      <div class="ba-migrate__panel" data-bd-live data-bd-ba data-state="before" data-rv data-rv-d="80">
        <div class="ba-migrate__main">
          <div class="ba-migrate__top">
            <div class="ba-tog" role="group" aria-label="Portfolio view">
              <span class="ba-tog__thumb" aria-hidden="true"><i></i></span>
              <button type="button" class="ba-tog__b" data-bd-ba-btn="before" aria-pressed="true">Today</button>
              <button type="button" class="ba-tog__b" data-bd-ba-btn="after" aria-pressed="false">Structured</button>
            </div>
            <p class="ba-migrate__status" aria-hidden="true">
              <span data-for="before"><b class="num">12</b> names<i>·</i><b class="num">5</b> conventions<i>·</i><b class="num">1</b> duplicate</span>
              <span data-for="after"><b class="num">11</b> names<i>·</i><b class="num">1</b> rule<i>·</i><b class="num">0</b> duplicates</span>
            </p>
            <p class="sr" aria-live="polite" data-ba-say></p>
          </div>

          <div class="ba-migrate__stage" role="img" aria-label="Today: twelve product names written five different ways, including a duplicate of the master brand. Structured: eleven names under the master brand, grouped into Cloud, Studio and Labs, each named Master, Line, Tier.">
            <span class="ba-migrate__grid" aria-hidden="true"></span>
            <span class="ba-migrate__guides" aria-hidden="true"><i></i><i></i><i></i></span>
            <div class="ba-migrate__cols" aria-hidden="true">
              <?php foreach ([['Master', 0, 0, 0, 1], ['Cloud', 1, 1, 0, 4], ['Studio', 2, 0, 5, 3], ['Labs', 3, 1, 5, 3]] as $h): ?>
                <span style="--ac:<?= $h[1] ?>;--mc:<?= $h[2] ?>;--mt:<?= $h[3] ?>"><?= e($h[0]) ?><i class="num"><?= $h[4] ?></i></span>
              <?php endforeach; ?>
            </div>
            <?php
            /* today: centre x %, centre y %, tilt · structured: column, row · phone: column, row */
            $chips = [
                ['Xterra Edze', 'Xterra Edze',    14, 15, -5, 0, 0, 0, 1, 'master'],
                ['Labs Beta',   'XE Labs Beta',   40, 22,  8, 3, 1, 1, 7, ''],
                ['XE Cloud',    'XE Cloud',       65, 12,  4, 1, 0, 1, 1, ''],
                ['SOLO',        'XE Studio Solo', 87, 24, -7, 2, 2, 0, 8, ''],
                ['xe.',         'Xterra Edze',    11, 44,  9, 0, 0, 0, 1, 'dup'],
                ['CloudPro™',   'XE Cloud Pro',   34, 45, -9, 1, 1, 1, 2, ''],
                ['xe-cloud-go', 'XE Cloud Go',    74, 42,  6, 1, 2, 1, 3, ''],
                ['Studio',      'XE Studio',      19, 69,  3, 2, 0, 0, 6, ''],
                ['The Lab',     'XE Labs',        53, 63, -4, 3, 0, 1, 6, ''],
                ['XE Kit',      'XE Labs Kit',    86, 67,  7, 3, 2, 1, 8, ''],
                ['Edze Teams',  'XE Cloud Teams', 31, 88,  5, 1, 3, 1, 4, ''],
                ['XE Studio+',  'XE Studio Plus', 66, 87, -3, 2, 1, 0, 7, ''],
            ];
            foreach ($chips as $i => $c):
                $mods = $c[9] ? ' ba-chip--' . $c[9] : '';
                $parts = explode(' ', $c[1]);
            ?>
              <span class="ba-chip ba-chip--v<?= $i % 5 ?><?= $mods ?>" aria-hidden="true"
                    style="--bx:<?= $c[2] ?>%;--by:<?= $c[3] ?>%;--br:<?= $c[4] ?>deg;--ac:<?= $c[5] ?>;--ar:<?= $c[6] ?>;--mc:<?= $c[7] ?>;--mt:<?= $c[8] ?>;--i:<?= $i ?>">
                <b class="ba-chip__before"><?= e($c[0]) ?></b>
                <b class="ba-chip__after"><?php if ($c[9] === 'master' || $c[9] === 'dup'): ?><span class="ba-chip__m"><?= $mark ?></span><?= e($c[1]) ?><?php else: ?><em><?= e($parts[0]) ?></em> <?= e(implode(' ', array_slice($parts, 1))) ?><?php endif; ?></b>
              </span>
            <?php endforeach; ?>
          </div>
        </div>

        <aside class="ba-names" aria-labelledby="names-t">
          <p class="ba-names__k">Naming system</p>
          <h3 class="ba-names__h" id="names-t">One rule for every name</h3>
          <div class="ba-names__rule" aria-hidden="true">
            <span>Master</span><i>›</i><span>Line</span><i>›</i><span>Tier</span>
          </div>
          <ul class="ba-names__ex" data-bd-cycle="2400">
            <li class="is-on" data-bd-cycle-i><b>XE</b><b>Cloud</b><b>Pro</b></li>
            <li data-bd-cycle-i><b>XE</b><b>Studio</b><b>Solo</b></li>
            <li data-bd-cycle-i><b>XE</b><b>Labs</b><b>Kit</b></li>
            <li class="ba-names__next"><b>XE</b><b>Labs</b><b><span class="ba-names__caret" aria-hidden="true"></span><span class="sr">next tier</span></b></li>
          </ul>
          <dl class="ba-names__tests">
            <div><dt>Line</dt><dd>Named for a customer need, never a team.</dd></div>
            <div><dt>Tier</dt><dd>One word from a closed list.</dd></div>
            <div><dt>Retire</dt><dd><s>CloudPro™</s> <s>xe-cloud-go</s> <s>xe.</s></dd></div>
          </dl>
          <p class="ba-names__note"><i aria-hidden="true">›</i> One rule. The next product names itself.</p>
        </aside>
      </div>
    </div>
  </section>

  <!-- ===== where architecture shows up ===== -->
  <section class="band band--line ba-field" aria-labelledby="field-t">
    <div class="wrap">
      <div class="head--row ba-field__head" data-rv>
        <div>
          <p class="lbl lbl--blue"><span class="dot"></span>In the world</p>
          <h2 class="h2" id="field-t"><span class="g">Where architecture</span><br>shows up</h2>
        </div>
        <p class="lead">Customers never read the decision record. They meet the structure on a fascia, a sign and a shelf, and each of those follows the same lockup rules.</p>
      </div>

      <!-- PLACEHOLDER: stock photography from Unsplash, see assets/imgs/brand/brand-architecture/CREDITS.md. Replace with Xterra Edze's own work before launch. -->
      <div class="ba-field__row ba-field__row--a" data-bd-live data-rv-s data-rv-step="110">
        <figure class="ba-shot ba-shot--store" style="--ar:1100 / 1146">
          <div class="ba-shot__ph" data-ba-par>
            <div class="ba-shot__in">
              <img src="<?= xe_url('assets/imgs/brand/brand-architecture/storefront-frosted-glass.jpg') ?>" width="1100" height="1146" loading="lazy" decoding="async"
                   alt="A building entrance clad in brushed metal panels, shown with the XE Studio lockup mounted on the white fascia and the Xterra Edze mark etched into the metal.">
              <span class="ba-comp ba-comp--fascia" aria-hidden="true"><span class="ba-comp__mk"><?= $mark ?></span><span class="ba-comp__wd"><b>XE</b> Studio</span></span>
              <span class="ba-comp ba-comp--etch" aria-hidden="true"><?= $mark ?></span>
              <span class="ba-pin" style="--px:63%;--py:13.5%" aria-hidden="true"><i>1</i><b>Fascia lockup</b></span>
              <span class="ba-pin ba-pin--l" style="--px:22%;--py:52%" aria-hidden="true"><i>2</i><b>Etched mark</b></span>
            </div>
          </div>
          <figcaption class="ba-shot__cap">
            <p class="ba-shot__k"><span>Storefront</span><i>·</i>XE Studio</p>
            <ol class="ba-shot__notes">
              <li><i class="num">1</i>The master mark leads. The line name follows at one fixed ratio.</li>
              <li><i class="num">2</i>The parent is on the building without a second logo competing.</li>
            </ol>
          </figcaption>
        </figure>

        <figure class="ba-shot ba-shot--pack" style="--ar:1600 / 1067">
          <div class="ba-shot__ph" data-ba-par>
            <div class="ba-shot__in">
              <img src="<?= xe_url('assets/imgs/brand/brand-architecture/product-family-bottles.jpg') ?>" width="1600" height="1067" loading="lazy" decoding="async"
                   alt="Four bottles of different sizes in a row, each carrying an XE Labs label with the same layout and a different tier name.">
              <?php foreach ([['Pro', '250 ml', 1], ['Plus', '400 ml', 2], ['Go', '100 ml', 3], ['Kit', '30 ml', 4]] as $b): ?>
                <span class="ba-label ba-label--<?= $b[2] ?>" aria-hidden="true">
                  <span class="ba-label__mk"><?= $mark ?></span>
                  <span class="ba-label__ln">Labs</span>
                  <span class="ba-label__tr"><?= e($b[0]) ?></span>
                  <span class="ba-label__ml"><?= e($b[1]) ?></span>
                </span>
              <?php endforeach; ?>
              <span class="ba-pin ba-pin--l" style="--px:24%;--py:26%" aria-hidden="true"><i>1</i><b>Mark · fixed position</b></span>
              <span class="ba-pin" style="--px:53.4%;--py:43%" aria-hidden="true"><i>2</i><b>Line · one ratio</b></span>
              <span class="ba-pin" style="--px:81.5%;--py:59%" aria-hidden="true"><i>3</i><b>Tier · the only change</b></span>
            </div>
          </div>
          <figcaption class="ba-shot__cap">
            <p class="ba-shot__k"><span>Product family</span><i>·</i>XE Labs</p>
            <ol class="ba-shot__notes">
              <li><i class="num">1</i>The mark sits in one position on every pack, largest to smallest.</li>
              <li><i class="num">2</i>The line name keeps its ratio, so the family reads as one row.</li>
              <li><i class="num">3</i>The tier is the only word that changes.</li>
            </ol>
          </figcaption>
        </figure>
      </div>

      <div class="ba-field__row ba-field__row--b" data-bd-live data-rv-s data-rv-step="110">
        <figure class="ba-shot ba-shot--blade" style="--ar:1000 / 1250">
          <div class="ba-shot__ph" data-ba-par>
            <div class="ba-shot__in">
              <img src="<?= xe_url('assets/imgs/brand/brand-architecture/blade-sign-blank.jpg') ?>" width="1000" height="1250" loading="lazy" decoding="async"
                   alt="A square projecting sign under a shop awning, printed with the Xterra Edze mark above the name XE Cloud.">
              <span class="ba-comp ba-comp--blade" aria-hidden="true"><span class="ba-comp__mk"><?= $mark ?></span><span class="ba-comp__wd"><b>XE</b> Cloud</span></span>
              <span class="ba-pin" style="--px:51%;--py:38%" aria-hidden="true"><i>1</i><b>Mark first</b></span>
              <span class="ba-pin" style="--px:51%;--py:55.5%" aria-hidden="true"><i>2</i><b>Never alone</b></span>
            </div>
          </div>
          <figcaption class="ba-shot__cap">
            <p class="ba-shot__k"><span>Signage</span><i>·</i>XE Cloud</p>
            <ol class="ba-shot__notes">
              <li><i class="num">1</i>From a distance the master brand is recognised before the name is read.</li>
              <li><i class="num">2</i>A sub-brand never appears on a sign without the mark.</li>
            </ol>
          </figcaption>
        </figure>

        <figure class="ba-shot ba-shot--way" style="--ar:1000 / 1250">
          <div class="ba-shot__ph" data-ba-par>
            <div class="ba-shot__in">
              <img src="<?= xe_url('assets/imgs/brand/brand-architecture/wayfinding-panel-blank.jpg') ?>" width="1000" height="1250" loading="lazy" decoding="async"
                   alt="A wall-mounted directory panel under climbing plants, listing XE Cloud, XE Studio and XE Labs beneath the Xterra Edze lockup, each with a direction.">
              <span class="ba-comp ba-comp--dir" aria-hidden="true">
                <span class="ba-dir__hd"><span class="ba-comp__mk"><?= $mark ?></span><b>Xterra Edze</b></span>
                <span class="ba-dir__row"><i>↑</i><b><em>XE</em> Cloud</b><small>Level 2</small></span>
                <span class="ba-dir__row"><i>→</i><b><em>XE</em> Studio</b><small>Hall B</small></span>
                <span class="ba-dir__row"><i>↓</i><b><em>XE</em> Labs</b><small>Level 0</small></span>
              </span>
              <span class="ba-pin" style="--px:45%;--py:40.5%" aria-hidden="true"><i>1</i><b>Master, once</b></span>
              <span class="ba-pin" style="--px:45%;--py:62%" aria-hidden="true"><i>2</i><b>Lines by need</b></span>
            </div>
          </div>
          <figcaption class="ba-shot__cap">
            <p class="ba-shot__k"><span>Wayfinding</span><i>·</i>One building</p>
            <ol class="ba-shot__notes">
              <li><i class="num">1</i>The master brand heads the directory once, not on every line.</li>
              <li><i class="num">2</i>Lines are listed by what visitors came for, not by department.</li>
            </ol>
          </figcaption>
        </figure>

        <!-- PLACEHOLDER: illustrative lockup values for the mock — confirm against the real guidelines -->
        <div class="ba-spec bd-stage" data-bd-live>
          <div class="bd-stage__bar">
            <span class="bd-stage__dots" aria-hidden="true"><i></i><i></i><i></i></span>
            <span class="bd-stage__title">Lockup rules<i>›</i>v1.0</span>
          </div>
          <div class="bd-stage__body ba-spec__body">
            <div class="ba-spec__art" aria-hidden="true">
              <span class="ba-spec__cs">
                <span class="ba-spec__lock"><span class="ba-comp__mk"><?= $mark ?></span><i class="ba-spec__div"></i><span class="ba-spec__wd"><b>XE</b> Studio</span></span>
                <i class="ba-spec__x ba-spec__x--t">x</i><i class="ba-spec__x ba-spec__x--l">x</i>
              </span>
            </div>
            <h3 class="ba-spec__h">Four rules every lockup follows</h3>
            <dl class="ba-spec__list">
              <div><dt>Order</dt><dd>Master › Line › Tier</dd></div>
              <div><dt>Clearspace</dt><dd>One mark height, all sides</dd></div>
              <div><dt>Minimum</dt><dd>Lockup 96 px · mark 16 px</dd></div>
              <div><dt>Never</dt><dd><s>Studio</s> without the mark</dd></div>
            </dl>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $proc = $cap['process'];
  include __DIR__ . '/../../partials/brand/process.php';
  include __DIR__ . '/../../partials/brand/deliver.php';
  include __DIR__ . '/../../partials/brand/outcomes.php';
  include __DIR__ . '/../../partials/brand/pairs.php';
  $faqId = 'faq';
  $faq = ['title' => 'Brand Architecture,<br><span class="g">asked directly</span>', 'items' => $cap['faq']];
  include __DIR__ . '/../../partials/brand/faq.php';
  include __DIR__ . '/../../partials/brand/next.php';
  include __DIR__ . '/../../partials/cta.php';
  ?>
</main>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
