<?php
/**
 * Audits & Assessments — capability 09 of Technology & Intelligence.
 * Concept: "The Findings Register" — an audit is only useful if it says what is broken, what it
 * costs and what to fix first. Evidence-led findings run from the register hero through the
 * fix-order planner, the cost waterfall and the maturity scorecard to the report itself.
 *
 * A shell: each section is partials/tech/audits-assessments/<id>.php with optional
 * assets/css/tech/audits-assessments/<id>.css and assets/js/tech/audits-assessments/<id>.js, loaded
 * when non-empty. Base: assets/css/brand/hub.css (layout utilities), assets/css/tech/kit.css (logos,
 * icons, badges, onward aid), assets/css/tech/audits-assessments.css (page tokens + primitives),
 * assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (discipline row), $TI (all ten capabilities), $CAP (this one),
 * $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php), plus taa_sev().
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local
 * here is taa_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['audits-assessments'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $taa_disc) { if ($taa_disc['slug'] === 'technology-intelligence') $TECH = $taa_disc; }
unset($taa_disc);
$CAP_ROW = null;
foreach (($TECH['caps'] ?? []) as $taa_row) { if (($taa_row[0] ?? '') === $CAP['name']) $CAP_ROW = $taa_row; }
unset($taa_row);

/** Severity tag: four rising pips and the severity name. Used across the register sections. */
if (!function_exists('taa_sev')) {
    function taa_sev(string $s, array $o = []): string {
        $pips  = ['critical' => 4, 'high' => 3, 'medium' => 2, 'low' => 1];
        $names = ['critical' => 'Critical', 'high' => 'High', 'medium' => 'Medium', 'low' => 'Low'];
        $abbr  = ['critical' => 'Crit', 'high' => 'High', 'medium' => 'Med', 'low' => 'Low'];
        $key   = strtolower($s);
        $p     = $pips[$key] ?? 1;
        $n     = !empty($o['short']) ? ($abbr[$key] ?? $s) : ($names[$key] ?? $s);
        return '<span class="taa-sev' . (!empty($o['class']) ? ' ' . e($o['class']) : '') . '"'
             . ' data-s="' . e($key) . '" data-p="' . $p . '">'
             . '<span class="taa-sev__p" aria-hidden="true"><i></i><i></i><i></i><i></i></span>'
             . '<span class="taa-sev__n">' . e($n) . '</span></span>';
    }
}

/* Running order. Bands: paper · alt · ink · paper · alt · paper · ink · alt · paper · alt · paper ·
   alt · alt (services, the shared catalogue) · paper (faq), then the onward aid. */
$TAA = [
    'hero', 'types', 'fixplan', 'method', 'instruments', 'scorecard', 'cost',
    'readiness', 'sample', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$taa_root = __DIR__ . '/../../';
$taa_has  = function (string $path) use ($taa_root): bool {
    $f = $taa_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$taa_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/audits-assessments.css'];
$taa_js  = ['assets/js/brand/hub.js'];
foreach ($TAA as $taa_id) {
    if ($taa_has('assets/css/tech/audits-assessments/' . $taa_id . '.css')) $taa_css[] = 'assets/css/tech/audits-assessments/' . $taa_id . '.css';
    if ($taa_has('assets/js/tech/audits-assessments/' . $taa_id . '.js'))   $taa_js[]  = 'assets/js/tech/audits-assessments/' . $taa_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$taa_css[] = 'assets/css/services.css';
$taa_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($taa_css, $taa_has)),
    'js'    => array_values(array_filter($taa_js, $taa_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh taa">
<?php foreach ($TAA as $taa_id):
    $taa_file = __DIR__ . '/../../partials/tech/audits-assessments/' . $taa_id . '.php'; ?>
<!-- ===== audits & assessments · <?= e($taa_id) ?> ===== -->
<?php if (is_file($taa_file)) { include $taa_file; } else { echo '<!-- missing section: ' . e($taa_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== audits & assessments · onward ===== -->
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
    'serviceType' => array_map(fn ($taa_o) => $taa_o[0], $CAP['offer']),
    'areaServed'  => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
