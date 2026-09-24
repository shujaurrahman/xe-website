<?php /* DRAFT COPY — review before launch */
/* 23 — Brand Design, in depth: what each of the six capabilities actually hands over.
   08-disciplines names the six; this section opens one at a time and shows one artefact it
   produces, the files handed over and how you know it worked.

   Data: names, one-liners and page links from data/site.php (the brand-design row, through
   xe_cap_url, which only links pages that exist); kicker, lead, meta, deliverables and outcomes
   from data/brand-design.php. Only the artefact mocks are written here, and each one is a
   different artefact from the mock the hub's capabilities section draws for that capability.

   Without JavaScript the selector is a row of #s23-<slug> links: the first capability shows by
   default and a targeted one replaces it (CSS :target). 23-brand.js upgrades the links to ARIA
   tabs, keeps one pane in flow ([hidden] on the rest), reserves the tallest pane's height and
   builds an artefact in only when the visitor changes tab. */
$s23_bd   = require __DIR__ . '/../data/brand-design.php';
$s23_disc = null;
foreach ($GLOBALS['SITE']['disciplines'] as $s23_row) { if ($s23_row['slug'] === 'brand-design') $s23_disc = $s23_row; }
unset($s23_row);
$s23_caps  = $s23_disc ? $s23_disc['caps'] : [];
$s23_total = str_pad((string) count($s23_caps), 2, '0', STR_PAD_LEFT);
/* window path · the format the artefact ships in (its row in data/brand-design.php 'deliver') */
$s23_path = [
    'growth-strategy'    => ['strategy / whitespace-map',   'Figma'],
    'brand-identity'     => ['identity / touchpoint-email', 'Figma · Office'],
    'brand-foundation'   => ['foundation / decision-log',   'Document'],
    'brand-systems'      => ['system / flex-rules',         'Guidelines'],
    'brand-architecture' => ['portfolio / migration-plan',  'Roadmap'],
    'brand-ai-tools'     => ['ai-tools / generation-queue', 'Dashboard'],
];
$s23_desc = [
    'growth-strategy'    => 'Illustration: a whitespace map plotting competitors by how present they are against how well each space fits your brand. Your company sits mid-field, and two uncontested openings are outlined where presence is low and fit is high.',
    'brand-identity'     => 'Illustration: the same email shown before and after the identity work. Before, it mixes marks, typefaces and button styles and opens with a generic headline. After, it uses one mark, two typefaces, one button style and a headline in the brand voice.',
    'brand-foundation'   => 'Illustration: a decision log. Under a one-line positioning statement, two real decisions are recorded with the principle that settled each: a discount sub-brand declined, and a product name chosen for clarity.',
    'brand-systems'      => 'Illustration: flex rules drawn as ranges. Signal colour share and headline scale may move inside set ranges, the logo minimum width is locked, and a partner deck using too much signal colour is flagged as out of range.',
    'brand-architecture' => 'Illustration: a four-phase migration plan. The master brand runs throughout, Atlas moves from standalone to endorsed in phase two, Label B is retired into the master brand in phase three, and recognition is measured in phase four.',
    'brand-ai-tools'     => 'Illustration: a generation queue of four market variants. One is approved, one waits for a person, one is rejected for an unapproved claim and one is still generating, with each outcome written to an approval log.',
];
$s23_fx = [   /* flex rules: label · allowed range (0–100 scale) · value · state · readout */
    ['Signal share · campaign',   10, 30, 20, 'ok',   '20% · range 10–30'],
    ['Headline scale · social',          40, 75, 62, 'ok',   '1.4× · range 1.25–1.5'],
    ['Logo minimum width',               null, null, 30, 'lock', '24 px · locked'],
    ['Signal share · partner deck', 10, 30, 42, 'out',  '42% · outside range'],
];
?>
<section class="band band--alt s23 bdh" id="brand" aria-labelledby="s23-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row s23__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Brand Design, in depth</p>
        <h2 class="h2" id="s23-t"><span class="g">What we make for a brand.</span> Six capabilities, each ending in files you&nbsp;own.</h2>
      </div>
      <div>
        <p class="lead">Strategy, identity and the systems that carry them. Every capability is scoped on its own, hands over named artefacts your teams can use, and plugs into the other&nbsp;five.</p>
        <a class="tl s23__hub" href="<?= xe_url('services/brand-design.php') ?>">Explore Brand Design <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="s23__app" data-s23 data-rv data-rv-d="80">
      <nav class="s23__tabs" aria-label="Brand Design capabilities">
        <?php foreach ($s23_caps as $s23_i => $s23_cap):
                $s23_slug = $s23_cap[2]; $s23_row = $s23_bd[$s23_slug]; ?>
          <a class="s23__tab" href="#s23-<?= e($s23_slug) ?>" id="s23-tab-<?= e($s23_slug) ?>">
            <i class="s23__rule" aria-hidden="true"></i>
            <span class="s23__tn" aria-hidden="true"><?= e($s23_row['n']) ?></span>
            <span class="s23__tname"><?= e($s23_cap[0]) ?></span>
            <span class="s23__tk" aria-hidden="true"><?= e($s23_row['kicker']) ?></span>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="s23__panes">
        <?php foreach ($s23_caps as $s23_i => $s23_cap):
                $s23_slug = $s23_cap[2]; $s23_row = $s23_bd[$s23_slug]; ?>
        <article class="s23__pane" id="s23-<?= e($s23_slug) ?>" aria-labelledby="s23-<?= e($s23_slug) ?>-h">

          <div class="s23__art">
            <div class="bdh-ui s23__win" aria-hidden="true">
              <div class="bdh-ui__bar s23__bar">
                <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
                <?php $s23_seg = explode(' / ', $s23_path[$s23_slug][0]); ?><span class="s23__crumb"><span class="s23__org">your-company / <?= e($s23_seg[0]) ?> / </span><?= e($s23_seg[1]) ?></span>
                <span class="s23__ver">v1.0</span>
              </div>
              <div class="s23__canvas dots">
              <?php if ($s23_slug === 'growth-strategy'): ?>
                <!-- PLACEHOLDER: illustrative market positions — not client or competitor data -->
                <p class="s23__cap s23-a">Competitive whitespace <span>presence × fit</span></p>
                <div class="s23-gs s23-a" style="--i:1">
                  <span class="s23-gs__y">Fit with your brand</span>
                  <div class="s23-gs__plot">
                    <span class="s23-gs__q"></span>
                    <span class="s23-gs__zone s23-a" style="--x:5%;--y:7%;--w:36%;--h:34%;--i:3"><b>A</b><span>Regulated mid&#8209;market</span></span>
                    <span class="s23-gs__zone is-b s23-a" style="--x:7%;--y:52%;--w:26%;--h:24%;--i:4"><b>B</b><span>Partner&#8209;led buyers</span></span>
                    <?php foreach ([[62, 22], [74, 34], [81, 58], [58, 70], [88, 16]] as $s23_k => $s23_pt): ?>
                      <i class="s23-gs__dot s23-a" style="--x:<?= $s23_pt[0] ?>%;--y:<?= $s23_pt[1] ?>%;--i:<?= $s23_k + 2 ?>"></i>
                    <?php endforeach; ?>
                    <span class="s23-gs__you s23-a" style="--x:50%;--y:44%;--i:6">Your company</span>
                  </div>
                  <span class="s23-gs__x">Competitor presence</span>
                </div>
                <ul class="s23-gs__key s23-a" style="--i:7">
                  <li><b>A</b>Uncontested · high fit<span>Now</span></li>
                  <li><b>B</b>Thinly served · good fit<span>Next</span></li>
                </ul>
              <?php elseif ($s23_slug === 'brand-identity'): ?>
                <p class="s23__cap s23-a">Monthly update email <span>before · after</span></p>
                <div class="s23-bi">
                  <figure class="s23-bi__tp is-before s23-a" style="--i:1">
                    <figcaption><span class="s23__k">Before</span>four teams, four versions</figcaption>
                    <div class="s23-bi__mail">
                      <p class="s23-bi__from"><b class="s23-bi__old">YOUR CO.</b><span>Newsletter</span></p>
                      <p class="s23-bi__hl">Exciting news: our Q3 newsletter</p>
                      <i class="s23-bi__ln"></i><i class="s23-bi__ln is-s"></i>
                      <p class="s23-bi__btns"><span class="s23-bi__b1">Click here</span><span class="s23-bi__b2">Learn more</span></p>
                    </div>
                  </figure>
                  <figure class="s23-bi__tp is-after s23-a" style="--i:2">
                    <figcaption><span class="s23__k">After</span>identity kit applied</figcaption>
                    <div class="s23-bi__mail">
                      <p class="s23-bi__from"><span class="s23-bi__mark"><i></i></span><b>Your company</b></p>
                      <p class="s23-bi__hl">Your quarter, in three numbers.</p>
                      <i class="s23-bi__ln"></i><i class="s23-bi__ln is-s"></i>
                      <p class="s23-bi__btns"><span class="s23-bi__b">Read the update</span></p>
                    </div>
                  </figure>
                </div>
                <ul class="s23-bi__diff s23-a" style="--i:3"><li>One mark</li><li>Two typefaces</li><li>One button style</li><li>Voice rules</li></ul>
              <?php elseif ($s23_slug === 'brand-foundation'): ?>
                <p class="s23__cap s23-a">Decision log <span>foundation v1 · in use</span></p>
                <p class="s23-bf__pos s23-a" style="--i:1"><span class="s23__k">Positioning</span>For companies selling across borders, Your company is the brand partner that keeps one promise in every&nbsp;market.</p>
                <ol class="s23-bf__log">
                  <li class="s23-a" style="--i:2">
                    <span class="s23-bf__id">D-014</span>
                    <b>Launch a discount sub-brand for price-led markets?</b>
                    <span class="s23-bf__by">Settled by principle 02 · One promise, every market</span>
                    <span class="s23-bf__out is-no">Declined · local pricing inside the master brand</span>
                  </li>
                  <li class="s23-a" style="--i:3">
                    <span class="s23-bf__id">D-015</span>
                    <b>What do we call the new reporting product?</b>
                    <span class="s23-bf__by">Settled by principle 01 · Clarity over cleverness</span>
                    <span class="s23-bf__out">Chosen · “Your company Reports”</span>
                  </li>
                </ol>
              <?php elseif ($s23_slug === 'brand-systems'): ?>
                <p class="s23__cap s23-a">Flex rules <span>ranges, not opinions</span></p>
                <ul class="s23-bs">
                  <?php foreach ($s23_fx as $s23_k => $s23_f): ?>
                    <li class="s23-a is-<?= $s23_f[4] ?>" style="--i:<?= $s23_k + 1 ?>">
                      <span class="s23-bs__l"><?= e($s23_f[0]) ?></span>
                      <span class="s23-bs__st"><?= $s23_f[4] === 'ok' ? 'flexes' : ($s23_f[4] === 'lock' ? 'locked' : 'flagged') ?></span>
                      <span class="s23-bs__track">
                        <?php if ($s23_f[1] !== null): ?><i class="s23-bs__band" style="--a:<?= $s23_f[1] ?>%;--b:<?= $s23_f[2] ?>%"></i><?php endif; ?>
                        <b class="s23-bs__thumb" style="--v:<?= $s23_f[3] ?>%;--i:<?= $s23_k + 2 ?>"></b>
                      </span>
                      <span class="s23-bs__v"><?= e($s23_f[5]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <p class="s23-bs__note s23-a" style="--i:6">Out-of-range values are sent back with the nearest allowed value: 30%.</p>
              <?php elseif ($s23_slug === 'brand-architecture'): ?>
                <p class="s23__cap s23-a">Migration plan <span>phased · nothing breaks</span></p>
                <div class="s23-ba">
                  <ol class="s23-ba__ph s23-a" style="--i:1"><li>01 Map</li><li>02 Endorse</li><li>03 Retire</li><li>04 Measure</li></ol>
                  <?php foreach ([
                      ['Your company', 'master brand throughout', [[1, 5, 'master']]],
                      ['Atlas',        'standalone → endorsed',   [[1, 2, 'old'], [2, 5, 'new']]],
                      ['Label B',      'retired into the master', [[1, 3, 'old'], [3, 4, 'end']]],
                  ] as $s23_k => $s23_ln): ?>
                    <div class="s23-ba__row s23-a" style="--i:<?= $s23_k + 2 ?>">
                      <p><b><?= e($s23_ln[0]) ?></b><?= e($s23_ln[1]) ?></p>
                      <span class="s23-ba__lane">
                        <?php foreach ($s23_ln[2] as $s23_sg): ?><i class="is-<?= $s23_sg[2] ?>" style="grid-column:<?= $s23_sg[0] ?> / <?= $s23_sg[1] ?>"></i><?php endforeach; ?>
                      </span>
                    </div>
                  <?php endforeach; ?>
                </div>
                <p class="s23-ba__gate s23-a" style="--i:5"><span class="s23__k">Gate before each phase</span>Search, support and sales scripts checked for the old names.</p>
              <?php else: ?>
                <p class="s23__cap s23-a">Generation queue <span>one source · four markets</span></p>
                <ul class="s23-ai">
                  <?php foreach ([
                      ['Variant 01', 'UK · 1:1',  [30, 30],  'ok',   'approved'],
                      ['Variant 02', 'DE · 4:5',  [26, 32],  'wait', 'with a person'],
                      ['Variant 03', 'FR · 9:16', [19, 34], 'no',   'rejected'],
                      ['Variant 04', 'ES · 16:9', [34, 19], 'run',  'generating'],
                  ] as $s23_k => $s23_q): ?>
                    <li class="s23-a is-<?= $s23_q[3] ?>" style="--i:<?= $s23_k + 1 ?>">
                      <span class="s23-ai__th"><i style="width:<?= $s23_q[2][0] ?>px;height:<?= $s23_q[2][1] ?>px"></i></span>
                      <span class="s23-ai__n"><b><?= e($s23_q[0]) ?></b><?= e($s23_q[1]) ?></span>
                      <span class="s23-ai__st"><?= e($s23_q[4]) ?></span>
                      <?php if ($s23_q[3] === 'no'): ?><span class="s23-ai__why">Headline states a claim that has not been approved</span><?php endif; ?>
                      <?php if ($s23_q[3] === 'run'): ?><span class="s23-ai__bar"><b></b></span><?php endif; ?>
                    </li>
                  <?php endforeach; ?>
                </ul>
                <ol class="s23-ai__log s23-a" style="--i:6">
                  <li>V01 · approved by brand lead</li>
                  <li>V03 · blocked by guardrail · reason sent to prompt owner</li>
                  <li>V02 · held for review · regulated market</li>
                </ol>
              <?php endif; ?>
              </div>
              <div class="s23__status"><span class="s23__ready">Ready for handover</span><span><?= e($s23_path[$s23_slug][1]) ?></span></div>
            </div>
            <p class="bdh-sr"><?= e($s23_desc[$s23_slug]) ?></p>
          </div>

          <div class="s23__spec">
            <p class="s23__top"><span class="bdh-idx"><?= e($s23_row['n']) ?> / <?= $s23_total ?></span><span class="s23__kick"><?= e($s23_row['kicker']) ?></span></p>
            <h3 class="s23__h" id="s23-<?= e($s23_slug) ?>-h"><?= e($s23_cap[0]) ?></h3>
            <p class="s23__lead"><?= e($s23_row['lead']) ?></p>

            <p class="s23__k s23__sk">Handed over</p>
            <ul class="bdh-list s23__list">
              <?php foreach (array_slice($s23_row['deliver'], 0, 5) as $s23_dl): ?>
                <li><?= e($s23_dl[0]) ?><small><?= e($s23_dl[1]) ?></small></li>
              <?php endforeach; ?>
            </ul>
            <?php if (count($s23_row['deliver']) > 5): ?>
              <p class="s23__more">+ <?= count($s23_row['deliver']) - 5 ?> more in the full handover</p>
            <?php endif; ?>

            <p class="s23__k s23__sk">How you know it worked</p>
            <ul class="bdh-bullets s23__out">
              <?php foreach ($s23_row['outcomes'] as $s23_o): ?><li><?= e($s23_o[0]) ?></li><?php endforeach; ?>
            </ul>

            <div class="s23__foot">
              <!-- PLACEHOLDER: typical length from data/brand-design.php — confirm before launch -->
              <span class="bdh-tag"><?= e(($s23_row['meta_k'][0] ?? 'Typical length') . ' · ' . $s23_row['meta'][0]) ?></span>
              <a class="tl" href="<?= xe_cap_url($s23_disc, $s23_cap) ?>">Explore <?= e($s23_cap[0]) ?> <span class="i" aria-hidden="true">›</span></a>
            </div>
          </div>

        </article>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
