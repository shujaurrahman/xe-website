<?php /* DRAFT COPY — review before launch */
/* Industries — different constraints in every sector. A list-detail: eight sectors as a vertical tablist; each
   pane has a photograph with a readout of the constraint that shapes the build, the four constraints
   (regulation, data residency, latency and scale, AI oversight), the capabilities most used (links), the
   frameworks that apply (code-built chips) and a typical first project. industries.js adds auto-advance
   until the first interaction; the photo and chips animate in on each switch (CSS).
   Regulatory references are summaries for orientation, not legal advice. */
$ind_url = fn (string $ind_s): string => xe_url('services/technology-intelligence/' . $ind_s . '.php');
$ind_by_n = [];
foreach ($TI as $ind_s => $ind_c) { $ind_by_n[$ind_c['n']] = $ind_s; }
$ind_rows = [
    ['finance', 'Financial services', 'PCI DSS · RBI · SEBI', 'industry-finance.jpg', 1400, 934, 'Trading screens and a tablet showing market charts on a desk', '50% 50%',
     'Money moves in milliseconds, and every decision needs an audit trail.',
     [['Regulation', 'PCI DSS v4.0.1 for card data, RBI directions on IT outsourcing, and SEBI\'s cybersecurity and cyber-resilience framework for market entities.'],
      ['Data residency', 'Payment-system data stored only in India under RBI\'s 2018 direction; customer data processed under the DPDP Act.'],
      ['Latency & scale', 'Payment and trading APIs with p99 budgets in the low hundreds of milliseconds; peaks on salary days and at market open.'],
      ['AI oversight', 'Every AI-assisted decision logged with inputs, model version and reviewer, with explanations for credit outcomes.']],
     ['06', '02', '05', '07', '09'], ['pci-dss', 'iso27001', 'soc2', 'dpdp'],
     'p99 ≤ 180 ms · payments API', 'A security and AI-readiness audit, then a fraud-triage assistant with human approval.'],
    ['health', 'Healthcare & life sciences', 'HIPAA · DPDP · clinical safety', 'industry-health.jpg', 1400, 788, 'A doctor reviewing scans on a tablet with a patient', '60% 40%',
     'Clinical safety comes first, and the data is the most sensitive there is.',
     [['Regulation', 'The HIPAA Security Rule where US patient data is involved, DPDP Act consent and purpose limits in India, and ABDM health-data standards where they apply.'],
      ['Data residency', 'Health records kept in region; models trained or tuned only on de-identified data.'],
      ['Latency & scale', 'Clinician tools answer within a consultation and tolerate weak connectivity at remote sites.'],
      ['AI oversight', 'A clinician reviews every AI suggestion that touches care. No autonomous clinical decisions.']],
     ['04', '06', '02', '07'], ['hipaa', 'dpdp', 'iso27001', 'iso42001'],
     'PHI redacted before any model call', 'Visit summaries drafted by AI, signed off by the clinician on every note.'],
    ['retail', 'Retail & D2C', 'Core Web Vitals · sale days', 'industry-retail.jpg', 1400, 1050, 'A shopper and a store assistant looking at products on a tablet', '50% 35%',
     'Sale days, mid-range phones and answer engines decide the revenue.',
     [['Regulation', 'PCI DSS through the payment provider, DPDP consent for marketing, and consumer-protection rules on prices and claims.'],
      ['Data residency', 'Customer profiles in region; card data never leaves the payment gateway.'],
      ['Latency & scale', 'Good Core Web Vitals at p75 on mid-range Android, and 10 to 20 times normal traffic on sale days.'],
      ['AI oversight', 'Product answers grounded in the live catalogue, so an assistant never invents a price or a stock level.']],
     ['01', '08', '02', '07', '05'], ['cwv', 'pci-dss', 'wcag22', 'dpdp'],
     'LCP 1.9 s at p75 · mid-range Android', 'A field-data speed fix on product and checkout pages, measured in conversion.'],
    ['manufacturing', 'Manufacturing', 'OT security · edge', 'industry-manufacturing.jpg', 1400, 878, 'A robotic arm on an automated production line', '50% 45%',
     'Plants run on control systems that cannot stop for an upgrade.',
     [['Regulation', 'IEC 62443 for industrial control-system security alongside ISO/IEC 27001 for IT, and export controls on some designs.'],
      ['Data residency', 'Plant data stays at the edge; only summaries and models travel to the cloud.'],
      ['Latency & scale', 'Vision inspection at line speed, with edge inference that keeps working when the network drops.'],
      ['AI oversight', 'Quality decisions reviewed by an engineer until precision is proven on your own line.']],
     ['07', '04', '05', '06'], ['iso27001', 'nist-csf', 'iso22301', 'iso9001'],
     'Vision QC · edge inference · 42 ms', 'Connect MES and ERP data, then a vision-inspection pilot on one line.'],
    ['education', 'Education', 'Children\'s data · accessibility', 'industry-education.jpg', 1400, 788, 'Students gathered around a laptop in a lecture hall', '50% 40%',
     'Results days bring the peaks, and children\'s data needs the most care.',
     [['Regulation', 'The DPDP Act requires verifiable parental consent for users under 18 and rules out tracking or targeted ads aimed at them; WCAG 2.2 AA for accessibility.'],
      ['Data residency', 'Student records in region, with retention tied to the purpose they were collected for.'],
      ['Latency & scale', 'Results-day spikes of 50 times normal traffic, and pages that work on low bandwidth.'],
      ['AI oversight', 'Tutoring agents with guardrails, age-appropriate content and full visibility for teachers.']],
     ['01', '04', '06', '10'], ['wcag22', 'dpdp', 'gdpr', 'owasp-llm'],
     'Results day · 50× traffic · autoscaled', 'An accessible student portal, load-tested for results day.'],
    ['logistics', 'Logistics', 'Events · integrations · offline', 'industry-logistics.jpg', 1400, 933, 'Shipping containers stacked in a port, seen from above', '50% 50%',
     'Every shipment is an event, and every event has to reach the right system.',
     [['Regulation', 'E-way bill and GST e-invoicing integrations, and data-sharing agreements with carriers and partners.'],
      ['Data residency', 'Operational data in region; partner APIs bound by contract and scoped per partner.'],
      ['Latency & scale', 'Tracking events streamed in seconds, and driver apps that keep working offline.'],
      ['AI oversight', 'Route and arrival-time models watched for drift, with exceptions escalated to a dispatcher.']],
     ['07', '01', '02', '05'], ['iso27001', 'soc2', 'iso22301'],
     '12k events per minute · streamed', 'One event backbone across carriers, warehouse and ERP, with WhatsApp updates to customers.'],
    ['public', 'Public sector', 'Residency · audit · languages', 'industry-public.jpg', 1400, 875, 'Government buildings in New Delhi under a cloudy sky', '50% 45%',
     'Residency, accessibility and audit trails are the baseline, not extras.',
     [['Regulation', 'CERT-In six-hour incident reporting and 180-day log retention, the DPDP Act, and the GIGW guidelines for government websites.'],
      ['Data residency', 'Data held in India, on government-empanelled cloud where the department requires it.'],
      ['Latency & scale', 'Citizen services in many Indian languages, with spikes as scheme deadlines approach.'],
      ['AI oversight', 'A person reviews any decision about a citizen, and the explanation can be published.']],
     ['06', '01', '09', '07'], ['cert-in', 'dpdp', 'wcag22', 'iso27001'],
     'Logs retained 180 days · in India', 'A security and accessibility audit, then a multilingual citizen-service assistant.'],
    ['saas', 'SaaS', 'SOC 2 · tenancy · AI features', 'industry-saas.jpg', 1600, 1066, 'Two engineers working side by side at monitors of code', '50% 50%',
     'Enterprise buyers ask for evidence before they sign.',
     [['Regulation', 'SOC 2 reports and ISO/IEC 27001 expected by enterprise buyers; GDPR and the EU AI Act for customers in the EU.'],
      ['Data residency', 'Per-tenant data boundaries, with EU or India hosting on request.'],
      ['Latency & scale', 'p95 targets per plan, and isolation so one busy tenant cannot slow the rest.'],
      ['AI oversight', 'AI features that never mix one tenant\'s data with another\'s, with evals on every release.']],
     ['02', '04', '05', '06', '10'], ['soc2', 'iso27001', 'gdpr', 'eu-ai-act'],
     'Tenant isolation · evals per release', 'Security-questionnaire readiness, then an AI feature built with tenant isolation.'],
];
?>
<section class="band band--alt tih-industries" id="industries" aria-labelledby="industries-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Industries</p>
        <h2 class="h2" id="industries-t"><span class="g">Different constraints</span> in every sector.</h2>
      </div>
      <div>
        <p class="lead">The same platform bends to very different rules. Regulation, data residency, latency and how much a person must review decide the architecture before any code is written.</p>
      </div>
    </div>

    <div class="tih-ind" data-rv data-rv-d="60" data-bdh-live>
      <div class="tih-ind__side">
        <p class="tih-k tih-ind__lk"><span>Sector</span><span><b class="tih-ind__pos">01</b> / <?= str_pad((string) count($ind_rows), 2, '0', STR_PAD_LEFT) ?></span></p>
        <div class="tih-ind__list" role="tablist" aria-label="Sectors" aria-orientation="vertical">
          <?php foreach ($ind_rows as $ind_i => $ind_r): ?>
            <button type="button" role="tab" class="tih-ind__tab" id="industries-t<?= $ind_i ?>" aria-controls="industries-p<?= $ind_i ?>" aria-selected="<?= $ind_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $ind_i === 0 ? '0' : '-1' ?>">
              <span class="tih-ind__n"><?= str_pad((string) ($ind_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <span class="tih-ind__tn"><?= e($ind_r[1]) ?><small><?= e($ind_r[2]) ?></small></span>
              <i aria-hidden="true">›</i>
              <span class="tih-ind__prog" aria-hidden="true"></span>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="tih-note tih-ind__legal">Regulatory notes are a summary for orientation, not legal advice.</p>
      </div>

      <div class="tih-ind__panes bdh-panes">
        <?php foreach ($ind_rows as $ind_i => $ind_r): ?>
          <div class="bdh-pane tih-ind__pane<?= $ind_i === 0 ? ' is-on' : '' ?>" id="industries-p<?= $ind_i ?>" role="tabpanel" aria-labelledby="industries-t<?= $ind_i ?>">
            <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
            <figure class="bdh-img bdh-img--r219 tih-ind__img">
              <img src="<?= xe_url('assets/imgs/tech/hub/' . $ind_r[3]) ?>" alt="<?= e($ind_r[6]) ?>" width="<?= $ind_r[4] ?>" height="<?= $ind_r[5] ?>" style="object-position:<?= e($ind_r[7]) ?>" loading="lazy" decoding="async">
              <span class="tih-ind__ro" aria-hidden="true"><i class="bdh-pulse"></i><?= e($ind_r[12]) ?></span>
              <span class="tih-ind__frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
            </figure>
            <div class="tih-ind__info">
              <div class="tih-ind__head">
                <p class="tih-k"><?= str_pad((string) ($ind_i + 1), 2, '0', STR_PAD_LEFT) ?> · <?= e($ind_r[2]) ?></p>
                <h3 class="tih-ind__h"><?= e($ind_r[1]) ?></h3>
                <p class="tih-ind__lead"><?= e($ind_r[8]) ?></p>
              </div>
              <dl class="tih-ind__cons">
                <?php foreach ($ind_r[9] as $ind_ci => $ind_c): ?>
                  <div style="--i:<?= $ind_ci ?>"><dt><?= e($ind_c[0]) ?></dt><dd><?= e($ind_c[1]) ?></dd></div>
                <?php endforeach; ?>
              </dl>
              <div class="tih-ind__foot">
                <div class="tih-ind__caps">
                  <p class="tih-k">Capabilities most used</p>
                  <p class="tih-ind__chips"><?php foreach ($ind_r[10] as $ind_ni => $ind_n): $ind_s = $ind_by_n[$ind_n]; ?><a class="tih-capl" href="<?= $ind_url($ind_s) ?>" style="--i:<?= $ind_ni ?>"><b><?= e($ind_n) ?></b><?= e($TI[$ind_s]['short']) ?><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
                </div>
                <div class="tih-ind__std">
                  <p class="tih-k">Frameworks that apply</p>
                  <ul class="tih-ind__badges" role="list" aria-label="Frameworks for <?= e($ind_r[1]) ?>"><?php foreach ($ind_r[11] as $ind_b) { echo xt_badge($ind_b, ['variant' => 'chip', 'tag' => 'li']); } ?></ul>
                </div>
                <p class="tih-ind__first"><span class="tih-k">Typical first project</span><?= e($ind_r[13]) ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
