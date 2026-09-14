<?php
/**
 * The hero of a capability page. Expects $cap, $BD and $mockHtml — the page's
 * own stage, already rendered with output buffering, so each page keeps a
 * bespoke mock while the text column stays identical across all six.
 */
require_once __DIR__ . '/icons.php';
$phTotal = isset($BD) ? count($BD) : 6;
$phAt    = (int) $cap['n'];
?>
<section class="bd-phero" aria-labelledby="phero-t">
  <div class="bd-phero__bg" aria-hidden="true">
    <span class="aurora aurora--soft"><i></i><i></i><i></i><i></i></span>
    <span class="dither dither--wide bd-phero__dither"></span>
    <span class="bd-phero__grid"></span>
  </div>
  <div class="wrap bd-phero__in">
    <div class="bd-phero__text" data-rv>
      <nav class="bd-crumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="<?= xe_url('services/') ?>">Services</a></li>
          <li><a href="<?= xe_url('services/brand-design.php') ?>">Brand Design</a></li>
          <li><span aria-current="page"><?= e($cap['name']) ?></span></li>
        </ol>
      </nav>
      <p class="lbl lbl--blue bd-phero__eyebrow">
        <span class="bd-phero__ticks" aria-hidden="true"><?php for ($t = 1; $t <= $phTotal; $t++): ?><i<?= $t === $phAt ? ' class="is-on"' : '' ?>></i><?php endfor; ?></span>
        <span class="num"><?= e($cap['n']) ?></span><span class="bd-phero__of">/ <?= str_pad((string) $phTotal, 2, '0', STR_PAD_LEFT) ?></span>
        <span class="bd-phero__k"><?= e($cap['kicker']) ?></span>
      </p>
      <h1 class="bd-phero__h" id="phero-t"><?= $cap['title'] ?></h1>
      <p class="lead bd-phero__lead"><?= e($cap['lead']) ?></p>
      <div class="bd-phero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($cap['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#offer">What we offer <span class="i" aria-hidden="true">›</span></a>
      </div>
      <!-- PLACEHOLDER: typical timeframe — confirm before launch -->
      <ul class="bd-phero__meta">
        <?php foreach ($cap['meta'] as $i => $m): ?>
          <li class="bd-phero__mi">
            <?= bd_icon($i === 0 ? 'clock' : 'tick') ?>
            <?php if ($i === 0): ?><span class="bd-phero__mk">Typical</span><?php endif; ?>
            <span><?= e($m) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="bd-phero__stage" data-rv data-rv-d="140">
      <span class="bd-phero__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
      <div class="bd-phero__float" data-bd-tilt>
        <?= $mockHtml ?>
      </div>
    </div>
  </div>
</section>
