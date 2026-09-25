<?php /* DRAFT COPY — review before launch */
/* Measures — outcomes and how they are measured, as a ladder: did anyone notice, did it change what
   they think, did it pay. Each rung names the metric and how the number is produced, because a metric
   without a method is an opinion. Then the things we refuse to report as success, and the review
   rhythm. Every metric here is one the eight capabilities in data/campaign-content.php already
   commit to; no figure or result is claimed. */
$ms_tiers = [
    [
        'n' => '01', 'name' => 'Attention', 'q' => 'Did anyone notice?',
        'rows' => [
            ['Share of voice in your category', 'Coverage and mentions against a named competitor set, tracked monthly against a baseline taken in week one.'],
            ['Saves and shares',                'The engagement that signals intent, reported instead of impressions, by format and by pillar.'],
            ['Branded search volume',           'From Search Console: the cleanest signal that the work reached people who then went looking for you.'],
            ['Named in AI answers',             'Whether answer engines name you when asked about the category, run against a fixed prompt panel each month.'],
        ],
    ],
    [
        'n' => '02', 'name' => 'Persuasion', 'q' => 'Did it change what they think?',
        'rows' => [
            ['Message pull-through',            'Whether your key messages survive into the article, scored per piece of coverage rather than counted.'],
            ['Engaged sessions and returns',    'Whether the content earns the next click, by topic and by buying stage, not by pageview total.'],
            ['Assisted conversations',          'Replies and community threads that turn into a sales or support conversation, logged at the handover.'],
            ['Creator incrementality',          'Holdout or matched-market tests on activations, so borrowed reach and real lift are never confused.'],
        ],
    ],
    [
        'n' => '03', 'name' => 'Business', 'q' => 'Did it pay?',
        'rows' => [
            ['Qualified demand',                'Pipeline measured on consented first-party data and reconciled with the finance view, not with a platform dashboard.'],
            ['Cost per customer',               'Margin-aware, with offline and CRM conversions imported, so the platforms optimise towards customers.'],
            ['Incremental revenue',             'What stopped happening when the spend stopped, read from a geo holdout designed before the budget moved.'],
            ['Retention and repeat rate',       'Tracked alongside acquisition, because the cheapest revenue is a customer you already have.'],
        ],
    ],
];
$ms_not = [
    ['Impressions on their own',   'A number that grows with budget and says nothing about whether anyone noticed.'],
    ['Follower count',             'A stock, not a flow. What a feed earns is measured in saves, shares and returns.'],
    ['Last-click ROAS as a decision', 'Useful as a diagnostic. As a budget decision it rewards the channel that closed the door.'],
    ['Engagement rate with no denominator', 'A percentage of what? Reported with the base, or not reported.'],
    ['Earned media value',         'An advertising price attached to coverage nobody bought. We report the coverage instead.'],
];
$ms_rhythm = [
    ['Week 01',  'Baseline agreed',   'Every metric defined with sales and finance, and its starting value written down before work begins.'],
    ['Day 30',   'First read',        'Enough to correct the plan: what is landing, what is not, and what we stopped doing as a result.'],
    ['Day 90',   'First decision',    'The first reallocation made on evidence, with the reasoning recorded against the numbers that prompted it.'],
    ['Quarterly','Plan corrected',    'Budget moved between channel roles, the content refresh backlog reordered, and the next quarter set.'],
];
?>
<section class="band band--ink cch-measures" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes and how they are measured</p>
        <h2 class="h2" id="measures-t"><span class="g">Three questions,</span> in the order they matter.</h2>
      </div>
      <div>
        <p class="lead">Did anyone notice, did it change what they think, and did it pay. Every metric below comes with the method that produces it, because a metric without a method is an opinion with a decimal point.</p>
      </div>
    </div>

    <div class="cch-ms__ladder" data-rv data-rv-d="60">
      <?php foreach ($ms_tiers as $ms_t): ?>
        <div class="cch-ms__tier">
          <p class="cch-ms__th"><span class="cch-ms__tn"><?= e($ms_t['n']) ?></span><b><?= e($ms_t['name']) ?></b></p>
          <p class="cch-ms__tq"><?= e($ms_t['q']) ?></p>
          <ul class="cch-ms__rows" role="list">
            <?php foreach ($ms_t['rows'] as $ms_r): ?>
              <li><b><?= e($ms_r[0]) ?></b><span><?= e($ms_r[1]) ?></span></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cch-ms__not" data-rv data-rv-d="80">
      <div class="cch-ms__nh">
        <h3 class="cch-ms__h3">Five numbers we will not report as success</h3>
        <p class="cch-ms__nd">Not because they are always meaningless, but because none of them answers one of the three questions above. If one appears in a report, it will be as context with its base attached.</p>
      </div>
      <ol class="cch-ms__nlist">
        <?php foreach ($ms_not as $ms_ni => $ms_n): ?>
          <li><span class="cch-ms__nn"><?= str_pad((string) ($ms_ni + 1), 2, '0', STR_PAD_LEFT) ?></span><b><?= e($ms_n[0]) ?></b><span><?= e($ms_n[1]) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="cch-ms__rhythm" data-rv data-rv-d="60">
      <p class="cch-k cch-ms__rk">The review rhythm</p>
      <ol class="cch-ms__rlist">
        <?php foreach ($ms_rhythm as $ms_ri => $ms_r): ?>
          <li class="cch-ms__step">
            <p class="cch-ms__sw"><?= e($ms_r[0]) ?></p>
            <h3 class="cch-ms__st"><?= e($ms_r[1]) ?></h3>
            <p class="cch-ms__sd"><?= e($ms_r[2]) ?></p>
          </li>
        <?php endforeach; ?>
      </ol>
      <!-- PLACEHOLDER: confirm the review cadence and the first-read timing before launch -->
      <p class="cch-note cch-ms__rn">Timings are the rhythm we recommend and are agreed per engagement. No result, ranking, placement or coverage volume is promised anywhere on this page.</p>
    </div>
  </div>
</section>
