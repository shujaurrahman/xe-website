<?php
/**
 * Product & Experience Design — the discipline hub. "From signal to shipped".
 *
 * Concept: every product decision is a claim about people that can be tested. The page follows one idea
 * from a raw signal to a measured release, and every section is a view of that same loop
 * (evidence → journey → wireframe → prototype → release, with the assumptions tracked throughout).
 * Sections: partials/product-experience/<id>.php (+ assets/css/product-experience/<id>.css,
 * assets/js/product-experience/<id>.js, loaded automatically once they hold anything).
 *
 * Base layers: assets/css/brand/hub.css (.bdh-*), assets/css/tech/kit.css (.xt-*), then
 * assets/css/product-experience.css — the discipline's reusable visual language (.pxh-*):
 *
 *   CARD SYSTEM   .pxh-card (+ __top __idx __ico __t __d __list __foot, --ink)  a spec card with a
 *                 five-step fidelity rail .pxh-fid[data-fid="1..5"] showing how far an idea has travelled.
 *                 Capability pages: offer cards, outcome cards, pairs.
 *   DIAGRAM       .pxh-flow (+ __col __node __lbl __gate)  columns of nodes; connectors are drawn in the
 *                 gaps between columns (::after), never through a node, and turn vertical ≤860.
 *                 Capability pages: token pipeline, research ops, eval loop, operating model.
 *   DATA VIZ      .pxh-db dumbbell rows (baseline dot → result dot, target tick; values in %) and
 *                 .pxh-curve SVG line chart with mono axes. Always labelled "illustrative".
 *   STEPPER       .pxh-steps (+ __i __n __gate) numbered stages with a gate question between each;
 *                 horizontal ≥1024, vertical below. Capability pages: their process from data.
 *   TRACKER       .pxh-as assumption rows (state pill + confidence bar), reusable for any evidence list.
 *
 * Variables for every partial: $SITE, $DISC (this discipline's row in $SITE['disciplines']),
 * $CAPS (data/product-experience.php), $STACK (data/tech-stack.php), $page.
 * nav/cta/footer use $c $d $i $k $item $url $current $disc $col $l $s — partial locals are prefixed pxh_.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$CAPS  = require __DIR__ . '/../data/product-experience.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $pxh_x) { if ($pxh_x['slug'] === 'product-experience') $DISC = $pxh_x; }
unset($pxh_x);

$SECTIONS = ['hero', 'capabilities', 'shift', 'signal', 'process', 'ai', 'system', 'stack', 'standards', 'deliverables', 'outcomes', 'services', 'faq'];

$pp_root = __DIR__ . '/../';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/product-experience.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($pxh_f = $pp_has("assets/css/product-experience/$pp_id.css")) $pp_css[] = $pxh_f;
    if ($pxh_f = $pp_has("assets/js/product-experience/$pp_id.js"))   $pp_js[]  = $pxh_f;
}
if ($pxh_f = $pp_has('assets/css/services.css')) $pp_css[] = $pxh_f;
if ($pxh_f = $pp_has('assets/js/services.js'))   $pp_js[]  = $pxh_f;

$page = [
    'key'   => 'services',
    'title' => 'Product & Experience Design',
    'desc'  => $DISC['intro'],
    'css'   => array_values($pp_css),
    'js'    => array_values($pp_js),
];
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>
<main id="main" class="bdh pxh">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/../partials/product-experience/$pp_id.php"; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $DISC['name'],
    'serviceType' => 'Product and experience design',
    'description' => $DISC['intro'],
    'url'         => xe_url('services/product-experience.php'),
    'provider'    => ['@type' => 'Organization', 'name' => 'Xterra Edze'],
    'hasOfferCatalog' => [
        '@type' => 'OfferCatalog',
        'name'  => $DISC['name'],
        'itemListElement' => array_values(array_map(fn ($pxh_c) => [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $pxh_c['name'], 'description' => strip_tags($pxh_c['lead'])],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
