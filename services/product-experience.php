<?php
/**
 * Product & Experience Design — the discipline hub. "Ahead of the build."
 *
 * The concept: this discipline is the work that happens *before* anything expensive is built —
 * deciding what to build, and proving it before it is built. Every section is a view of that one
 * idea: the cost of deciding late (#stakes), the four gates a bet has to pass (#method), the
 * signature Proving Ground that puts a bet through the cheapest proof that could break it
 * (#proving), the evidence we gather (#research), and the system that makes the second screen
 * cheaper than the first (#system).
 *
 * The page is a shell: every section is its own partial in partials/product-experience/<id>.php,
 * with assets/css/product-experience/<id>.css and assets/js/product-experience/<id>.js loaded
 * automatically once they hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/product-experience.css (.pxh-* primitives for this discipline).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                     $DISC   the product-experience discipline row
 *   $CAPS   data/product-experience.php       $STACK  data/tech-stack.php (slug => name, category, file)
 *   $page   page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (pxh_*, hero_*, pg_* …) and never use those names.
 *
 * The five capability subpages do not exist yet, so every capability link on this page is an
 * anchor to that capability's card in #capabilities (id = the capability slug).
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the page and service

$CAPS  = require __DIR__ . '/../data/product-experience.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $pxh_disc) { if ($pxh_disc['slug'] === 'product-experience') $DISC = $pxh_disc; }
unset($pxh_disc);

/* Running order: the promise → why it matters → how we decide → the proof → what we do →
   the evidence → the system → AI → the standards → the tools → how we work → what you get →
   what changes → buy → questions.
   Bands: P P A I P A P I A P I P A P A P, then the shared ink CTA.
   'services' is the shared Services & packages catalogue (partials/services/catalogue.php, data key
   'product-experience'). Its packages row is this page's one set of engagement models, so there is no
   separate engagement section — the same call the Brand Design and Technology hubs made. */
$PXH_SECTIONS = [
    'hero', 'capabilities', 'stakes', 'method', 'proving', 'offer', 'research', 'system', 'ai',
    'standards', 'stack', 'process', 'deliverables', 'measures', 'services', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$pxh_root  = __DIR__ . '/../';
$pxh_asset = function (string $path) use ($pxh_root): ?string {
    $f = $pxh_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$pxh_css = array_filter([
    $pxh_asset('assets/css/brand/hub.css'),
    $pxh_asset('assets/css/tech/kit.css'),
    $pxh_asset('assets/css/product-experience.css'),
]);
$pxh_js = array_filter([$pxh_asset('assets/js/brand/hub.js')]);
foreach ($PXH_SECTIONS as $pxh_id) {
    if ($pxh_x = $pxh_asset('assets/css/product-experience/' . $pxh_id . '.css')) $pxh_css[] = $pxh_x;
    if ($pxh_x = $pxh_asset('assets/js/product-experience/' . $pxh_id . '.js'))   $pxh_js[]  = $pxh_x;
}
/* the shared services & packages catalogue (.svc-*), after the page's own files, as on every other hub */
if ($pxh_x = $pxh_asset('assets/css/services.css')) $pxh_css[] = $pxh_x;
if ($pxh_x = $pxh_asset('assets/js/services.js'))   $pxh_js[]  = $pxh_x;

$page = [
    'key'   => 'services',
    'title' => $DISC['name'],
    'desc'  => $DISC['intro'],
    'css'   => array_values($pxh_css),
    'js'    => array_values($pxh_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement, and every one of
     them waits for an .is-in class that only JavaScript adds, so with JavaScript off they are all resolved to
     their finished state here. Tab panes keep their own hidden/shown logic: one pane is meant to be on. -->

<main id="main" class="bdh pxh">
<?php foreach ($PXH_SECTIONS as $pxh_id):
    $pxh_file = __DIR__ . '/../partials/product-experience/' . $pxh_id . '.php'; ?>
<!-- ===== product & experience hub · <?= e($pxh_id) ?> ===== -->
<?php if (is_file($pxh_file)) { include $pxh_file; } else { echo "<!-- missing hub section: " . e($pxh_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $DISC['name'],
    'description' => $DISC['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($pxh_c) => $pxh_c[0], $DISC['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $DISC['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($pxh_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $pxh_c['name'], 'description' => $pxh_c['lead']],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
