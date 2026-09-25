<?php /* DRAFT COPY — review before launch */
/* Measures — what changes, and how it is measured. First the four things agreed before anything is
   built, then the measures themselves by concern with how each one is collected, then the outcomes
   each capability is accountable for (the approved copy in data/product-experience.php).
   No achieved results are claimed anywhere on this page; every figure elsewhere is marked illustrative. */
$msr_contract = [
    ['01', 'The measure',  'Named, and narrow enough to move. "Conversion" is a report; "completion rate on the delivery step, on mobile" is a measure.'],
    ['02', 'The method',   'How it is collected, by whom and with what script, so the number after the work is comparable with the number before it.'],
    ['03', 'The baseline', 'Taken before anything changes. A redesign without a baseline can only ever be argued about.'],
    ['04', 'The target',   'Agreed with you, in writing, including what we will do if it is missed.'],
];
$msr_groups = [
    ['Usability', 'gauge', [
        ['Task success rate',            'Moderated sessions, fixed task set, same script before and after'],
        ['Time on task',                 'Median seconds per task, from the same recordings'],
        ['Error rate',                   'Errors per attempt, against a written definition of an error'],
        ['SUS or UMUX-Lite',             'Standard questionnaire at the end of each benchmark round'],
    ]],
    ['The product', 'chart', [
        ['Completion rate on the journey', 'Your product analytics, segmented by device'],
        ['Adoption of the changed journey','Share of eligible users who use it in a month'],
        ['Support contacts per 100 sessions','Your helpdesk, tagged to the journey'],
    ]],
    ['Performance', 'bolt', [
        ['LCP, INP and CLS at p75',      'Field data from real page loads, mobile and desktop read separately'],
        ['Budgets held on merge',        'Lab checks in CI, so a regression fails the merge'],
        ['Time to first meaningful task','Measured on a mid-range Android phone, not a laptop'],
    ]],
    ['Accessibility', 'accessibility', [
        ['WCAG 2.2 AA criteria met',     'Automated checks plus a manual keyboard and screen-reader pass per journey'],
        ['Open failures by severity',    'Tracked by how much each one blocks people, not by count'],
        ['Components hardened',          'Share of the library with accessibility acceptance criteria and tests'],
    ]],
    ['The system', 'cube', [
        ['Adoption per product team',    'Component usage measured across your repositories'],
        ['Detached and bespoke components','Counted per team, as the signal that something is missing'],
        ['Time to build a common screen','Timed with a real team, before and after'],
    ]],
    ['An AI feature', 'sparkle', [
        ['Use in week four',             'Adoption measured after the launch spike has passed'],
        ['Correction and abandonment rate','Logged per interaction, alongside what the person did next'],
        ['Escalation rate to a person',  'Counted, and read as a design signal rather than a failure'],
        ['Evaluation score on the golden set','Graded criteria run on every change to a model, prompt or source'],
    ]],
];
?>
<section class="band pxh-measures" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes</p>
        <h2 class="h2" id="measures-t"><span class="g">We will not promise a number.</span> We will promise the measurement.</h2>
      </div>
      <div>
        <p class="lead">Anyone can quote an uplift. What is worth agreeing before the work starts is the measure, how it is collected, the number it starts at and the number you want it to reach. Those four things are the contract; the result is what they produce.</p>
      </div>
    </div>

    <ol class="pxh-measures__contract" data-rv-s data-rv-step="80">
      <?php foreach ($msr_contract as $msr_i => $msr_c): ?>
        <li style="--i:<?= $msr_i ?>">
          <span class="pxh-measures__cn"><?= e($msr_c[0]) ?></span>
          <h3 class="pxh-measures__ct"><?= e($msr_c[1]) ?></h3>
          <p class="pxh-measures__cd"><?= e($msr_c[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="pxh-measures__report">
      <p class="pxh-k pxh-measures__rk">The measures themselves, by concern</p>
      <ul class="pxh-cards pxh-cards--3 pxh-measures__cards" role="list" data-rv-s data-rv-step="60">
        <?php foreach ($msr_groups as $msr_gi => $msr_g): ?>
          <li class="pxh-card pxh-measures__card">
            <span class="pxh-card__top">
              <span class="pxh-card__n"><?= str_pad((string) ($msr_gi + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="pxh-card__ico" aria-hidden="true"><?= xt_icon($msr_g[1], ['size' => 22]) ?></span>
            </span>
            <h3 class="pxh-card__t"><?= e($msr_g[0]) ?></h3>
            <dl class="pxh-measures__list">
              <?php foreach ($msr_g[2] as $msr_m): ?>
                <div><dt><?= e($msr_m[0]) ?></dt><dd><?= e($msr_m[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="pxh-measures__out">
      <div class="pxh-measures__oh" data-rv>
        <div>
          <p class="pxh-k">What changes</p>
          <p class="pxh-measures__ot">What each capability is accountable for, in its own words.</p>
        </div>
        <p class="pxh-note pxh-measures__on">These are the outcomes we write into a statement of work, and the ones a quarterly review is held against. Nothing here is a claim about work already done for someone else.</p>
      </div>

      <div class="pxh-measures__grid">
        <?php foreach (array_values($CAPS) as $msr_ci => $msr_cap): ?>
          <div class="pxh-measures__ocol" data-rv data-rv-d="<?= ($msr_ci % 5) * 40 ?>">
            <p class="pxh-measures__oc">
              <a class="pxh-capl" href="#<?= e($msr_cap['slug']) ?>"><b><?= e($msr_cap['n']) ?></b><span><?= e($msr_cap['short']) ?></span><i aria-hidden="true">›</i></a>
            </p>
            <dl class="pxh-measures__olist">
              <?php foreach (array_slice($msr_cap['outcomes'], 1) as $msr_o): ?>
                <div><dt><?= e($msr_o[0]) ?></dt><dd><?= e($msr_o[1]) ?></dd></div>
              <?php endforeach; ?>
            </dl>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
