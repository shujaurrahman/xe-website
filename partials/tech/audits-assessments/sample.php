<?php /* DRAFT COPY — review before launch */
/* Sample — what the report actually looks like. Five code-built report pages (cover, executive
   summary, a findings entry in full, the fix roadmap, the evidence appendix) fanned as a stack,
   moved with real previous and next buttons and a page index.
   Without JavaScript the five pages simply read down the page in order; sample.js turns them into
   the stack and shows the controls. Figures match the register and the cost model elsewhere on
   this page, and every one of them is illustrative. */

$taa_sm_pages = [  // [key, name, page number printed on the sheet]
    ['cover',    'Cover',             '01'],
    ['summary',  'Executive summary', '03'],
    ['finding',  'Findings detail',   '14'],
    ['roadmap',  'Fix roadmap',       '28'],
    ['evidence', 'Evidence appendix', '35'],
];
$taa_sm_n = count($taa_sm_pages);

$taa_sm_sev = [['Critical', 2], ['High', 7], ['Medium', 12], ['Low', 16]];

$taa_sm_lanes = [
    ['Days 0–30', 'Now', 11, 'Risk closed + $20,900 / month', [
        ['SEC-01', 'MFA and IP allow-listing on the admin console'],
        ['SEC-04', 'Patch the payment-service dependency, then re-scan'],
        ['SEO-05', 'Remove the legacy noindex from the product template'],
        ['CLD-02', 'Right-size two database instances against p95'],
    ]],
    ['Days 31–60', 'Next', 13, '$33,000 / month', [
        ['TA-03',  'Checkout LCP: defer the payment script, server-render the summary'],
        ['DAT-02', 'Durable queue with a dead-letter path for order events'],
        ['ACC-01', 'Label every checkout form field (WCAG 2.2 AA, 1.3.1)'],
    ]],
    ['Days 61–90', 'Later', 7, 'Prerequisites for the AI programme', [
        ['AI-02',  'De-duplicate the knowledge base, add freshness checks'],
        ['GOV-01', 'Model register and approval gate before the next pilot'],
    ]],
];

$taa_sm_ev = [  // [ref, artefact, source, captured, finding]
    ['E-014', '28-day field export, mobile',        'Chrome UX Report',    'Day 04', 'TA-03'],
    ['E-015', 'Lab trace and filmstrip',            'Lighthouse',          'Day 04', 'TA-03'],
    ['E-022', 'Authenticated scan report',          'Burp Suite',          'Day 09', 'SEC-01'],
    ['E-023', 'SBOM with CVE match, CVSS v3.1',     'Trivy',               'Day 09', 'SEC-04'],
    ['E-031', 'Coverage export vs full crawl',      'Search Console',      'Day 11', 'SEO-05'],
    ['E-040', 'Profiling notebook, null and duplicate rates', 'Python · Jupyter', 'Day 12', 'AI-02'],
];
?>
<section class="band taa-sam" id="sample" aria-labelledby="sample-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">08</span><span>The report</span></p>
        <h2 class="h2" id="sample-t"><span class="g">What the report</span> looks like.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Five pages from a combined audit, built here rather than photographed. The document is written to be read twice: once by a board in four pages, once by the engineers who have to act on it, in as much detail as the fix needs.</p>
      </div>
    </header>

    <div class="taa-sam__rig" data-taa-sam>

      <ol class="taa-sam__pages" data-taa-sam-pages>

        <li class="taa-sam__pg" id="sample-pg-1" role="group" aria-roledescription="report page" aria-label="Page 1 of <?= (int) $taa_sm_n ?>: Cover">
          <article class="taa-sam__sheet taa-sam__sheet--cover">
            <header class="taa-sam__ph"><span>Combined technology audit</span><span>Confidential</span></header>
            <div class="taa-sam__pb taa-sam__cov">
              <div class="taa-sam__covt">
                <p class="taa-lbl">Audit report · v1.0</p>
                <h3 class="taa-sam__h">Combined technology audit</h3>
                <p class="taa-sam__covs">Technical &amp; performance · Security · Data &amp; analytics · SEO &amp; AI visibility · AI readiness</p>
                <!-- PLACEHOLDER: confirm reporting period and version conventions before launch -->
                <dl class="taa-sam__covm">
                  <div><dt>Prepared for</dt><dd>Your company</dd></div>
                  <div><dt>Prepared by</dt><dd><?= e($SITE['name'] ?? 'Xterra Edze') ?></dd></div>
                  <div><dt>Period</dt><dd>Kick-off to readout</dd></div>
                  <div><dt>Classification</dt><dd>Named recipients only</dd></div>
                </dl>
              </div>
              <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
              <figure class="taa-sam__covi">
                <img src="<?= xe_url('assets/imgs/tech/audits-assessments/sample-cover-architecture.jpg') ?>" width="525" height="700"
                     alt="The corner of a glass office building against a deep sky, its lines converging upward" loading="lazy" decoding="async">
              </figure>
            </div>
            <footer class="taa-sam__pf"><span>Findings register · 37 findings</span><span>Page 01 of 42</span></footer>
          </article>
        </li>

        <li class="taa-sam__pg" id="sample-pg-2" role="group" aria-roledescription="report page" aria-label="Page 2 of <?= (int) $taa_sm_n ?>: Executive summary">
          <article class="taa-sam__sheet">
            <header class="taa-sam__ph"><span>1. Executive summary</span><span>Confidential</span></header>
            <div class="taa-sam__pb">
              <h3 class="taa-sam__h">Executive summary</h3>
              <ul class="taa-sam__sev" role="list">
                <li class="taa-sam__sevt"><b>37</b> findings</li>
                <?php foreach ($taa_sm_sev as $taa_sm_s): ?>
                  <li><span><?= e($taa_sm_s[0]) ?></span><b><?= (int) $taa_sm_s[1] ?></b></li>
                <?php endforeach; ?>
              </ul>
              <ul class="bdh-bullets taa-sam__bul" role="list">
                <li>Two findings need attention this week: an admin console reachable from the public internet without MFA, and a known vulnerability in a payment-service dependency.</li>
                <li>Checkout is the largest single revenue line. Mobile LCP is 4.6 s at the 75th percentile against a good threshold of 2.5 s, and the slower cohort converts 0.29 points lower.</li>
                <li>Modelled recoverable value is <b>$61,200 a month</b> — 4.9% of monthly digital revenue — for 31 engineering days of remediation.</li>
                <li>AI readiness is held back by governance rather than technology. There is no model register and no approval gate; the use cases themselves are sound.</li>
              </ul>
              <p class="taa-sam__rec"><b>Recommendation.</b> Take the Now lane — eleven engineering days — before the next release train. It closes both critical findings and recovers $20,900 a month without touching the checkout code path.</p>
            </div>
            <footer class="taa-sam__pf"><span>Severity counts as at readout</span><span>Page 03 of 42</span></footer>
          </article>
        </li>

        <li class="taa-sam__pg" id="sample-pg-3" role="group" aria-roledescription="report page" aria-label="Page 3 of <?= (int) $taa_sm_n ?>: Findings detail">
          <article class="taa-sam__sheet">
            <header class="taa-sam__ph"><span>3.2 Findings · Performance</span><span>TA-03</span></header>
            <div class="taa-sam__pb">
              <h3 class="taa-sam__h taa-sam__h--f"><span class="taa-id">TA-03</span> Checkout LCP is 4.6 s on mobile at the 75th percentile</h3>
              <dl class="taa-sam__fm">
                <div><dt>Severity</dt><dd>High</dd></div>
                <div><dt>Component</dt><dd>web / checkout</dd></div>
                <div><dt>Owner</dt><dd>Web platform</dd></div>
                <div><dt>Effort</dt><dd>8 eng. days</dd></div>
                <div><dt>Fix order</dt><dd>02</dd></div>
              </dl>
              <div class="taa-sam__fg">
                <section class="taa-sam__fs" aria-label="Evidence">
                  <p class="taa-lbl">Evidence</p>
                  <ul role="list">
                    <li>Field data, 28-day window: LCP p75 4.6 s, INP p75 240 ms, CLS 0.04 (mobile)</li>
                    <li>Lab trace: 1.9 s blocked on a third-party payment script loaded in the head</li>
                    <li>Analytics cohort: 1.42% conversion above 4 s against 1.71% below 2.5 s</li>
                    <li>Filmstrip captured at 2.0 s, 3.0 s and 4.6 s (appendix E-014, E-015)</li>
                  </ul>
                </section>
                <section class="taa-sam__fs" aria-label="Reproduction">
                  <p class="taa-lbl">Reproduction</p>
                  <ol role="list">
                    <li>Throttle to Slow 4G on a mid-range Android profile</li>
                    <li>Load /checkout cold, cache disabled, from a cold CDN edge</li>
                    <li>Record LCP — the element is the order-summary card</li>
                  </ol>
                </section>
              </div>
              <p class="taa-sam__fr"><b>Rating rationale.</b> High, not critical: revenue is affected continuously, but no data and no availability is at risk. Core Web Vitals count as good at LCP ≤ 2.5 s, INP ≤ 200 ms and CLS ≤ 0.1; this journey fails one of the three.</p>
              <p class="taa-sam__fr"><b>Recommendation.</b> Defer the payment script until interaction, self-host the two web fonts, and server-render the order summary. Re-test against field data after two weeks of collection, not against a lab score.</p>
            </div>
            <footer class="taa-sam__pf"><span>Every finding carries evidence, reproduction, rationale and an owner</span><span>Page 14 of 42</span></footer>
          </article>
        </li>

        <li class="taa-sam__pg" id="sample-pg-4" role="group" aria-roledescription="report page" aria-label="Page 4 of <?= (int) $taa_sm_n ?>: Fix roadmap">
          <article class="taa-sam__sheet">
            <header class="taa-sam__ph"><span>5. Fix roadmap</span><span>Confidential</span></header>
            <div class="taa-sam__pb">
              <h3 class="taa-sam__h">Fix roadmap — 30, 60, 90 days</h3>
              <div class="taa-sam__lanes">
                <?php foreach ($taa_sm_lanes as $taa_sm_l): ?>
                  <section class="taa-sam__lane" aria-label="<?= e($taa_sm_l[1]) ?>, <?= e($taa_sm_l[0]) ?>">
                    <p class="taa-sam__lh"><b><?= e($taa_sm_l[1]) ?></b><span><?= e($taa_sm_l[0]) ?></span></p>
                    <ul role="list">
                      <?php foreach ($taa_sm_l[4] as $taa_sm_it): ?>
                        <li><span class="taa-id"><?= e($taa_sm_it[0]) ?></span><?= e($taa_sm_it[1]) ?></li>
                      <?php endforeach; ?>
                    </ul>
                    <p class="taa-sam__lf"><span><?= (int) $taa_sm_l[2] ?> eng. days</span><span><?= e($taa_sm_l[3]) ?></span></p>
                  </section>
                <?php endforeach; ?>
              </div>
              <p class="taa-sam__note">Dependencies are respected: the payment dependency is patched before the checkout work touches the same service, and the knowledge-base clean-up precedes any retrieval build. Totals: 31 engineering days, $61,200 a month recovered on the model.</p>
            </div>
            <footer class="taa-sam__pf"><span>Ordered by value per engineering day, dependencies respected</span><span>Page 28 of 42</span></footer>
          </article>
        </li>

        <li class="taa-sam__pg" id="sample-pg-5" role="group" aria-roledescription="report page" aria-label="Page 5 of <?= (int) $taa_sm_n ?>: Evidence appendix">
          <article class="taa-sam__sheet">
            <header class="taa-sam__ph"><span>Appendix E · Evidence</span><span>Confidential</span></header>
            <div class="taa-sam__pb">
              <h3 class="taa-sam__h">Evidence appendix</h3>
              <div class="taa-sam__scroll bdh-scroll-x">
                <table class="taa-tbl taa-sam__tbl">
                  <caption class="bdh-sr">Evidence artefacts retained for the audit, with the instrument that produced each one, the day it was captured and the finding it supports.</caption>
                  <thead>
                    <tr><th scope="col">Ref</th><th scope="col">Artefact</th><th scope="col">Instrument</th><th scope="col">Captured</th><th scope="col">Finding</th></tr>
                  </thead>
                  <tbody>
                    <?php foreach ($taa_sm_ev as $taa_sm_e): ?>
                      <tr>
                        <th scope="row" class="taa-id"><?= e($taa_sm_e[0]) ?></th>
                        <td><?= e($taa_sm_e[1]) ?></td>
                        <td class="taa-sam__src"><?= e($taa_sm_e[2]) ?></td>
                        <td class="taa-n"><?= e($taa_sm_e[3]) ?></td>
                        <td class="taa-n"><span class="taa-id"><?= e($taa_sm_e[4]) ?></span></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <p class="taa-sam__note">Every artefact is handed over with the report and retained for twelve months. Raw scan output is never shipped: each line above was reproduced by a person before the finding it supports was written.</p>
            </div>
            <footer class="taa-sam__pf"><span>6 of 148 artefacts shown</span><span>Page 35 of 42</span></footer>
          </article>
        </li>

      </ol>

      <div class="taa-sam__ctl" data-taa-sam-ctl>
        <button type="button" class="taa-sam__arw" data-taa-sam-prev aria-label="Previous report page"><span aria-hidden="true">‹</span></button>
        <ol class="taa-sam__ix" role="list">
          <?php foreach ($taa_sm_pages as $taa_sm_i => $taa_sm_p): ?>
            <li>
              <button type="button" data-taa-sam-go="<?= (int) $taa_sm_i ?>"<?= $taa_sm_i === 0 ? ' aria-current="true"' : '' ?>>
                <span class="taa-sam__ixn"><?= str_pad((string) ($taa_sm_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="taa-sam__ixl"><?= e($taa_sm_p[1]) ?></span>
              </button>
            </li>
          <?php endforeach; ?>
        </ol>
        <button type="button" class="taa-sam__arw" data-taa-sam-next aria-label="Next report page"><span aria-hidden="true">›</span></button>
      </div>

      <p class="bdh-sr" role="status" aria-live="polite" data-taa-sam-live></p>
      <p class="bdh-sr">The five pages are shown as a stack with the current page in front and the next pages fanned behind it. Each page can also be opened from the index above.</p>

      <p class="taa-sam__foot">
        <span class="taa-est">Illustrative</span>
        <span>A sample document for a fictional company. The full report runs to roughly forty pages, of which about six are the executive summary and the roadmap — the part most people read. What it is not is a scanner export with a cover sheet.</span>
      </p>

    </div>

  </div>
</section>
