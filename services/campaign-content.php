<?php
/**
 * Campaign & Content Design — the discipline hub. "One idea, every frame."
 *
 * The page follows a single campaign idea as it travels: from the insight, through a key visual and a
 * kit of parts, into every channel's cut-down, onto a flighting plan, and back as a measured result.
 * Each section is its own partial in partials/campaign-content/<id>.php, with
 * assets/css/campaign-content/<id>.css and assets/js/campaign-content/<id>.js loaded once they hold anything.
 *
 * Base layers: assets/css/brand/hub.css (.bdh-*), assets/css/tech/kit.css (.xt-*), then
 * assets/css/campaign-content.css — the discipline's shared components, which the eight capability
 * pages reuse with their own content:
 *   .cch-card    card system      index · icon · title · text · tag list · foot link (+ --ink)
 *   .cch-frame   format frame     one key visual cropped to any aspect ratio with a spec tag (--r169 --r45 --r916 --r11 --r31)
 *   .cch-flow    diagram idiom    a node chain with CSS connectors that stop at each box edge; vertical ≤860
 *   .cch-viz     data-viz idiom   thin-line SVG on a mono axis, test vs holdout, lift area in --blue-wash
 *   .cch-steps   stepper          numbered rail, timing, description, outputs; horizontal → vertical ≤860
 *   .cch-fl      flighting grid   channel lanes × weeks with bars placed by --s/--e (start/end column)
 *   .cch-kpi     readout tile     mono label, figure, delta
 *
 * Variables for every partial (never reassign): $SITE, $DISC (this discipline's row), $CAPS
 * (data/campaign-content.php), $STACK (data/tech-stack.php). Partials prefix their locals with cch_.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';

$CAPS  = require __DIR__ . '/../data/campaign-content.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $cch_x) { if ($cch_x['slug'] === 'campaign-content') $DISC = $cch_x; }
unset($cch_x);

/* Running order: the idea → where it breaks → what we do → the board → the kit → AI → tools → rules →
   how we work → what you get → how it is measured → buy → questions. */
$CCH_SECTIONS = ['hero', 'drift', 'capabilities', 'board', 'kit', 'ai-native', 'stack', 'standards',
                 'process', 'deliverables', 'measures', 'services', 'faq'];

$cch_root = __DIR__ . '/../';
$cch_has  = fn (string $p): ?string => (is_file($cch_root . $p) && filesize($cch_root . $p) > 0) ? $p : null;
$cch_css  = array_filter([$cch_has('assets/css/brand/hub.css'), $cch_has('assets/css/tech/kit.css'), $cch_has('assets/css/campaign-content.css')]);
$cch_js   = array_filter([$cch_has('assets/js/brand/hub.js')]);
foreach ($CCH_SECTIONS as $cch_id) {
    if ($cch_x = $cch_has("assets/css/campaign-content/$cch_id.css")) $cch_css[] = $cch_x;
    if ($cch_x = $cch_has("assets/js/campaign-content/$cch_id.js"))   $cch_js[]  = $cch_x;
}
if ($cch_x = $cch_has('assets/css/services.css')) $cch_css[] = $cch_x;
if ($cch_x = $cch_has('assets/js/services.js'))   $cch_js[]  = $cch_x;

$page = [
    'key'   => 'services',
    'title' => 'Campaign & Content Design',
    'desc'  => $DISC['intro'],
    'css'   => array_values($cch_css),
    'js'    => array_values($cch_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>
<main id="main" class="bdh cch">
<?php foreach ($CCH_SECTIONS as $cch_id) include __DIR__ . "/../partials/campaign-content/$cch_id.php"; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $DISC['name'],
    'description' => $DISC['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($cch_c) => $cch_c[0], $DISC['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $DISC['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($cch_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $cch_c['name'], 'description' => $cch_c['lead']],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
