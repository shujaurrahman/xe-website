<?php
/**
 * Industries — the deep version of the categories we work in. "The category brief".
 *
 * The home page (sections/03-industries.php) names the six categories; the Brand Design and
 * Technology & Intelligence hubs each give their own sector read. This page is what those three
 * link into: what each category is under, what we do there across the six disciplines, the
 * instruments that shape the work, and how success is measured.
 *
 * The page is a shell. Every section is a partial in partials/industries/<id>.php with
 * assets/css/industries/<id>.css and assets/js/industries/<id>.js loaded only once the file
 * exists and holds something. Content lives in data/industries.php, so this file stays a shell.
 *
 * Base layers, in order: assets/css/brand/hub.css (.bdh-* primitives, window.BDH in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/industries.css (.ind-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE      data/site.php          $IND       data/industries.php
 *   $IND_SET   $IND['set'], the six categories, keyed by slug
 *   $IND_URL(disc, cap?)  a discipline or capability URL, resolving to the hub when the
 *                         capability subpage does not exist
 *   $IND_DISC(disc)       that discipline's row from $SITE['disciplines']
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col
 * $l $s, so every local in this page and its partials is prefixed ind_.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/tech/kit.php';

$IND     = require __DIR__ . '/data/industries.php';
$IND_SET = $IND['set'];

/** That discipline's row from data/site.php, or null. */
$IND_DISC = function (string $ind_slug) use ($SITE): ?array {
    foreach ($SITE['disciplines'] as $ind_row) {
        if ($ind_row['slug'] === $ind_slug) return $ind_row;
    }
    return null;
};

/**
 * The URL for a discipline, or for one of its capability subpages.
 * Only Brand Design and Technology & Intelligence have capability subpages built; anything else
 * resolves to the discipline hub, so this page never links at a file that is not there.
 */
$IND_URL = function (string $ind_slug, ?string $ind_cap = null): string {
    if ($ind_cap !== null && is_file(__DIR__ . '/services/' . $ind_slug . '/' . $ind_cap . '.php')) {
        return xe_url('services/' . $ind_slug . '/' . $ind_cap . '.php');
    }
    return is_file(__DIR__ . '/services/' . $ind_slug . '.php')
        ? xe_url('services/' . $ind_slug . '.php')
        : xe_url('services/');
};

/* Running order: who we serve → how we read a category → what transfers → the six in depth →
   the instruments → the systems → the AI angle → adjacent categories → how it starts → questions.
   Bands: P A I P A P I A P A, then the shared ink CTA. */
$IND_SECTIONS = ['scope', 'lens', 'transfer', 'dossiers', 'rules', 'stack', 'ai', 'adjacent', 'start', 'faq'];

/* Base layers first, then each section's own file once it holds content. head/footer stamp ?v=. */
$ind_asset = function (string $ind_path): ?string {
    $ind_f = __DIR__ . '/' . $ind_path;
    return (is_file($ind_f) && filesize($ind_f) > 0) ? $ind_path : null;
};
$ind_css = array_filter([
    $ind_asset('assets/css/brand/hub.css'),
    $ind_asset('assets/css/tech/kit.css'),
    $ind_asset('assets/css/industries.css'),
]);
$ind_js = array_filter([$ind_asset('assets/js/brand/hub.js')]);
foreach ($IND_SECTIONS as $ind_id) {
    if ($ind_x = $ind_asset('assets/css/industries/' . $ind_id . '.css')) $ind_css[] = $ind_x;
    if ($ind_x = $ind_asset('assets/js/industries/' . $ind_id . '.js'))   $ind_js[]  = $ind_x;
}

$page = [
    'key'   => 'industries',
    'title' => 'Industries',
    'desc'  => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media. What each category is under, what we do there, and how success is measured.',
    'css'   => array_values($ind_css),
    'js'    => array_values($ind_js),
];

$hero = [
    'eyebrow' => 'Industries',
    'title'   => 'Helping brands win in<br><span class="g">the categories they compete in</span>',
    'lead'    => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media. Six categories, read through what decides a purchase, what governs the words, and where the experience is actually had.',
    'meta'    => ['6 categories in depth', '6 disciplines applied', 'India-first, built to travel'],
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement and each waits
     for an .is-in class that only JavaScript adds, so with JavaScript off they resolve to the finished
     state here. The tabbed panes in #ai keep their own shown/hidden logic: one pane is meant to be on. -->

<main id="main" class="bdh ind">
<?php include 'partials/page-hero.php'; ?>
<?php
foreach ($IND_SECTIONS as $ind_id):
    $ind_file = __DIR__ . '/partials/industries/' . $ind_id . '.php'; ?>
<!-- ===== industries · <?= e($ind_id) ?> ===== -->
<?php if (is_file($ind_file)) { include $ind_file; } else { echo '<!-- missing industries section: ' . e($ind_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include 'partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'ItemList',
    'name'            => 'Industries served by ' . $SITE['company']['name'],
    'description'     => $page['desc'],
    'itemListOrder'   => 'https://schema.org/ItemListUnordered',
    'numberOfItems'   => count($IND_SET),
    'itemListElement' => array_values(array_map(fn (array $ind_c) => [
        '@type'    => 'ListItem',
        'position' => (int) $ind_c['n'],
        'item'     => [
            '@type'       => 'Service',
            'name'        => $ind_c['name'],
            'description' => $ind_c['pressure'],
            'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
            'url'         => xe_url('industries.php') . '#' . $ind_c['slug'],
        ],
    ], $IND_SET)),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include 'partials/footer.php'; ?>
