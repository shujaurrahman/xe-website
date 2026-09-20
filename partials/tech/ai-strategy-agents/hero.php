<?php /* DRAFT COPY — review before launch */
/* Hero — the mission board. Diagonal composition: the breadcrumb runs along the top; the board holds
   the top right (cols 5–12) with a compact autonomy legend beside it; the headline card anchors the
   lower left (cols 1–6) and overlaps the board's lower-left edge, where the Queued column keeps its
   second slot empty; the meta readouts sit lower right, under the board.
   hero.js moves cards between columns while on screen. The HTML is the finished board. */
$tas_hr_cols = [   // [key, label, short label (1024–1279), WIP limit or null, small note]
    ['queued',   'Queued',         'Queued',   null, 'next up'],
    ['working',  'Agent working',  'Working',  2,    'WIP 2'],
    ['approval', 'Needs approval', 'Approval', 2,    'WIP 2'],
    ['done',     'Done',           'Done',     null, 'today'],
];
$tas_hr_steps = ['plan', 'retrieve', 'read', 'calculate', 'draft', 'check', 'write'];
$tas_hr_cards = [  // [id, mission, owner role, agent, level, spend, cap, step, steps, column]
    ['M-214', 'Draft renewal quotes',         'Sales ops',    'renewals-agent',  3, '0.00', '0.40', 0, 7, 'queued'],
    ['M-209', 'Reconcile vendor invoices',    'Finance lead', 'ap-reconciler',   4, '0.12', '0.30', 5, 7, 'working'],
    ['M-211', 'Triage inbound RFPs',          'Bid manager',  'rfp-triage',      2, '0.07', '0.25', 3, 6, 'working'],
    ['M-207', 'Resolve billing dispute 4471', 'Service lead', 'billing-agent',   3, '0.02', '0.10', 7, 7, 'approval'],
    ['M-201', 'Summarise shift handovers',    'Ops manager',  'shift-copilot',   1, '0.01', '0.05', 4, 4, 'done'],
    ['M-198', 'Prepare Q3 board pack',        'CFO office',   'boardpack-agent', 2, '0.24', '0.50', 7, 7, 'done'],
];
$tas_hr_levels = [   // [level, name, a short gloss]
    [1, 'Suggest',           'recommends only'],
    [2, 'Draft',             'a person sends it'],
    [3, 'Act with approval', 'a person approves'],
    [4, 'Act within limits', 'escalates outside'],
];
/* The lead is set here rather than read from $CAP['lead'], which repeats the h1 almost word for word
   (shared change requested in data/technology-intelligence.php). Meta labels and scope come from the
   data file; the timeframe matches this page's pace and process sections (strategy and first agent
   chosen by week 3, first agent live at L3 by week 8); the data file still says "6-week strategy ·
   12-week pilot" and needs the same shared change. */
$tas_hr_lead = 'We rank your use cases by value, feasibility and risk, then build the first agents with guardrails, evals and a person approving what matters.';
$tas_hr_meta = [];
foreach ($CAP['meta_k'] as $tas_mk => $tas_mv) { $tas_hr_meta[] = [$tas_mv, $CAP['meta'][$tas_mk] ?? '']; }
unset($tas_mk, $tas_mv);
if (isset($tas_hr_meta[0])) { $tas_hr_meta[0][1] = 'Strategy in 3 weeks · first agent live by week 8'; }   // PLACEHOLDER: confirm typical timeframes
/* one card: every row has a fixed height, so the board never changes size while cards move */
$tas_hr_state = ['queued' => 'Next in line', 'working' => 'Running', 'approval' => 'Needs approval', 'done' => 'Closed'];
$tas_hr_card = function (array $c) use ($tas_hr_steps, $tas_hr_state) {
    $pct = (float) $c[6] > 0 ? min(1, (float) $c[5] / (float) $c[6]) : 0;
    $sub = $c[9] === 'working' ? ' · ' . ($tas_hr_steps[min($c[7], count($tas_hr_steps) - 1)] ?? '') : ($c[9] === 'done' ? ' · logged' : '');
    ob_start(); ?>
        <li class="tas-mc" data-st="<?= e($c[9]) ?>" data-id="<?= e($c[0]) ?>">
          <span class="tas-mc__top"><span class="tas-mc__agent"><?= e($c[3]) ?></span><span class="tas-mc__id"><?= e($c[0]) ?></span><?= tas_lvl($c[4], ['short' => true]) ?></span>
          <span class="tas-mc__t"><?= e($c[1]) ?></span>
          <span class="tas-mc__who"><span class="tas-mc__idw"><?= e($c[0]) ?></span><span class="tas-mc__role"><?= e($c[2]) ?></span></span>
          <span class="tas-mc__ro"><span>$<b data-spend><?= e($c[5]) ?></b> / $<?= e($c[6]) ?></span><span class="tas-mc__step">step <b data-step><?= (int) $c[7] ?></b>/<?= (int) $c[8] ?></span></span>
          <span class="tas-mc__bar"><i style="--p:<?= number_format($pct, 3) ?>"></i></span>
          <span class="tas-mc__st"><i class="tas-mc__sd" aria-hidden="true"></i><span class="tas-mc__sl"><?= e($tas_hr_state[$c[9]] ?? '') ?></span><span class="tas-mc__ss"><?= e($sub) ?></span></span>
        </li>
    <?php return ob_get_clean();
};
?>
<section class="tas-hero" id="top" aria-labelledby="hero-t">
  <span class="tas-hero__wall dots" aria-hidden="true"></span>
  <div class="wrap">
    <nav class="tas-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology & Intelligence') ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>
  </div>
  <div class="wrap tas-hero__in">

    <div class="tas-hero__card">
      <p class="tas-hero__eb"><span class="tas-kick__ref">Capability 03 / 10</span><span><?= e($CAP['kicker']) ?></span></p>
      <h1 class="tas-hero__h" id="hero-t"><span class="g">Decide where AI fits.</span> Then put agents to work on it.</h1>
      <p class="lead tas-hero__lead"><?= e($tas_hr_lead) ?></p>
      <div class="tas-hero__act">
        <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>">Book an AI strategy session <span class="i" aria-hidden="true">›</span></a>
        <a class="btn btn--out btn--lg" href="#autonomy">Run an agent <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>

    <div class="tas-hero__board">
      <div class="tas-board" data-tas-board aria-hidden="true">
        <div class="tas-board__bar">
          <span class="tas-board__title"><b>Mission board</b> · Your company · Q3 portfolio</span>
          <span class="tas-board__stat"><i class="tas-led tas-led--pulse"></i><b data-board-run>2</b> <span data-board-runl>agents</span> running</span>
          <span class="tas-board__stat tas-board__stat--spend">Spend today <b>$41.20</b> / $120</span>
        </div>
        <div class="tas-board__cols">
          <?php foreach ($tas_hr_cols as $tas_hc):
              $tas_hcards = array_filter($tas_hr_cards, fn ($tas_x) => $tas_x[9] === $tas_hc[0]); ?>
            <div class="tas-board__col" data-col="<?= e($tas_hc[0]) ?>"<?= $tas_hc[3] ? ' data-wip="' . (int) $tas_hc[3] . '"' : '' ?>>
              <p class="tas-board__ch"><span class="tas-board__cl"><?= e($tas_hc[1]) ?></span><span class="tas-board__cs"><?= e($tas_hc[2]) ?></span><b data-count><?= count($tas_hcards) ?></b><small><?= e($tas_hc[4]) ?></small></p>
              <ul class="tas-board__list">
                <?php foreach ($tas_hcards as $tas_hcard) { echo $tas_hr_card($tas_hcard); } ?>
              </ul>
            </div>
          <?php endforeach; ?>
        </div>
        <p class="tas-board__tick"><span class="tas-board__time">10:42:07</span><span data-board-tick>M-207 · write step needs approval · credit $240 · sent to Service lead</span></p>
      </div>
      <p class="bdh-sr">An illustrative mission board for “Your company”. Six missions sit in four columns: queued, agent working, needs approval and done. Each card shows the agent, the person who owns the work, its autonomy level, spend against a budget and progress through its steps. A billing dispute waits for the Service lead to approve a $240 credit before the agent writes it.</p>
    </div>

    <div class="tas-hero__legend">
      <p class="tas-lbl">Autonomy levels on the board</p>
      <ol class="tas-hero__levels">
        <?php foreach ($tas_hr_levels as $tas_hl): ?>
          <li><?= tas_lvl($tas_hl[0], ['short' => true]) ?><b><?= e($tas_hl[1]) ?></b><small><?= e($tas_hl[2]) ?></small></li>
        <?php endforeach; ?>
      </ol>
    </div>

    <!-- PLACEHOLDER: confirm typical timeframes before launch -->
    <dl class="tas-hero__meta">
      <?php foreach ($tas_hr_meta as $tas_hm): ?>
        <div><dt><?= e($tas_hm[0]) ?></dt><dd><?= e($tas_hm[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

  </div>
</section>
