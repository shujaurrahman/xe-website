<?php
/**
 * The way onward: the next capability as a large photograph card, the previous
 * one beside it, and where this page sits among the six.
 *
 *   $BD   required  all six capabilities
 *   $cap  required  the current capability
 */
require_once __DIR__ . '/icons.php';
$nxKeys = array_keys($BD);
$nxCnt  = count($nxKeys);
$nxAt   = array_search($cap['slug'], $nxKeys, true);
if ($nxAt === false) { $nxAt = 0; }
$nxNext = $BD[$nxKeys[($nxAt + 1) % $nxCnt]];
$nxPrev = $BD[$nxKeys[($nxAt - 1 + $nxCnt) % $nxCnt]];
?>
<section class="bd-next" aria-labelledby="next-t">
  <div class="wrap">
    <div class="bd-next__bar" data-rv>
      <h2 class="lbl" id="next-t"><span class="dot"></span>Keep going</h2>
      <span class="bd-next__dots" aria-hidden="true"><?php foreach ($nxKeys as $j => $key): ?><i class="<?= $j === $nxAt ? 'is-here' : ($key === $nxNext['slug'] ? 'is-next' : '') ?>"></i><?php endforeach; ?></span>
      <span class="bd-next__pos num" aria-hidden="true"><?= e($cap['n']) ?> / <?= str_pad((string) $nxCnt, 2, '0', STR_PAD_LEFT) ?></span>
    </div>

    <div class="bd-next__in" data-rv data-rv-d="80">
      <a class="bd-next__prev" href="<?= xe_url('services/brand-design/' . $nxPrev['slug'] . '.php') ?>" aria-label="Previous: <?= e($nxPrev['name']) ?>">
        <span class="bd-next__parrow" aria-hidden="true">‹</span>
        <span class="bd-next__lbl">Previous · <?= e($nxPrev['n']) ?></span>
        <span class="bd-next__pt"><?= e($nxPrev['name']) ?></span>
        <span class="bd-next__pk"><?= e($nxPrev['kicker']) ?></span>
      </a>

      <a class="bd-next__go" href="<?= xe_url('services/brand-design/' . $nxNext['slug'] . '.php') ?>" aria-label="Next: <?= e($nxNext['name']) ?>">
        <span class="bd-next__txt">
          <span class="bd-next__lbl">Next · <?= e($nxNext['n']) ?> · <?= e($nxNext['kicker']) ?></span>
          <span class="bd-next__t"><?= e($nxNext['name']) ?></span>
          <span class="bd-next__d"><?= e($nxNext['lead']) ?></span>
          <span class="bd-next__cta">Explore <?= e($nxNext['short']) ?> <i aria-hidden="true">›</i></span>
        </span>
        <span class="bd-next__vis" aria-hidden="true">
          <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
          <?= !empty($nxNext['img']) ? bd_img(array_merge($nxNext['img'], ['alt' => ''])) : bd_glyph($nxNext['slug']) ?>
        </span>
        <span class="bd-next__arrow" aria-hidden="true"><i></i><b>›</b></span>
      </a>
    </div>
  </div>
</section>
