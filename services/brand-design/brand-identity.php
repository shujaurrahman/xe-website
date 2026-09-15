<?php
/**
 * Brand Identity — capability page. Concept: "The Specimen Book" — an identity shown the way
 * a type foundry shows a typeface: crop marks, construction grids, big type, colourways.
 *
 * A shell: each section is partials/brand/brand-identity/<id>.php with optional
 * assets/css/brand/brand-identity/<id>.css and assets/js/brand/brand-identity/<id>.js, loaded
 * once non-empty. Base: assets/css/brand/hub.css (layout utilities only), assets/css/brand/brand-identity.css
 * (page tokens + specimen primitives), assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $BRAND, $BD, $CAP (= $BD['brand-identity']), $CAP_ROW (the $BRAND caps row).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is cbi_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD = require __DIR__ . '/../../data/brand-design.php';
$CAP = $BD['brand-identity'];
$BRAND = null;
foreach ($SITE['disciplines'] as $cbi_disc) { if ($cbi_disc['slug'] === 'brand-design') $BRAND = $cbi_disc; }
unset($cbi_disc);
$CAP_ROW = null;
foreach ($BRAND['caps'] as $cbi_row) { if (($cbi_row[2] ?? '') === 'brand-identity') $CAP_ROW = $cbi_row; }
unset($cbi_row);

/* Running order — plate by plate, like a specimen book. */
$CBI = [
    'hero', 'anatomy', 'offer', 'construct', 'colour', 'type', 'voice',
    'motion', 'touchpoints', 'process', 'deliver', 'outcomes', 'onward',
];

$cbi_root = __DIR__ . '/../../';
$cbi_has  = function (string $path) use ($cbi_root): bool {
    $f = $cbi_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$cbi_css = ['assets/css/brand/hub.css', 'assets/css/brand/brand-identity.css'];
$cbi_js  = ['assets/js/brand/hub.js'];
foreach ($CBI as $cbi_id) {
    if ($cbi_has('assets/css/brand/brand-identity/' . $cbi_id . '.css')) $cbi_css[] = 'assets/css/brand/brand-identity/' . $cbi_id . '.css';
    if ($cbi_has('assets/js/brand/brand-identity/' . $cbi_id . '.js'))   $cbi_js[]  = 'assets/js/brand/brand-identity/' . $cbi_id . '.js';
}

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($cbi_css, $cbi_has)),
    'js'    => array_values(array_filter($cbi_js, $cbi_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="cbi">
<?php foreach ($CBI as $cbi_id):
    $cbi_file = __DIR__ . '/../../partials/brand/brand-identity/' . $cbi_id . '.php'; ?>
<!-- ===== brand identity · <?= e($cbi_id) ?> ===== -->
<?php if (is_file($cbi_file)) { include $cbi_file; } else { echo '<!-- missing section: ' . e($cbi_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => $CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $BRAND['name']],
    'serviceType' => array_map(fn ($cbi_o) => $cbi_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
