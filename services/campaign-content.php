<?php
/**
 * Campaign & Content Design — the discipline hub. "The attention loop."
 *
 * The concept: attention is earned, then compounded. The page runs as one loop —
 * DECIDE what to say → BUILD what carries it → PUBLISH it, always → REACH the people who
 * repeat it → MEASURE, and decide again. Every section is a view of that loop, and the eight
 * capabilities sit on it rather than in a stack.
 *
 * The page is a shell: each section is its own partial in partials/campaign-content/<id>.php,
 * with assets/css/campaign-content/<id>.css and assets/js/campaign-content/<id>.js loaded
 * automatically once they hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/campaign-content.css (.cch-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                    $DISC   the campaign-content discipline row
 *   $CAPS   data/campaign-content.php        $STACK  data/tech-stack.php (slug => name, category, file)
 *   $CCH    partials/campaign-content/_map.php   the four loop stages and the shared ring geometry
 *   $page   page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (cch_*, hero_*, adapt_* …) and never use those names.
 *
 * The eight capability subpages do not exist yet, so every capability link on this page is an
 * anchor to its card on this hub (#<capability-slug>), never a file.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the page and service

$CAPS  = require __DIR__ . '/../data/campaign-content.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $cch_disc) { if ($cch_disc['slug'] === 'campaign-content') $DISC = $cch_disc; }
unset($cch_disc);
$CCH = require __DIR__ . '/../partials/campaign-content/_map.php';

/* Running order: the loop → the eight on it → the machine that makes the work → proof it lands →
   how we work together → buy → ask.
   Bands: (hero) A P I P A P A I P A P A P I A P, then the shared ink CTA.
   'services' is the shared Services & packages catalogue (partials/services/catalogue.php, data key
   'campaign-content'). Its packages row is the page's one set of engagement models, so there is no
   separate engagement section — the same call the Brand Design and Technology hubs made. */
$CCH_SECTIONS = [
    'hero', 'navigator', 'shift', 'loop', 'capabilities', 'adapt', 'season', 'newsroom',
    'ai-native', 'mix', 'process', 'deliverables', 'standards', 'stack', 'measures', 'services', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$cch_root  = __DIR__ . '/../';
$cch_asset = function (string $path) use ($cch_root): ?string {
    $f = $cch_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$cch_css = array_filter([
    $cch_asset('assets/css/brand/hub.css'),
    $cch_asset('assets/css/tech/kit.css'),
    $cch_asset('assets/css/campaign-content.css'),
]);
$cch_js = array_filter([$cch_asset('assets/js/brand/hub.js')]);
foreach ($CCH_SECTIONS as $cch_id) {
    if ($cch_x = $cch_asset('assets/css/campaign-content/' . $cch_id . '.css')) $cch_css[] = $cch_x;
    if ($cch_x = $cch_asset('assets/js/campaign-content/' . $cch_id . '.js'))   $cch_js[]  = $cch_x;
}
/* the shared services & packages catalogue (.svc-*), after the page's own files, as on every hub */
if ($cch_x = $cch_asset('assets/css/services.css')) $cch_css[] = $cch_x;
if ($cch_x = $cch_asset('assets/js/services.js'))   $cch_js[]  = $cch_x;

$page = [
    'key'   => 'services',
    'title' => $DISC['name'],
    'desc'  => $DISC['intro'],
    'css'   => array_values($cch_css),
    'js'    => array_values($cch_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement, and every one of
     them waits for an .is-in class that only JavaScript adds, so with JavaScript off they are all resolved to
     their finished state here. Tab panes keep their own hidden/shown logic: one pane is meant to be on. -->

<main id="main" class="bdh cch">
<?php foreach ($CCH_SECTIONS as $cch_id):
    $cch_file = __DIR__ . '/../partials/campaign-content/' . $cch_id . '.php'; ?>
<!-- ===== campaign & content hub · <?= e($cch_id) ?> ===== -->
<?php if (is_file($cch_file)) { include $cch_file; } else { echo "<!-- missing hub section: " . e($cch_id) . " -->\n"; } ?>
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
    'serviceType' => array_map(fn ($cch_c) => $cch_c[0], $DISC['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $DISC['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($cch_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $cch_c['name'], 'description' => $cch_c['lead']],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
