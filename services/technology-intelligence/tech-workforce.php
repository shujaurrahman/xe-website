<?php
/**
 * Tech Workforce — capability 10 of Technology & Intelligence.
 * Concept: "Squad Assembly" — vetted engineers, AI specialists and full squads embedded in your
 * team with no hiring cycle. Roles snap into a squad, time zones overlap, vetting filters,
 * onboarding runs to a first merged pull request, and sprint reporting keeps it accountable.
 *
 * A shell: each section is partials/tech/tech-workforce/<id>.php with optional
 * assets/css/tech/tech-workforce/<id>.css and assets/js/tech/tech-workforce/<id>.js, loaded when
 * non-empty. Base: assets/css/brand/hub.css (layout utilities), assets/css/tech/kit.css (logos,
 * icons, badges, onward aid), assets/css/tech/tech-workforce.css (page tokens + primitives),
 * assets/js/brand/hub.js (window.BDH helpers).
 *
 * Section partials see $SITE, $TECH (discipline row), $TI (all ten capabilities), $CAP (this one),
 * $CAP_ROW (this capability's row in $TECH['caps']) and $STACK (data/tech-stack.php).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local
 * here is ttw_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['tech-workforce'];
$STACK = require __DIR__ . '/../../data/tech-stack.php';
$TECH  = null;
foreach ($SITE['disciplines'] as $ttw_disc) { if ($ttw_disc['slug'] === 'technology-intelligence') $TECH = $ttw_disc; }
unset($ttw_disc);
$CAP_ROW = null;
foreach (($TECH['caps'] ?? []) as $ttw_row) { if (($ttw_row[0] ?? '') === $CAP['name']) $CAP_ROW = $ttw_row; }
unset($ttw_row);

/* Running order. Bands: paper · alt · ink · paper · alt · paper · ink · alt · paper · ink · alt ·
   paper · alt (services, the shared catalogue) · alt (faq), then the onward aid. */
$TTW = [
    'hero', 'models', 'composer', 'vetting', 'skills', 'onboarding', 'ai-native',
    'overlap', 'security', 'governance', 'deliver', 'outcomes', 'services', 'faq',
];

$ttw_root = __DIR__ . '/../../';
$ttw_has  = function (string $path) use ($ttw_root): bool {
    $f = $ttw_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$ttw_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/tech-workforce.css'];
/* arm.js arms every [data-ttw-arm] root once, and only when motion is allowed: it is the single
   thing that lets a section's CSS hide anything. Without it — no JS, or reduced motion — the
   shipped HTML stands as the finished state. It loads before the section scripts. */
$ttw_js  = ['assets/js/brand/hub.js', 'assets/js/tech/tech-workforce/arm.js'];
foreach ($TTW as $ttw_id) {
    if ($ttw_has('assets/css/tech/tech-workforce/' . $ttw_id . '.css')) $ttw_css[] = 'assets/css/tech/tech-workforce/' . $ttw_id . '.css';
    if ($ttw_has('assets/js/tech/tech-workforce/' . $ttw_id . '.js'))   $ttw_js[]  = 'assets/js/tech/tech-workforce/' . $ttw_id . '.js';
}
/* The shared Services & packages catalogue (partials/services/catalogue.php), after the page's own files. */
$ttw_css[] = 'assets/css/services.css';
$ttw_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . ($TECH['name'] ?? 'Technology & Intelligence'),
    'desc'  => $CAP['lead'],
    'css'   => array_values(array_filter($ttw_css, $ttw_has)),
    'js'    => array_values(array_filter($ttw_js, $ttw_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh ttw">
<?php foreach ($TTW as $ttw_id):
    $ttw_file = __DIR__ . '/../../partials/tech/tech-workforce/' . $ttw_id . '.php'; ?>
<!-- ===== tech workforce · <?= e($ttw_id) ?> ===== -->
<?php if (is_file($ttw_file)) { include $ttw_file; } else { echo '<!-- missing section: ' . e($ttw_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== tech workforce · onward ===== -->
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
    'serviceType' => array_map(fn ($ttw_o) => $ttw_o[0], $CAP['offer']),
    'areaServed'  => 'Worldwide',
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
