<?php
/**
 * Careers — "one team, six disciplines". The page is a shell: each section is its own
 * partial in partials/careers/<id>.php, with assets/css/careers/<id>.css and
 * assets/js/careers/<id>.js picked up automatically once those files hold anything.
 *
 * Base layers (in order): assets/css/brand/hub.css (.bdh-* primitives, window.BDH helpers in
 * assets/js/brand/hub.js), assets/css/tech/kit.css (.xt-* icons and badges), then
 * assets/css/careers.css (.car-* primitives for this page).
 *
 * The open roles are data, not markup: data/careers.php drives the list, the filters, the
 * counters and the role menu on /careers/apply. partials/careers/lib.php reads it.
 *
 * Variables available to every section partial (never reassign):
 *   $SITE  data/site.php    $CAR_ROLES  slug => role    $CAR_GROUPS  group key => group
 *   $page  page meta        $hero       the hero copy handed to partials/page-hero.php
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so section partials prefix their own locals (car_*, roles_*, hire_* …) and never use those names.
 *
 * No JobPosting structured data is emitted on purpose: Google's JobPosting type needs a real
 * datePosted and validThrough for every role, and inventing those would be a false claim.
 * Add it once hiring confirms live posting and closing dates.
 */
$BASE = '';
require 'partials/init.php';
require_once 'partials/tech/kit.php';
require_once 'partials/careers/lib.php';

$CAR_ROLES  = car_roles();
$CAR_GROUPS = car_groups();
/* the six disciplines carry a hub URL; extra groups (studio) do not, so the hero can say how many
   of the practices are hiring without contradicting "six disciplines" anywhere else on the site */
$car_dcount = count(array_filter($CAR_GROUPS, fn ($car_g) => $car_g['url'] !== ''));

/* Running order: orient → why here → who you join → the work → how AI changes it →
   the roles → the bar → hiring → growth → where → what we offer → questions.
   Bands: P A P A I A P A P A P A, then the shared ink CTA. */
$CAR_SECTIONS = [
    'navigator', 'why', 'team', 'the-work', 'ai-native', 'roles',
    'bar', 'hiring', 'growth', 'studios', 'support', 'faq',
];

/* Base layers first, then each section's own file once it has content. head/footer stamp ?v= on every path. */
$car_asset = function (string $path): ?string {
    $f = __DIR__ . '/' . $path;
    return (is_file($f) && filesize($f) > 0) ? $path : null;
};
$car_css = array_filter([
    $car_asset('assets/css/brand/hub.css'),
    $car_asset('assets/css/tech/kit.css'),
    $car_asset('assets/css/careers.css'),
]);
$car_js = array_filter([$car_asset('assets/js/brand/hub.js')]);
foreach ($CAR_SECTIONS as $car_id) {
    if ($car_x = $car_asset('assets/css/careers/' . $car_id . '.css')) $car_css[] = $car_x;
    if ($car_x = $car_asset('assets/js/careers/' . $car_id . '.js'))   $car_js[]  = $car_x;
}

$page = [
    'key'   => 'careers',
    'title' => 'Careers',
    'desc'  => 'One team across brand, technology, campaign, AI, product and marketing technology — working from New Delhi and Ludhiana.',
    'css'   => array_values($car_css),
    'js'    => array_values($car_js),
];

$hero = [
    'eyebrow' => 'Careers',
    'title'   => 'Build the work<br><span class="g">that outlasts the brief.</span>',
    'lead'    => 'One team across brand, technology, campaign, AI, product and marketing technology — working from New Delhi and Ludhiana.',
    'meta'    => [
        count($CAR_ROLES) === 1 ? '1 open role' : count($CAR_ROLES) . ' open roles',
        $car_dcount . ($car_dcount === 1 ? ' practice hiring' : ' practices hiring'),
        'New Delhi · Ludhiana',
    ],
];

include 'partials/head.php';
include 'partials/nav.php';
?>

<!-- The shipped HTML is the finished state. Reveals and entrance motion are an enhancement and wait for
     an .is-in class only JavaScript adds, so with JavaScript off everything here is already resolved.
     The role filters are a real GET form that the server answers; roles.js only makes them instant. -->

<main id="main" class="bdh car">
<?php include 'partials/page-hero.php'; ?>
<?php foreach ($CAR_SECTIONS as $car_id):
    $car_file = __DIR__ . '/partials/careers/' . $car_id . '.php'; ?>
<!-- ===== careers · <?= e($car_id) ?> ===== -->
<?php if (is_file($car_file)) { include $car_file; } else { echo "<!-- missing careers section: " . e($car_id) . " -->\n"; } ?>
<?php endforeach; ?>
<?php include 'partials/cta.php'; ?>
</main>

<?php include 'partials/footer.php'; ?>
