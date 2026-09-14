<?php
/** The capabilities this one is most often bought with. Expects $BD and $cap. */
require_once __DIR__ . '/icons.php';
?>
<section class="band band--alt bd-pairs" aria-labelledby="pairs-t">
  <div class="wrap">
    <div class="head--row bd-pairs__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Pairs with</p>
        <h2 class="h2" id="pairs-t"><span class="g">Rarely alone.</span><br>Usually with these.</h2>
      </div>
      <p class="lead">Brand Design is one system. Each capability plugs into the next, and most engagements run two or three together.</p>
    </div>

    <div class="bd-pairs__grid" data-rv-s data-rv-step="90">
      <?php foreach ($cap['pairs'] as $slug): $p = $BD[$slug]; ?>
        <a class="bd-pairs__card" href="<?= xe_url('services/brand-design/' . $p['slug'] . '.php') ?>">
          <span class="bd-pairs__vis" aria-hidden="true">
            <?= bd_glyph($p['slug']) ?>
            <span class="bd-pairs__n num"><?= e($p['n']) ?></span>
          </span>
          <span class="bd-pairs__body">
            <span class="bd-pairs__k"><?= e($p['kicker']) ?></span>
            <span class="bd-pairs__t"><?= e($p['name']) ?></span>
            <span class="bd-pairs__d"><?= e($p['lead']) ?></span>
            <span class="bd-pairs__go">Explore <?= e($p['short']) ?> <i aria-hidden="true">›</i></span>
          </span>
        </a>
      <?php endforeach; ?>

      <a class="bd-pairs__card bd-pairs__card--all" href="<?= xe_url('services/brand-design.php') ?>">
        <span class="bd-pairs__vis" aria-hidden="true">
          <?= bd_glyph('hub') ?>
          <span class="bd-pairs__mark"><?= xe_svg('xe-mark') ?></span>
          <span class="bd-pairs__n num"><?= str_pad((string) count($BD), 2, '0', STR_PAD_LEFT) ?></span>
        </span>
        <span class="bd-pairs__body">
          <span class="bd-pairs__k">The discipline</span>
          <span class="bd-pairs__t">All of Brand Design</span>
          <span class="bd-pairs__d">Six capabilities, one system, one team accountable for the outcome.</span>
          <span class="bd-pairs__go">See the discipline <i aria-hidden="true">›</i></span>
        </span>
      </a>
    </div>
  </div>
</section>
