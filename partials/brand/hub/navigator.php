<?php
/* Capability navigator — one clean index of the six capabilities (names and one-liners from
   data/site.php), plus a desktop dock that appears while the reader is inside #capabilities. */
?>
<section class="bdh-nav" id="navigator" aria-label="Brand Design capabilities">
  <div class="wrap">
    <p class="bdh-nav__cap"><span><?= count($BRAND['caps']) ?> capabilities · one system</span><span>Jump to a capability</span></p>
    <nav aria-label="Capabilities on this page">
      <ol class="bdh-nav__list" data-rv-s data-rv-step="60">
        <?php foreach ($BRAND['caps'] as $nav_i => $nav_cap): ?>
          <li>
            <a class="bdh-nav__a" href="#cap-<?= e($nav_cap[2]) ?>">
              <span class="bdh-nav__n"><?= str_pad((string) ($nav_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="bdh-nav__t"><?= e($nav_cap[0]) ?></span>
              <span class="bdh-nav__d"><?= e($nav_cap[1]) ?></span>
              <span class="bdh-nav__go" aria-hidden="true">›</span>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </div>
</section>

<nav class="bdh-dock" aria-label="Capability quick links" inert>
  <div class="bdh-dock__in">
    <?php foreach ($BRAND['caps'] as $nav_i => $nav_cap): ?>
      <a class="bdh-dock__a" href="#cap-<?= e($nav_cap[2]) ?>" data-dock="<?= e($nav_cap[2]) ?>">
        <b><?= str_pad((string) ($nav_i + 1), 2, '0', STR_PAD_LEFT) ?></b><?= e($BD[$nav_cap[2]]['short'] ?? $nav_cap[0]) ?>
      </a>
    <?php endforeach; ?>
    <span class="bdh-dock__bar" aria-hidden="true"><i></i></span>
  </div>
</nav>
