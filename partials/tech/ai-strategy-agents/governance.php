<?php /* DRAFT COPY — review before launch */
/* Governance — the crosswalk. Four columns follow the NIST AI RMF functions (Govern · Map · Measure ·
   Manage); each holds the artefacts we produce and the clause of each framework the artefact answers.
   The framework buttons along the top filter the map, so legal, security and the board can each see
   their own view. governance.js drops the artefacts in on entry and drives the filter.
   Wording: frameworks we build to and align delivery with. No certification is claimed. */
$tas_gv_fw = [   // key => [badge key or null, short label, long name]
    'nist'     => ['nist-ai-rmf', 'NIST AI RMF',      'NIST AI RMF 1.0 · the spine of this map'],
    'iso42001' => ['iso42001',    'ISO/IEC 42001',    'AI management system · Annex A controls'],
    'iso23894' => ['iso23894',    'ISO/IEC 23894',    'AI risk management guidance'],
    'euai'     => ['eu-ai-act',   'EU AI Act',        'Regulation (EU) 2024/1689'],
    'gdpr'     => ['gdpr',        'GDPR',             'Personal data · EU'],
    'dpdp'     => ['dpdp',        'DPDP Act 2023',    'Personal data · India'],
    'owasp'    => ['owasp-llm',   'OWASP LLM Top 10', 'Application security for LLM apps'],
];
$tas_gv_cols = [   // [key, name, NIST function, meaning, artefacts: [title, [fw key => clause]]]
    ['govern', 'Govern', 'GOVERN', 'Policies, roles and accountability, so every decision about AI has an owner.', [
        ['AI use policy and principles',           ['nist' => 'GOVERN 1', 'iso42001' => 'A.2', 'euai' => 'Art. 4']],
        ['Roles, approval rights and a RACI',      ['nist' => 'GOVERN 2', 'iso42001' => 'A.3']],
        ['AI system inventory',                    ['nist' => 'GOVERN 1.6', 'iso42001' => 'A.4']],
        ['Training record for owners and approvers', ['euai' => 'Art. 4 AI literacy', 'nist' => 'GOVERN 2']],
    ]],
    ['map', 'Map', 'MAP', 'Each use case in context: who it affects, what could go wrong, which rules apply.', [
        ['Context sheet and EU AI Act risk tier',  ['nist' => 'MAP 1', 'iso23894' => '§6.3 context', 'euai' => 'Art. 6 · Annex III']],
        ['Risk assessment with treatment plan',    ['iso42001' => '6.1.2 · 6.1.3', 'iso23894' => '§6.4 · §6.5', 'nist' => 'MAP 5']],
        ['Impact assessment where high-risk',      ['iso42001' => 'A.5', 'euai' => 'Art. 27', 'gdpr' => 'Art. 35 DPIA', 'dpdp' => '§10']],
        ['Data map and lawful basis',              ['gdpr' => 'Art. 6', 'dpdp' => '§4 · §5', 'iso42001' => 'A.7']],
        ['Threat model for the agent',             ['owasp' => 'LLM01 · LLM06', 'nist' => 'MAP 5']],
    ]],
    ['measure', 'Measure', 'MEASURE', 'Evidence, not opinion: every risk has a test, a number and a trend.', [
        ['Eval suite, golden sets and red-team results', ['nist' => 'MEASURE 2', 'euai' => 'Art. 15', 'owasp' => 'LLM01–LLM10']],
        ['Model cards per model and version',      ['euai' => 'Art. 11 · Art. 13', 'iso42001' => 'A.8']],
        ['Bias and fairness tests where people are affected', ['euai' => 'Art. 10', 'gdpr' => 'Art. 22', 'nist' => 'MEASURE 2']],
        ['Monitoring: success, cost, escalations, drift', ['nist' => 'MEASURE 3', 'euai' => 'Art. 26']],
    ]],
    ['manage', 'Manage', 'MANAGE', 'Controls in place, kept working after launch, and a plan for when they fail.', [
        ['Human-oversight design: the four autonomy levels', ['euai' => 'Art. 14', 'nist' => 'MANAGE 1', 'iso42001' => 'A.9']],
        ['Guardrail and approval policy',          ['owasp' => 'LLM06', 'nist' => 'MANAGE 2']],
        ['Disclosure: people are told they are talking to AI', ['euai' => 'Art. 50', 'dpdp' => '§5 notice']],
        ['Audit log and retention rules',          ['euai' => 'Art. 12 · Art. 26', 'gdpr' => 'Art. 5', 'dpdp' => '§8']],
        ['Change, rollback and incident response', ['iso42001' => 'A.6', 'nist' => 'MANAGE 4', 'dpdp' => '§8(6)', 'gdpr' => 'Art. 33']],
    ]],
];
$tas_gv_total = 0; foreach ($tas_gv_cols as $tas_gc) { $tas_gv_total += count($tas_gc[4]); }
$tas_gv_counts = [];
foreach ($tas_gv_fw as $tas_fk => $tas_fv) {
    $tas_gv_counts[$tas_fk] = 0;
    foreach ($tas_gv_cols as $tas_gc) { foreach ($tas_gc[4] as $tas_ga) { if (isset($tas_ga[1][$tas_fk])) $tas_gv_counts[$tas_fk]++; } }
}
/* EU AI Act application dates: Regulation (EU) 2024/1689 as amended by Regulation (EU) 2026/1744,
   the Digital Omnibus on AI (published in the Official Journal on 24 July 2026, in force since
   27 July 2026), which deferred the high-risk dates, gave systems already on the market until
   2 December 2026 to mark AI-generated content under Art. 50(2), and added a prohibited practice
   (non-consensual intimate imagery and child sexual abuse material) from the same date. Checked
   against published summaries of the amending regulation; a legal re-check stays on the launch
   list. Each date is marked "in force" or "ahead" against the day the page is served. */
// PLACEHOLDER: legal re-check of the EU AI Act dates against the consolidated text before launch
$tas_gv_tl = [   // [ISO date, label, what applies, articles]
    ['2025-02-02', '2 Feb 2025', 'Prohibited practices and AI literacy duties', 'Art. 4 · Art. 5'],
    ['2025-08-02', '2 Aug 2025', 'General-purpose model obligations and governance', 'Chapter V'],
    ['2026-08-02', '2 Aug 2026', 'Transparency duties and most remaining provisions', 'Art. 50'],
    ['2026-12-02', '2 Dec 2026', 'Content marking for systems already on the market, and a new prohibited practice', 'Art. 50(2) · Art. 5'],
    ['2027-12-02', '2 Dec 2027', 'High-risk systems listed in Annex III, deferred by the 2026 amendment', 'Art. 6(2) · Annex III'],
    ['2028-08-02', '2 Aug 2028', 'High-risk systems embedded in regulated products', 'Art. 6(1) · Annex I'],
];
/* ISO/IEC 23894 has no entry in the kit's standards list: the same code-built badge and chip are
   made here from the kit's own badge art (xt__badge_art), never an official mark. */
$tas_gv_23894 = ['code' => 'ISO/IEC 23894:2023', 'name' => 'AI risk management guidance', 'mark' => '23894', 'sub' => 'ISO/IEC'];
$tas_gv_chip23894 = '<span class="xt-badge xt-badge--chip" title="' . e($tas_gv_23894['name']) . '"><svg class="xt-badge__pip" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M6 1 10.5 2.8v3.1c0 2.6-1.9 4.5-4.5 5.3C3.4 10.4 1.5 8.5 1.5 5.9V2.8z"/></svg>'
    . '<span class="xt-badge__code">' . e($tas_gv_23894['code']) . '</span><span class="sr"> — ' . e($tas_gv_23894['name']) . '</span></span>';
$tas_gv_badge23894 = function_exists('xt__badge_art')
    ? '<li class="xt-badge xt-badge--seal" data-standard="iso23894">' . xt__badge_art($tas_gv_23894, 'seal')
      . '<span class="xt-badge__txt"><span class="xt-badge__code">' . e($tas_gv_23894['code']) . '</span><span class="xt-badge__name">' . e($tas_gv_23894['name']) . '</span></span></li>'
    : '';
$tas_gv_today = date('Y-m-d');
$tas_gv_n = 0;
?>
<section class="band band--ink tas-governance" id="governance" aria-labelledby="governance-t">
  <div class="wrap">
    <div class="tas-head" data-rv>
      <div class="tas-head__t">
        <p class="tas-kick"><span class="tas-kick__ref">06</span>AI governance map</p>
        <h2 class="h2" id="governance-t"><span class="g">Governance that lets you</span> say yes.</h2>
      </div>
      <div class="tas-head__l">
        <p class="lead">Legal and security say no when nobody can show what the agent may do, who approves it and which rules apply. We answer those questions in writing, mapped to the frameworks your auditors use, before the first agent goes live.</p>
      </div>
    </div>

    <div class="tas-gv" data-tas-gv data-fw="all" data-rv>
      <div class="tas-gv__top">
        <div class="tas-gv__fws" role="group" aria-label="Show artefacts for a framework">
          <button type="button" class="tas-gv__fw" data-gv-fw="all" aria-pressed="true"><span class="tas-gv__fwn">All frameworks</span><small><?= $tas_gv_total ?></small></button>
          <?php foreach ($tas_gv_fw as $tas_fk => $tas_fv): ?>
            <button type="button" class="tas-gv__fw" data-gv-fw="<?= e($tas_fk) ?>" aria-pressed="false" title="<?= e($tas_fv[2]) ?>">
              <?= $tas_fk === 'iso23894' ? $tas_gv_chip23894 : xt_badge($tas_fv[0], ['variant' => 'chip']) ?>
              <small><?= $tas_gv_counts[$tas_fk] ?></small>
            </button>
          <?php endforeach; ?>
        </div>
        <p class="tas-gv__ro" role="status" aria-live="polite" data-gv-ro><b><?= $tas_gv_total ?></b> artefacts across the four functions of NIST AI RMF 1.0 · frameworks we build to, not badges we hold</p>
      </div>

      <div class="tas-gv__fnsw" role="group" aria-label="Show one NIST AI RMF function" data-gv-fnsw hidden>
        <?php foreach ($tas_gv_cols as $tas_ci => $tas_gc): ?>
          <button type="button" data-gv-col="<?= e($tas_gc[0]) ?>" aria-pressed="<?= $tas_ci === 0 ? 'true' : 'false' ?>"><?= e($tas_gc[1]) ?></button>
        <?php endforeach; ?>
      </div>
      <div class="tas-gv__cols">
        <?php foreach ($tas_gv_cols as $tas_ci => $tas_gc): ?>
          <div class="tas-gv__col" data-col="<?= e($tas_gc[0]) ?>">
            <div class="tas-gv__ch">
              <p class="tas-gv__fn"><span><?= sprintf('%02d', $tas_ci + 1) ?></span><?= e($tas_gc[2]) ?></p>
              <h3 class="tas-gv__ct"><?= e($tas_gc[1]) ?></h3>
              <p class="tas-gv__cm"><?= e($tas_gc[3]) ?></p>
            </div>
            <ul class="tas-gv__list" id="gv-list-<?= e($tas_gc[0]) ?>">
              <?php foreach ($tas_gc[4] as $tas_ga): $tas_gv_n++; ?>
                <li class="tas-gv__chip" data-fw="<?= e(implode(' ', array_keys($tas_ga[1]))) ?>" style="--i:<?= $tas_gv_n ?>">
                  <p class="tas-gv__at"><?= e($tas_ga[0]) ?></p>
                  <p class="tas-gv__tags"><?php foreach ($tas_ga[1] as $tas_tk => $tas_tv): ?><span data-fw="<?= e($tas_tk) ?>"><b><?= e($tas_gv_fw[$tas_tk][1]) ?></b> <?= e($tas_tv) ?></span><?php endforeach; ?></p>
                </li>
              <?php endforeach; ?>
            </ul>
            <p class="tas-gv__none">No artefact in this function for the chosen framework.</p>
            <button type="button" class="tas-gv__more" aria-expanded="false" aria-controls="gv-list-<?= e($tas_gc[0]) ?>" data-gv-more hidden>Show all <?= count($tas_gc[4]) ?> artefacts</button>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tas-gv__std" data-rv>
      <p class="tas-lbl">Frameworks we build to and align delivery with</p>
      <ul class="xt-badges tas-gv__badges" role="list">
        <?php foreach (['nist-ai-rmf', 'iso42001', 'iso23894', 'eu-ai-act', 'owasp-llm', 'dpdp', 'gdpr'] as $tas_bk): ?>
          <?= $tas_bk === 'iso23894' ? $tas_gv_badge23894 : xt_badge($tas_bk, ['tag' => 'li']) ?>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="tas-gv__foot">
      <div class="tas-gv__tl" data-rv>
        <p class="tas-lbl">EU AI Act · obligations phase in</p>
        <!-- PLACEHOLDER: legal re-check of the EU AI Act application dates (Regulation (EU) 2026/1744) before launch -->
        <ol class="tas-gv__dates">
          <?php foreach ($tas_gv_tl as $tas_di => $tas_dt): ?>
            <li class="<?= $tas_dt[0] <= $tas_gv_today ? 'is-past' : 'is-ahead' ?>" style="--i:<?= $tas_di ?>"><b><?= e($tas_dt[1]) ?> <em><?= $tas_dt[0] <= $tas_gv_today ? 'in force' : 'ahead' ?></em></b><span><?= e($tas_dt[2]) ?></span><small><?= e($tas_dt[3]) ?></small></li>
          <?php endforeach; ?>
        </ol>
        <p class="tas-gv__tln">Regulation (EU) 2024/1689 as amended by Regulation (EU) 2026/1744, the Digital Omnibus on AI, in force since 27 July 2026. It moved the high-risk dates later, set 2 December 2026 for content marking by systems already on the market and added a prohibited practice from the same day. We plan against the text in force.</p>
      </div>
      <div class="tas-gv__note" data-rv data-rv-d="80">
        <p class="tas-lbl">What this is, and is not</p>
        <p>These are the frameworks we design and deliver to. The artefacts are the evidence a certification body or a regulator asks for; whether to certify stays your decision. GDPR and India’s DPDP Act 2023 sit in the same map, so one register serves privacy and AI risk.</p>
        <a class="tl" href="<?= xe_url('services/technology-intelligence/cybersecurity-ai-trust.php') ?>">Security and compliance in depth <span class="i" aria-hidden="true">›</span></a>
      </div>
    </div>
  </div>
</section>
