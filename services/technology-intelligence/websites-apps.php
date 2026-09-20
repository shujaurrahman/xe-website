<?php
/**
 * Websites & Apps — capability 01 of Technology & Intelligence. Concept: "The Field Test".
 * The page is a performance lab that judges work by field data (real users, real phones, real networks, p75),
 * not by a lab score on a fast laptop: device clusters, a filmstrip speed simulator, the request path as the
 * stack, real-usage photography, CI quality gates, an AI-assisted release lane and the page-weight carbon lever.
 *
 * A shell: each section is partials/tech/websites-apps/<id>.php with optional assets/css/tech/websites-apps/<id>.css
 * and assets/js/tech/websites-apps/<id>.js, loaded only when present and non-empty. Base layers:
 * assets/css/brand/hub.css (layout + motion utilities), assets/css/tech/kit.css (logos, icons, badges, onward aid),
 * assets/css/tech/websites-apps.css (page tokens + field-test primitives), assets/js/brand/hub.js (window.BDH).
 *
 * Section partials see $SITE, $TECH (the discipline row in data/site.php), $TI (data/technology-intelligence.php),
 * $CAP (= $TI['websites-apps']), $CAP_ROW (this capability's [name, one-liner] row in $TECH['caps']),
 * $STACK (data/tech-stack.php) and $TWA_OFFER (the six things we build, also used for JSON-LD).
 * nav.php / cta.php / footer.php use $c $d $i $k $item $url $current $disc $col $l $s — every local here is twa_*.
 */
$BASE = '../../';
require __DIR__ . '/../../partials/init.php';
require_once __DIR__ . '/../../partials/tech/kit.php';

$TI    = require __DIR__ . '/../../data/technology-intelligence.php';
$CAP   = $TI['websites-apps'];
$STACK = xt_stack_data();
$TECH  = null;
foreach ($SITE['disciplines'] as $twa_disc) { if ($twa_disc['slug'] === 'technology-intelligence') $TECH = $twa_disc; }
unset($twa_disc);
$CAP_ROW = null;
foreach ($TECH['caps'] as $twa_row) { if (($twa_row[0] ?? '') === $CAP['name']) $CAP_ROW = $twa_row; }
unset($twa_row);

/* The six things we build: [title, description, tag line, icon, stack slugs, mock key]. DRAFT COPY */
$TWA_OFFER = [
    ['Marketing & corporate websites', 'Server-rendered or static sites on a headless CMS, with structured content, preview links for editors and edge caching that holds as pages multiply.', 'Next.js · Astro · headless CMS', 'browser', ['nextdotjs', 'astro', 'contentful', 'sanity'], 'cms'],
    ['Web applications & portals', 'Customer portals, dashboards and SaaS products with typed APIs, role-based access and state that survives unreliable networks.', 'React · Vue · TypeScript', 'code', ['react', 'vuedotjs', 'typescript', 'graphql'], 'portal'],
    ['Native & cross-platform mobile apps', 'Native iOS and Android, or one codebase with Flutter or React Native, chosen on evidence: device APIs, offline needs and team skills.', 'Flutter · React Native · Swift · Kotlin', 'mobile', ['flutter', 'reactnative', 'swift', 'kotlin'], 'mobile'],
    ['Commerce storefronts', 'Shopify or headless storefronts where search, product pages and checkout are tuned for the slowest phone in the market, not the fastest.', 'Shopify · headless · payments', 'target', ['shopify', 'stripe', 'algolia', 'nextdotjs'], 'shop'],
    ['Progressive web apps & offline-first', 'Installable web apps with service workers, background sync and a local queue, so field teams keep working when the signal drops.', 'Service workers · IndexedDB', 'sync', ['javascript', 'typescript', 'firebase', 'supabase'], 'pwa'],
    ['Design systems in code', 'Tokens and components shared by web and mobile, documented in Storybook and tested for accessibility on every change.', 'Storybook · tokens · Figma', 'layers', ['storybook', 'figma', 'tailwindcss', 'react'], 'ds'],
];

/* Running order — P A P I P A P I A P A P A P, then the shared onward aid and the CTA. */
$TWA = [
    'hero', 'field', 'offer', 'simulator', 'render-path', 'surfaces', 'gates',
    'release', 'carbon', 'process', 'deliver', 'outcomes', 'services', 'faq',
];

$twa_root = __DIR__ . '/../../';
$twa_has  = function (string $path) use ($twa_root): bool {
    $f = $twa_root . $path;
    return is_file($f) && filesize($f) > 0;
};
$twa_css = ['assets/css/brand/hub.css', 'assets/css/tech/kit.css', 'assets/css/tech/websites-apps.css'];
$twa_js  = ['assets/js/brand/hub.js'];
foreach ($TWA as $twa_id) {
    $twa_css[] = 'assets/css/tech/websites-apps/' . $twa_id . '.css';
    $twa_js[]  = 'assets/js/tech/websites-apps/' . $twa_id . '.js';
}
unset($twa_id);
/* the shared catalogue loads last, after the page's own files, so page CSS can never quietly win over .svc-* */
$twa_css[] = 'assets/css/services.css';
$twa_js[]  = 'assets/js/services.js';

$page = [
    'key'   => 'services',
    'title' => $CAP['name'] . ' · ' . $TECH['name'],
    'desc'  => $CAP_ROW[1] ?? $CAP['lead'],
    'css'   => array_values(array_filter($twa_css, $twa_has)),
    'js'    => array_values(array_filter($twa_js, $twa_has)),
];

include __DIR__ . '/../../partials/head.php';
include __DIR__ . '/../../partials/nav.php';
?>

<main id="main" class="bdh twa">
<?php foreach ($TWA as $twa_id):
    $twa_file = __DIR__ . '/../../partials/tech/websites-apps/' . $twa_id . '.php'; ?>
<!-- ===== websites & apps · <?= e($twa_id) ?> ===== -->
<?php if (is_file($twa_file)) { include $twa_file; } else { echo '<!-- missing section: ' . e($twa_id) . " -->\n"; } ?>
<?php endforeach; ?>

<!-- ===== websites & apps · onward (shared) ===== -->
<?php include __DIR__ . '/../../partials/tech/next.php'; ?>

<?php include __DIR__ . '/../../partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $CAP['name'],
    'description' => $CAP_ROW[1] ?? $CAP['lead'],
    'provider'    => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    'isRelatedTo' => ['@type' => 'Service', 'name' => $TECH['name']],
    'serviceType' => array_map(fn ($twa_o) => $twa_o[0], $TWA_OFFER),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/../../partials/footer.php'; ?>
