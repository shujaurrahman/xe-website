<?php
/* Careers — a working job board: why join, how and where we work, benefits, hiring steps, filterable roles with inline applications.
   Sections: partials/careers/<id>.php (+ assets/js/careers/<id>.js). Styles: assets/css/careers.css. Roles: data/careers.php. */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
$car_data  = require __DIR__ . '/data/careers.php';
$car_roles = $car_data['roles'];
/* the contact form's signed render time — mirrored exactly from sections/20-booking.php (see the note there) */
$car_token = function_exists('ct_token') ? ct_token() : (function (): string {
    $car_key = hash('sha256', realpath(__DIR__ . '/partials/contact/handler.php') . '|' . php_uname('n') . '|xe-contact');
    $car_t = (string) time();
    return $car_t . '.' . substr(hash_hmac('sha256', $car_t, $car_key), 0, 20);
})();
$SECTIONS = ['hero', 'why', 'work', 'benefits', 'hiring', 'roles', 'apply'];
$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/careers.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($x = $pp_has("assets/css/careers/$pp_id.css")) $pp_css[] = $x;
    if ($x = $pp_has("assets/js/careers/$pp_id.js"))   $pp_js[]  = $x;
}
$page = ['key' => 'careers', 'title' => 'Careers — open roles',
         'desc' => 'Join Xterra Edze: brand, technology, campaign, AI, product and marketing technology roles in New Delhi, Ludhiana and remote across India.',
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
