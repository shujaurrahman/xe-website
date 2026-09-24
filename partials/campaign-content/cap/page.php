<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Campaign & Content Design — the shared capability page template.
 *
 * services/campaign-content/<slug>.php sets $CCD_KEY and includes this file. Every section is driven by
 * data/campaign-content.php ($CAPS[$CCD_KEY]); the only per-topic markup is the signature mock in
 * partials/campaign-content/cap/sig/<slug>.php, shown in the hero. Components are the hub's
 * (.cch-card, .cch-steps, .cch-faq, .cch-viz) plus assets/css/campaign-content/cap.css (layout) and
 * cap-sig.css (the signature mocks); assets/js/campaign-content/cap/sig.js drives every mock.
 *
 * Locals are prefixed ccd_. Variables for sections: $SITE, $DISC, $CAPS, $CAP, $CAP_ROW, $STACK.
 */
$BASE = $BASE ?? '../../';
require __DIR__ . '/../../init.php';
require_once __DIR__ . '/../../tech/kit.php';
require_once __DIR__ . '/../../services/lib.php';

$CAPS  = require __DIR__ . '/../../../data/campaign-content.php';
$STACK = require __DIR__ . '/../../../data/tech-stack.php';
$CAP   = $CAPS[$CCD_KEY];
$DISC  = null;
foreach ($SITE['disciplines'] as $ccd_x) { if ($ccd_x['slug'] === 'campaign-content') $DISC = $ccd_x; }
$CAP_ROW = null;
foreach ($DISC['caps'] as $ccd_x) { if (($ccd_x[2] ?? '') === $CCD_KEY) $CAP_ROW = $ccd_x; }
unset($ccd_x);
$CCD_T = (require __DIR__ . '/topic.php')[$CCD_KEY] ?? [];

/** Section heading from topic.php (grey phrase, ink rest), falling back to the template default. */
function ccd_h(string $k, string $g, string $ink): string {
    global $CCD_T;
    $ccd_v = $CCD_T['h'][$k] ?? [$g, $ink];
    return '<span class="g">' . e($ccd_v[0]) . '</span> ' . e($ccd_v[1]);
}
/** Section lead from topic.php, falling back to the template default. */
function ccd_lead(string $k, string $d): string { global $CCD_T; return e($CCD_T['h'][$k][2] ?? $d); }
/** Offer plate for a capability, or null. */
function ccd_img(string $slug): ?array {
    static $ccd_all = null;
    $ccd_all ??= require __DIR__ . '/topic.php';
    return $ccd_all[$slug]['img'] ?? null;
}

/** Signature mock frame: the title bar and the real, labelled state buttons. */
function ccd_sig_head(string $title, string $sub, array $opts, string $label, int $on = 1): string {
    $h = '<div class="ccd-sig__bar"><span class="ccd-sig__dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="bdh-ro">' . e($title) . '</span><span class="bdh-ro ccd-sig__sub">' . e($sub) . '</span></div>';
    if (!$opts) return $h;
    $h .= '<div class="ccd-sig__ctl" role="group" aria-label="' . e($label) . '">';
    foreach (array_values($opts) as $ccd_i => $ccd_o) {
        $h .= '<button type="button" class="ccd-sig__b" data-ccd-set="' . ($ccd_i + 1) . '" aria-pressed="' . ($ccd_i + 1 === $on ? 'true' : 'false') . '">' . e($ccd_o) . '</button>';
    }
    return $h . '</div>';
}

$CCD_SECTIONS = ['hero', 'offer', 'process', 'show', 'deliver', 'outcomes', 'stack', 'standards', 'services', 'faq', 'onward'];

$ccd_root = __DIR__ . '/../../../';
$ccd_has  = fn (string $p): ?string => (is_file($ccd_root . $p) && filesize($ccd_root . $p) > 0) ? $p : null;
$ccd_css  = array_values(array_filter([
    $ccd_has('assets/css/brand/hub.css'), $ccd_has('assets/css/tech/kit.css'), $ccd_has('assets/css/campaign-content.css'),
    $ccd_has('assets/css/campaign-content/faq.css'), $ccd_has('assets/css/campaign-content/cap.css'),
    $ccd_has('assets/css/campaign-content/cap-sig.css'), $ccd_has('assets/css/campaign-content/cap-show.css'), $ccd_has('assets/css/services.css'),
]));
$ccd_js   = array_values(array_filter([
    $ccd_has('assets/js/brand/hub.js'), $ccd_has('assets/js/campaign-content/cap/sig.js'), $ccd_has('assets/js/services.js'),
]));

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $DISC['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => $ccd_css,
    'js'    => $ccd_js,
];

include __DIR__ . '/../../head.php';
include __DIR__ . '/../../nav.php';
?>
<main id="main" class="bdh cch ccd ccd--<?= e($CCD_KEY) ?>">
<?php foreach ($CCD_SECTIONS as $ccd_id) include __DIR__ . "/$ccd_id.php"; ?>
<?php include __DIR__ . '/../../cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'Service',
            'name'        => $CAP['name'],
            'description' => $CAP['lead'],
            'serviceType' => $CAP['name'],
            'category'    => $DISC['name'],
            'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => $CAP['name'],
                'itemListElement' => array_map(fn ($ccd_o) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $ccd_o[0], 'description' => $ccd_o[1]]], $CAP['offer']),
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => xe_url('')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $DISC['name'], 'item' => xe_discipline_url($DISC)],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $CAP['name']],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../footer.php'; ?>
