<?php /* DRAFT COPY — review before launch */
/* Fixplan — the signature section: the fix-order planner.
   Sixteen findings from a combined audit, each with a severity, a likelihood, a risk score
   (severity × likelihood, CVSS-derived for the vulnerabilities), an estimated monthly value where
   the item is a revenue or waste line, an effort in engineering days and its dependencies.

   Two controls drive one calculation: capacity (engineering days available this quarter) and
   objective (reduce risk first · recover revenue first · balanced). The ranking is greedy by value
   density with dependency closure — an item can only be selected once everything it depends on is
   selected — and the result splits into Now (the first third of capacity), Next (the rest of the
   plan) and Later (does not fit this quarter). Rows can be pinned "Must fix", which forces them and
   their dependencies into Now even when that overruns capacity.

   The whole plan is computed here in PHP, so the HTML that ships is the finished, readable state:
   lanes filled, curve drawn, readouts written, table sorted. fixplan.js re-runs the identical
   calculation in the browser when the controls move, animates the cards between lanes and redraws
   the curve. Figures are illustrative. */

$taa_fp_cap0 = 30;          // default capacity, engineering days
$taa_fp_obj0 = 'balanced';  // default objective
$taa_fp_wt   = ['critical' => 5, 'high' => 4, 'medium' => 3, 'low' => 2];

/* id · area · finding · severity · likelihood 1–5 · monthly value (0 = rated, not priced) · effort days · dependencies · basis */
$taa_fp_src = [
    ['SEC-01', 'Security',      'Admin console reachable from the public internet without MFA',        'critical', 4,     0, 2, [],         'Rated, not priced'],
    ['SEC-04', 'Security',      'Payment service ships a dependency with a known CVE (CVSS 8.1)',      'critical', 3,     0, 1, [],         'Rated, not priced'],
    ['SEC-11', 'Security',      'Cloud audit logging disabled in two of five accounts (CIS 3.1)',      'high',     4,     0, 2, [],         'Rated, not priced'],
    ['DAT-09', 'Data',          'Personal data in analytics exports with no retention limit',          'high',     4,     0, 3, [],         'Rated, not priced'],
    ['ACC-01', 'Accessibility', 'Checkout fields without labels — WCAG 2.2 AA 1.3.1 failure',          'high',     5,  7600, 4, [],         'Abandonment delta × orders'],
    ['TA-03',  'Performance',   'Checkout LCP 4.6 s on mobile at the 75th percentile (good ≤ 2.5 s)',  'high',     5, 18400, 8, ['TA-11'],  'Conversion elasticity × revenue'],
    ['TA-11',  'Performance',   'Product media served unresized, no modern formats, no edge cache',    'medium',   5,  6100, 3, [],         'Transfer cost + conversion'],
    ['TA-08',  'Delivery',      'No rollback path — every incident is resolved by a forward fix',      'high',     3,     0, 5, [],         'Rated, not priced'],
    ['SEO-05', 'Search',        'Product pages return 200 with a noindex tag from a legacy template',  'high',     5, 11700, 3, [],         'Lost sessions × conversion × AOV'],
    ['SEO-09', 'Search',        'Structured data invalid on 62% of product pages — rich results lost', 'medium',   4,  5400, 4, [],         'Click-through delta × sessions'],
    ['DAT-02', 'Data',          'Order events dropped when the queue backs up — 3.1% loss last month', 'high',     4,  9200, 5, [],         'Under-reported orders × margin'],
    ['DAT-06', 'Data',          'Revenue reported three ways; no agreed definition or owner',          'medium',   4,     0, 4, ['DAT-02'], 'Rework hours × blended rate'],
    ['CLD-02', 'Cloud',         'Two oversized database instances idle above 80% of the month',        'medium',   5,  4300, 2, [],         'Unused capacity × hourly rate'],
    ['CLD-05', 'Cloud',         'Non-production environments run 24/7, including weekends',            'low',      5,  2100, 1, [],         'Idle hours × hourly rate'],
    ['AI-02',  'AI readiness',  'Knowledge base 40% duplicated — retrieval returns conflicting answers','medium',  4,     0, 6, [],         'Rework hours × blended rate'],
    ['CAR-02', 'Carbon',        'Batch jobs scheduled at the daily grid carbon peak',                  'low',      4,   900, 2, ['CLD-02'], 'Energy × grid intensity × rate'],
];

$taa_fp_rows = [];
foreach ($taa_fp_src as $taa_fp_r) {
    $taa_fp_rows[$taa_fp_r[0]] = [
        'id'   => $taa_fp_r[0],
        'area' => $taa_fp_r[1],
        'f'    => $taa_fp_r[2],
        'sev'  => $taa_fp_r[3],
        'lik'  => $taa_fp_r[4],
        'risk' => $taa_fp_wt[$taa_fp_r[3]] * $taa_fp_r[4],
        'val'  => $taa_fp_r[5],
        'eff'  => $taa_fp_r[6],
        'deps' => $taa_fp_r[7],
        'why'  => $taa_fp_r[8],
    ];
}
unset($taa_fp_r);

/**
 * Score for one finding under an objective, normalised to 0–1 so risk and money compare.
 */
if (!function_exists('taa_fp_score')) {
    function taa_fp_score(array $row, string $obj, int $maxRisk, int $maxVal): float {
        $riskN = $maxRisk > 0 ? $row['risk'] / $maxRisk : 0.0;
        $valN  = $maxVal  > 0 ? $row['val']  / $maxVal  : 0.0;
        if ($obj === 'risk')    return $riskN;
        if ($obj === 'revenue') return $valN;
        return (0.5 * $riskN) + (0.5 * $valN);
    }
}

/**
 * Everything that must ship before $id can ship, depth first, excluding what is already taken.
 */
if (!function_exists('taa_fp_closure')) {
    function taa_fp_closure(string $id, array $rows, array $taken, array $seen = []): array {
        if (isset($taken[$id]) || isset($seen[$id])) return [];
        $seen[$id] = true;
        $out = [];
        foreach ($rows[$id]['deps'] as $dep) {
            if (!isset($rows[$dep])) continue;
            foreach (taa_fp_closure($dep, $rows, $taken, $seen) as $add) {
                if (!in_array($add, $out, true)) $out[] = $add;
            }
        }
        $out[] = $id;
        return $out;
    }
}

/**
 * The full ranking, ignoring capacity: repeatedly take the finding whose dependency closure buys the
 * most score per engineering day. Deterministic, and the same routine runs in fixplan.js.
 */
if (!function_exists('taa_fp_rank')) {
    function taa_fp_rank(array $rows, string $obj): array {
        $maxRisk = max(array_column($rows, 'risk'));
        $maxVal  = max(array_column($rows, 'val'));
        $taken   = [];
        $order   = [];
        while (count($order) < count($rows)) {
            $best = null; $bestD = -1.0; $bestSet = [];
            foreach (array_keys($rows) as $id) {
                if (isset($taken[$id])) continue;
                $set = taa_fp_closure($id, $rows, $taken);
                $sum = 0.0; $eff = 0;
                foreach ($set as $sid) { $sum += taa_fp_score($rows[$sid], $obj, $maxRisk, $maxVal); $eff += $rows[$sid]['eff']; }
                $dens = $eff > 0 ? $sum / $eff : 0.0;
                if ($dens > $bestD + 1e-9) { $bestD = $dens; $best = $id; $bestSet = $set; }
            }
            if ($best === null) break;
            foreach ($bestSet as $sid) { $taken[$sid] = true; $order[] = $sid; }
        }
        return $order;
    }
}

/**
 * The plan: pinned items first (forced, dependencies included), then the ranking in order, taking
 * each closure that still fits. Lanes: Now = the first third of capacity, Next = the rest of the
 * plan, Later = does not fit this quarter.
 */
if (!function_exists('taa_fp_plan')) {
    function taa_fp_plan(array $rows, array $rank, int $cap, array $pins): array {
        $taken = []; $order = []; $used = 0;
        foreach ($rank as $id) {
            if (!in_array($id, $pins, true) || isset($taken[$id])) continue;
            foreach (taa_fp_closure($id, $rows, $taken) as $sid) { $taken[$sid] = true; $order[] = $sid; $used += $rows[$sid]['eff']; }
        }
        $forced = $used;
        foreach ($rank as $id) {
            if (isset($taken[$id])) continue;
            $set = taa_fp_closure($id, $rows, $taken);
            $eff = 0;
            foreach ($set as $sid) { $eff += $rows[$sid]['eff']; }
            if ($used + $eff > $cap) continue;
            foreach ($set as $sid) { $taken[$sid] = true; $order[] = $sid; $used += $rows[$sid]['eff']; }
        }
        $nowCap = max(1, (int) ceil($cap / 3));
        $lane = []; $cum = 0; $val = 0; $riskFixed = 0;
        foreach ($order as $id) {
            $cum += $rows[$id]['eff'];
            $lane[$id] = ($cum <= $nowCap || $cum === $rows[$order[0]]['eff']) ? 'now' : 'next';
            if (in_array($id, $pins, true)) $lane[$id] = 'now';
            $val += $rows[$id]['val'];
            $riskFixed += $rows[$id]['risk'];
        }
        $rest = [];
        foreach ($rank as $id) { if (!isset($taken[$id])) { $lane[$id] = 'later'; $rest[] = $id; } }
        $riskTotal = array_sum(array_column($rows, 'risk'));
        return [
            'lane'     => $lane,
            'order'    => $order,
            'rest'     => $rest,
            'days'     => $used,
            'forced'   => $forced,
            'over'     => max(0, $used - $cap),
            'value'    => $val,
            'residual' => $riskTotal > 0 ? (int) round(100 * ($riskTotal - $riskFixed) / $riskTotal) : 0,
            'nowcap'   => $nowCap,
        ];
    }
}

$taa_fp_rank   = taa_fp_rank($taa_fp_rows, $taa_fp_obj0);
$taa_fp_p      = taa_fp_plan($taa_fp_rows, $taa_fp_rank, $taa_fp_cap0, []);
$taa_fp_days   = array_sum(array_column($taa_fp_rows, 'eff'));
$taa_fp_valtot = array_sum(array_column($taa_fp_rows, 'val'));

/* Cumulative value curve. X is engineering days across the whole register, Y is recovered monthly
   value. The solid path is the plan; the dashed path is what the next days would buy. */
$taa_fp_vw = 680; $taa_fp_vh = 188; $taa_fp_pad = 10;
$taa_fp_pt = function (int $days, int $val) use ($taa_fp_days, $taa_fp_valtot, $taa_fp_vw, $taa_fp_vh, $taa_fp_pad): string {
    $xx = $taa_fp_pad + ($taa_fp_days > 0 ? $days / $taa_fp_days : 0) * ($taa_fp_vw - 2 * $taa_fp_pad);
    $yy = ($taa_fp_vh - $taa_fp_pad) - ($taa_fp_valtot > 0 ? $val / $taa_fp_valtot : 0) * ($taa_fp_vh - 2 * $taa_fp_pad);
    return round($xx, 1) . ' ' . round($yy, 1);
};
$taa_fp_curve = function (array $ids, array $rows, callable $pt, int $d0 = 0, int $v0 = 0) {
    $out = ['M ' . $pt($d0, $v0)];
    $dd = $d0; $vv = $v0;
    foreach ($ids as $id) { $dd += $rows[$id]['eff']; $vv += $rows[$id]['val']; $out[] = 'L ' . $pt($dd, $vv); }
    return ['d' => implode(' ', $out), 'days' => $dd, 'val' => $vv];
};
$taa_fp_solid = $taa_fp_curve($taa_fp_p['order'], $taa_fp_rows, $taa_fp_pt);
$taa_fp_dash  = $taa_fp_curve($taa_fp_p['rest'], $taa_fp_rows, $taa_fp_pt, $taa_fp_solid['days'], $taa_fp_solid['val']);
$taa_fp_mark  = $taa_fp_pad + ($taa_fp_cap0 / $taa_fp_days) * ($taa_fp_vw - 2 * $taa_fp_pad);

$taa_fp_lanes = [
    'now'   => ['Now',   'First third of capacity'],
    'next'  => ['Next',  'The rest of the plan'],
    'later' => ['Later', 'Does not fit this quarter'],
];
$taa_fp_objs = [
    'risk'     => ['Reduce risk first',      'Ranks by severity × likelihood'],
    'revenue'  => ['Recover revenue first',  'Ranks by estimated monthly value'],
    'balanced' => ['Balanced',               'Half risk, half money'],
];
$taa_fp_json = [];
foreach ($taa_fp_rows as $taa_fp_id => $taa_fp_row) {
    $taa_fp_json[] = ['id' => $taa_fp_id, 'sev' => $taa_fp_row['sev'], 'risk' => $taa_fp_row['risk'],
                      'val' => $taa_fp_row['val'], 'eff' => $taa_fp_row['eff'], 'deps' => $taa_fp_row['deps']];
}
unset($taa_fp_id, $taa_fp_row);
?>
<section class="band band--ink taa-fx" id="fixplan" aria-labelledby="fixplan-t">
  <div class="wrap">

    <header class="taa-head taa-head--wide" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">02</span><span>Signature · fix-order planner</span></p>
        <h2 class="h2" id="fixplan-t"><span class="g">Set your capacity.</span> Get the fix order.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Sixteen findings, one quarter of engineering time. Move the capacity slider and change the objective: the plan, the value curve and the risk you are choosing to carry all recalculate.</p>
      </div>
    </header>

    <div class="taa-win taa-fx__win"
         data-taa-fix
         data-rows='<?= e(json_encode($taa_fp_json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'
         data-total-days="<?= (int) $taa_fp_days ?>"
         data-total-value="<?= (int) $taa_fp_valtot ?>"
         data-vw="<?= (int) $taa_fp_vw ?>" data-vh="<?= (int) $taa_fp_vh ?>" data-pad="<?= (int) $taa_fp_pad ?>">

      <div class="taa-win__bar">
        <span class="taa-win__t"><b>Fix-order planner</b> · Your company · combined audit · the 16 findings scheduled this quarter · <?= (int) $taa_fp_days ?> engineering days in total</span>
        <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i>Plan recalculated live</span>
      </div>

      <!-- controls -->
      <div class="taa-fx__ctl">
        <div class="taa-fx__cap">
          <label class="taa-lbl" for="fixplan-cap">Engineering days available this quarter</label>
          <div class="taa-fx__slide">
            <input type="range" id="fixplan-cap" name="fixplan-cap" min="10" max="80" step="5"
                   value="<?= (int) $taa_fp_cap0 ?>" data-taa-cap
                   aria-describedby="fixplan-cap-note">
            <output class="taa-fx__capo" for="fixplan-cap"><span class="taa-num" data-taa-capnum><?= (int) $taa_fp_cap0 ?></span> days</output>
          </div>
          <p class="taa-fx__ticks" aria-hidden="true"><span>10</span><span>30</span><span>50</span><span>80</span></p>
          <p class="taa-fx__note" id="fixplan-cap-note">One engineer working the whole quarter is roughly 60 days. Effort figures are the audit’s own estimates, not a quote.</p>
        </div>

        <div class="taa-fx__obj">
          <p class="taa-lbl" id="fixplan-obj-l">Objective</p>
          <div class="taa-fx__seg" role="radiogroup" aria-labelledby="fixplan-obj-l" data-taa-obj>
            <?php foreach ($taa_fp_objs as $taa_fp_ok => $taa_fp_ov): ?>
              <button type="button" role="radio" data-obj="<?= e($taa_fp_ok) ?>"
                      aria-checked="<?= $taa_fp_ok === $taa_fp_obj0 ? 'true' : 'false' ?>"
                      tabindex="<?= $taa_fp_ok === $taa_fp_obj0 ? '0' : '-1' ?>">
                <span class="taa-fx__segn"><?= e($taa_fp_ov[0]) ?></span>
                <span class="taa-fx__segd"><?= e($taa_fp_ov[1]) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- readouts -->
      <dl class="taa-fx__out">
        <div>
          <dt>Days committed</dt>
          <dd><span class="taa-num" data-taa-days><?= (int) $taa_fp_p['days'] ?></span> <span class="taa-fx__u">of <span data-taa-capref><?= (int) $taa_fp_cap0 ?></span></span></dd>
          <span class="taa-meter" aria-hidden="true"><i data-taa-daysbar style="--p:<?= number_format(min(1, $taa_fp_p['days'] / max(1, $taa_fp_cap0)), 3) ?>"></i></span>
        </div>
        <div>
          <dt>Findings in the plan</dt>
          <dd><span class="taa-num" data-taa-count><?= count($taa_fp_p['order']) ?></span> <span class="taa-fx__u">of 16</span></dd>
          <span class="taa-meter" aria-hidden="true"><i data-taa-countbar style="--p:<?= number_format(count($taa_fp_p['order']) / 16, 3) ?>"></i></span>
        </div>
        <div>
          <dt>Value recovered <span class="taa-est">Est.</span></dt>
          <dd>$<span class="taa-num" data-taa-value><?= number_format($taa_fp_p['value']) ?></span> <span class="taa-fx__u">per month</span></dd>
          <span class="taa-meter" aria-hidden="true"><i data-taa-valuebar style="--p:<?= number_format($taa_fp_p['value'] / max(1, $taa_fp_valtot), 3) ?>"></i></span>
        </div>
        <div>
          <dt>Left unfixed</dt>
          <dd><span class="taa-num" data-taa-residual><?= (int) $taa_fp_p['residual'] ?></span><span class="taa-fx__u">% of rated risk</span></dd>
          <span class="taa-meter" aria-hidden="true"><i data-taa-residualbar style="--p:<?= number_format($taa_fp_p['residual'] / 100, 3) ?>"></i></span>
        </div>
      </dl>
      <p class="bdh-sr" aria-live="polite" data-taa-say>Plan at 30 days, balanced objective: <?= count($taa_fp_p['order']) ?> findings selected, <?= (int) $taa_fp_p['days'] ?> days committed, <?= (int) $taa_fp_p['residual'] ?>% of rated risk left unfixed.</p>

      <!-- lanes -->
      <div class="taa-fx__lanes">
        <?php foreach ($taa_fp_lanes as $taa_fp_lk => $taa_fp_lv): ?>
          <section class="taa-fx__lane" data-lane="<?= e($taa_fp_lk) ?>" aria-labelledby="fixplan-lane-<?= e($taa_fp_lk) ?>">
            <h3 class="taa-fx__laneh" id="fixplan-lane-<?= e($taa_fp_lk) ?>">
              <span><?= e($taa_fp_lv[0]) ?></span>
              <span class="taa-num" data-taa-lanecount="<?= e($taa_fp_lk) ?>"><?= count(array_keys($taa_fp_p['lane'], $taa_fp_lk, true)) ?></span>
            </h3>
            <p class="taa-fx__laned"><?= e($taa_fp_lv[1]) ?></p>
            <ul class="taa-fx__cards" role="list" data-taa-lanelist="<?= e($taa_fp_lk) ?>">
              <?php foreach ($taa_fp_rows as $taa_fp_cid => $taa_fp_c): if (($taa_fp_p['lane'][$taa_fp_cid] ?? 'later') !== $taa_fp_lk) continue; ?>
                <li class="taa-fx__card" data-id="<?= e($taa_fp_cid) ?>">
                  <p class="taa-fx__cardt"><span class="taa-id"><?= e($taa_fp_cid) ?></span><?= taa_sev($taa_fp_c['sev'], ['short' => true]) ?></p>
                  <p class="taa-fx__cardf"><?= e($taa_fp_c['f']) ?></p>
                  <p class="taa-fx__cardm">
                    <span><?= (int) $taa_fp_c['eff'] ?> d</span>
                    <span><?= $taa_fp_c['val'] > 0 ? '$' . number_format($taa_fp_c['val']) . '/mo' : 'Rated risk ' . (int) $taa_fp_c['risk'] ?></span>
                  </p>
                </li>
              <?php endforeach; ?>
            </ul>
          </section>
        <?php endforeach; ?>
      </div>

      <!-- value curve -->
      <figure class="taa-fx__curve">
        <figcaption>
          <span class="taa-lbl">Cumulative value recovered against engineering days</span>
          <span class="taa-fx__key" aria-hidden="true">
            <span class="taa-fx__k taa-fx__k--solid">In the plan</span>
            <span class="taa-fx__k taa-fx__k--dash">Beyond capacity</span>
            <span class="taa-fx__k taa-fx__k--mark">Capacity</span>
          </span>
        </figcaption>
        <div class="taa-fx__plot">
          <svg viewBox="0 0 <?= (int) $taa_fp_vw ?> <?= (int) $taa_fp_vh ?>" preserveAspectRatio="none" role="img"
               aria-label="Cumulative recovered monthly value rises steeply over the first engineering days and flattens as the lower-value findings are reached." data-taa-plot>
            <g class="taa-fx__grid" aria-hidden="true">
              <line x1="<?= (int) $taa_fp_pad ?>" y1="<?= $taa_fp_vh - $taa_fp_pad ?>" x2="<?= $taa_fp_vw - $taa_fp_pad ?>" y2="<?= $taa_fp_vh - $taa_fp_pad ?>"/>
              <line x1="<?= (int) $taa_fp_pad ?>" y1="<?= round($taa_fp_vh / 2) ?>" x2="<?= $taa_fp_vw - $taa_fp_pad ?>" y2="<?= round($taa_fp_vh / 2) ?>"/>
              <line x1="<?= (int) $taa_fp_pad ?>" y1="<?= (int) $taa_fp_pad ?>" x2="<?= $taa_fp_vw - $taa_fp_pad ?>" y2="<?= (int) $taa_fp_pad ?>"/>
            </g>
            <path class="taa-fx__dash" d="<?= e($taa_fp_dash['d']) ?>" fill="none" vector-effect="non-scaling-stroke" data-taa-dash />
            <path class="taa-fx__solid" d="<?= e($taa_fp_solid['d']) ?>" fill="none" vector-effect="non-scaling-stroke" data-taa-solid />
            <line class="taa-fx__markl" x1="<?= round($taa_fp_mark, 1) ?>" y1="<?= (int) $taa_fp_pad ?>" x2="<?= round($taa_fp_mark, 1) ?>" y2="<?= $taa_fp_vh - $taa_fp_pad ?>" vector-effect="non-scaling-stroke" data-taa-mark aria-hidden="true"/>
          </svg>
          <span class="taa-fx__ymax taa-ro">$<?= number_format($taa_fp_valtot) ?>/mo</span>
          <span class="taa-fx__xmax taa-ro"><?= (int) $taa_fp_days ?> days</span>
        </div>
      </figure>

      <!-- register -->
      <div class="taa-fx__tbl bdh-scroll-x" tabindex="0" role="group" aria-labelledby="fixplan-tbl-t">
        <p class="bdh-sr" id="fixplan-tbl-t">The sixteen findings behind the plan, sortable, scrollable sideways</p>
        <table class="taa-tbl taa-fx__table" data-taa-table>
          <caption class="bdh-sr">Sixteen illustrative findings with severity, risk score, estimated monthly value, effort, dependencies and the lane the current plan puts them in.</caption>
          <thead>
            <tr>
              <th scope="col" class="taa-fx__sortth" aria-sort="none"><button type="button" data-sort="id">ID <span class="taa-fx__ar" aria-hidden="true"></span></button></th>
              <th scope="col">Finding</th>
              <th scope="col" class="taa-fx__sortth" aria-sort="none"><button type="button" data-sort="risk">Risk <span class="taa-fx__ar" aria-hidden="true"></span></button></th>
              <th scope="col">Severity</th>
              <th scope="col" class="taa-fx__sortth" aria-sort="none"><button type="button" data-sort="val">Value / mo <span class="taa-fx__ar" aria-hidden="true"></span></button></th>
              <th scope="col" class="taa-fx__sortth" aria-sort="none"><button type="button" data-sort="eff">Effort <span class="taa-fx__ar" aria-hidden="true"></span></button></th>
              <th scope="col">Depends on</th>
              <th scope="col" class="taa-fx__sortth" aria-sort="none"><button type="button" data-sort="lane">Lane <span class="taa-fx__ar" aria-hidden="true"></span></button></th>
              <th scope="col"><span class="bdh-sr">Must fix</span><span aria-hidden="true">Pin</span></th>
            </tr>
          </thead>
          <tbody data-taa-tbody>
            <?php foreach ($taa_fp_rank as $taa_fp_ri => $taa_fp_rid): $taa_fp_t = $taa_fp_rows[$taa_fp_rid]; ?>
              <tr data-id="<?= e($taa_fp_rid) ?>" data-lane="<?= e($taa_fp_p['lane'][$taa_fp_rid] ?? 'later') ?>" style="--i:<?= (int) $taa_fp_ri ?>">
                <td class="taa-id"><?= e($taa_fp_rid) ?></td>
                <th scope="row" class="taa-fx__f"><?= e($taa_fp_t['f']) ?><span class="taa-fx__area"><?= e($taa_fp_t['area']) ?></span></th>
                <td class="taa-n"><?= (int) $taa_fp_t['risk'] ?><span class="taa-fx__of">/25</span></td>
                <td><?= taa_sev($taa_fp_t['sev']) ?></td>
                <td class="taa-n"><?= $taa_fp_t['val'] > 0 ? '$' . number_format($taa_fp_t['val']) : '<span class="taa-fx__na">Rated</span>' ?></td>
                <td class="taa-n"><?= (int) $taa_fp_t['eff'] ?> d</td>
                <td class="taa-n taa-fx__dep"><?= $taa_fp_t['deps'] ? e(implode(', ', $taa_fp_t['deps'])) : '<span class="taa-fx__na">—</span>' ?></td>
                <td><span class="taa-pill taa-fx__lanetag" data-taa-lanecell><?= e($taa_fp_lanes[$taa_fp_p['lane'][$taa_fp_rid] ?? 'later'][0]) ?></span></td>
                <td>
                  <button type="button" class="taa-fx__pin" data-taa-pin="<?= e($taa_fp_rid) ?>" aria-pressed="false">
                    <span class="taa-fx__pini" aria-hidden="true"></span>
                    <span class="bdh-sr">Pin <?= e($taa_fp_rid) ?> as must fix</span>
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="taa-fx__foot">
        <p><span class="taa-est">Illustrative</span> The register holds 37 findings. The planner carries the 16 the audit recommends scheduling this quarter — every critical and high finding, and the medium and low ones where the fix is small enough, or the dependency close enough, to be worth doing now. The other 21 sit in the backlog appendix with the same fields. Risk is severity × likelihood on a 1–5 scale, so a maximum of 25; vulnerabilities inherit their severity from CVSS v3.1 and are re-rated for your environment. Value is modelled from your own analytics, cloud bills and engineering rates, and items marked <b>Rated</b> are risk we will not price — a breach is a probability, not a monthly line. Effort is an engineering estimate with a stated confidence. Dependencies are respected: nothing is scheduled before the work it needs.</p>
      </div>

    </div>
  </div>
</section>
