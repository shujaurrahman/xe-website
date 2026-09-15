<?php /* DRAFT COPY — review before launch */
/* 13 · Onward — the Brand Design practice as a site plan. The other five capabilities are buildings
   on one plot (each a link); the two $BD pairs are marked and joined to "You are here" by dashed
   connectors; Brand Design is the gatehouse at the entrance. */
$cba_here = 'brand-architecture';
$cba_pairs = $CBA_CAP['pairs'];
$cba_others = array_values(array_filter($BRAND['caps'], fn ($cba_c) => ($cba_c[2] ?? '') !== $cba_here));
/* footprints on a 12 × 8 plot: [col start, col end (incl.), row start, row end (incl.)] */
$cba_foot = [[1, 4, 1, 2], [9, 12, 1, 3], [1, 3, 3, 5], [10, 12, 5, 8], [5, 8, 7, 8]];
$cba_here_ft = [5, 8, 3, 5];
$cba_gate_ft = [1, 3, 7, 8];
$cba_ctr = fn (array $f): array => [round(($f[0] - 1 + $f[1]) / 2 / 12 * 1200), round(($f[2] - 1 + $f[3]) / 2 / 8 * 700)];
[$cba_hx, $cba_hy] = $cba_ctr($cba_here_ft);
/* placement travels as custom properties so the phone layout (a stacked list) can override it */
$cba_area = fn (array $f): string => '--c1:' . $f[0] . ';--c2:' . ($f[1] + 1) . ';--r1:' . $f[2] . ';--r2:' . ($f[3] + 1);
?>
<section class="band band--alt cba-on" id="onward" aria-labelledby="onward-t">
  <div class="wrap">
    <div class="cba-head" data-rv>
      <div class="cba-head__t">
        <p class="cba-eb"><b>A-112</b><i aria-hidden="true"></i>Site plan · <?= e($BRAND['name']) ?></p>
        <h2 class="h2" id="onward-t"><span class="g">One practice, six buildings.</span> Architecture rarely stands alone.</h2>
      </div>
      <div class="cba-head__l">
        <p class="lead">Brand Architecture sits on the same plot as the five other Brand Design capabilities. Two of them are marked: the ones an architecture brief most often needs alongside it.</p>
      </div>
    </div>

    <div class="cba-on__site" data-bdh-in>
      <p class="cba-on__cap cba-mono" aria-hidden="true"><span>Plot · <?= e($BRAND['name']) ?> · 6 buildings</span><span class="cba-on__key"><i class="is-pair"></i>Pairs with Brand Architecture</span><span>N ↑</span></p>
      <div class="cba-on__plot">
        <svg class="cba-on__links" viewBox="0 0 1200 700" preserveAspectRatio="none" aria-hidden="true" focusable="false">
          <?php foreach ($cba_others as $cba_oi => $cba_oc): if (!in_array($cba_oc[2] ?? '', $cba_pairs, true)) continue; [$cba_px, $cba_py] = $cba_ctr($cba_foot[$cba_oi]); ?>
            <?php /* above "you are here": rise through the open bay first; below: run across, then drop */ ?>
            <path d="M<?= $cba_hx ?> <?= $cba_hy ?> <?= $cba_py < $cba_hy ? 'V' . $cba_py . ' H' . $cba_px : 'H' . $cba_px . ' V' . $cba_py ?>"/>
          <?php endforeach; ?>
        </svg>

        <div class="cba-on__b cba-on__b--here" style="<?= $cba_area($cba_here_ft) ?>">
          <span class="cba-on__no">B-<?= e($CBA_CAP['n']) ?> · You are here</span>
          <p class="cba-on__name"><?= e($CBA_CAP['name']) ?></p>
          <span class="cba-on__dot" aria-hidden="true"></span>
        </div>

        <?php foreach ($cba_others as $cba_oi => $cba_oc): $cba_isPair = in_array($cba_oc[2] ?? '', $cba_pairs, true); ?>
          <a class="cba-on__b<?= $cba_isPair ? ' is-pair' : '' ?>" style="<?= $cba_area($cba_foot[$cba_oi]) ?>" href="<?= xe_cap_url($BRAND, $cba_oc) ?>">
            <span class="cba-on__no">B-<?= e($BD[$cba_oc[2]]['n'] ?? sprintf('%02d', $cba_oi + 1)) ?><?= $cba_isPair ? ' · Pair' : '' ?></span>
            <h3 class="cba-on__name"><?= e($cba_oc[0]) ?></h3>
            <span class="cba-on__line"><?= e($cba_oc[1]) ?></span>
            <span class="cba-on__go" aria-hidden="true">›</span>
          </a>
        <?php endforeach; ?>

        <a class="cba-on__b cba-on__b--gate" style="<?= $cba_area($cba_gate_ft) ?>" href="<?= xe_discipline_url($BRAND) ?>">
          <span class="cba-on__no">Gatehouse · Entrance</span>
          <h3 class="cba-on__name">Back to <?= e($BRAND['name']) ?></h3>
          <span class="cba-on__go" aria-hidden="true">‹</span>
        </a>
        <span class="cba-on__entry" aria-hidden="true">Entrance</span>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own imagery before launch -->
    <figure class="cba-plate cba-on__photo" data-rv>
      <img src="<?= xe_url('assets/imgs/brand/brand-architecture/white-city-model.jpg') ?>" alt="A white site model of low buildings and streets seen from above at an angle" width="1400" height="934" loading="lazy" decoding="async">
      <figcaption><b>Fig. 07</b>Every building earns its place on the plot</figcaption>
    </figure>
  </div>
</section>
