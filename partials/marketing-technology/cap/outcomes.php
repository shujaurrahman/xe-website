<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Outcomes: three aims from the data, beside the hub's data-viz idiom (.mth-viz) drawn from topics.php.
   The chart is a shape, labelled ILLUSTRATIVE, never a claimed result. */
$mtd_v  = $MTD_X['viz'];
$mtd_ho = $mtd_head('out', ['Three things', 'you should notice.', 'Outcomes we design for and measure against a holdout or an agreed baseline.']);
$mtd_lo = min(array_merge($mtd_v[3], $mtd_v[4])); $mtd_hi = max(array_merge($mtd_v[3], $mtd_v[4]));
$mtd_pt = fn (array $s): array => array_map(fn ($mtd_j, $mtd_y) => [30 + $mtd_j * 90, round(200 - ($mtd_y - $mtd_lo) / max(1, $mtd_hi - $mtd_lo) * 160, 1)], array_keys($s), $s);
$mtd_a  = $mtd_pt($mtd_v[3]);
$mtd_b  = $mtd_pt($mtd_v[4]);
$mtd_ps = fn (array $p): string => implode(' ', array_map(fn ($mtd_q) => $mtd_q[0] . ',' . $mtd_q[1], $p));
?>
<section class="band band--alt mtd-out" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>What changes</p>
        <h2 class="h2" id="outcomes-t"><span class="g"><?= e($mtd_ho[0]) ?></span> <?= e($mtd_ho[1]) ?></h2></div>
      <div><p class="lead"><?= e($mtd_ho[2]) ?> They are aims, not guarantees.</p></div>
    </div>
    <div class="mtd-out__g">
      <ol class="mtd-out__l">
        <?php foreach ($CAP['outcomes'] as $mtd_i => $mtd_o): ?>
        <li class="mtd-out__i" data-rv>
          <span class="bdh-idx"><?= sprintf('%02d', $mtd_i + 1) ?></span>
          <div><h3 class="bdh-t bdh-t--l"><?= e($mtd_o[0]) ?></h3><p class="bdh-d"><?= e($mtd_o[1]) ?></p></div>
        </li>
        <?php endforeach; ?>
      </ol>
      <figure class="mth-viz mtd-out__viz" data-rv>
        <figcaption class="mth-viz__head"><span><?= e($mtd_v[0]) ?></span><span class="mth-viz__key">With</span><span class="mth-viz__key mth-viz__key--b">Without</span><span class="mth-viz__ill">Illustrative</span></figcaption>
        <svg viewBox="0 0 600 240" role="img" aria-label="<?= e($mtd_v[1]) ?>. An illustrative shape, not a measured result.">
          <?php foreach ([40, 90, 140, 190, 220] as $mtd_y): ?><line class="mth-viz__grid" x1="0" x2="600" y1="<?= $mtd_y ?>" y2="<?= $mtd_y ?>"/><?php endforeach; ?>
          <polygon class="mth-viz__gap" points="<?= $mtd_ps($mtd_a) ?> <?= $mtd_ps(array_reverse($mtd_b)) ?>"/>
          <polyline class="mth-viz__b" points="<?= $mtd_ps($mtd_b) ?>"/>
          <polyline class="mth-viz__a" points="<?= $mtd_ps($mtd_a) ?>"/>
          <circle class="mth-viz__dot" cx="<?= end($mtd_a)[0] ?>" cy="<?= end($mtd_a)[1] ?>" r="5"/>
        </svg>
        <div class="mth-viz__axis" aria-hidden="true"><?php foreach ($mtd_v[2] as $mtd_x): ?><span><?= e($mtd_x) ?></span><?php endforeach; ?></div>
        <p class="mth-viz__note"><b><?= e($mtd_v[1]) ?>.</b> <?= e($mtd_v[5]) ?></p>
      </figure>
    </div>
  </div>
</section>
