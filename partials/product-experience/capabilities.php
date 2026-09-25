<?php /* DRAFT COPY — review before launch */
/* Capabilities — the card system. Each card's id is its capability slug (stable anchor for the pages to come).
   The fidelity rail shows where in the signal → shipped loop the capability does most of its work. */
$pxh_cap_fid = [
    'design-consulting-solutioning'   => [1, 2, 3],
    'product-strategy-vision'         => [1, 2],
    'experience-design-development'   => [2, 3, 4, 5],
    'ai-product-strategy-development' => [1, 3, 4, 5],
    'system-design'                   => [3, 4, 5],
];
$pxh_cap_short = [];
$pxh_cap_row = [];
foreach ($DISC['caps'] as $pxh_dc) { $pxh_cap_short[$pxh_dc[2]] = $pxh_dc[1]; $pxh_cap_row[$pxh_dc[2]] = $pxh_dc; }
?>
<section class="band band--alt pxh-capabilities" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Five capabilities</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Five ways in.</span> One loop from signal to shipped.</h2></div>
      <div><p class="lead">Start with any one. Each is scoped and delivered on its own, and each hands its evidence to the next, so a strategy arrives with its research and a design arrives with its tests.</p></div>
    </div>
    <div class="pxh-cards" data-bdh-stagger>
      <?php foreach ($CAPS as $pxh_slug => $pxh_cap): $pxh_on = $pxh_cap_fid[$pxh_slug] ?? []; ?>
      <article class="pxh-card pxh-capabilities__card" id="<?= e($pxh_slug) ?>" aria-labelledby="<?= e($pxh_slug) ?>-t">
        <div class="pxh-card__top">
          <span class="pxh-card__idx"><?= e($pxh_cap['n']) ?> / 0<?= count($CAPS) ?> · <?= e($pxh_cap['short']) ?></span>
          <span class="pxh-card__ico"><?= xt_icon($pxh_cap['icon']) ?></span>
        </div>
        <p class="pxh-card__k"><?= e($pxh_cap['kicker']) ?></p>
        <h3 class="pxh-card__t" id="<?= e($pxh_slug) ?>-t"><?= e($pxh_cap['name']) ?></h3>
        <p class="pxh-card__d"><?= e($pxh_cap_short[$pxh_slug] ?? '') ?></p>
        <ul class="pxh-card__list">
          <?php foreach (array_slice($pxh_cap['offer'], 0, 3) as $pxh_o): ?><li><?= e($pxh_o[0]) ?></li><?php endforeach; ?>
        </ul>
        <div class="pxh-capabilities__fid">
          <ul class="pxh-fid" aria-label="Where it works in the loop: <?= e(implode(', ', array_map(fn ($pxh_n) => ['Signal', 'Journey', 'Wireframe', 'Prototype', 'Shipped'][$pxh_n - 1], $pxh_on))) ?>">
            <?php for ($pxh_n = 1; $pxh_n <= 5; $pxh_n++): ?><li<?= in_array($pxh_n, $pxh_on, true) ? ' class="on"' : '' ?>></li><?php endfor; ?>
          </ul>
          <div class="pxh-fid__k" aria-hidden="true"><span>Signal</span><span>Shipped</span></div>
        </div>
        <div class="pxh-card__foot">
          <!-- PLACEHOLDER: confirm typical length before launch -->
          <span class="pxh-card__meta"><?= e($pxh_cap['meta_k'][0]) ?> · <?= e($pxh_cap['meta'][0]) ?></span>
          <a class="tl" href="<?= e(xe_cap_url($DISC, $pxh_cap_row[$pxh_slug])) ?>">Explore <?= e($pxh_cap['short']) ?><span class="sr"> — <?= e($pxh_cap['name']) ?></span> <span class="i" aria-hidden="true"></span></a>
        </div>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
