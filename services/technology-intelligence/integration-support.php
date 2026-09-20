<?php
/**
 * Integration & Support — capability 07 of Technology & Intelligence. Concept: "The Switchboard".
 * Your systems drawn as a transit network: stations, lines, events and contracts, with a control
 * room that answers when something breaks. Support after launch is shown as operating practice.
 *
 * A shell: each section is partials/tech/integration-support/<id>.php with optional
 * assets/css/tech/integration-support/<id>.css and assets/js/tech/integration-support/<id>.js,
 * loaded only when the file exists and is not empty. Base layers: assets/css/brand/hub.css
 * (.bdh-* primitives), assets/css/tech/kit.css (.xt-* logos, icons, badges, onward aid),
 * assets/css/tech/integration-support.css (page tokens + .tis-* primitives), assets/js/brand/hub.js
 * (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (the discipline row in data/site.php), $TI (data/technology-intelligence.php),
 * $CAP (= $TI['integration-support']), $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is tis_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['integration-support'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tis_disc) { if ($tis_disc['slug'] === 'technology-intelligence') $TECH = $tis_disc; }
unset($tis_disc);
$CAP_ROW = null;
foreach ($TECH['caps'] as $tis_row) { if (($tis_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tis_row; }
unset($tis_row);

/* Running order. Bands: paper · alt · paper · ink · alt · paper · ink · alt · paper · alt · paper · ink ·
   alt (services, the shared catalogue) · paper (faq), then the onward aid. */
$TIS = [
    'hero', 'sprawl', 'mapper', 'patterns', 'catalogue', 'contracts', 'support',
    'tiers', 'consolidate', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tis_root = __DIR__ . '/../../';
$tis_has  = function (string $path) use ($tis_root): bool {
    $f = $tis_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tis_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/integration-support.css'];
$tis_js  = ['assets/js/brand/hub.js'];
foreach ($TIS as $tis_id) {
    if ($tis_has('assets/css/tech/integration-support/' . $tis_id . '.css')) $tis_css[] = 'assets/css/tech/integration-support/' . $tis_id . '.css';
    if ($tis_has('assets/js/tech/integration-support/' . $tis_id . '.js'))   $tis_js[]  = 'assets/js/tech/integration-support/' . $tis_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$tis_css[] = 'assets/css/services.css';
$tis_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $TECH['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($tis_css, $tis_has)),
    'js'    => array_values(array_filter($tis_js, $tis_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tis">
<?php foreach ($TIS as $tis_id):
    $tis_file = __DIR__ . '/../../partials/tech/integration-support/' . $tis_id . '.php'; ?>
<!-- ===== integration & support · <?= e($tis_id) ?> ===== -->
<?php if (is_file($tis_file)) { include $tis_file; } else { echo '<!-- missing section: ' . e($tis_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== integration & support · onward ===== -->
<?php include __DIR__ . '/../../partials/tech/next.php'; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => $CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name']],
    'serviceType' => array_map(fn ($tis_o) => $tis_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
