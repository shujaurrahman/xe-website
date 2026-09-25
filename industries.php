<?php
/**
 * Industries — "the rules of the room".
 *
 * Six operating environments, not six audiences. Every section reads the same six sectors through a
 * different instrument: the constraint map (hero), the sector at a glance (explorer), the forces
 * (pressure), the dossiers (sectors), the Sector Console (console — the signature), one capability
 * seen six ways (lens), the sector × discipline matrix (matrix), the platforms each actually runs on
 * (systems), what applies and what does not (rulebook), the same sector in three markets (markets),
 * AI shown concretely (ai-native), what transfers (transfer), how it is measured (measures), the
 * baseline that never moves (cross), and the questions (faq).
 *
 * Shell only: every section is partials/industries/<id>.php, with assets/css/industries/<id>.css and
 * assets/js/industries/<id>.js loaded automatically once they hold anything, over the page-level
 * assets/css/industries.css.
 *
 * Variables available to every section partial (never reassign):
 *   $SITE      data/site.php                 $IND       data/industries.php (the six sectors, in order)
 *   $ind_disc  discipline slug => row        $STACK     data/tech-stack.php
 *   $BASE      path back to the site root    $page      page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so every local in this page's partials carries the ind_ prefix.
 */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
require_once __DIR__ . '/partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the sector

$IND   = require __DIR__ . '/data/industries.php';
$STACK = require __DIR__ . '/data/tech-stack.php';
$ind_disc = [];
foreach ($SITE['disciplines'] as $ind_d) $ind_disc[$ind_d['slug']] = $ind_d;
unset($ind_d);

/* Running order: what the map says → the six at a glance → why now → the six in depth → build one →
   how the work differs → what it runs on → what applies → where it applies → AI, concretely →
   what travels → what is measured → the baseline → the questions.
   Bands: P A P A P A P A P A I P A I P, then the shared ink CTA. */
$IND_SECTIONS = [
    'hero', 'explorer', 'pressure', 'sectors', 'console', 'lens', 'matrix', 'systems',
    'rulebook', 'markets', 'ai-native', 'transfer', 'measures', 'cross', 'faq',
];

$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/industries.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($IND_SECTIONS as $pp_id) {
    if ($pp_x = $pp_has("assets/css/industries/$pp_id.css")) $pp_css[] = $pp_x;
    if ($pp_x = $pp_has("assets/js/industries/$pp_id.js"))   $pp_js[]  = $pp_x;
}

$page = ['key' => 'industries', 'title' => 'Industries',
         'desc' => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media — the pressure each category is under, the systems it runs on, the rules that genuinely apply, and the programmes we build in each.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Entrance motion is an enhancement: every starting class is
     added by JavaScript at init, so with JavaScript off each section renders complete and readable. -->

<main id="main" class="bdh ind">
<?php
/* The page is rendered into a buffer so every repeated drawing is inlined once. xt_logo() and
   xt_badge() emit a complete <svg> at each instance, and this page shows the same marks across the
   systems wall, the rulebook, the console and the dossiers. Each distinct drawing is lifted into one
   <symbol> and every instance becomes a <use> of it: same rendering, a fraction of the bytes and DOM
   nodes. Same technique as services/technology-intelligence.php, whose comment explains why the
   proper home for it would be the shared kit. */
ob_start();
foreach ($IND_SECTIONS as $pp_id):
    $pp_file = __DIR__ . '/partials/industries/' . $pp_id . '.php'; ?>
<!-- ===== industries · <?= e($pp_id) ?> ===== -->
<?php if (is_file($pp_file)) { include $pp_file; } else { echo '<!-- missing section: ' . e($pp_id) . " -->\n"; } ?>
<?php endforeach;
include __DIR__ . '/partials/cta.php';
$pp_body = (string) ob_get_clean();
$pp_re   = '~<svg\b([^>]*\bviewBox="([^"]+)"[^>]*)>((?:(?!</?svg\b).)*)</svg>~s';
/* only drawings that repeat, and only plain ones: nothing with an internal url(#…) reference or an
   <animate>, which would not survive being moved into a <symbol>'s shadow tree */
$pp_reuse = fn (string $pp_d): bool => strlen($pp_d) >= 120 && strpos($pp_d, 'url(#') === false && strpos($pp_d, '<animate') === false;
$pp_seen = [];
if (preg_match_all($pp_re, $pp_body, $pp_all, PREG_SET_ORDER)) {
    foreach ($pp_all as $pp_m) {
        if (!$pp_reuse($pp_m[3])) continue;
        $pp_k = md5($pp_m[2] . '|' . $pp_m[3]);
        $pp_seen[$pp_k] = ($pp_seen[$pp_k] ?? 0) + 1;
    }
}
$pp_syms = [];
$pp_body = preg_replace_callback($pp_re, function (array $pp_m) use (&$pp_syms, $pp_seen, $pp_reuse): string {
    $pp_k = md5($pp_m[2] . '|' . $pp_m[3]);
    if (!$pp_reuse($pp_m[3]) || ($pp_seen[$pp_k] ?? 0) < 2) return $pp_m[0];
    if (!isset($pp_syms[$pp_k])) {
        $pp_syms[$pp_k] = '<symbol id="ind-s' . count($pp_syms) . '" viewBox="' . $pp_m[2] . '">' . $pp_m[3] . '</symbol>';
    }
    preg_match('~ id="(ind-s\d+)"~', $pp_syms[$pp_k], $pp_sid);
    return '<svg' . $pp_m[1] . '><use href="#' . $pp_sid[1] . '"/></svg>';
}, $pp_body);
if ($pp_syms) {
    echo '<svg class="ind-sprite" aria-hidden="true" focusable="false" width="0" height="0"><defs>'
       . implode('', $pp_syms) . '</defs></svg>' . "\n";
}
echo $pp_body;
?>
</main>

<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'CollectionPage',
    'name' => 'Industries — ' . $SITE['company']['name'],
    'description' => $page['desc'],
    'hasPart' => array_map(fn ($pp_s) => [
        '@type' => 'WebPageElement', 'name' => $pp_s['name'], 'description' => $pp_s['line'], 'url' => '#' . $pp_s['id'],
    ], $IND),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
