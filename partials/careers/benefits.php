<?php /* DRAFT COPY — review before launch */
/* PLACEHOLDER: every benefit below is a draft — confirm the actual package with HR before launch. */
$car_ben = [
  ['shield', 'Health cover', 'Medical insurance for you and your family.'],
  ['calendar', 'Time off', 'Paid leave, public holidays and a winter break.'],
  ['lightbulb', 'Learning budget', 'An annual budget for courses, books and conferences.'],
  ['sparkle', 'AI tooling', 'Paid access to the models and tools you use at work.'],
  ['browser', 'Home setup', 'A laptop of your choice and a home-office allowance.'],
  ['users', 'Parental leave', 'Paid leave for every new parent.'],
  ['trend-up', 'Growth reviews', 'Twice-yearly reviews against a published career framework.'],
  ['handshake', 'Team weeks', 'The whole company together, in person, twice a year.'],
];
?>
<section class="band band--ink car-ben" id="benefits" aria-labelledby="benefits-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Benefits</p>
        <h2 class="h2" id="benefits-t"><span class="g">Looked after,</span> so you can do the work.</h2></div>
      <div><p class="p">A draft of the package we intend to offer. Final benefits are confirmed in every offer letter.</p></div>
    </div>
    <!-- PLACEHOLDER: confirm benefits before launch -->
    <ul class="car-ben__grid">
      <?php foreach ($car_ben as $car_b): ?>
      <li class="car-ben__i"><?= xt_icon($car_b[0]) ?><h3 class="car-ben__t"><?= e($car_b[1]) ?></h3><p class="car-ben__p"><?= e($car_b[2]) ?></p></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
