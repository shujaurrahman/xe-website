<?php
/**
 * Search & AI Visibility — capability 08 of Technology & Intelligence.
 * Concept: "Search, Answered" — ranking and being cited are one system. The page opens with a
 * single buyer query answered two ways (a ranked results page and an AI answer with citations),
 * then follows how crawlers read a site, how entities connect, how content earns citations, and
 * how share of answer is measured across Google, ChatGPT, Perplexity and AI Overviews.
 *
 * A shell: each section is partials/tech/search-ai-visibility/<id>.php with optional
 * assets/css/tech/search-ai-visibility/<id>.css and assets/js/tech/search-ai-visibility/<id>.js,
 * loaded only when non-empty. Base: assets/css/brand/hub.css (layout primitives),
 * assets/css/tech/kit.css (logos, icons, badges, onward aid),
 * assets/css/tech/search-ai-visibility.css (page tokens + primitives),
 * assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (discipline row), $TI (all ten capabilities), $CAP (this one),
 * $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php), plus tsv_src().
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local
 * here is tsv_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['search-ai-visibility'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tsv_disc) { if ($tsv_disc['slug'] === 'technology-intelligence') $TECH = $tsv_disc; }
unset($tsv_disc);
$CAP_ROW = null;
foreach (($TECH['caps'] ?? []) as $tsv_row) { if (($tsv_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tsv_row; }
unset($tsv_row);

/**
 * A source chip as the mock result pages render it: favicon square, host, and an optional
 * "you" flag when the source is the placeholder company. Used in the hero and in the lens drawer.
 */
if (!function_exists('tsv_src')) {
    function tsv_src(string $host, array $o = []): string {
        $you  = !empty($o['you']);
        $n    = isset($o['n']) ? (string) $o['n'] : '';
        return '<span class="tsv-src' . ($you ? ' is-you' : '') . (!empty($o['class']) ? ' ' . e($o['class']) : '') . '">'
             . ($n !== '' ? '<i class="tsv-src__n" aria-hidden="true">' . e($n) . '</i>' : '')
             . '<i class="tsv-src__f" aria-hidden="true"></i>'
             . '<span class="tsv-src__h">' . e($host) . '</span></span>';
    }
}

/* Running order. Bands: paper · ink · paper · alt · paper · alt · ink · paper · alt · paper · alt ·
   paper · alt (services, the shared catalogue) · paper (faq), then the shared onward aid. */
$TSV = [
    'hero', 'shift', 'lens', 'technical', 'entities', 'content', 'authority',
    'stack', 'measure', 'guardrails', 'process', 'deliver', 'services', 'faq',
];

$tsv_root = __DIR__ . '/../../';
$tsv_has  = function (string $path) use ($tsv_root): bool {
    $f = $tsv_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tsv_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/search-ai-visibility.css'];
$tsv_js  = ['assets/js/brand/hub.js'];
foreach ($TSV as $tsv_id) {
    if ($tsv_has('assets/css/tech/search-ai-visibility/' . $tsv_id . '.css')) $tsv_css[] = 'assets/css/tech/search-ai-visibility/' . $tsv_id . '.css';
    if ($tsv_has('assets/js/tech/search-ai-visibility/' . $tsv_id . '.js'))   $tsv_js[]  = 'assets/js/tech/search-ai-visibility/' . $tsv_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$tsv_css[] = 'assets/css/services.css';
$tsv_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($tsv_css, $tsv_has)),
    'js'    => array_values(array_filter($tsv_js, $tsv_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tsv">
<?php foreach ($TSV as $tsv_id):
    $tsv_file = __DIR__ . '/../../partials/tech/search-ai-visibility/' . $tsv_id . '.php'; ?>
<!-- ===== search & ai visibility · <?= e($tsv_id) ?> ===== -->
<?php if (is_file($tsv_file)) { include $tsv_file; } else { echo '<!-- missing section: ' . e($tsv_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== search & ai visibility · onward ===== -->
<?php include __DIR__ . '/../../partials/tech/next.php'; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => $CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name'] ?? 'Technology & Intelligence'],
    'serviceType' => array_map(fn ($tsv_o) => $tsv_o[0], $CAP['offer']),
    'areaServed'  => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
