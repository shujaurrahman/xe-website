<?php /* DRAFT COPY — review before launch */
/* Hero — the findings register. The breadcrumb runs along the top, then the headline block (cols 1–8)
   with the lead and the two calls to action beneath it. Under that, full bleed inside the wrap, the
   register itself: a severity summary bar and an eight-row table with the columns an audit readout
   actually has — ID, area, finding, severity, estimated monthly cost, effort in engineering days and
   fix order. hero.js sweeps a scan line down the rows once on entry and upgrades the four numeric
   column headers into sort controls, so the register behaves like the software it depicts. The
   headers ship as plain text, so without JS there is no dead control and the table still reads in
   fix order — which is the order the page argues for. */
$taa_hr_sum = [   // [severity key, count, label]
    ['critical', 2,  'Critical'],
    ['high',     7,  'High'],
    ['medium',  12,  'Medium'],
    ['low',     16,  'Low'],
];
$taa_hr_rows = [  // [id, area, finding, severity, monthly cost est., effort days, fix order]
    ['SEC-01', 'Security',    'Admin console reachable from the public internet without MFA',        'critical', 'Rated',    2, 1],
    ['TA-03',  'Performance', 'Checkout LCP 4.6 s on mobile 75th percentile (target ≤ 2.5 s)',        'high',     '$18,400',  8, 2],
    ['SEC-04', 'Security',    'Dependency with a known CVE in the payment service (CVSS 8.1)',        'critical', 'Rated',    1, 3],
    ['DAT-02', 'Data',        'Order events dropped when the queue backs up — 3.1% loss last month',  'high',     '$9,200',   5, 4],
    ['SEO-05', 'Search',      'Product pages return 200 with a noindex tag from a legacy template',   'high',     '$11,700',  3, 5],
    ['CLD-02', 'Cloud',       'Two oversized database instances idle above 80% of the month',         'medium',   '$4,300',   2, 6],
    ['AI-02',  'AI readiness','Knowledge base 40% duplicated — retrieval returns conflicting answers','medium',   'Rated',    6, 7],
    ['ACC-01', 'Accessibility','Checkout form fields without labels — WCAG 2.2 AA failure (1.3.1)',   'high',     '$7,600',   4, 8],
];
$taa_hr_sevp = ['critical' => 4, 'high' => 3, 'medium' => 2, 'low' => 1];
$taa_hr_meta = [];
foreach ($CAP['meta_k'] as $taa_hmk => $taa_hmv) { $taa_hr_meta[] = [$taa_hmv, $CAP['meta'][$taa_hmk] ?? '']; }
unset($taa_hmk, $taa_hmv);
$taa_hr_total = array_sum(array_column($taa_hr_sum, 1));
?>
<section class="taa-hero" id="top" aria-labelledby="hero-t">
  <span class="taa-hero__wall dots" aria-hidden="true"></span>
  <div class="wrap">

    <nav class="taa-crumb" aria-label="Breadcrumb">
      <ol>
        <li><a href="<?= xe_url('services/') ?>">Services</a></li>
        <li><a href="<?= xe_url('services/technology-intelligence.php') ?>"><?= e($TECH['name'] ?? 'Technology &amp; Intelligence') ?></a></li>
        <li><span aria-current="page"><?= e($CAP['name']) ?></span></li>
      </ol>
    </nav>

    <div class="taa-hero__top">
      <div class="taa-hero__t">
        <p class="taa-kick"><span class="taa-kick__ref">Capability 09 / 10</span><span>What is broken, what it costs, what first</span></p>
        <h1 class="taa-hero__h" id="hero-t"><span class="g">What is broken, what it is costing you,</span> and what to fix first.</h1>
      </div>
      <div class="taa-hero__side">
        <p class="lead taa-hero__lead">Technical, SEO, security, data and AI-readiness audits that end in one register: every finding evidenced, rated, costed and placed in a fix order your team can start on Monday.</p>
        <div class="taa-hero__act">
          <a class="btn btn--ink btn--lg" href="<?= xe_url('contact.php') ?>"><?= e($CAP['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
          <a class="btn btn--out btn--lg" href="#fixplan">Try the fix-order planner <span class="i" aria-hidden="true">›</span></a>
        </div>
      </div>
    </div>

    <div class="taa-reg taa-win" data-taa-reg>
      <div class="taa-win__bar">
        <span class="taa-win__t"><b>Findings register</b> · Your company · combined audit · sample extract</span>
        <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i><b data-bdh-count><?= (int) $taa_hr_total ?></b> findings</span>
        <span class="taa-win__st">Showing <?= count($taa_hr_rows) ?> of <?= (int) $taa_hr_total ?> · ranked by <span data-taa-rank>fix order</span></span>
      </div>

      <div class="taa-reg__sum" aria-hidden="true">
        <?php foreach ($taa_hr_sum as $taa_hs): ?>
          <span class="taa-reg__s" data-s="<?= e($taa_hs[0]) ?>" style="--n:<?= (int) $taa_hs[1] ?>">
            <b><?= e($taa_hs[2]) ?></b><span class="taa-num"><?= (int) $taa_hs[1] ?></span>
            <i class="taa-reg__sbar"><em style="--p:<?= number_format($taa_hs[1] / $taa_hr_total, 3) ?>"></em></i>
          </span>
        <?php endforeach; ?>
      </div>
      <p class="bdh-sr">Severity summary for the sample register: 2 critical, 7 high, 12 medium and 16 low findings, 37 in total.</p>

      <div class="taa-reg__scroll bdh-scroll-x" tabindex="0" role="group" aria-labelledby="hero-reg-t">
        <p class="bdh-sr" id="hero-reg-t">Sample findings register, scrollable sideways</p>
        <table class="taa-tbl taa-reg__tbl">
          <caption class="bdh-sr">An illustrative extract from a combined audit of “Your company”: eight findings with severity, estimated monthly cost, effort in engineering days and fix order. Figures are illustrative.</caption>
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Area</th>
              <th scope="col">Finding</th>
              <th scope="col">Severity</th>
              <th scope="col">Monthly cost (est.)</th>
              <th scope="col">Effort</th>
              <th scope="col">Fix order</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($taa_hr_rows as $taa_hi => $taa_hr): ?>
              <tr class="<?= $taa_hr[6] <= 3 ? 'is-top' : '' ?>" style="--i:<?= (int) $taa_hi ?>"
                  data-sev="<?= (int) ($taa_hr_sevp[$taa_hr[3]] ?? 1) ?>"
                  data-cost="<?= (int) preg_replace('/[^0-9]/', '', $taa_hr[4]) ?>"
                  data-eff="<?= (int) $taa_hr[5] ?>" data-order="<?= (int) $taa_hr[6] ?>">
                <td class="taa-id"><?= e($taa_hr[0]) ?></td>
                <td class="taa-reg__area"><?= e($taa_hr[1]) ?></td>
                <th scope="row" class="taa-reg__f"><?= e($taa_hr[2]) ?></th>
                <td><?= taa_sev($taa_hr[3]) ?></td>
                <td class="taa-n taa-reg__c"><?= e($taa_hr[4]) ?></td>
                <td class="taa-n"><?= (int) $taa_hr[5] ?> d</td>
                <td class="taa-n"><span class="taa-reg__o"><?= (int) $taa_hr[6] ?></span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <span class="taa-reg__scan" aria-hidden="true"></span>
      </div>

      <p class="taa-reg__foot">
        <span class="taa-est">Illustrative</span>
        <span>Costs are modelled from your own analytics, cloud bills and engineering rates. Items marked <b>Rated</b> are risk we will not price — a breach is a probability, not a monthly line. The sixteen findings the audit recommends scheduling this quarter drive the fix-order planner below, priced the same way.</span>
      </p>
    </div>

    <!-- PLACEHOLDER: confirm typical audit length and commercial terms before launch -->
    <dl class="taa-hero__meta">
      <?php foreach ($taa_hr_meta as $taa_hm): ?>
        <div><dt><?= e($taa_hm[0]) ?></dt><dd><?= e($taa_hm[1]) ?></dd></div>
      <?php endforeach; ?>
    </dl>

  </div>
</section>
