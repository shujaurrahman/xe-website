<?php
/**
 * Technology & Intelligence — the discipline hub. "The Control Plane".
 *
 * The ten capabilities shown as one running platform: every section is a view of the same
 * system (topology, composer, stack, gates, telemetry). The page is a shell: each section is
 * its own partial in partials/tech/hub/<id>.php, with assets/css/tech/hub/<id>.css and
 * assets/js/tech/hub/<id>.js loaded automatically once they hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/tech/hub.css (.tih-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                         $TECH   the technology-intelligence discipline row
 *   $TI     data/technology-intelligence.php      $STACK  data/tech-stack.php (slug => name, category, file)
 *   $TIH    partials/tech/hub/_map.php            layers of "Your platform" and the shared node layout
 *   $page   page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (tih_*, hero_*, cmp_* …) and never use those names.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the page and service

$TI    = require __DIR__ . '/../data/technology-intelligence.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tih_disc) { if ($tih_disc['slug'] === 'technology-intelligence') $TECH = $tih_disc; }
unset($tih_disc);
$TIH = require __DIR__ . '/../partials/tech/hub/_map.php';

/* Running order: the platform → how it is built → proof it holds → how we work together → buy.
   Bands: P P A I P A P I P A P A I P A P A, then the shared ink CTA.
   'services' is the shared Services & packages catalogue (partials/services/catalogue.php, data key
   'technology-intelligence' in data/services/technology-intelligence.php). Its packages row is the page's one set of
   engagement models, so there is no separate engagement section (the same call the Brand Design hub made). */
$TIH_SECTIONS = [
    'hero', 'navigator', 'shift', 'platform', 'composer', 'stack', 'standards', 'ai-native', 'pace',
    'delivery', 'sustainability', 'industries', 'measures', 'global', 'services', 'principles', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$tih_root  = __DIR__ . '/../';
$tih_asset = function (string $path) use ($tih_root): ?string {
    $f = $tih_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$tih_css = array_filter([
    $tih_asset('assets/css/brand/hub.css'),
    $tih_asset('assets/css/tech/kit.css'),
    $tih_asset('assets/css/tech/hub.css'),
]);
$tih_js = array_filter([$tih_asset('assets/js/brand/hub.js')]);
foreach ($TIH_SECTIONS as $tih_id) {
    if ($tih_x = $tih_asset('assets/css/tech/hub/' . $tih_id . '.css')) $tih_css[] = $tih_x;
    if ($tih_x = $tih_asset('assets/js/tech/hub/' . $tih_id . '.js'))   $tih_js[]  = $tih_x;
}
/* the shared services & packages catalogue (.svc-*), after the page's own files, as on every capability page */
if ($tih_x = $tih_asset('assets/css/services.css')) $tih_css[] = $tih_x;
if ($tih_x = $tih_asset('assets/js/services.js'))   $tih_js[]  = $tih_x;

$page = [
    'key'   => 'services',
    'title' => 'Technology & Intelligence',
    'desc'  => $TECH['intro'],
    'css'   => array_values($tih_css),
    'js'    => array_values($tih_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement, and every one of
     them waits for an .is-in class that only JavaScript adds, so with JavaScript off they are all resolved to
     their finished state here. Tab panes keep their own hidden/shown logic: one pane is meant to be on. -->

<main id="main" class="bdh tih">
<?php
/* The page is rendered into a buffer so every brand mark can be inlined once. xt_logo() inlines a complete
   <svg> at each instance, and this page shows about ninety distinct marks several hundred times over
   (the stack wall, the platform layers, the standards wall, the services catalogue), which was 45% of the
   document. Here each distinct mark is lifted into one <symbol> at the top of <main> and every instance
   becomes a <use> of it — same rendering, same attributes, a fraction of the bytes and DOM nodes.
   The proper home for this is xt_logo() in partials/tech/kit.php, which is shared and not ours to change. */
ob_start();
foreach ($TIH_SECTIONS as $tih_id):
    $tih_file = __DIR__ . '/../partials/tech/hub/' . $tih_id . '.php'; ?>
<!-- ===== tech hub · <?= e($tih_id) ?> ===== -->
<?php if (is_file($tih_file)) { include $tih_file; } else { echo "<!-- missing hub section: " . e($tih_id) . " -->\n"; } ?>
<?php endforeach;
include __DIR__ . '/../partials/cta.php';
$tih_body = (string) ob_get_clean();
$tih_re   = '~<svg\b([^>]*\bviewBox="([^"]+)"[^>]*)>((?:(?!</?svg\b).)*)</svg>~s';
/* only drawings that repeat, and only plain ones: nothing with an internal url(#…) reference or an
   <animate>, which would not survive being moved into a <symbol>'s shadow tree */
$tih_reuse = function (string $tih_d): bool {
    return strlen($tih_d) >= 120 && strpos($tih_d, 'url(#') === false && strpos($tih_d, '<animate') === false;
};
$tih_seen = [];
if (preg_match_all($tih_re, $tih_body, $tih_all, PREG_SET_ORDER)) {
    foreach ($tih_all as $tih_m) {
        if ($tih_reuse($tih_m[3])) $tih_seen[md5($tih_m[2] . '|' . $tih_m[3])] = ($tih_seen[md5($tih_m[2] . '|' . $tih_m[3])] ?? 0) + 1;
    }
}
$tih_syms = [];
$tih_body = preg_replace_callback($tih_re, function (array $tih_m) use (&$tih_syms, $tih_seen, $tih_reuse): string {
    $tih_k = md5($tih_m[2] . '|' . $tih_m[3]);
    if (!$tih_reuse($tih_m[3]) || ($tih_seen[$tih_k] ?? 0) < 2) return $tih_m[0];
    if (!isset($tih_syms[$tih_k])) {
        $tih_syms[$tih_k] = '<symbol id="xt-s' . count($tih_syms) . '" viewBox="' . $tih_m[2] . '">' . $tih_m[3] . '</symbol>';
    }
    preg_match('~ id="(xt-s\d+)"~', $tih_syms[$tih_k], $tih_id);
    return '<svg' . $tih_m[1] . '><use href="#' . $tih_id[1] . '"/></svg>';
}, $tih_body);
if ($tih_syms) {
    echo '<svg class="tih-sprite" aria-hidden="true" focusable="false" width="0" height="0"><defs>'
       . implode('', $tih_syms) . '</defs></svg>' . "\n";
}
echo $tih_body;
?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $TECH['name'],
    'description' => $TECH['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($tih_c) => $tih_c[0], $TECH['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $TECH['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($tih_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $tih_c['name'], 'description' => $tih_c['lead']],
        ], $TI)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
