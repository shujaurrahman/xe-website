<?php /* DRAFT COPY — review before launch */
/* PLACEHOLDER: the typical timeline (days per step, total) is a target — confirm with hiring before launch. */
$car_steps = [
  ['Apply', 'Day 0', 'Send your details and a link to your work. A person reads every application.', 'Relevance of your work to the role'],
  ['Intro call', 'Within 5 working days', 'Thirty minutes with the hiring lead about the role, the team and what you want next.', 'Motivation, fit, logistics'],
  ['Craft conversation', 'Week 2', 'A deep dive into one or two pieces of your own work with two practitioners.', 'Reasoning, trade-offs, depth'],
  ['Work sample', 'Week 2–3', 'A short, paid exercise or a review of existing work. Never unpaid spec work.', 'How you approach a real problem'],
  ['Team conversation', 'Week 3', 'Meet the people you would work with, and ask them anything.', 'Collaboration, communication'],
  ['Offer', 'Week 3–4', 'A written offer with the full package and a start date that suits you.', 'Your questions answered first'],
];
?>
<section class="band car-hire" id="hiring" aria-labelledby="hiring-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How we hire</p>
        <h2 class="h2" id="hiring-t"><span class="g">Six steps,</span> about four weeks.</h2></div>
      <div><p class="lead">Typical timeline, from application to offer. We tell you where you stand after every step, including when the answer is no.</p></div>
    </div>
    <ol class="car-hire__steps">
      <?php foreach ($car_steps as $car_n => $car_s): ?>
      <li class="car-step">
        <p class="car-step__top"><span class="car-step__n"><?= $car_n + 1 ?></span><span class="car-step__when"><?= e($car_s[1]) ?></span></p>
        <h3 class="car-step__t"><?= e($car_s[0]) ?></h3>
        <p class="car-step__p"><?= e($car_s[2]) ?></p>
        <p class="car-step__look"><span>We look at</span><?= e($car_s[3]) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
