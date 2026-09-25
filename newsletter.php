<?php
/**
 * The Dispatch — /newsletter. The newsletter's own page and the home of the sign-up.
 *
 * SHAPE
 *   A shell. Each of the eleven sections is its own partial in partials/newsletter/<id>.php, with
 *   assets/css/newsletter/<id>.css and assets/js/newsletter/<id>.js picked up automatically once they
 *   hold something, over a page-level assets/css/newsletter.css (.nlt-* primitives).
 *
 * URL
 *   /newsletter, with no rule added: .htaccess and router.php already map /foo to foo.php, which is
 *   why this file sits at the site root and sets $BASE = ''.
 *
 * THE FORM
 *   partials/newsletter/handler.php runs before any output — it may redirect (Post/Redirect/Get) or
 *   answer a background post with JSON. partials/newsletter/signup.php is the reusable component; its
 *   header comment documents the one-line include for any other page. Three instances sit on this
 *   page, one on each kind of band, which is also how the component's three contexts are proved:
 *     'hero'      inline, on a plain paper band
 *     'aside'     card,   on .band--alt
 *     'subscribe' full,   on .band--ink
 *   $NL_INSTANCES below is the list the handler's result is matched against; a sign-up posted from
 *   another page carries an id this page does not have, so the result falls back to 'subscribe'.
 *
 * TRUTHFULNESS
 *   There is no database and no email-service integration. A valid submission emails the address to
 *   the company inbox and stops; every part of the page that touches this says so in plain words. No
 *   subscriber count, open rate or issue number appears anywhere, because none exists. The sample
 *   issue and the three archive entries are written in-house and are marked as samples on the page.
 *
 * Content: data/newsletter.php — its header comment documents every key.
 * Partials see $SITE, $NLT (data/newsletter.php), $NL (the form state) and $page. nav.php, cta.php and
 * footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s, so every local here is nlt_*.
 */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
require_once __DIR__ . '/partials/newsletter/lib.php';
require __DIR__ . '/partials/newsletter/handler.php';   // may redirect or emit JSON and exit

$NLT = require __DIR__ . '/data/newsletter.php';

/* which sign-up on this page the handler's answer belongs to */
$NL_INSTANCES = ['hero', 'aside', 'subscribe'];
if (!in_array($NL['inst'], $NL_INSTANCES, true)) { $NL['inst'] = 'subscribe'; }

/* Running order: what it is → who it is for → read one → how one is made → the rhythm → your address
   → subscribe → the archive → how it sits beside the journal → questions.
   Bands: P A P A I P A I P A P, then the shared ink CTA. */
$NLT_SECTIONS = ['hero', 'promise', 'reader', 'issue', 'made', 'rhythm', 'privacy', 'subscribe', 'archive', 'journal', 'faq'];

$nlt_asset = function (string $nlt_path): ?string {
    $nlt_f = __DIR__ . '/' . $nlt_path;
    return (is_file($nlt_f) && filesize($nlt_f) > 0) ? $nlt_path : null;
};
$nlt_css = array_filter([
    $nlt_asset('assets/css/brand/hub.css'),
    $nlt_asset('assets/css/tech/kit.css'),
    $nlt_asset('assets/css/newsletter.css'),
    /* the sign-up component's own stylesheet. It emits this itself on a page that does not list it;
       listing it here puts it in the head, which is better for the three instances on this page. */
    $nlt_asset('assets/css/newsletter/signup.css'),
]);
$nlt_js = array_filter([$nlt_asset('assets/js/brand/hub.js'), $nlt_asset('assets/js/newsletter/signup.js')]);
foreach ($NLT_SECTIONS as $nlt_id) {
    if ($nlt_x = $nlt_asset('assets/css/newsletter/' . $nlt_id . '.css')) $nlt_css[] = $nlt_x;
    if ($nlt_x = $nlt_asset('assets/js/newsletter/' . $nlt_id . '.js'))   $nlt_js[]  = $nlt_x;
}
unset($nlt_id, $nlt_x);

$page = [
    'key'   => 'newsletter',
    'title' => $NLT['meta']['name'],
    'desc'  => 'One email a month from the people building the work: one change of mind, three things worth reading and one number with its definition. No tracking, one-click unsubscribe.',
    'css'   => array_values($nlt_css),
    'js'    => array_values($nlt_js),
];

include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Every reveal resolves to its finished form without
     JavaScript (partials/head.php carries the <noscript> rule), the sample-issue reader ships as the
     whole issue in reading order and is only folded into a tabbed reader once its script runs, and the
     sign-up is a real form post that needs no JavaScript at all. -->

<main id="main" class="bdh nlt">
<?php
foreach ($NLT_SECTIONS as $nlt_id):
    $nlt_file = __DIR__ . '/partials/newsletter/' . $nlt_id . '.php'; ?>
<!-- ===== dispatch · <?= e($nlt_id) ?> ===== -->
<?php if (is_file($nlt_file)) { include $nlt_file; } else { echo '<!-- missing dispatch section: ' . e($nlt_id) . " -->\n"; }
endforeach;
unset($nlt_id, $nlt_file);
include __DIR__ . '/partials/cta.php';
?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'WebPage',
    'name'        => $NLT['meta']['name'],
    'description' => $page['desc'],
    'publisher'   => ['@type' => 'Organization', 'name' => $SITE['company']['name'], 'email' => $SITE['company']['email']],
    'mainEntity'  => [
        '@type'       => 'CreativeWorkSeries',
        'name'        => $NLT['meta']['name'],
        'description' => $NLT['meta']['line'],
        'inLanguage'  => 'en',
        'publisher'   => ['@type' => 'Organization', 'name' => $SITE['company']['name']],
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
