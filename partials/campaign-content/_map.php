<?php
/**
 * Campaign & Content Design — the shared model behind every section of the hub.
 *
 * The discipline runs as a loop, not a stack: DECIDE what to say → BUILD what carries it →
 * PUBLISH it, always → REACH the people who repeat it → MEASURE, and decide again. The eight
 * capabilities each sit on one stage of that loop, and the loop's geometry (a 640 × 640 ring with
 * four arrows and four stage chips) is computed once here so the loop section, the navigator and
 * the capability cards all speak the same language.
 *
 * Returned keys
 *   stages     stage key => [code, name, lbl, q, lead, caps (slugs), out (what leaves), x, y, i]
 *   arcs       four [d, head] — the arc between two stage chips and its arrowhead, trimmed to stop
 *              short of both chips so no line ever runs through a box
 *   stage_of   capability slug => stage key
 *   ring       ['vb' => 640, 'r' => 200, 'c' => 320]
 *
 * Nothing here is content: every sentence below is drawn from data/campaign-content.php and
 * data/site.php, restated only to name the stage it belongs to.
 */

$cch_m_c  = 320.0;   // ring centre
$cch_m_r  = 200.0;   // ring radius
$cch_m_vb = 640.0;   // viewBox edge
$cch_m_gap = 22.0;   // degrees of clear air kept either side of a stage chip

$cch_m_stages = [
    'decide' => [
        'code' => '01', 'name' => 'Decide', 'lbl' => 'Decide what to say', 'deg' => -90.0,
        'q'    => 'Who are we reaching, in what order, with what budget, and how will we know it worked?',
        'lead' => 'One plan with owners, budgets and measures attached. Channel roles decided once, so nothing is bought out of habit.',
        'caps' => ['omnichannel-marketing-strategy'],
        'out'  => ['Channel architecture', 'Message sequence', 'Budget model with scenarios', 'One definition per metric'],
    ],
    'build' => [
        'code' => '02', 'name' => 'Build', 'lbl' => 'Build what carries it', 'deg' => 0.0,
        'q'    => 'What does the idea look like in forty formats and a dozen markets, and who makes the work?',
        'lead' => 'A campaign built like a product — tokens, templates, rules and checks — and original photography, film and CGI produced against the channel plan.',
        'caps' => ['campaign-design-systems', 'global-content-production'],
        'out'  => ['Campaign platform and art direction', 'Master templates and tokens', 'Original assets, market versions', 'Rights and provenance records'],
    ],
    'publish' => [
        'code' => '03', 'name' => 'Publish', 'lbl' => 'Publish it, always', 'deg' => 90.0,
        'q'    => 'What goes out this week, who answers the replies, and what is it supposed to do?',
        'lead' => 'An editorial engine and an always-on presence: briefed pieces that answer real questions, native social formats, and community management against agreed response times.',
        'caps' => ['content-marketing', 'social-media-marketing'],
        'out'  => ['Editorial calendar and briefs', 'Published clusters and native posts', 'Community log and escalation route', 'Repurposing plan'],
    ],
    'reach' => [
        'code' => '04', 'name' => 'Reach', 'lbl' => 'Reach the people who repeat it', 'deg' => 180.0,
        'q'    => 'Who carries this further than we can — journalists, creators, or the auction?',
        'lead' => 'Earned coverage you cannot buy, creators chosen on audience evidence, and paid media bought against outcomes you can verify.',
        'caps' => ['public-relations', 'social-influencer-activation', 'performance-marketing'],
        'out'  => ['Placed coverage and share of voice', 'Creator content with cleared rights', 'Consented measurement layer', 'Incrementality read'],
    ],
];

/* where each capability chip sits inside its stage's span of the ring, evenly spread */
$cch_m_i = 0;
foreach ($cch_m_stages as $cch_m_k => $cch_m_s) {
    $cch_m_rad = deg2rad($cch_m_s['deg']);
    $cch_m_stages[$cch_m_k]['x'] = round(($cch_m_c + $cch_m_r * cos($cch_m_rad)) / $cch_m_vb * 100, 3);
    $cch_m_stages[$cch_m_k]['y'] = round(($cch_m_c + $cch_m_r * sin($cch_m_rad)) / $cch_m_vb * 100, 3);
    $cch_m_stages[$cch_m_k]['i'] = $cch_m_i++;
}

$cch_m_stage_of = [];
foreach ($cch_m_stages as $cch_m_k => $cch_m_s) {
    foreach ($cch_m_s['caps'] as $cch_m_slug) { $cch_m_stage_of[$cch_m_slug] = $cch_m_k; }
}

/* one arrow per hop, from just after a chip to just before the next one */
$cch_m_pt = function (float $cch_m_deg) use ($cch_m_c, $cch_m_r): array {
    $cch_m_t = deg2rad($cch_m_deg);
    return [$cch_m_c + $cch_m_r * cos($cch_m_t), $cch_m_c + $cch_m_r * sin($cch_m_t)];
};
$cch_m_f = fn (float $cch_m_v): string => rtrim(rtrim(number_format($cch_m_v, 2, '.', ''), '0'), '.');

$cch_m_keys = array_keys($cch_m_stages);
$cch_m_arcs = [];
foreach ($cch_m_keys as $cch_m_n => $cch_m_k) {
    $cch_m_a = $cch_m_stages[$cch_m_k]['deg'] + $cch_m_gap;
    $cch_m_b = $cch_m_stages[$cch_m_keys[($cch_m_n + 1) % 4]]['deg'];
    if ($cch_m_b < $cch_m_a) $cch_m_b += 360.0;                 // the last hop wraps past 180°
    $cch_m_b -= $cch_m_gap;
    [$cch_m_x1, $cch_m_y1] = $cch_m_pt($cch_m_a);
    [$cch_m_x2, $cch_m_y2] = $cch_m_pt($cch_m_b - 5.0);          // stop short: the arrowhead covers the last 5°
    [$cch_m_hx, $cch_m_hy] = $cch_m_pt($cch_m_b);
    /* arrowhead: a triangle on the tangent at the arc's end (tangent of a clockwise sweep = angle + 90°) */
    $cch_m_tan = deg2rad($cch_m_b + 90.0);
    $cch_m_nor = deg2rad($cch_m_b);
    $cch_m_hl  = 11.0; $cch_m_hw = 5.5;
    $cch_m_bx  = $cch_m_hx - cos($cch_m_tan) * $cch_m_hl;
    $cch_m_by  = $cch_m_hy - sin($cch_m_tan) * $cch_m_hl;
    $cch_m_arcs[] = [
        'stage' => $cch_m_k,
        'd'     => 'M' . $cch_m_f($cch_m_x1) . ' ' . $cch_m_f($cch_m_y1)
                 . ' A' . $cch_m_f($cch_m_r) . ' ' . $cch_m_f($cch_m_r) . ' 0 0 1 '
                 . $cch_m_f($cch_m_x2) . ' ' . $cch_m_f($cch_m_y2),
        'head'  => 'M' . $cch_m_f($cch_m_hx) . ' ' . $cch_m_f($cch_m_hy)
                 . ' L' . $cch_m_f($cch_m_bx + cos($cch_m_nor) * $cch_m_hw) . ' ' . $cch_m_f($cch_m_by + sin($cch_m_nor) * $cch_m_hw)
                 . ' L' . $cch_m_f($cch_m_bx - cos($cch_m_nor) * $cch_m_hw) . ' ' . $cch_m_f($cch_m_by - sin($cch_m_nor) * $cch_m_hw) . ' Z',
    ];
}

return [
    'stages'   => $cch_m_stages,
    'arcs'     => $cch_m_arcs,
    'stage_of' => $cch_m_stage_of,
    'ring'     => ['vb' => $cch_m_vb, 'r' => $cch_m_r, 'c' => $cch_m_c],
];
