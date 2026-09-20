<?php
/**
 * Brand AI Tools — capability page. Concept: "The Machine Room".
 * The tooling that makes brand-safe content at scale, with people in charge.
 *
 * A shell: each section is partials/brand/brand-ai-tools/<id>.php with its own
 * assets/css/brand/brand-ai-tools/<id>.css and assets/js/brand/brand-ai-tools/<id>.js
 * (included only when non-empty). Base: assets/css/brand/brand-ai-tools.css (.cat-*),
 * plus the hub's layout utilities and BDH motion helpers.
 *
 * Available to partials: $SITE $BRAND $BD $CAT (= $BD['brand-ai-tools']) $CAT_CAPS $page.
 * nav/cta/footer loop with $c $d $i $k $item $url $current $disc $col $l $s —
 * partials prefix their locals with $cat_.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';

$BD = require __DIR__ . '/../../data/brand-design.php';
$BRAND = null;
foreach ($SITE['disciplines'] as $cat_disc) { if ($cat_disc['slug'] === 'brand-design') $BRAND = $cat_disc; }
unset($cat_disc);
$CAT = $BD['brand-ai-tools'];

/* capability rows from data/site.php keyed by slug */
$CAT_CAPS = [];
foreach ($BRAND['caps'] as $cat_row) { $CAT_CAPS[$cat_row[2]] = $cat_row; }
unset($cat_row);

/* Running order: the room → the commands → the data → the run → the checks → the record → the handover. */
$CAT_SECTIONS = [
    'hero', 'help', 'curate', 'playground', 'guardrails', 'eval',
    'provenance', 'vault', 'deploy', 'registry', 'reports', 'services', 'man', 'onward',
];

$cat_root = __DIR__ . '/../../';
$cat_has  = fn (string $p): bool => is_file($cat_root . $p) && filesize($cat_root . $p) > 0;
$cat_css  = ['assets/css/brand/hub.css', 'assets/css/services.css', 'assets/css/brand/brand-ai-tools.css'];
$cat_js   = ['assets/js/brand/hub.js', 'assets/js/services.js'];
foreach ($CAT_SECTIONS as $cat_id) {
    if ($cat_has($cat_x = 'assets/css/brand/brand-ai-tools/' . $cat_id . '.css')) $cat_css[] = $cat_x;
    if ($cat_has($cat_x = 'assets/js/brand/brand-ai-tools/' . $cat_id . '.js'))   $cat_js[]  = $cat_x;
}

$page = [
    'key'   => 'services',
    'title' => $CAT['name'] . ' · ' . $BRAND['name'],
    'desc'  => $CAT['lead'],
    'css'   => array_values(array_filter($cat_css, $cat_has)),
    'js'    => array_values(array_filter($cat_js, $cat_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh cat">
<?php foreach ($CAT_SECTIONS as $cat_id):
    $cat_file = __DIR__ . '/../../partials/brand/brand-ai-tools/' . $cat_id . '.php'; ?>
<!-- ===== brand-ai-tools · <?= e($cat_id) ?> ===== -->
<?php if (is_file($cat_file)) { include $cat_file; } else { echo '<!-- missing section: ' . e($cat_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAT['name'],
    'description' => $CAT['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($cat_o) => $cat_o[0], $CAT['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
