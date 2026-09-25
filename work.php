<?php
/* Work — an anonymised programme ledger: hero index, one featured case with a code-built rollout board,
   a filterable index (GET ?d=<discipline>&i=<industry>, live with JS), and why we don't show logos.
   Sections: partials/work/<id>.php (+ assets/js/work/<id>.js); styles in assets/css/work.css. */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
$WRK = require __DIR__ . '/data/work.php';
$wrk_disc = [];
foreach ($SITE['disciplines'] as $wrk_x) $wrk_disc[$wrk_x['slug']] = $wrk_x;
$wrk_q = fn (string $k, array $ok): string => (is_string($_GET[$k] ?? null) && isset($ok[$_GET[$k]])) ? $_GET[$k] : '';
$wrk_fd = $wrk_q('d', $wrk_disc);
$wrk_fi = $wrk_q('i', $WRK['industries']);
$wrk_match = fn (array $c, string $d, string $i): bool
    => ($d === '' || in_array($d, array_column($c['did'], 0), true)) && ($i === '' || $c['industry'] === $i);
$SECTIONS = ['hero', 'featured', 'index', 'nda'];
$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/work.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/work/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/work/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'work', 'title' => 'Work',
         'desc' => 'Anonymised programmes across brand, product, content, AI and technology — the brief, the system we built, what we delivered and how it is measured.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<main id="main" class="bdh wrk">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/partials/work/$pp_id.php"; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'CollectionPage', 'name' => 'Work — ' . $SITE['company']['name'],
    'description' => $page['desc'],
    'hasPart' => array_map(fn ($c) => ['@type' => 'CreativeWork', 'name' => $c['title'], 'url' => '#' . $c['id']], $WRK['cases']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
