<?php /* DRAFT COPY — review before launch */
$car_norms = [
  ['users', 'Hybrid by team', 'Teams agree their office days together. Client workshops are in person when it helps.'],
  ['clock', 'Core overlap hours', 'A shared window for collaboration; the rest of the day is yours to plan.'],
  ['agent', 'AI tools provided', 'Licensed models and agent tooling, with clear rules on client data.'],
  ['doc', 'Written first', 'Briefs, decisions and reviews are written down, so remote never means out of the loop.'],
];
?>
<section class="band car-work" id="how-we-work" aria-labelledby="work-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How and where we work</p>
        <h2 class="h2" id="work-t"><span class="g">Offices in New Delhi and Ludhiana,</span> and the rest of India.</h2></div>
      <div><p class="lead">Work from our offices in New Delhi or Ludhiana, or remotely from anywhere in India for roles marked remote.</p></div>
    </div>
    <div class="car-work__places">
      <?php foreach ($SITE['company']['studios'] as $car_st): ?>
      <article class="car-place">
        <p class="car-place__k"><?= xt_icon('pin') ?> Studio</p>
        <h3 class="car-place__t"><?= e($car_st['city']) ?></h3>
        <?php if ($car_st['city'] === 'New Delhi'): ?><!-- PLACEHOLDER: the New Delhi address is carried over from the previous site — confirm before launch --><?php endif; ?>
        <address class="car-place__a"><?php if ($car_st['units']): ?><?= e(implode(' · ', $car_st['units'])) ?><br><?php endif; ?><?= implode('<br>', array_map('e', $car_st['lines'])) ?></address>
      </article>
      <?php endforeach; ?>
      <article class="car-place car-place--remote">
        <p class="car-place__k"><?= xt_icon('globe') ?> Remote</p>
        <h3 class="car-place__t">Anywhere in India</h3>
        <p class="car-place__a">For roles marked Remote (India). Occasional travel to an office or client for workshops and team weeks.</p>
      </article>
    </div>
    <ul class="car-work__norms">
      <?php foreach ($car_norms as $car_nm): ?>
      <li><?= xt_icon($car_nm[0]) ?><div><h3 class="car-norm__t"><?= e($car_nm[1]) ?></h3><p><?= e($car_nm[2]) ?></p></div></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
