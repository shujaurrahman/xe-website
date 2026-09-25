<?php
/**
 * The Journal — the listing. Eleven sections, each its own partial in partials/blog/<id>.php with
 * assets/css/blog/<id>.css and assets/js/blog/<id>.js loaded only once they hold something.
 *
 * URLs. /blog is this file; /blog/<slug> is a three-line shell beside it that requires
 * partials/blog/post.php. Both resolve under the existing .htaccess with no rule added: /dir/ maps
 * to dir/index.php and /dir/name maps to dir/name.php, exactly as /services works.
 *
 * Filters are a plain GET form (?type=&discipline=&industry=&tag=). The server renders every card
 * and sets [hidden] on the ones that do not match, so the page is already filtered with JavaScript
 * off; assets/js/blog/index.js then filters in place, keeps the counts and the status line live and
 * rewrites the address without a reload.
 *
 * Content: data/blog.php — its header comment documents the schema and how to add a post.
 * Partials see $SITE, $BLG (data/blog.php), $POSTS (derived, newest first), $DISCS (discipline rows),
 * $FILTER (the four active values) and $SHOWN (how many match). nav.php, cta.php and footer.php loop
 * with $c $d $i $k $item $url $current $disc $col $l $s, so every local here is blg_*.
 */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require_once __DIR__ . '/../partials/blog/lib.php';

$BLG   = blog_data();
$POSTS = blog_posts();
$DISCS = blog_disciplines();

/* the four filters, validated against the taxonomy — anything unknown is dropped */
$blg_in = function (string $blg_key, array $blg_allowed): string {
    $blg_v = isset($_GET[$blg_key]) && is_string($_GET[$blg_key]) ? $_GET[$blg_key] : '';
    return in_array($blg_v, $blg_allowed, true) ? $blg_v : '';
};
$FILTER = [
    'type'       => $blg_in('type',       array_keys($BLG['types'])),
    'discipline' => $blg_in('discipline', array_keys($DISCS)),
    'industry'   => $blg_in('industry',   array_keys($BLG['industries'])),
    'tag'        => $blg_in('tag',        array_keys($BLG['tags'])),
];
$SHOWN = blog_count($FILTER);

$BLG_SECTIONS = ['hero', 'featured', 'paths', 'index', 'cases', 'topics', 'desks', 'standard', 'archive', 'follow', 'faq'];

$blg_root  = __DIR__ . '/../';
$blg_asset = function (string $blg_path) use ($blg_root): ?string {
    $blg_f = $blg_root . $blg_path;
    return (is_file($blg_f) && filesize($blg_f) > 0) ? $blg_path : null;
};
$blg_css = array_filter([
    $blg_asset('assets/css/brand/hub.css'),
    $blg_asset('assets/css/tech/kit.css'),
    $blg_asset('assets/css/blog.css'),
]);
$blg_js = array_filter([$blg_asset('assets/js/brand/hub.js')]);
foreach ($BLG_SECTIONS as $blg_id) {
    if ($blg_x = $blg_asset('assets/css/blog/' . $blg_id . '.css')) $blg_css[] = $blg_x;
    if ($blg_x = $blg_asset('assets/js/blog/' . $blg_id . '.js'))   $blg_js[]  = $blg_x;
}
unset($blg_id, $blg_x);

$page = [
    'key'   => 'blog',
    'title' => 'The Journal',
    'desc'  => 'Written notes on the work — articles on how we build, and case studies of what changed. Filter by type, discipline, sector or topic.',
    'css'   => array_values($blg_css),
    'js'    => array_values($blg_js),
];

include __DIR__ . '/../partials/head.php';
include __DIR__ . '/../partials/nav.php';
?>

<!-- The shipped HTML is the finished state: every card is present and already filtered by the server.
     JavaScript only re-filters in place, keeps the counts live and rewrites the address. -->

<main id="main" class="bdh blg blg-index">
<?php
foreach ($BLG_SECTIONS as $blg_id):
    $blg_file = __DIR__ . '/../partials/blog/' . $blg_id . '.php'; ?>
<!-- ===== journal · <?= e($blg_id) ?> ===== -->
<?php if (is_file($blg_file)) { include $blg_file; } else { echo '<!-- missing journal section: ' . e($blg_id) . " -->\n"; }
endforeach;
unset($blg_id, $blg_file);
include __DIR__ . '/../partials/cta.php';
?>
</main>

<script type="application/ld+json">
<?= blog_jsonld_index($POSTS) ?>
</script>

<?php include __DIR__ . '/../partials/footer.php'; ?>
