<?php /* DRAFT COPY — review before launch */
/* How hiring runs — five stages, all of them on the page at once. Deliberately not a tab set: a
   candidate wants to read the whole process in one pass, and a stepper with every stage expanded
   cannot render blank without JavaScript. The rail behind the numbers is drawn with .bdh-draw when
   the section enters, which resolves to the finished line under reduced motion and with JS off.
   Every duration is written as a target. Locals prefixed hire_. */

/* PLACEHOLDER: confirm the stages, the people in each and every turnaround target before launch */
$hire_stages = [
    [
        'k'    => 'You apply',
        'who'  => 'One form, five minutes',
        'time' => 'Reply within 5 working days',
        'p'    => 'The application form on this site, or an email if you would rather. A named person in the practice you applied to reads it — not a keyword filter and not an agency.',
        'out'  => 'A yes, a no, or a question. Always one of the three, always in writing.',
    ],
    [
        'k'    => 'A first conversation',
        'who'  => 'You and the practice lead',
        'time' => '30 minutes, video',
        'p'    => 'Your work, our work, and whether the role is what you think it is. We will tell you the pay range for the role in this call rather than making you ask.',
        'out'  => 'You should be able to describe the job accurately to a friend afterwards.',
    ],
    [
        'k'    => 'Craft conversation',
        'who'  => 'You and two future colleagues',
        'time' => '60–75 minutes',
        'p'    => 'Deep on one thing you have made: the constraints, the decisions, what you would change. For engineering roles, real code — yours or ours — read together. No whiteboard algorithms.',
        'out'  => 'A clear read on how you think, from people whose work sits next to yours.',
    ],
    [
        'k'    => 'A paid exercise',
        'who'  => 'Your own time, capped at a day',
        'time' => 'Only if we need it · paid',
        'p'    => 'We skip this whenever your existing work already answers the question. When we cannot, the brief is invented rather than taken from a live client, it is capped at one day, and it is paid. We never use exercise output in client work.',
        'out'  => 'A shared artefact to talk through, and a day\'s fee either way.',
    ],
    [
        'k'    => 'Decision and offer',
        'who'  => 'Practice lead and a founder',
        'time' => 'Decision within 3 working days',
        'p'    => 'A call first, then the written offer with the number, the level, the location and the start date. Two references after you accept, with your permission, never before.',
        'out'  => 'A written offer, or a written no with the actual reason.',
    ],
];

$hire_never = [
    'Unpaid spec work, on any role, at any level.',
    'An exercise built from a live client brief.',
    'A panel you were not told about in advance.',
    'Ghosting. If you have heard nothing and the target has passed, write to us and we will answer.',
    'Salary history as a basis for an offer. The number comes from the role and the level.',
];
?>
<section class="band band--alt car-hire" id="hiring" aria-labelledby="hiring-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How hiring runs</p>
        <h2 class="h2" id="hiring-t"><span class="g">Five stages,</span> and what each one is for.</h2>
      </div>
      <div>
        <!-- PLACEHOLDER: confirm the end-to-end target and every stage turnaround before launch -->
        <p class="lead">Our target is two to three weeks from application to decision, and the fourth stage is skipped more often than it is used. Every time below is a target we work to, not a promise, and calendars are the usual reason one slips.</p>
        <p class="car-note">If a target passes without you hearing from us, that is our mistake. Write to <a href="mailto:<?= e($SITE['company']['email']) ?>"><?= e($SITE['company']['email']) ?></a> and we will answer the same week.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm the five stages, who sits in each, the paid-exercise day rate and every
         turnaround target below before launch -->
    <ol class="car-hire__steps" data-rv-s data-rv-step="80">
      <?php foreach ($hire_stages as $hire_i => $hire_s): ?>
        <li class="car-hire__step">
          <span class="car-hire__rail" aria-hidden="true"></span>
          <span class="car-hire__n" aria-hidden="true"><?= str_pad((string) ($hire_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <div class="car-hire__b">
            <h3 class="bdh-t bdh-t--l car-hire__t"><?= e($hire_s['k']) ?></h3>
            <p class="car-hire__meta"><span class="bdh-tag"><?= e($hire_s['who']) ?></span><span class="bdh-tag bdh-tag--blue"><?= e($hire_s['time']) ?></span></p>
            <p class="bdh-d car-hire__d"><?= e($hire_s['p']) ?></p>
            <p class="car-hire__out"><span class="car-k">You leave with</span><?= e($hire_s['out']) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <!-- PLACEHOLDER: confirm that each of these commitments is one the company will stand behind -->
    <div class="car-hire__never" data-rv data-rv-d="90">
      <div>
        <p class="car-k car-k--warn">What we will never do</p>
        <ul class="bdh-bullets">
          <?php foreach ($hire_never as $hire_x): ?><li><?= e($hire_x) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <div class="car-hire__access">
        <p class="car-k car-k--blue">Adjustments</p>
        <p class="bdh-d">Tell us what you need and we will arrange it — extra time, written questions ahead of a call, captions, a different format, a call outside working hours. Asking never counts against you, and you do not have to explain why.</p>
        <a class="btn btn--out" href="<?= e(car_apply_url()) ?>">Start an application <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
