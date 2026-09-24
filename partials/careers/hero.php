<?php /* DRAFT COPY — review before launch */
$car_by = [];
foreach ($car_roles as $car_r) $car_by[$car_r['dept']] = ($car_by[$car_r['dept']] ?? 0) + 1;
arsort($car_by);
?>
<section class="band car-hero" id="top" aria-labelledby="car-hero-t">
  <div class="wrap car-hero__grid">
    <div class="car-hero__copy">
      <p class="lbl lbl--blue"><span class="dot"></span>Careers at Xterra Edze</p>
      <h1 class="d1" id="car-hero-t"><span class="g">Do the best work of your career</span> for brands the world knows.</h1>
      <!-- PLACEHOLDER: confirm the description of our client base (global enterprise brands) before launch -->
      <p class="lead">We are an independent creative and technology company in India, building brands, products and AI systems for global enterprise clients. Six disciplines, one team, and an operating model where agents do the repeatable work so people can do the part that needs judgement.</p>
      <div class="car-hero__cta">
        <a class="btn btn--ink btn--lg" href="#roles">See open roles <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#apply">Send a general application <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
    <aside class="car-board" aria-labelledby="car-board-t">
      <div class="car-board__top">
        <p class="car-board__k" id="car-board-t">Open roles by team</p>
        <p class="car-board__n"><b><?= count($car_roles) ?></b> listed</p>
      </div>
      <ul class="car-board__list">
        <?php foreach ($car_by as $car_dn => $car_cnt): ?>
        <li><a href="<?= e(xe_url('careers.php') . '?dept=' . rawurlencode($car_dn) . '#roles') ?>"><span><?= e($car_dn) ?></span><b><?= $car_cnt ?></b></a></li>
        <?php endforeach; ?>
      </ul>
      <p class="car-board__foot"><?= xt_icon('pin') ?> New Delhi · Ludhiana · Remote in India</p>
      <!-- PLACEHOLDER: openings are illustrative until confirmed by hiring before launch -->
      <p class="car-board__note">Openings shown are to be confirmed. Updated <?= e($car_data['updated']) ?>.</p>
    </aside>
  </div>
</section>
