<?php
/**
 * AI Strategy & Agents — capability 03 of Technology & Intelligence.
 * Concept: "The Mission Board" — strategy that ends in agents doing real work. A portfolio of use
 * cases is ranked, the first become missions, and agents work them under explicit autonomy levels,
 * budgets and human approval, with every step traced.
 *
 * A shell: each section is partials/tech/ai-strategy-agents/<id>.php with optional
 * assets/css/tech/ai-strategy-agents/<id>.css and assets/js/tech/ai-strategy-agents/<id>.js, loaded
 * when non-empty. Base: assets/css/brand/hub.css (layout utilities), assets/css/tech/kit.css (logos,
 * icons, badges, onward aid), assets/css/tech/ai-strategy-agents.css (page tokens + primitives),
 * assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (discipline row), $TI (all ten capabilities), $CAP (this one),
 * $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php), plus tas_lvl().
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local
 * here is tas_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['ai-strategy-agents'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $tas_disc) { if ($tas_disc['slug'] === 'technology-intelligence') $TECH = $tas_disc; }
unset($tas_disc);
$CAP_ROW = null;
foreach (($TECH['caps'] ?? []) as $tas_row) { if (($tas_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tas_row; }
unset($tas_row);

/** Autonomy level tag: four rising pips and the level name. Used across the page. */
if (!function_exists('tas_lvl')) {
    function tas_lvl(int $l, array $o = []): string {
        $names = [1 => 'Suggest', 2 => 'Draft', 3 => 'Act with approval', 4 => 'Act within limits'];
        $short = !empty($o['short']);
        return '<span class="tas-lvl' . (!empty($o['class']) ? ' ' . e($o['class']) : '') . '" data-l="' . $l . '">'
             . '<span class="tas-lvl__p" aria-hidden="true"><i></i><i></i><i></i><i></i></span>'
             . '<span class="tas-lvl__n">L' . $l . ($short ? '' : ' · ' . e($names[$l] ?? '')) . '</span></span>';
    }
}

/* Running order. Bands: paper · alt · paper · ink · paper · alt · ink · paper · alt · paper · alt · paper · alt (services,
   the shared catalogue) · paper (faq), then the onward aid. */
$TAS = [
    'hero', 'reality', 'portfolio', 'autonomy', 'anatomy', 'evals', 'governance',
    'pace', 'workshop', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tas_root = __DIR__ . '/../../';
$tas_has  = function (string $path) use ($tas_root): bool {
    $f = $tas_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tas_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/ai-strategy-agents.css'];
$tas_js  = ['assets/js/brand/hub.js'];
foreach ($TAS as $tas_id) {
    if ($tas_has('assets/css/tech/ai-strategy-agents/' . $tas_id . '.css')) $tas_css[] = 'assets/css/tech/ai-strategy-agents/' . $tas_id . '.css';
    if ($tas_has('assets/js/tech/ai-strategy-agents/' . $tas_id . '.js'))   $tas_js[]  = 'assets/js/tech/ai-strategy-agents/' . $tas_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$tas_css[] = 'assets/css/services.css';
$tas_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($tas_css, $tas_has)),
    'js'    => array_values(array_filter($tas_js, $tas_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tas">
<?php foreach ($TAS as $tas_id):
    $tas_file = __DIR__ . '/../../partials/tech/ai-strategy-agents/' . $tas_id . '.php'; ?>
<!-- ===== ai strategy & agents · <?= e($tas_id) ?> ===== -->
<?php if (is_file($tas_file)) { include $tas_file; } else { echo '<!-- missing section: ' . e($tas_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== ai strategy & agents · onward ===== -->
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
    'serviceType' => array_map(fn ($tas_o) => $tas_o[0], $CAP['offer']),
    'areaServed'  => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
