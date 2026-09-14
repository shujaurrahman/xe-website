<?php
/**
 * Brand Design — the shared line icons and the six capability glyphs.
 * Included with require_once by the shared partials. Every drawing uses
 * currentColor; parts marked class="a" take the single blue accent in CSS.
 *
 *   bd_icon('map')              24px line icon, stroke 1.5
 *   bd_glyph('brand-systems')   240×140 illustration keyed to a capability slug
 *   bd_badges('Figma · JSON')   format string → short file-type badges
 *   bd_img($cap['img'])         a capability photograph, lazy by default
 */

if (!function_exists('bd_icon')) {

function bd_icon(string $name): string {
    static $I = [
        'map'       => '<path d="M3 6.5 8.5 4l7 2.5L21 4v13.5L15.5 20l-7-2.5L3 20z"/><path d="M8.5 4v13.5"/><path class="a" d="M15.5 6.5V20"/>',
        'target'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle class="a af" cx="12" cy="12" r="1.3"/>',
        'gridgap'   => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect class="a" x="13.5" y="13.5" width="7" height="7" rx="1.5" stroke-dasharray="2 2"/>',
        'page'      => '<path d="M6 3.5h8l4 4v13H6z"/><path d="M14 3.5v4h4"/><path class="a" d="M9 12h6M9 15.5h4"/>',
        'steps'     => '<path d="M3 20h5v-5h5v-5h5V6"/><path class="a" d="m15 7.5 3-3 3 3"/>',
        'gauge'     => '<path d="M4 16a8 8 0 1 1 16 0"/><path d="M4 19.5h16"/><path class="a" d="m12 16 3.8-4.8"/>',
        'mark'      => '<path d="M4 5.5h4.5l6.5 6.5-6.5 6.5H4l6.5-6.5z"/><path class="a" d="m15.5 7 5 5-5 5"/>',
        'quote'     => '<path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 3.5V17A2.5 2.5 0 0 1 4 14.5z"/><path class="a" d="M8.5 9h7M8.5 12.5h4.5"/>',
        'cursor'    => '<path d="M5 4l13 5.5-5.5 1.8L10.7 17z"/><path class="a" d="m13.2 13.2 5.3 5.3"/>',
        'wave'      => '<path d="M3 12h1.5M7 8.5v7M15 9v6M18.5 11v2M21 12h0"/><path class="a" d="M11 5v14"/>',
        'book'      => '<path d="M12 6.5C10 5 7 4.5 4 5v13.5c3-.5 6 0 8 1.5 2-1.5 5-2 8-1.5V5c-3-.5-6 0-8 1.5z"/><path class="a" d="M12 6.5V20"/>',
        'box'       => '<path d="M12 3 20 7.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/><path class="a" d="m8 5.3 8 4.5"/>',
        'compass'   => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="m15.5 8.5-2 5-5 2 2-5z"/>',
        'crosshair' => '<circle cx="12" cy="12" r="7"/><path d="M12 2.5v4M12 17.5v4M2.5 12h4M17.5 12h4"/><circle class="a af" cx="12" cy="12" r="1.6"/>',
        'scale'     => '<path d="M12 5v15M7.5 20h9M5 7.5h14"/><path d="M5 7.5 2.8 13a2.3 2.3 0 0 0 4.4 0zM19 7.5 16.8 13a2.3 2.3 0 0 0 4.4 0z"/><circle class="a" cx="12" cy="4" r="1.3"/>',
        'people'    => '<circle cx="9" cy="8.5" r="3"/><path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle class="a" cx="17" cy="9.5" r="2.3"/><path class="a" d="M16.8 14c2.4 0 4.2 1.8 4.2 4.5"/>',
        'lines'     => '<path d="M4 6.5h16M4 12h11"/><path class="a" d="M4 17.5h6"/>',
        'check'     => '<rect x="3.5" y="3.5" width="17" height="17" rx="4"/><path class="a" d="m8 12.3 2.8 2.7L16 9"/>',
        'tokens'    => '<path d="M8 4H7a2 2 0 0 0-2 2v3.5L3.5 12 5 14.5V18a2 2 0 0 0 2 2h1M16 4h1a2 2 0 0 1 2 2v3.5l1.5 2.5-1.5 2.5V18a2 2 0 0 1-2 2h-1"/><circle class="a af" cx="12" cy="12" r="1.8"/>',
        'blocks'    => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect class="a" x="13.5" y="13.5" width="7" height="7" rx="3.5"/>',
        'layout'    => '<rect x="3.5" y="4" width="17" height="16" rx="2"/><path d="M3.5 9h17M10 9v11"/><path class="a" d="M13 13h4.5M13 16h3"/>',
        'ranges'    => '<path d="M4 7h3M11 7h9M4 17h9M17 17h3"/><circle class="a" cx="9" cy="7" r="2"/><circle cx="15" cy="17" r="2"/><path d="M4 12h16" stroke-dasharray="1 3"/>',
        'branch'    => '<circle cx="6.5" cy="5.5" r="2"/><circle cx="6.5" cy="18.5" r="2"/><path d="M6.5 7.5v9M17.5 10.5c0 4-11 2.5-11 6"/><circle class="a" cx="17.5" cy="8.5" r="2"/>',
        'browser'   => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="M3 9h18M6 6.8h.01M8.5 6.8h.01"/><path class="a" d="M7 13h6M7 16h9"/>',
        'layers'    => '<path d="M12 4 21 8.5 12 13 3 8.5z"/><path d="m3 12.5 9 4.5 9-4.5"/><path class="a" d="m3 16.5 9 4.5 9-4.5"/>',
        'tree'      => '<rect x="9" y="3" width="6" height="4.5" rx="1"/><rect x="3" y="16.5" width="5" height="4.5" rx="1"/><rect x="16" y="16.5" width="5" height="4.5" rx="1"/><path d="M12 7.5v9M5.5 16.5V12h13v4.5"/><rect class="a" x="9.5" y="16.5" width="5" height="4.5" rx="1"/>',
        'link'      => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path class="a" d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
        'tag'       => '<path d="M3.5 12.2V4.5a1 1 0 0 1 1-1h7.7l8.3 8.3a1.5 1.5 0 0 1 0 2.1l-6.6 6.6a1.5 1.5 0 0 1-2.1 0z"/><circle class="a" cx="8" cy="8" r="1.6"/>',
        'arrows'    => '<path d="M4 8h13M13.5 4.5 17 8l-3.5 3.5"/><path class="a" d="M20 16H7M10.5 12.5 7 16l3.5 3.5"/>',
        'shield'    => '<path d="M12 3 19.5 6v5.5c0 4.5-3.2 8-7.5 9.5-4.3-1.5-7.5-5-7.5-9.5V6z"/><path class="a" d="m8.8 12 2.3 2.3L15.5 10"/>',
        'chip'      => '<rect x="6" y="6" width="12" height="12" rx="2"/><path d="M9.5 3v3M14.5 3v3M9.5 18v3M14.5 18v3M3 9.5h3M3 14.5h3M18 9.5h3M18 14.5h3"/><rect class="a" x="9.5" y="9.5" width="5" height="5" rx="1"/>',
        'scan'      => '<path d="M4 8V5.5A1.5 1.5 0 0 1 5.5 4H8M16 4h2.5A1.5 1.5 0 0 1 20 5.5V8M20 16v2.5a1.5 1.5 0 0 1-1.5 1.5H16M8 20H5.5A1.5 1.5 0 0 1 4 18.5V16"/><path class="a" d="m8.5 12.2 2.4 2.3 4.6-5"/>',
        'images'    => '<rect x="3.5" y="6.5" width="13" height="13" rx="2"/><path d="M7.5 3.5h11a2 2 0 0 1 2 2v11"/><path d="m3.5 16 4-4 3.5 3.5 2-2 3.5 3.5"/><circle class="a" cx="12.3" cy="10.3" r="1.3"/>',
        'pen'       => '<path d="M4 20l1-4.5L15.5 5a2.1 2.1 0 0 1 3 0l.5.5a2.1 2.1 0 0 1 0 3L8.5 19zM13 20h7"/><path class="a" d="m13.5 7 3.5 3.5"/>',
        'flow'      => '<rect x="3" y="4" width="6" height="6" rx="1.5"/><rect x="3" y="14" width="6" height="6" rx="1.5"/><path d="M9 7h2.5A1.5 1.5 0 0 1 13 8.5V12h2M9 17h2.5a1.5 1.5 0 0 0 1.5-1.5V12"/><rect class="a" x="15" y="9" width="6" height="6" rx="1.5"/>',
        'clock'     => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="M12 7.5V12l3 2"/>',
        'dot'       => '<circle cx="12" cy="12" r="8.5"/><circle class="a af" cx="12" cy="12" r="2"/>',
        'tick'      => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
    ];
    $body = $I[$name] ?? $I['dot'];
    return '<svg class="bd-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $body . '</svg>';
}

/** A small illustration for each capability. Ink lines, paper fills, one blue part. */
function bd_glyph(string $slug): string {
    static $G = [
        'growth-strategy' =>
            '<path class="gl-ax" d="M30 18v98h186"/>'
          . '<path class="gl-ax" d="M30 83h186M30 50h186" stroke-dasharray="2 5"/>'
          . '<path class="gl-trend" d="M40 108C92 98 140 76 198 36"/>'
          . '<g class="gl-pts"><circle cx="60" cy="92" r="4"/><circle cx="82" cy="100" r="3"/><circle cx="104" cy="80" r="4"/><circle cx="126" cy="94" r="3"/><circle cx="140" cy="64" r="4"/><circle cx="164" cy="76" r="3"/><circle cx="176" cy="54" r="4"/></g>'
          . '<circle class="gl-ring" cx="200" cy="34" r="14"/><circle class="gl-b" cx="200" cy="34" r="6"/>',
        'brand-identity' =>
            '<rect class="gl-dash" x="34" y="18" width="104" height="104" rx="6"/>'
          . '<path class="gl-ax" d="M34 40h104M34 100h104M56 18v104M116 18v104" stroke-dasharray="2 5"/>'
          . '<path class="gl-ink" d="M58 42h20l38 28-38 28H58l38-28z"/>'
          . '<path class="gl-b" d="M60 58h10l12 12-12 12H60l12-12z"/>'
          . '<g class="gl-sw"><rect class="gl-inkf" x="156" y="22" width="52" height="24" rx="5"/><rect class="gl-paper" x="156" y="54" width="52" height="24" rx="5"/><rect class="gl-soft" x="156" y="86" width="52" height="24" rx="5"/></g>',
        'brand-foundation' =>
            '<path class="gl-ax" d="M120 12v18" stroke-dasharray="2 4"/>'
          . '<rect class="gl-paper" x="92" y="30" width="56" height="20" rx="4"/>'
          . '<rect class="gl-paper" x="66" y="56" width="108" height="20" rx="4"/>'
          . '<rect class="gl-paper" x="44" y="82" width="152" height="20" rx="4"/>'
          . '<rect class="gl-b" x="24" y="108" width="192" height="16" rx="4"/>'
          . '<path class="gl-ax" d="M104 40h32M80 66h56M58 92h40"/>',
        'brand-systems' =>
            '<g class="gl-tok"><rect class="gl-paper" x="36" y="20" width="30" height="30" rx="0"/><rect class="gl-paper" x="78" y="20" width="30" height="30" rx="6"/><rect class="gl-paper" x="120" y="20" width="30" height="30" rx="11"/><rect class="gl-paper" x="162" y="20" width="30" height="30" rx="15"/>'
          . '<rect class="gl-soft" x="36" y="60" width="30" height="30" rx="6"/><rect class="gl-inkf" x="78" y="60" width="30" height="30" rx="6"/><rect class="gl-b" x="120" y="60" width="30" height="30" rx="6"/><rect class="gl-paper" x="162" y="60" width="30" height="30" rx="6"/></g>'
          . '<path class="gl-ax" d="M36 114h156"/><circle class="gl-knob" cx="120" cy="114" r="6"/><path class="gl-ax" d="M36 108v12M192 108v12"/>',
        'brand-architecture' =>
            '<path class="gl-line" d="M120 42v22M52 64h136M52 64v18M120 64v18M188 64v18M40 104v12M64 104v12M176 104v12M200 104v12"/>'
          . '<rect class="gl-inkf" x="92" y="16" width="56" height="26" rx="6"/>'
          . '<rect class="gl-paper" x="28" y="82" width="48" height="22" rx="5"/>'
          . '<rect class="gl-b" x="96" y="82" width="48" height="22" rx="5"/>'
          . '<rect class="gl-paper" x="164" y="82" width="48" height="22" rx="5"/>'
          . '<g class="gl-leaf"><rect x="32" y="116" width="16" height="10" rx="3"/><rect x="56" y="116" width="16" height="10" rx="3"/><rect x="168" y="116" width="16" height="10" rx="3"/><rect x="192" y="116" width="16" height="10" rx="3"/></g>',
        'brand-ai-tools' =>
            '<rect class="gl-soft" x="66" y="16" width="96" height="72" rx="8"/>'
          . '<rect class="gl-paper" x="52" y="30" width="96" height="72" rx="8"/>'
          . '<rect class="gl-paper" x="38" y="44" width="96" height="72" rx="8"/>'
          . '<path class="gl-ax" d="m38 100 26-24 20 18 14-12 36 30" />'
          . '<circle class="gl-ax" cx="108" cy="64" r="7"/>'
          . '<path class="gl-scan" d="M30 80h112"/>'
          . '<circle class="gl-b" cx="176" cy="92" r="20"/><path class="gl-tick" d="m167 92 6 6 12-13"/>',
        'hub' =>
            '<circle class="gl-orbit" cx="120" cy="70" r="54"/><circle class="gl-orbit" cx="120" cy="70" r="30" stroke-dasharray="2 5"/>'
          . '<g class="gl-spin"><path class="gl-spoke" d="M120 70V16M120 70l47-27M120 70l47 27M120 70v54M120 70 73 97M120 70 73 43" stroke-dasharray="2 4"/>'
          . '<g class="gl-sat"><circle cx="120" cy="16" r="5"/><circle cx="167" cy="43" r="5"/><circle cx="167" cy="97" r="5"/><circle cx="120" cy="124" r="5"/><circle cx="73" cy="97" r="5"/><circle class="gl-sat-b" cx="73" cy="43" r="5"/></g></g>'
          . '<circle class="gl-core" cx="120" cy="70" r="15"/><circle class="gl-b" cx="120" cy="70" r="5"/>',
    ];
    $body = $G[$slug] ?? $G['hub'];
    return '<svg class="bd-glyph bd-glyph--' . htmlspecialchars($slug, ENT_QUOTES) . '" viewBox="0 0 240 140" fill="none" aria-hidden="true" focusable="false">' . $body . '</svg>';
}

/**
 * A capability photograph — ['src', 'w', 'h', 'alt', 'pos'] as in data/brand-design.php.
 * $eager is for the hero (LCP): no lazy loading, high fetch priority.
 */
function bd_img(array $img, string $class = '', bool $eager = false): string {
    $h = function ($v) { return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8'); };
    $pos = !empty($img['pos']) ? ' style="object-position:' . $h($img['pos']) . '"' : '';
    return '<img class="' . $h(trim('bd-img ' . $class)) . '" src="' . $h(xe_url($img['src'])) . '" width="' . (int) $img['w']
         . '" height="' . (int) $img['h'] . '" alt="' . $h($img['alt'] ?? '') . '"'
         . ($eager ? ' fetchpriority="high" decoding="async"' : ' loading="lazy" decoding="async"') . $pos . '>';
}

/** 'Figma · font files' → ['FIGMA', 'FONTS']. Words that are not formats are dropped. */
function bd_badges(string $formats): array {
    static $MAP = [
        'figma variables' => 'FIG VARS', 'figma' => 'FIG', 'font files' => 'FONTS', 'guidelines' => 'GUIDE',
        'document' => 'DOC', 'one page' => '1 PAGE', 'prompt set' => 'PROMPTS', 'changelog' => 'LOG',
        'dashboard' => 'DASH', 'roadmap' => 'ROADMAP', 'comfyui' => 'COMFY', 'weights' => 'WEIGHTS',
        'yours' => '',
    ];
    $out = [];
    foreach (preg_split('~\s*·\s*~u', $formats) as $t) {
        $k = strtolower(trim($t));
        if ($k === '') continue;
        $b = array_key_exists($k, $MAP) ? $MAP[$k] : strtoupper($t);
        if ($b !== '') $out[] = $b;
    }
    return $out ?: ['FILE'];
}

/** 'Wk 03–05' → [3, 5]; 'Wk 05' → [5, 5]. */
function bd_weeks(string $s): array {
    preg_match_all('~\d+~', $s, $m);
    $n = array_map('intval', $m[0]);
    if (!$n) return [0, 0];
    return [$n[0], $n[count($n) - 1]];
}

/** 'Logo system & clearspace rules' → 'logo-system-clearspace-rules' */
function bd_slugify(string $s): string {
    $s = strtolower(str_replace(['&', '’', "'"], ['', '', ''], $s));
    return trim(preg_replace('~[^a-z0-9]+~', '-', $s), '-');
}

}
