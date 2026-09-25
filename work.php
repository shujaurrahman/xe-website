<?php
/**
 * Work — the portfolio, as a working record.
 *
 * The concept: a portfolio page that is honest about what it can show. Every programme is an
 * *exhibit* with three layers — a photographic plate, a code-built artefact of the thing the work
 * left behind, and the record (brief, disciplines, system, deliverables, measures). The client's
 * name is the only layer that is missing, and the page says so rather than hiding it.
 *
 * Structure: a shell that includes one partial per section, partials/work/<id>.php, with
 * assets/css/work/<id>.css and assets/js/work/<id>.js loaded automatically once they hold anything,
 * over the page-level assets/css/work.css.
 *
 * Case-study pages live at /work/<slug> — work/<slug>.php is a three-line shell over the shared
 * renderer in partials/work/case.php. .htaccess maps /work/<slug> → work/<slug>.php exactly as it
 * maps /services/brand-design, so a page file sits beside a folder of the same name.
 *
 * Variables available to every section partial (never reassign):
 *   $SITE      data/site.php                 $WRK       data/work.php (the case studies)
 *   $wrk_disc  discipline slug => row        $wrk_cases cases that have all their required fields
 *   $wrk_fd    the discipline filter ('' = all)     $wrk_fi   the industry filter
 *   $wrk_match fn(case, d, i): bool          $wrk_has   fn(slug): bool — does /work/<slug> render?
 * partials/nav.php, cta.php and footer.php loop with $c $d $i $k $item $url $current $disc $col $l $s,
 * so every local here and in the section partials is prefixed wrk_.
 */
$BASE = '';
require __DIR__ . '/partials/init.php';
require_once __DIR__ . '/partials/tech/kit.php';
require_once __DIR__ . '/partials/work/lib.php';

$WRK       = require __DIR__ . '/data/work.php';
$wrk_cases = wrk_cases($WRK);
$wrk_disc  = [];
foreach ($SITE['disciplines'] as $wrk_x) $wrk_disc[$wrk_x['slug']] = $wrk_x;
unset($wrk_x);

/* Filters arrive as ?d=<discipline-slug>&i=<industry-key>; anything unknown is ignored, never echoed. */
$wrk_q     = fn (string $k, array $ok): string => (is_string($_GET[$k] ?? null) && isset($ok[$_GET[$k]])) ? $_GET[$k] : '';
$wrk_fd    = $wrk_q('d', $wrk_disc);
$wrk_fi    = $wrk_q('i', $WRK['industries']);
$wrk_match = fn (array $wrk_c, string $wrk_d, string $wrk_i): bool
    => ($wrk_d === '' || in_array($wrk_d, array_column($wrk_c['did'], 0), true)) && ($wrk_i === '' || $wrk_c['industry'] === $wrk_i);
/* Only ever link a case that has a page: the index shows every entry, links the ones that render. */
$wrk_has = fn (string $wrk_s): bool => is_file(__DIR__ . '/work/' . $wrk_s . '.php');

/* Running order: what we did → how to read it → the whole index → the shape of it →
   how it is made → what it is judged by → why the names are missing → questions. */
$SECTIONS = ['hero', 'featured', 'anatomy', 'index', 'sectors', 'shape', 'split', 'craft', 'method', 'stack', 'measures', 'nda', 'faq'];

$pp_root = __DIR__ . '/';
$pp_has  = fn (string $p): ?string => (is_file($pp_root . $p) && filesize($pp_root . $p) > 0) ? $p : null;
$pp_css  = array_filter([$pp_has('assets/css/brand/hub.css'), $pp_has('assets/css/tech/kit.css'), $pp_has('assets/css/work.css')]);
$pp_js   = array_filter([$pp_has('assets/js/brand/hub.js')]);
foreach ($SECTIONS as $pp_id) {
    if ($pp_x = $pp_has("assets/css/work/$pp_id.css")) $pp_css[] = $pp_x;
    if ($pp_x = $pp_has("assets/js/work/$pp_id.js"))   $pp_js[]  = $pp_x;
}

$page = [
    'key'   => 'work',
    'title' => 'Work',
    'desc'  => 'Anonymised programmes across brand, product, content, AI and technology — the brief, the system we built, what we delivered and how it is measured.',
    'css'   => array_values($pp_css),
    'js'    => array_values($pp_js),
];
include __DIR__ . '/partials/head.php';
include __DIR__ . '/partials/nav.php';
?>
<!-- PLACEHOLDER: replace with real case studies before launch. Every programme below is an
     anonymised illustration written in-house — no client is named, and no figure is presented as an
     achieved result. The structure is final: add a project by appending one entry to data/work.php
     (its header comment is the instructions) and copying work/<slug>.php from any existing one. -->
<main id="main" class="bdh wrk">
<?php foreach ($SECTIONS as $pp_id): ?>
<!-- ===== work · <?= e($pp_id) ?> ===== -->
<?php include __DIR__ . "/partials/work/$pp_id.php"; endforeach; ?>
<?php include __DIR__ . '/partials/cta.php'; ?>
</main>

<script type="application/ld+json"><?= json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'CollectionPage',
    'name'        => 'Work — ' . $SITE['company']['name'],
    'description' => $page['desc'],
    'hasPart'     => array_values(array_map(fn ($wrk_c) => array_filter([
        '@type'       => 'CreativeWork',
        'name'        => $wrk_c['title'],
        'description' => $wrk_c['brief'],
        'url'         => $wrk_has($wrk_c['slug']) ? xe_url('work/' . $wrk_c['slug'] . '.php') : null,
    ]), $wrk_cases)),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<?php include __DIR__ . '/partials/footer.php'; ?>
