<?php
/**
 * The top of every inner page. Set before including:
 *   $hero = ['eyebrow' =>, 'title' =>, 'lead' =>, 'meta' => [] (optional)]
 */
$hero = $hero ?? [];
?>
<section class="phero" aria-labelledby="phero-t">
  <div class="phero__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="dither dither--wide phero__dither"></span>
  </div>
  <div class="wrap phero__in">
    <?php if (!empty($hero['eyebrow'])): ?>
      <p class="lbl lbl--blue"><span class="dot"></span><?= e($hero['eyebrow']) ?></p>
    <?php endif; ?>
    <h1 class="phero__h" id="phero-t"><?= $hero['title'] ?? '' ?></h1>
    <?php if (!empty($hero['lead'])): ?>
      <p class="lead phero__lead"><?= e($hero['lead']) ?></p>
    <?php endif; ?>
    <?php if (!empty($hero['meta'])): ?>
      <p class="phero__meta">
        <?php foreach ($hero['meta'] as $i => $m): ?>
          <?php if ($i) echo '<i aria-hidden="true">·</i>'; ?><span><?= e($m) ?></span>
        <?php endforeach; ?>
      </p>
    <?php endif; ?>
  </div>
</section>
