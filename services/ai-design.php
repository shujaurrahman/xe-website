<?php
/**
 * AI Design — the discipline hub. "Direction at the scale of a machine."
 *
 * The concept, deliberately not the Technology hub's control plane: this discipline is about the brand
 * experiences that only exist because the medium generates. So the spine of the page is one object — a
 * generation run. A brief goes in; direction, a routed model, an eval, a guardrail and a named approver
 * shape it; what comes out is on brand, rights-clear, disclosed and logged. Every section is a closer
 * look at one part of that run.
 *
 * The page is a shell: each section is its own partial in partials/ai-design/<id>.php, with
 * assets/css/ai-design/<id>.css and assets/js/ai-design/<id>.js loaded automatically once they hold
 * anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* logos, icons, badges), then
 * assets/css/ai-design.css (.aih-* primitives for this discipline — the capability subpages reuse them).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                 $DISC   the ai-design row of $SITE['disciplines']
 *   $CAPS   data/ai-design.php            $STACK  data/tech-stack.php (slug => name, category, file)
 *   $page   page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (aih_*, hero_*, run_* …) and never use those names.
 *
 * The four capability subpages do not exist yet, so every capability link on this page is an anchor on
 * this page (#<capability-slug>), set on the dossier cards in partials/ai-design/capabilities.php.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/services/lib.php';   // svc_contact_url(): enquiries arrive tagged with the page and service

$CAPS  = require __DIR__ . '/../data/ai-design.php';
$STACK = require __DIR__ . '/../data/tech-stack.php';
$DISC  = null;
foreach ($SITE['disciplines'] as $aih_disc) { if ($aih_disc['slug'] === 'ai-design') $DISC = $aih_disc; }
unset($aih_disc);

/* Running order: the claim → what changed → what we do → the run itself → the mechanism inside it
   (route, evals, control, provenance) → how we work → what we work to → what lands → what moves → the
   lines between disciplines → buy → ask.
   Bands: hero P, then A P I P A P I P A P A I P A(catalogue) P.
   'services' is the shared Services & packages catalogue (partials/services/catalogue.php, data key
   'ai-design'). Its packages row is this page's one set of engagement models, so there is no separate
   engagement section — the same call the Brand Design and Technology hubs made. */
$AIH_SECTIONS = [
    'hero', 'premise', 'capabilities', 'run', 'routing', 'evals', 'control', 'provenance',
    'process', 'stack', 'standards', 'deliverables', 'outcomes', 'lines', 'services', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$aih_root  = __DIR__ . '/../';
$aih_asset = function (string $path) use ($aih_root): ?string {
    $f = $aih_root . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$aih_css = array_filter([
    $aih_asset('assets/css/brand/hub.css'),
    $aih_asset('assets/css/tech/kit.css'),
    $aih_asset('assets/css/ai-design.css'),
]);
$aih_js = array_filter([$aih_asset('assets/js/brand/hub.js')]);
foreach ($AIH_SECTIONS as $aih_id) {
    if ($aih_x = $aih_asset('assets/css/ai-design/' . $aih_id . '.css')) $aih_css[] = $aih_x;
    if ($aih_x = $aih_asset('assets/js/ai-design/' . $aih_id . '.js'))   $aih_js[]  = $aih_x;
}
/* the shared services & packages catalogue (.svc-*), after the page's own files, as on every other page */
if ($aih_x = $aih_asset('assets/css/services.css')) $aih_css[] = $aih_x;
if ($aih_x = $aih_asset('assets/js/services.js'))   $aih_js[]  = $aih_x;

$page = [
    'key'   => 'services',
    'title' => 'AI Design',
    'desc'  => $DISC['intro'],
    'css'   => array_values($aih_css),
    'js'    => array_values($aih_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state: every run resolved, every score at its value, every gate
     marked. Entrance and step-through motion is an enhancement — each section's script adds its own
     starting class at init, so with JavaScript off nothing is hidden and nothing is half-drawn. -->

<main id="main" class="bdh aih">
<?php foreach ($AIH_SECTIONS as $aih_id):
    $aih_file = __DIR__ . '/../partials/ai-design/' . $aih_id . '.php'; ?>
<!-- ===== ai-design hub · <?= e($aih_id) ?> ===== -->
<?php if (is_file($aih_file)) { include $aih_file; } else { echo "<!-- missing hub section: " . e($aih_id) . " -->\n"; } ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $DISC['name'],
    'description' => $DISC['intro'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'serviceType' => array_map(fn ($aih_c) => $aih_c[0], $DISC['caps']),
    'hasOfferCatalog' => [
        '@type'           => 'OfferCatalog',
        'name'            => $DISC['name'] . ' capabilities',
        'itemListElement' => array_values(array_map(fn ($aih_c) => [
            '@type'       => 'Offer',
            'itemOffered' => ['@type' => 'Service', 'name' => $aih_c['name'], 'description' => $aih_c['lead']],
        ], $CAPS)),
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
