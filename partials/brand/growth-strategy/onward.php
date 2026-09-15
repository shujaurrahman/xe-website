<?php /* DRAFT COPY — review before launch */
/* 13 Onward — a waypoint strip map. Growth Strategy is "you are here"; the other five Brand Design
   capabilities are waypoints along one route, the two $CAP pairs marked "Often paired"; the route ends
   back at the Brand Design hub. Names, one-liners and URLs come from $BRAND caps. */
$cgs_on_caps = array_values(array_filter($BRAND['caps'], fn ($c) => ($c[2] ?? '') !== 'growth-strategy'));
$cgs_on_pairs = $CAP['pairs'] ?? [];
usort($cgs_on_caps, fn ($a, $b) => (int) in_array($b[2], $cgs_on_pairs, true) <=> (int) in_array($a[2], $cgs_on_pairs, true));
$cgs_on_here = null;
foreach ($BRAND['caps'] as $cgs_c) { if ($cgs_c[2] === 'growth-strategy') $cgs_on_here = $cgs_c; }
?>
<section class="band band--alt cgs-onward" id="onward" aria-labelledby="onward-t">
  <span class="cgs-survey" aria-hidden="true"></span>
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>13</b><i></i>Where to go from here</p>
        <h2 class="h2" id="onward-t"><span class="g">The shortlist is the start.</span> The rest of Brand Design takes it further.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">Growth Strategy decides where to play. These capabilities decide how the brand shows up there, and most engagements pair it with two of them.</p>
        <a class="tl" href="<?= xe_discipline_url($BRAND) ?>">Back to <?= e($BRAND['name']) ?> <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <nav class="cgs-on" aria-label="Other <?= e($BRAND['name']) ?> capabilities" data-cgs-onward>
      <ol class="cgs-on__list">
        <li class="cgs-on__route" aria-hidden="true"></li>
        <li class="cgs-on__pt cgs-on__pt--here" style="--i:0">
          <span class="cgs-on__pin" aria-hidden="true"></span>
          <p class="cgs-on__k">You are here · <?= e($CAP['n']) ?></p>
          <p class="cgs-on__name"><?= e($CAP['name']) ?></p>
          <p class="cgs-on__line"><?= e($cgs_on_here[1] ?? $CAP['kicker']) ?></p>
        </li>
        <?php foreach ($cgs_on_caps as $cgs_oi => $cgs_oc): $cgs_pair = in_array($cgs_oc[2], $cgs_on_pairs, true); ?>
          <li class="cgs-on__pt<?= $cgs_pair ? ' is-pair' : '' ?>" style="--i:<?= $cgs_oi + 1 ?>">
            <a class="cgs-on__a" href="<?= xe_cap_url($BRAND, $cgs_oc) ?>">
              <span class="cgs-on__pin" aria-hidden="true"></span>
              <span class="cgs-on__k"><?= $cgs_pair ? 'Often paired' : 'Waypoint ' . sprintf('%02d', $cgs_oi + 1) ?></span>
              <span class="cgs-on__name"><?= e($cgs_oc[0]) ?>&nbsp;<i aria-hidden="true">›</i></span>
              <span class="cgs-on__line"><?= e($cgs_oc[1]) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
      <a class="cgs-on__base" href="<?= xe_discipline_url($BRAND) ?>">
        <span class="cgs-on__k">Return to base</span>
        <span class="cgs-on__bn"><?= e($BRAND['name']) ?> · all <?= count($BRAND['caps']) ?> capabilities</span>
        <span class="cgs-on__arrow" aria-hidden="true">›</span>
      </a>
    </nav>
  </div>
</section>
