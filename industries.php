<?php
/* Industries — six sector dossiers read through the rules each category plays by: a regulation map (hero),
   a sector explorer (discipline mix), six collapsible sector dossiers, each with its own artefact, the cross-industry baseline.
   Sections: partials/industries/<id>.php (+ assets/js/industries/<id>.js); styles in assets/css/industries.css. */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
$IND = require __DIR__ . '/data/industries.php';
$ind_disc = [];
foreach ($SITE['disciplines'] as $ind_d) $ind_disc[$ind_d['slug']] = $ind_d;
$SECTIONS = ['hero', 'explorer', 'sectors', 'cross'];
$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/industries.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/industries/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/industries/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'industries', 'title' => 'Industries',
         'desc' => 'Consumer health, financial services, retail and commerce, B2B technology, hospitality, telecom and media — the shifts, the rules and the programmes we build in each.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<main id="main" class="bdh ind">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/partials/industries/$pp_id.php"; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => 'Industries — ' . $SITE['company']['name'],
    'description' => $page['desc'],
    'hasPart' => array_map(fn ($s) => ['@type' => 'WebPageElement', 'name' => $s['name'], 'url' => '#' . $s['id']], $IND),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
