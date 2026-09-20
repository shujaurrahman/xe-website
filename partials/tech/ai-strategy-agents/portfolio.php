<?php /* DRAFT COPY — review before launch */
/* Portfolio — twelve candidate use cases on a value × feasibility chart (bubble size = hours of
   work a month), a ranked list and a detail card. Chips filter by function; a switch shows the EU AI
   Act risk tier as the bubble outline. portfolio.js drifts the bubbles in, draws the "build first"
   paths and drives the filters and selection. Values are illustrative. The HTML is the finished
   state: all functions, risk tiers off, rank 1 selected. */
$tas_pf_fns = ['sales' => 'Sales', 'service' => 'Service', 'finance' => 'Finance', 'ops' => 'Operations', 'hr' => 'HR'];
$tas_pf_tiers = ['minimal' => 'Minimal risk', 'limited' => 'Limited risk · transparency', 'high' => 'High risk'];
$tas_pf = [   // [use case, fn, value 0–10, feasibility 0–10, hours a month, tier, time to value, owner, value note, feasibility note, risk note, decision, start level (pilot)]
    ['Reconcile vendor invoices',     'finance', 8.4, 8.6, 360, 'minimal', '4–6 wks',  'Finance lead',   '360 hours a month of three-way matching across about 2,900 invoices.', 'Invoices and purchase orders already sit in the ERP. About 18% arrive as PDFs and need extraction.', 'Minimal tier. Supplier data only, and payment release stays with a person.', 'Build first', 2],
    ['Triage inbound RFPs',           'sales',   8.6, 7.4, 240, 'minimal', '5–7 wks',  'Bid manager',    'Around 60 RFPs a month get a go or no-go in a day instead of a week.',       'Past bids are searchable and the scoring criteria are already written down.',                   'Minimal tier. The bid decision stays with the bid manager.',                   'Build first', 2],
    ['Draft renewal quotes',          'sales',   8.0, 8.1, 320, 'minimal', '4–6 wks',  'Sales ops lead', '320 hours a month on about 4,000 quote drafts and revisions for roughly 1,100 renewals a year.',       'Contract terms are in the CRM and pricing rules are documented.',                               'Minimal tier. Discounts above policy go to a person.',                         'Build first', 2],
    ['Answer customer policy questions','service', 6.4, 8.8, 520, 'limited', '3–5 wks', 'Support lead',   'High volume, low value per question: 520 hours a month in the queue.',       'Policies are current and held in one knowledge base.',                                          'Limited tier. People must be told they are talking to AI, and answers cite the policy.', 'Next quarter · copilot for support staff first', 1],
    ['Qualify inbound leads',         'sales',   6.0, 6.8, 180, 'minimal', '5–6 wks',  'Sales ops lead', 'Faster first response on about 900 leads a month.',                           'CRM firmographic data is patchy and needs a clean-up first.',                                   'Minimal tier, but profiling individuals needs a lawful basis under GDPR and the DPDP Act.', 'Next quarter · after CRM clean-up', 2],
    ['Resolve billing disputes',      'service', 7.6, 6.2, 400, 'limited', '8–10 wks', 'Service lead',   '400 hours a month across roughly 1,300 disputes.',                            'Billing history is split across two systems, so an integration comes first.',                   'Limited tier for customer-facing replies. Credits above the limit need approval.', 'Next quarter · after the billing integration', 2],
    ['Prepare the board pack',        'finance', 5.2, 6.4,  60, 'minimal', '4–6 wks',  'CFO office',     '60 hours a month, concentrated at quarter end.',                              'Figures are in the warehouse; the narrative changes every quarter.',                             'Minimal tier, but confidential, so distribution is restricted.',              'Later · drafts only', 2],
    ['Summarise shift handovers',     'ops',     3.8, 8.2, 150, 'minimal', '2–3 wks',  'Ops manager',    '150 hours a month, small value per summary.',                                 'Notes are already typed into the maintenance system.',                                           'Minimal tier.',                                                                'Copilot candidate · in the existing tool', 1],
    ['Forecast spare-parts demand',   'ops',     6.2, 4.4, 120, 'minimal', '10–12 wks','Ops manager',    'Less stock held and fewer stock-outs on critical parts.',                     'Three years of history, but part codes changed mid-way and need mapping.',                      'Minimal tier.',                                                                'Prepare the data first', 1],
    ['Answer HR policy questions',    'hr',      4.4, 7.6, 110, 'limited', '3–4 wks',  'People team',    '110 hours a month for the people team.',                                      'The handbook is current. Payroll and personal cases are out of scope.',                          'Limited tier. Staff are told they are using AI; personal cases go to a person.', 'Copilot candidate', 1],
    ['Assess customer credit limits', 'finance', 7.2, 3.8,  90, 'high',    '12+ wks',  'Credit manager', 'Fewer write-offs and faster onboarding.',                                     'Needs bureau data contracts and independent model validation.',                                  'High tier where it scores the creditworthiness of individuals (EU AI Act, Annex III). Needs a risk management system, logging and human oversight.', 'Park · revisit with a compliance plan', 1],
    ['Screen job applications',       'hr',      5.0, 5.2, 200, 'high',    '12+ wks',  'Talent lead',    '200 hours a month at peak hiring.',                                           'Applications sit in the applicant tracking system; criteria vary by role.',                      'High tier: recruitment and selection is listed in Annex III of the EU AI Act. Bias testing, oversight and logging required.', 'Park · high risk for the value', 1],
];
/* autonomy ceiling: the highest level the use case may reach, only after the review at each gate */
$tas_pf_ceil = [
    'Reconcile vendor invoices' => 4, 'Triage inbound RFPs' => 2, 'Draft renewal quotes' => 4, 'Answer customer policy questions' => 3,
    'Qualify inbound leads' => 3, 'Resolve billing disputes' => 4, 'Prepare the board pack' => 2, 'Summarise shift handovers' => 2,
    'Forecast spare-parts demand' => 2, 'Answer HR policy questions' => 2, 'Assess customer credit limits' => 1, 'Screen job applications' => 1,
];
$tas_pf_ceil_t = function (int $start, int $ceil): string {
    if ($ceil <= $start) return 'L' . $ceil . ' · stays at this level';
    return 'L' . $ceil . ' · ' . ($ceil === 4 ? 'only after 90 days at L3' : 'after the pilot review');
};
/* score = 0.45 × value + 0.35 × feasibility + risk adjustment − 0.05 × weeks to a measured pilot
   (the midpoint of the time-to-value range; "12+ wks" counts as 13). Ranked on the exact score,
   shown to one decimal. */
$tas_pf_tier_adj = ['minimal' => 1.0, 'limited' => 0.4, 'high' => -1.0];
$tas_pf_weeks = function (string $ttv): float {
    if (preg_match('/(\d+)\s*[–-]\s*(\d+)/u', $ttv, $m)) return ((float) $m[1] + (float) $m[2]) / 2;
    if (preg_match('/(\d+)\+/', $ttv, $m)) return (float) $m[1] + 1;
    return (float) $ttv;
};
foreach ($tas_pf as $tas_pk => $tas_pr) {
    $tas_pf[$tas_pk][14] = 0.45 * $tas_pr[2] + 0.35 * $tas_pr[3] + $tas_pf_tier_adj[$tas_pr[5]] - 0.05 * $tas_pf_weeks($tas_pr[6]);
    $tas_pf[$tas_pk][13] = round($tas_pf[$tas_pk][14], 1);
}
usort($tas_pf, fn ($tas_a, $tas_b) => $tas_b[14] <=> $tas_a[14]);
$tas_pf_pos = fn (float $v) => round(4 + ($v - 3) / 7 * 92, 2);   // 3–10 → 4–96 %
$tas_pf_json = array_map(fn ($tas_r) => ['n' => $tas_r[0], 'fn' => $tas_pf_fns[$tas_r[1]], 'v' => $tas_r[2], 'f' => $tas_r[3], 'h' => $tas_r[4], 'tier' => $tas_pf_tiers[$tas_r[5]], 'ttv' => $tas_r[6], 'own' => $tas_r[7], 'vn' => $tas_r[8], 'fnote' => $tas_r[9], 'rn' => $tas_r[10], 'dec' => $tas_r[11], 'lvl' => $tas_r[12], 'ceil' => $tas_pf_ceil_t($tas_r[12], $tas_pf_ceil[$tas_r[0]] ?? $tas_r[12]), 's' => $tas_r[13]], $tas_pf);
$tas_pf_sel = $tas_pf[0];
$tas_pf_criteria = [
    ['Value',         'Hours returned or revenue affected, from the teams’ own volumes.', 'target'],
    ['Feasibility',   'Data readiness and integration effort: where the data lives and how clean it is.', 'database'],
    ['Risk',          'EU AI Act tier, personal data involved and the harm if the agent is wrong.', 'shield'],
    ['Time to value', 'Weeks to a measured pilot, data and integration work included. Each week costs 0.05 points.', 'clock'],
];
?>
<section class="band tas-portfolio" id="portfolio" aria-labelledby="portfolio-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">02</span>Use-case portfolio</p>
        <h2 class="h2" id="portfolio-t"><span class="g">Twelve ideas.</span> Three worth building first.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Every candidate is scored with the people who run the work. The output is a ranked roadmap and a business case for the first three, not a slide of possibilities.</p>
      </div>
    </div>

    <ul class="tas-pf__crit" data-rv-s data-rv-step="70">
      <?php foreach ($tas_pf_criteria as $tas_pc): ?>
        <li><?= xt_icon($tas_pc[2], ['size' => 22]) ?><div><h3><?= e($tas_pc[0]) ?></h3><p><?= e($tas_pc[1]) ?></p></div></li>
      <?php endforeach; ?>
    </ul>

    <div class="tas-pf" data-tas-pf data-risk="off" data-fn="all" data-rv data-pf='<?= e(json_encode($tas_pf_json, JSON_UNESCAPED_UNICODE)) ?>'>
      <div class="tas-pf__bar">
        <div class="tas-pf__chips" role="group" aria-label="Filter use cases by function">
          <button type="button" class="tas-chip" aria-pressed="true" data-pf-fn="all">All <small><?= count($tas_pf) ?></small></button>
          <?php foreach ($tas_pf_fns as $tas_fk => $tas_fl): ?>
            <button type="button" class="tas-chip" aria-pressed="false" data-pf-fn="<?= e($tas_fk) ?>"><?= e($tas_fl) ?> <small><?= count(array_filter($tas_pf, fn ($tas_x) => $tas_x[1] === $tas_fk)) ?></small></button>
          <?php endforeach; ?>
        </div>
        <button type="button" class="bdh-switch tas-pf__risk" aria-pressed="false" data-pf-risk><span class="bdh-switch__track" aria-hidden="true"></span>Show EU AI Act risk tier</button>
      </div>

      <div class="tas-pf__body">
        <div class="tas-pf__chart">
          <div class="tas-pf__plot" aria-hidden="true">
            <span class="tas-pf__q tas-pf__q--first">Build first</span>
            <span class="tas-pf__q tas-pf__q--prep">Prepare the data</span>
            <span class="tas-pf__q tas-pf__q--quick">Copilot candidates</span>
            <span class="tas-pf__q tas-pf__q--park">Park</span>
            <svg class="tas-pf__svg" viewBox="0 0 100 100" preserveAspectRatio="none" focusable="false">
              <rect class="tas-pf__zone" x="<?= $tas_pf_pos(6.5) ?>" y="0" width="<?= 100 - $tas_pf_pos(6.5) ?>" height="<?= 100 - $tas_pf_pos(6.5) ?>"/>
              <?php for ($tas_g = 4; $tas_g <= 10; $tas_g += 2): ?>
                <line class="tas-pf__grid" x1="<?= $tas_pf_pos($tas_g) ?>" y1="0" x2="<?= $tas_pf_pos($tas_g) ?>" y2="100"/>
                <line class="tas-pf__grid" x1="0" y1="<?= 100 - $tas_pf_pos($tas_g) ?>" x2="100" y2="<?= 100 - $tas_pf_pos($tas_g) ?>"/>
              <?php endfor; ?>
              <line class="tas-pf__split" x1="<?= $tas_pf_pos(6.5) ?>" y1="0" x2="<?= $tas_pf_pos(6.5) ?>" y2="100"/>
              <line class="tas-pf__split" x1="0" y1="<?= 100 - $tas_pf_pos(6.5) ?>" x2="100" y2="<?= 100 - $tas_pf_pos(6.5) ?>"/>
              <g class="tas-pf__paths">
                <?php for ($tas_pi = 0; $tas_pi < 3; $tas_pi++):
                    $tas_px = $tas_pf_pos($tas_pf[$tas_pi][3]); $tas_py = 100 - $tas_pf_pos($tas_pf[$tas_pi][2]); ?>
                  <path pathLength="1" style="--i:<?= $tas_pi ?>" d="M<?= $tas_px ?> <?= $tas_py ?> C <?= $tas_px ?> <?= round($tas_py - 10, 2) ?>, 86 <?= 12 + $tas_pi * 1.5 ?>, 90 <?= 5 ?>"/>
                <?php endfor; ?>
              </g>
            </svg>
            <?php foreach ($tas_pf as $tas_pi => $tas_pr):
                $tas_size = round(24 + sqrt($tas_pr[4] / 520) * 36); ?>
              <button type="button" tabindex="-1" class="tas-pf__b<?= $tas_pi < 3 ? ' is-top' : '' ?><?= $tas_pi === 0 ? ' is-sel' : '' ?>" data-i="<?= $tas_pi ?>" data-fn="<?= e($tas_pr[1]) ?>" data-tier="<?= e($tas_pr[5]) ?>"
                style="--x:<?= $tas_pf_pos($tas_pr[3]) ?>;--y:<?= $tas_pf_pos($tas_pr[2]) ?>;--d:<?= $tas_size ?>px;--i:<?= $tas_pi ?>"><span><?= $tas_pi + 1 ?></span><em><?= e($tas_pr[0]) ?></em></button>
            <?php endforeach; ?>
            <span class="tas-pf__ax tas-pf__ax--x">Feasibility <i>→</i></span>
            <span class="tas-pf__ax tas-pf__ax--y">Value <i>→</i></span>
          </div>
          <p class="bdh-sr">A chart of twelve use cases by value and feasibility. The three in the high-value, high-feasibility corner are marked to build first: reconcile vendor invoices, triage inbound RFPs and draft renewal quotes. The ranked list that follows holds the same information.</p>
          <div class="tas-pf__foot">
            <p class="tas-pf__legend" data-pf-legend hidden>
              <span><i class="tas-pf__sw" data-tier="minimal"></i>Minimal</span>
              <span><i class="tas-pf__sw" data-tier="limited"></i>Limited · transparency duties</span>
              <span><i class="tas-pf__sw" data-tier="high"></i>High risk · Annex III</span>
            </p>
            <p class="tas-pf__key"><span>Bubble size = hours of work a month · axes 3–10</span><span class="tas-ill">Illustrative portfolio</span></p>
            <p class="tas-pf__formula"><code>score = 0.45·value + 0.35·feasibility + risk − 0.05·weeks</code><span>risk: +1 minimal · +0.4 limited · −1 high</span></p>
          </div>
        </div>

        <div class="tas-pf__side">
          <div class="tas-pf__lh"><span>#</span><span>Use case</span><span>Score</span><span>Risk</span></div>
          <ol class="tas-pf__list" id="pf-list" aria-label="Ranked use cases">
            <?php foreach ($tas_pf as $tas_pi => $tas_pr): ?>
              <li data-fn="<?= e($tas_pr[1]) ?>">
                <button type="button" class="tas-pf__row<?= $tas_pi < 3 ? ' is-top' : '' ?>" aria-pressed="<?= $tas_pi === 0 ? 'true' : 'false' ?>" data-i="<?= $tas_pi ?>" aria-controls="pf-detail">
                  <span class="tas-pf__rk"><?= sprintf('%02d', $tas_pi + 1) ?></span>
                  <span class="tas-pf__rn"><b><?= e($tas_pr[0]) ?></b><small><?= e($tas_pf_fns[$tas_pr[1]]) ?> · <?= e($tas_pr[6]) ?></small></span>
                  <span class="tas-pf__rs"><?= number_format($tas_pr[13], 1) ?></span>
                  <span class="tas-pf__rt" data-tier="<?= e($tas_pr[5]) ?>"><?= e(ucfirst($tas_pr[5])) ?></span>
                </button>
              </li>
            <?php endforeach; ?>
          </ol>
          <button type="button" class="tas-pf__more" aria-expanded="false" aria-controls="pf-list" data-pf-more hidden>Show all <?= count($tas_pf) ?> use cases</button>
          <div class="tas-pf__out">
            <p class="tas-lbl">What the portfolio hands over</p>
            <ul>
              <li><?= xt_icon('flag', ['size' => 20]) ?><span><b>Ranked roadmap</b>All twelve, sequenced by quarter with dependencies</span></li>
              <li><?= xt_icon('doc', ['size' => 20]) ?><span><b>Business case × 3</b>Baseline, target, build and run cost, payback</span></li>
              <li><?= xt_icon('users', ['size' => 20]) ?><span><b>Owners and measures</b>One accountable owner and one number per use case</span></li>
            </ul>
          </div>
        </div>

        <div class="tas-pf__detail" id="pf-detail" aria-live="polite">
          <div class="tas-pf__dh">
            <p class="tas-lbl">Selected · rank <b data-d="rank">01</b> · score <b data-d="s"><?= number_format($tas_pf_sel[13], 1) ?></b></p>
            <h3 class="tas-pf__dt" data-d="n"><?= e($tas_pf_sel[0]) ?></h3>
            <p class="tas-pf__dm"><span data-d="fn"><?= e($tas_pf_fns[$tas_pf_sel[1]]) ?></span> · owner <span data-d="own"><?= e($tas_pf_sel[7]) ?></span> · <span data-d="ttv"><?= e($tas_pf_sel[6]) ?></span> to a measured pilot</p>
          </div>
          <dl class="tas-pf__dl">
            <div><dt>Value <span class="tas-pf__meter"><i data-d="vbar" style="--p:<?= $tas_pf_sel[2] / 10 ?>"></i></span></dt><dd data-d="vn"><?= e($tas_pf_sel[8]) ?></dd></div>
            <div><dt>Feasibility <span class="tas-pf__meter"><i data-d="fbar" style="--p:<?= $tas_pf_sel[3] / 10 ?>"></i></span></dt><dd data-d="fnote"><?= e($tas_pf_sel[9]) ?></dd></div>
            <div><dt>Risk <span class="tas-pf__tier" data-d="tier"><?= e($tas_pf_tiers[$tas_pf_sel[5]]) ?></span></dt><dd data-d="rn"><?= e($tas_pf_sel[10]) ?></dd></div>
          </dl>
          <div class="tas-pf__dec">
            <p class="tas-pf__dv"><span class="tas-pf__deck">Decision</span><b data-d="dec"><?= e($tas_pf_sel[11]) ?></b></p>
            <p class="tas-pf__dv"><span class="tas-pf__deck">Pilot starts at</span><span data-d="lvl"><?= tas_lvl($tas_pf_sel[12]) ?></span></p>
            <p class="tas-pf__dv"><span class="tas-pf__deck">Autonomy ceiling</span><span class="tas-pf__ceil" data-d="ceil"><?= e($tas_pf_ceil_t($tas_pf_sel[12], $tas_pf_ceil[$tas_pf_sel[0]] ?? $tas_pf_sel[12])) ?></span></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
