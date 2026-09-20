<?php /* DRAFT COPY — review before launch */
/* Composer — SIGNATURE. The Platform Composer: pick a business outcome (radiogroup) and the mock app lights
   the capabilities involved on the shared topology, draws the build order as a numbered path and shows the
   plan: phases in weeks, the team, the quality gates and the first-90-day measures. All five plans are in the
   markup (plan 1 visible); composer.js switches them, draws the path and autoplays until the reader takes over.
   PLACEHOLDER: every timing, team shape and phase length below is a typical range — confirm before launch. */
$cmp_goals = [
    [
        'title' => 'Launch an AI support assistant', 'icon' => 'chat', 'weeks' => 12,
        'why'   => 'Answers customer questions from your own knowledge and records, hands off to people when unsure.',
        'phases' => [
            ['03', 'Use-case & risk assessment',          1, 2,  false],
            ['02', 'Knowledge & CRM data ready',          2, 4,  false],
            ['04', 'RAG assistant with evals',            3, 8,  false],
            ['05', 'Gateway, caching & cost caps',        6, 9,  false],
            ['06', 'Red-team & OWASP LLM Top 10 review',  7, 8,  false],
            ['07', 'Human handoff & ongoing support',     9, 12, true],
        ],
        'team'     => ['AI lead', 'Product designer', '2 × AI engineers', 'Data engineer', 'Security engineer', 'Your support-operations lead'],
        'gates'    => ['Faithfulness ≥ 0.90 on the golden set', 'Zero critical red-team findings', 'p95 < 2.5 s, first token < 800 ms', 'Handoff to a person on low confidence'],
        'measures' => ['Containment rate', 'Cost per resolved conversation', 'CSAT on assisted conversations'],
        'standards'=> ['owasp-llm', 'nist-ai-rmf', 'iso42001', 'dpdp'],
        'services' => ['knowledge-assistant', 'ai-agent'],   // hub offer keys, data/services/technology-intelligence.php
        'slug'     => 'ai-support-assistant',
    ],
    [
        'title' => 'Replace a legacy CRM', 'icon' => 'database', 'weeks' => 18,
        'why'   => 'One customer record your sales and service teams trust, migrated without losing a quarter.',
        'phases' => [
            ['09', 'Data & process audit',                 1,  3,  false],
            ['02', 'Data model & CRM build',               3,  14, false],
            ['01', 'Sales & service interface',            5,  14, false],
            ['07', 'ERP, email & telephony integrations',  6,  14, false],
            ['06', 'SSO, access model & audit logging',    8,  12, false],
            ['10', 'Cutover squad & hypercare',            14, 18, false],
        ],
        'team'     => ['Solution architect', '3 × full-stack engineers', 'Data engineer', 'Integration engineer', 'QA engineer', 'Your sales-operations owner'],
        'gates'    => ['100% row-level reconciliation of migrated records', 'Two parallel-run cycles, zero P1 defects', 'Role-based access reviewed and signed off', 'Rollback rehearsed before cutover'],
        'measures' => ['Time from lead to quote', 'Duplicate record rate', 'Weekly active users'],
        'standards'=> ['iso27001', 'soc2', 'dpdp', 'owasp-asvs'],
        'services' => ['custom-platform', 'system-integration'],
        'slug'     => 'replace-legacy-crm',
    ],
    [
        'title' => 'Make the product fast on real phones', 'icon' => 'gauge', 'weeks' => 10,
        'why'   => 'Good Core Web Vitals in the field, on the mid-range Android phones most customers actually carry.',
        'phases' => [
            ['09', 'Field-data performance audit',          1, 2,  false],
            ['01', 'Image, font & JavaScript budgets',      2, 6,  false],
            ['05', 'Edge caching & CDN rules',              3, 6,  false],
            ['01', 'Render path & hydration fixes',         4, 9,  false],
            ['08', 'Template-level search checks',          6, 9,  false],
            ['07', 'Budgets in CI & real-user monitoring',  8, 10, true],
        ],
        'team'     => ['Performance lead', '2 × frontend engineers', 'Platform engineer', 'Search specialist'],
        'gates'    => ['LCP ≤ 2.5 s at p75, field data', 'INP ≤ 200 ms at p75', 'CLS ≤ 0.1 at p75', 'JavaScript budget enforced on every merge'],
        'measures' => ['p75 LCP on low-end Android', 'Mobile conversion rate', 'Organic sessions on mobile'],
        'standards'=> ['cwv', 'wcag22', 'sci'],
        'services' => ['tech-audit', 'website'],
        'slug'     => 'fast-on-real-phones',
    ],
    [
        'title' => 'Get cited in AI answers', 'icon' => 'search', 'weeks' => 12,
        'why'   => 'Your pages ranked on Google and quoted by AI Overviews, ChatGPT and Perplexity for the questions buyers ask.',
        'phases' => [
            ['09', 'Search & answer visibility audit',   1, 2,  false],
            ['08', 'Entity & prompt map',                2, 4,  false],
            ['01', 'Technical SEO & structured data',    3, 7,  false],
            ['08', 'Answer-ready content system',        4, 12, false],
            ['02', 'Product & knowledge data feeds',     5, 9,  false],
            ['07', 'Prompt-panel tracking & reporting',  8, 12, true],
        ],
        'team'     => ['Search lead', 'Content strategist', 'Technical SEO engineer', 'Data engineer', 'Analyst'],
        'gates'    => ['Valid structured data on every key template', 'Core Web Vitals good at p75', 'Facts consistent across site, feeds and profiles', 'Prompt-panel baseline recorded before changes'],
        'measures' => ['Share of answer across a fixed prompt panel', 'Citations per engine', 'Organic and AI-referred conversions'],
        'standards'=> ['cwv', 'wcag22', 'gdpr'],
        'services' => ['ai-visibility', 'seo-programme'],
        'slug'     => 'cited-in-ai-answers',
    ],
    [
        'title' => 'Stand up an embedded AI squad', 'icon' => 'users', 'weeks' => 12,
        'why'   => 'Vetted AI engineers inside your sprints, shipping a first feature to production with evals from day one.',
        'phases' => [
            ['10', 'Role profiles & squad match',              1,  2,  false],
            ['03', 'Use-case backlog & priorities',            1,  3,  false],
            ['06', 'Access, data handling & AI policy',        2,  3,  false],
            ['10', 'Onboarding into your sprints',             3,  4,  false],
            ['04', 'First AI feature in production',           4,  10, false],
            ['09', 'Quarterly delivery & AI-readiness review', 12, 12, true],
        ],
        'team'     => ['Squad lead', '2 × AI engineers', 'ML & data engineer', 'QA engineer, eval focus', 'Your product owner'],
        'gates'    => ['Background checks and NDAs complete', 'Least-privilege access in your tools', 'Eval suite in CI before the first release', 'DORA metrics reported from sprint 1'],
        'measures' => ['Lead time for changes', 'Change failure rate', 'AI features shipped per quarter'],
        'standards'=> ['iso27001', 'iso42001', 'dora-metrics'],
        'services' => ['dedicated-squad', 'ai-agent'],
        'package'  => 'squad',
        'slug'     => 'embedded-ai-squad',
    ],
];
$cmp_by_n = [];
foreach ($TI as $cmp_s => $cmp_c) { $cmp_by_n[$cmp_c['n']] = $cmp_s; }
$cmp_order = function (array $cmp_g) use ($cmp_by_n): array {
    $cmp_o = [];
    foreach ($cmp_g['phases'] as $cmp_p) { if (!in_array($cmp_p[0], $cmp_o, true)) $cmp_o[] = $cmp_p[0]; }
    return $cmp_o;
};
/* The build path is routed, not drawn straight: every step leaves its node vertically, runs along the
   gutter between two layers (y 190 · 350 · 510) or a side rail (x 60 · 940), and drops into the next node.
   A step therefore never crosses a capability that is not in the plan. $cmp_geom returns the rounded path
   and the fraction of the route at which each node sits, so composer.js can pulse the nodes in time. */
$cmp_rows   = [110 => 0, 270 => 1, 430 => 2, 590 => 3];
$cmp_gut    = [190, 350, 510];
$cmp_rail   = [60, 940];
$cmp_row_xs = [];
foreach ($TIH['nodes'] as $cmp_xy) { $cmp_row_xs[$cmp_xy[1]][] = $cmp_xy[0]; }

$cmp_leg = function (array $cmp_a, array $cmp_b) use ($cmp_rows, $cmp_gut, $cmp_rail, $cmp_row_xs): array {
    [$cmp_x1, $cmp_y1] = $cmp_a; [$cmp_x2, $cmp_y2] = $cmp_b;
    $cmp_r1 = $cmp_rows[$cmp_y1]; $cmp_r2 = $cmp_rows[$cmp_y2];
    $cmp_step = abs($cmp_r1 - $cmp_r2);
    if ($cmp_step === 0) {
        $cmp_lo = min($cmp_x1, $cmp_x2); $cmp_hi = max($cmp_x1, $cmp_x2);
        $cmp_blocked = false;
        foreach ($cmp_row_xs[$cmp_y1] as $cmp_x) { if ($cmp_x > $cmp_lo && $cmp_x < $cmp_hi) $cmp_blocked = true; }
        if (!$cmp_blocked) return [[$cmp_x1, $cmp_y1], [$cmp_x2, $cmp_y2]];
        $cmp_g = $cmp_r1 < 3 ? $cmp_gut[$cmp_r1] : $cmp_gut[$cmp_r1 - 1];
        return [[$cmp_x1, $cmp_y1], [$cmp_x1, $cmp_g], [$cmp_x2, $cmp_g], [$cmp_x2, $cmp_y2]];
    }
    if ($cmp_step === 1) {
        $cmp_g = $cmp_gut[min($cmp_r1, $cmp_r2)];
        return [[$cmp_x1, $cmp_y1], [$cmp_x1, $cmp_g], [$cmp_x2, $cmp_g], [$cmp_x2, $cmp_y2]];
    }
    $cmp_down = $cmp_r2 > $cmp_r1;
    $cmp_ga = $cmp_down ? $cmp_gut[$cmp_r1] : $cmp_gut[$cmp_r1 - 1];
    $cmp_gb = $cmp_down ? $cmp_gut[$cmp_r2 - 1] : $cmp_gut[$cmp_r2];
    $cmp_rl = (($cmp_x1 + $cmp_x2) / 2 <= 500) ? $cmp_rail[0] : $cmp_rail[1];
    return [[$cmp_x1, $cmp_y1], [$cmp_x1, $cmp_ga], [$cmp_rl, $cmp_ga], [$cmp_rl, $cmp_gb], [$cmp_x2, $cmp_gb], [$cmp_x2, $cmp_y2]];
};

$cmp_geom = function (array $cmp_ns) use ($cmp_by_n, $TIH, $cmp_leg): array {
    $cmp_pts = []; $cmp_at = [];
    foreach ($cmp_ns as $cmp_k => $cmp_n) {
        $cmp_xy = $TIH['nodes'][$cmp_by_n[$cmp_n]];
        if ($cmp_k === 0) { $cmp_pts[] = $cmp_xy; $cmp_at[] = 0; continue; }
        $cmp_prev = $TIH['nodes'][$cmp_by_n[$cmp_ns[$cmp_k - 1]]];
        foreach ($cmp_leg($cmp_prev, $cmp_xy) as $cmp_j => $cmp_p) {
            if ($cmp_j === 0) continue;                                        // the leg starts where the last one ended
            $cmp_last = end($cmp_pts);
            if (abs($cmp_last[0] - $cmp_p[0]) < 0.5 && abs($cmp_last[1] - $cmp_p[1]) < 0.5) continue;
            $cmp_pts[] = $cmp_p;
        }
        $cmp_at[] = count($cmp_pts) - 1;
    }
    /* cumulative length, so a node's position on the route is a fraction of the whole */
    $cmp_cum = [0.0]; $cmp_tot = 0.0;
    for ($cmp_i = 1; $cmp_i < count($cmp_pts); $cmp_i++) {
        $cmp_tot += hypot($cmp_pts[$cmp_i][0] - $cmp_pts[$cmp_i - 1][0], $cmp_pts[$cmp_i][1] - $cmp_pts[$cmp_i - 1][1]);
        $cmp_cum[] = $cmp_tot;
    }
    $cmp_stops = array_map(fn ($cmp_i) => $cmp_tot > 0 ? round($cmp_cum[$cmp_i] / $cmp_tot, 4) : 0, $cmp_at);
    /* polyline → rounded corners */
    $cmp_r = 22; $cmp_n = count($cmp_pts);
    $cmp_f = fn (float $cmp_v): string => rtrim(rtrim(number_format($cmp_v, 1, '.', ''), '0'), '.');
    $cmp_d = 'M' . $cmp_f($cmp_pts[0][0]) . ' ' . $cmp_f($cmp_pts[0][1]);
    for ($cmp_i = 1; $cmp_i < $cmp_n - 1; $cmp_i++) {
        $cmp_p0 = $cmp_pts[$cmp_i - 1]; $cmp_p1 = $cmp_pts[$cmp_i]; $cmp_p2 = $cmp_pts[$cmp_i + 1];
        $cmp_l1 = hypot($cmp_p1[0] - $cmp_p0[0], $cmp_p1[1] - $cmp_p0[1]);
        $cmp_l2 = hypot($cmp_p2[0] - $cmp_p1[0], $cmp_p2[1] - $cmp_p1[1]);
        $cmp_rr = min($cmp_r, $cmp_l1 / 2, $cmp_l2 / 2);
        /* a step that leaves a node the way it arrived retraces its own stub: no corner to round there */
        $cmp_cr = $cmp_l1 > 0 && $cmp_l2 > 0
            ? abs((($cmp_p0[0] - $cmp_p1[0]) * ($cmp_p2[1] - $cmp_p1[1]) - ($cmp_p0[1] - $cmp_p1[1]) * ($cmp_p2[0] - $cmp_p1[0])) / ($cmp_l1 * $cmp_l2))
            : 0;
        if ($cmp_rr < 1 || $cmp_cr < 0.02) { $cmp_d .= ' L' . $cmp_f($cmp_p1[0]) . ' ' . $cmp_f($cmp_p1[1]); continue; }
        $cmp_ax = $cmp_p1[0] + ($cmp_p0[0] - $cmp_p1[0]) / $cmp_l1 * $cmp_rr;
        $cmp_ay = $cmp_p1[1] + ($cmp_p0[1] - $cmp_p1[1]) / $cmp_l1 * $cmp_rr;
        $cmp_bx = $cmp_p1[0] + ($cmp_p2[0] - $cmp_p1[0]) / $cmp_l2 * $cmp_rr;
        $cmp_by = $cmp_p1[1] + ($cmp_p2[1] - $cmp_p1[1]) / $cmp_l2 * $cmp_rr;
        $cmp_d .= ' L' . $cmp_f($cmp_ax) . ' ' . $cmp_f($cmp_ay)
                . ' Q' . $cmp_f($cmp_p1[0]) . ' ' . $cmp_f($cmp_p1[1]) . ' ' . $cmp_f($cmp_bx) . ' ' . $cmp_f($cmp_by);
    }
    $cmp_d .= ' L' . $cmp_f($cmp_pts[$cmp_n - 1][0]) . ' ' . $cmp_f($cmp_pts[$cmp_n - 1][1]);
    return ['d' => $cmp_d, 'stops' => implode(',', $cmp_stops)];
};
$cmp_path = fn (array $cmp_ns): string => $cmp_geom($cmp_ns)['d'];
$cmp_first = $cmp_order($cmp_goals[0]);
$cmp_caps_count = fn (array $cmp_g): int => count($cmp_order($cmp_g));
/* the composer's compile log for a goal: what the plan resolved to, line by line (typed by composer.js) */
$cmp_log = function (array $cmp_g, int $cmp_i) use ($cmp_order, $cmp_goals): array {
    $cmp_o = $cmp_order($cmp_g);
    $cmp_yours = array_values(array_filter($cmp_g['team'], fn ($cmp_t) => strpos($cmp_t, 'Your ') === 0));
    return [
        ['$', 'compose --goal ' . $cmp_g['slug']],
        ['resolve',  count($cmp_o) . ' capabilities · ' . implode(' ', $cmp_o)],
        ['order',    implode(' → ', $cmp_o)],
        ['gates',    count($cmp_g['gates']) . ' quality gates · ' . count($cmp_g['standards']) . ' frameworks'],
        ['team',     count($cmp_g['team']) . ' roles' . ($cmp_yours ? ' · incl. ' . lcfirst($cmp_yours[0]) : '')],
        ['estimate', $cmp_g['weeks'] . ' weeks typical · ' . count($cmp_g['phases']) . ' phases'],
        ['ready',    'plan ' . ($cmp_i + 1) . ' of ' . count($cmp_goals) . ' · scope it with us'],
    ];
};
$cmp_contact = fn (array $cmp_g): string => svc_contact_url(
    array_map(fn ($cmp_k) => 'technology-intelligence:' . $cmp_k, $cmp_g['services']),
    $cmp_g['package'] ?? null,
    'technology-intelligence'
);
$cmp_summary = fn (array $cmp_g): string => $cmp_g['title'] . ' · ' . count($cmp_g['phases']) . ' phases · ' . $cmp_g['weeks'] . ' weeks · ' . $cmp_caps_count($cmp_g) . ' capabilities';
?>
<section class="band tih-composer" id="composer" aria-labelledby="composer-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Platform Composer</p>
        <h2 class="h2" id="composer-t"><span class="g">Pick an outcome.</span> See the platform it needs.</h2>
      </div>
      <div>
        <p class="lead">Choose a goal and the composer lights the capabilities involved, draws the order we would build them in, and lays out the phases, the team, the gates that must pass and what we measure in the first 90 days.</p>
      </div>
    </div>

    <div class="bdh-ui tih-cmp" data-goal="0" data-rv data-rv-d="80" data-bdh-live>
      <div class="bdh-ui__bar tih-cmp__top">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="tih-cmp__title">Platform Composer · Your company · draft plan</span>
        <span class="tih-cmp__status"><i class="bdh-pulse" aria-hidden="true"></i><span class="tih-cmp__stxt">Plan ready</span></span>
        <span class="bdh-ill">Typical ranges</span>
      </div>

      <div class="tih-cmp__goals" role="radiogroup" aria-label="Business goal">
        <?php foreach ($cmp_goals as $cmp_i => $cmp_g): ?>
          <button class="tih-cmp__goal" type="button" role="radio" aria-checked="<?= $cmp_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $cmp_i === 0 ? '0' : '-1' ?>" data-goal="<?= $cmp_i ?>">
            <span class="tih-cmp__gi" aria-hidden="true"><?= xt_icon($cmp_g['icon'], ['size' => 20]) ?></span>
            <span class="tih-cmp__gt"><?= e($cmp_g['title']) ?></span>
            <span class="tih-cmp__gm"><?= count($cmp_g['phases']) ?> phases · <?= $cmp_g['weeks'] ?> wks</span>
          </button>
        <?php endforeach; ?>
      </div>
      <p class="tih-cmp__hint" aria-hidden="true"><span class="tih-kbd">←</span><span class="tih-kbd">→</span> to change goal</p>

      <p class="bdh-sr tih-cmp__live" aria-live="polite">Plan: <?= e($cmp_summary($cmp_goals[0])) ?></p>

      <div class="tih-cmp__body">
        <div class="tih-cmp__map">
          <div class="tih-cmp__mapin">
          <p class="tih-cmp__mh"><span class="tih-k">Architecture · capabilities involved</span><span class="tih-cmp__mc"><b><?= count($cmp_first) ?></b> of 10</span></p>
          <p class="bdh-sr">The capabilities involved in the selected plan are highlighted on the platform map and numbered in build order.</p>
          <div class="tih-stage tih-cmp__stage" aria-hidden="true">
            <svg viewBox="0 0 1000 700" focusable="false">
              <?php foreach ($TIH['layers'] as $cmp_l): ?>
                <line class="tih-cmp__lane" x1="0" y1="<?= $cmp_l['y'] + 80 ?>" x2="1000" y2="<?= $cmp_l['y'] + 80 ?>"/>
              <?php endforeach; ?>
              <?php foreach ($TIH['edges'] as $cmp_e): ?>
                <path class="tih-cmp__edge" d="<?= e($cmp_e[2]) ?>"/>
              <?php endforeach; ?>
              <path class="tih-cmp__path" d="<?= e($cmp_path($cmp_first)) ?>" pathLength="1"/>
              <path class="tih-cmp__pk" d="<?= e($cmp_path($cmp_first)) ?>" pathLength="1"/>
            </svg>
            <?php foreach ($TIH['layers'] as $cmp_lk => $cmp_l): ?>
              <span class="tih-cmp__ll" style="--y:<?= round(($cmp_l['y'] - 66) / 7, 3) ?>"><?= e($cmp_l['code']) ?> <?= e($cmp_l['name']) ?></span>
              <?php foreach ($cmp_l['caps'] as $cmp_s): $cmp_xy = $TIH['nodes'][$cmp_s]; $cmp_n = $TI[$cmp_s]['n']; $cmp_pos = array_search($cmp_n, $cmp_first, true); ?>
                <span class="tih-node tih-cmp__node <?= $cmp_pos === false ? 'is-dim' : 'is-on' ?>" data-n="<?= e($cmp_n) ?>" style="--x:<?= $cmp_xy[0] / 10 ?>;--y:<?= round($cmp_xy[1] / 7, 3) ?>">
                  <b><?= e($cmp_n) ?></b><span><?= e($TI[$cmp_s]['short']) ?></span><em class="tih-cmp__ord"><?= $cmp_pos === false ? '' : $cmp_pos + 1 ?></em>
                </span>
              <?php endforeach; ?>
            <?php endforeach; ?>
          </div>
          <p class="tih-cmp__legend" aria-hidden="true"><span><i class="is-on"></i>Involved</span><span><i class="is-path"></i>Build order</span><span><i class="is-dim"></i>Not needed yet</span></p>
          <p class="tih-cmp__route" aria-hidden="true"><span class="tih-k">Build order</span><span class="tih-cmp__rtxt"><?= e(implode(' → ', $cmp_first)) ?></span></p>
          <div class="tih-cmp__term tih-on-ink" aria-hidden="true">
            <p class="tih-cmp__th"><span class="bdh-ui__dots"><i></i><i></i><i></i></span><span>composer.log</span><span class="tih-cmp__tn">plan 1 / <?= count($cmp_goals) ?></span></p>
            <ol class="tih-cmp__tl">
              <?php foreach ($cmp_log($cmp_goals[0], 0) as $cmp_ln): ?>
                <li><b><?= e($cmp_ln[0]) ?></b><span><?= e($cmp_ln[1]) ?></span></li>
              <?php endforeach; ?>
            </ol>
          </div>
          </div>
        </div>

        <!-- PLACEHOLDER: phase lengths, team shapes and weeks are typical ranges — confirm before launch -->
        <div class="tih-cmp__plan bdh-panes">
          <?php foreach ($cmp_goals as $cmp_i => $cmp_g): $cmp_o = $cmp_order($cmp_g); ?>
            <div class="bdh-pane tih-cmp__pane<?= $cmp_i === 0 ? ' is-on' : '' ?>" data-plan="<?= $cmp_i ?>" data-order="<?= e(implode(',', $cmp_o)) ?>" data-path="<?= e($cmp_geom($cmp_o)['d']) ?>" data-stops="<?= e($cmp_geom($cmp_o)['stops']) ?>" data-summary="<?= e($cmp_summary($cmp_g)) ?>" data-log="<?= e(json_encode($cmp_log($cmp_g, $cmp_i), JSON_UNESCAPED_UNICODE)) ?>">
              <div class="tih-cmp__ph">
                <div>
                  <p class="tih-k">Plan <?= $cmp_i + 1 ?> of <?= count($cmp_goals) ?> · typical</p>
                  <h3 class="tih-cmp__pt"><?= e($cmp_g['title']) ?></h3>
                  <p class="tih-cmp__pw"><?= e($cmp_g['why']) ?></p>
                </div>
                <dl class="tih-cmp__pm">
                  <div><dt>Weeks</dt><dd><?= $cmp_g['weeks'] ?></dd></div>
                  <div><dt>Phases</dt><dd><?= count($cmp_g['phases']) ?></dd></div>
                  <div><dt>Capabilities</dt><dd><?= count($cmp_o) ?></dd></div>
                </dl>
              </div>

              <div class="tih-cmp__gantt">
                <p class="tih-cmp__gh" aria-hidden="true">
                  <span>Phase</span>
                  <span class="tih-cmp__scale"><?php for ($cmp_w = 1; $cmp_w <= $cmp_g['weeks']; $cmp_w++): ?><i><?= ($cmp_w === 1 || $cmp_w % 2 === 0) ? $cmp_w : '' ?></i><?php endfor; ?></span>
                  <span>Weeks</span>
                </p>
                <ol class="tih-cmp__rows">
                  <?php foreach ($cmp_g['phases'] as $cmp_pi => $cmp_p):
                      $cmp_left = ($cmp_p[2] - 1) / $cmp_g['weeks'] * 100;
                      $cmp_wid  = ($cmp_p[3] - $cmp_p[2] + 1) / $cmp_g['weeks'] * 100; ?>
                    <li class="tih-cmp__row" style="--i:<?= $cmp_pi ?>">
                      <span class="tih-cmp__rn"><?= e($cmp_p[0]) ?></span>
                      <span class="tih-cmp__rt"><?= e($cmp_p[1]) ?><small><?= e($TI[$cmp_by_n[$cmp_p[0]]]['short']) ?></small></span>
                      <span class="tih-cmp__track" aria-hidden="true"><i class="tih-cmp__bar<?= $cmp_p[4] ? ' is-open' : '' ?>" style="left:<?= round($cmp_left, 3) ?>%;width:<?= round($cmp_wid, 3) ?>%"></i></span>
                      <span class="tih-cmp__rw">Wk <?= $cmp_p[2] === $cmp_p[3] ? $cmp_p[2] : $cmp_p[2] . '–' . $cmp_p[3] ?><?= $cmp_p[4] ? ' →' : '' ?></span>
                    </li>
                  <?php endforeach; ?>
                </ol>
              </div>

              <div class="tih-cmp__cols">
                <div class="tih-cmp__col">
                  <p class="tih-k">Team</p>
                  <ul class="tih-cmp__team"><?php foreach ($cmp_g['team'] as $cmp_t): ?><li><?= e($cmp_t) ?></li><?php endforeach; ?></ul>
                </div>
                <div class="tih-cmp__col">
                  <p class="tih-k">Quality gates · must pass</p>
                  <ul class="tih-cmp__gates"><?php foreach ($cmp_g['gates'] as $cmp_gt): ?><li><b aria-hidden="true">✓</b><?= e($cmp_gt) ?></li><?php endforeach; ?></ul>
                </div>
                <div class="tih-cmp__col">
                  <p class="tih-k">First 90 days · we measure</p>
                  <ol class="tih-cmp__meas"><?php foreach ($cmp_g['measures'] as $cmp_mi => $cmp_m): ?><li><span><?= str_pad((string) ($cmp_mi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($cmp_m) ?></li><?php endforeach; ?></ol>
                </div>
              </div>

              <div class="tih-cmp__stdrow">
                <p class="tih-k">Frameworks this plan aligns with</p>
                <ul class="tih-cmp__std" role="list" aria-label="Frameworks this plan aligns with"><?php foreach ($cmp_g['standards'] as $cmp_st) { echo xt_badge($cmp_st, ['variant' => 'chip', 'tag' => 'li']); } ?></ul>
              </div>

              <div class="tih-cmp__foot">
                <p class="tih-cmp__links"><span class="tih-k">Capability pages</span><?php foreach ($cmp_o as $cmp_n): $cmp_s = $cmp_by_n[$cmp_n]; ?><a class="tih-capl" href="<?= xe_url('services/technology-intelligence/' . $cmp_s . '.php') ?>"><b><?= e($cmp_n) ?></b><?= e($TI[$cmp_s]['short']) ?><i aria-hidden="true">›</i></a><?php endforeach; ?></p>
                <a class="btn btn--ink btn--sm" href="<?= e($cmp_contact($cmp_g)) ?>">Scope this plan with us <span class="i" aria-hidden="true">›</span><span class="bdh-sr">: <?= e($cmp_g['title']) ?></span></a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <p class="tih-note tih-cmp__note">Plans show typical phases and lengths for a programme of this shape, not a quote. Every engagement is scoped with your team before it starts.</p>
  </div>
</section>
