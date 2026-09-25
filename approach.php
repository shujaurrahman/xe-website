<?php
/* Approach — the operating model as a working system, at the depth of the Technology & Intelligence hub.
   Sixteen sections in four chapters:
     01 The principle      hero · principle · board
     02 How a project runs  delivery (the stage stepper, the spine of the page) · agents · rhythm
     03 How quality holds   quality · recovery · governance
     04 What we agree       scope · contracts · handover
     05 How we work         global · boundaries · responsible · faq
   Sections: partials/approach/<id>.php, styles assets/css/approach.css + assets/css/approach/<id>.css,
   behaviour assets/js/approach/<id>.js — each loaded only when the file exists and is non-empty.
   Partial locals carry the apr_ / <id>_ prefix; nav, cta and footer loop with $c $d $i $k $item $url
   $current $disc $col $l $s, so no partial may use those at top level. */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
require_once __DIR__ . '/partials/services/lib.php';
$apr_pk = require __DIR__ . '/data/services/packages.php';

/* Bands: P A I · P A P · A I P · A P A · P A I P, then the shared ink CTA. */
$SECTIONS = [
    'hero', 'principle', 'board',
    'delivery', 'agents', 'rhythm',
    'quality', 'recovery', 'governance',
    'scope', 'contracts', 'handover',
    'global', 'boundaries', 'responsible', 'faq',
];

$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/approach.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/approach/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/approach/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'approach', 'title' => 'Approach — how a project actually runs',
         'desc' => 'Six stages with a named approval at each gate, the agents that do the legwork, the rhythm of a week, how quality is enforced and what happens when it fails, how scope and change work, and how everything transfers to you at the end.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<!-- Every section ships its finished state. Reveals wait on an .is-in class that only JavaScript adds, and
     the two stepped components (the stage stepper, the agent register) start as complete readable lists and
     are folded into single-pane form by their own script at init. Nothing here is blank without JavaScript. -->
<main id="main" class="bdh apr">
<?php foreach ($SECTIONS as $pp_id): ?>
<!-- ===== approach · <?= e($pp_id) ?> ===== -->
<?php include __DIR__ . "/partials/approach/$pp_id.php"; endforeach; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Approach — Xterra Edze',
    'description' => $page['desc'], 'url' => xe_url('approach.php'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
