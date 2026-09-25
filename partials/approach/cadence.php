<?php /* DRAFT COPY — review before launch */
/* Cadence — how we communicate week to week, which is the question every prospect actually asks and
   almost no agency answers. Five days, each with what arrives, who it comes from and whether it needs
   the client's time. Then the channels, the commitments and the escalation path.
   Response times are typical, not contractual; the numbers agreed for a specific engagement live in its
   statement of work. */
// PLACEHOLDER: confirm response times, meeting lengths and the escalation path before launch
$aprc_week = [
    ['Mon', 'The week, posted',      'The sprint goal, what is in the week, and anything we need from you, in the shared channel by the start of your day.', 'Read it', 'doc'],
    ['Tue', 'Heads down',            'No meeting. Questions go to the channel and are answered the same working day.',                                        'Nothing', 'code'],
    ['Wed', 'Demo, recorded',        'A short recording of what is working, on a preview environment you can open yourself.',                                 'Watch when you like', 'browser'],
    ['Thu', 'Review, 45 minutes',    'One call. Decisions, trade-offs and what changes. Not a status read-out, because you already have the status.',          '45 minutes', 'users'],
    ['Fri', 'The written report',    'What shipped, what slipped and why, what is blocked, what needs a decision from you, and next week\'s goal.',           'Read it', 'chart'],
];
$aprc_commit = [
    ['First reply',        'Within one working day, from someone who can answer'],
    ['A blocker',          'Raised the day it appears, not saved for the review'],
    ['Bad news',           'Told early, in writing, with what we propose to do'],
    ['Your time',          'One 45-minute call a week during Build; more only if you want it'],
    ['One named lead',     'The same person for the whole engagement, with a named deputy'],
    ['Escalation',         'Discipline lead, then engagement director, then the founders'],
];
$aprc_never = [
    'Chase us for a status update',
    'Sit through a deck to find out what happened',
    'Wait for the weekly call to raise a problem',
    'Ask which of us owns a decision',
];
?>
<section class="band apr-cadence" id="cadence" aria-labelledby="cadence-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Week to week</p>
        <h2 class="h2" id="cadence-t"><span class="g">One call a week.</span> Everything else in writing.</h2>
      </div>
      <div>
        <p class="lead">Most of the frustration in agency work is not the work, it is not knowing where it
          is. So the week has a shape, it is the same every week, and you can see what happened without
          asking anyone.</p>
      </div>
    </div>

    <ol class="apr-cad__week" data-rv-s data-rv-step="60">
      <?php foreach ($aprc_week as $aprc_d): ?>
        <li class="apr-cad__day">
          <p class="apr-cad__dh">
            <span class="apr-cad__dn"><?= e($aprc_d[0]) ?></span>
            <span class="apr-ico" aria-hidden="true"><?= xt_icon($aprc_d[4], ['size' => 18]) ?></span>
          </p>
          <h3 class="bdh-t bdh-t--s"><?= e($aprc_d[1]) ?></h3>
          <p class="bdh-d"><?= e($aprc_d[2]) ?></p>
          <p class="apr-cad__cost"><span class="apr-k">Your time</span><span><?= e($aprc_d[3]) ?></span></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="apr-cad__below">
      <div class="apr-cad__commit" data-rv data-rv-d="80">
        <p class="apr-k">What we commit to</p>
        <!-- PLACEHOLDER: confirm response times and the escalation path before launch -->
        <dl class="apr-defs apr-cad__cd">
          <?php foreach ($aprc_commit as $aprc_c): ?>
            <div><dt><?= e($aprc_c[0]) ?></dt><dd><?= e($aprc_c[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="apr-note">Typical for our engagements. The response times and service levels for yours
          are written into its statement of work, where they are enforceable.</p>
      </div>

      <div class="apr-cad__never" data-rv data-rv-d="120">
        <p class="apr-k">What you never have to do</p>
        <ul>
          <?php foreach ($aprc_never as $aprc_n): ?>
            <li><span class="apr-never"><?= e($aprc_n) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <p class="apr-cad__say">If you have to ask where something is, the cadence has failed and we want
          to hear about it.</p>
      </div>
    </div>
  </div>
</section>
