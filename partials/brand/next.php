<?php
/** The way onward: the next capability, and the previous one. Expects $BD and $cap. */
require_once __DIR__ . '/icons.php';
$keys  = array_keys($BD);
$cnt   = count($keys);
$k     = array_search($cap['slug'], $keys, true);
$next  = $BD[$keys[($k + 1) % $cnt]];
$prev  = $BD[$keys[($k - 1 + $cnt) % $cnt]];
?>
<section class="bd-next" aria-labelledby="next-t">
  <div class="wrap">
    <div class="bd-next__bar" data-rv>
      <h2 class="lbl" id="next-t">Keep going</h2>
      <span class="bd-next__dots" aria-hidden="true">
        <?php foreach ($keys as $j => $key): ?><i class="<?= $j === $k ? 'is-here' : ($key === $next['slug'] ? 'is-next' : '') ?>"></i><?php endforeach; ?>
      </span>
      <span class="bd-next__pos num" aria-hidden="true"><?= e($cap['n']) ?> / <?= str_pad((string) $cnt, 2, '0', STR_PAD_LEFT) ?></span>
    </div>
    <div class="bd-next__in" data-rv data-rv-d="80">
      <a class="bd-next__prev" href="<?= xe_url('services/brand-design/' . $prev['slug'] . '.php') ?>">
        <span class="bd-next__parrow" aria-hidden="true">‹</span>
        <span class="bd-next__lbl">Previous · <?= e($prev['n']) ?></span>
        <span class="bd-next__pt"><?= e($prev['name']) ?></span>
        <span class="bd-next__pk"><?= e($prev['kicker']) ?></span>
      </a>
      <a class="bd-next__go" href="<?= xe_url('services/brand-design/' . $next['slug'] . '.php') ?>">
        <span class="bd-next__txt">
          <span class="bd-next__lbl">Next · <?= e($next['n']) ?> · <?= e($next['kicker']) ?></span>
          <span class="bd-next__t"><?= e($next['name']) ?></span>
          <span class="bd-next__d"><?= e($next['lead']) ?></span>
        </span>
        <span class="bd-next__vis" aria-hidden="true"><?= bd_glyph($next['slug']) ?></span>
        <span class="bd-next__arrow" aria-hidden="true"><i></i><b>›</b></span>
      </a>
    </div>
  </div>
</section>
