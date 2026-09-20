<?php
/**
 * Brand Systems — capability page. Concept: "The Living System" (a brand run like a product).
 *
 * A shell: each section is partials/brand/brand-systems/<id>.php with optional
 * assets/css/brand/brand-systems/<id>.css and assets/js/brand/brand-systems/<id>.js,
 * loaded once they hold anything. Page base: assets/css/brand/brand-systems.css (.cbs-*).
 * Layout utilities and motion helpers come from hub.css / hub.js (window.BDH).
 *
 * Available to every partial: $SITE, $BRAND (the brand-design discipline), $BD, $CAP ($BD['brand-systems']).
 * nav/cta/footer use $c $d $i $k $item $url $current $disc $col $l $s — partials prefix locals with cbs_.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD = require __DIR__ . '/../../data/brand-design.php';
$CAP = $BD['brand-systems'];
$BRAND = null;
foreach ($SITE['disciplines'] as $cbs_disc) { if ($cbs_disc['slug'] === 'brand-design') $BRAND = $cbs_disc; }
unset($cbs_disc);

/* Running order: the pipeline → the editor → what we build → how it runs → proof → onward. */
$CBS = [
    'hero', 'editor', 'manifest', 'flex', 'inventory', 'templates',
    'governance', 'docs', 'process', 'bundle', 'adoption', 'services', 'faq', 'onward',
];

$cbs_root = __DIR__ . '/../../';
$cbs_has = function (string $p) use ($cbs_root): bool { $f = $cbs_root . $p; return is_file($f) && filesize($f) > 0; };
$cbs_css = ['assets/css/brand/hub.css', 'assets/css/services.css'];
$cbs_js  = ['assets/js/brand/hub.js', 'assets/js/services.js'];
if ($cbs_has('assets/css/brand/brand-systems.css')) $cbs_css[] = 'assets/css/brand/brand-systems.css';
if ($cbs_has('assets/js/brand/brand-systems.js'))   $cbs_js[]  = 'assets/js/brand/brand-systems.js';
foreach ($CBS as $cbs_id) {
    if ($cbs_has('assets/css/brand/brand-systems/' . $cbs_id . '.css')) $cbs_css[] = 'assets/css/brand/brand-systems/' . $cbs_id . '.css';
    if ($cbs_has('assets/js/brand/brand-systems/' . $cbs_id . '.js'))   $cbs_js[]  = 'assets/js/brand/brand-systems/' . $cbs_id . '.js';
}

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CAP['lead'],
    'css'   => $cbs_css,
    'js'    => $cbs_js,
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="cbs">
<?php foreach ($CBS as $cbs_id):
    $cbs_file = __DIR__ . '/../../partials/brand/brand-systems/' . $cbs_id . '.php'; ?>
<!-- ===== brand-systems · <?= e($cbs_id) ?> ===== -->
<?php if (is_file($cbs_file)) { include $cbs_file; } else { echo '<!-- missing section: ' . e($cbs_id) . " -->\n"; } ?>
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
    'serviceType' => array_map(fn ($cbs_o) => $cbs_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
