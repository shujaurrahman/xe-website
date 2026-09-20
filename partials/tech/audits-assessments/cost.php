<?php /* DRAFT COPY — review before launch */
/* Cost — what the issues cost per month, as a waterfall. Five loss lines rise from zero to a
   recoverable total, each one a tab on the chart; selecting or hovering a bar opens the pane
   beneath it with the formula, the substituted arithmetic, the inputs and where each input came
   from. Everything here is an illustrative model for "Your company", not a client result.
   cost.js drops the bars in sequence on entry and wires the tablist. */

$taa_ct_max  = 64000;   // axis top, so the total bar does not touch the ceiling
$taa_ct_grid = [0, 16000, 32000, 48000, 64000];

$taa_ct_steps = [
    [
        'k'    => 'conv',
        'n'    => 'Conversions',
        'full' => 'Lost conversions',
        'sub'  => 'Slow mobile checkout',
        'v'    => 18400,
        'conf' => 'Measured inputs · modelled uplift',
        'ids'  => ['TA-03'],
        'f'    => 'monthly loss = checkout sessions × Δ conversion rate × average order value',
        'calc' => '214,000 × 0.29% × $29.60 = $18,369',
        'in'   => [
            ['Mobile checkout sessions', '214,000 / month', 'Analytics, 28 days'],
            ['Conversion at LCP ≤ 2.5 s', '1.71%', 'Analytics cohort, field LCP'],
            ['Conversion at LCP 4.6 s', '1.42%', 'Analytics cohort, field LCP'],
            ['Average order value', '$29.60', 'Order data, 90 days'],
        ],
        'note' => 'Cohorts are split on field LCP from the Chrome UX Report, not on a lab score, so the difference is between real sessions. Core Web Vitals count as good at LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1 at the 75th percentile.',
    ],
    [
        'k'    => 'search',
        'n'    => 'Search',
        'full' => 'Lost search visibility',
        'sub'  => 'Legacy noindex on product templates',
        'v'    => 11700,
        'conf' => 'Measured inputs · modelled uplift',
        'ids'  => ['SEO-05'],
        'f'    => 'monthly loss = non-brand clicks lost × organic order rate × average order value',
        'calc' => '41,300 × 0.96% × $29.60 = $11,736',
        'in'   => [
            ['Non-brand clicks lost', '41,300 / month', 'Search Console vs 12-month baseline'],
            ['Organic session → order rate', '0.96%', 'Analytics, 90 days'],
            ['Average order value', '$29.60', 'Order data, 90 days'],
            ['Pages affected', '2,140 product URLs', 'Full crawl reconciled with coverage'],
        ],
        'note' => 'The baseline is the twelve months before the legacy template shipped, seasonally adjusted against the category trend. Recovery is not instant: indexation takes weeks after the tag is removed.',
    ],
    [
        'k'    => 'rework',
        'n'    => 'Rework',
        'full' => 'Manual rework',
        'sub'  => 'Reconciling order and event data by hand',
        'v'    => 14600,
        'conf' => 'Estimated from a four-week time log',
        'ids'  => ['DAT-02', 'AI-02'],
        'f'    => 'monthly cost = rework hours × blended loaded hourly rate',
        'calc' => '380 h × $38.40 = $14,592',
        'in'   => [
            ['Rework hours', '380 / month', 'Time log, three teams, 4 weeks'],
            ['Blended loaded rate', '$38.40 / hour', 'Your finance team'],
            ['Largest single task', 'Order reconciliation, 190 h', 'Time log'],
            ['Event loss driving it', '3.1% of order events', 'Queue metrics vs server truth'],
        ],
        'note' => 'Rework is the cost of doing a task twice, not the cost of the team. Hours were logged by the people doing the work rather than estimated in a workshop.',
    ],
    [
        'k'    => 'cloud',
        'n'    => 'Cloud waste',
        'full' => 'Cloud waste',
        'sub'  => 'Idle compute, unattached storage, transfer',
        'v'    => 9200,
        'conf' => 'Measured from the bill and utilisation',
        'ids'  => ['CLD-02'],
        'f'    => 'monthly waste = Σ (unused capacity × unit rate × hours)',
        'calc' => '$5,690 + $2,288 + $1,220 = $9,198',
        'in'   => [
            ['Oversized instances', '9, mean 61% unused', 'p95 utilisation, 30 days'],
            ['Blended instance rate', '$1.42 / hour × 730 h', 'Cloud bill'],
            ['Unattached block storage', '26 TB at $0.088 / GB-month', 'Cloud bill'],
            ['Cross-region transfer', '61 TB at $0.02 / GB', 'Cloud bill'],
        ],
        'note' => 'That is 9.6% of the monthly cloud bill spent on capacity nobody used. Right-sizing against p95 rather than peak also lowers the Software Carbon Intensity baseline, SCI = ((E × I) + M) per R, so the cost line and the carbon line move together.',
    ],
    [
        'k'    => 'risk',
        'n'    => 'Risk',
        'full' => 'Risk exposure',
        'sub'  => 'Expected loss, not a price',
        'v'    => 7300,
        'model'=> true,
        'conf' => 'Modelled · rated, not priced',
        'ids'  => ['SEC-01', 'SEC-04'],
        'f'    => 'expected monthly loss = (annual likelihood × modelled impact) ÷ 12',
        'calc' => '(14% × $625,000) ÷ 12 = $7,292',
        'in'   => [
            ['Critical findings open', '2', 'Findings register'],
            ['Modelled annual likelihood', '14%', 'Exposure, exploit maturity, controls'],
            ['Modelled impact', '$625,000', 'Response, notification, downtime, penalty exposure'],
            ['Rating method', 'CVSS v3.1, re-rated for context', 'Security assessment'],
        ],
        'note' => 'This line exists only so risk can be compared with revenue inside one fix order. A breach is a probability, not a monthly invoice, and the register still rates security findings with CVSS rather than pricing them. Penalty exposure is modelled against the India DPDP Act 2023.',
    ],
    [
        'k'    => 'total',
        'n'    => 'Recoverable',
        'full' => 'Recoverable value',
        'sub'  => 'The five lines together',
        'v'    => 61200,
        'total'=> true,
        'conf' => 'Sum of the lines above',
        'ids'  => [],
        'f'    => 'recoverable value = Σ (the five lines above)',
        'calc' => '$18,400 + $11,700 + $14,600 + $9,200 + $7,300 = $61,200',
        'in'   => [
            ['Recoverable per month', '$61,200', 'Modelled'],
            ['Recoverable per year', '≈ $734,400', 'Modelled, at a steady run rate'],
            ['Share of monthly digital revenue', '4.9%', 'Against $1.24M / month'],
            ['Remediation effort', '31 engineering days', 'Engineering estimates, ±30%'],
        ],
        'note' => 'The planner above sequences the full 55-day plan, these five lines included, so the value arrives in the order that recovers the most soonest while respecting dependencies. Every figure on this page is illustrative and built for a fictional company.',
    ],
];

$taa_ct_base = [
    ['Monthly digital revenue', '$1.24M', 'the baseline the loss lines are measured against'],
    ['Monthly cloud bill', '$96,000', 'of which 9.6% buys unused capacity'],
    ['Remediation effort', '31 eng. days', 'behind these five lines, of 55 across the whole plan'],
];

// running cumulative → bar offset and height as a share of the axis
$taa_ct_cum = 0;
foreach ($taa_ct_steps as $taa_ct_i => $taa_ct_s) {
    $taa_ct_off = empty($taa_ct_s['total']) ? $taa_ct_cum : 0;
    $taa_ct_steps[$taa_ct_i]['o'] = round($taa_ct_off / $taa_ct_max * 100, 2);
    $taa_ct_steps[$taa_ct_i]['h'] = round($taa_ct_s['v'] / $taa_ct_max * 100, 2);
    if (empty($taa_ct_s['total'])) { $taa_ct_cum += $taa_ct_s['v']; }
}
unset($taa_ct_i, $taa_ct_s, $taa_ct_off);
?>
<section class="band band--ink taa-cost" id="cost" aria-labelledby="cost-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">06</span><span>Cost of inaction</span></p>
        <h2 class="h2" id="cost-t"><span class="g">What the issues cost,</span> per month.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Severity alone does not fund a sprint. Every finding that can be costed is costed, with the formula printed next to the number and the inputs taken from your own analytics, bills and engineering estimates.</p>
      </div>
    </header>

    <dl class="taa-cost__base" data-rv>
      <?php foreach ($taa_ct_base as $taa_ct_b): ?>
        <div>
          <dt><?= e($taa_ct_b[0]) ?></dt>
          <dd><b><?= e($taa_ct_b[1]) ?></b><span><?= e($taa_ct_b[2]) ?></span></dd>
        </div>
      <?php endforeach; ?>
    </dl>

    <div class="taa-cost__wf" data-taa-cost>

      <figure class="taa-wf">
        <div class="taa-wf__scroll bdh-scroll-x">
          <div class="taa-wf__plot">
            <div class="taa-wf__grid" aria-hidden="true">
              <?php foreach ($taa_ct_grid as $taa_ct_g): ?>
                <?php $taa_ct_p = round($taa_ct_g / $taa_ct_max * 100, 2); ?>
                <span class="taa-wf__gl" style="--p:<?= $taa_ct_p ?>"></span>
                <span class="taa-wf__ax" style="--p:<?= $taa_ct_p ?>"><?= $taa_ct_g ? '$' . number_format($taa_ct_g / 1000) . 'k' : '$0' ?></span>
              <?php endforeach; ?>
            </div>

            <div class="bdh-tabs taa-wf__bars" role="tablist" aria-label="Monthly cost lines" data-taa-cost-tabs>
              <?php foreach ($taa_ct_steps as $taa_ct_i => $taa_ct_s): ?>
                <button type="button" class="taa-wf__b<?= !empty($taa_ct_s['total']) ? ' is-total' : '' ?><?= !empty($taa_ct_s['model']) ? ' is-model' : '' ?>"
                        role="tab" id="cost-tab-<?= e($taa_ct_s['k']) ?>" aria-controls="cost-pane-<?= e($taa_ct_s['k']) ?>"
                        aria-selected="<?= $taa_ct_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $taa_ct_i === 0 ? '0' : '-1' ?>"
                        style="--i:<?= (int) $taa_ct_i ?>;--o:<?= $taa_ct_s['o'] ?>;--h:<?= $taa_ct_s['h'] ?>">
                  <span class="taa-wf__track" aria-hidden="true">
                    <span class="taa-wf__bar"></span>
                    <?php if (empty($taa_ct_s['total']) && $taa_ct_i < 4): ?><span class="taa-wf__link"></span><?php endif; ?>
                  </span>
                  <span class="taa-wf__lb">
                    <span class="taa-wf__v">$<?= number_format($taa_ct_s['v']) ?></span>
                    <span class="taa-wf__n"><?= e($taa_ct_s['n']) ?><span class="bdh-sr"> — <?= e($taa_ct_s['full']) ?>, <?= e($taa_ct_s['sub']) ?></span></span>
                  </span>
                </button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <p class="bdh-sr">The chart is a waterfall: five loss lines stack from zero to a recoverable total of $61,200 a month. Lost conversions are the largest at $18,400, then manual rework at $14,600, lost search visibility at $11,700, cloud waste at $9,200 and modelled risk exposure at $7,300. Select any bar for its formula and inputs.</p>
        <figcaption class="taa-wf__cap">
          <span class="taa-est">Illustrative</span>
          <span>Monthly, in US dollars, for a fictional company. Select a bar — or move across them with the arrow keys — to open the calculation.</span>
        </figcaption>
      </figure>

      <div class="bdh-panes taa-cost__panes">
        <?php foreach ($taa_ct_steps as $taa_ct_i => $taa_ct_s): ?>
          <div class="bdh-pane taa-cost__pane<?= $taa_ct_i === 0 ? ' is-on' : '' ?>" id="cost-pane-<?= e($taa_ct_s['k']) ?>"
               role="tabpanel" aria-labelledby="cost-tab-<?= e($taa_ct_s['k']) ?>" tabindex="0">

            <div class="taa-cost__ph">
              <div>
                <h3 class="bdh-t"><?= e($taa_ct_s['full']) ?></h3>
                <p class="taa-cost__sub"><?= e($taa_ct_s['sub']) ?></p>
              </div>
              <p class="taa-cost__fig"><b>$<?= number_format($taa_ct_s['v']) ?></b><span>per month<?= !empty($taa_ct_s['model']) ? ' · modelled' : '' ?></span></p>
            </div>

            <div class="taa-cost__f">
              <p class="taa-lbl">Formula</p>
              <code class="taa-cost__code"><?= e($taa_ct_s['f']) ?></code>
              <code class="taa-cost__code taa-cost__code--calc"><?= e($taa_ct_s['calc']) ?></code>
            </div>

            <table class="taa-tbl taa-cost__in">
              <caption class="bdh-sr">Inputs to the <?= e(strtolower($taa_ct_s['full'])) ?> calculation, with the source of each one.</caption>
              <thead>
                <tr><th scope="col">Input</th><th scope="col">Value</th><th scope="col">Source</th></tr>
              </thead>
              <tbody>
                <?php foreach ($taa_ct_s['in'] as $taa_ct_in): ?>
                  <tr>
                    <th scope="row"><?= e($taa_ct_in[0]) ?></th>
                    <td class="taa-n"><?= e($taa_ct_in[1]) ?></td>
                    <td class="taa-cost__src"><?= e($taa_ct_in[2]) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <div class="taa-cost__pf">
              <p class="taa-cost__note"><?= e($taa_ct_s['note']) ?></p>
              <ul class="taa-cost__tags" role="list">
                <li class="taa-cost__conf"><?= e($taa_ct_s['conf']) ?></li>
                <?php foreach ($taa_ct_s['ids'] as $taa_ct_id): ?>
                  <li class="taa-id taa-cost__ref"><?= e($taa_ct_id) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="taa-cost__foot">
      These five lines group the register's losses by where the money goes, and add a modelled figure for risk that the fix-order planner rates rather than prices — so $61,200 here and $65,700 in the planner are the same audit counted two ways, not two claims. Confidence is stated on every line. <b>Measured</b> means it was counted in your own systems, <b>estimated</b> means a person sized it and said so, <b>modelled</b> means a probability was applied. Nothing on this page is presented as certain, and no cost is claimed for a finding that cannot be traced back to an input you can check.
    </p>

  </div>
</section>
