<?php /* DRAFT COPY — review before launch */
/* 09 Reliability — the SLO panel. Three service level indicators, each with its target, its observed
   30-day figure and an error-budget burn-down with deploy markers. Tabs switch the indicator; the HTML
   ships all three panes complete and readable, reliability.js adds the ARIA tablist and redraws the line.
   Burn-down series are illustrative; the arithmetic behind them is not — 99.9% over 30 days really is
   43.2 minutes of budget, and the burn-rate thresholds are the standard fast/slow pair. */
$tic_rl_slis = [
    [
        'k'        => 'availability',
        'name'     => 'Availability',
        'ico'      => 'uptime',
        'sli'      => 'Successful responses ÷ all responses, measured at the gateway, excluding client 4xx.',
        'target'   => '99.9%',
        'target_l' => 'over 30 days',
        'obs'      => '99.96%',
        'budget'   => '43.2 min',
        'spent'    => '17.4 min',
        'left'     => '25.8 min',
        'pct'      => 59.7,
        'note'     => 'One provider incident on day 12 burned 6.4 minutes. The multi-provider router carried the rest of the traffic, so the budget survived it.',
        'series'   => [100, 99.4, 98.7, 98.1, 97.6, 96.9, 96.2, 95.6, 95.0, 94.3, 93.6, 93.0, 78.2, 76.8, 75.9, 75.1, 74.2, 73.4, 72.5, 71.6, 70.8, 69.9, 68.9, 67.9, 66.8, 65.7, 64.6, 63.4, 62.2, 61.0, 59.7],
        'events'   => [[12, 'Provider incident', 'The multi-provider router failed over in 41 seconds. 6.4 minutes of budget spent.']],
    ],
    [
        'k'        => 'latency',
        'name'     => 'p95 latency',
        'ico'      => 'latency',
        'sli'      => 'Share of non-streaming requests completed end to end within the target, per endpoint class.',
        'target'   => '99% &lt; 1.5 s',
        'target_l' => 'p95 observed 1.21 s',
        'obs'      => '99.38%',
        'budget'   => '345k req',
        'spent'    => '214k req',
        'left'     => '131k req',
        'pct'      => 37.9,
        'note'     => 'A day-20 release raised p95 by 340 ms. Fast burn paged on-call inside the hour, the release was rolled back, and the budget is being repaid before the next feature ships.',
        'series'   => [100, 98.8, 97.5, 96.3, 95.0, 93.8, 92.5, 91.2, 90.0, 88.7, 87.4, 86.2, 84.9, 83.6, 82.3, 81.0, 79.6, 78.3, 76.9, 75.5, 58.4, 56.2, 54.1, 52.0, 49.9, 47.8, 45.7, 43.6, 41.5, 39.7, 37.9],
        'events'   => [[20, 'Bad release · rolled back', 'Fast burn hit 14.4× and paged on-call. Rolled back inside the hour.']],
    ],
    [
        'k'        => 'ttft',
        'name'     => 'Time to first token',
        'ico'      => 'bolt',
        'sli'      => 'Share of streaming responses that put their first token on the wire within the target.',
        'target'   => '95% &lt; 800 ms',
        'target_l' => 'p95 observed 612 ms',
        'obs'      => '96.8%',
        'budget'   => '965k streams',
        'spent'    => '342k streams',
        'left'     => '623k streams',
        'pct'      => 64.6,
        'note'     => 'Prompt caching and continuous batching hold first token steady through the evening peak, so the budget burns close to the ideal line.',
        'series'   => [100, 98.8, 97.6, 96.4, 95.1, 93.9, 92.6, 91.3, 90.0, 88.6, 87.3, 85.9, 84.5, 83.1, 81.7, 80.3, 78.8, 77.4, 75.9, 74.4, 72.9, 71.4, 70.0, 69.2, 68.5, 67.8, 67.2, 66.5, 65.9, 65.2, 64.6],
    ],
];
$tic_rl_deploys = [4, 9, 14, 18, 23, 27];
$tic_rl_x = fn (float $d): float => round($d / 30 * 600, 1);
$tic_rl_y = fn (float $v): float => round(10 + (100 - $v) / 100 * 180, 1);
$tic_rl_path = function (array $vals) use ($tic_rl_x, $tic_rl_y): string {
    $d = '';
    foreach ($vals as $i => $v) { $d .= ($i ? 'L' : 'M') . $tic_rl_x((float) $i) . ',' . $tic_rl_y((float) $v); }
    return $d;
};
$tic_rl_practice = [
    ['wrench',  'Runbooks that match the alerts',  'Every alert links to a runbook with the first five commands, the dashboards to open and the rollback. Written during the build, not after the first incident.'],
    ['headset', 'On-call with a real rotation',    'A primary and a secondary, paging through an escalation policy, with handover notes at the end of each shift. Your engineers and ours share the rotation where you want that.'],
    ['eval',    'Blameless post-incident reviews', 'Within five working days: timeline, contributing causes, what the monitoring missed, and actions with owners. The actions go into the next sprint, not a backlog.'],
    ['rollback','DR with tested RTO and RPO',      'Targets agreed per system, then proven by a restore drill each quarter — a real rebuild from infrastructure as code and backups, timed and written up.'],
];
$tic_rl_badges = ['iso27001', 'soc2', 'cis', 'nist-csf', 'iso22301'];
?>
<section class="band band--ink tic-reliability" id="reliability" aria-labelledby="reliability-t">
  <div class="wrap">
    <div class="tic-head" data-rv>
      <p class="tic-ch"><b>09</b><span>Reliability</span><i aria-hidden="true"></i><em>service level objectives · error budgets · on-call</em></p>
      <div class="tic-head__t">
        <h2 class="h2" id="reliability-t"><span class="g">SLOs we set with you,</span> and a budget we spend carefully.</h2>
      </div>
      <div class="tic-head__l">
        <p class="lead">Uptime is a number you choose and then pay for. We agree the indicators, the targets and the window with you, publish the budget they leave, and let that budget decide when the team ships features and when it fixes reliability.</p>
      </div>
    </div>

    <div class="tic-rl" data-rv data-tic-rl>
      <div class="tic-panel tic-rl__panel">
        <div class="tic-panel__bar tic-rl__bar">
          <span class="tic-led tic-led--blink" aria-hidden="true"></span>
          <span class="tic-rl__id">slo · your-platform-prod · rolling 30 days</span>
          <div class="bdh-tabs tic-rl__tabs" role="tablist" aria-label="Service level indicator" data-tic-rl-tabs>
            <?php foreach ($tic_rl_slis as $tic_rl_i => $tic_rl_s): ?>
              <button type="button" role="tab" id="reliability-t<?= $tic_rl_i ?>" tabindex="<?= $tic_rl_i === 0 ? '0' : '-1' ?>" aria-selected="<?= $tic_rl_i === 0 ? 'true' : 'false' ?>" aria-controls="reliability-p<?= $tic_rl_i ?>"><?= xt_icon($tic_rl_s['ico'], ['size' => 15, 'mono' => true]) ?><?= e($tic_rl_s['name']) ?></button>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bdh-panes tic-rl__panes">
          <?php foreach ($tic_rl_slis as $tic_rl_i => $tic_rl_s): ?>
            <div class="bdh-pane tic-rl__pane<?= $tic_rl_i === 0 ? ' is-on' : '' ?>" id="reliability-p<?= $tic_rl_i ?>" role="tabpanel" tabindex="0" aria-labelledby="reliability-t<?= $tic_rl_i ?>">

              <div class="tic-rl__top">
                <div class="tic-rl__def">
                  <h3 class="h3 tic-rl__h"><?= e($tic_rl_s['name']) ?></h3>
                  <p class="tic-rl__sli"><?= e($tic_rl_s['sli']) ?></p>
                </div>
                <dl class="tic-rl__kpis">
                  <div><dt class="tic-k">Objective</dt><dd class="tic-v"><?= $tic_rl_s['target'] ?></dd><dd class="tic-rl__sub"><?= e($tic_rl_s['target_l']) ?></dd></div>
                  <div><dt class="tic-k">Observed</dt><dd class="tic-v"><?= e($tic_rl_s['obs']) ?></dd><dd class="tic-rl__sub">this window</dd></div>
                  <div><dt class="tic-k">Budget</dt><dd class="tic-v"><?= e($tic_rl_s['budget']) ?></dd><dd class="tic-rl__sub">total for 30 days</dd></div>
                  <div class="is-key"><dt class="tic-k">Remaining</dt><dd class="tic-v"><?= e($tic_rl_s['left']) ?></dd><dd class="tic-rl__sub"><?= $tic_rl_s['pct'] ?>% of budget</dd></div>
                </dl>
              </div>

              <p class="bdh-sr">An error-budget burn-down for <?= e($tic_rl_s['name']) ?> across thirty days, falling from the full budget to <?= $tic_rl_s['pct'] ?>% remaining, plotted against a straight ideal-burn line, with deployment markers along the bottom<?= !empty($tic_rl_s['events']) ? ' and one step drop where an incident burned budget quickly' : '' ?>.</p>
              <figure class="tic-rl__fig" aria-hidden="true">
                <figcaption class="tic-rl__cap"><span>Error budget remaining</span><span class="tic-rl__legend"><i class="tic-rl__lg tic-rl__lg--a"></i>actual<i class="tic-rl__lg tic-rl__lg--i"></i>ideal burn<i class="tic-rl__lg tic-rl__lg--f"></i>release freeze at 25%</span></figcaption>
                <div class="tic-rl__plot">
                  <svg class="tic-chart tic-rl__svg" viewBox="0 0 600 200" preserveAspectRatio="none" focusable="false">
                    <defs><clipPath id="reliability-w<?= $tic_rl_i ?>" clipPathUnits="userSpaceOnUse"><rect class="tic-wipe tic-rl__wipe" x="-6" y="-14" width="612" height="228"/></clipPath></defs>
                    <?php foreach ([25, 50, 75] as $tic_rl_g): ?><line class="gl" x1="0" y1="<?= $tic_rl_y($tic_rl_g) ?>" x2="600" y2="<?= $tic_rl_y($tic_rl_g) ?>"/><?php endforeach; ?>
                    <line class="th tic-rl__freeze" x1="0" y1="<?= $tic_rl_y(25) ?>" x2="600" y2="<?= $tic_rl_y(25) ?>"/>
                    <path class="s3" d="M<?= $tic_rl_x(0) ?>,<?= $tic_rl_y(100) ?>L<?= $tic_rl_x(30) ?>,<?= $tic_rl_y(0) ?>"/>
                    <path class="s1 tic-rl__line" d="<?= $tic_rl_path($tic_rl_s['series']) ?>" clip-path="url(#reliability-w<?= $tic_rl_i ?>)"/>
                  </svg>
                  <?php foreach ([100, 75, 50, 25] as $tic_rl_g): ?>
                    <span class="tic-rl__yl" style="--y:<?= round($tic_rl_y($tic_rl_g) / 200, 4) ?>"><?= $tic_rl_g ?>%</span>
                  <?php endforeach; ?>
                  <?php foreach ($tic_rl_deploys as $tic_rl_d): ?>
                    <span class="tic-rl__dep" style="--x:<?= round($tic_rl_d / 30, 4) ?>" title="Deployment"></span>
                  <?php endforeach; ?>
                  <?php foreach (($tic_rl_s['events'] ?? []) as $tic_rl_ev):
                      /* --ey is where the plotted line sits at this day, so the callout can be placed
                         clear of it: early events drop below the line, later ones sit above it. */
                      $tic_rl_ey = round($tic_rl_y((float) $tic_rl_s['series'][$tic_rl_ev[0]]) / 200, 4); ?>
                    <span class="tic-rl__ev<?= $tic_rl_ev[0] > 15 ? ' tic-rl__ev--l' : '' ?>" style="--x:<?= round($tic_rl_ev[0] / 30, 4) ?>;--ey:<?= $tic_rl_ey ?>">
                      <i></i><b>Day <?= $tic_rl_ev[0] ?> · <?= e($tic_rl_ev[1]) ?></b><span class="tic-rl__evd"><?= e($tic_rl_ev[2]) ?></span>
                    </span>
                  <?php endforeach; ?>
                </div>
                <p class="tic-rl__days"><?php foreach ([0, 10, 20, 30] as $tic_rl_dd): ?><span style="--x:<?= $tic_rl_dd / 30 ?>">day <?= sprintf('%02d', $tic_rl_dd) ?></span><?php endforeach; ?></p>
              </figure>

              <p class="tic-rl__note"><?= xt_icon('log', ['size' => 16]) ?><span><?= e($tic_rl_s['note']) ?></span></p>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="tic-rl__rules">
          <div class="tic-rl__rule">
            <p class="tic-k">Burn-rate alerting</p>
            <p>Fast burn — 14.4× the budget rate sustained over one hour — pages on-call. Slow burn — 6× over six hours — opens a ticket for the next working day. Alerts are on the indicator, never on a single failing host.</p>
          </div>
          <div class="tic-rl__rule">
            <p class="tic-k">The freeze rule</p>
            <p>Under 25% of the budget left, feature releases stop and the team spends the sprint on reliability. Everyone agrees this in advance, so the decision is arithmetic rather than an argument during an incident.</p>
          </div>
          <div class="tic-rl__rule">
            <p class="tic-k">Illustrative figures</p>
            <p>The window, targets and thresholds are the real ones we use. The values plotted here are sample data for a sample platform. <span class="bdh-ill">Illustrative</span></p>
          </div>
        </div>
      </div>

      <div class="tic-rl__ops">
        <div class="tic-rl__left">
        <ul class="tic-rl__practice" role="list" data-rv-s data-rv-step="80">
          <?php foreach ($tic_rl_practice as $tic_rl_p): ?>
            <li class="bdh-card tic-rl__pc">
              <span class="tic-rl__pi" aria-hidden="true"><?= xt_icon($tic_rl_p[0], ['size' => 20]) ?></span>
              <h3 class="h3 tic-rl__pt"><?= e($tic_rl_p[1]) ?></h3>
              <p><?= e($tic_rl_p[2]) ?></p>
            </li>
          <?php endforeach; ?>
        </ul>

        <figure class="tic-rl__photo" data-rv>
          <div class="bdh-img bdh-img--r219"><img src="<?= xe_url('assets/imgs/tech/ai-infrastructure-cloud/tic-reliability-patch.jpg') ?>" alt="A network patch panel in close-up, its ports numbered and grey and blue cables plugged into them" width="1600" height="1067" loading="lazy" decoding="async"></div>
          <figcaption class="bdh-cap-chip"><b>02:40 · on-call</b>Every alert links to a runbook, and every runbook opens with the first five commands and the rollback.</figcaption>
        </figure>
        </div>

        <div class="tic-rl__std" data-rv>
          <div class="tic-rl__stdh">
            <p class="tic-k">Frameworks we align delivery with</p>
            <p class="tic-note">Controls, continuity and hardening baselines the platform is built to. Certification of your own environment is a separate exercise we can prepare you for.</p>
          </div>
          <ul class="xt-badges tic-rl__badges" role="list">
            <?php foreach ($tic_rl_badges as $tic_rl_b): ?><?= xt_badge($tic_rl_b, ['tag' => 'li']) ?><?php endforeach; ?>
          </ul>
          <!-- PLACEHOLDER: confirm on-call coverage and support hours before launch -->
          <p class="tic-note tic-rl__hours"><?= xt_icon('clock', ['size' => 15]) ?>Support cover is agreed per engagement — business hours, extended hours or 24×7 — and written into the runbook with the escalation path.</p>
        </div>
      </div>
    </div>
  </div>
</section>
