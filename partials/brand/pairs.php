<?php
/**
 * The capabilities this one is most often bought with — photograph cards —
 * plus the way back to the whole discipline.
 *
 *   $BD         required  all six capabilities
 *   $cap        required  pairs => [slug, slug]; each paired capability's 'img' is its card photo
 *   $pairsLead  optional  lead text
 */
require_once __DIR__ . '/icons.php';
$paLead = $pairsLead ?? 'Brand Design is one system. Each capability plugs into the next, and most engagements run two or three together.';
?>
<section class="band band--alt bd-pairs" aria-labelledby="pairs-t" data-bd-live>
  <div class="wrap">
    <div class="head--row bd-pairs__head" data-rv>
      <div class="bd-pairs__hl">
        <p class="lbl lbl--blue"><span class="dot"></span>Pairs with</p>
        <h2 class="h2" id="pairs-t"><span class="g">Rarely alone.</span> Usually with these.</h2>
      </div>
      <p class="lead"><?= e($paLead) ?></p>
    </div>

    <!-- PLACEHOLDER: card photographs are reference imagery (Unsplash) — confirm before launch -->
    <div class="bd-pairs__grid" data-rv-s data-rv-step="90">
      <?php foreach ($cap['pairs'] as $slug): if (empty($BD[$slug])) { continue; } $p = $BD[$slug]; ?>
        <article class="bd-pairs__card">
          <div class="bd-pairs__vis">
            <?= !empty($p['img']) ? bd_img($p['img']) : bd_glyph($p['slug']) ?>
            <span class="bd-pairs__n num" aria-hidden="true"><?= e($p['n']) ?></span>
          </div>
          <div class="bd-pairs__body">
            <p class="bd-pairs__k"><?= e($p['kicker']) ?></p>
            <h3 class="bd-pairs__t"><a class="bd-pairs__a" href="<?= xe_url('services/brand-design/' . $p['slug'] . '.php') ?>"><?= e($p['name']) ?></a></h3>
            <p class="bd-pairs__d"><?= e($p['lead']) ?></p>
            <span class="bd-pairs__go" aria-hidden="true">Explore <?= e($p['short']) ?> <i>›</i></span>
          </div>
        </article>
      <?php endforeach; ?>

      <article class="bd-pairs__card bd-pairs__card--all">
        <div class="bd-pairs__vis">
          <span class="bd-pairs__dots dots-ink" aria-hidden="true"></span>
          <?= bd_glyph('hub') ?>
          <span class="bd-pairs__n num" aria-hidden="true">All <?= str_pad((string) count($BD), 2, '0', STR_PAD_LEFT) ?></span>
        </div>
        <div class="bd-pairs__body">
          <p class="bd-pairs__k">The discipline</p>
          <h3 class="bd-pairs__t"><a class="bd-pairs__a" href="<?= xe_url('services/brand-design.php') ?>">All of Brand Design</a></h3>
          <p class="bd-pairs__d">Six capabilities, one system, one team accountable for the outcome.</p>
          <span class="bd-pairs__go" aria-hidden="true">See the discipline <i>›</i></span>
        </div>
      </article>
    </div>
  </div>
</section>
