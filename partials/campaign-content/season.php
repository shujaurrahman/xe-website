<?php /* DRAFT COPY — review before launch */
/* Season — the timeline idiom. Six months of one campaign season on a 26-week board: waves that start
   and finish, always-on lanes that do not, and the moments everything is timed around. Bars are
   positioned from the week numbers below, so the shape is data rather than drawing. Wide, so on a
   phone it scrolls inside .bdh-scroll-x with a role and a label. Bars grow with .bdh-grow once the
   section is revealed, and the noscript rule in partials/head.php leaves them at full width without
   JavaScript.
   PLACEHOLDER: the week numbers are a typical shape for a season of this size, not a commitment. */
$se_weeks = 26;
/* [lane, stage key, [ [label, from, to, open?] … ] ] */
$se_lanes = [
    ['Plan',        'decide',  [['Channel roles, message sequence, budget', 1, 6, false]]],
    ['System',      'build',   [['Campaign platform, templates, message matrix', 4, 13, false], ['Market toolkits', 14, 17, false]]],
    ['Production',  'build',   [['Shoot wave 1', 7, 13, false], ['Shoot wave 2', 18, 22, false]]],
    ['Editorial',   'publish', [['Cluster 01', 6, 12, false], ['Cluster 02', 14, 20, false], ['Cluster 03', 21, 26, true]]],
    ['Social',      'publish', [['Always-on, with a reactive slot each week', 9, 26, true]]],
    ['Earned',      'reach',   [['Narrative and media list', 5, 10, false], ['Announcement', 13, 16, false], ['Category argument', 19, 24, false]]],
    ['Creators',    'reach',   [['Activation 01', 12, 18, false], ['Activation 02', 21, 26, true]]],
    ['Paid',        'reach',   [['Measurement layer', 3, 7, false], ['Always-on, holdout held back', 8, 26, true]]],
    ['Measure',     'decide',  [['Baseline', 1, 3, false], ['First read', 12, 14, false], ['Quarterly review', 23, 26, false]]],
];
$se_moments = [
    [13, 'Launch',           'Everything built before this week, nothing after it left to chance'],
    [20, 'Category report',  'A data story the press and the answer engines can both quote'],
    [26, 'Quarterly review', 'The plan corrected by performance, not by debate'],
];
$se_left  = fn (int $se_a): float => round(($se_a - 1) / $se_weeks * 100, 3);
$se_width = fn (int $se_a, int $se_b): float => round(($se_b - $se_a + 1) / $se_weeks * 100, 3);
$se_notes = [
    ['One shoot, a season of content', 'Productions are planned against the channel calendar, so a single day on set feeds months of publishing instead of one campaign.', 'global-content-production'],
    ['Clusters compound',              'Internal linking and a quarterly refresh make the pieces published in month one work harder in month six. New clusters typically take three to six months to compound.', 'content-marketing'],
    ['The holdout is left alone',       'Paid runs always-on, but the geo holdout is never switched on for a quarter-end push, because that is the only way the lift stays measurable.', 'performance-marketing'],
];
?>
<section class="band cch-season" id="season" aria-labelledby="season-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The season</p>
        <h2 class="h2" id="season-t"><span class="g">A burst is a cost.</span> A season compounds.</h2>
      </div>
      <div>
        <p class="lead">Campaigns are planned as a season with waves, moments and an always-on floor underneath. Six months of that shape, with the weeks it usually takes and the dates everything else is timed around.</p>
      </div>
    </div>

    <div class="cch-se" data-rv data-rv-d="60">
      <p class="cch-se__legend" aria-hidden="true">
        <span><i class="cch-se__sw"></i>A wave, with an end</span>
        <span><i class="cch-se__sw is-open"></i>Always-on, no end date</span>
        <span><i class="cch-se__sw is-pin"></i>A moment everything is timed around</span>
      </p>

      <div class="bdh-scroll-x cch-se__scroll" tabindex="0" role="group" aria-label="A 26-week campaign season, nine workstreams. Scroll sideways to see the later weeks.">
        <div class="cch-se__board">
          <p class="cch-se__scale" aria-hidden="true">
            <span class="cch-se__lk"></span>
            <span class="cch-se__track cch-se__ruler">
              <?php for ($se_w = 1; $se_w <= $se_weeks; $se_w++): ?>
                <i class="cch-se__tick<?= ($se_w === 1 || $se_w % 4 === 0) ? ' is-lbl' : '' ?>" style="left:<?= $se_left($se_w) ?>%"></i>
                <?php if ($se_w === 1 || $se_w % 4 === 0): ?><span class="cch-se__wk" style="left:<?= $se_left($se_w) ?>%">wk <?= $se_w ?></span><?php endif; ?>
              <?php endfor; ?>
              <?php foreach ($se_moments as $se_m): $se_x = $se_left($se_m[0]); ?>
                <b class="cch-se__pin<?= $se_x > 78 ? ' is-end' : '' ?>" style="left:<?= $se_x ?>%"><?= e($se_m[1]) ?></b>
              <?php endforeach; ?>
            </span>
          </p>

          <?php foreach ($se_lanes as $se_li => $se_l): ?>
            <p class="cch-se__lane" style="--i:<?= $se_li ?>">
              <span class="cch-se__lk"><b><?= e($se_l[0]) ?></b><small><?= e($CCH['stages'][$se_l[1]]['name']) ?></small></span>
              <span class="cch-se__track">
                <?php foreach ($se_moments as $se_m): ?>
                  <i class="cch-se__grid" aria-hidden="true" style="left:<?= $se_left($se_m[0]) ?>%"></i>
                <?php endforeach; ?>
                <?php foreach ($se_l[2] as $se_bi => $se_b): ?>
                  <span class="cch-se__bar<?= $se_b[3] ? ' is-open' : '' ?> bdh-grow" style="left:<?= $se_left($se_b[1]) ?>%;width:<?= $se_width($se_b[1], $se_b[2]) ?>%;--i:<?= $se_li * 2 + $se_bi ?>">
                    <em><?= e($se_b[0]) ?></em>
                  </span>
                <?php endforeach; ?>
              </span>
            </p>
          <?php endforeach; ?>
        </div>
      </div>

      <p class="cch-note cch-se__note">Week numbers show a typical shape for a season of this size. Every plan is scoped with your team, and the calendar keeps a reactive slot each week for whatever the category is actually talking about.</p>
    </div>

    <div class="cch-se__moments" data-rv data-rv-d="90">
      <?php foreach ($se_moments as $se_mi => $se_m): ?>
        <div class="cch-se__mo">
          <p class="cch-k">Week <?= (int) $se_m[0] ?></p>
          <h3 class="cch-se__mt"><?= e($se_m[1]) ?></h3>
          <p class="cch-se__md"><?= e($se_m[2]) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cch-se__notes" data-rv data-rv-d="120">
      <?php foreach ($se_notes as $se_n): $se_c = $CAPS[$se_n[2]]; ?>
        <div class="cch-se__nc">
          <h3 class="cch-se__nt"><?= e($se_n[0]) ?></h3>
          <p class="cch-se__nd"><?= e($se_n[1]) ?></p>
          <p class="cch-capls"><a class="cch-capl" href="#<?= e($se_n[2]) ?>"><b><?= e($se_c['n']) ?></b><?= e($se_c['short']) ?><i aria-hidden="true">›</i></a></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
