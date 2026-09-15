<?php /* DRAFT COPY — review before launch */
/* 09 Measurement defined up front — a KPI tree: one north-star, three drivers, leading indicators under
   each. Every node is a button that opens its definition (source, cadence, owner, baseline) in the
   reading panel. <!-- PLACEHOLDER: illustrative metrics, baselines and targets, confirm before launch --> */
$cgs_kp_star = ['New revenue from shortlisted segments', 'Revenue from customers in Segments C and D who were not customers at the start of the first move.', 'Finance ledger · CRM', 'Monthly', 'Growth lead', '£0 → £2.4m in 12 months'];
$cgs_kp_drivers = [ // name, definition, source, cadence, owner, baseline→target, indicators [[name, def, source, cadence, owner, target]]
    ['Qualified pipeline', 'Opportunities in C and D that meet the agreed qualification rules.', 'CRM', 'Weekly', 'Sales', '£0.3m → £6m', [
        ['Meetings booked in C', 'First meetings with decision-makers in Segment C.', 'CRM activity', 'Weekly', 'Sales', '40 per month'],
        ['Share of search in C', 'Your brand’s share of category searches from Segment C buyers.', 'Search data', 'Monthly', 'Marketing', '4% → 12%'],
    ]],
    ['Win rate', 'Closed-won as a share of qualified opportunities, per segment.', 'CRM', 'Monthly', 'Sales', '18% → 28%', [
        ['Pilot conversion in D', 'Partner-led pilots that convert to paid contracts.', 'CRM · partner reports', 'Monthly', 'Sales', '1 in 3'],
        ['Proof assets live', 'Published case material from first C customers.', 'Content log', 'Monthly', 'Marketing', '6 by Q2'],
    ]],
    ['Time to value', 'Days from contract signature to the customer’s first successful outcome.', 'Product analytics', 'Weekly', 'Product', '34 days → 5 days', [
        ['Onboarding completion', 'New accounts that finish onboarding within seven days.', 'Product analytics', 'Weekly', 'Product', '85%'],
        ['Early retention in C', 'Customers in C still active after 90 days.', 'Product analytics', 'Monthly', 'Product', '92%'],
    ]],
];
$cgs_kp_json = ['star' => $cgs_kp_star, 'drivers' => $cgs_kp_drivers];
$cgs_kp_node = function (string $id, string $level, array $n) {
    return '<button type="button" class="cgs-kp__node cgs-kp__node--' . $level . '" data-cgs-node="' . e($id) . '" aria-pressed="' . ($id === 's' ? 'true' : 'false') . '" aria-controls="kpi-read">'
        . '<span class="cgs-kp__lv">' . ['star' => 'North star', 'driver' => 'Driver', 'lead' => 'Leading'][$level] . '</span>'
        . '<span class="cgs-kp__nm">' . e($n[0]) . '</span>'
        . '<span class="cgs-kp__tg">' . e($n[5]) . '</span></button>';
};
?>
<section class="band cgs-kpi" id="kpi" aria-labelledby="kpi-t">
  <!-- PLACEHOLDER: illustrative metrics, baselines and targets, confirm before launch -->
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>09</b><i></i><?= e($CAP['offer'][5][0]) ?> · <?= e($CAP['offer'][5][2]) ?></p>
        <h2 class="h2" id="kpi-t"><span class="g">Agree the numbers</span> before the first move ships.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead"><?= e($CAP['offer'][5][1]) ?> One north-star, the drivers that move it, and the early signals that show up first.</p>
        <span class="cgs-illus">Illustrative metrics</span>
      </div>
    </div>

    <div class="cgs-kp" data-cgs-kpi data-tree='<?= e(json_encode($cgs_kp_json)) ?>'>
      <div class="cgs-kp__tree">
        <svg class="cgs-kp__wires" aria-hidden="true" focusable="false"><g data-cgs-wires></g></svg>
        <div class="cgs-kp__row cgs-kp__row--star"><?= $cgs_kp_node('s', 'star', $cgs_kp_star) ?></div>
        <div class="cgs-kp__row cgs-kp__row--drivers">
          <?php foreach ($cgs_kp_drivers as $cgs_di => $cgs_dv): ?>
            <div class="cgs-kp__branch" data-cgs-branch="<?= $cgs_di ?>">
              <?= $cgs_kp_node('d' . $cgs_di, 'driver', $cgs_dv) ?>
              <div class="cgs-kp__leaves">
                <?php foreach ($cgs_dv[6] as $cgs_li => $cgs_lf): ?><?= $cgs_kp_node('d' . $cgs_di . 'l' . $cgs_li, 'lead', $cgs_lf) ?><?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <aside class="cgs-kp__read" id="kpi-read" aria-live="polite">
        <p class="cgs-kp__rk" data-cgs-rk>North star</p>
        <h3 class="cgs-kp__rt" data-cgs-rt><?= e($cgs_kp_star[0]) ?></h3>
        <p class="cgs-kp__rd" data-cgs-rd><?= e($cgs_kp_star[1]) ?></p>
        <dl class="cgs-kp__spec">
          <div><dt>Source</dt><dd data-cgs-r2><?= e($cgs_kp_star[2]) ?></dd></div>
          <div><dt>Cadence</dt><dd data-cgs-r3><?= e($cgs_kp_star[3]) ?></dd></div>
          <div><dt>Owner</dt><dd data-cgs-r4><?= e($cgs_kp_star[4]) ?></dd></div>
          <div><dt>Baseline → target</dt><dd data-cgs-r5><?= e($cgs_kp_star[5]) ?></dd></div>
        </dl>
        <p class="cgs-kp__who"><b>Agent</b> pulls baselines from your systems and flags gaps. <b>People</b> agree each definition and target before launch.</p>
      </aside>
    </div>
  </div>
</section>
