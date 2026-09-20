<?php /* DRAFT COPY — review before launch */
/* 04.2 SIGNATURE — the A/B RAG Inspector. Five questions about a fictional company's policies and product
   docs. For the chosen question, Baseline RAG (fixed 1,000-token chunks, vector-only search, no reranker)
   sits beside Tuned RAG (semantic chunks, hybrid BM25 + vector, cross-encoder reranker, citations enforced).
   Each stage is a disclosure: query rewrite → retrieved chunks → reranked top-k → answer with citations,
   then four eval scores. "No retrieval" swaps the baseline for the bare model answer, flagged ungrounded.
   All five questions are rendered finished in the HTML; inspector.js animates each run. Every document,
   answer and score here is illustrative. */

/* chunk: [document, location, snippet, score, tag: '' | old (archived/superseded) | cut (chunk boundary) | off (off-topic) | draft] */
$tapi_q = [
  [
    'q' => 'How long do customers have to return a damaged item?', 'topic' => 'Returns policy',
    'base' => [
      'ret' => [
        ['warranty-terms.pdf', '§4 Defects', 'Manufacturing defects are covered for 12 months from purchase…', '0.84', 'off'],
        ['returns-policy-v2.pdf', '§3 Damaged items', '…damaged items may be returned within 30 days of purchase…', '0.82', 'old'],
        ['returns-policy-v4.pdf', '§2 · 1,000-token chunk', '…14 days of delivery … exchanges … gift cards … store credit…', '0.79', 'cut'],
        ['shipping-faq.md', 'Delivery problems', 'If your parcel arrives damaged, keep the packaging and…', '0.77', ''],
        ['careers-page.md', 'Benefits', 'Staff discount on returns and exchanges…', '0.71', 'off'],
      ],
      'ans' => [
        ['Customers can return a damaged item within 30 days of purchase.', [2], 'old'],
        ['They should keep the original packaging.', [4], ''],
        ['Refunds reach the customer’s account in 3 to 5 working days.', [], 'nis'],
      ],
      'ev' => ['0.71', '0.83', '0.58', '0.67'],
    ],
    'tuned' => [
      'rw' => 'damaged item return window · days from delivery · refund or replacement',
      'filter' => 'status = current · 1 archived document excluded',
      'ret' => [
        ['damaged-goods-sop.docx', '§1 Intake', 'Support logs the order, the photo and the damage type before…', '0.86', ''],
        ['returns-policy-v4.pdf', '§2.3 Photo evidence', 'Damage reported with a photo within 48 hours skips inspection…', '0.84', ''],
        ['returns-policy-v4.pdf', '§2.1 Damaged on arrival', 'Items that arrive damaged can be returned within 14 days of delivery…', '0.83', ''],
        ['shipping-faq.md', 'Delivery problems', 'If your parcel arrives damaged, keep the packaging and…', '0.77', ''],
        ['warranty-terms.pdf', '§4 Defects', 'Manufacturing defects are covered for 12 months from purchase…', '0.74', 'off'],
      ],
      'rr' => [[2, '0.97'], [1, '0.91'], [0, '0.62']],
      'ans' => [
        ['Damaged items can be returned within 14 days of delivery for a replacement or a full refund.', [1], ''],
        ['If the damage is reported with a photo within 48 hours, the inspection step is skipped.', [2], ''],
      ],
      'ev' => ['0.94', '0.92', '0.88', '0.90'],
      'route' => ['ok', 'Grounded · every sentence cited · answered'],
    ],
    'bare' => ['Most retailers accept returns of damaged goods within 30 days, and many extend that for defects covered by warranty. Check the retailer’s own policy for details.', '0.61'],
  ],
  [
    'q' => 'Does the Pro plan include single sign-on?', 'topic' => 'Product docs',
    'base' => [
      'ret' => [
        ['sso-setup-guide.md', 'Configure SAML', 'Admins on paid plans can connect an identity provider using SAML 2.0…', '0.89', ''],
        ['security-whitepaper.pdf', '§5 Identity', 'Customer data is protected by encryption at rest and SSO support…', '0.85', 'off'],
        ['pricing-plans.md', 'Plan table · 1,000-token chunk', '| Feature | Pro | Business | Enter… (row cut at the boundary)', '0.80', 'cut'],
        ['release-notes-2026-04.md', 'Sign-in', 'Google and Microsoft sign-in now available on every plan…', '0.78', ''],
        ['blog-security.md', 'Announcement', 'We believe good security should be available to everyone…', '0.73', 'off'],
      ],
      'ans' => [
        ['Yes, single sign-on is available on every paid plan, including Pro.', [1], 'nis'],
        ['Admins connect an identity provider using SAML 2.0 from the security settings.', [1], ''],
      ],
      'ev' => ['0.68', '0.88', '0.52', '0.50'],
    ],
    'tuned' => [
      'rw' => 'Pro plan · SAML single sign-on · included or add-on',
      'filter' => 'doc_type in pricing, docs, release notes',
      'ret' => [
        ['sso-setup-guide.md', 'Configure SAML', 'Admins on paid plans can connect an identity provider using SAML 2.0…', '0.87', ''],
        ['release-notes-2026-06.md', 'SSO add-on', 'SAML SSO is now available to Pro workspaces as a paid add-on…', '0.85', ''],
        ['release-notes-2026-04.md', 'Sign-in', 'Google and Microsoft sign-in now available on every plan…', '0.81', ''],
        ['pricing-plans.md', 'Plans · identity row', 'SAML SSO: Business included · Enterprise included · Pro not included', '0.80', ''],
        ['security-whitepaper.pdf', '§5 Identity', 'Customer data is protected by encryption at rest and SSO support…', '0.72', 'off'],
      ],
      'rr' => [[3, '0.96'], [1, '0.93'], [0, '0.71']],
      'ans' => [
        ['Not by default: SAML single sign-on is included in the Business and Enterprise plans.', [1], ''],
        ['Pro workspaces can add it as a paid add-on, available since June 2026.', [2], ''],
      ],
      'ev' => ['0.96', '0.94', '0.91', '0.92'],
      'route' => ['ok', 'Grounded · every sentence cited · answered'],
    ],
    'bare' => ['Single sign-on is often reserved for business or enterprise tiers, so the Pro plan may not include it. Contact the vendor’s sales team to confirm.', '0.55'],
  ],
  [
    'q' => 'Can I carry unused annual leave into next year?', 'topic' => 'HR policy',
    'base' => [
      'ret' => [
        ['employee-handbook.pdf', '§7 · 1,000-token chunk', '…annual leave … public holidays … carried forward … sick leave…', '0.86', 'cut'],
        ['holiday-calendar-2026.xlsx', 'Sheet 1', '26 Jan Republic Day · 15 Aug Independence Day · 2 Oct…', '0.81', 'off'],
        ['leave-policy-2025.pdf', '§3 Carry-over', 'Up to 15 days may be carried forward to the next year…', '0.80', 'old'],
        ['payroll-faq.md', 'Leave encashment', 'Encashment requests are processed with the March payroll…', '0.76', ''],
        ['leave-policy-2026.pdf', '§1 Scope', 'This policy applies to all permanent employees in India…', '0.74', ''],
      ],
      'ans' => [
        ['Yes, you can carry forward up to 15 days of annual leave.', [3], 'old'],
        ['Any days above that are paid out in your final settlement.', [], 'nis'],
      ],
      'ev' => ['0.74', '0.86', '0.60', '0.55'],
    ],
    'tuned' => [
      'rw' => 'carry forward unused annual leave · limit · expiry date · exceptions',
      'filter' => 'effective_year = 2026 · 1 superseded policy excluded',
      'ret' => [
        ['leave-policy-2026.pdf', '§1 Scope', 'This policy applies to all permanent employees in India…', '0.84', ''],
        ['hr-portal-guide.md', 'Exceptions', 'Managers can approve a carry-over exception under Requests…', '0.83', ''],
        ['leave-policy-2026.pdf', '§3.2 Carry-over', 'Up to 10 unused days carry over and must be used by 31 March…', '0.82', ''],
        ['payroll-faq.md', 'Leave encashment', 'Encashment requests are processed with the March payroll…', '0.75', ''],
        ['holiday-calendar-2026.xlsx', 'Sheet 1', '26 Jan Republic Day · 15 Aug Independence Day · 2 Oct…', '0.69', 'off'],
      ],
      'rr' => [[2, '0.98'], [1, '0.88'], [0, '0.57']],
      'ans' => [
        ['Yes, up to 10 unused days carry over into the next year.', [1], ''],
        ['Carried-over days must be used by 31 March, after which they lapse.', [1], ''],
        ['Your manager can approve an exception in the HR portal.', [2], ''],
      ],
      'ev' => ['0.95', '0.93', '0.89', '0.94'],
      'route' => ['ok', 'Grounded · every sentence cited · answered'],
    ],
    'bare' => ['Carry-over rules vary by employer and by local law. Many companies allow five to ten days to be carried forward. Check your HR policy.', '0.58'],
  ],
  [
    'q' => 'What is the API rate limit on the Team plan?', 'topic' => 'API docs',
    'base' => [
      'ret' => [
        ['rate-limits.md', 'Limits by plan · 2025', 'Starter 60 · Team 300 · Enterprise custom, requests per minute…', '0.88', 'old'],
        ['api-reference.md', 'Errors', '429 Too Many Requests is returned when a limit is exceeded…', '0.84', ''],
        ['status-incident-0712.md', 'Postmortem', 'Elevated 429 responses between 14:02 and 14:31 IST…', '0.80', 'off'],
        ['pricing-plans.md', 'Plan table · 1,000-token chunk', '| API access | Team | Enterprise | … (row cut at the boundary)', '0.77', 'cut'],
        ['sdk-readme.md', 'Retries', 'The SDK retries idempotent requests with exponential backoff…', '0.74', ''],
      ],
      'ans' => [
        ['The Team plan allows 300 requests per minute.', [1], 'old'],
        ['Requests over the limit return a 429 error.', [2], ''],
        ['Limits reset at the start of every hour.', [], 'nis'],
      ],
      'ev' => ['0.70', '0.90', '0.62', '0.48'],
    ],
    'tuned' => [
      'rw' => 'Team plan API rate limit · requests per minute · burst · 429 Retry-After',
      'filter' => 'latest version per document · changelog included',
      'ret' => [
        ['api-reference.md', 'Errors', '429 Too Many Requests is returned with a Retry-After header…', '0.86', ''],
        ['sdk-readme.md', 'Retries', 'The SDK retries idempotent requests with exponential backoff…', '0.80', ''],
        ['rate-limits.md', 'Limits by plan · 2026', 'Team: 600 requests per minute per workspace, bursts to 1,000 over 10 s…', '0.79', ''],
        ['changelog-2026-08.md', '4 August', 'Team rate limit raised from 300 to 600 requests per minute…', '0.78', ''],
        ['status-incident-0712.md', 'Postmortem', 'Elevated 429 responses between 14:02 and 14:31 IST…', '0.66', 'off'],
      ],
      'rr' => [[2, '0.97'], [3, '0.94'], [0, '0.90']],
      'ans' => [
        ['The Team plan allows 600 requests per minute per workspace, raised from 300 on 4 August 2026.', [1, 2], ''],
        ['Short bursts of up to 1,000 requests over 10 seconds are allowed.', [1], ''],
        ['Requests over the limit return HTTP 429 with a Retry-After header.', [3], ''],
      ],
      'ev' => ['0.97', '0.95', '0.86', '0.93'],
      'route' => ['ok', 'Grounded · every sentence cited · answered'],
    ],
    'bare' => ['API rate limits typically range from 60 to 1,000 requests per minute depending on the plan. The provider’s documentation lists the exact figures.', '0.52'],
  ],
  [
    'q' => 'Who approves an expense claim over ₹50,000?', 'topic' => 'Finance policy',
    'base' => [
      'ret' => [
        ['expense-policy-v4-draft.docx', '§2 Approvals · draft', 'Claims above ₹50,000 need department head sign-off…', '0.87', 'draft'],
        ['travel-policy.pdf', '§6 Hotels', 'Hotel stays above the city cap need prior approval…', '0.82', 'off'],
        ['expense-policy-v3.pdf', '§2 Approvals', 'Claims above ₹50,000 are approved by the department head…', '0.81', ''],
        ['finance-faq.md', 'Reimbursement', 'Approved claims are paid in the next payroll cycle…', '0.78', ''],
        ['onboarding-checklist.md', 'Week 1', 'Set up your expense account and corporate card…', '0.72', 'off'],
      ],
      'ans' => [
        ['Expense claims above ₹50,000 are approved by the department head.', [1], 'draft'],
        ['Approvals are usually completed within two working days.', [], 'nis'],
      ],
      'ev' => ['0.66', '0.84', '0.55', '0.46'],
    ],
    'tuned' => [
      'rw' => 'approver · expense claim above ₹50,000 · delegation of authority · current',
      'filter' => 'status = approved · 1 draft excluded',
      'ret' => [
        ['finance-faq.md', 'Reimbursement', 'Approved claims are paid in the next payroll cycle…', '0.83', ''],
        ['expense-policy-v3.pdf', '§2 Approvals', 'Claims above ₹50,000 are approved by the department head…', '0.82', ''],
        ['delegation-of-authority.xlsx', 'Row 14 · Expenses', '₹50,000–₹1,00,000: Finance controller · above ₹1,00,000: CFO…', '0.81', ''],
        ['travel-policy.pdf', '§6 Hotels', 'Hotel stays above the city cap need prior approval…', '0.70', 'off'],
        ['onboarding-checklist.md', 'Week 1', 'Set up your expense account and corporate card…', '0.61', 'off'],
      ],
      'rr' => [[2, '0.95'], [1, '0.93'], [0, '0.41']],
      'ans' => [
        ['The sources disagree: the delegation-of-authority matrix names the finance controller for claims of ₹50,000 to ₹1,00,000.', [1], ''],
        ['The expense policy (v3) names the department head.', [2], ''],
        ['I have sent this to Finance operations to confirm, with both sources attached.', [], 'hand'],
      ],
      'ev' => ['0.93', '0.71', '0.84', '0.88'],
      'route' => ['hand', 'Sources conflict · confidence 0.52 < 0.70 · handed to Finance operations'],
    ],
    'bare' => ['Large expense claims are usually approved by a senior manager or the finance department. Your company’s expense policy will name the approver.', '0.49'],
  ],
];
$tapi_ev_k  = ['Faithfulness', 'Answer relevance', 'Context precision', 'Context recall'];
$tapi_ev_th = ['0.90', '0.85', '0.80', '0.80'];   // release thresholds, drawn as a tick on each bar
$tapi_tag   = ['old' => 'superseded', 'cut' => 'cut mid-table', 'off' => 'off-topic', 'draft' => 'draft'];
$tapi_flag  = ['old' => 'superseded source', 'draft' => 'draft source', 'nis' => 'not in sources'];
$tapi_cfg   = [
    'base'  => ['Fixed 1,000-token chunks', 'Vector search only', 'No reranker', 'Citations optional'],
    'tuned' => ['Semantic chunks · 300–500 tokens', 'Hybrid BM25 + vector', 'Cross-encoder reranker', 'Citations enforced'],
    'bare'  => ['No retrieval', 'No sources', 'No citations'],
];

/* word-by-word answer, so the stream can be animated with CSS only ($k runs across the whole answer) */
$tapi_words = function (string $text, int &$k): string {
    $out = '';
    foreach (preg_split('/\s+/u', trim($text)) as $w) { $out .= '<span class="w" style="--k:' . $k++ . '">' . e($w) . '</span> '; }
    return $out;
};
$tapi_answer = function (array $sents, int &$k) use ($tapi_words, $tapi_flag): string {
    $out = '';
    foreach ($sents as $s) {
        $cites = '';
        foreach ($s[1] as $c) { $cites .= '<i class="tap-cite w" style="--k:' . $k++ . '">' . (int) $c . '</i>'; }
        $body = rtrim($tapi_words($s[0], $k)) . $cites;
        if ($s[2] === 'hand') {
            $out .= '<span class="tap-ins__hand">' . $body . '</span> ';
        } elseif ($s[2] !== '') {
            $out .= '<mark class="tap-ins__mk tap-ins__mk--' . e($s[2]) . '">' . $body . '<span class="tap-ins__flag w" style="--k:' . $k++ . '">' . e($tapi_flag[$s[2]]) . '</span></mark> ';
        } else {
            $out .= $body . ' ';
        }
    }
    return $out;
};
$tapi_chunks = function (array $ret) use ($tapi_tag): string {
    $out = '';
    foreach ($ret as $j => $c) {
        $out .= '<li class="tap-ins__chunk' . ($c[4] ? ' is-' . e($c[4]) : '') . '" style="--k:' . $j . ';--v:' . e($c[3]) . '">'
              . '<span class="tap-ins__rank">' . ($j + 1) . '</span>'
              . '<span class="tap-ins__doc"><b>' . e($c[0]) . '</b><span>' . e($c[1]) . '</span>' . ($c[4] ? '<em class="tap-ins__tag">' . e($tapi_tag[$c[4]]) . '</em>' : '') . '</span>'
              . '<span class="tap-ins__sc">' . e($c[3]) . '<i></i></span>'
              . '<span class="tap-ins__snip">' . e($c[2]) . '</span></li>';
    }
    return $out;
};
$tapi_evals = function (array $ev, string $id) use ($tapi_ev_k, $tapi_ev_th): string {
    $out = '<div class="tap-ins__ev" role="group" aria-labelledby="' . $id . '-ev"><p class="tap-ins__evt" id="' . $id . '-ev">Evals</p><div class="tap-ins__evg">';
    foreach ($tapi_ev_k as $j => $label) {
        $v   = $ev[$j];
        $na  = $v === null;
        $low = !$na && (float) $v < (float) $tapi_ev_th[$j];
        $out .= '<div class="tap-meter' . ($low || $na ? ' is-low' : '') . '" style="--i:' . $j . '">'
              . '<span class="tap-meter__k">' . e($label) . '</span>'
              . '<span class="tap-meter__v">' . ($na ? 'n/a' : e($v)) . '</span>'
              . '<span class="tap-meter__t" aria-hidden="true"><i style="--v:' . ($na ? '0' : e($v)) . '"></i><b style="--th:' . e($tapi_ev_th[$j]) . '"></b></span></div>';
    }
    return $out . '</div></div>';
};
$tapi_stage = function (string $id, int $n, string $name, string $sum, string $body): string {
    return '<div class="tap-ins__st">'
         . '<h4 class="tap-ins__sh"><button type="button" class="tap-ins__sbtn" data-ins-stage="' . $n . '" aria-expanded="true" aria-controls="' . $id . '-s' . $n . '">'
         . '<b>' . sprintf('%02d', $n) . '</b><span class="tap-ins__sn">' . e($name) . '</span><span class="tap-ins__ss">' . e($sum) . '</span><i aria-hidden="true"></i></button></h4>'
         . '<div class="tap-ins__sb" id="' . $id . '-s' . $n . '">' . $body . '</div></div>';
};
$tapi_cfgl = function (array $items): string {
    $out = '<ul class="tap-ins__cfg" role="list">';
    foreach ($items as $it) { $out .= '<li>' . e($it) . '</li>'; }
    return $out . '</ul>';
};
?>
<section class="band band--ink tap-inspector" id="inspector" aria-labelledby="inspector-t">
  <span class="tap-inspector__grid dots-ink" aria-hidden="true"></span>
  <div class="wrap">
    <div class="tap-head" data-rv>
      <div>
        <p class="tap-eb"><span class="tap-eb__box" aria-hidden="true"></span><span class="tap-eb__n">04.2</span><span>RAG inspector</span><span class="tap-eb__p">/inspector</span></p>
        <h2 class="h2" id="inspector-t"><span class="g">Same question, two pipelines.</span> See why one is right.</h2>
      </div>
      <div>
        <p class="lead">Pick a question about a fictional company’s policies and product docs. The baseline is what most first RAG builds look like; the tuned pipeline is what we ship. Open any stage to see what each one retrieved, ranked and wrote, and how it scored.</p>
      </div>
    </div>

    <div class="tap-ins tap-win" data-rv>
      <div class="tap-win__bar tap-ins__bar">
        <span class="tap-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tap-win__path"><b>rag-inspector</b> · your-company-kb · 1,284 docs · 18,402 chunks</span>
        <span class="tap-win__end">
          <button type="button" class="bdh-switch tap-ins__sw" data-ins-bare aria-pressed="false"><span class="bdh-switch__track" aria-hidden="true"></span>No retrieval</button>
          <span class="tap-ill">Illustrative</span>
        </span>
      </div>

      <div class="tap-ins__body">
        <div class="tap-ins__side">
          <p class="tap-ins__lbl" id="ins-qs-l">Questions</p>
          <div class="tap-ins__qs" role="tablist" aria-orientation="vertical" aria-labelledby="ins-qs-l">
            <?php foreach ($tapi_q as $tapi_i => $tapi_x):
                $tapi_d = (float) $tapi_x['tuned']['ev'][0] - (float) $tapi_x['base']['ev'][0]; ?>
              <button type="button" role="tab" class="tap-ins__qb" id="ins-t<?= $tapi_i ?>" aria-controls="ins-p<?= $tapi_i ?>" aria-selected="<?= $tapi_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tapi_i === 0 ? '0' : '-1' ?>">
                <span class="tap-ins__qn">Q<?= $tapi_i + 1 ?></span>
                <span class="tap-ins__qt"><?= e($tapi_x['q']) ?></span>
                <span class="tap-ins__qm"><?= e($tapi_x['topic']) ?> · faithfulness +<?= number_format($tapi_d, 2) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
          <dl class="tap-ins__legend">
            <div><dt><span class="tap-ins__mk tap-ins__mk--nis">text</span></dt><dd>Sentence not supported by any retrieved chunk</dd></div>
            <div><dt><span class="tap-ins__mk tap-ins__mk--old">text</span></dt><dd>Supported, but by a superseded or draft source</dd></div>
            <div><dt><i class="tap-cite">1</i></dt><dd>Citation to a chunk the model was given</dd></div>
          </dl>
        </div>

        <div class="tap-ins__ab" role="group" aria-label="Pipeline shown">
          <div class="bdh-seg">
            <button type="button" data-ins-ab="0" aria-pressed="true"><b>A</b> <span data-ins-alabel>Baseline</span></button>
            <button type="button" data-ins-ab="1" aria-pressed="false"><b>B</b> Tuned</button>
          </div>
        </div>

        <div class="bdh-panes tap-ins__panes">
          <?php foreach ($tapi_q as $tapi_i => $tapi_x):
              $tapi_b = $tapi_x['base']; $tapi_t = $tapi_x['tuned'];
              $tapi_nis = count(array_filter($tapi_b['ans'], fn ($tapi_s) => $tapi_s[2] !== ''));
              $tapi_flagged = count(array_filter($tapi_b['ret'], fn ($tapi_c) => $tapi_c[4] !== ''));
              $tapi_tflag = count(array_filter($tapi_t['ret'], fn ($tapi_c) => $tapi_c[4] !== ''));
              $tapi_hand = $tapi_t['route'][0] === 'hand';
              $tapi_sum = 'Question ' . ($tapi_i + 1) . ' of ' . count($tapi_q) . ': ' . $tapi_x['q'] . ' Baseline RAG faithfulness ' . $tapi_b['ev'][0] . ', context precision ' . $tapi_b['ev'][2] . '. Tuned RAG faithfulness ' . $tapi_t['ev'][0] . ', context precision ' . $tapi_t['ev'][2] . '.' . ($tapi_hand ? ' The tuned pipeline found conflicting sources and handed the question to a person.' : '');
          ?>
            <div class="bdh-pane tap-ins__pane<?= $tapi_i === 0 ? ' is-on' : '' ?>" id="ins-p<?= $tapi_i ?>" role="tabpanel" aria-labelledby="ins-t<?= $tapi_i ?>" data-ins-sum="<?= e($tapi_sum) ?>">
              <p class="tap-ins__ask"><span>Question</span><?= e($tapi_x['q']) ?></p>
              <div class="tap-ins__grid">

                <?php /* ---- A · baseline ---- */ $tapi_id = 'ins-p' . $tapi_i . '-b'; $tapi_k = 0; ?>
                <article class="tap-ins__col tap-ins__col--base" aria-labelledby="<?= $tapi_id ?>-t">
                  <header class="tap-ins__ch">
                    <p class="tap-ins__cn">A</p>
                    <h3 class="tap-ins__ct" id="<?= $tapi_id ?>-t">Baseline RAG</h3>
                    <?= $tapi_cfgl($tapi_cfg['base']) ?>
                  </header>
                  <?= $tapi_stage($tapi_id, 1, 'Query', 'passed through', '<p class="tap-ins__q"><span>query</span>' . e($tapi_x['q']) . '</p><p class="tap-ins__none">No rewrite, no metadata filter.</p>') ?>
                  <?= $tapi_stage($tapi_id, 2, 'Retrieve', 'top 5 · ' . $tapi_flagged . ' flagged', '<ol class="tap-ins__chunks">' . $tapi_chunks($tapi_b['ret']) . '</ol>') ?>
                  <?= $tapi_stage($tapi_id, 3, 'Rerank', 'skipped', '<p class="tap-ins__none">No reranker. All five chunks go to the model in vector-score order, off-topic chunks included.</p><div class="tap-ins__tok"><span>Context sent to the model</span><i style="--v:1"></i><b>≈ 5,000 tokens</b></div>') ?>
                  <?= $tapi_stage($tapi_id, 4, 'Answer', $tapi_nis . ' sentence' . ($tapi_nis === 1 ? '' : 's') . ' flagged', '<p class="tap-ins__ans">' . $tapi_answer($tapi_b['ans'], $tapi_k) . '</p><p class="tap-ins__route is-warn"><span class="tap-ins__rd" aria-hidden="true"></span>Shown to the user as written</p>') ?>
                  <?= $tapi_evals($tapi_b['ev'], $tapi_id) ?>
                </article>

                <?php /* ---- A · no retrieval (shown by the switch) ---- */ $tapi_id = 'ins-p' . $tapi_i . '-n'; $tapi_k = 0; ?>
                <article class="tap-ins__col tap-ins__col--bare" aria-labelledby="<?= $tapi_id ?>-t">
                  <header class="tap-ins__ch">
                    <p class="tap-ins__cn">A</p>
                    <h3 class="tap-ins__ct" id="<?= $tapi_id ?>-t">Model only</h3>
                    <?= $tapi_cfgl($tapi_cfg['bare']) ?>
                  </header>
                  <?= $tapi_stage($tapi_id, 1, 'Query', 'passed through', '<p class="tap-ins__q"><span>query</span>' . e($tapi_x['q']) . '</p>') ?>
                  <?= $tapi_stage($tapi_id, 2, 'Retrieve', 'off', '<p class="tap-ins__none">Retrieval switched off. The model answers from what it learned in training, with no access to your documents.</p>') ?>
                  <?= $tapi_stage($tapi_id, 3, 'Rerank', 'off', '<p class="tap-ins__none">Nothing to rank.</p>') ?>
                  <?= $tapi_stage($tapi_id, 4, 'Answer', 'ungrounded', '<p class="tap-ins__ans"><mark class="tap-ins__mk tap-ins__mk--nis">' . rtrim($tapi_words($tapi_x['bare'][0], $tapi_k)) . '<span class="tap-ins__flag w" style="--k:' . $tapi_k . '">ungrounded · no sources</span></mark></p><p class="tap-ins__route is-warn"><span class="tap-ins__rd" aria-hidden="true"></span>Plausible, generic and unverifiable</p>') ?>
                  <?= $tapi_evals([null, $tapi_x['bare'][1], null, null], $tapi_id) ?>
                </article>

                <?php /* ---- B · tuned ---- */ $tapi_id = 'ins-p' . $tapi_i . '-t'; $tapi_k = 0;
                  $tapi_rr = '';
                  foreach ($tapi_t['rr'] as $tapi_j => $tapi_r) {
                      $tapi_c = $tapi_t['ret'][$tapi_r[0]];
                      $tapi_rr .= '<li class="tap-ins__chunk tap-ins__chunk--rr' . ((float) $tapi_r[1] < 0.5 ? ' is-drop' : '') . '" style="--k:' . $tapi_j . ';--d:' . ($tapi_r[0] - $tapi_j) . ';--v:' . e($tapi_r[1]) . '">'
                               . '<span class="tap-ins__rank">' . ($tapi_j + 1) . '</span>'
                               . '<span class="tap-ins__doc"><b>' . e($tapi_c[0]) . '</b><span>' . e($tapi_c[1]) . '</span><em class="tap-ins__from">was #' . ($tapi_r[0] + 1) . '</em></span>'
                               . '<span class="tap-ins__sc">' . e($tapi_r[1]) . '<i></i></span></li>';
                  }
                ?>
                <article class="tap-ins__col tap-ins__col--tuned" aria-labelledby="<?= $tapi_id ?>-t">
                  <header class="tap-ins__ch">
                    <p class="tap-ins__cn">B</p>
                    <h3 class="tap-ins__ct" id="<?= $tapi_id ?>-t">Tuned RAG</h3>
                    <?= $tapi_cfgl($tapi_cfg['tuned']) ?>
                  </header>
                  <?= $tapi_stage($tapi_id, 1, 'Query', 'rewritten + filtered', '<p class="tap-ins__q"><span>rewrite</span>' . e($tapi_t['rw']) . '</p><p class="tap-ins__filt"><span>filter</span>' . e($tapi_t['filter']) . '</p>') ?>
                  <?= $tapi_stage($tapi_id, 2, 'Retrieve', 'top 5 · hybrid · ' . $tapi_tflag . ' flagged', '<ol class="tap-ins__chunks">' . $tapi_chunks($tapi_t['ret']) . '</ol>') ?>
                  <?= $tapi_stage($tapi_id, 3, 'Rerank', 'cross-encoder · top 3', '<ol class="tap-ins__chunks tap-ins__rr">' . $tapi_rr . '</ol><div class="tap-ins__tok"><span>Context sent to the model</span><i style="--v:.22"></i><b>≈ 1,100 tokens</b></div><p class="tap-ins__note">Chunks scoring under 0.50 are dropped before generation.</p>') ?>
                  <?= $tapi_stage($tapi_id, 4, 'Answer', $tapi_hand ? 'handed to a person' : 'every sentence cited', '<p class="tap-ins__ans">' . $tapi_answer($tapi_t['ans'], $tapi_k) . '</p><p class="tap-ins__route' . ($tapi_hand ? ' is-hand' : ' is-ok') . '"><span class="tap-ins__rd" aria-hidden="true"></span>' . e($tapi_t['route'][1]) . '</p>') ?>
                  <?= $tapi_evals($tapi_t['ev'], $tapi_id) ?>
                </article>

              </div>
              <?php /* narrow screens show one column at a time; this strip keeps both sets of scores in view */ ?>
              <table class="tap-ins__cmp">
                <caption class="bdh-sr">Eval scores for question <?= $tapi_i + 1 ?>: column A against column B</caption>
                <thead><tr><th scope="col">Evals</th><th scope="col"><b>A</b></th><th scope="col"><b>B</b></th></tr></thead>
                <tbody>
                <?php foreach ($tapi_ev_k as $tapi_j => $tapi_lab):
                    $tapi_av = $tapi_b['ev'][$tapi_j]; $tapi_nv = [null, $tapi_x['bare'][1], null, null][$tapi_j]; $tapi_bv = $tapi_t['ev'][$tapi_j]; ?>
                  <tr><th scope="row"><?= e($tapi_lab) ?></th><td class="tap-ins__cmpa<?= (float) $tapi_av < (float) $tapi_ev_th[$tapi_j] ? ' is-low' : '' ?>"><i class="is-rag"><?= e($tapi_av) ?></i><i class="is-bare"><?= $tapi_nv === null ? 'n/a' : e($tapi_nv) ?></i></td><td class="tap-ins__cmpb<?= (float) $tapi_bv < (float) $tapi_ev_th[$tapi_j] ? ' is-low' : '' ?>"><?= e($tapi_bv) ?></td></tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <p class="bdh-sr" aria-live="polite" data-ins-live></p>
    </div>

    <div class="tap-ins__notes" data-rv-s>
      <div class="tap-ins__nt">
        <p class="tap-ins__ntk"><?= xt_icon('eval', ['size' => 20]) ?>The four scores</p>
        <dl class="tap-ins__defs">
          <div><dt>Faithfulness</dt><dd>Share of the answer’s claims that the retrieved context supports.</dd></div>
          <div><dt>Answer relevance</dt><dd>How directly the answer addresses the question asked.</dd></div>
          <div><dt>Context precision</dt><dd>Whether the relevant chunks are ranked above the noise.</dd></div>
          <div><dt>Context recall</dt><dd>Whether retrieval found everything the answer needed.</dd></div>
        </dl>
        <p class="tap-ins__ntf">Metric names as used in open-source RAG evaluation tooling such as Ragas. LLM judges are calibrated against labels from your domain experts before their scores gate a release.</p>
      </div>
      <div class="tap-ins__nt">
        <p class="tap-ins__ntk"><?= xt_icon('link', ['size' => 20]) ?>Citations are enforced</p>
        <p class="tap-ins__ntd">Every sentence must point at a chunk the model was given. A check after generation strips or regenerates sentences that do not, and an answer left with no supported sentences is never shown. Superseded and draft documents are filtered out by metadata before search, not left for the model to notice.</p>
      </div>
      <div class="tap-ins__nt">
        <p class="tap-ins__ntk"><?= xt_icon('approve', ['size' => 20]) ?>Low confidence goes to a person</p>
        <p class="tap-ins__ntd">When sources conflict or retrieval scores fall below threshold, the assistant says so and routes the question, with its sources, to the team that owns the answer. Their reply is logged, and the question joins the golden set the next release is tested against.</p>
      </div>
    </div>
  </div>
</section>
