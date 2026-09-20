<?php
/**
 * Technology & Intelligence — the shared kit. Safe to require_once from any page or partial
 * (every function is guarded). Needs partials/init.php first (e(), xe_url()). Styles:
 * assets/css/tech/kit.css (load after assets/css/brand/hub.css). All output is escaped.
 *
 * LOGOS  (data/tech-stack.php, monochrome Simple Icons SVGs, licence notes in assets/tech/logos/LICENSE.md)
 *   xt_tech(string $slug): ?array            ['slug','name','category','file'] or null when unknown
 *   xt_stack_data(): array                   the whole library, slug => [...]
 *   xt_categories(): array                   category key => label, in display order
 *   xt_logo(string $slug, array $o = [])     inline <svg class="xt-logo" role="img" aria-label="Name" fill="currentColor">
 *                                            or, with no licence-clean file, <span class="xt-logo xt-logo--word">Name</span>
 *        $o: size    int px (sets width/height; default: CSS 1.25em via .xt-logo)
 *            label   true → wraps as <span class="xt-lg">logo <span class="xt-lg__n">Name</span></span> (svg becomes aria-hidden)
 *            hidden  true → aria-hidden decorative logo (use when the name is printed beside it)
 *            class   extra classes
 *   xt_stack(array $slugs, array $o = [])    a list of technologies
 *        $o: variant 'chips' (default; pill: logo + name) · 'tiles' (square-ish card: logo, name, category)
 *                    · 'logos' (logo only, name as the accessible label, tooltip via title) · 'row' (one nowrap line of logo + name)
 *            marquee true (row only) → wraps in .xt-marquee with a duplicated aria-hidden copy; scrolls only while
 *                    on screen via [data-bdh-live] (needs assets/js/brand/hub.js), paused on hover; static under reduced motion
 *            speed   seconds per loop for the marquee (default 60)
 *            cat     true (tiles) → show the category label
 *            size    logo px (chips 18, tiles 28, logos 24, row 20)
 *            label   aria-label for the list (default "Technologies")
 *            class   extra classes on the list (or marquee wrapper)
 *
 * ICONS  24px line icons, stroke 1.5, currentColor; parts with class "a" take the blue accent in CSS
 *   xt_icon(string $name, array $o = [])     <svg class="xt-ico"> · $o: size int px · label string (role="img" + aria-label;
 *                                            otherwise aria-hidden) · mono true (no blue accent) · class
 *   xt_icons(): array                        every icon name
 *
 * STANDARDS  code-built badges. Never official seals or logos. Frame as "frameworks we build to / align delivery with";
 *            never claim Xterra Edze holds a certification without a PLACEHOLDER comment above it.
 *   xt_standards(): array                    key => ['code','name','body','kind','covers','apply','mark','sub','shape']
 *   xt_standard(string $key): ?array
 *   xt_badge(string $key, array $o = [])     <span class="xt-badge xt-badge--seal|shield|hex|chip">
 *        $o: variant 'seal' | 'shield' | 'hex' (default: the standard's own shape) · 'chip' (compact inline pill)
 *            detail  true → adds the "covers" line · apply true → adds the "how we apply it" line
 *            tag     wrapper element: 'span' (default), 'li', 'div'
 *            class   extra classes
 */

if (!function_exists('xt_logo')) {

function xt_stack_data(): array {
    static $S = null;
    if ($S === null) { $S = require __DIR__ . '/../../data/tech-stack.php'; }
    return $S;
}

function xt_categories(): array {
    return [
        'languages'     => 'Languages & runtimes',
        'frontend'      => 'Web & frontend',
        'mobile'        => 'Mobile',
        'backend'       => 'Backend & APIs',
        'data'          => 'Data, analytics & streaming',
        'ai-ml'         => 'AI & ML frameworks',
        'llm'           => 'Model providers',
        'ai-tooling'    => 'Agents, retrieval & evals',
        'cloud'         => 'Cloud & edge',
        'devops'        => 'Containers, IaC & CI/CD',
        'observability' => 'Observability',
        'quality'       => 'Testing & quality',
        'security'      => 'Security & identity',
        'integration'   => 'Integration & messaging',
        'business'      => 'CRM, commerce & payments',
        'search'        => 'Search, SEO & analytics',
        'content'       => 'CMS & content',
        'collaboration' => 'Collaboration & design',
    ];
}

function xt_tech(string $slug): ?array {
    $S = xt_stack_data();
    return isset($S[$slug]) ? ['slug' => $slug] + $S[$slug] : null;
}

/** Parse a Simple Icons file once: viewBox + drawable markup (title and outer svg removed). */
function xt__svg_body(string $file): ?array {
    static $C = [];
    if (array_key_exists($file, $C)) return $C[$file];
    $path = __DIR__ . '/../../' . $file;
    if (!is_file($path)) return $C[$file] = null;
    $raw = (string) file_get_contents($path);
    $vb  = preg_match('~viewBox="([0-9.\s-]+)"~', $raw, $m) ? trim($m[1]) : '0 0 24 24';
    $in  = preg_replace(['~^.*?<svg[^>]*>~s', '~</svg>\s*$~s', '~<title>.*?</title>~s'], '', $raw);
    // keep only drawing elements with geometry; drop any inline fill so currentColor wins
    preg_match_all('~<(path|circle|rect|polygon|ellipse)\b[^>]*/?>~', $in, $els);
    $body = '';
    foreach ($els[0] as $el) { $body .= preg_replace('~\s(fill|style|class)="[^"]*"~', '', $el); }
    return $C[$file] = $body === '' ? null : ['vb' => $vb, 'body' => $body];
}

function xt_logo(string $slug, array $o = []): string {
    $t     = xt_tech($slug);
    $name  = $t['name'] ?? ucwords(str_replace(['dotjs', '-', '_'], ['.js', ' ', ' '], $slug));
    $class = trim('xt-logo ' . ($o['class'] ?? ''));
    $size  = !empty($o['size']) ? (int) $o['size'] : 0;
    $label = !empty($o['label']);
    $hide  = !empty($o['hidden']) || $label;
    $svg   = !empty($t['file']) ? xt__svg_body($t['file']) : null;

    if ($svg) {
        $dim  = $size ? ' width="' . $size . '" height="' . $size . '"' : '';
        $a11y = $hide ? ' aria-hidden="true"' : ' role="img" aria-label="' . e($name) . '"';
        $mark = '<svg class="' . e($class) . '" viewBox="' . e($svg['vb']) . '"' . $dim . ' fill="currentColor"' . $a11y
              . ' focusable="false" data-tech="' . e($slug) . '">' . $svg['body'] . '</svg>';
    } else {
        // No licence-clean mark: a plain mono wordmark. The text itself is the accessible name.
        // a wordmark sits at about half the logo box so it lines up optically with neighbouring marks
        $style = $size ? ' style="--xt-word:' . max(10, (int) round($size * 0.5)) . 'px"' : '';
        $mark  = '<span class="' . e($class . ' xt-logo--word') . '"' . $style . ($label ? ' aria-hidden="true"' : '') . ' data-tech="' . e($slug) . '">' . e($name) . '</span>';
        if ($label) return '<span class="xt-lg xt-lg--word"><span class="xt-lg__n">' . e($name) . '</span></span>';
        return $mark;
    }
    if ($label) return '<span class="xt-lg">' . $mark . '<span class="xt-lg__n">' . e($name) . '</span></span>';
    return $mark;
}

function xt_stack(array $slugs, array $o = []): string {
    $variant = in_array($o['variant'] ?? 'chips', ['chips', 'tiles', 'logos', 'row'], true) ? ($o['variant'] ?? 'chips') : 'chips';
    $sizes   = ['chips' => 18, 'tiles' => 28, 'logos' => 24, 'row' => 20];
    $size    = !empty($o['size']) ? (int) $o['size'] : $sizes[$variant];
    $cats    = xt_categories();
    $label   = $o['label'] ?? 'Technologies';
    $marquee = $variant === 'row' && !empty($o['marquee']);

    $items = '';
    foreach ($slugs as $slug) {
        $t    = xt_tech((string) $slug);
        $name = $t['name'] ?? (string) $slug;
        $word = empty($t['file']);
        if ($variant === 'logos') {
            $items .= '<li class="xt-lo' . ($word ? ' xt-lo--word' : '') . '" title="' . e($name) . '">' . xt_logo((string) $slug, ['size' => $size]) . '</li>';
        } elseif ($variant === 'tiles') {
            $items .= '<li class="xt-tile' . ($word ? ' xt-tile--word' : '') . '">'
                    . '<span class="xt-tile__mark">' . ($word ? '<span class="xt-tile__dot" aria-hidden="true"></span>' : xt_logo((string) $slug, ['size' => $size, 'hidden' => true])) . '</span>'
                    . '<span class="xt-tile__n">' . e($name) . '</span>'
                    . (!empty($o['cat']) && $t ? '<span class="xt-tile__c">' . e($cats[$t['category']] ?? '') . '</span>' : '')
                    . '</li>';
        } else {
            $cls    = $variant === 'row' ? 'xt-ri' : 'xt-chip';
            $items .= '<li class="' . $cls . ($word ? ' ' . $cls . '--word' : '') . '">'
                    . ($word ? '<span class="' . $cls . '__dot" aria-hidden="true"></span>' : xt_logo((string) $slug, ['size' => $size, 'hidden' => true]))
                    . '<span class="' . $cls . '__n">' . e($name) . '</span></li>';
        }
    }

    $cls = 'xt-stack xt-stack--' . $variant;
    if (!$marquee) {
        return '<ul class="' . e(trim($cls . ' ' . ($o['class'] ?? ''))) . '" role="list" aria-label="' . e($label) . '">' . $items . '</ul>';
    }
    $speed = !empty($o['speed']) ? (int) $o['speed'] : 60;
    return '<div class="' . e(trim('xt-marquee mask-x mq-hold ' . ($o['class'] ?? ''))) . '" data-bdh-live>'
         . '<div class="mq mq--l xt-marquee__track" style="--mq-dur:' . $speed . 's">'
         . '<ul class="' . $cls . '" role="list" aria-label="' . e($label) . '">' . $items . '</ul>'
         . '<ul class="' . $cls . '" role="list" aria-hidden="true">' . $items . '</ul>'
         . '</div></div>';
}

/* ---------------------------------------------------------------------------------------------
   Icons — 24 × 24, stroke 1.5, round caps. class="a" = accent part, "af" = accent filled.
   --------------------------------------------------------------------------------------------- */
function xt__icon_set(): array {
    static $I = [
        // build
        'code'      => '<path d="m8 7-5 5 5 5M16 7l5 5-5 5"/><path class="a" d="m13.5 5-3 14"/>',
        'terminal'  => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="m7 9.5 3 2.5-3 2.5"/><path class="a" d="M12.5 15H17"/>',
        'api'       => '<path d="M8 4.5H6.5a2 2 0 0 0-2 2v3L3 12l1.5 2.5v3a2 2 0 0 0 2 2H8M16 4.5h1.5a2 2 0 0 1 2 2v3L21 12l-1.5 2.5v3a2 2 0 0 1-2 2H16"/><path class="a" stroke-width="2.2" d="M9 12h.01M12 12h.01M15 12h.01"/>',
        'browser'   => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="M3 9h18M6 6.8h.01M8.5 6.8h.01"/><path class="a" d="M7 13h6M7 16h9"/>',
        'mobile'    => '<rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M10.5 5.5h3"/><path class="a" d="M10.5 18.5h3"/>',
        'git-branch'=> '<circle cx="6.5" cy="5.5" r="2"/><circle cx="6.5" cy="18.5" r="2"/><path d="M6.5 7.5v9M17.5 10.5c0 4-11 2.5-11 6"/><circle class="a" cx="17.5" cy="8.5" r="2"/>',
        'layers'    => '<path d="M12 4 21 8.5 12 13 3 8.5z"/><path d="m3 12.5 9 4.5 9-4.5"/><path class="a" d="m3 16.5 9 4.5 9-4.5"/>',
        'stack'     => '<rect x="4" y="3.5" width="16" height="4.5" rx="1.5"/><rect x="4" y="9.75" width="16" height="4.5" rx="1.5"/><rect class="a" x="4" y="16" width="16" height="4.5" rx="1.5"/>',
        'cube'      => '<path d="M12 3 20 7.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/><path class="a" d="m8 5.3 8 4.5"/>',
        'puzzle'    => '<path d="M4 8h4a2 2 0 1 1 4 0h4v4a2 2 0 1 1 0 4v4h-4a2 2 0 1 0-4 0H4v-4a2 2 0 1 0 0-4z"/><circle class="a af" cx="10" cy="14" r="1.3"/>',
        'rocket'    => '<path d="M12 3c3 2 5 5.5 5 9.5V17H7v-4.5C7 8.5 9 5 12 3z"/><path d="M7 13 4 15.5V19l3-2M17 13l3 2.5V19l-3-2"/><circle cx="12" cy="10" r="1.8"/><path class="a" d="M10.5 19.5V21M13.5 19.5V21"/>',
        'rollback'  => '<path d="M4 4.5v5h5"/><path d="M4.6 9.5A8 8 0 1 1 4 13.5"/><path class="a" d="M12 8v4.5l3 1.5"/>',
        // data + infrastructure
        'database'  => '<ellipse cx="12" cy="6" rx="7.5" ry="2.5"/><path d="M4.5 6v12c0 1.4 3.4 2.5 7.5 2.5s7.5-1.1 7.5-2.5V6"/><path class="a" d="M4.5 12c0 1.4 3.4 2.5 7.5 2.5s7.5-1.1 7.5-2.5"/>',
        'server'    => '<rect x="3.5" y="4" width="17" height="7" rx="2"/><rect x="3.5" y="13" width="17" height="7" rx="2"/><path d="M7 7.5h.01M7 16.5h.01"/><path class="a" d="M11 7.5h6M11 16.5h6"/>',
        'cloud'     => '<path d="M7 18.5a4.5 4.5 0 0 1-.6-8.96A6 6 0 0 1 18 9.5a4.5 4.5 0 0 1-1 9z"/><path class="a" d="M9.5 14.5h5"/>',
        'gpu'       => '<rect x="2.5" y="5.5" width="19" height="11.5" rx="2"/><circle cx="9" cy="11.25" r="3.25"/><path d="M4.5 17v2.5M8 17v2.5M11.5 17v2.5"/><path class="a" d="M15.5 9h3M15.5 11.25h3M15.5 13.5h3"/><circle class="a af" cx="9" cy="11.25" r="1"/>',
        'chip'      => '<rect x="6" y="6" width="12" height="12" rx="2"/><path d="M9.5 3v3M14.5 3v3M9.5 18v3M14.5 18v3M3 9.5h3M3 14.5h3M18 9.5h3M18 14.5h3"/><rect class="a" x="9.5" y="9.5" width="5" height="5" rx="1"/>',
        'container' => '<rect x="3" y="6.5" width="18" height="11" rx="1.5"/><path d="M7 9.5v5M10.5 9.5v5M14 9.5v5"/><path class="a" d="M17.5 9.5v5"/>',
        'cluster'   => '<circle cx="12" cy="5.5" r="2.5"/><circle cx="5.5" cy="17" r="2.5"/><circle class="a" cx="18.5" cy="17" r="2.5"/><path d="M10.8 7.7 6.7 14.8M13.2 7.7l4.1 7.1M8 17h8"/>',
        'network'   => '<rect x="9" y="3" width="6" height="5" rx="1"/><rect x="3" y="16" width="6" height="5" rx="1"/><rect class="a" x="15" y="16" width="6" height="5" rx="1"/><path d="M12 8v4M6 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2"/>',
        'edge'      => '<circle cx="12" cy="12" r="8.5" stroke-dasharray="2 2.6"/><circle cx="12" cy="12" r="2.5"/><circle class="a af" cx="12" cy="3.5" r="1.6"/><circle class="a af" cx="19.4" cy="16.3" r="1.6"/><circle class="a af" cx="4.6" cy="16.3" r="1.6"/>',
        'pipeline'  => '<circle cx="4.5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle class="a" cx="19.5" cy="12" r="2"/><path d="M6.5 12H10M14 12h3.5"/><path d="M3 6.5h18M3 17.5h18" stroke-dasharray="1.5 2.5"/>',
        'queue'     => '<rect x="2.5" y="8" width="4" height="8" rx="1"/><rect x="8" y="8" width="4" height="8" rx="1"/><rect x="13.5" y="8" width="4" height="8" rx="1"/><path class="a" d="m19.5 9.5 2.5 2.5-2.5 2.5"/>',
        'vector'    => '<path d="M4 4v16h16"/><circle cx="9" cy="7" r="1.2"/><circle cx="17.5" cy="15.5" r="1.2"/><circle cx="13" cy="17" r="1.2"/><path class="a" d="M4 20 16 8M11 8h5v5"/>',
        'sync'      => '<path d="M19.5 9A8 8 0 0 0 5 7.5M4.5 15A8 8 0 0 0 19 16.5"/><path d="M5 3.5v4h4"/><path class="a" d="M19 20.5v-4h-4"/>',
        'plug'      => '<path d="M9 3v4.5M15 3v4.5"/><path d="M6.5 7.5h11v3a5.5 5.5 0 0 1-11 0z"/><path class="a" d="M12 16v5"/>',
        'link'      => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path class="a" d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
        'workflow'  => '<rect x="3" y="3.5" width="7" height="5" rx="1.5"/><rect x="14" y="9.5" width="7" height="5" rx="1.5"/><rect class="a" x="3" y="15.5" width="7" height="5" rx="1.5"/><path d="M10 6h4.5a3 3 0 0 1 3 3v.5M17.5 14.5v1a3 3 0 0 1-3 3H10"/>',
        // AI
        'agent'     => '<rect x="4.5" y="7.5" width="15" height="11" rx="3"/><path d="M12 5v2.5M2.5 12v3M21.5 12v3"/><circle cx="12" cy="3.8" r="1.2"/><path class="a" d="M9 12v1.5M15 12v1.5"/>',
        'brain'     => '<path d="M12 5.5A3 3 0 0 0 6.5 7a3 3 0 0 0-2 4.9 3 3 0 0 0 1.4 5A3 3 0 0 0 12 18.5z"/><path d="M12 5.5A3 3 0 0 1 17.5 7a3 3 0 0 1 2 4.9 3 3 0 0 1-1.4 5A3 3 0 0 1 12 18.5"/><path class="a" d="M12 5.5v13M8.5 10.5h1.5M14 13.5h1.5"/>',
        'sparkle'   => '<path d="M12 3.5 13.8 9a2 2 0 0 0 1.2 1.2l5.5 1.8-5.5 1.8a2 2 0 0 0-1.2 1.2L12 20.5 10.2 15a2 2 0 0 0-1.2-1.2L3.5 12 9 10.2A2 2 0 0 0 10.2 9z"/><path class="a" d="M19 2.5v4M17 4.5h4"/>',
        'prompt'    => '<path d="M4 5.5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2V15a2 2 0 0 1-2 2h-7l-4.5 3.5V17H6a2 2 0 0 1-2-2z"/><path d="m8 8.2 2.5 2.1L8 12.4"/><path class="a" d="M12.5 12.5H16"/>',
        'chat'      => '<path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 3.5V17A2.5 2.5 0 0 1 4 14.5z"/><path class="a" d="M8.5 9h7M8.5 12.5h4.5"/>',
        'voice'     => '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0M12 17.5V21"/><path class="a" d="M9 21h6"/>',
        'vision'    => '<path d="M3.5 8V5.5a2 2 0 0 1 2-2H8M16 3.5h2.5a2 2 0 0 1 2 2V8M20.5 16v2.5a2 2 0 0 1-2 2H16M8 20.5H5.5a2 2 0 0 1-2-2V16"/><path d="M6.5 12S8.5 8.5 12 8.5s5.5 3.5 5.5 3.5-2 3.5-5.5 3.5-5.5-3.5-5.5-3.5z"/><circle class="a af" cx="12" cy="12" r="1.5"/>',
        'eval'      => '<path d="M9 3.5h6M10 3.5v6L4.8 18.3a1.5 1.5 0 0 0 1.3 2.2h11.8a1.5 1.5 0 0 0 1.3-2.2L14 9.5v-6"/><path class="a" d="m9.2 15.3 2 2 3.8-4"/>',
        'approve'   => '<circle cx="9.5" cy="8" r="3.5"/><path d="M3 20c0-3.6 2.9-6 6.5-6 1.4 0 2.7.4 3.8 1"/><path class="a" d="m15 18 2 2 4-4.5"/>',
        'lightbulb' => '<path d="M9.5 17.5h5M10.5 21h3"/><path d="M8.5 14.5a6 6 0 1 1 7 0c-.6.5-1 1.2-1 2v1h-5v-1c0-.8-.4-1.5-1-2z"/><path class="a" d="m12.5 7.5-2 3.5h3l-2 3.5"/>',
        // security + trust
        'shield'    => '<path d="M12 3 19.5 6v5.5c0 4.5-3.2 8-7.5 9.5-4.3-1.5-7.5-5-7.5-9.5V6z"/><path class="a" d="m8.8 12 2.3 2.3L15.5 10"/>',
        'lock'      => '<rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5v-3a4 4 0 0 1 8 0v3"/><path class="a" d="M12 14.5v2.5"/>',
        'key'       => '<circle cx="8" cy="15" r="4"/><path d="m11 12 8.5-8.5M16.5 6.5 19 9M14 9l2 2"/><circle class="a af" cx="8" cy="15" r="1.1"/>',
        'fingerprint'=> '<path d="M6.3 7.2A7 7 0 0 1 19 11.5v1.5"/><path d="M5 11.5v1.5a10 10 0 0 0 1.4 5"/><path d="M9.3 20.5A11 11 0 0 1 8 15v-3.5a4 4 0 0 1 8 0V14"/><path class="a" d="M12 11.5V15a8.5 8.5 0 0 0 2 5.5"/><path d="M16.8 17.5a12 12 0 0 1-.4 3"/>',
        'eye'       => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/><circle class="a" cx="12" cy="12" r="3"/>',
        'bug'       => '<rect x="7" y="8" width="10" height="12.5" rx="5"/><path d="M9.5 8V6.5a2.5 2.5 0 0 1 5 0V8M3.5 13.5H7M17 13.5h3.5M4.5 8.5 7 10M19.5 8.5 17 10M4.5 19 7 17.5M19.5 19 17 17.5"/><path class="a" d="M12 11.5v6"/>',
        'alert'     => '<path d="M10.3 4.3 2.8 17.5a2 2 0 0 0 1.7 3h15a2 2 0 0 0 1.7-3L13.7 4.3a2 2 0 0 0-3.4 0z"/><path class="a" d="M12 9.5V14M12 17h.01"/>',
        'scan'      => '<path d="M4 8V5.5A1.5 1.5 0 0 1 5.5 4H8M16 4h2.5A1.5 1.5 0 0 1 20 5.5V8M20 16v2.5a1.5 1.5 0 0 1-1.5 1.5H16M8 20H5.5A1.5 1.5 0 0 1 4 18.5V16"/><path class="a" d="m8.5 12.2 2.4 2.3 4.6-5"/>',
        'radar'     => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><path class="a" d="m12 12 6-6"/><circle class="a af" cx="15" cy="14.5" r="1.1"/>',
        'clipboard-check' => '<rect x="5" y="4.5" width="14" height="16.5" rx="2"/><rect x="9" y="3" width="6" height="3" rx="1"/><path class="a" d="m9 13 2 2 4-4.5"/>',
        'accessibility' => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="7.3" r="1.2"/><path d="M12 10.2v3.8l-2.6 3.8M12 14l2.6 3.8"/><path class="a" d="M7.5 10.2h9"/>',
        // operate + measure
        'gauge'     => '<path d="M4 16a8 8 0 1 1 16 0"/><path d="M4 19.5h16"/><path class="a" d="m12 16 3.8-4.8"/>',
        'chart'     => '<path d="M3.5 3.5v17h17"/><path d="M7.5 16v-4M11.5 16V8M15.5 16v-6"/><path class="a" d="M19.5 16V5.5"/>',
        'trend-up'  => '<path d="M3 17.5 9 11.5l4 4 8-8"/><path class="a" d="M15 7.5h6v6"/>',
        'dashboard' => '<rect x="3" y="3.5" width="18" height="17" rx="2"/><path d="M3 9h18M9 9v11.5"/><path class="a" d="m12 17 2.5-3 2 1.5 2.5-3.5"/>',
        'log'       => '<rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M7.5 8h1M11 8h5.5M7.5 12h1M11 12h5.5M7.5 16h1"/><path class="a" d="M11 16h3.5"/>',
        'uptime'    => '<path d="M3 12h4l2.5-6 5 12 2.5-6"/><path class="a" d="M17 12h4"/>',
        'latency'   => '<circle cx="13.5" cy="13.5" r="7"/><path d="M13.5 3.5v3M11 3.5h5M2 10h3M1.5 14h2.5M2 18h3"/><path class="a" d="m13.5 13.5 3-3"/>',
        'cost'      => '<ellipse cx="9" cy="6.5" rx="5.5" ry="2.5"/><path d="M3.5 6.5v5c0 1.4 2.5 2.5 5.5 2.5s5.5-1.1 5.5-2.5v-5M3.5 11.5v5C3.5 17.9 6 19 9 19c1 0 2-.1 2.8-.4"/><path class="a" d="M18 9v7.5M15 13.5l3 3 3-3"/>',
        'clock'     => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="M12 7.5V12l3 2"/>',
        'calendar'  => '<rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/><path class="a" d="M8 14h3"/>',
        'bolt'      => '<path d="M13 3 5 13.5h6L11 21l8-10.5h-6z"/><path class="a" d="M11 13.5 11 21"/>',
        'leaf'      => '<path d="M4.5 19.5C4.5 10 10 4.5 19.5 4.5c0 9.5-5.5 15-15 15z"/><path class="a" d="M4.5 19.5 13 11"/>',
        'filter'    => '<path d="M3.5 5h17l-6.5 7.5v6l-4 2v-8z"/><path class="a" d="M7 8.5h10"/>',
        'search'    => '<circle cx="10.5" cy="10.5" r="6.5"/><path class="a" d="m15.5 15.5 5 5"/>',
        'globe'     => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5C9.7 5.8 8.5 8.7 8.5 12s1.2 6.2 3.5 8.5"/><path class="a" d="M12 3.5c2.3 2.3 3.5 5.2 3.5 8.5s-1.2 6.2-3.5 8.5"/>',
        'pin'       => '<path d="M12 21s-6.5-5.6-6.5-11a6.5 6.5 0 0 1 13 0c0 5.4-6.5 11-6.5 11z"/><circle class="a" cx="12" cy="10" r="2.3"/>',
        'target'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle class="a af" cx="12" cy="12" r="1.3"/>',
        'flag'      => '<path d="M5 21V3.5"/><path class="a" d="M5 4.5h12l-2.5 4 2.5 4H5"/>',
        'compass'   => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="m15.5 8.5-2 5-5 2 2-5z"/>',
        'doc'       => '<path d="M6 3.5h8l4 4v13H6z"/><path d="M14 3.5v4h4"/><path class="a" d="M9 12h6M9 15.5h4"/>',
        'check'     => '<rect x="3.5" y="3.5" width="17" height="17" rx="4"/><path class="a" d="m8 12.3 2.8 2.7L16 9"/>',
        // people + support
        'users'     => '<circle cx="9" cy="8.5" r="3"/><path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle class="a" cx="17" cy="9.5" r="2.3"/><path class="a" d="M16.8 14c2.4 0 4.2 1.8 4.2 4.5"/>',
        'handshake' => '<path d="M2.5 12.5 7 8l3.5-1 1.5 1"/><path d="M21.5 12.5 17 8l-3.5-1-4 3.5a1.5 1.5 0 0 0 2 2.2L14 11l3.5 3.5"/><path class="a" d="m6 14.5 2.5 2.5a1.4 1.4 0 0 0 2-2M10 18l.8.8a1.4 1.4 0 0 0 2-2M12.8 18.8a1.4 1.4 0 0 0 2-2l2.7-2.3"/><path d="M2.5 12.5 6 14.5"/>',
        'headset'   => '<path d="M4 14v-2a8 8 0 0 1 16 0v2"/><rect x="3" y="13" width="4" height="6" rx="1.5"/><rect x="17" y="13" width="4" height="6" rx="1.5"/><path class="a" d="M19 19c0 1.5-2 2.5-5 2.5"/>',
        'wrench'    => '<path d="M20.5 7.5a4.5 4.5 0 0 1-6.2 4.2l-8 8a2 2 0 0 1-2.8-2.8l8-8a4.5 4.5 0 0 1 5-5.4l-2.7 2.7.6 2.8 2.8.6z"/><circle class="a af" cx="4.9" cy="18.3" r=".9"/>',
        'dot'       => '<circle cx="12" cy="12" r="8.5"/><circle class="a af" cx="12" cy="12" r="2"/>',
    ];
    return $I;
}

function xt_icons(): array {
    return array_keys(xt__icon_set());
}

function xt_icon(string $name, array $o = []): string {
    $I     = xt__icon_set();
    $body  = $I[$name] ?? $I['dot'];
    $size  = !empty($o['size']) ? (int) $o['size'] : 0;
    $class = trim('xt-ico' . (!empty($o['mono']) ? ' xt-ico--mono' : '') . ' ' . ($o['class'] ?? ''));
    $dim   = $size ? ' width="' . $size . '" height="' . $size . '"' : '';
    $a11y  = !empty($o['label']) ? ' role="img" aria-label="' . e((string) $o['label']) . '"' : ' aria-hidden="true"';
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24"' . $dim . ' fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"' . $a11y . ' focusable="false">' . $body . '</svg>';
}

/* ---------------------------------------------------------------------------------------------
   Standards — the frameworks delivery is built to or aligned with. Facts only; no claims.
   'mark' = the short text drawn inside the badge; 'sub' = the small body line under it;
   'shape' = default badge shape: seal (management-system & technical standards),
   shield (security & AI-risk frameworks, laws and regulations), hex (metrics & sustainability).
   --------------------------------------------------------------------------------------------- */
function xt_standards(): array {
    static $S = [
        'iso27001' => ['code' => 'ISO/IEC 27001:2022', 'name' => 'Information security management systems', 'body' => 'ISO / IEC', 'kind' => 'Standard',
            'covers' => 'Requirements for an information security management system: risk assessment and treatment, with 93 Annex A controls across organisational, people, physical and technological themes.',
            'apply'  => 'Access reviews, change control, supplier risk and logging are built into delivery, so the evidence exists as the work ships.',
            'mark' => '27001', 'sub' => 'ISO/IEC', 'shape' => 'seal'],
        'iso27701' => ['code' => 'ISO/IEC 27701', 'name' => 'Privacy information management systems', 'body' => 'ISO / IEC', 'kind' => 'Standard',
            'covers' => 'Requirements and guidance for managing personally identifiable information as a controller or processor.',
            'apply'  => 'Data maps, retention rules and processor records kept alongside the systems that hold personal data.',
            'mark' => '27701', 'sub' => 'ISO/IEC', 'shape' => 'seal'],
        'iso42001' => ['code' => 'ISO/IEC 42001:2023', 'name' => 'Artificial intelligence management systems', 'body' => 'ISO / IEC', 'kind' => 'Standard',
            'covers' => 'Requirements for establishing, running and improving an AI management system: AI policy, impact assessment, data and lifecycle controls.',
            'apply'  => 'An AI inventory, impact assessments and lifecycle controls are part of how every model and agent is shipped.',
            'mark' => '42001', 'sub' => 'ISO/IEC', 'shape' => 'seal'],
        'iso9001' => ['code' => 'ISO 9001:2015', 'name' => 'Quality management systems', 'body' => 'ISO', 'kind' => 'Standard',
            'covers' => 'Requirements for a quality management system built on process control, risk-based thinking and continual improvement.',
            'apply'  => 'Definitions of done, peer review and release checklists that make quality repeatable rather than heroic.',
            'mark' => '9001', 'sub' => 'ISO', 'shape' => 'seal'],
        'iso14001' => ['code' => 'ISO 14001:2015', 'name' => 'Environmental management systems', 'body' => 'ISO', 'kind' => 'Standard',
            'covers' => 'Requirements for managing environmental aspects, compliance obligations and performance improvement.',
            'apply'  => 'Hosting, device and data-transfer impact recorded next to cost, with reduction targets that are reviewed.',
            'mark' => '14001', 'sub' => 'ISO', 'shape' => 'seal'],
        'iso22301' => ['code' => 'ISO 22301:2019', 'name' => 'Business continuity management systems', 'body' => 'ISO', 'kind' => 'Standard',
            'covers' => 'Requirements for planning, testing and improving the ability to keep operating through disruption.',
            'apply'  => 'Recovery time and recovery point objectives set per service, then proven with restore and failover drills.',
            'mark' => '22301', 'sub' => 'ISO', 'shape' => 'seal'],
        'soc2' => ['code' => 'SOC 2', 'name' => 'Trust Services Criteria', 'body' => 'AICPA', 'kind' => 'Attestation framework',
            'covers' => 'Controls for security, availability, processing integrity, confidentiality and privacy. Type I tests design at a point in time; Type II tests operation over a period.',
            'apply'  => 'Change approvals, access logs and incident records captured automatically, ready for your auditor.',
            'mark' => 'SOC 2', 'sub' => 'AICPA', 'shape' => 'seal'],
        'nist-csf' => ['code' => 'NIST CSF 2.0', 'name' => 'Cybersecurity Framework', 'body' => 'NIST', 'kind' => 'Framework',
            'covers' => 'Six functions for managing cybersecurity risk: Govern, Identify, Protect, Detect, Respond and Recover.',
            'apply'  => 'Current and target profiles that turn security posture into a prioritised, costed roadmap.',
            'mark' => 'CSF 2.0', 'sub' => 'NIST', 'shape' => 'shield'],
        'nist-ai-rmf' => ['code' => 'NIST AI RMF 1.0', 'name' => 'AI Risk Management Framework', 'body' => 'NIST', 'kind' => 'Framework',
            'covers' => 'Four functions for trustworthy AI: Govern, Map, Measure and Manage, with a companion profile for generative AI (NIST AI 600-1).',
            'apply'  => 'Risks mapped per use case, measured with evals, and managed with named owners and release thresholds.',
            'mark' => 'AI RMF', 'sub' => 'NIST', 'shape' => 'shield'],
        'owasp-asvs' => ['code' => 'OWASP ASVS', 'name' => 'Application Security Verification Standard', 'body' => 'OWASP', 'kind' => 'Standard',
            'covers' => 'Testable security requirements for web applications and APIs, organised in three verification levels by risk.',
            'apply'  => 'Security requirements written as acceptance criteria at the level your risk profile needs, and verified in CI.',
            'mark' => 'ASVS', 'sub' => 'OWASP', 'shape' => 'shield'],
        'owasp-top10' => ['code' => 'OWASP Top 10', 'name' => 'Web application security risks', 'body' => 'OWASP', 'kind' => 'Awareness standard',
            'covers' => 'The most critical web application risks, from broken access control and injection to security misconfiguration.',
            'apply'  => 'Threat-modelled at design, scanned on every merge and tested manually before release.',
            'mark' => 'TOP 10', 'sub' => 'OWASP', 'shape' => 'shield'],
        'owasp-llm' => ['code' => 'OWASP Top 10 for LLM Applications', 'name' => 'LLM and generative AI security risks', 'body' => 'OWASP GenAI Security Project', 'kind' => 'Awareness standard',
            'covers' => 'Risks specific to LLM systems, including prompt injection (LLM01), sensitive information disclosure (LLM02), excessive agency (LLM06) and vector and embedding weaknesses (LLM08).',
            'apply'  => 'Red-team suites for prompt injection, data leakage and tool misuse run in CI before any model or agent release.',
            'mark' => 'LLM', 'sub' => 'OWASP', 'shape' => 'shield'],
        'mitre-atlas' => ['code' => 'MITRE ATLAS', 'name' => 'Adversarial Threat Landscape for AI Systems', 'body' => 'MITRE', 'kind' => 'Knowledge base',
            'covers' => 'Adversary tactics and techniques against machine-learning and AI systems, drawn from real attacks and red-team research.',
            'apply'  => 'Threat models for AI systems mapped to ATLAS techniques, then exercised in red-team tests.',
            'mark' => 'ATLAS', 'sub' => 'MITRE', 'shape' => 'shield'],
        'cis' => ['code' => 'CIS Controls v8.1', 'name' => 'Critical Security Controls and Benchmarks', 'body' => 'Center for Internet Security', 'kind' => 'Framework',
            'covers' => 'Prioritised safeguards grouped into implementation groups, plus hardening benchmarks for cloud, container and operating-system configurations.',
            'apply'  => 'Cloud accounts, clusters and images hardened to CIS Benchmarks and scanned continuously for drift.',
            'mark' => 'CIS', 'sub' => 'v8.1', 'shape' => 'shield'],
        'slsa' => ['code' => 'SLSA', 'name' => 'Supply-chain Levels for Software Artifacts', 'body' => 'OpenSSF', 'kind' => 'Framework',
            'covers' => 'Levels of assurance for how software artifacts are built, with verifiable build provenance.',
            'apply'  => 'Signed builds, provenance attestations and an SBOM in SPDX or CycloneDX for every release.',
            'mark' => 'SLSA', 'sub' => 'OpenSSF', 'shape' => 'shield'],
        'pci-dss' => ['code' => 'PCI DSS v4.0.1', 'name' => 'Payment Card Industry Data Security Standard', 'body' => 'PCI Security Standards Council', 'kind' => 'Standard',
            'covers' => 'Twelve requirements for protecting cardholder data wherever it is stored, processed or transmitted.',
            'apply'  => 'Scope reduced first, with tokenised payments and segmented networks, then controls built for what remains.',
            'mark' => 'PCI DSS', 'sub' => 'v4.0.1', 'shape' => 'shield'],
        'hipaa' => ['code' => 'HIPAA Security Rule', 'name' => 'Safeguards for electronic protected health information', 'body' => 'US HHS', 'kind' => 'Regulation',
            'covers' => 'Administrative, physical and technical safeguards for electronic protected health information (ePHI).',
            'apply'  => 'Access control, audit trails and encryption for ePHI, with business associate agreements for every processor.',
            'mark' => 'HIPAA', 'sub' => 'US HHS', 'shape' => 'shield'],
        'gdpr' => ['code' => 'GDPR', 'name' => 'General Data Protection Regulation (EU) 2016/679', 'body' => 'European Union', 'kind' => 'Regulation',
            'covers' => 'Lawful basis, data-subject rights, data protection by design and by default, breach notification and DPIAs for high-risk processing.',
            'apply'  => 'Consent, retention and data-subject request flows designed into the product, with DPIAs where the risk calls for one.',
            'mark' => 'GDPR', 'sub' => 'EU', 'shape' => 'shield'],
        'dpdp' => ['code' => 'DPDP Act 2023', 'name' => 'Digital Personal Data Protection Act, 2023', 'body' => 'Government of India', 'kind' => 'Law',
            'covers' => 'Notice and consent, duties of data fiduciaries, rights of data principals, breach intimation and added duties for significant data fiduciaries, with the DPDP Rules.',
            'apply'  => 'Consent records, notices and data-principal request handling built for India-based users from the first release.',
            'mark' => 'DPDP', 'sub' => 'India', 'shape' => 'shield'],
        'cert-in' => ['code' => 'CERT-In Directions 2022', 'name' => 'Cyber incident reporting directions', 'body' => 'CERT-In, Government of India', 'kind' => 'Regulation',
            'covers' => 'Reporting of specified cyber incidents within six hours, log retention for 180 days within India and clock synchronisation.',
            'apply'  => 'Incident runbooks, log retention and time synchronisation configured so reporting deadlines can be met.',
            'mark' => 'CERT-In', 'sub' => 'India', 'shape' => 'shield'],
        'eu-ai-act' => ['code' => 'EU AI Act', 'name' => 'Artificial Intelligence Act (EU) 2024/1689', 'body' => 'European Union', 'kind' => 'Regulation',
            'covers' => 'A risk-based regime: prohibited practices, obligations for high-risk systems, transparency duties and rules for general-purpose AI models.',
            'apply'  => 'Each use case classified by risk tier early, with transparency notices, logging and human oversight designed in.',
            'mark' => 'AI ACT', 'sub' => 'EU', 'shape' => 'shield'],
        'nis2' => ['code' => 'NIS2', 'name' => 'Network and Information Security Directive (EU) 2022/2555', 'body' => 'European Union', 'kind' => 'Directive',
            'covers' => 'Cybersecurity risk-management measures, supply-chain security and staged incident reporting for essential and important entities.',
            'apply'  => 'Risk measures and incident reporting stages mapped to the services we build and run for in-scope clients.',
            'mark' => 'NIS2', 'sub' => 'EU', 'shape' => 'shield'],
        'wcag22' => ['code' => 'WCAG 2.2 AA', 'name' => 'Web Content Accessibility Guidelines', 'body' => 'W3C', 'kind' => 'Standard',
            'covers' => 'Perceivable, operable, understandable and robust content, including 2.2 criteria such as focus not obscured, target size and accessible authentication.',
            'apply'  => 'Automated checks in CI plus manual keyboard and screen-reader passes on every key journey.',
            'mark' => 'WCAG', 'sub' => '2.2 AA', 'shape' => 'seal'],
        'cwv' => ['code' => 'Core Web Vitals', 'name' => 'Loading, interactivity and visual stability', 'body' => 'Google', 'kind' => 'Metric set',
            'covers' => 'Good at the 75th percentile of page loads: LCP ≤ 2.5 s, INP ≤ 200 ms, CLS ≤ 0.1.',
            'apply'  => 'Performance budgets enforced in CI, with field data watched at p75 for every template.',
            'mark' => 'CWV', 'sub' => 'p75', 'shape' => 'hex'],
        'dora-metrics' => ['code' => 'DORA metrics', 'name' => 'Software delivery performance', 'body' => 'DORA (DevOps Research and Assessment)', 'kind' => 'Metric set',
            'covers' => 'Deployment frequency, change lead time, change failure rate and failed deployment recovery time.',
            'apply'  => 'Measured from your pipeline from week one, so delivery speed and stability are reported, not asserted.',
            'mark' => 'DORA', 'sub' => '4 keys', 'shape' => 'hex'],
        'sci' => ['code' => 'SCI · ISO/IEC 21031:2024', 'name' => 'Software Carbon Intensity', 'body' => 'Green Software Foundation', 'kind' => 'Specification',
            'covers' => 'A rate of carbon emissions per functional unit: SCI = ((E × I) + M) per R, where E is energy, I is grid carbon intensity, M is embodied emissions and R the unit.',
            'apply'  => 'Carbon per request, per user or per inference measured, so efficiency work has a number to move.',
            'mark' => 'SCI', 'sub' => 'GSF', 'shape' => 'hex'],
    ];
    return $S;
}

function xt_standard(string $key): ?array {
    $S = xt_standards();
    return isset($S[$key]) ? ['key' => $key] + $S[$key] : null;
}

/** The drawn part of a badge: a seal, shield or hexagon with the short mark and body line. */
function xt__badge_art(array $s, string $shape): string {
    $mark = e($s['mark']);
    $sub  = e($s['sub']);
    $len  = mb_strlen($s['mark']);
    $fs   = $len <= 3 ? 13 : ($len <= 5 ? 11 : ($len <= 6 ? 9 : 7.6));
    if ($shape !== 'seal' && $len >= 6) $fs -= .6;   // shields and hexagons narrow towards the text line
    if ($shape === 'shield') {
        $art = '<path class="xt-badge__ln" d="M32 4.5 55 12v17.5c0 14.5-9.8 25.5-23 30-13.2-4.5-23-15.5-23-30V12z"/>'
             . '<path class="xt-badge__ln2" d="M32 9.5 50 15.4v14.1c0 11.6-7.6 20.4-18 24.4-10.4-4-18-12.8-18-24.4V15.4z"/>'
             . '<path class="xt-badge__ac" d="M24 14.2 32 11.6l8 2.6"/>';
        $ty = 33.5; $sy = 42.5;
    } elseif ($shape === 'hex') {
        $art = '<path class="xt-badge__ln" d="M32 4 56.2 18v28L32 60 7.8 46V18z"/>'
             . '<path class="xt-badge__ln2" d="M32 9.5 51.5 20.75v22.5L32 54.5 12.5 43.25v-22.5z"/>'
             . '<path class="xt-badge__ac" d="M26 12.9 32 9.5l6 3.4"/>';
        $ty = 34; $sy = 43;
    } else {
        $ticks = '';
        for ($i = 0; $i < 36; $i++) {
            $a = deg2rad($i * 10);
            $ticks .= sprintf('M%.2f %.2fL%.2f %.2f', 32 + 27.5 * cos($a), 32 + 27.5 * sin($a), 32 + 25.5 * cos($a), 32 + 25.5 * sin($a));
        }
        $art = '<circle class="xt-badge__ln" cx="32" cy="32" r="29.5"/>'
             . '<path class="xt-badge__tk" d="' . $ticks . '"/>'
             . '<circle class="xt-badge__ln2" cx="32" cy="32" r="21.5"/>'
             . '<path class="xt-badge__ac" d="M22.5 12.6A21.5 21.5 0 0 1 41.5 12.6"/>';
        $ty = 34; $sy = 43;
    }
    return '<svg class="xt-badge__art" viewBox="0 0 64 64" aria-hidden="true" focusable="false">' . $art
         . '<text class="xt-badge__mk" x="32" y="' . $ty . '" text-anchor="middle" style="font-size:' . $fs . 'px">' . $mark . '</text>'
         . '<text class="xt-badge__sb" x="32" y="' . $sy . '" text-anchor="middle">' . $sub . '</text></svg>';
}

function xt_badge(string $key, array $o = []): string {
    $s = xt_standard($key);
    if (!$s) return '<!-- xt_badge: unknown standard "' . e($key) . '" -->';
    $variant = $o['variant'] ?? $s['shape'];
    if (!in_array($variant, ['seal', 'shield', 'hex', 'chip'], true)) $variant = $s['shape'];
    $tag   = in_array($o['tag'] ?? 'span', ['span', 'li', 'div'], true) ? ($o['tag'] ?? 'span') : 'span';
    $class = trim('xt-badge xt-badge--' . $variant . ' ' . ($o['class'] ?? ''));

    if ($variant === 'chip') {
        return '<' . $tag . ' class="' . e($class) . '" title="' . e($s['name']) . '">'
             . '<svg class="xt-badge__pip" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path d="M6 1 10.5 2.8v3.1c0 2.6-1.9 4.5-4.5 5.3C3.4 10.4 1.5 8.5 1.5 5.9V2.8z"/></svg>'
             . '<span class="xt-badge__code">' . e($s['code']) . '</span>'
             . '<span class="sr"> — ' . e($s['name']) . '</span></' . $tag . '>';
    }
    return '<' . $tag . ' class="' . e($class) . '" data-standard="' . e($key) . '">'
         . xt__badge_art($s, $variant)
         . '<span class="xt-badge__txt">'
         . '<span class="xt-badge__code">' . e($s['code']) . '</span>'
         . '<span class="xt-badge__name">' . e($s['name']) . '</span>'
         . (!empty($o['detail']) ? '<span class="xt-badge__covers">' . e($s['covers']) . '</span>' : '')
         . (!empty($o['apply']) ? '<span class="xt-badge__apply"><b>How we apply it</b> ' . e($s['apply']) . '</span>' : '')
         . '</span></' . $tag . '>';
}

}
