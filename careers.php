<?php
/**
 * Careers — the employer-brand page and the job board.
 *
 * Fourteen sections, each its own partial in partials/careers/<id>.php, with
 * assets/css/careers/<id>.css and assets/js/careers/<id>.js loaded automatically once the file
 * exists and holds something. Page-level styles that several sections share stay in
 * assets/css/careers.css.
 *
 * Applying happens on its own page, /careers/apply, which validates ?role=<id> against this same
 * data file. That page's own assets are assets/css/careers-apply.css and assets/js/careers-apply.js
 * — deliberately outside assets/css/careers/ and assets/js/careers/, because everything in those
 * folders is auto-loaded into THIS page by the loop below.
 *
 * Variables every section partial may read (never reassign):
 *   $SITE      data/site.php                 $car_data   data/careers.php (whole file)
 *   $car_roles the roles array               $car_by_dept  dept label => number of open roles
 *   $page      page meta
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so every local in a careers partial is prefixed car_ (or the section's own short prefix).
 */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
$car_data  = require __DIR__ . '/data/careers.php';
$car_roles = $car_data['roles'];

/* open roles per department, biggest first — the hero board and the practice cards both read it */
$car_by_dept = [];
foreach ($car_roles as $car_r) $car_by_dept[$car_r['dept']] = ($car_by_dept[$car_r['dept']] ?? 0) + 1;
arsort($car_by_dept);

/* Running order: the offer → who we are to work for → how the work feels → what we ask of you →
   what you get → how we hire → the roles → the promises → the questions → the general application.
   Bands: P A P A I P A P I P A P A P, then the shared ink CTA. */
$SECTIONS = ['hero', 'reasons', 'teams', 'why', 'week', 'bar', 'growth', 'work', 'benefits', 'hiring', 'roles', 'eeo', 'faq', 'apply'];

$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/careers.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/careers/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/careers/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'careers', 'title' => 'Careers — open roles',
         'desc' => 'Join Xterra Edze: brand, technology, campaign, AI, product and marketing technology roles in New Delhi, Ludhiana and remote across India. Six disciplines, one team, an AI-native way of working.',
         'css' => array_values($pp_css), 'js' => array_values($pp_js)];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<main id="main" class="bdh car">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/partials/careers/$pp_id.php"; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org', '@type' => 'WebPage', 'name' => 'Careers — Xterra Edze',
    'description' => $page['desc'], 'url' => xe_url('careers.php'),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
