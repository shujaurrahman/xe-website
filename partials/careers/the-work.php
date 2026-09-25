<?php /* DRAFT COPY — review before launch */
/* The work, honestly — the shape of a week on the left of the photograph, and a blunt "what this job
   is not" list under it. The rituals are the honest part: they are what actually takes your hours.
   The photograph is stock and is captioned as stock; see assets/imgs/careers/CREDITS.md.
   Locals prefixed wk_. */

/* PLACEHOLDER: confirm the rituals and their cadence with the practice leads before launch */
$wk_week = [
    ['Mon', 'One plan for the week',   'Every engagement re-plans in public: what shipped, what slipped, what changes. Fifteen minutes per engagement, written down before the call.'],
    ['Daily', 'Fifteen minutes, standing', 'Blockers and handovers only. If something needs a decision it gets a named owner and a date, not a discussion.'],
    ['Wed', 'Critique',                 'Work in progress on the wall, reviewed against the brief by people who did not make it. Juniors present the same way principals do.'],
    ['Thu', 'Build review',             'Engineering and design in the same room looking at the actual build, not the design file. Accessibility and performance are on the checklist, every time.'],
    ['Fri', 'Ship, then write it down', 'What went out, what it cost, what we learned. The decision log is updated on Friday or it is not updated at all.'],
];

$wk_not = [
    'Not a research lab. Almost everything we build is for a client with a date and a budget, and the date usually wins the argument about scope.',
    'Not a place to hide. Your work is reviewed weekly by people outside your practice, and your name is on the decision log.',
    'Not endlessly greenfield. Plenty of the work is improving something that already exists, in someone else\'s codebase, with someone else\'s constraints.',
    'Not a nine-to-five every week. Launch weeks are heavier than normal weeks, and we would rather say so than pretend otherwise.',
];
?>
<section class="band car-work" id="the-work" aria-labelledby="the-work-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The work, honestly</p>
        <h2 class="h2" id="the-work-t"><span class="g">What a week here</span> actually looks like.</h2>
      </div>
      <div>
        <p class="lead">Client work with real dates, reviewed in public, in a studio that writes things down. The rituals below are what hold it together. They are also most of what will be different from your last job.</p>
      </div>
    </div>

    <div class="car-work__grid">
      <ol class="car-work__week" data-rv-s data-rv-step="70">
        <?php foreach ($wk_week as $wk_r): ?>
          <li class="car-work__step">
            <span class="car-work__day"><?= e($wk_r[0]) ?></span>
            <h3 class="bdh-t car-work__t"><?= e($wk_r[1]) ?></h3>
            <p class="bdh-d car-work__d"><?= e($wk_r[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="car-work__aside" data-rv data-rv-d="90">
        <!-- PLACEHOLDER: stock photograph, not an Xterra Edze team or office — replace with our own
             photography before launch. Credit in assets/imgs/careers/CREDITS.md. -->
        <figure class="bdh-img bdh-img--r43 car-work__fig">
          <img src="<?= xe_url('assets/imgs/careers/work-review.jpg') ?>" alt="Two colleagues talking through a diagram at a whiteboard." width="1400" height="934" loading="lazy" decoding="async">
        </figure>
        <p class="car-work__cap"><span class="bdh-cap-chip"><b>Illustrative</b>A stock photograph, not our studio. Our own photography replaces it before launch.</span></p>

        <div class="car-work__not">
          <p class="car-k car-k--warn">What this job is not</p>
          <ul class="bdh-bullets">
            <?php foreach ($wk_not as $wk_x): ?><li><?= e($wk_x) ?></li><?php endforeach; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
