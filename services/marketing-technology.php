<?php
/**
 * Marketing Technology — the discipline hub. "The always-on engine".
 *
 * The seven capabilities shown as the machinery that keeps marketing running between campaigns: signals in,
 * consent checked, a decision made, guardrails applied, a person approving what is sensitive, a message out,
 * and every step logged and measured against a holdout. Each section is its own partial in
 * partials/marketing-technology/<id>.php, with assets/css/marketing-technology/<id>.css and
 * assets/js/marketing-technology/<id>.js loaded automatically once they hold anything.
 *
 * Base layers: assets/css/brand/hub.css (.bdh-* primitives, window.BDH), assets/css/tech/kit.css (.xt-*),
 * then assets/css/marketing-technology.css — the discipline's own visual language, which the seven
 * capability pages should reuse with their own content:
 *   .mth-mod     card system    module card: header strip (index · icon · status), photo, title, body, footer
 *                               (variants --wide for a full-width feature card, --flat without photo)
 *   .mth-flow    diagram idiom  a chain of .mth-node boxes whose connectors start and stop at the box edges
 *                               (gap-drawn, never centre-to-centre); horizontal ≥861px, vertical below
 *   .mth-viz     data-viz idiom framed chart: head (title · legend · ILLUSTRATIVE), inline SVG with
 *                               .mth-viz__a (solid blue) / .mth-viz__b (dashed ghost) / .mth-viz__gap (lift area), axis row
 *   .mth-steps   stepper        numbered rail of tab buttons over .mth-steps__pane panels; every pane is shown
 *                               until assets/js/marketing-technology/process.js adds .is-tabs (finished state without JS)
 *   .mth-chip    status chips   mono chips: --ok (passed/sent) --hold (queued/held) --stop (suppressed/exited) --wait (approval)
 *   .mth-ledger  log idiom      mono audit-log rows: time · subject · step · detail · state
 *
 * Variables for every partial (never reassign): $SITE, $DISC (this discipline's row in $SITE['disciplines']),
 * $CAPS (data/marketing-technology.php), $STACK (data/tech-stack.php), $page.
 * nav/cta/footer use $c $d $i $k $item $url $current $disc $col $l $s, so partials prefix locals with mth_.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';

$CAPS  = require __DIR__ . '/../data/marketing-technology.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $mth_row) { if ($mth_row['slug'] === 'marketing-technology') $DISC = $mth_row; }
unset($mth_row);

/* Running order: the claim → why now → the engine running → the seven parts → how they fit → the stack →
   AI with limits → the rules it keeps → how it is measured → how we get there → what you own → buy → ask. */
$MTH_SECTIONS = [
    'hero', 'shift', 'engine', 'capabilities', 'architecture', 'stack', 'ai-native',
    'standards', 'measures', 'process', 'deliverables', 'services', 'faq',
];

$mth_root = __DIR__ . '/../';
$mth_has  = fn (string $p): ?string => (is_file($mth_root . $p) && filesize($mth_root . $p) > 0) ? $p : null;
$mth_css  = array_filter([$mth_has('assets/css/brand/hub.css'), $mth_has('assets/css/tech/kit.css'), $mth_has('assets/css/marketing-technology.css')]);
$mth_js   = array_filter([$mth_has('assets/js/brand/hub.js')]);
foreach ($MTH_SECTIONS as $mth_id) {
    if ($mth_x = $mth_has("assets/css/marketing-technology/$mth_id.css")) $mth_css[] = $mth_x;
    if ($mth_x = $mth_has("assets/js/marketing-technology/$mth_id.js"))   $mth_js[]  = $mth_x;
}
/* the shared services catalogue last, so nothing on this page can win over .svc-* */
if ($mth_x = $mth_has('assets/css/services.css')) $mth_css[] = $mth_x;
if ($mth_x = $mth_has('assets/js/services.js'))   $mth_js[]  = $mth_x;

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
<main id="main" class="bdh mth">
<?php
/* Rendered into a buffer so each brand mark or icon drawn more than once is inlined once as a <symbol> and
   reused with <use> (the stack and the services catalogue repeat the same logos many times). Same approach as
   services/technology-intelligence.php; drawings with url(#…) references or <animate> are left alone. */
ob_start();
foreach ($MTH_SECTIONS as $mth_id) include __DIR__ . "/../partials/marketing-technology/$mth_id.php";
include __DIR__ . '/../partials/cta.php';
$mth_body = (string) ob_get_clean();
$mth_re   = '~<svg\b([^>]*\bviewBox="([^"]+)"[^>]*)>((?:(?!</?svg\b).)*)</svg>~s';
$mth_ok   = fn (string $mth_d): bool => strlen($mth_d) >= 120 && strpos($mth_d, 'url(#') === false && strpos($mth_d, '<animate') === false;
$mth_seen = [];
if (preg_match_all($mth_re, $mth_body, $mth_all, PREG_SET_ORDER)) {
    foreach ($mth_all as $mth_m) if ($mth_ok($mth_m[3])) { $mth_h = md5($mth_m[2] . '|' . $mth_m[3]); $mth_seen[$mth_h] = ($mth_seen[$mth_h] ?? 0) + 1; }
}
$mth_syms = [];
$mth_body = preg_replace_callback($mth_re, function (array $mth_m) use (&$mth_syms, $mth_seen, $mth_ok): string {
    $mth_h = md5($mth_m[2] . '|' . $mth_m[3]);
    if (!$mth_ok($mth_m[3]) || ($mth_seen[$mth_h] ?? 0) < 2) return $mth_m[0];
    if (!isset($mth_syms[$mth_h])) $mth_syms[$mth_h] = ['mth-s' . count($mth_syms), $mth_m[2], $mth_m[3]];
    return '<svg' . $mth_m[1] . '><use href="#' . $mth_syms[$mth_h][0] . '"/></svg>';
}, $mth_body);
if ($mth_syms) {
    echo '<svg class="mth-sprite" aria-hidden="true" focusable="false" width="0" height="0" style="position:absolute"><defs>';
    foreach ($mth_syms as $mth_sy) echo '<symbol id="' . $mth_sy[0] . '" viewBox="' . $mth_sy[1] . '">' . $mth_sy[2] . '</symbol>';
    echo "</defs></svg>\n";
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
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
