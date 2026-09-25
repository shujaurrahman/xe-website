<?php /* DRAFT COPY — review before launch */
/* How we hire — five stages, each with what it tests, who is in the room, how long it takes and how
   to prepare for it. The apply page's "what happens next" band quotes the same five, so if a stage
   changes here it has to change there too. PLACEHOLDER: every timing below is a target — confirm the
   stages, the formats and the work-sample fee with hiring before launch. Locals prefixed hr_. */
$hr_steps = [
    ['Apply',              'Day 0',              '10 minutes, on your own',
     'Whether the work you have made is close enough to this role to be worth both our time.',
     'A person in the practice, not a filter',
     'Send a CV and one link. Spend the time on the note, not the formatting.'],
    ['Intro call',         'Within 5 working days', '30 minutes, video',
     'Motivation, the shape of what you want next, and the practical things — money, notice, location — before either of us invests more.',
     'The hiring lead for the practice',
     'Have a number in mind. We will tell you the range for the role on this call, unprompted.'],
    ['Craft conversation', 'Week 2',             '60–75 minutes, video or in a studio',
     'Depth. One or two pieces of your own work, taken apart: what you chose, what you rejected, what you would do differently now.',
     'Two practitioners you would work with',
     'Pick work you can talk about honestly, including the parts that went wrong. Polish is not the point.'],
    ['Work sample',        'Week 2–3',           'About 3 hours, paid, or a review of existing work',
     'How you approach a real problem with real constraints — and how you explain the approach afterwards.',
     'Set by the practice, reviewed by two people',
     'If a paid exercise does not work for you, bring existing work instead. That route is not a worse route.'],
    ['Team and offer',     'Week 3–4',           '45 minutes, then a written offer',
     'Whether you want to work with these people, which is a question for you more than for us.',
     'The people you would sit with, and a founder at offer',
     'Ask them the hard questions. Nobody in that room is scored on how well they sell the company.'],
];
/* PLACEHOLDER: confirm each of these commitments with hiring before launch */
$hr_never = [
    ['Unpaid spec work',            'A work sample is paid at a fair hourly rate, or replaced with work you already own.'],
    ['Surprise extra rounds',       'Five stages. If we ever need a sixth, we say why and you can decline it.'],
    ['Silence',                     'You hear something after every stage, including when the answer is no, and the no has a reason in it.'],
    ['Exploding offers',            'An offer has a sensible deadline and we will extend it if you ask for a reasonable one.'],
];
?>
<section class="band car-hire" id="hiring" aria-labelledby="hiring-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>How we hire</p>
        <h2 class="h2" id="hiring-t"><span class="g">Five stages,</span> about four weeks, published in advance.</h2></div>
      <div><p class="lead">Every stage below says what it is testing, so you can prepare for the actual question rather than guessing. Timings are targets we work to. When one slips, we tell you rather than going quiet.</p></div>
    </div>

    <!-- PLACEHOLDER: the timings, formats and the paid work-sample rate are targets — confirm with hiring before launch -->
    <ol class="car-hire__steps" data-rv-s data-rv-step="70">
      <?php foreach ($hr_steps as $hr_n => $hr_s): ?>
      <li class="car-step">
        <p class="car-step__top"><span class="car-step__n"><?= $hr_n + 1 ?></span><span class="car-step__when"><?= e($hr_s[1]) ?></span></p>
        <h3 class="car-step__t"><?= e($hr_s[0]) ?></h3>
        <p class="car-step__fmt"><?= xt_icon('clock', ['size' => 15]) ?><span><?= e($hr_s[2]) ?></span></p>
        <p class="car-step__look"><span>What it tests</span><?= e($hr_s[3]) ?></p>
        <p class="car-step__who"><span>Who you meet</span><?= e($hr_s[4]) ?></p>
        <p class="car-step__prep"><span>How to prepare</span><?= e($hr_s[5]) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>

    <div class="car-hire__never">
      <div class="car-hire__nk">
        <p class="car-hire__k">What we will not do</p>
        <p class="car-hire__np">Four commitments that cost us candidates when we break them, which is the only reason a commitment means anything.</p>
      </div>
      <ul class="car-never">
        <?php foreach ($hr_never as $hr_x): ?>
        <li><span class="car-never__x" aria-hidden="true"></span><b><?= e($hr_x[0]) ?></b><span><?= e($hr_x[1]) ?></span></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
