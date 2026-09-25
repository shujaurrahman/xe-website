<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Marketing Technology — the shared capability page template (prefix mtd).
 *
 * services/marketing-technology/<slug>.php sets $MTD_KEY and includes this file. Every section is driven by
 * data/marketing-technology.php ($CAPS[$MTD_KEY]) plus the per-topic extras in ./topics.php (the diagram,
 * the illustrative chart and, for Customer Relationship Strategy, its five practice sections). The one piece of
 * per-topic markup is the signature mock, partials/marketing-technology/cap/sig/<slug>.php, shown in the hero.
 *
 * Components are the hub's (assets/css/marketing-technology.css): .mth-mod card system, .mth-flow diagram,
 * .mth-viz chart, .mth-steps stepper, .mth-chip, .mth-ledger; the hub's .mth-faq (faq.css) for questions.
 * Page layout lives in assets/css/marketing-technology/cap.css, the mocks in cap-sig.css, and
 * assets/js/marketing-technology/cap/cap.js drives the stepper and every signature mock.
 *
 * Locals are prefixed mtd_. Variables for sections: $SITE, $DISC, $CAPS, $CAP, $CAP_ROW, $MTD_X, $STACK.
 */
$BASE = $BASE ?? '../../';
require __DIR__ . '/../../init.php';
require_once __DIR__ . '/../../tech/kit.php';
require_once __DIR__ . '/../../services/lib.php';

$CAPS  = require __DIR__ . '/../../../data/marketing-technology.php';
$STACK = require __DIR__ . '/../../../data/tech-stack.php';
$CAP   = $CAPS[$MTD_KEY];
$MTD_X = (require __DIR__ . '/topics.php')[$MTD_KEY];
$MTD_HS = require __DIR__ . '/heads.php';
$MTD_H  = $MTD_HS[$MTD_KEY] ?? [];
require_once __DIR__ . '/matrix.php';
/* Section heading: topic copy from heads.php, template default as the fallback. Returns [grey, ink, lead]. */
$mtd_head = fn (string $mtd_k, array $mtd_def): array => ($MTD_H['h'][$mtd_k] ?? []) + $mtd_def;
$DISC  = null;
foreach ($SITE['disciplines'] as $mtd_x) { if ($mtd_x['slug'] === 'marketing-technology') $DISC = $mtd_x; }
$CAP_ROW = null;
foreach ($DISC['caps'] as $mtd_x) { if (($mtd_x[2] ?? '') === $MTD_KEY) $CAP_ROW = $mtd_x; }
unset($mtd_x);

/**
 * Signature mock frame. The mock body is aria-hidden; the state buttons are real, labelled controls, and a
 * visually hidden status line (role=status) says in words what the current state shows.
 * $states = [[button label, status sentence], …]; the shipped HTML is the last (finished) state.
 */
function mtd_sig_open(string $title, string $sub, array $states, string $group): string {
    $n = count($states);
    $h = '<div class="mtd-sig" data-mtd-sig data-state="' . $n . '">';
    $h .= '<div class="mtd-sig__bar"><span class="mtd-sig__dots" aria-hidden="true"><i></i><i></i><i></i></span><span class="bdh-ro">' . e($title) . '</span><span class="bdh-ro mtd-sig__sub">' . e($sub) . '</span></div>';
    $h .= '<div class="mtd-sig__ctl" role="group" aria-label="' . e($group) . '">';
    foreach ($states as $i => $st) {
        $h .= '<button type="button" class="mtd-sig__b" data-mtd-set="' . ($i + 1) . '" aria-pressed="' . ($i + 1 === $n ? 'true' : 'false') . '"><span class="bdh-ro">' . sprintf('%02d', $i + 1) . '</span> ' . e($st[0]) . '</button>';
    }
    $h .= '</div><p class="bdh-sr" role="status"';
    foreach ($states as $i => $st) $h .= ' data-t' . ($i + 1) . '="' . e($st[1]) . '"';
    return $h . '>' . e($states[$n - 1][1]) . '</p><div class="mtd-sig__body" aria-hidden="true">';
}
function mtd_sig_close(string $note): string {
    return '</div><p class="mtd-sig__note">' . e($note) . '</p></div>';
}
/** Text that changes per state: data-t1…tN, shipped with the last. */
function mtd_t(array $t): string {
    $h = '';
    foreach ($t as $i => $v) $h .= ' data-t' . ($i + 1) . '="' . e($v) . '"';
    return $h . '>' . e(end($t));
}

$MTD_CRS = $MTD_KEY === 'customer-relationship-strategy';
$MTD_SECTIONS = $MTD_CRS
    ? ['hero', 'parts', 'flow', 'process', 'deliver', 'outcomes', 'stack', 'standards', 'services', 'faq', 'onward']
    : ['hero', 'offer', 'flow', 'process', 'showcase', 'deliver', 'outcomes', 'stack', 'standards', 'services', 'faq', 'onward'];

$mtd_root = __DIR__ . '/../../../';
$mtd_has  = fn (string $p): ?string => (is_file($mtd_root . $p) && filesize($mtd_root . $p) > 0) ? $p : null;
$mtd_css  = array_values(array_filter([
    $mtd_has('assets/css/brand/hub.css'), $mtd_has('assets/css/tech/kit.css'), $mtd_has('assets/css/marketing-technology.css'),
    $mtd_has('assets/css/marketing-technology/faq.css'), $mtd_has('assets/css/marketing-technology/cap.css'),
    $mtd_has('assets/css/marketing-technology/cap-sig.css'), $mtd_has('assets/css/marketing-technology/cap-x.css'), $mtd_has('assets/css/services.css'),
]));
$mtd_js   = array_values(array_filter([
    $mtd_has('assets/js/brand/hub.js'), $mtd_has('assets/js/marketing-technology/cap/cap.js'), $mtd_has('assets/js/services.js'),
]));

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $DISC['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => $mtd_css,
    'js'    => $mtd_js,
];

include __DIR__ . '/../../head.php';
include __DIR__ . '/../../nav.php';
?>
<main id="main" class="bdh mth mtd mtd--<?= e($MTD_KEY) ?>">
<?php foreach ($MTD_SECTIONS as $mtd_id) include __DIR__ . "/$mtd_id.php"; ?>
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
            'url'         => xe_cap_url($DISC, $CAP_ROW),
            'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => $CAP['name'],
                'itemListElement' => array_map(fn ($mtd_o) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $mtd_o[0], 'description' => $mtd_o[1]]], $CAP['offer']),
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
