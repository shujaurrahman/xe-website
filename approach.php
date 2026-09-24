<?php
/* Approach — the operating model as a working system: principle, live operating board, gated delivery, quality bars, governance, contracts.
   Sections: partials/approach/<id>.php (+ assets/js/approach/<id>.js). Styles: assets/css/approach.css. */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
require_once __DIR__ . '/partials/services/lib.php';
$apr_pk = require __DIR__ . '/data/services/packages.php';
$SECTIONS = ['hero', 'principle', 'board', 'delivery', 'quality', 'governance', 'responsible', 'contracts'];
$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/approach.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/approach/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/approach/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'approach', 'title' => 'Approach — how the operation runs',
         'desc' => 'AI runs the operation, people run the strategy: agents, evals, guardrails, approval gates and audit logs, a gated delivery model, quality bars and six ways to engage.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<main id="main" class="bdh apr">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/partials/approach/$pp_id.php"; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Approach — Xterra Edze',
    'description' => $page['desc'], 'url' => xe_url('approach.php'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
