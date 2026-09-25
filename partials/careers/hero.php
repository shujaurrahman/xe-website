<?php /* DRAFT COPY — review before launch */
/* Careers hero. Copy and the two calls on the left; the live board of open roles by team on the
   right, every row a filter link into #roles. Below both, a four-fact strip that answers the
   questions a candidate asks before reading anything else. Locals prefixed car_. */
$car_locs = [];
foreach ($car_roles as $car_r) $car_locs[$car_r['loc']] = ($car_locs[$car_r['loc']] ?? 0) + 1;
$car_types = [];
foreach ($car_roles as $car_r) $car_types[$car_r['type']] = true;
/* PLACEHOLDER: confirm the reply target and the number of hiring stages with hiring before launch */
$car_facts = [
    ['pin',    'Where',       'New Delhi · Ludhiana · Remote in India', count($car_locs) . ' locations across ' . count($car_roles) . ' listings'],
    ['users',  'Who you join', 'Six disciplines and delivery',          'One team, not six agencies under one roof'],
    ['clock',  'How long',    'Five stages, about four weeks',          'Target, not a promise — calendars slip and we say so'],
    ['doc',    'What to send', 'A CV and one link',                     'Ten honest minutes beats a polished template'],
];
?>
<section class="band car-hero" id="top" aria-labelledby="car-hero-t">
  <div class="wrap">
    <div class="car-hero__grid">
      <div class="car-hero__copy">
        <p class="lbl lbl--blue"><span class="dot"></span>Careers at Xterra Edze</p>
        <h1 class="d1" id="car-hero-t"><span class="g">Do the best work of your career</span> with people who will tell you the truth about it.</h1>
        <!-- PLACEHOLDER: confirm the description of our client base (global enterprise brands) before launch -->
        <p class="lead">We are an independent creative and technology company in India, building brands, products and AI systems for global enterprise clients. Six disciplines, one team, and an operating model where agents do the repeatable work so people can do the part that needs judgement.</p>
        <div class="car-hero__cta">
          <a class="btn btn--ink btn--lg" href="#roles">See <?= count($car_roles) ?> open roles <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="<?= e(xe_url('careers/apply.php')) ?>">Send a general application <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>

      <aside class="car-board" aria-labelledby="car-board-t">
        <div class="car-board__top">
          <p class="car-board__k" id="car-board-t">Open roles by team</p>
          <p class="car-board__n"><b><?= count($car_roles) ?></b> listed</p>
        </div>
        <ul class="car-board__list">
          <?php foreach ($car_by_dept as $car_dn => $car_cnt): ?>
          <li><a href="<?= e(xe_url('careers.php') . '?dept=' . rawurlencode($car_dn) . '#roles') ?>"><span><?= e($car_dn) ?></span><b><?= $car_cnt ?></b></a></li>
          <?php endforeach; ?>
        </ul>
        <p class="car-board__foot"><?= xt_icon('pin') ?> <?= e(implode(' · ', array_keys($car_locs))) ?></p>
        <!-- PLACEHOLDER: openings are illustrative until confirmed by hiring before launch -->
        <p class="car-board__note">Openings shown are to be confirmed. Updated <?= e($car_data['updated']) ?>.</p>
      </aside>
    </div>

    <ul class="car-hero__facts" data-rv-s data-rv-step="60">
      <?php foreach ($car_facts as $car_f): ?>
      <li class="car-fact">
        <span class="car-fact__ico" aria-hidden="true"><?= xt_icon($car_f[0], ['size' => 18]) ?></span>
        <span class="car-fact__k"><?= e($car_f[1]) ?></span>
        <b class="car-fact__v"><?= e($car_f[2]) ?></b>
        <span class="car-fact__d"><?= e($car_f[3]) ?></span>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
