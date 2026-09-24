<?php
/* What we do — six disciplines read as one operating system: a ledger of hubs, a capability finder that works as a plain GET form, and the relay that shows how work moves between them. Sections: partials/services-index/<id>.php · styles: assets/css/services-index.css · finder: assets/js/services-index/finder.js. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url() for the finder's Enquire links

/* ---- every capability, tagged by the need it answers (used by hero, finder and system) ---- */
$SVX_NEEDS = [
    'stand-out' => ['Stand out',        '~brand|identity|positioning|foundation|architecture|creative|design system|visual~i'],
    'build'     => ['Build a product',  '~app|software|platform|product|experience|system design|website|development|solutioning~i'],
    'ai'        => ['Put AI to work',   '~\bAI\b|agent|automat|copilot|intelligen~'],
    'demand'    => ['Grow demand',      '~marketing|content|social|campaign|lead|sales|search|relations|influencer|growth|customer|omnichannel|performance~i'],
    'run'       => ['Secure and run',   '~secur|trust|infrastructure|cloud|support|integration|workforce|infrastructure|communication infrastructure~i'],
    'measure'   => ['Measure and fix',  '~audit|assess|optimi[sz]|data|analytic|strategy|consulting|vision~i'],
];
$svx_rows = [];
foreach ($SITE['disciplines'] as $svx_d) {
    foreach ($svx_d['caps'] as $svx_c) {
        $svx_hay = $svx_c[0] . ' ' . $svx_c[1];
        $svx_n = [];
        foreach ($SVX_NEEDS as $svx_k => $svx_nd) if (preg_match($svx_nd[1], $svx_hay)) $svx_n[] = $svx_k;
        if (!$svx_n) $svx_n[] = 'build';
        $svx_rows[] = ['d' => $svx_d, 'name' => $svx_c[0], 'desc' => $svx_c[1], 'slug' => (string) ($svx_c[2] ?? ''), 'url' => xe_cap_url($svx_d, $svx_c),
                       'own' => xe_cap_url($svx_d, $svx_c) !== xe_discipline_url($svx_d), 'needs' => $svx_n];
    }
}
$svx_total = count($svx_rows);

/* ---- the finder's state comes from the query, so filtering works without JavaScript ---- */
$svx_q    = is_string($_GET['q'] ?? null) ? mb_substr(trim($_GET['q']), 0, 60) : '';
$svx_fd   = is_string($_GET['d'] ?? null) ? $_GET['d'] : '';
$svx_fn   = is_string($_GET['need'] ?? null) ? $_GET['need'] : '';
if (!in_array($svx_fd, array_column($SITE['disciplines'], 'slug'), true)) $svx_fd = '';
if (!isset($SVX_NEEDS[$svx_fn])) $svx_fn = '';

$SECTIONS = ['hero', 'finder', 'system'];
$pp_root = __DIR__ . '/../';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/services-index.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/services-index/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/services-index/$pp_id.js"))   $pp_js[]  = $x;
}
$page = [
    'key'   => 'services',
    'title' => 'What we do',
    'desc'  => 'Six disciplines on one system — brand, technology, campaign, AI, product and marketing technology. Find the capability you need.',
    'css'   => array_values($pp_css),
    'js'    => array_values($pp_js),
];
include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>
<main id="main" class="bdh svx">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/../partials/services-index/$pp_id.php"; ?>
<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'ItemList', 'name' => 'What we do — Xterra Edze',
    'itemListElement' => array_map(fn ($svx_d) => ['@type' => 'ListItem', 'position' => (int) $svx_d['n'], 'name' => $svx_d['name']], $SITE['disciplines']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
