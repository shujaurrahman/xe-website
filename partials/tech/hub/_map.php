<?php
/**
 * Hub map — returned to the shell as $TIH. Not a section (the shell never includes it by id).
 *
 * layers  the four layers of "Your platform" and the capabilities that build each one
 *         (hero topology, platform diagram, navigator tags, composer mini-map).
 * nodes   capability slug => [x, y] in a 1000 × 700 stage: the one topology every map on the
 *         page is drawn on, so the hero and the composer read as views of the same system.
 * edges   [from slug, to slug, SVG path d] in the same stage, drawn in the hero.
 * layer_of slug => layer key (filled below).
 */
$tih_map = [
    'layers' => [
        'experience'   => ['name' => 'Experience',         'code' => 'L1', 'y' => 110, 'caps' => ['websites-apps', 'search-ai-visibility'],
                           'line' => 'What customers and search engines touch: web, mobile and answer surfaces.'],
        'intelligence' => ['name' => 'Intelligence',       'code' => 'L2', 'y' => 270, 'caps' => ['ai-strategy-agents', 'ai-product-automation'],
                           'line' => 'Agents, retrieval and automation that do work inside the product.'],
        'platform'     => ['name' => 'Platform & data',    'code' => 'L3', 'y' => 430, 'caps' => ['custom-software-data-platforms', 'ai-infrastructure-cloud', 'integration-support'],
                           'line' => 'Custom apps, customer data, the integration bus, the AI gateway and compute.'],
        'trust'        => ['name' => 'Trust & operations', 'code' => 'L4', 'y' => 590, 'caps' => ['cybersecurity-ai-trust', 'audits-assessments', 'tech-workforce'],
                           'line' => 'Security, audits and the people who run it, touching every layer.'],
    ],
    'nodes' => [
        'websites-apps'                  => [300, 110],
        'search-ai-visibility'           => [700, 110],
        'ai-strategy-agents'             => [300, 270],
        'ai-product-automation'          => [700, 270],
        'custom-software-data-platforms' => [200, 430],
        'ai-infrastructure-cloud'        => [500, 430],
        'integration-support'            => [800, 430],
        'cybersecurity-ai-trust'         => [200, 590],
        'audits-assessments'             => [500, 590],
        'tech-workforce'                 => [800, 590],
    ],
    'edges' => [
        ['search-ai-visibility',  'websites-apps',                  'M700 110 L300 110'],
        ['websites-apps',         'ai-product-automation',          'M300 110 C300 200 700 180 700 270'],
        ['ai-strategy-agents',    'ai-product-automation',          'M300 270 L700 270'],
        ['ai-product-automation', 'ai-infrastructure-cloud',        'M700 270 C700 360 500 340 500 430'],
        ['ai-infrastructure-cloud', 'integration-support',          'M500 430 L800 430'],
        ['integration-support',   'custom-software-data-platforms', 'M800 430 C800 350 200 350 200 430'],
        ['ai-infrastructure-cloud', 'cybersecurity-ai-trust',       'M500 430 C500 520 200 500 200 590'],
        ['cybersecurity-ai-trust', 'audits-assessments',            'M200 590 L500 590'],
        ['tech-workforce',        'integration-support',            'M800 590 L800 430'],
    ],
];
$tih_map['layer_of'] = [];
foreach ($tih_map['layers'] as $tih_lk => $tih_lv) {
    foreach ($tih_lv['caps'] as $tih_ls) { $tih_map['layer_of'][$tih_ls] = $tih_lk; }
}
unset($tih_lk, $tih_lv, $tih_ls);
return $tih_map;
