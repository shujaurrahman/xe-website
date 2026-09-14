<?php
/**
 * The capability switcher that sits under every Brand Design hero. It sticks
 * below the floating nav once it reaches it, and keeps the current capability
 * scrolled into view. Expects $BD (all six) and $cap (the current one, or null on the hub).
 */
$cur   = $cap['slug'] ?? '';
$keys  = array_keys($BD);
$total = count($keys);
$at    = $cur !== '' ? array_search($cur, $keys, true) : false;
?>
<nav class="bd-rail" aria-label="Brand Design capabilities" data-bd-railbar>
  <div class="wrap bd-rail__in">
    <a class="bd-rail__hub<?= $cur === '' ? ' is-here' : '' ?>" href="<?= xe_url('services/brand-design.php') ?>"<?= $cur === '' ? ' aria-current="page"' : '' ?>>
      <span class="bd-rail__mark" aria-hidden="true"><?= xe_svg('xe-mark') ?></span><span class="bd-rail__hubt">Brand Design</span>
    </a>
    <div class="bd-rail__scroll" data-bd-rail>
      <ol class="bd-rail__list">
        <?php foreach ($BD as $c): $here = $c['slug'] === $cur; ?>
          <li>
            <a class="bd-rail__i<?= $here ? ' is-here' : '' ?>" href="<?= xe_url('services/brand-design/' . $c['slug'] . '.php') ?>"<?= $here ? ' aria-current="page"' : '' ?>>
              <span class="bd-rail__n num"><?= e($c['n']) ?></span><span class="bd-rail__t"><?= e($c['name']) ?></span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
    <span class="bd-rail__pos num" aria-hidden="true"><b><?= $at === false ? '00' : str_pad((string) ($at + 1), 2, '0', STR_PAD_LEFT) ?></b> / <?= str_pad((string) $total, 2, '0', STR_PAD_LEFT) ?></span>
    <span class="bd-rail__prog" aria-hidden="true"><i></i></span>
  </div>
</nav>
