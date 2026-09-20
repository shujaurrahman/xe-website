<?php
/**
 * Brand Architecture — capability page. "The Portfolio as Structure".
 *
 * A shell: each section is partials/brand/brand-architecture/<id>.php with optional
 * assets/css/brand/brand-architecture/<id>.css and assets/js/brand/brand-architecture/<id>.js,
 * loaded once they hold anything. Page base: assets/css/brand/brand-architecture.css (.cba-*).
 * Layout utilities and motion helpers come from the hub base layer (hub.css / hub.js, window.BDH).
 *
 * Variables for section partials: $SITE, $BRAND (brand-design discipline), $BD, $CBA_CAP
 * ($BD['brand-architecture']). Locals are prefixed cba_ — never $c $d $i $k $item $url $current
 * $disc $col $l $s (nav / cta / footer loops).
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD = require __DIR__ . '/../../data/brand-design.php';
$BRAND = null;
foreach ($SITE['disciplines'] as $cba_disc) { if ($cba_disc['slug'] === 'brand-design') $BRAND = $cba_disc; }
unset($cba_disc);
$CBA_CAP = $BD['brand-architecture'];

/* Running order: the portfolio → the model → the rules → the route → the work → onward. */
$CBA = [
    'hero', 'audit', 'offer', 'spectrum', 'lockup', 'naming', 'wayfinding',
    'migration', 'process', 'register', 'outcomes', 'services', 'faq', 'onward',
];

$cba_root = __DIR__ . '/../../';
$cba_has  = fn (string $p): bool => is_file($cba_root . $p) && filesize($cba_root . $p) > 0;
$cba_css  = ['assets/css/brand/hub.css', 'assets/css/services.css'];
$cba_js   = ['assets/js/brand/hub.js', 'assets/js/services.js'];
if ($cba_has('assets/css/brand/brand-architecture.css')) $cba_css[] = 'assets/css/brand/brand-architecture.css';
if ($cba_has('assets/js/brand/brand-architecture.js'))   $cba_js[]  = 'assets/js/brand/brand-architecture.js';
foreach ($CBA as $cba_id) {
    if ($cba_has($cba_x = 'assets/css/brand/brand-architecture/' . $cba_id . '.css')) $cba_css[] = $cba_x;
    if ($cba_has($cba_x = 'assets/js/brand/brand-architecture/' . $cba_id . '.js'))   $cba_js[]  = $cba_x;
}

$page = [
    'key'   => 'services',
    'title' => $CBA_CAP['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CBA_CAP['lead'],
    'css'   => $cba_css,
    'js'    => $cba_js,
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh cba">
<?php foreach ($CBA as $cba_id):
    $cba_file = __DIR__ . '/../../partials/brand/brand-architecture/' . $cba_id . '.php'; ?>
<!-- ===== brand-architecture · <?= e($cba_id) ?> ===== -->
<?php if (is_file($cba_file)) { include $cba_file; } else { echo '<!-- missing section: ' . e($cba_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CBA_CAP['name'],
    'description' => $CBA_CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($cba_o) => $cba_o[0], $CBA_CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
