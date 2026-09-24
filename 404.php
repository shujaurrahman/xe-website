<?php
/* Not found — a designed 404: what was asked for, why it did not resolve, the closest real page, and every main destination. Served by router.php (php -S) and .htaccess (Apache) for any unknown URL. Sections: partials/e404/<id>.php · styles: assets/css/e404.css. */
/* Links must work from any depth (/nope, /services/nope/deeper), so $BASE is the site root as an absolute path.
   Derived from where this file sits under the document root (works at the domain root, in a sub-folder, and
   under php -S); if the host maps the site outside the document root, fall back to the script's own folder. */
$e404_dir  = str_replace('\\', '/', (string) realpath(__DIR__));
$e404_root = str_replace('\\', '/', (string) realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));
$BASE = ($e404_root !== '' && strpos($e404_dir . '/', rtrim($e404_root, '/') . '/') === 0)
    ? substr($e404_dir, strlen(rtrim($e404_root, '/'))) . '/'
    : rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/') . '/';
http_response_code(404);
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';

/* the path that failed, relative to the site root, for the readout and the nearest-match guess */
$e404_path = rawurldecode((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH));
if (strpos($e404_path, $BASE) === 0) $e404_path = '/' . substr($e404_path, strlen($BASE));
$e404_path = mb_substr(preg_replace('~[^\w/.\-]~u', '', $e404_path), 0, 80);
$e404_word = strtolower(preg_replace('~[^a-z0-9]+~i', ' ', basename($e404_path) ?: ''));
$e404_word = trim(preg_replace('~\b(php|html?|index)\b~', '', $e404_word));

/* nearest real page: compare the last path segment with every discipline and capability name */
$e404_best = null; $e404_score = 0;
if (strlen($e404_word) >= 3) {
    foreach ($SITE['disciplines'] as $e404_d) {
        $e404_cands = [[$e404_d['name'], xe_discipline_url($e404_d), $e404_d['name']]];
        foreach ($e404_d['caps'] as $e404_c) $e404_cands[] = [$e404_c[0], xe_cap_url($e404_d, $e404_c), $e404_d['name']];
        foreach ($e404_cands as $e404_x) {
            similar_text($e404_word, strtolower($e404_x[0]), $e404_pc);
            if (stripos($e404_x[0], $e404_word) !== false) $e404_pc += 40;
            if ($e404_pc > $e404_score) { $e404_score = $e404_pc; $e404_best = $e404_x; }
        }
    }
    if ($e404_score < 55) $e404_best = null;
}

$SECTIONS = ['hero', 'routes'];
$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/e404.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
$page = [
    'key'   => 'e404',
    'title' => 'Page not found',
    'desc'  => 'This address does not lead to a page on the Xterra Edze site. Here is where to go instead.',
    'css'   => array_values($pp_css),
    'js'    => array_values($pp_js),
];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<main id="main" class="bdh e404">
<?php foreach ($SECTIONS as $pp_id) include __DIR__ . "/partials/e404/$pp_id.php"; ?>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
