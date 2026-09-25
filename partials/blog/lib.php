<?php
/**
 * The Journal — shared data layer and block renderer for /blog and every post page.
 *
 * Include-safe: require_once from anywhere after partials/init.php (it needs e() and xe_url()).
 * Every function is guarded, so a second include is harmless. All output is escaped.
 *
 * CONTENT
 *   data/blog.php holds everything. Its header comment documents the schema and the two-step way to
 *   add a post: append one entry, create one three-line blog/<slug>.php shell.
 *
 * API
 *   blog_data(): array                     the whole file, cached
 *   blog_posts(): array                    slug => post, newest first, each with the derived keys
 *                                          'slug' 'url' 'live' (its page file exists) 'words' 'minutes'
 *                                          'toc' 'iso' 'human' 'type_row' 'desk_row'
 *   blog_post(string $slug): ?array        one post, with the same derived keys
 *   blog_url(string $slug): string         /blog/<slug>            (clean; '' when the page file is absent)
 *   blog_home(array $q = []): string       /blog, with optional filter query
 *   blog_disciplines(): array              discipline slug => the row from data/site.php
 *   blog_related(string $slug, int $n): array   posts sharing a discipline or a tag, best match first
 *   blog_neighbours(string $slug): array   ['prev' => ?post, 'next' => ?post] in publication order
 *   blog_count(array $f): int              how many posts match a filter ['type','discipline','industry','tag']
 *   blog_match(array $post, array $f): bool
 *
 * RENDERING
 *   blog_inline(string $s): string         escaped text with *emphasis*, `code` and [label](page.php)
 *   blog_blocks(array $blocks): void       echoes the body blocks (see data/blog.php for the block list)
 *   blog_jsonld_post(array $post): string  BlogPosting (article) / Article + case-study genre, and a breadcrumb
 *   blog_jsonld_index(array $posts): string   the Blog listing
 */

if (!function_exists('blog_data')) {

function blog_data(): array {
    static $blg_all = null;
    if ($blg_all === null) { $blg_all = require __DIR__ . '/../../data/blog.php'; }
    return $blg_all;
}

/** Root of the repository on disk — used only to ask whether a post's page file exists. */
function blog_root(): string { return dirname(__DIR__, 2) . '/'; }

/** Absolute URL for structured data. Falls back to the site-relative form when the host is unknown. */
function blog_abs(string $blg_path): string {
    $blg_rel = xe_url($blg_path);
    $blg_host = $_SERVER['HTTP_HOST'] ?? '';
    if ($blg_host === '') return $blg_rel;
    $blg_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || ($_SERVER['SERVER_PORT'] ?? '') === '443';
    $blg_base  = ($blg_https ? 'https://' : 'http://') . $blg_host;
    if ($blg_rel !== '' && $blg_rel[0] === '/') return $blg_base . $blg_rel;
    /* xe_url() returns a path relative to the page ('../blog/x'); resolve it against the current directory */
    $blg_dir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
    $blg_out = $blg_dir . '/' . ltrim(preg_replace('~^\./~', '', $blg_rel), '/');
    while (strpos($blg_out, '/../') !== false) {
        $blg_out = preg_replace('~/[^/]+/\.\./~', '/', $blg_out, 1);
    }
    return $blg_base . $blg_out;
}

/** Every text string inside a value, flattened — used for the word count. */
function blog_text_of($blg_v): string {
    if (is_string($blg_v)) return ' ' . $blg_v;
    if (!is_array($blg_v)) return '';
    $blg_s = '';
    foreach ($blg_v as $blg_k => $blg_x) {
        if (in_array($blg_k, ['file', 'credit', 'lang', 'pos'], true)) continue;
        $blg_s .= blog_text_of($blg_x);
    }
    return $blg_s;
}

/** The fixed spine a case study is set out on. Keys match the sections partials/blog/post-case.php renders. */
function blog_case_spine(): array {
    return [
        'brief'       => 'The brief',
        'constraints' => 'What could not move',
        'did'         => 'What we did',
        'disciplines' => 'Who did what',
        'changed'     => 'What we measure',
        'owns'        => 'What you own afterwards',
    ];
}

function blog_posts(): array {
    static $blg_posts = null;
    if ($blg_posts !== null) return $blg_posts;

    $blg_d = blog_data();
    $blg_posts = [];
    foreach ($blg_d['posts'] as $blg_slug => $blg_p) {
        $blg_p['slug'] = $blg_slug;
        $blg_p['live'] = is_file(blog_root() . 'blog/' . $blg_slug . '.php');
        $blg_p['url']  = $blg_p['live'] ? xe_url('blog/' . $blg_slug . '.php') : '';
        $blg_p['type_row'] = $blg_d['types'][$blg_p['type']] ?? $blg_d['types']['article'];
        $blg_p['desk_row'] = $blg_d['desks'][$blg_p['desk']] ?? null;

        $blg_words = str_word_count(strip_tags(blog_text_of($blg_p['body'] ?? []) . blog_text_of($blg_p['case'] ?? []) . ' ' . ($blg_p['dek'] ?? '')));
        $blg_p['words']   = $blg_words;
        $blg_p['minutes'] = max(1, (int) round($blg_words / 210));

        $blg_p['iso']   = $blg_p['date'];
        $blg_p['human'] = date('j F Y', strtotime($blg_p['date']));

        /* the contents list: an article's own headings, a case study's fixed spine */
        $blg_toc = [];
        if (($blg_p['type'] ?? '') === 'case-study') {
            foreach (blog_case_spine() as $blg_k => $blg_label) $blg_toc[] = ['cs-' . $blg_k, $blg_label];
            $blg_i = 0;
            foreach ($blg_p['body'] ?? [] as $blg_b) {
                if (($blg_b[0] ?? '') === 'h') { $blg_toc[] = ['ap-' . $blg_i, $blg_b[1]]; $blg_i++; }
            }
        } else {
            $blg_i = 0;
            foreach ($blg_p['body'] ?? [] as $blg_b) {
                if (($blg_b[0] ?? '') === 'h') { $blg_toc[] = ['sec-' . $blg_i, $blg_b[1]]; $blg_i++; }
            }
        }
        $blg_p['toc'] = $blg_toc;

        $blg_posts[$blg_slug] = $blg_p;
    }
    uasort($blg_posts, fn (array $blg_a, array $blg_b): int => strcmp($blg_b['date'], $blg_a['date']));
    return $blg_posts;
}

function blog_post(string $blg_slug): ?array {
    $blg_all = blog_posts();
    return $blg_all[$blg_slug] ?? null;
}

function blog_url(string $blg_slug): string {
    $blg_p = blog_post($blg_slug);
    return $blg_p ? $blg_p['url'] : '';
}

function blog_home(array $blg_q = []): string {
    $blg_q = array_filter($blg_q, fn ($blg_v) => $blg_v !== '' && $blg_v !== null);
    return xe_url('blog/index.php') . ($blg_q ? '?' . http_build_query($blg_q) : '');
}

function blog_disciplines(): array {
    static $blg_map = null;
    if ($blg_map !== null) return $blg_map;
    $blg_map = [];
    $blg_site = $GLOBALS['SITE'] ?? require dirname(__DIR__, 2) . '/data/site.php';
    foreach ($blg_site['disciplines'] as $blg_row) $blg_map[$blg_row['slug']] = $blg_row;
    return $blg_map;
}

function blog_match(array $blg_p, array $blg_f): bool {
    if (!empty($blg_f['type'])       && $blg_p['type'] !== $blg_f['type']) return false;
    if (!empty($blg_f['discipline']) && !in_array($blg_f['discipline'], $blg_p['disciplines'] ?? [], true)) return false;
    if (!empty($blg_f['industry'])   && ($blg_p['industry'] ?? '') !== $blg_f['industry']) return false;
    if (!empty($blg_f['tag'])        && !in_array($blg_f['tag'], $blg_p['tags'] ?? [], true)) return false;
    return true;
}

function blog_count(array $blg_f): int {
    $blg_n = 0;
    foreach (blog_posts() as $blg_p) if (blog_match($blg_p, $blg_f)) $blg_n++;
    return $blg_n;
}

function blog_related(string $blg_slug, int $blg_n = 3): array {
    $blg_me = blog_post($blg_slug);
    if (!$blg_me) return [];
    $blg_scored = [];
    foreach (blog_posts() as $blg_k => $blg_p) {
        if ($blg_k === $blg_slug) continue;
        $blg_s = count(array_intersect($blg_p['tags'] ?? [], $blg_me['tags'] ?? [])) * 2
               + count(array_intersect($blg_p['disciplines'] ?? [], $blg_me['disciplines'] ?? []))
               + ((($blg_p['industry'] ?? '') !== '' && ($blg_p['industry'] ?? '') === ($blg_me['industry'] ?? '')) ? 1 : 0)
               + ((($blg_p['series'] ?? '') !== '' && ($blg_p['series'] ?? '') === ($blg_me['series'] ?? '')) ? 2 : 0);
        $blg_scored[$blg_k] = $blg_s;
    }
    arsort($blg_scored);
    $blg_out = [];
    foreach (array_slice(array_keys($blg_scored), 0, $blg_n) as $blg_k) $blg_out[] = blog_post($blg_k);
    return $blg_out;
}

function blog_neighbours(string $blg_slug): array {
    $blg_keys = array_keys(blog_posts());
    $blg_at = array_search($blg_slug, $blg_keys, true);
    if ($blg_at === false) return ['prev' => null, 'next' => null];
    return [
        'prev' => $blg_at > 0 ? blog_post($blg_keys[$blg_at - 1]) : null,                       // newer
        'next' => $blg_at < count($blg_keys) - 1 ? blog_post($blg_keys[$blg_at + 1]) : null,    // older
    ];
}

/* ---------- inline text ------------------------------------------------------------------------ */

/** Escape, then allow *emphasis*, `code` and [label](page.php) — nothing else. */
function blog_inline(string $blg_s): string {
    $blg_out = e($blg_s);
    $blg_out = preg_replace_callback('~\[([^\]]+)\]\(([a-z0-9./_-]+\.php(?:#[a-z0-9-]+)?|https?://[^\s)]+|#[a-z0-9-]+)\)~i',
        function (array $blg_m): string {
            $blg_href = html_entity_decode($blg_m[2], ENT_QUOTES, 'UTF-8');
            $blg_ext  = preg_match('~^https?://~i', $blg_href);
            return '<a class="blg-a" href="' . e(xe_url($blg_href)) . '"'
                 . ($blg_ext ? ' target="_blank" rel="noopener"' : '') . '>' . $blg_m[1] . '</a>';
        }, $blg_out);
    $blg_out = preg_replace('~`([^`]+)`~', '<code class="blg-code">$1</code>', $blg_out);
    $blg_out = preg_replace('~(?<![\w*])\*([^*\n]+)\*(?![\w*])~', '<em>$1</em>', $blg_out);
    return $blg_out;
}

/* ---------- the body blocks --------------------------------------------------------------------- */

/**
 * Echo a list of body blocks. $o:
 *   'id_prefix'  prefix for heading ids ('sec' for an article, 'ap' for a case-study appendix)
 *   'start'      the index the first heading takes, so ids match the contents list
 */
function blog_blocks(array $blg_blocks, array $blg_o = []): void {
    $blg_pre = $blg_o['id_prefix'] ?? 'sec';
    $blg_i   = (int) ($blg_o['start'] ?? 0);

    foreach ($blg_blocks as $blg_b) {
        $blg_t = $blg_b[0] ?? '';
        $blg_v = $blg_b[1] ?? '';
        switch ($blg_t) {

        case 'lede':
            echo '<p class="blg-lede">' . blog_inline($blg_v) . "</p>\n";
            break;

        case 'h':
            echo '<h2 class="blg-h2" id="' . e($blg_pre . '-' . $blg_i) . '">'
               . '<span class="blg-h2__n" aria-hidden="true">' . e(str_pad((string) ($blg_i + 1), 2, '0', STR_PAD_LEFT)) . '</span>'
               . e($blg_v) . "</h2>\n";
            $blg_i++;
            break;

        case 'p':
            echo '<p class="blg-p">' . blog_inline($blg_v) . "</p>\n";
            break;

        case 'ul':
            echo '<ul class="blg-ul">';
            foreach ($blg_v as $blg_li) echo '<li>' . blog_inline($blg_li) . '</li>';
            echo "</ul>\n";
            break;

        case 'ol':
            echo '<ol class="blg-ol">';
            foreach ($blg_v as $blg_li) echo '<li>' . blog_inline($blg_li) . '</li>';
            echo "</ol>\n";
            break;

        case 'steps':
            echo '<ol class="blg-steps">';
            foreach ($blg_v as $blg_n => $blg_st) {
                echo '<li class="blg-steps__i"><span class="blg-steps__n" aria-hidden="true">' . e(str_pad((string) ($blg_n + 1), 2, '0', STR_PAD_LEFT)) . '</span>'
                   . '<h3 class="blg-steps__t">' . e($blg_st[0]) . '</h3>'
                   . '<p class="blg-steps__d">' . blog_inline($blg_st[1]) . '</p></li>';
            }
            echo "</ol>\n";
            break;

        case 'defs':
            echo '<dl class="blg-defs">';
            foreach ($blg_v as $blg_row) {
                echo '<div class="blg-defs__r"><dt>' . e($blg_row[0]) . '</dt><dd>' . blog_inline($blg_row[1]) . '</dd></div>';
            }
            echo "</dl>\n";
            break;

        case 'quote':
            echo '<figure class="blg-quote"><blockquote><p>' . blog_inline($blg_v[0]) . '</p></blockquote>'
               . '<figcaption>' . e($blg_v[1]) . "</figcaption></figure>\n";
            break;

        case 'fig':
            $blg_wide = !empty($blg_v['wide']) ? ' blg-fig--wide' : '';
            echo '<figure class="blg-fig' . $blg_wide . '">'
               . '<span class="bdh-img bdh-img--r169 blg-fig__img">'
               . '<img src="' . e(xe_url('assets/imgs/blog/' . $blg_v['file'])) . '" alt="' . e($blg_v['alt']) . '"'
               . ' width="' . (int) $blg_v['w'] . '" height="' . (int) $blg_v['h'] . '" loading="lazy" decoding="async"'
               . (!empty($blg_v['pos']) ? ' style="object-position:' . e($blg_v['pos']) . '"' : '') . '>'
               . '</span>'
               . '<figcaption class="blg-fig__cap"><span class="blg-fig__t">' . blog_inline($blg_v['caption']) . '</span>'
               . '<span class="blg-fig__cr">Photograph · ' . e($blg_v['credit']) . ' · Unsplash</span>'
               . "</figcaption></figure>\n";
            break;

        case 'code':
            $blg_lines = $blg_v['lines'];
            echo '<figure class="blg-codeblock">'
               . '<figcaption class="blg-codeblock__bar"><span class="blg-codeblock__t">' . e($blg_v['title']) . '</span>'
               . '<span class="blg-codeblock__lang">' . e($blg_v['lang']) . '</span></figcaption>'
               . '<div class="bdh-scroll-x blg-codeblock__scroll" tabindex="0" role="group" aria-label="' . e($blg_v['title']) . ' — scroll sideways to read">'
               . '<pre class="blg-codeblock__pre"><code>';
            foreach ($blg_lines as $blg_n => $blg_line) {
                echo '<span class="blg-codeblock__l"><i aria-hidden="true">' . e(str_pad((string) ($blg_n + 1), 2, ' ', STR_PAD_LEFT)) . '</i>' . e($blg_line) . "</span>\n";
            }
            echo '</code></pre></div>';
            if (!empty($blg_v['note'])) echo '<p class="blg-codeblock__note">' . blog_inline($blg_v['note']) . '</p>';
            echo "</figure>\n";
            break;

        case 'data':
            echo '<figure class="blg-table">'
               . '<figcaption class="blg-table__cap"><span class="blg-table__t">' . e($blg_v['title']) . '</span>'
               . (!empty($blg_v['note']) ? '<span class="blg-table__note">' . blog_inline($blg_v['note']) . '</span>' : '')
               . '</figcaption>'
               . '<div class="bdh-scroll-x mask-x blg-table__scroll" tabindex="0" role="group" aria-label="' . e($blg_v['title']) . ' — scroll sideways to read">'
               . '<table class="blg-table__t2"><thead><tr>';
            foreach ($blg_v['head'] as $blg_th) echo '<th scope="col">' . e($blg_th) . '</th>';
            echo '</tr></thead><tbody>';
            foreach ($blg_v['rows'] as $blg_row) {
                echo '<tr>';
                foreach (array_values($blg_row) as $blg_n => $blg_td) {
                    echo $blg_n === 0 ? '<th scope="row">' . e($blg_td) . '</th>' : '<td>' . blog_inline($blg_td) . '</td>';
                }
                echo '</tr>';
            }
            echo "</tbody></table></div></figure>\n";
            break;

        case 'note':
            $blg_kind = $blg_v['kind'] ?? 'info';
            echo '<aside class="blg-note blg-note--' . e($blg_kind) . '">'
               . '<p class="blg-note__k">' . e($blg_kind === 'warn' ? 'Watch this' : ($blg_kind === 'check' ? 'Worth knowing' : 'Note')) . '</p>'
               . '<h3 class="blg-note__t">' . e($blg_v['title']) . '</h3>'
               . '<p class="blg-note__d">' . blog_inline($blg_v['text']) . "</p></aside>\n";
            break;

        case 'key':
            echo '<aside class="blg-key"><p class="blg-key__k">Takeaways</p><h3 class="blg-key__t">' . e($blg_v['title']) . '</h3><ol class="blg-key__l">';
            foreach ($blg_v['items'] as $blg_n => $blg_it) {
                echo '<li><span class="blg-key__n" aria-hidden="true">' . e(str_pad((string) ($blg_n + 1), 2, '0', STR_PAD_LEFT)) . '</span>' . blog_inline($blg_it) . '</li>';
            }
            echo "</ol></aside>\n";
            break;

        case 'formula':
            echo '<figure class="blg-formula"><p class="blg-formula__e">' . e($blg_v['expr']) . '</p><dl class="blg-formula__t">';
            foreach ($blg_v['terms'] as $blg_term) {
                echo '<div><dt>' . e($blg_term[0]) . '</dt><dd>' . blog_inline($blg_term[1]) . '</dd></div>';
            }
            echo '</dl>';
            if (!empty($blg_v['note'])) echo '<figcaption class="blg-formula__n">' . blog_inline($blg_v['note']) . '</figcaption>';
            echo "</figure>\n";
            break;

        case 'stack':
            if (function_exists('xt_stack')) {
                echo '<div class="blg-stack"><p class="blg-k">Technologies we work with</p>'
                   . xt_stack($blg_v, ['variant' => 'chips', 'label' => 'Technologies referenced in this post'])
                   . "</div>\n";
            }
            break;

        case 'badges':
            if (function_exists('xt_badge')) {
                echo '<div class="blg-badges"><p class="blg-k">Frameworks this work is built to</p><ul class="blg-badges__l">';
                foreach ($blg_v as $blg_key) echo xt_badge($blg_key, ['variant' => 'chip', 'tag' => 'li']);
                echo '</ul><p class="blg-badges__n">Frameworks delivery is built to, not certifications held.</p>' . "</div>\n";
            }
            break;

        case 'links':
            echo '<nav class="blg-links" aria-label="Related pages on this site"><p class="blg-k">Where this connects</p><ul class="blg-links__l">';
            foreach ($blg_v as $blg_row) {
                echo '<li><a class="blg-links__a" href="' . e(xe_url($blg_row[1])) . '">'
                   . '<span class="blg-links__t">' . e($blg_row[0]) . '</span>'
                   . '<span class="blg-links__d">' . e($blg_row[2]) . '</span>'
                   . '<span class="blg-links__i" aria-hidden="true">›</span></a></li>';
            }
            echo "</ul></nav>\n";
            break;
        }
    }
}

/* ---------- structured data --------------------------------------------------------------------- */

function blog_org(): array {
    $blg_site = $GLOBALS['SITE'] ?? require dirname(__DIR__, 2) . '/data/site.php';
    return [
        '@type' => 'Organization',
        'name'  => $blg_site['company']['name'],
        'url'   => blog_abs('index.php'),
        'logo'  => ['@type' => 'ImageObject', 'url' => blog_abs('assets/brand/icon-512.png')],
    ];
}

/** BlogPosting for an article; Article with a case-study genre for a case study. Plus a breadcrumb. */
function blog_jsonld_post(array $blg_p): string {
    $blg_case = $blg_p['type'] === 'case-study';
    $blg_url  = blog_abs('blog/' . $blg_p['slug'] . '.php');
    $blg_tags = array_map(fn (string $blg_k): string => blog_data()['tags'][$blg_k] ?? $blg_k, $blg_p['tags'] ?? []);
    $blg_disc = array_map(fn (string $blg_k): string => blog_disciplines()[$blg_k]['name'] ?? $blg_k, $blg_p['disciplines'] ?? []);

    $blg_node = [
        '@type'            => $blg_case ? 'Article' : 'BlogPosting',
        '@id'              => $blg_url . '#post',
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $blg_url],
        'url'              => $blg_url,
        'headline'         => mb_substr($blg_p['title'], 0, 110),
        'description'      => $blg_p['dek'],
        'inLanguage'       => 'en',
        'datePublished'    => $blg_p['iso'],
        'dateModified'     => $blg_p['updated'] ?? $blg_p['iso'],
        'author'           => blog_org(),
        'publisher'        => blog_org(),
        'image'            => [blog_abs('assets/imgs/blog/' . $blg_p['cover']['file'])],
        'wordCount'        => $blg_p['words'],
        'timeRequired'     => 'PT' . $blg_p['minutes'] . 'M',
        'keywords'         => implode(', ', $blg_tags),
        'articleSection'   => $blg_disc ? $blg_disc[0] : 'Technology & Intelligence',
        'about'            => array_map(fn (string $blg_n): array => ['@type' => 'Thing', 'name' => $blg_n], $blg_disc),
        'isPartOf'         => ['@type' => 'Blog', '@id' => blog_abs('blog/index.php') . '#blog'],
    ];
    if ($blg_case) {
        $blg_node['genre'] = 'Case study';
        /* the seed entries are illustrations, and the structured data has to say so too */
        if (!empty($blg_p['placeholder'])) $blg_node['creativeWorkStatus'] = 'Illustrative example, not a client engagement';
    }

    $blg_crumbs = [
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home',    'item' => blog_abs('index.php')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Journal', 'item' => blog_abs('blog/index.php')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $blg_p['title'], 'item' => $blg_url],
        ],
    ];

    return json_encode(['@context' => 'https://schema.org', '@graph' => [$blg_node, $blg_crumbs]],
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

/** The Blog itself, with every post that has a page. */
function blog_jsonld_index(array $blg_posts): string {
    $blg_items = [];
    foreach ($blg_posts as $blg_p) {
        if (!$blg_p['live']) continue;
        $blg_items[] = array_filter([
            '@type'         => $blg_p['type'] === 'case-study' ? 'Article' : 'BlogPosting',
            '@id'           => blog_abs('blog/' . $blg_p['slug'] . '.php') . '#post',
            'url'           => blog_abs('blog/' . $blg_p['slug'] . '.php'),
            'headline'      => mb_substr($blg_p['title'], 0, 110),
            'description'   => $blg_p['dek'],
            'datePublished' => $blg_p['iso'],
            'dateModified'  => $blg_p['updated'] ?? $blg_p['iso'],
            'image'         => blog_abs('assets/imgs/blog/' . $blg_p['cover']['file']),
            'author'        => blog_org(),
            'genre'         => $blg_p['type'] === 'case-study' ? 'Case study' : null,
        ], fn ($blg_v) => $blg_v !== null);
    }
    return json_encode([
        '@context'    => 'https://schema.org',
        '@type'       => 'Blog',
        '@id'         => blog_abs('blog/index.php') . '#blog',
        'url'         => blog_abs('blog/index.php'),
        'name'        => 'The Journal — Xterra Edze',
        'description' => 'Written notes on the work: articles on how we build, and case studies of what changed.',
        'inLanguage'  => 'en',
        'publisher'   => blog_org(),
        'blogPost'    => $blg_items,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

}
