<?php /* DRAFT COPY — review before launch */
/**
 * The Journal — one post. This file IS the post page; blog/<slug>.php is a three-line shell:
 *
 *     <?php $blog_slug = 'my-slug';
 *     require __DIR__ . '/../partials/blog/post.php';
 *
 * Everything the page shows comes from data/blog.php. Two spines, one system:
 *   'article'    → partials/blog/post-article.php — a reading column with a contents list that
 *                  tracks the scroll, figures, pull quotes, tables, code and takeaways.
 *   'case-study' → partials/blog/post-case.php — a dossier: the brief, what could not move, the
 *                  movements, who did what, what we measure, and what the client owns afterwards.
 *
 * Base layers: assets/css/brand/hub.css (.bdh-*), assets/css/tech/kit.css (.xt-*),
 * assets/css/blog.css (.blg-* primitives), then the two spine stylesheets. Scripts: assets/js/brand/hub.js
 * (window.BDH), then assets/js/blog/post.js.
 *
 * Locals here and in every blog partial are blg_* / pst_* / cse_* — nav.php, cta.php and footer.php
 * loop with $c $d $i $k $item $url $current $disc $col $l $s.
 */

$BASE = '../';
require __DIR__ . '/../init.php';
require_once __DIR__ . '/../tech/kit.php';
require_once __DIR__ . '/lib.php';

$BLG  = blog_data();
$POST = isset($blog_slug) ? blog_post((string) $blog_slug) : null;
if (!$POST) {                       // a shell with no entry in data/blog.php — never link to nothing
    require __DIR__ . '/../../404.php';
    return;
}
$DISCS = blog_disciplines();
$NEIGH = blog_neighbours($POST['slug']);
$REL   = blog_related($POST['slug'], 3);
$IS_CASE = $POST['type'] === 'case-study';

$blg_root  = __DIR__ . '/../../';
$blg_asset = function (string $blg_path) use ($blg_root): ?string {
    $blg_f = $blg_root . $blg_path;
    return (is_file($blg_f) && filesize($blg_f) > 0) ? $blg_path : null;
};
$blg_css = array_filter([
    $blg_asset('assets/css/brand/hub.css'),
    $blg_asset('assets/css/tech/kit.css'),
    $blg_asset('assets/css/blog.css'),
    $blg_asset('assets/css/blog/post.css'),
    $IS_CASE ? $blg_asset('assets/css/blog/case.css') : null,
]);
$blg_js = array_filter([
    $blg_asset('assets/js/brand/hub.js'),
    $blg_asset('assets/js/blog/post.js'),
]);

$page = [
    'key'   => 'blog',
    'title' => $POST['title'],
    'desc'  => $POST['dek'],
    'css'   => array_values($blg_css),
    'js'    => array_values($blg_js),
];

include __DIR__ . '/../head.php';
include __DIR__ . '/../nav.php';
?>

<!-- The shipped HTML is the finished state. post.js only adds the reading progress, the contents
     highlight and the share/copy affordance; with JavaScript off every word is still here and the
     contents list is an ordinary set of anchors. -->

<main id="main" class="bdh blg blg-post<?= $IS_CASE ? ' blg-post--case' : ' blg-post--article' ?>">
<?php
include __DIR__ . '/post-hero.php';
include __DIR__ . ($IS_CASE ? '/post-case.php' : '/post-article.php');
include __DIR__ . '/post-end.php';
include __DIR__ . '/../cta.php';
?>
</main>

<script type="application/ld+json">
<?= blog_jsonld_post($POST) ?>
</script>

<?php include __DIR__ . '/../footer.php'; ?>
