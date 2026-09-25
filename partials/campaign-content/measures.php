<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Outcomes and how each is measured. Data-viz idiom: .cch-viz (response curve). */
$cch_rows = [   // [outcome, question, metrics, method, cadence]
    ['Attention', 'Did the right people see it, enough times?', 'Reach at effective frequency · attention time · share of voice', 'Platform and panel data, de-duplicated across channels', 'Weekly'],
    ['Memory',    'Do they remember it, and the brand?',        'Ad recall · brand awareness · message association', 'Brand lift studies with exposed and control groups', 'Per flight'],
    ['Action',    'Did it change what people did?',             'Qualified visits · leads · conversions · search demand for the brand', 'Server-side tracking and CRM match, not platform claims alone', 'Weekly'],
    ['Business',  'What did it cause, and was it worth it?',    'Incremental conversions · cost per incremental customer · payback', 'Geo holdouts and, at scale, media-mix modelling', 'Per flight · quarterly'],
];
/* diminishing-returns curve: spend (x) against incremental outcome (y) */
$cch_curve = [];
for ($cch_x = 0; $cch_x <= 20; $cch_x++) {
    $cch_y = 1 - exp(-$cch_x / 6);
    $cch_curve[] = round(32 + $cch_x * 22, 1) . ',' . round(170 - $cch_y * 140, 1);
}
?>
<section class="band cch-meas" id="measures" aria-labelledby="measures-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Outcomes, and how we measure them</p>
        <h2 class="h2" id="measures-t"><span class="g">Agreed before launch.</span> Measured by what the campaign caused.</h2></div>
      <div><p class="lead">Platforms each claim credit for the same customer. We separate what a campaign caused from what would have happened anyway, and report it in four layers.</p></div>
    </div>
    <div class="bdh-scroll-x mask-x cch-meas__wrap" tabindex="0" role="region" aria-label="Campaign outcomes, metrics, methods and cadence">
      <table class="cch-meas__t">
        <thead><tr><th scope="col">Outcome</th><th scope="col">What we track</th><th scope="col">How it is measured</th><th scope="col">Read</th></tr></thead>
        <tbody>
          <?php foreach ($cch_rows as $cch_i => $cch_r): ?>
          <tr>
            <th scope="row"><span class="bdh-idx"><?= sprintf('%02d', $cch_i + 1) ?></span><span class="cch-meas__o"><?= e($cch_r[0]) ?></span><span class="cch-meas__q"><?= e($cch_r[1]) ?></span></th>
            <td data-k="What we track"><?= e($cch_r[2]) ?></td><td data-k="How it is measured"><?= e($cch_r[3]) ?></td><td class="bdh-ro" data-k="Read"><?= e($cch_r[4]) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div class="cch-meas__g">
      <figure class="cch-viz" data-rv>
        <figcaption class="bdh-ro"><span><i class="cch-viz__k cch-viz__k--t"></i>Incremental outcome</span><span>Response curve · illustrative</span></figcaption>
        <svg viewBox="0 0 496 200" aria-hidden="true" focusable="false">
          <?php foreach ([30, 100, 170] as $cch_y): ?><line class="cch-viz__grid" x1="32" x2="472" y1="<?= $cch_y ?>" y2="<?= $cch_y ?>"/><?php endforeach; ?>
          <rect class="cch-viz__band" x="164" y="22" width="110" height="150"/>
          <polyline class="cch-viz__t" points="<?= implode(' ', $cch_curve) ?>"/>
          <circle class="cch-viz__pt" cx="230" cy="<?= round(170 - (1 - exp(-9 / 6)) * 140, 1) ?>" r="5"/>
        </svg>
        <div class="cch-viz__x bdh-ro" aria-hidden="true"><span>Spend →</span><span class="cch-viz__eff">Efficient range</span><span>Diminishing returns</span></div>
        <p class="bdh-sr">An illustrative response curve: incremental outcome rises quickly with spend, then flattens. A shaded band marks the efficient range where the plan is set.</p>
      </figure>
      <div class="cch-meas__side" data-rv>
        <h3 class="h3">Where the next pound, dollar or rupee works hardest</h3>
        <p class="p">Holdouts and lift studies tell us what a campaign caused. Response curves built from them show where extra budget stops paying back, so the next flight is planned on evidence rather than last year's split.</p>
        <ul class="cch-meas__l">
          <li><strong>Before launch</strong> — baseline, holdout design and the one number that decides success</li>
          <li><strong>In flight</strong> — weekly optimisation on leading signals, never on clicks alone</li>
          <li><strong>After</strong> — incremental result, cost per incremental customer and what to change</li>
        </ul>
      </div>
    </div>
  </div>
</section>
