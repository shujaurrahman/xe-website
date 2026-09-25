<?php /* DRAFT COPY — review before launch */
/* How the work actually feels, week to week — the week we design for, drawn as a real calendar.
   The point of the section is the ratio: most of the grid is making, and the scheduled time is
   counted in the strip underneath from this same array, so the figure can never drift from the
   picture. PLACEHOLDER: confirm this week shape with the practice leads before launch.
   Locals prefixed wk_. */
$wk_kinds = [
    'make'   => ['Making',            'Heads-down work on the engagement. Nobody books over it.'],
    'review' => ['Review',            'Work on the wall, in front of people who will say what they think.'],
    'client' => ['Client',            'In the room with the people who have to live with what we ship.'],
    'craft'  => ['Craft & learning',  'Time that is yours: agents, reading, writing, teaching.'],
];
$wk_days = [
    ['Mon', 'Monday', [
        ['09:45', 25,  'review', 'Engagement open',        'What shipped, what is stuck, who needs a decision this week.'],
        ['10:15', 195, 'make',   'Making',                 'The long block. Your calendar is clear until lunch by default.'],
        ['14:00', 45,  'craft',  'Agent run review',       'Read the week\'s agent output and the cases it held back.'],
        ['15:00', 180, 'make',   'Making',                 'Second long block.'],
    ]],
    ['Tue', 'Tuesday', [
        ['10:00', 240, 'make',   'Making',                 'Four hours, uninterrupted.'],
        ['14:30', 60,  'client', 'Client working session', 'Not a status call. Work in progress, on screen, questions answered live.'],
        ['15:45', 135, 'make',   'Making',                 'Straight back into it while the session is still warm.'],
    ]],
    ['Wed', 'Wednesday', [
        ['10:00', 120, 'make',   'Making',                 ''],
        ['12:00', 60,  'review', 'Craft review',           'Your discipline, your peers, one piece of work each. Direct, and about the work.'],
        ['14:00', 150, 'make',   'Making',                 ''],
        ['16:30', 60,  'craft',  'Cross-discipline hour',  'You sit in another practice\'s review. Engineers in brand critiques, designers in model evaluations.'],
    ]],
    ['Thu', 'Thursday', [
        ['10:00', 270, 'make',   'Making',                 'The longest block of the week.'],
        ['15:00', 45,  'craft',  'Write it down',          'Decision log entries, notes and handover writing. Paid work, not homework.'],
        ['16:00', 120, 'make',   'Making',                 ''],
    ]],
    ['Fri', 'Friday', [
        ['10:00', 150, 'make',   'Making',                 ''],
        ['12:30', 45,  'review', 'Weekly review',          'Decisions, risks and what actually shipped. The log is read, not the loudest voice.'],
        ['14:00', 120, 'craft',  'Learning block',         'Yours. Courses, a side build, a paper, a talk you are writing.'],
        ['16:00', 60,  'client', 'Ship or hand over',      'Something leaves the building most Fridays, even if it is small.'],
    ]],
];
/* counted from the grid above, so the claim and the picture cannot disagree */
$wk_tot = $wk_sched = 0;
$wk_by  = array_fill_keys(array_keys($wk_kinds), 0);
foreach ($wk_days as $wk_d) foreach ($wk_d[2] as $wk_b) { $wk_tot += $wk_b[1]; $wk_by[$wk_b[2]] += $wk_b[1]; if ($wk_b[2] !== 'make') $wk_sched += $wk_b[1]; }
$wk_hrs = function (int $m): string { $h = intdiv($m, 60); $r = $m % 60; return $h . ' h' . ($r ? ' ' . $r . ' min' : ''); };
$wk_pct = fn (int $m): int => (int) round($m / max(1, $wk_tot) * 100);
?>
<section class="band band--ink car-week" id="week" aria-labelledby="week-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>A week here</p>
        <h2 class="h2" id="week-t"><span class="g">The week we design for,</span> with the meetings left in.</h2></div>
      <div><p class="lead">Most careers pages describe the culture. This is the calendar it comes from: where the long blocks are, who is allowed to book over them, and what the meetings are actually for.</p>
        <p class="car-week__cap">Block height follows duration, with a floor so that short blocks stay readable.</p></div>
    </div>

    <!-- PLACEHOLDER: confirm this week shape, and the meeting load below, with the practice leads before launch -->
    <div class="bdh-scroll-x mask-x car-week__scroll" tabindex="0" role="group" aria-label="A typical week, Monday to Friday — scroll sideways to see every day">
      <div class="car-week__grid">
        <?php foreach ($wk_days as $wk_i => $wk_d): ?>
        <div class="car-week__day" style="--i:<?= $wk_i ?>">
          <h3 class="car-week__dn"><abbr title="<?= e($wk_d[1]) ?>"><?= e($wk_d[0]) ?></abbr></h3>
          <ol class="car-week__blocks">
            <?php foreach ($wk_d[2] as $wk_b): ?>
            <li class="car-blk car-blk--<?= e($wk_b[2]) ?>" style="--min:<?= (int) $wk_b[1] ?>">
              <span class="car-blk__t"><?= e($wk_b[0]) ?></span>
              <b class="car-blk__l"><?= e($wk_b[3]) ?></b>
              <?php if ($wk_b[4] !== ''): ?><span class="car-blk__d"><?= e($wk_b[4]) ?></span><?php endif; ?>
              <span class="car-blk__m"><?= (int) $wk_b[1] ?> min</span>
            </li>
            <?php endforeach; ?>
          </ol>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="car-week__foot">
      <ul class="car-week__key">
        <?php foreach ($wk_kinds as $wk_k => $wk_kv): ?>
        <li class="car-key car-key--<?= e($wk_k) ?>">
          <span class="car-key__sw" aria-hidden="true"></span>
          <b class="car-key__t"><?= e($wk_kv[0]) ?></b>
          <span class="car-key__n"><?= $wk_pct($wk_by[$wk_k]) ?>% of the grid above</span>
          <span class="car-key__d"><?= e($wk_kv[1]) ?></span>
        </li>
        <?php endforeach; ?>
      </ul>
      <div class="car-week__note">
        <p class="car-week__k">The number that matters</p>
        <p class="car-week__big"><b><?= e($wk_hrs($wk_sched)) ?></b> of scheduled time, against <?= e($wk_hrs($wk_by['make'])) ?> of making.</p>
        <p class="car-week__p">Everything else is yours to plan. Two things protect that: nothing recurring may be booked over a making block without the practice lead agreeing, and anything that could have been written down is written down instead. When a week goes badly it is usually because we broke one of those two rules, and we say so at the Friday review.</p>
      </div>
    </div>
  </div>
</section>
