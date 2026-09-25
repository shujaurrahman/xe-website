<?php /* DRAFT COPY — review before launch */
/**
 * Product & Experience Design — the ONE capability-page template. A shell in services/product-experience/<slug>.php sets
 *   $BASE = '../../'; $PXD_KEY = '<capability slug>';
 * and includes this file. Every section is data-driven from data/product-experience.php ($CAP) plus the page-level
 * additions in partials/product-experience/cap/extra.php ($PXD_X). The only topic-specific markup is the signature
 * mock in partials/product-experience/cap/sig/<slug>.php, shown in the hero.
 *
 * Reuses the hub's visual language (assets/css/product-experience.css: .pxh-card, .pxh-steps, .pxh-db, .pxh-win) and
 * the hub's section styles for process, outcomes, deliverables, stack, standards and FAQ. Template-only styles are
 * .pxd-* in assets/css/product-experience/cap.css; the five signature mocks share assets/css/product-experience/cap-sig.css
 * and assets/js/product-experience/cap/sig.js (a state switcher: the shipped HTML is state "a", finished and readable).
 *
 * Sections: hero(+signature) · offer · process · deliver · outcomes · stack · standards · services · faq · next · cta.
 * nav/cta/footer use $c $d $i $k $item $url $current $disc $col $l $s — every local here is pxd_*.
 */
require __DIR__ . '/../../init.php';
require_once __DIR__ . '/../../tech/kit.php';
require_once __DIR__ . '/../../services/lib.php';
$STACK = require __DIR__ . '/../../../data/tech-stack.php';
$CAPS  = require __DIR__ . '/../../../data/product-experience.php';
$PXD_XS = require __DIR__ . '/extra.php';
$CAP   = $CAPS[$PXD_KEY];
$PXD_X = $PXD_XS[$PXD_KEY];
$PXD_TS = require __DIR__ . '/topic.php';
$PXD_T  = $PXD_TS[$PXD_KEY] ?? [];
/* Section heading: topic copy from topic.php, template default as the fallback. Returns [grey, ink, lead]. */
$pxd_h = fn (string $pxd_k, array $pxd_def): array => ($PXD_T['h'][$pxd_k] ?? []) + $pxd_def;
$DISC  = null;
foreach ($SITE['disciplines'] as $pxd_d) { if ($pxd_d['slug'] === 'product-experience') $DISC = $pxd_d; }
$CAP_ROW = null;
foreach ($DISC['caps'] as $pxd_r) { if ($pxd_r[2] === $PXD_KEY) $CAP_ROW = $pxd_r; }
unset($pxd_d, $pxd_r);
$PXD_HUB = xe_url('services/product-experience.php');

$pxd_root = __DIR__ . '/../../../';
$pxd_has  = fn (string $p): ?string => (is_file($pxd_root . $p) && filesize($pxd_root . $p) > 0) ? $p : null;
$pxd_css  = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/product-experience.css'];
foreach (['hero', 'capabilities', 'process', 'outcomes', 'deliverables', 'stack', 'standards', 'faq'] as $pxd_f) $pxd_css[] = "assets/css/product-experience/$pxd_f.css";
$pxd_css = array_merge($pxd_css, ['assets/css/product-experience/cap.css', 'assets/css/product-experience/cap-sig.css', 'assets/css/product-experience/cap-x.css', 'assets/css/services.css']);
$pxd_js  = ['assets/js/brand/hub.js', 'assets/js/product-experience/outcomes.js', 'assets/js/product-experience/cap/sig.js', 'assets/js/services.js'];

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $DISC['name'],
    'desc'  => $CAP_ROW[1] ?? strip_tags($CAP['lead']),
    'css'   => array_values(array_filter(array_map($pxd_has, $pxd_css))),
    'js'    => array_values(array_filter(array_map($pxd_has, $pxd_js))),
];
include __DIR__ . '/../../head.php';
include __DIR__ . '/../../nav.php';
?>
<main id="main" class="bdh pxh pxd pxd--<?= e($PXD_KEY) ?>">
<?php
include __DIR__ . '/hero.php';
include __DIR__ . '/sections.php';
include __DIR__ . '/close.php';
include __DIR__ . '/../../cta.php';
?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'       => 'Service',
            'name'        => $CAP['name'],
            'serviceType' => $CAP['name'],
            'description' => $CAP_ROW[1] ?? strip_tags($CAP['lead']),
            'url'         => xe_cap_url($DISC, $CAP_ROW),
            'provider'    => ['@type' => 'Organization', 'name' => 'Xterra Edze'],
            'isRelatedTo' => ['@type' => 'Service', 'name' => $DISC['name'], 'url' => $PXD_HUB],
            'hasOfferCatalog' => [
                '@type' => 'OfferCatalog',
                'name'  => $CAP['name'],
                'itemListElement' => array_map(fn ($pxd_o) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $pxd_o[0], 'description' => $pxd_o[1]]], $CAP['offer']),
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Services', 'item' => xe_url('services/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => $DISC['name'], 'item' => $PXD_HUB],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $CAP['name'], 'item' => xe_cap_url($DISC, $CAP_ROW)],
            ],
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../../footer.php'; ?>
