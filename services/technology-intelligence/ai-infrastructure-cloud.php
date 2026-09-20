<?php
/**
 * AI Infrastructure & Cloud — capability 05 of Technology & Intelligence.
 * Concept: "The Engine Room" — the backend shown as live telemetry: GPUs, queues, token throughput,
 * p95 latency, error budgets, cost and carbon per request. Reliability is proven by breaking
 * things on purpose (#chaos, the Failure Drill) and watching the system recover.
 *
 * A shell: each section is partials/tech/ai-infrastructure-cloud/<id>.php with optional
 * assets/css/tech/ai-infrastructure-cloud/<id>.css and assets/js/tech/ai-infrastructure-cloud/<id>.js,
 * loaded only when present and non-empty. Base layers: assets/css/brand/hub.css (.bdh-* utilities),
 * assets/css/tech/kit.css (.xt-* logos, icons, badges, onward aid), assets/css/tech/ai-infrastructure-cloud.css
 * (page tokens + engine-room primitives), assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (discipline row), $TI (data/technology-intelligence.php),
 * $CAP (= $TI['ai-infrastructure-cloud']), $CAP_ROW (this capability's row in $TECH['caps']) and $STACK
 * (data/tech-stack.php). nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s,
 * so every local here is tic_* and every section local is prefixed by its section.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['ai-infrastructure-cloud'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';

$TECH = null;
foreach ($SITE['disciplines'] as $tic_disc) { if ($tic_disc['slug'] === 'technology-intelligence') $TECH = $tic_disc; }
unset($tic_disc);
$CAP_ROW = null;
foreach ($TECH['caps'] as $tic_row) { if (($tic_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tic_row; }
unset($tic_row);

/* Running order — band rhythm I P A I P A P A I P A P A(services) P, then the shared onward aid.
   hero · 02 pressure · 03 reference · 04 chaos (signature) · 05 serving · 06 stack · 07 finops · 08 carbon ·
   09 reliability · 10 process · 11 deliver · 12 outcomes · services & packages (shared catalogue,
   partials/services/catalogue.php) · 13 faq. */
$TIC = [
    'hero', 'pressure', 'reference', 'chaos', 'serving', 'stack', 'finops',
    'carbon', 'reliability', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tic_root = __DIR__ . '/../../';
$tic_has  = function (string $path) use ($tic_root): bool {
    $f = $tic_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tic_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/ai-infrastructure-cloud.css'];
$tic_js  = ['assets/js/brand/hub.js'];
foreach ($TIC as $tic_id) {
    if ($tic_has('assets/css/tech/ai-infrastructure-cloud/' . $tic_id . '.css')) $tic_css[] = 'assets/css/tech/ai-infrastructure-cloud/' . $tic_id . '.css';
    if ($tic_has('assets/js/tech/ai-infrastructure-cloud/' . $tic_id . '.js'))   $tic_js[]  = 'assets/js/tech/ai-infrastructure-cloud/' . $tic_id . '.js';
}
unset($tic_id);
$tic_css[] = 'assets/css/services.css';   // the shared services & packages catalogue (.svc-*), after the page's own files
$tic_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $TECH['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($tic_css, $tic_has)),
    'js'    => array_values(array_filter($tic_js, $tic_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tic">
<?php foreach ($TIC as $tic_id):
    $tic_file = __DIR__ . '/../../partials/tech/ai-infrastructure-cloud/' . $tic_id . '.php'; ?>
<!-- ===== ai infrastructure & cloud · <?= e($tic_id) ?> ===== -->
<?php if (is_file($tic_file)) { include $tic_file; } else { echo '<!-- missing section: ' . e($tic_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== onward (shared) ===== -->
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
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name']],
    'serviceType' => array_map(fn ($tic_o) => $tic_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
