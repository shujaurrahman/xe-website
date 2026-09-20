<?php
/**
 * Custom Software & Data Platforms — capability 02 of Technology & Intelligence.
 * Concept: "The Schema". Software shaped around how the business runs: everything starts from the
 * domain model (accounts, contacts, orders, cases, consents) and grows outward into internal tools,
 * a customer data platform and a governed data platform. The page is drawn in entities, relations,
 * records and lineage.
 *
 * A shell: each section is partials/tech/custom-software-data-platforms/<id>.php with optional
 * assets/css/tech/custom-software-data-platforms/<id>.css and assets/js/tech/custom-software-data-platforms/<id>.js,
 * loaded when present and non-empty. Base layers: assets/css/brand/hub.css (.bdh-* primitives),
 * assets/css/tech/kit.css (.xt-* kit), assets/css/tech/custom-software-data-platforms.css (.tcs-* page primitives),
 * assets/js/brand/hub.js (window.BDH helpers). The 'services' section is the shared catalogue
 * (partials/services/catalogue.php, data key 'custom-software-data-platforms' in data/services/technology-intelligence.php);
 * its assets/css/services.css and assets/js/services.js load after the page's own files.
 *
 * Section partials see $SITE, $TECH (the discipline row), $TI (all ten capabilities), $CAP (this one),
 * $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (the logo library).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is tcs_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['custom-software-data-platforms'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tcs_disc) { if ($tcs_disc['slug'] === 'technology-intelligence') $TECH = $tcs_disc; }
unset($tcs_disc);
$CAP_ROW = null;
foreach (($TECH['caps'] ?? []) as $tcs_row) { if (($tcs_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tcs_row; }
unset($tcs_row);

/* Running order. Bands: P A P A I P A I P A P A P, the shared services catalogue (A), the FAQ (P),
   then the shared onward aid (P, ruled off) and the CTA. */
$TCS = [
    'hero', 'symptoms', 'console', 'offer', 'stitcher', 'lakehouse', 'stack',
    'governance', 'carbon', 'migration', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tcs_root = __DIR__ . '/../../';
$tcs_has  = function (string $path) use ($tcs_root): bool {
    $f = $tcs_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tcs_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/custom-software-data-platforms.css'];
$tcs_js  = ['assets/js/brand/hub.js'];
foreach ($TCS as $tcs_id) {
    $tcs_css[] = 'assets/css/tech/custom-software-data-platforms/' . $tcs_id . '.css';
    $tcs_js[]  = 'assets/js/tech/custom-software-data-platforms/' . $tcs_id . '.js';
}
unset($tcs_id);
/* the shared services catalogue (partials/services/catalogue.php), after the page's own files */
$tcs_css[] = 'assets/css/services.css';
$tcs_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($tcs_css, $tcs_has)),
    'js'    => array_values(array_filter($tcs_js, $tcs_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tcs">
<?php foreach ($TCS as $tcs_id):
    $tcs_file = __DIR__ . '/../../partials/tech/custom-software-data-platforms/' . $tcs_id . '.php'; ?>
<!-- ===== custom software & data platforms · <?= e($tcs_id) ?> ===== -->
<?php if (is_file($tcs_file)) { include $tcs_file; } else { echo '<!-- missing section: ' . e($tcs_id) . " -->\n"; } ?>
<?php endforeach; unset($tcs_id, $tcs_file); ?>

<!-- ===== custom software & data platforms · onward ===== -->
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
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name'] ?? 'Technology & Intelligence'],   // no absolute-URL helper yet; a relative url would be invalid in JSON-LD
    'serviceType' => ['Custom CRM', 'Customer data platform', 'Internal tools and back-office systems', 'Workflow and approvals engines', 'Data platform and semantic layer', 'Legacy modernisation'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
