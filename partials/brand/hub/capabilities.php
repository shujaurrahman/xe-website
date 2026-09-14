<?php /* DRAFT COPY — review before launch */
/* The six capabilities, in depth. Order, names, one-liners and links come from data/site.php;
   kicker, lead, meta and deliverables from data/brand-design.php. Only the triggers, the photo
   choice and the small artefact cards live here. #cap-<slug>[data-cap] drives the navigator dock. */
$cap_triggers = [
    'growth-strategy'    => ['Growth has stalled in the core segment.', 'A new market or category is on the table.', 'Sales and marketing disagree on who the customer is.'],
    'brand-identity'     => ['The identity no longer fits what the company has become.', 'A merger, spin-off or listing needs a new face.', 'Every team has drifted into its own version of the brand.'],
    'brand-foundation'   => ['Leadership describes the company five different ways.', 'A new strategy needs a brand that can carry it.', 'Decisions stall because nothing settles the argument.'],
    'brand-systems'      => ['Assets are rebuilt by hand in every market.', 'Product and marketing ship two different brands.', 'Partners cannot stay on brand without a review queue.'],
    'brand-architecture' => ['An acquisition has to find its place.', 'A new product needs a name and nobody agrees.', 'Customers confuse two of your offerings.'],
    'brand-ai-tools'     => ['Content demand has outrun the brand team.', 'Teams already use generative tools without guardrails.', 'Localisation at volume is slow and inconsistent.'],
];
/* PLACEHOLDER: reference photography (Unsplash) — replace with commissioned/own imagery before launch */
$cap_photos = [
    'growth-strategy'    => ['growth.jpg',       1200, 802,  'A strategy workshop wall covered in sticky notes and sketches', '50% 50%'],
    'brand-identity'     => ['identity.jpg',     1200, 800,  'Stacks of blank business cards on a pale surface',              '50% 50%'],
    'brand-foundation'   => ['foundation.jpg',   800,  1200, 'A team working together at a glass wall',                       '50% 40%'],
    'brand-systems'      => ['systems.jpg',      1200, 811,  'A hand holding a phone with a blank screen in soft light',       '46% 50%'],
    'brand-architecture' => ['architecture.jpg', 1200, 800,  'Office towers seen from street level, looking straight up',       '50% 50%'],
    'brand-ai-tools'     => ['ai-tools.jpg',     1200, 675,  'Hands working on a laptop at a desk',                           '50% 50%'],
];
$cap_total = str_pad((string) count($BRAND['caps']), 2, '0', STR_PAD_LEFT);
?>
<section class="band band--alt bdh-capabilities" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Six capabilities</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Six ways in.</span> One system out.</h2>
      </div>
      <div><p class="lead">Start with any one. Each is scoped and delivered on its own, and each is built to plug into the other five.</p></div>
    </div>

    <div class="bdh-caps__list">
      <?php foreach ($BRAND['caps'] as $cap_i => $cap_row):
              $cap_slug = $cap_row[2];
              $cap_bd   = $BD[$cap_slug];
              $cap_img  = $cap_photos[$cap_slug];
              $cap_n    = str_pad((string) ($cap_i + 1), 2, '0', STR_PAD_LEFT); ?>
        <article class="bdh-cap" id="cap-<?= e($cap_slug) ?>" data-cap="<?= e($cap_slug) ?>" aria-labelledby="cap-<?= e($cap_slug) ?>-t">
          <div class="bdh-cap__media bdh-zoom" data-rv>
            <figure class="bdh-img bdh-img--r45 bdh-img--xl bdh-cap__img" data-bdh-parallax="0.04">
              <img src="<?= xe_url('assets/imgs/brand/hub/capabilities/' . $cap_img[0]) ?>" alt="<?= e($cap_img[3]) ?>" width="<?= $cap_img[1] ?>" height="<?= $cap_img[2] ?>" loading="lazy" decoding="async" style="object-position:<?= e($cap_img[4]) ?>">
            </figure>

            <div class="bdh-cap__art bdh-up" style="--i:3" aria-hidden="true">
              <?php if ($cap_slug === 'growth-strategy'): ?>
                <p class="bdh-cap__ah">Next best customer · ranked</p>
                <ul class="bdh-cap__rank">
                  <li><span>Segment A</span><i><b class="bdh-grow" style="--w:.86;--i:5"></b></i><em>86</em></li>
                  <li><span>Segment B</span><i><b class="bdh-grow" style="--w:.64;--i:6"></b></i><em>64</em></li>
                  <li><span>Segment C</span><i><b class="bdh-grow" style="--w:.41;--i:7"></b></i><em>41</em></li>
                </ul>
                <span class="bdh-tag bdh-tag--blue">Next best · Segment A</span>
              <?php elseif ($cap_slug === 'brand-identity'): ?>
                <p class="bdh-cap__ah">Identity kit · v1.0</p>
                <div class="bdh-cap__kit"><span class="bdh-cap__sw"><i></i><i></i><i></i></span><b class="bdh-cap__aa">Aa</b><span class="bdh-cap__scale"><i></i><i></i><i></i></span></div>
                <p class="bdh-cap__voice"><span>Clear</span><span>Direct</span><span>Warm</span></p>
              <?php elseif ($cap_slug === 'brand-foundation'): ?>
                <p class="bdh-cap__ah">Positioning statement</p>
                <p class="bdh-cap__pos">For <u>enterprise teams</u> who <u>need one clear story</u>, Your brand is the <u>partner</u> that <u>keeps every market aligned</u>.</p>
              <?php elseif ($cap_slug === 'brand-systems'): ?>
                <p class="bdh-cap__ah">tokens.json <span class="bdh-tag">v2.4</span></p>
                <ul class="bdh-cap__code">
                  <li><span>color.action.primary</span><em>blue</em></li>
                  <li><span>space.4</span><em>16</em></li>
                  <li><span>radius.card</span><em>14</em></li>
                  <li><span>type.body</span><em>15 / 24</em></li>
                </ul>
              <?php elseif ($cap_slug === 'brand-architecture'): ?>
                <p class="bdh-cap__ah">Portfolio model · endorsed</p>
                <div class="bdh-cap__tree">
                  <b>Master brand</b>
                  <span class="bdh-cap__wires"></span>
                  <ul><li>Sub-brand A</li><li>Sub-brand B</li><li>Product C<small>endorsed</small></li></ul>
                </div>
              <?php else: ?>
                <p class="bdh-cap__ah">Brand check · asset 0412</p>
                <ul class="bdh-cap__chk">
                  <li><span>Palette</span><b class="bdh-ok">✓</b></li>
                  <li><span>Clearspace</span><b class="bdh-ok">✓</b></li>
                  <li><span>Tone of voice</span><b class="bdh-ok">✓</b></li>
                  <li><span>Claims</span><span class="bdh-flag">review</span></li>
                </ul>
              <?php endif; ?>
            </div>
          </div>

          <div class="bdh-cap__body" data-rv data-rv-d="90">
            <p class="bdh-cap__top"><span class="bdh-idx"><?= $cap_n ?> / <?= $cap_total ?></span><span class="lbl"><?= e($cap_bd['kicker']) ?></span></p>
            <h3 class="bdh-cap__h" id="cap-<?= e($cap_slug) ?>-t"><?= e($cap_row[0]) ?></h3>
            <p class="bdh-cap__one"><?= e($cap_row[1]) ?></p>
            <p class="bdh-cap__lead"><?= e($cap_bd['lead']) ?></p>

            <div class="bdh-cap__cols">
              <div>
                <p class="bdh-cap__k">What you get</p>
                <ul class="bdh-list">
                  <?php foreach (array_slice($cap_bd['deliver'], 0, 5) as $cap_d): ?>
                    <li><?= e($cap_d[0]) ?><small><?= e($cap_d[1]) ?></small></li>
                  <?php endforeach; ?>
                </ul>
              </div>
              <div>
                <p class="bdh-cap__k">When enterprises call us</p>
                <ul class="bdh-bullets">
                  <?php foreach ($cap_triggers[$cap_slug] as $cap_t): ?><li><?= e($cap_t) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>

            <div class="bdh-cap__foot">
              <!-- PLACEHOLDER: typical lengths come from data/brand-design.php — confirm before launch -->
              <p class="bdh-tags">
                <?php foreach (array_slice($cap_bd['meta'], 0, 2) as $cap_k => $cap_m): ?>
                  <span class="bdh-tag"><?= e(($cap_bd['meta_k'][$cap_k] ?? '') . ' · ' . $cap_m) ?></span>
                <?php endforeach; ?>
              </p>
              <a class="tl" href="<?= xe_cap_url($BRAND, $cap_row) ?>">Explore <?= e($cap_row[0]) ?> <span class="i" aria-hidden="true">›</span></a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
