<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * AI Design — the ONE capability-page template. Shells in services/ai-design/<slug>.php set $BASE and $AID_KEY
 * and require this file. Every section is data-driven from data/ai-design.php[$AID_KEY]; the few per-topic extras
 * that data file does not carry (outcome measures, the "where it sits" flow) live in partials/ai-design/cap/extra.php.
 * The one topic-specific piece is the signature mock, partials/ai-design/cap/sig/<slug>.php, shown in the hero.
 *
 * Reuses the hub's visual language (assets/css/ai-design.css: .aih-card, .aih-flow, .aih-bars, .aih-steps, .aih-rec)
 * and the hub's outcomes/standards/faq styles. Template-only styles: assets/css/ai-design/cap.css (.aid-*),
 * signature mocks: assets/css/ai-design/cap-sig.css; behaviour: assets/js/ai-design/cap/sig.js.
 *
 * Variables for the partials (never reassign): $SITE, $DISC, $CAPS, $CAP (= $CAPS[$AID_KEY]), $CAPROW (site.php row),
 * $AID_X (extras for this capability), $STACK, $AIH_URL, $AID_SVC (catalogue key). Locals are prefixed aid_.
 */
require_once __DIR__ . '/../../init.php';
require_once __DIR__ . '/../../tech/kit.php';
require_once __DIR__ . '/../../services/lib.php';

$CAPS  = require __DIR__ . '/../../../data/ai-design.php';
$STACK = require __DIR__ . '/../../../data/tech-stack.php';
$CAP   = $CAPS[$AID_KEY];
$AID_X = (require __DIR__ . '/extra.php')[$AID_KEY];
$AID_T = (require __DIR__ . '/topic.php')[$AID_KEY] ?? [];
/** Section heading from topic.php (grey phrase, ink rest), falling back to the template default. */
function aid_h(string $k, string $g, string $ink): string {
    global $AID_T;
    $aid_v = $AID_T['h'][$k] ?? [$g, $ink];
    return '<span class="g">' . e($aid_v[0]) . '</span> ' . e($aid_v[1]);
}
/** Section lead from topic.php, falling back to the template default. */
function aid_lead(string $k, string $d): string { global $AID_T; return e($AID_T['h'][$k][2] ?? $d); }
$AID_SVC = $CAP['svc'] ?? $CAP['slug'];
$DISC = null; $CAPROW = null;
foreach ($SITE['disciplines'] as $aid_d) { if ($aid_d['slug'] === 'ai-design') $DISC = $aid_d; }
foreach ($DISC['caps'] as $aid_r) { if ($aid_r[2] === $AID_KEY) $CAPROW = $aid_r; }
unset($aid_d, $aid_r);
$AIH_URL = xe_discipline_url($DISC);

$AID_SECTIONS = ['hero', 'offer', 'process', 'show', 'outcomes', 'deliverables', 'fit', 'stack', 'standards', 'services', 'faq', 'onward'];

$aid_root = __DIR__ . '/../../../';
$aid_has  = fn (string $p): ?string => (is_file($aid_root . $p) && filesize($aid_root . $p) > 0) ? $p : null;
$aid_css  = array_filter([
    $aid_has('assets/css/brand/hub.css'), $aid_has('assets/css/tech/kit.css'), $aid_has('assets/css/ai-design.css'),
    $aid_has('assets/css/ai-design/outcomes.css'), $aid_has('assets/css/ai-design/standards.css'), $aid_has('assets/css/ai-design/faq.css'),
    $aid_has('assets/css/ai-design/cap.css'), $aid_has('assets/css/ai-design/cap-sig.css'), $aid_has('assets/css/ai-design/cap-show.css'), $aid_has('assets/css/services.css'),
]);
$aid_js = array_filter([
    $aid_has('assets/js/brand/hub.js'), $aid_has('assets/js/ai-design/process.js'), $aid_has('assets/js/ai-design/models.js'),
    $aid_has('assets/js/ai-design/cap/sig.js'), $aid_has('assets/js/services.js'),
]);

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · AI Design',
    'desc'  => $CAPROW[1],
    'css'   => array_values($aid_css),
    'js'    => array_values($aid_js),
];

include __DIR__ . '/../../head.php';
include __DIR__ . '/../../nav.php';
?>

<main id="main" class="bdh aih aid aid--<?= e($AID_KEY) ?>">
<?php foreach ($AID_SECTIONS as $aid_id) include __DIR__ . "/$aid_id.php"; ?>
<?php include __DIR__ . '/../../cta.php'; ?>
</main>

<?php $aid_self = xe_cap_url($DISC, $CAPROW); ?>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'Service',
            'name'        => $CAP['name'],
            'serviceType' => $CAP['name'],
            'description' => $CAPROW[1],
            'provider'    => ['@type' => 'Organization', 'name' => 'Xterra Edze'],
            'areaServed'  => 'Worldwide',
            'category'    => 'AI Design',
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => $CAP['name'],
                'itemListElement' => array_map(fn ($aid_o) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $aid_o[0], 'description' => $aid_o[1]]], $CAP['offer']),
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Services', 'item' => xe_url('services.php')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'AI Design', 'item' => $AIH_URL],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $CAP['name'], 'item' => $aid_self],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php include __DIR__ . '/../../footer.php'; ?>
