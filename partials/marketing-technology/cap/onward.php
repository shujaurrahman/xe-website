<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Onward aid: the two capabilities this one pairs with, then every other sibling and the hub. */
$mtd_rows = [];
foreach ($DISC['caps'] as $mtd_r) $mtd_rows[$mtd_r[2]] = $mtd_r;
$mtd_rest = array_values(array_filter(array_keys($CAPS), fn ($mtd_k) => $mtd_k !== $MTD_KEY && !in_array($mtd_k, $CAP['pairs'], true)));
?>
<section class="band band--ink mtd-on" id="next" aria-labelledby="next-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl"><span class="dot"></span>Works best with</p>
        <h2 class="h2" id="next-t"><span class="g">One engine,</span> more of it switched on.</h2></div>
      <div><p class="lead">Each capability runs on its own. These two share the most data, consent and measurement with <?= e(strtolower($CAP['short'])) ?>, so they cost least to add next.</p></div>
    </div>
    <div class="mtd-on__pair">
      <?php foreach ($CAP['pairs'] as $mtd_k): $mtd_p = $CAPS[$mtd_k] ?? null; if (!$mtd_p) continue; ?>
      <a class="mth-mod mtd-on__card" href="<?= e(xe_cap_url($DISC, $mtd_rows[$mtd_k])) ?>" data-rv>
        <span class="mth-mod__bar"><span class="bdh-idx"><?= e($mtd_p['n']) ?></span><?= xt_icon($mtd_p['icon']) ?><span><?= e($mtd_p['kicker']) ?></span></span>
        <span class="mth-mod__body">
          <span class="mtd-on__t"><?= e($mtd_p['name']) ?></span>
          <span class="mtd-on__d"><?= e($mtd_rows[$mtd_k][1]) ?></span>
        </span>
        <span class="mth-mod__foot"><span class="mtd-on__go">Explore <?= e($mtd_p['short']) ?> <span class="i" aria-hidden="true">›</span></span></span>
      </a>
      <?php endforeach; ?>
    </div>
    <nav class="mtd-on__all" aria-label="Other <?= e($DISC['name']) ?> capabilities">
      <p class="bdh-ro">Also in <?= e($DISC['name']) ?></p>
      <ul>
        <?php foreach ($mtd_rest as $mtd_k): ?>
        <li><a href="<?= e(xe_cap_url($DISC, $mtd_rows[$mtd_k])) ?>"><span class="bdh-ro"><?= e($CAPS[$mtd_k]['n']) ?></span> <?= e($CAPS[$mtd_k]['name']) ?></a></li>
        <?php endforeach; ?>
        <li><a class="mtd-on__hub" href="<?= e(xe_discipline_url($DISC)) ?>">All of <?= e($DISC['name']) ?> <span class="i" aria-hidden="true">›</span></a></li>
      </ul>
    </nav>
  </div>
</section>
