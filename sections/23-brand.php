<?php /* DRAFT COPY — review before launch */
/* 23 — Brand Design, in depth: what each of the six capabilities actually hands over.
   08-disciplines names the six; this section opens one at a time and shows the artefact it
   produces, the files handed over and how you know it worked.

   Data: names, one-liners and page links from data/site.php (the brand-design row, through
   xe_cap_url, which only links pages that exist); kicker, lead, meta, deliverables and outcomes
   from data/brand-design.php. Only the artefact mocks are written here.

   Without JavaScript every capability renders in full, one after another, and the selector stays
   hidden. 23-brand.js turns the selector on, hides all but the current capability (hidden, so
   only one pane is ever in flow) and adds .is-anim so artefacts can build in. */
$s23_bd   = require __DIR__ . '/../data/brand-design.php';
$s23_disc = null;
foreach ($GLOBALS['SITE']['disciplines'] as $s23_row) { if ($s23_row['slug'] === 'brand-design') $s23_disc = $s23_row; }
unset($s23_row);
$s23_caps  = $s23_disc ? $s23_disc['caps'] : [];
$s23_total = str_pad((string) count($s23_caps), 2, '0', STR_PAD_LEFT);
$s23_path  = [
    'growth-strategy'    => 'strategy / next-best-customer',
    'brand-identity'     => 'identity / kit-v1',
    'brand-foundation'   => 'foundation / on-a-page',
    'brand-systems'      => 'system / tokens',
    'brand-architecture' => 'portfolio / model',
    'brand-ai-tools'     => 'ai-tools / brand-check',
];
$s23_fmt  = [   /* the formats this artefact ships in — from its row in data/brand-design.php 'deliver' */
    'growth-strategy'    => 'Sheet · Deck',
    'brand-identity'     => 'SVG · Figma · JSON',
    'brand-foundation'   => 'PDF · Print',
    'brand-systems'      => 'JSON · Figma · CSS',
    'brand-architecture' => 'Figma · Sheet',
    'brand-ai-tools'     => 'Plugin · API',
];
$s23_desc = [
    'growth-strategy'    => 'Illustration: a ranked list of four customer segments with scores, each tagged now, next, later or park, above a one-line growth thesis.',
    'brand-identity'     => 'Illustration: an identity kit showing a logo lockup inside its clearspace frame, four colour swatches, three typefaces and a voice rule of words to use and words to avoid.',
    'brand-foundation'   => 'Illustration: a foundation on a page, with a fill-in positioning statement and three principles, each noting the kind of decision it settles.',
    'brand-systems'      => 'Illustration: four design tokens feeding three surfaces, an app button, an email call to action and a social tile, which all read the same values.',
    'brand-architecture' => 'Illustration: a portfolio tree with a master brand above two branded products and one endorsed product, and the naming rule they follow.',
    'brand-ai-tools'     => 'Illustration: a generated campaign asset beside a brand check that passes palette, clearspace, type and tone, and routes a claim to a person for review before it is logged.',
];
?>
<section class="band band--alt s23 bdh" id="brand" aria-labelledby="s23-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row s23__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Brand Design, in depth</p>
        <h2 class="h2" id="s23-t"><span class="g">What we make for a brand.</span> Six capabilities, each ending in files you own.</h2>
      </div>
      <div>
        <p class="lead">Strategy, identity and the systems that carry them. Every capability is scoped on its own, hands over named artefacts your teams can use, and plugs into the other five.</p>
        <a class="tl" href="<?= xe_url('services/brand-design.php') ?>">Explore Brand Design <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="s23__app" data-s23 data-rv data-rv-d="80">
      <div class="s23__tabs" role="tablist" aria-label="Brand Design capabilities">
        <?php foreach ($s23_caps as $s23_i => $s23_cap):
                $s23_slug = $s23_cap[2]; $s23_row = $s23_bd[$s23_slug]; ?>
          <button class="s23__tab" type="button" role="tab" id="s23-tab-<?= e($s23_slug) ?>" aria-controls="s23-<?= e($s23_slug) ?>"
                  aria-selected="<?= $s23_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $s23_i === 0 ? '0' : '-1' ?>">
            <i class="s23__prog" aria-hidden="true"><b></b></i>
            <span class="s23__tn" aria-hidden="true"><?= e($s23_row['n']) ?></span>
            <span class="s23__tname"><?= e($s23_cap[0]) ?></span>
            <span class="s23__tk"><?= e($s23_row['kicker']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="s23__panes">
        <?php foreach ($s23_caps as $s23_i => $s23_cap):
                $s23_slug = $s23_cap[2]; $s23_row = $s23_bd[$s23_slug]; ?>
        <article class="s23__pane" id="s23-<?= e($s23_slug) ?>" aria-labelledby="s23-<?= e($s23_slug) ?>-h">

          <div class="s23__art">
            <div class="bdh-ui s23__win" aria-hidden="true">
              <div class="bdh-ui__bar s23__bar">
                <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
                <span class="s23__crumb">your-company / <?= e($s23_path[$s23_slug]) ?></span>
                <span class="s23__ver">v1.0</span>
              </div>
              <div class="s23__canvas s23__canvas--<?= e($s23_slug) ?>">
              <?php if ($s23_slug === 'growth-strategy'): ?>
                <!-- PLACEHOLDER: illustrative segments and scores — not client data -->
                <p class="s23__cap s23-a">Next-best-customer ranking <span>fit · reach · margin</span></p>
                <ol class="s23-gs__rank">
                  <?php foreach ([['Segment A', 86, 'Now'], ['Segment B', 71, 'Next'], ['Segment C', 58, 'Later'], ['Segment D', 34, 'Park']] as $s23_k => $s23_seg): ?>
                    <li class="s23-a<?= $s23_k === 0 ? ' is-top' : '' ?>" style="--i:<?= $s23_k + 1 ?>">
                      <span class="s23-gs__name"><?= e($s23_seg[0]) ?></span>
                      <span class="s23-gs__bar"><b class="s23-g" style="--w:<?= $s23_seg[1] / 100 ?>;--i:<?= $s23_k + 2 ?>"></b></span>
                      <span class="s23-gs__score"><?= $s23_seg[1] ?></span>
                      <span class="s23-gs__stage"><?= e($s23_seg[2]) ?></span>
                    </li>
                  <?php endforeach; ?>
                </ol>
                <div class="s23-gs__thesis s23-a" style="--i:6">
                  <span class="s23__k">Growth thesis</span>
                  <p>Growth comes from Segment A first, through the channel it already buys in, if onboarding time halves.</p>
                </div>
                <ul class="s23-gs__moves">
                  <li class="s23-a" style="--i:7"><span class="s23__k">Now · owner set</span>Pilot offer for Segment A</li>
                  <li class="s23-a" style="--i:8"><span class="s23__k">Next · Q+1</span>Partner channel for Segment B</li>
                  <li class="s23-a" style="--i:9"><span class="s23__k">Later · gated</span>Enter Segment C once A converts</li>
                </ul>
              <?php elseif ($s23_slug === 'brand-identity'): ?>
                <div class="s23-bi">
                  <div class="s23-bi__logo s23-a" style="--i:1">
                    <span class="s23__k">Lockup · clearspace</span>
                    <div class="s23-bi__frame"><span class="s23-bi__mark"><i></i></span><b>Your company</b></div>
                  </div>
                  <div class="s23-bi__col s23-a" style="--i:2">
                    <span class="s23__k">Colour</span>
                    <ul class="s23-bi__sw"><li><i class="is-ink"></i>Ink</li><li><i class="is-blue"></i>Signal</li><li><i class="is-paper"></i>Paper</li><li><i class="is-line"></i>Line</li></ul>
                  </div>
                  <div class="s23-bi__col s23-a" style="--i:3">
                    <span class="s23__k">Type</span>
                    <ul class="s23-bi__type"><li><b class="is-h">Aa</b>Display</li><li><b class="is-b">Aa</b>Text</li><li><b class="is-m">Aa</b>Data</li></ul>
                  </div>
                  <div class="s23-bi__voice s23-a" style="--i:4">
                    <span class="s23__k">Voice</span>
                    <p><span class="is-yes">clear</span><span class="is-yes">direct</span><span class="is-yes">warm</span><span class="is-no">best-in-class</span><span class="is-no">synergy</span></p>
                  </div>
                </div>
              <?php elseif ($s23_slug === 'brand-foundation'): ?>
                <p class="s23__cap s23-a">Foundation on a page <span>signed by leadership</span></p>
                <p class="s23-bf__pos s23-a" style="--i:1">For <u>enterprise teams</u> who <u>need one story in every market</u>, Your company is the <u>partner</u> that <u>keeps every market aligned</u>.</p>
                <ol class="s23-bf__pr">
                  <?php foreach ([['Clarity over cleverness', 'naming and copy calls'], ['One brand, many markets', 'local variations'], ['Prove, then promise', 'claims and launches']] as $s23_k => $s23_p): ?>
                    <li class="s23-a" style="--i:<?= $s23_k + 2 ?>"><span class="s23-bf__n">0<?= $s23_k + 1 ?></span><b><?= e($s23_p[0]) ?></b><small>Settles <?= e($s23_p[1]) ?></small></li>
                  <?php endforeach; ?>
                </ol>
              <?php elseif ($s23_slug === 'brand-systems'): ?>
                <div class="s23-bs">
                  <div class="s23-bs__tokens s23-a">
                    <span class="s23__k">tokens.json</span>
                    <ul>
                      <li style="--t:0"><span>color.action</span><em>blue</em></li>
                      <li style="--t:1"><span>radius.control</span><em>10</em></li>
                      <li style="--t:2"><span>space.inset</span><em>16</em></li>
                      <li style="--t:3"><span>type.label</span><em>13/20</em></li>
                    </ul>
                  </div>
                  <span class="s23-bs__to s23-a" style="--i:2"><span>exports to</span></span>
                  <ul class="s23-bs__out">
                    <li class="s23-a" style="--i:3"><span class="s23__k">App</span><span class="s23-bs__btn">Continue</span></li>
                    <li class="s23-a" style="--i:4"><span class="s23__k">Email</span><span class="s23-bs__line"></span><span class="s23-bs__btn">Read more</span></li>
                    <li class="s23-a" style="--i:5"><span class="s23__k">Social</span><span class="s23-bs__tile"><i></i><span class="s23-bs__btn">Join</span></span></li>
                  </ul>
                </div>
              <?php elseif ($s23_slug === 'brand-architecture'): ?>
                <p class="s23__cap s23-a">Portfolio model <span>branded house · one endorsed</span></p>
                <div class="s23-ba">
                  <b class="s23-ba__master s23-a" style="--i:1">Your company</b>
                  <ul class="s23-ba__kids">
                    <li class="s23-a" style="--i:2"><b>Cloud</b><small>branded</small></li>
                    <li class="s23-a" style="--i:3"><b>Studio</b><small>branded</small></li>
                    <li class="s23-a is-end" style="--i:4"><b>Atlas</b><small>endorsed</small></li>
                  </ul>
                </div>
                <p class="s23-ba__rule s23-a" style="--i:5"><span class="s23__k">Naming rule</span><code>[master] + [plain descriptor]</code></p>
              <?php else: ?>
                <div class="s23-ai">
                  <div class="s23-ai__asset s23-a">
                    <span class="s23__k">Variant 12 · 4:5 · DE</span>
                    <div class="s23-ai__img"><span class="s23-ai__arc"></span><span class="s23-ai__mk"><span class="s23-bi__mark"><i></i></span>Your company</span><i class="s23-ai__h"></i><i class="s23-ai__s"></i><span class="s23-ai__cta"></span><span class="s23-ai__scan"></span></div>
                  </div>
                  <div class="s23-ai__chk">
                    <span class="s23__k">Brand check</span>
                    <ul>
                      <?php foreach (['Palette', 'Clearspace', 'Type', 'Tone of voice'] as $s23_k => $s23_c): ?>
                        <li class="s23-a" style="--i:<?= $s23_k + 1 ?>"><span><?= e($s23_c) ?></span><b class="bdh-ok">pass</b></li>
                      <?php endforeach; ?>
                      <li class="s23-a is-flag" style="--i:5"><span>Product claim</span><span class="bdh-flag">human review</span></li>
                    </ul>
                    <p class="s23-ai__log s23-a" style="--i:6">approved by brand lead · logged</p>
                  </div>
                </div>
              <?php endif; ?>
              </div>
              <div class="s23__status"><span class="s23__ready">Ready for handover</span><span><?= e($s23_fmt[$s23_slug]) ?></span></div>
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
