<?php
/**
 * AI Product & Automation — capability 04 of Technology & Intelligence. Concept: "The Glass Box".
 * AI features you can see inside. Every feature (a knowledge assistant, a conversation, a vision
 * check, a workflow automation) is shown opened up: inputs, retrieval, model, output, confidence,
 * eval score and the person in the loop. Nothing on this page is a black box.
 *
 * A shell: each section is partials/tech/ai-product-automation/<id>.php with optional
 * assets/css/tech/ai-product-automation/<id>.css and assets/js/tech/ai-product-automation/<id>.js,
 * loaded only when the file exists and is not empty. Base layers: assets/css/brand/hub.css
 * (.bdh-* primitives), assets/css/tech/kit.css (.xt-* logos, icons, badges, onward aid),
 * assets/css/tech/ai-product-automation.css (page tokens + .tap-* primitives), assets/js/brand/hub.js
 * (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (the discipline row in data/site.php), $TI (data/technology-intelligence.php),
 * $CAP (= $TI['ai-product-automation']), $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is tap_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['ai-product-automation'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tap_disc) { if ($tap_disc['slug'] === 'technology-intelligence') $TECH = $tap_disc; }
unset($tap_disc);
$CAP_ROW = null;
foreach ($TECH['caps'] as $tap_row) { if (($tap_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tap_row; }
unset($tap_row);

/* Running order. Bands: paper · alt · ink · paper · alt · ink · paper · alt · paper · alt · paper · ink · alt (services) · alt · (onward, paper).
   04.1 families · 04.2 inspector (signature) · 04.3 conversation · 04.4 vision · 04.5 automation · 04.6 stack ·
   04.7 quality · 04.8 efficiency · 04.9 process · 04.10 deliver · 04.11 outcomes · services & packages (shared
   catalogue, partials/services/catalogue.php) · 04.12 faq. */
$TAP = [
    'hero', 'families', 'inspector', 'conversation', 'vision', 'automation', 'stack',
    'quality', 'efficiency', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tap_root = __DIR__ . '/../../';
$tap_has  = function (string $path) use ($tap_root): bool {
    $f = $tap_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tap_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/ai-product-automation.css'];
$tap_js  = ['assets/js/brand/hub.js'];
foreach ($TAP as $tap_id) {
    if ($tap_has('assets/css/tech/ai-product-automation/' . $tap_id . '.css')) $tap_css[] = 'assets/css/tech/ai-product-automation/' . $tap_id . '.css';
    if ($tap_has('assets/js/tech/ai-product-automation/' . $tap_id . '.js'))   $tap_js[]  = 'assets/js/tech/ai-product-automation/' . $tap_id . '.js';
}
$tap_css[] = 'assets/css/services.css';   // the shared services & packages catalogue (.svc-*), after the page's own files
$tap_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $TECH['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($tap_css, $tap_has)),
    'js'    => array_values(array_filter($tap_js, $tap_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tap">
<?php foreach ($TAP as $tap_id):
    $tap_file = __DIR__ . '/../../partials/tech/ai-product-automation/' . $tap_id . '.php'; ?>
<!-- ===== ai product & automation · <?= e($tap_id) ?> ===== -->
<?php if (is_file($tap_file)) { include $tap_file; } else { echo '<!-- missing section: ' . e($tap_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== ai product & automation · onward ===== -->
<?php include __DIR__ . '/../../partials/tech/next.php'; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => $CAP_ROW[1] ?? $CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name']],   // no absolute-URL helper; a relative url is invalid in JSON-LD
    'serviceType' => array_map(fn ($tap_o) => $tap_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
