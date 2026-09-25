<?php
/**
 * Book a call — /book. One job: get a qualified 30-minute discovery call on the calendar.
 *
 * THE SCHEDULER IS REAL. partials/book/scheduler.php mounts Cal.com's official element embed for
 * shujaurrahman/30min (assets/js/book/scheduler.js loads https://app.cal.com/embed/embed.js and calls
 * Cal("inline", …)). That is third-party JavaScript on a third-party host, so the page is built to
 * degrade honestly: the shipped HTML shows a plain, visible link to https://cal.com/shujaurrahman/30min,
 * the script only swaps that panel for the embed once it is actually initialising, and a bounded wait
 * puts the panel back with an explanation if the embed never arrives. No analytics, no other
 * third-party script — Cal.com's embed is the only external code on the page.
 *
 * The home page's booking section (sections/20-booking.php) is a front-end MOCK by its own comment.
 * This page does not repeat it and does not claim a slot is reserved: a booking is confirmed by the
 * email Cal.com sends, not by pressing a button. That distinction is stated in three places here.
 *
 * Structure: a shell over partials/book/<id>.php, each with assets/css/book/<id>.css and
 * assets/js/book/<id>.js loaded only once the file holds something, over the page layer
 * assets/css/book.css (.bk-* primitives).
 *
 * Variables available to every section partial (never reassign):
 *   $SITE  data/site.php          $BK  this page's booking facts (Cal.com link, duration, window)
 *   $page  page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so every local here is prefixed bk_ and no section partial uses those names.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/tech/kit.php';

/* ---------------------------------------------------------------------------------------------
   The booking facts, in one place, so no two sections can disagree with each other.
   The Cal.com link is the owner's real scheduling link. The working window is IST and IST has no
   daylight saving, so the UTC window below is stable all year; assets/js/book/hours.js formats it
   in the reader's own zone from those two UTC times.
   --------------------------------------------------------------------------------------------- */
$bk_win_tz    = 'Asia/Kolkata';
$bk_win_open  = '09:30';
$bk_win_close = '18:30';
$bk_utc = function (string $bk_hm) use ($bk_win_tz): string {
    $bk_d = new DateTimeImmutable('today ' . $bk_hm, new DateTimeZone($bk_win_tz));
    return $bk_d->setTimezone(new DateTimeZone('UTC'))->format('H:i');
};

$BK = [
    'cal_owner' => 'shujaurrahman',
    'cal_event' => '30min',
    'mins'      => 30,
    'email'     => $SITE['company']['email'],
    'window'    => [
        'tz'        => $bk_win_tz,
        'tz_label'  => 'IST',
        'open'      => $bk_win_open,
        'close'     => $bk_win_close,
        'days'      => 'Monday to Friday',
        'utc_open'  => $bk_utc($bk_win_open),
        'utc_close' => $bk_utc($bk_win_close),
    ],
];
$BK['cal_link'] = $BK['cal_owner'] . '/' . $BK['cal_event'];
$BK['cal_url']  = 'https://cal.com/' . $BK['cal_link'];

/* Running order: book it → what it is → who is there → what to bring → what follows →
   when we are online → the other ways in. Bands: P A P A P A P, then the shared ink CTA. */
$BK_SECTIONS = ['scheduler', 'agenda', 'who', 'prepare', 'after', 'hours', 'other'];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$bk_asset = function (string $bk_path): ?string {
    $bk_f = __DIR__ . '/' . $bk_path;
    return (is_file($bk_f) && filesize($bk_f) > 0) ? $bk_path : null;
};
$bk_css = array_filter([
    $bk_asset('assets/css/brand/hub.css'),
    $bk_asset('assets/css/tech/kit.css'),
    $bk_asset('assets/css/book.css'),
]);
$bk_js = array_filter([$bk_asset('assets/js/brand/hub.js')]);
foreach ($BK_SECTIONS as $bk_id) {
    if ($bk_x = $bk_asset('assets/css/book/' . $bk_id . '.css')) $bk_css[] = $bk_x;
    if ($bk_x = $bk_asset('assets/js/book/' . $bk_id . '.js'))   $bk_js[]  = $bk_x;
}

$page = [
    'key'   => 'book',
    'title' => 'Book a call',
    'desc'  => 'Book a 30-minute discovery call with Xterra Edze. Pick a time on the calendar and the invitation arrives by email.',
    'css'   => array_values($bk_css),
    'js'    => array_values($bk_js),
];

$hero = [
    'eyebrow' => 'Book a call',
    'title'   => 'Thirty minutes<br><span class="g">on the calendar.</span>',
    'lead'    => 'A discovery call with the people who would run the work. Pick a time below, and the invitation arrives by email.',
    // PLACEHOLDER: confirm the video platform used for discovery calls before launch.
    'meta'    => ['30 minutes', 'Video call', 'New Delhi · Ludhiana'],
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement and every one
     of them waits for a class only JavaScript adds, so with JavaScript off they resolve to their finished
     state here. The scheduler is the one place where JavaScript changes what is shown, and it only ever
     replaces a working link with a working embed — never the other way round. -->

<main id="main" class="bdh bk">
<!-- PLACEHOLDER: confirm the video platform used for discovery calls before launch -->
<?php
include 'partials/page-hero.php';
foreach ($BK_SECTIONS as $bk_id):
    $bk_file = __DIR__ . '/partials/book/' . $bk_id . '.php'; ?>
<!-- ===== book · <?= e($bk_id) ?> ===== -->
<?php if (is_file($bk_file)) { include $bk_file; } else { echo "<!-- missing book section: " . e($bk_id) . " -->\n"; } ?>
<?php endforeach;
include 'partials/cta.php';
?>
</main>

<script type="application/ld+json">
<?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'ContactPage',
    'name'        => $page['title'] . ' — ' . $SITE['company']['name'],
    'description' => $page['desc'],
    'mainEntity'  => [
        '@type' => 'Organization',
        'name'  => $SITE['company']['name'],
        'email' => $BK['email'],
    ],
    'potentialAction' => [
        '@type'  => 'ReserveAction',
        'name'   => 'Book a ' . $BK['mins'] . '-minute discovery call',
        'target' => ['@type' => 'EntryPoint', 'urlTemplate' => $BK['cal_url'], 'actionPlatform' => 'https://schema.org/DesktopWebPlatform'],
        'result' => ['@type' => 'Reservation', 'name' => 'Discovery call', 'description' => $BK['mins'] . ' minutes, confirmed by email.'],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
</script>

<?php include 'partials/footer.php'; ?>
