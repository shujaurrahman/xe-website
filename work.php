<?php
/**
 * Work — the showcase index. "The archive."
 *
 * The page is a shell. Every case study comes from data/work.php; nothing about a project is
 * written into a partial. Sections live in partials/work/<id>.php with assets/css/work/<id>.css
 * and assets/js/work/<id>.js, loaded automatically once those files hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* icons and badges), then
 * assets/css/work.css (.wk-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php            $WORK   data/work.php (industries, fields, cases)
 *   $WK     the derived view of $WORK: entries with facets resolved, and the facet counts
 *   $page   page meta                $hero   hero copy
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col
 * $l $s, so section partials prefix their own locals (wk_*) and never use those names.
 *
 * The discipline and industry filters work without JavaScript: they are a real GET form and the
 * filtering below is done in PHP. assets/js/work/index.js upgrades them to filter instantly.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/tech/kit.php';

$WORK = require 'data/work.php';

/* ---------- the derived view every section reads ------------------------------------------ */
$wk_disc = [];
foreach ($SITE['disciplines'] as $wk_d) {
    $wk_disc[$wk_d['slug']] = ['n' => $wk_d['n'], 'name' => $wk_d['name'], 'short' => $wk_d['short'], 'url' => xe_discipline_url($wk_d), 'intro' => $wk_d['intro']];
}
unset($wk_d);

$wk_cases = [];
foreach ($WORK['cases'] as $wk_c) {
    $wk_c['industry_label'] = $WORK['industries'][$wk_c['sector']] ?? $wk_c['sector'];
    $wk_c['attrib'] = ($wk_c['client'] !== '' && empty($wk_c['confidential'])) ? $wk_c['client'] : $wk_c['industry_label'];
    $wk_c['disc_names'] = [];
    foreach ($wk_c['disciplines'] as $wk_s) { $wk_c['disc_names'][$wk_s] = $wk_disc[$wk_s]['name'] ?? $wk_s; }
    $wk_cases[] = $wk_c;
}
unset($wk_c, $wk_s);

/* facet counts, so a filter never offers a chip that would empty the grid */
$wk_count_d = $wk_count_i = [];
foreach ($wk_cases as $wk_c) {
    foreach ($wk_c['disciplines'] as $wk_s) { $wk_count_d[$wk_s] = ($wk_count_d[$wk_s] ?? 0) + 1; }
    $wk_count_i[$wk_c['sector']] = ($wk_count_i[$wk_c['sector']] ?? 0) + 1;
}
unset($wk_c, $wk_s);

/* ---------- the filter, read from the query string so it works without JavaScript --------- */
$wk_pick = function (string $wk_key, array $wk_valid): array {
    $wk_raw = $_GET[$wk_key] ?? [];
    if (is_string($wk_raw)) $wk_raw = explode(',', $wk_raw);
    if (!is_array($wk_raw)) return [];
    $wk_out = [];
    foreach ($wk_raw as $wk_v) {
        if (!is_string($wk_v)) continue;
        $wk_v = trim($wk_v);
        if ($wk_v !== '' && isset($wk_valid[$wk_v]) && !in_array($wk_v, $wk_out, true)) $wk_out[] = $wk_v;
    }
    return array_slice($wk_out, 0, 12);
};
$wk_on_d = $wk_pick('d', $wk_disc);
$wk_on_i = $wk_pick('i', $WORK['industries']);

$wk_matches = function (array $wk_c) use ($wk_on_d, $wk_on_i): bool {
    if ($wk_on_d && !array_intersect($wk_on_d, $wk_c['disciplines'])) return false;
    if ($wk_on_i && !in_array($wk_c['sector'], $wk_on_i, true)) return false;
    return true;
};

$WK = [
    'disc'       => $wk_disc,
    'industries' => $WORK['industries'],
    'fields'     => $WORK['fields'],
    'cases'      => $wk_cases,
    'count_d'    => $wk_count_d,
    'count_i'    => $wk_count_i,
    'on_d'       => $wk_on_d,
    'on_i'       => $wk_on_i,
    'matches'    => $wk_matches,
    'filtered'   => ($wk_on_d || $wk_on_i),
    'shown'      => count(array_filter($wk_cases, $wk_matches)),
    'real'       => count(array_filter($wk_cases, fn (array $wk_c): bool => empty($wk_c['placeholder']))),
    'holding'    => count(array_filter($wk_cases, fn (array $wk_c): bool => !empty($wk_c['placeholder']))),
];

/* Running order: what this is → the work → the record behind it → where it happens →
   who does it → the bar it is held to → how outcomes are evidenced → what we cannot show → ask.
   Bands: P A P I P A P A P, then the shared ink CTA. */
$WK_SECTIONS = ['brief', 'index', 'anatomy', 'sectors', 'disciplines', 'craft', 'measure', 'confidential', 'faq'];

$wk_asset = function (string $wk_path): ?string {
    return (is_file(__DIR__ . '/' . $wk_path) && filesize(__DIR__ . '/' . $wk_path) > 0) ? $wk_path : null;
};
$wk_css = array_filter([
    $wk_asset('assets/css/brand/hub.css'),
    $wk_asset('assets/css/tech/kit.css'),
    $wk_asset('assets/css/work.css'),
]);
$wk_js = array_filter([$wk_asset('assets/js/brand/hub.js')]);
foreach ($WK_SECTIONS as $wk_id) {
    if ($wk_x = $wk_asset('assets/css/work/' . $wk_id . '.css')) $wk_css[] = $wk_x;
    if ($wk_x = $wk_asset('assets/js/work/' . $wk_id . '.js'))   $wk_js[]  = $wk_x;
}

$page = [
    'key'   => 'work',
    'title' => 'Work',
    'desc'  => 'Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it.',
    'css'   => array_values($wk_css),
    'js'    => array_values($wk_js),
];

$hero = [
    'eyebrow' => 'Selected work',
    'title'   => 'Delivered.<br><span class="g">And on the record.</span>',
    'lead'    => 'Work that reshapes how people experience a brand, moves the numbers that matter, and leaves the system better than we found it.',
    'meta'    => [
        count($WK['cases']) . ' records',
        count($WK['count_i']) . ' of ' . count($WK['industries']) . ' sectors',
        count($WK['count_d']) . ' of ' . count($WK['disc']) . ' disciplines',
    ],
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement: each one
     waits for an .is-in class only JavaScript adds, and partials/head.php restores the finished state
     in a <noscript> block. The showcase filter is a real GET form filtered in PHP, so it works with
     JavaScript off; assets/js/work/index.js only makes it instant. -->

<main id="main" class="bdh wk">
<?php include 'partials/page-hero.php'; ?>
<?php
foreach ($WK_SECTIONS as $wk_id):
    $wk_file = __DIR__ . '/partials/work/' . $wk_id . '.php'; ?>
<!-- ===== work · <?= e($wk_id) ?> ===== -->
<?php if (is_file($wk_file)) { include $wk_file; } else { echo "<!-- missing work section: " . e($wk_id) . " -->\n"; } ?>
<?php endforeach; ?>
<?php include 'partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'CollectionPage',
    'name'            => 'Work',
    'description'     => $page['desc'],
    'isPartOf'        => ['@type' => 'WebSite', 'name' => $SITE['company']['name']],
    'about'           => array_values(array_map(fn (array $wk_r): array => ['@type' => 'Service', 'name' => $wk_r['name']], $WK['disc'])),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include 'partials/footer.php'; ?>
