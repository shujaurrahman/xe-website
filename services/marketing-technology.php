<?php
/**
 * Marketing Technology — the discipline hub. "The customer system."
 *
 * The concept: one consented customer record and everything that acts on it. Every section is a
 * view of the same loop — collect, resolve, decide, produce, activate, measure — so the seven
 * capabilities read as one running system rather than seven products. Deliberately NOT the
 * Technology hub's control plane: this page is about customer data (identity, consent, segments,
 * journeys, measurement), not about shipping and running software.
 *
 * The page is a shell: each section is its own partial in partials/marketing-technology/<id>.php,
 * with assets/css/marketing-technology/<id>.css and assets/js/marketing-technology/<id>.js loaded
 * automatically once they hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/marketing-technology.css (.mth-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                      $DISC   the marketing-technology discipline row
 *   $CAPS   data/marketing-technology.php      $STACK  data/tech-stack.php (slug => name, category, file)
 *   $MTH    partials/marketing-technology/_lib.php   the loop stages, the capability map, the diagram router
 *   $page   page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (mth_*, hero_*, std_* …) and never use those names.
 *
 * Capability subpages do not exist yet: every capability links to its card anchor on this page
 * (#<capability-slug>), never to a file.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the page and service

$CAPS  = require __DIR__ . '/../data/marketing-technology.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $mth_disc) { if ($mth_disc['slug'] === 'marketing-technology') $DISC = $mth_disc; }
unset($mth_disc);
$MTH = require __DIR__ . '/../partials/marketing-technology/_lib.php';

/* Running order: the record → why it leaks → the loop that fixes it → the machinery → the seven →
   what we build to → how we work → what it returns → buy → ask.
   Bands: hero, P A I P A P I A P I P A I, then the shared alt catalogue and a paper FAQ, then the ink CTA.
   'services' is the shared Services & packages catalogue (partials/services/catalogue.php, data key
   'marketing-technology'). Its packages row is this page's one set of engagement models, so there is no
   separate engagement section — the same call the other two finished hubs made. */
$MTH_SECTIONS = [
    'hero', 'navigator', 'seams', 'loop', 'identity', 'studio', 'capabilities', 'crs',
    'stack', 'standards', 'ai-native', 'process', 'deliverables', 'measures', 'services', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$mth_root  = __DIR__ . '/../';
$mth_asset = function (string $path) use ($mth_root): ?string {
    $f = $mth_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$mth_css = array_filter([
    $mth_asset('assets/css/brand/hub.css'),
    $mth_asset('assets/css/tech/kit.css'),
    $mth_asset('assets/css/marketing-technology.css'),
]);
$mth_js = array_filter([$mth_asset('assets/js/brand/hub.js')]);
foreach ($MTH_SECTIONS as $mth_id) {
    if ($mth_x = $mth_asset('assets/css/marketing-technology/' . $mth_id . '.css')) $mth_css[] = $mth_x;
    if ($mth_x = $mth_asset('assets/js/marketing-technology/' . $mth_id . '.js'))   $mth_js[]  = $mth_x;
}
/* the shared services & packages catalogue (.svc-*), after the page's own files, as on every other hub */
if ($mth_x = $mth_asset('assets/css/services.css')) $mth_css[] = $mth_x;
if ($mth_x = $mth_asset('assets/js/services.js'))   $mth_js[]  = $mth_x;

$page = [
    'key'   => 'services',
    'title' => 'Marketing Technology',
    'desc'  => $DISC['intro'],
    'css'   => array_values($mth_css),
    'js'    => array_values($mth_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement and every one of
     them waits for a class only JavaScript adds, so with JavaScript off they are all already resolved here.
     Tab and radio panes keep their own shown/hidden logic: one pane is always meant to be on. -->

<main id="main" class="bdh mth">
<?php
/* The page is rendered into a buffer so every brand mark can be inlined once. xt_logo() inlines a complete
   <svg> at each instance, and the stack wall, the loop panes, the capability cards and the services
   catalogue between them repeat about fifty distinct marks several hundred times. Each distinct mark is
   lifted into one <symbol> at the top of <main> and every instance becomes a <use> of it: same rendering,
   same attributes, a fraction of the bytes and DOM nodes. The proper home for this is xt_logo() in
   partials/tech/kit.php, which is shared and not ours to change. */
ob_start();
foreach ($MTH_SECTIONS as $mth_id):
    $mth_file = __DIR__ . '/../partials/marketing-technology/' . $mth_id . '.php'; ?>
<!-- ===== marketing technology hub · <?= e($mth_id) ?> ===== -->
<?php if (is_file($mth_file)) { include $mth_file; } else { echo "<!-- missing hub section: " . e($mth_id) . " -->\n"; } ?>
<?php endforeach;
include __DIR__ . '/../partials/cta.php';
$mth_body = (string) ob_get_clean();
$mth_re   = '~<svg\b([^>]*\bviewBox="([^"]+)"[^>]*)>((?:(?!</?svg\b).)*)</svg>~s';
/* only drawings that repeat, and only plain ones: nothing with an internal url(#…) reference or an
   <animate>, which would not survive being moved into a <symbol>'s shadow tree */
$mth_reuse = function (string $mth_d): bool {
    return strlen($mth_d) >= 120 && strpos($mth_d, 'url(#') === false && strpos($mth_d, '<animate') === false;
};
$mth_seen = [];
if (preg_match_all($mth_re, $mth_body, $mth_all, PREG_SET_ORDER)) {
    foreach ($mth_all as $mth_m) {
        if ($mth_reuse($mth_m[3])) {
            $mth_k = md5($mth_m[2] . '|' . $mth_m[3]);
            $mth_seen[$mth_k] = ($mth_seen[$mth_k] ?? 0) + 1;
        }
    }
}
$mth_syms = [];
$mth_body = preg_replace_callback($mth_re, function (array $mth_m) use (&$mth_syms, $mth_seen, $mth_reuse): string {
    $mth_k = md5($mth_m[2] . '|' . $mth_m[3]);
    if (!$mth_reuse($mth_m[3]) || ($mth_seen[$mth_k] ?? 0) < 2) return $mth_m[0];
    if (!isset($mth_syms[$mth_k])) {
        $mth_syms[$mth_k] = '<symbol id="mth-s' . count($mth_syms) . '" viewBox="' . $mth_m[2] . '">' . $mth_m[3] . '</symbol>';
    }
    preg_match('~ id="(mth-s\d+)"~', $mth_syms[$mth_k], $mth_sid);
    return '<svg' . $mth_m[1] . '><use href="#' . $mth_sid[1] . '"/></svg>';
}, $mth_body);
if ($mth_syms) {
    echo '<svg class="mth-sprite" aria-hidden="true" focusable="false" width="0" height="0"><defs>'
       . implode('', $mth_syms) . '</defs></svg>' . "\n";
}
echo $mth_body;
?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $DISC['name'],
    'description' => $DISC['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($mth_c) => $mth_c[0], $DISC['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $DISC['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($mth_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $mth_c['name'], 'description' => $mth_c['lead']],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
