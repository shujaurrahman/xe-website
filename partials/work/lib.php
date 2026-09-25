<?php /* DRAFT COPY — review before launch */
/**
 * Work — shared helpers for work.php, the section partials and the case-study renderer.
 * Safe to require_once from anywhere after partials/init.php. Every function is guarded.
 *
 *   wrk_cases(array $W): array          every case that has the fields a page needs, in file order
 *   wrk_case(array $W, string $slug)    one case by slug, or null
 *   wrk_valid(array $c): bool           does this entry have everything a page needs?
 *   wrk_n(int $i): string               '01', '02', … — the index numbers printed on cards
 *   wrk_img(array $im, array $o)        a <figure class="bdh-img">, from an 'img'/'gallery' entry
 *   wrk_counts(array $cases, ...)       how many programmes match a discipline / an industry
 *
 * An entry that is missing a required field is dropped rather than half-rendered, so a typo in
 * data/work.php can never ship a broken card. wrk_invalid() names what was dropped, in an HTML
 * comment, so whoever added it can see why.
 */

if (!function_exists('wrk_valid')) {

/** The fields every surface needs. Anything else in data/work.php is optional. */
function wrk_required(): array
{
    return ['slug', 'title', 'industry', 'brief', 'did', 'system', 'deliverables', 'measure', 'duration', 'img'];
}

function wrk_valid(array $c): bool
{
    foreach (wrk_required() as $k) {
        if (!isset($c[$k]) || $c[$k] === '' || $c[$k] === []) return false;
    }
    return is_array($c['did']) && is_array($c['img']) && !empty($c['img']['file']) && preg_match('~^[a-z0-9-]+$~', (string) $c['slug']);
}

/** Every case that renders, in the order data/work.php lists them. */
function wrk_cases(array $W): array
{
    $out = [];
    foreach (($W['cases'] ?? []) as $c) {
        if (wrk_valid($c) && isset($W['industries'][$c['industry']])) $out[] = $c;
    }
    return $out;
}

/** Slugs that were dropped, and why — printed as an HTML comment so nothing disappears silently. */
function wrk_invalid(array $W): string
{
    $bad = [];
    foreach (($W['cases'] ?? []) as $i => $c) {
        if (wrk_valid($c) && isset($W['industries'][$c['industry']])) continue;
        $miss = [];
        foreach (wrk_required() as $k) if (!isset($c[$k]) || $c[$k] === '' || $c[$k] === []) $miss[] = $k;
        if (!isset($W['industries'][$c['industry'] ?? '']))          $miss[] = 'industry (unknown key)';
        $bad[] = ($c['slug'] ?? ('entry ' . ($i + 1))) . ': missing ' . implode(', ', $miss ?: ['a valid slug']);
    }
    return $bad ? "\n<!-- data/work.php — not rendered · " . e(implode(' · ', $bad)) . " -->\n" : '';
}

function wrk_case(array $W, string $slug): ?array
{
    foreach (wrk_cases($W) as $c) if ($c['slug'] === $slug) return $c;
    return null;
}

function wrk_n(int $i): string
{
    return str_pad((string) $i, 2, '0', STR_PAD_LEFT);
}

/**
 * A photograph in the house frame.
 *   $im  ['file' =>, 'alt' =>, 'w' =>, 'h' =>, 'pos' => (optional)]
 *   $o   ratio 'r43'|'r45'|'r34'|'r169'|'r219'|'r11'|'' · class extra classes · tag 'figure'|'div'|'span'
 *        eager true (hero images only) · parallax '0.05' · inner extra HTML inside the frame
 */
function wrk_img(array $im, array $o = []): string
{
    if (empty($im['file'])) return '';
    $tag   = in_array($o['tag'] ?? 'figure', ['figure', 'div', 'span'], true) ? ($o['tag'] ?? 'figure') : 'figure';
    $ratio = !empty($o['ratio']) ? ' bdh-img--' . preg_replace('~[^a-z0-9]~', '', (string) $o['ratio']) : '';
    $cls   = trim('bdh-img' . $ratio . ' ' . ($o['class'] ?? ''));
    $par   = !empty($o['parallax']) ? ' data-bdh-parallax="' . e((string) $o['parallax']) . '"' : '';
    $pos   = !empty($im['pos']) ? ' style="object-position:' . e((string) $im['pos']) . '"' : '';
    $dim   = (!empty($im['w']) && !empty($im['h'])) ? ' width="' . (int) $im['w'] . '" height="' . (int) $im['h'] . '"' : '';
    $load  = !empty($o['eager']) ? ' loading="eager" fetchpriority="high"' : ' loading="lazy"';
    return '<' . $tag . ' class="' . e($cls) . '"' . $par . '>'
         . '<img src="' . xe_url('assets/imgs/work/' . basename((string) $im['file'])) . '" alt="' . e((string) ($im['alt'] ?? '')) . '"'
         . $dim . $pos . $load . ' decoding="async">'
         . ($o['inner'] ?? '')
         . '</' . $tag . '>';
}

/** How many of $cases match one discipline slug (with the industry filter held), and vice versa. */
function wrk_count_d(array $cases, string $d, string $i): int
{
    $n = 0;
    foreach ($cases as $c) {
        if (($d === '' || in_array($d, array_column($c['did'], 0), true)) && ($i === '' || $c['industry'] === $i)) $n++;
    }
    return $n;
}

function wrk_count_i(array $cases, string $i, string $d): int
{
    return wrk_count_d($cases, $d, $i);
}

}
