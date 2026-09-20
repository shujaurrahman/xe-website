<?php
/**
 * Brand Design › Brand Foundation — "The Decision Document".
 *
 * A shell: each section is partials/brand/brand-foundation/<id>.php with optional
 * assets/css/brand/brand-foundation/<id>.css and assets/js/brand/brand-foundation/<id>.js
 * (loaded once non-empty; head.php / footer.php stamp ?v=filemtime through xe_asset()).
 * Base: hub.css (layout utilities only) + hub.js (window.BDH helpers) + brand-foundation.css.
 *
 * Section partials may read $SITE $BRAND $BD $CAP $page. nav/cta/footer loop with
 * $c $d $i $k $item $url $current $disc $col $l $s — partials prefix locals with $cbf_.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD  = require __DIR__ . '/../../data/brand-design.php';
$CAP = $BD['brand-foundation'];
$BRAND = null;
foreach ($SITE['disciplines'] as $cbf_disc) { if ($cbf_disc['slug'] === 'brand-design') $BRAND = $cbf_disc; }
unset($cbf_disc);

/* Running order — reads like the document: premise → clauses → evidence → drafting → ratified → annex. */
$CBF = [
    'hero', 'essay', 'charter', 'tensions', 'composer', 'rules', 'narrative',
    'revisions', 'onepage', 'appendix', 'room', 'services', 'transcript', 'seealso',
];

$cbf_root = __DIR__ . '/../../';
$cbf_has  = fn (string $p): bool => is_file($cbf_root . $p) && filesize($cbf_root . $p) > 0;
$cbf_css  = ['assets/css/brand/hub.css', 'assets/css/services.css', 'assets/css/brand/brand-foundation.css'];
$cbf_js   = ['assets/js/brand/hub.js', 'assets/js/services.js'];
foreach ($CBF as $cbf_id) {
    if ($cbf_has($cbf_x = 'assets/css/brand/brand-foundation/' . $cbf_id . '.css')) $cbf_css[] = $cbf_x;
    if ($cbf_has($cbf_x = 'assets/js/brand/brand-foundation/' . $cbf_id . '.js'))   $cbf_js[]  = $cbf_x;
}

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($cbf_css, $cbf_has)),
    'js'    => array_values(array_filter($cbf_js, $cbf_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh cbf">
<?php foreach ($CBF as $cbf_id):
    $cbf_file = __DIR__ . '/../../partials/brand/brand-foundation/' . $cbf_id . '.php'; ?>
<!-- ===== brand-foundation · <?= e($cbf_id) ?> ===== -->
<?php if (is_file($cbf_file)) { include $cbf_file; } else { echo '<!-- missing section: ' . e($cbf_id) . " -->\n"; } ?>
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
    'isPartOf'    => ['@type' => 'Service', 'name' => $BRAND['name']],
    'serviceType' => array_map(fn ($cbf_o) => $cbf_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
