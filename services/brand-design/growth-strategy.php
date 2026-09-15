<?php
/**
 * Brand Design › Growth Strategy — "The Terrain": the market as terrain to be read.
 *
 * A shell. Each section is partials/brand/growth-strategy/<id>.php with optional
 * assets/css/brand/growth-strategy/<id>.css and assets/js/brand/growth-strategy/<id>.js,
 * loaded when non-empty (head.php / footer.php stamp ?v= through xe_asset()).
 * Base: assets/css/brand/hub.css + assets/js/brand/hub.js for layout utilities and the
 * invisible window.BDH helpers only; every visible component is styled in this page's
 * own files (.cgs-*).
 *
 * Available to every partial: $SITE, $BRAND (brand-design discipline), $BD (data/brand-design.php),
 * $CAP ($BD['growth-strategy']), $page. nav/cta/footer loop with $c $d $i $k $item $url $current
 * $disc $col $l $s — partials prefix their locals (cgs_…).
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD = require __DIR__ . '/../../data/brand-design.php';
$CAP = $BD['growth-strategy'];
$BRAND = null;
foreach ($SITE['disciplines'] as $cgs_disc) { if ($cgs_disc['slug'] === 'brand-design') $BRAND = $cgs_disc; }
unset($cgs_disc);

/* Running order: read the ground → score it → decide → route → measure → hand over. */
$CGS = ['hero', 'hides', 'ledger', 'scorer', 'whitespace', 'thesis', 'route', 'moves', 'kpi', 'pack', 'outcomes', 'faq', 'onward'];

$cgs_root = __DIR__ . '/../../';
$cgs_has  = fn (string $p): bool => is_file($cgs_root . $p) && filesize($cgs_root . $p) > 0;
$cgs_css  = ['assets/css/brand/hub.css', 'assets/css/brand/growth-strategy.css'];
$cgs_js   = ['assets/js/brand/hub.js'];
foreach ($CGS as $cgs_id) {
    if ($cgs_has('assets/css/brand/growth-strategy/' . $cgs_id . '.css')) $cgs_css[] = 'assets/css/brand/growth-strategy/' . $cgs_id . '.css';
    if ($cgs_has('assets/js/brand/growth-strategy/' . $cgs_id . '.js'))   $cgs_js[]  = 'assets/js/brand/growth-strategy/' . $cgs_id . '.js';
}

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($cgs_css, $cgs_has)),
    'js'    => array_values(array_filter($cgs_js, $cgs_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh cgs">
<?php foreach ($CGS as $cgs_id):
    $cgs_file = __DIR__ . '/../../partials/brand/growth-strategy/' . $cgs_id . '.php'; ?>
<!-- ===== growth-strategy · <?= e($cgs_id) ?> ===== -->
<?php if (is_file($cgs_file)) { include $cgs_file; } else { echo '<!-- missing section: ' . e($cgs_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => strip_tags($CAP['lead']),
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $BRAND['name']],
    'serviceType' => array_map(fn ($cgs_o) => $cgs_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
