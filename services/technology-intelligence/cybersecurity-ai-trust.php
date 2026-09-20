<?php
/**
 * Cybersecurity & AI Trust — capability 06 of Technology & Intelligence.
 * Concept: "The Threat Model". Every asset (product, data, models, agents) sits inside layers of
 * controls that are attacked in tests, watched by detection and proven with evidence for auditors.
 * The page scans, attacks, blocks and logs.
 *
 * A shell: each section is partials/tech/cybersecurity-ai-trust/<id>.php with its own
 * assets/css/tech/cybersecurity-ai-trust/<id>.css and assets/js/tech/cybersecurity-ai-trust/<id>.js
 * (loaded only when the file exists and is not empty). Base layers: assets/css/brand/hub.css (.bdh-*
 * utilities), assets/css/tech/kit.css (.xt-* logos, icons, badges, onward aid),
 * assets/css/tech/cybersecurity-ai-trust.css (page tokens and .tsc-* primitives), assets/js/brand/hub.js (window.BDH).
 *
 * Section partials see $SITE, $TECH (the discipline row), $TI (data/technology-intelligence.php),
 * $CAP (= $TI['cybersecurity-ai-trust']), $CAP_ROW (this capability's row in $TECH['caps']) and $STACK.
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is tsc_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

if (!function_exists('tsc_tool')) {
    /**
     * One technology mark for this page. A library slug renders the kit logo (xt_logo); anything the
     * library does not carry (Splunk, Wazuh, PyRIT…) is passed as its exact product name and renders the
     * kit's mono wordmark chip, never a drawn or fetched mark. Presented as technologies we work with.
     * 'hidden' hides a drawn logo from assistive tech, because the name is printed beside it. A wordmark
     * IS the name, so it is never hidden: callers hide their own duplicated label in CSS instead.
     */
    function tsc_tool(string $key, array $o = []): string {
        if (xt_tech($key)) return xt_logo($key, $o);
        $size = !empty($o['size']) ? ' style="--xt-word:' . max(10, (int) round($o['size'] * 0.5)) . 'px"' : '';
        return '<span class="xt-logo xt-logo--word"' . $size . '>' . e($key) . '</span>';
    }
    function tsc_tool_name(string $key): string {
        return xt_tech($key)['name'] ?? $key;
    }
}

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$CAP   = $TI['cybersecurity-ai-trust'];

$TECH = null;
foreach ($SITE['disciplines'] as $tsc_disc) { if ($tsc_disc['slug'] === 'technology-intelligence') $TECH = $tsc_disc; }
unset($tsc_disc);
$CAP_ROW = null;
foreach ($TECH['caps'] ?? [] as $tsc_row) { if (($tsc_row[0] ?? '') === $CAP['name']) $CAP_ROW = $tsc_row; }
unset($tsc_row);

/* Running order: see the surface → the layers → attack it → the AI risks → detect and report →
   prove it → the tools → privacy → the programme → what you keep → the measures → what you can buy →
   questions. Bands: P A P I A I P A P A P I A (the shared catalogue) P, then the onward aid. */
$TSC = [
    'hero', 'exposure', 'layers', 'range', 'owasp', 'soc', 'compliance',
    'stack', 'privacy', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$tsc_root = __DIR__ . '/../../';
$tsc_has  = function (string $path) use ($tsc_root): bool {
    $f = $tsc_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$tsc_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/cybersecurity-ai-trust.css'];
$tsc_js  = ['assets/js/brand/hub.js'];
foreach ($TSC as $tsc_id) {
    $tsc_css[] = 'assets/css/tech/cybersecurity-ai-trust/' . $tsc_id . '.css';
    $tsc_js[]  = 'assets/js/tech/cybersecurity-ai-trust/' . $tsc_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$tsc_css[] = 'assets/css/services.css';
$tsc_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($tsc_css, $tsc_has)),
    'js'    => array_values(array_filter($tsc_js, $tsc_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh tsc">
<?php foreach ($TSC as $tsc_id):
    $tsc_file = __DIR__ . '/../../partials/tech/cybersecurity-ai-trust/' . $tsc_id . '.php'; ?>
<!-- ===== cybersecurity & ai trust · <?= e($tsc_id) ?> ===== -->
<?php if (is_file($tsc_file)) { include $tsc_file; } else { echo '<!-- missing section: ' . e($tsc_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== cybersecurity & ai trust · onward ===== -->
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
    'serviceType' => array_map(fn ($tsc_o) => $tsc_o[0], $CAP['offer']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
