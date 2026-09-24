<?php /* DRAFT COPY — review before launch */
$car_why = [
  ['Work that ships at scale', 'Your design system, your agent, your campaign goes live across markets, not into a pitch folder.'],
  ['AI as your tooling, not your replacement', 'Agents take the repetitive work: drafts, checks, variants, monitoring. You keep the decisions and the craft.'],
  ['Six disciplines in one room', 'Strategists, designers, engineers and marketers on the same team, the same backlog, the same weekly review.'],
  ['Seniority without the politics', 'Small teams, named owners, a decision log. Your reasoning is written down and credited.'],
];
?>
<section class="band band--alt car-why" id="why" aria-labelledby="why-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Why join</p>
        <h2 class="h2" id="why-t"><span class="g">The opportunity,</span> plainly.</h2></div>
      <div><p class="lead">Enterprise-grade problems, a studio-sized team, and a way of working that was designed for the tools you will actually use for the next decade.</p></div>
    </div>
    <ol class="car-why__list">
      <?php foreach ($car_why as $car_n => $car_w): ?>
      <li class="car-why__i"><span class="car-why__n">0<?= $car_n + 1 ?></span><h3 class="car-why__t"><?= e($car_w[0]) ?></h3><p class="car-why__p"><?= e($car_w[1]) ?></p></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
