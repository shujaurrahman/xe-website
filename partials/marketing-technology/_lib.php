<?php /* DRAFT COPY — review before launch */
/**
 * Marketing Technology hub — the page's shared map and its diagram helpers.
 *
 * Returned as $MTH by services/marketing-technology.php and read by every section partial.
 * Nothing here prints; it is data plus four pure functions, so a section can draw a diagram
 * without hand-computing coordinates. The capability subpages will reuse all of it.
 *
 *   $MTH['stages']      the six stages of the customer loop, in order:
 *                       key => [code, name, line, icon, caps (capability slugs), angle on the ring]
 *   $MTH['stage_of']    capability slug => its primary stage key
 *   $MTH['caps_of']     stage key => capability slugs that work in it
 *   $MTH['cap_href']    fn(slug): the capability's anchor on this hub (never a file that does not exist)
 *
 * DIAGRAM IDIOM (mth_* functions, defined once and guarded)
 *   mth_box($x, $y, $w, $h)             a node's geometry in stage units
 *   mth_edge($a, $b, $mode, $rail)      an orthogonal connector between two boxes, TRIMMED to each box's
 *                                       edge plus a 7-unit gap, with rounded corners. $mode:
 *                                         'auto' straight when aligned, else horizontal-first L
 *                                         'tee'  a leaf joining a bus: one vertical line at the leaf's x
 *                                         'h'    leave A sideways, turn once, enter B sideways
 *                                         'v'    leave A vertically, turn once, enter B vertically
 *                                         'under'/'over'  leave A vertically to $rail, across, into B
 *                                       Never draws centre to centre, so a line never crosses its own boxes.
 *   mth_ray($box, $tx, $ty, $gap)       the point where a ray from the box centre towards (tx,ty) leaves the
 *                                       box, plus the gap — for radial diagrams (the loop ring, the CRS wheel)
 *   mth_round(array $pts, $r)           waypoints → one rounded SVG path
 */

if (!function_exists('mth_box')) {

/** A node's geometry in stage units: centre plus half extents. */
function mth_box(float $x, float $y, float $w, float $h): array {
    return ['x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'hw' => $w / 2, 'hh' => $h / 2];
}

function mth__n(float $v): string {
    return rtrim(rtrim(number_format($v, 1, '.', ''), '0'), '.');
}

/** Waypoints → one path with rounded corners (radius $r, clamped to half of the shorter leg). */
function mth_round(array $pts, float $r = 16): string {
    $pts = array_values(array_filter($pts, fn ($p) => is_array($p) && count($p) >= 2));
    /* drop repeated points: a zero-length leg has no direction to round */
    $clean = [];
    foreach ($pts as $p) {
        $last = end($clean);
        if ($last !== false && abs($last[0] - $p[0]) < 0.25 && abs($last[1] - $p[1]) < 0.25) continue;
        $clean[] = [(float) $p[0], (float) $p[1]];
    }
    $n = count($clean);
    if ($n === 0) return '';
    if ($n === 1) return 'M' . mth__n($clean[0][0]) . ' ' . mth__n($clean[0][1]);
    $d = 'M' . mth__n($clean[0][0]) . ' ' . mth__n($clean[0][1]);
    for ($i = 1; $i < $n - 1; $i++) {
        [$p0, $p1, $p2] = [$clean[$i - 1], $clean[$i], $clean[$i + 1]];
        $l1 = hypot($p1[0] - $p0[0], $p1[1] - $p0[1]);
        $l2 = hypot($p2[0] - $p1[0], $p2[1] - $p1[1]);
        $rr = min($r, $l1 / 2, $l2 / 2);
        /* collinear corner: nothing to round */
        $cross = ($l1 > 0 && $l2 > 0)
            ? abs((($p0[0] - $p1[0]) * ($p2[1] - $p1[1]) - ($p0[1] - $p1[1]) * ($p2[0] - $p1[0])) / ($l1 * $l2))
            : 0;
        if ($rr < 1 || $cross < 0.02) { $d .= ' L' . mth__n($p1[0]) . ' ' . mth__n($p1[1]); continue; }
        $ax = $p1[0] + ($p0[0] - $p1[0]) / $l1 * $rr;
        $ay = $p1[1] + ($p0[1] - $p1[1]) / $l1 * $rr;
        $bx = $p1[0] + ($p2[0] - $p1[0]) / $l2 * $rr;
        $by = $p1[1] + ($p2[1] - $p1[1]) / $l2 * $rr;
        $d .= ' L' . mth__n($ax) . ' ' . mth__n($ay)
            . ' Q' . mth__n($p1[0]) . ' ' . mth__n($p1[1]) . ' ' . mth__n($bx) . ' ' . mth__n($by);
    }
    $d .= ' L' . mth__n($clean[$n - 1][0]) . ' ' . mth__n($clean[$n - 1][1]);
    return $d;
}

/**
 * An orthogonal connector from box $a to box $b, trimmed to where it leaves each box (plus $gap),
 * so the line never runs through the boxes it connects. Defect class 4 in docs/BUILD-BRIEF.md.
 */
function mth_edge(array $a, array $b, string $mode = 'auto', ?float $rail = null, float $gap = 7, float $r = 16): string {
    $dx = $b['x'] - $a['x'];
    $dy = $b['y'] - $a['y'];
    $sx = $dx >= 0 ? 1 : -1;
    $sy = $dy >= 0 ? 1 : -1;
    $aR = $a['x'] + $sx * ($a['hw'] + $gap);          // a's left/right edge, towards b
    $bL = $b['x'] - $sx * ($b['hw'] + $gap);          // b's edge, facing a
    $aB = $a['y'] + $sy * ($a['hh'] + $gap);          // a's top/bottom edge, towards b
    $bT = $b['y'] - $sy * ($b['hh'] + $gap);

    if ($mode === 'auto') {
        if (abs($dy) < 1.5) $mode = 'straight-h';
        elseif (abs($dx) < 1.5) $mode = 'straight-v';
        else $mode = 'h';
    }
    switch ($mode) {
        case 'straight-h':
            return mth_round([[$aR, $a['y']], [$bL, $b['y']]], $r);
        case 'straight-v':
            return mth_round([[$a['x'], $aB], [$b['x'], $bT]], $r);
        case 'tee':   // a leaf joins a bus: one vertical line, at the narrower box's x
            $tx = $a['w'] <= $b['w'] ? $a['x'] : $b['x'];
            return mth_round([[$tx, $aB], [$tx, $bT]], $r);
        case 'v':   // leave A vertically, turn in the gutter between the rows, enter B sideways
            $gy = $rail !== null ? $rail : ($aB + $bT) / 2;
            return mth_round([[$a['x'], $aB], [$a['x'], $gy], [$bL, $gy], [$bL, $b['y']]], $r);
        case 'under':
        case 'over':
            $ry = $rail !== null ? $rail : ($mode === 'under' ? max($a['y'] + $a['hh'], $b['y'] + $b['hh']) + 34 : min($a['y'] - $a['hh'], $b['y'] - $b['hh']) - 34);
            $ay = $mode === 'under' ? $a['y'] + $a['hh'] + $gap : $a['y'] - $a['hh'] - $gap;
            $by = $mode === 'under' ? $b['y'] + $b['hh'] + $gap : $b['y'] - $b['hh'] - $gap;
            return mth_round([[$a['x'], $ay], [$a['x'], $ry], [$b['x'], $ry], [$b['x'], $by]], $r);
        case 'h':
        default:    // leave A sideways, turn in the gutter between the columns, enter B sideways
            $gx = $rail !== null ? $rail : ($aR + $bL) / 2;
            return mth_round([[$aR, $a['y']], [$gx, $a['y']], [$gx, $b['y']], [$bL, $b['y']]], $r);
    }
}

/** Where a ray from the centre of $box towards ($tx,$ty) leaves the box, moved out by $gap. */
function mth_ray(array $box, float $tx, float $ty, float $gap = 7): array {
    $dx = $tx - $box['x'];
    $dy = $ty - $box['y'];
    $len = hypot($dx, $dy);
    if ($len < 0.001) return [$box['x'], $box['y']];
    $ux = $dx / $len;
    $uy = $dy / $len;
    $t = INF;
    if (abs($ux) > 0.0001) $t = min($t, $box['hw'] / abs($ux));
    if (abs($uy) > 0.0001) $t = min($t, $box['hh'] / abs($uy));
    if (!is_finite($t)) $t = 0;
    $t += $gap;
    return [round($box['x'] + $ux * $t, 2), round($box['y'] + $uy * $t, 2)];
}

}

/* ------------------------------------------------------------------------------------------------
   The customer loop. Six stages, in order, and back to the start: this is the page's spine and the
   order of every diagram on it. Each stage names the capabilities that do the work in it.
   ------------------------------------------------------------------------------------------------ */
$mth_stages = [
    'collect' => [
        'code' => 'S1', 'name' => 'Collect', 'short' => 'Collect',
        'line' => 'First-party events, forms, transactions and consent, captured once at the source with the consent state attached.',
        'icon' => 'radar',
        'caps' => ['ai-campaign-optimization', 'ai-lead-generation'],
        'does' => ['Server-side tagging and one event schema', 'Consent captured with source, scope and timestamp', 'Offline and in-store events brought in', 'Intent signals from site, app, content and events'],
        'out'  => ['Event & data map', 'Tracking plan', 'Consent record'],
        'stack'=> ['googletagmanager', 'googleanalytics', 'posthog', 'mixpanel', 'airbyte'],
    ],
    'resolve' => [
        'code' => 'S2', 'name' => 'Resolve', 'short' => 'Resolve',
        'line' => 'Four systems that each think they know the customer become one profile, matched on hashed identifiers and deduplicated.',
        'icon' => 'fingerprint',
        'caps' => ['customer-relationship-strategy'],
        'does' => ['Deterministic match keys before probabilistic ones', 'Deduplication and merge rules with a survivorship order', 'One profile in your warehouse or platform', 'Retention and suppression applied to the record, not the list'],
        'out'  => ['Identity rules', 'Unified profile', 'Data dictionary'],
        'stack'=> ['snowflake', 'googlebigquery', 'dbt', 'postgresql', 'salesforce'],
    ],
    'decide' => [
        'code' => 'S3', 'name' => 'Decide', 'short' => 'Decide',
        'line' => 'Segments, value tiers, propensity and churn models, and the per-person choice of channel, offer and moment — each with a rule-based fallback.',
        'icon' => 'brain',
        'caps' => ['ai-driven-marketing-automation', 'customer-relationship-strategy', 'ai-lead-generation'],
        'does' => ['One segment definition every team uses', 'Propensity, churn and lifetime value models', 'Next best action with a confidence threshold', 'Frequency caps, quiet hours and pressure rules'],
        'out'  => ['Segmentation model', 'Decision rules', 'Contact strategy'],
        'stack'=> ['python', 'scikitlearn', 'hubspot', 'salesforce', 'zoho'],
    ],
    'produce' => [
        'code' => 'S4', 'name' => 'Produce', 'short' => 'Produce',
        'line' => 'Content modelled as data and creative generated inside brand rules, so one approved fact or concept reaches every size, locale and channel.',
        'icon' => 'layers',
        'caps' => ['content-communication-infrastructure', 'ai-creative-solutions'],
        'does' => ['Structured content and a governed asset library', 'Variant and feed-driven creative generation', 'Automated brand, claim and legal checks', 'Localisation reviewed in market'],
        'out'  => ['Content model', 'Component library', 'Variant sets'],
        'stack'=> ['contentful', 'sanity', 'figma', 'openai', 'replicate'],
    ],
    'activate' => [
        'code' => 'S5', 'name' => 'Activate', 'short' => 'Activate',
        'line' => 'Journeys, campaigns and sales workflows running across email, SMS, WhatsApp, push, in-app, paid media and the CRM — consent enforced at the moment of sending.',
        'icon' => 'workflow',
        'caps' => ['ai-driven-marketing-automation', 'automated-dynamic-sales', 'content-communication-infrastructure'],
        'does' => ['Lifecycle journeys with entry, exit and suppression rules', 'Authenticated senders and approved message templates', 'Audiences and exclusions pushed to paid platforms', 'Guided selling, quoting and routing in the CRM'],
        'out'  => ['Live journeys', 'Message templates', 'Routing rules'],
        'stack'=> ['twilio', 'whatsapp', 'hubspot', 'google', 'shopify'],
    ],
    'measure' => [
        'code' => 'S6', 'name' => 'Measure', 'short' => 'Measure',
        'line' => 'Holdouts, experiments, mix modelling and cohort retention, reported against one set of definitions — and fed straight back into the next decision.',
        'icon' => 'chart',
        'caps' => ['ai-campaign-optimization', 'customer-relationship-strategy', 'automated-dynamic-sales'],
        'does' => ['A holdout group on every always-on programme', 'Geo and holdout experiments that calibrate the models', 'Marketing mix modelling for the whole budget', 'Cohort retention and lifetime value against a baseline'],
        'out'  => ['Experiment readouts', 'Mix model', 'Retention dashboard'],
        'stack'=> ['looker', 'powerbi', 'googlebigquery', 'python', 'dbt'],
    ],
];

/* which stage a capability leads in, and every stage it works in */
$mth_stage_of = [
    'ai-driven-marketing-automation'       => 'activate',
    'content-communication-infrastructure' => 'produce',
    'ai-campaign-optimization'             => 'measure',
    'ai-creative-solutions'                => 'produce',
    'ai-lead-generation'                   => 'collect',
    'automated-dynamic-sales'              => 'activate',
    'customer-relationship-strategy'       => 'resolve',
];
$mth_caps_of = [];
foreach ($mth_stages as $mth_sk => $mth_sv) { $mth_caps_of[$mth_sk] = $mth_sv['caps']; }

return [
    'stages'   => $mth_stages,
    'stage_of' => $mth_stage_of,
    'caps_of'  => $mth_caps_of,
    /* The seven capability subpages are not built yet: a capability links to its card on this hub. */
    'cap_href' => fn (string $mth_slug): string => '#' . $mth_slug,
    'page_key' => 'marketing-technology',
];
