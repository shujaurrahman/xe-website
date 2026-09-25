<?php
/**
 * Approach — how we work. "The operating model."
 *
 * The spine of the page is the six stages of a project, end to end. Every section is a different view
 * of the same engagement: the stages, the gates between them, who does what (agents and people), how
 * quality is enforced, how a week runs, how the work is bought, and how it is handed over.
 *
 * The page is a shell. Sections live in partials/approach/<id>.php with assets/css/approach/<id>.css
 * and assets/js/approach/<id>.js, loaded automatically once those files hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* icons and badges), then
 * assets/css/approach.css (.apr-* primitives for this page).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE   data/site.php                    $APR   partials/approach/_map.php — the six stages and
 *   $PACKS  data/services/packages.php              the five gates, shared by several sections
 *   $page   page meta                        $hero  hero copy
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (apr_*) and never use those names.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/tech/kit.php';

$APR   = require 'partials/approach/_map.php';
$PACKS = require 'data/services/packages.php';

/* Running order: the division of labour → the stages → the decisions between them → what the machine
   does → how it is assured → how quality is enforced → how a week runs → how it is bought → how it is
   handed over → what has not changed → ask.
   Bands: P A P I P A P A P I A, then the shared ink CTA. */
$APR_SECTIONS = ['model', 'stages', 'gates', 'ai-native', 'assurance', 'quality', 'cadence', 'engagements', 'handover', 'principles', 'faq'];

$apr_asset = function (string $apr_path): ?string {
    return (is_file(__DIR__ . '/' . $apr_path) && filesize(__DIR__ . '/' . $apr_path) > 0) ? $apr_path : null;
};
$apr_css = array_filter([
    $apr_asset('assets/css/brand/hub.css'),
    $apr_asset('assets/css/tech/kit.css'),
    $apr_asset('assets/css/approach.css'),
]);
$apr_js = array_filter([$apr_asset('assets/js/brand/hub.js')]);
foreach ($APR_SECTIONS as $apr_id) {
    if ($apr_x = $apr_asset('assets/css/approach/' . $apr_id . '.css')) $apr_css[] = $apr_x;
    if ($apr_x = $apr_asset('assets/js/approach/' . $apr_id . '.js'))   $apr_js[]  = $apr_x;
}

$page = [
    'key'   => 'approach',
    'title' => 'Approach',
    'desc'  => 'We have rebuilt how we work around AI. What has not changed is what we stand for.',
    'css'   => array_values($apr_css),
    'js'    => array_values($apr_js),
];

$hero = [
    'eyebrow' => 'How we work',
    'title'   => 'AI runs the operation.<br><span class="g">People run the strategy.</span>',
    'lead'    => 'We have rebuilt how we work around AI. What has not changed is what we stand for.',
    'meta'    => [count($APR['stages']) . ' stages', count($APR['gates']) . ' decision gates', 'A person signs every one'],
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement: each one
     waits for an .is-in class only JavaScript adds, and partials/head.php restores the finished state
     in a <noscript> block. The stage stepper ships as a complete ordered list with a jump rail of real
     in-page links; assets/js/approach/stages.js swaps that rail for a tablist and shows one stage at a
     time. With JavaScript off, every stage is on the page, in order, in full. -->

<main id="main" class="bdh apr">
<?php include 'partials/page-hero.php'; ?>
<?php
foreach ($APR_SECTIONS as $apr_id):
    $apr_file = __DIR__ . '/partials/approach/' . $apr_id . '.php'; ?>
<!-- ===== approach · <?= e($apr_id) ?> ===== -->
<?php if (is_file($apr_file)) { include $apr_file; } else { echo "<!-- missing approach section: " . e($apr_id) . " -->\n"; } ?>
<?php endforeach; ?>
<?php include 'partials/cta.php'; ?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'        => 'https://schema.org',
    '@type'           => 'HowTo',
    'name'            => 'How Xterra Edze runs a project',
    'description'     => 'The six stages of an engagement, the decision each one unlocks and what a client holds at the end of it.',
    'step'            => array_values(array_map(fn (array $apr_s): array => [
        '@type' => 'HowToStep',
        'name'  => $apr_s['name'],
        'text'  => $apr_s['line'],
        'url'   => xe_url('approach.php') . '#stage-' . $apr_s['key'],
    ], $APR['stages'])),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include 'partials/footer.php'; ?>
