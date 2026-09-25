<?php
/**
 * AI Design — the discipline hub. "The Studio Floor": one request, routed across models, checked, scored and
 * approved by a person before anything ships. Every section is a view of that same working studio.
 *
 * Sections: partials/ai-design/<id>.php (+ assets/css/ai-design/<id>.css, assets/js/ai-design/<id>.js, loaded
 * when non-empty). Base layers: brand/hub.css (.bdh-*, window.BDH), tech/kit.css (.xt-*), ai-design.css (.aih-*).
 *
 * Variables for every partial (never reassign): $SITE, $DISC (this discipline's row in $SITE['disciplines']),
 * $CAPS (data/ai-design.php, keyed by capability slug), $STACK (data/tech-stack.php), $AIH_URL (this hub's URL).
 * Partials prefix their locals with aih_ — nav/cta/footer use $c $d $i $k $item $url $current $disc $col $l $s.
 *
 * VISUAL LANGUAGE FOR THE FOUR CAPABILITY PAGES — reuse these (all in assets/css/ai-design.css, prefix .aih-):
 *   Card system   .aih-card (+ --ink, --flat) with .aih-card__media / __body / __idx / __t / __d / __foot;
 *                 .aih-cards (auto grid, 1→2→4 columns). Stable id on each card = the capability slug.
 *   Diagram idiom .aih-flow > .aih-node (+ --blue, --ghost) joined by .aih-edge (CSS connector that starts and
 *                 stops at the box edges — never centre-to-centre); horizontal ≥861px, vertical below.
 *   Data-viz      .aih-bars > .aih-bar (label, track, fill via --v 0–1, value) with an optional
 *                 .aih-bars__thr threshold line at --t; finished widths in the HTML, JS only animates.
 *   Stepper       .aih-steps > .aih-step (index, name, timing, text, outputs); horizontal rail ≥1024px with a
 *                 progress line JS fills on scroll; plain ordered list without JS.
 *   Record chip   .aih-rec (mono key/value readout used in the hero, studio log and states mocks).
 * The signature showcase (partials/ai-design/studio.php) is the hub's own and is not reused on subpages.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';

$CAPS  = require __DIR__ . '/../data/ai-design.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $aih_d) { if ($aih_d['slug'] === 'ai-design') $DISC = $aih_d; }
unset($aih_d);
$AIH_URL = xe_url('services/ai-design.php');

/* Bands: P A I P A P A P A P I A(catalogue) P, then the shared ink CTA. */
$AIH_SECTIONS = ['hero', 'capabilities', 'studio', 'states', 'models', 'two-tools', 'process', 'stack',
                 'standards', 'deliverables', 'outcomes', 'services', 'faq'];

$aih_root = __DIR__ . '/../';
$aih_has  = fn (string $p): ?string => (is_file($aih_root . $p) && filesize($aih_root . $p) > 0) ? $p : null;
$aih_css  = array_filter([$aih_has('assets/css/brand/hub.css'), $aih_has('assets/css/tech/kit.css'), $aih_has('assets/css/ai-design.css')]);
$aih_js   = array_filter([$aih_has('assets/js/brand/hub.js')]);
foreach ($AIH_SECTIONS as $aih_id) {
    if ($aih_x = $aih_has("assets/css/ai-design/$aih_id.css")) $aih_css[] = $aih_x;
    if ($aih_x = $aih_has("assets/js/ai-design/$aih_id.js"))   $aih_js[]  = $aih_x;
}
if ($aih_x = $aih_has('assets/css/services.css')) $aih_css[] = $aih_x;
if ($aih_x = $aih_has('assets/js/services.js'))   $aih_js[]  = $aih_x;

$page = [
    'key'   => 'services',
    'title' => 'AI Design',
    'desc'  => $DISC['intro'],
    'css'   => array_values($aih_css),
    'js'    => array_values($aih_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<main id="main" class="bdh aih">
<?php foreach ($AIH_SECTIONS as $aih_id) include __DIR__ . "/../partials/ai-design/$aih_id.php"; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<script type="application/ld+json"><?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => 'AI Design',
    'serviceType' => 'AI experience design, generative content production, custom brand models and AI adoption consulting',
    'description' => $DISC['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => 'Xterra Edze'],
    'areaServed'  => 'Worldwide',
    'hasOfferCatalog' => [
        '@type' => 'OfferCatalog',
        'name'  => 'AI Design capabilities',
        'itemListElement' => array_map(fn ($aih_cp) => [
            '@type' => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $aih_cp[0], 'description' => $aih_cp[1]],
        ], $DISC['caps']),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
