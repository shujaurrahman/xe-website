<?php
/**
 * Brand Design — the discipline hub. "The brand as an operating system."
 *
 * The page is a shell: every section is its own partial in partials/brand/hub/<id>.php,
 * with optional assets/css/brand/hub/<id>.css and assets/js/brand/hub/<id>.js that are
 * loaded automatically once they hold anything. Shared base: assets/css/brand/hub.css
 * (.bdh-* classes) and assets/js/brand/hub.js (window.BDH helpers).
 *
 * Variables available to every section partial:
 *   $SITE   data/site.php            $BRAND  the brand-design discipline (n, name, intro, caps)
 *   $BD     data/brand-design.php    $page   page meta — never reassign any of these.
 * partials/nav.php loops with $c $d $i $k $item $url $current $disc — so section partials
 * prefix their own locals ($cap_rows, $jr_stages, …) and never use those short names.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';

$BD = require __DIR__ . '/../data/brand-design.php';
$BRAND = null;
foreach ($SITE['disciplines'] as $bdh_disc) { if ($bdh_disc['slug'] === 'brand-design') $BRAND = $bdh_disc; }
unset($bdh_disc);

/* Running order: belief → system → world → proof → buy.
   'services' is the shared catalogue (partials/services/catalogue.php, data/services/brand-design.php). Its packages
   row replaced the 'engagement' section (partials/brand/hub/engagement.php, kept on disk but no longer shown), so the
   page never carries two competing sets of engagement models. */
$HUB = [
    'hero', 'navigator', 'why-now', 'capabilities', 'journey', 'ai-os', 'ai-trust', 'deliverables',
    'touchpoints', 'industries', 'global', 'sustainability', 'measurement', 'principles', 'services', 'faq',
];

/* Base layer first, then each section's own file once it has content. ?v= busts the cache on edit. */
$bdh_root  = __DIR__ . '/../';
$bdh_asset = function (string $path) use ($bdh_root): ?string {
    $f = $bdh_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path . '?v=' . filemtime($f) : null;
};
$bdh_css = array_filter([$bdh_asset('assets/css/brand/hub.css'), $bdh_asset('assets/css/services.css')]);
$bdh_js  = array_filter([$bdh_asset('assets/js/brand/hub.js'), $bdh_asset('assets/js/services.js')]);
foreach ($HUB as $bdh_id) {
    if ($bdh_x = $bdh_asset('assets/css/brand/hub/' . $bdh_id . '.css')) $bdh_css[] = $bdh_x;
    if ($bdh_x = $bdh_asset('assets/js/brand/hub/' . $bdh_id . '.js'))   $bdh_js[]  = $bdh_x;
}

$page = [
    'key'   => 'services',
    'title' => 'Brand Design',
    'desc'  => $BRAND['intro'],
    'css'   => array_values($bdh_css),
    'js'    => array_values($bdh_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<main id="main" class="bdh">
<?php foreach ($HUB as $bdh_id):
    $bdh_file = __DIR__ . '/../partials/brand/hub/' . $bdh_id . '.php'; ?>
<!-- ===== hub · <?= e($bdh_id) ?> ===== -->
<?php if (is_file($bdh_file)) { include $bdh_file; } else { echo "<!-- missing hub section: " . e($bdh_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $BRAND['name'],
    'description' => $BRAND['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($bdh_c) => $bdh_c[0], $BRAND['caps']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
