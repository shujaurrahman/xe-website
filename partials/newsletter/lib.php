<?php /* DRAFT COPY — review before launch */
/**
 * The Dispatch — the one place the sample issue is measured.
 *
 * Two sections print figures about the sample issue: the reader (partials/newsletter/issue.php) and
 * the rhythm (rhythm.php), which multiplies them by a year. Both call this file, so the page cannot
 * contradict itself — which is exactly the defect an independent review found on other pages here.
 *
 * Nothing in this file asserts anything. Every number is counted from the text the page is about to
 * print, at the same 210 words a minute partials/blog/lib.php uses, so a "minute" means the same thing
 * across the site.
 *
 * Include-safe: require_once from anywhere. Every function is guarded.
 *
 *   nlt_words(string $text): int          words, counted as runs of letters and digits
 *   nlt_stats(array $nlt_data): array     ['blocks' => key => words, 'total' => int, 'minutes' => int]
 */

if (!function_exists('nlt_words')) {

/** A word is a run of letters or digits; an apostrophe or a hyphen inside one does not split it. */
function nlt_words(string $nlt_t): int {
    return (int) (preg_match_all('~[\p{L}\p{N}][\p{L}\p{N}\'\x{2019}-]*~u', $nlt_t, $nlt_m) ?: 0);
}

/** Every string inside one block's 'sample', in the order the page prints it. */
function nlt_sample_text(array $nlt_s): string {
    $nlt_t = ($nlt_s['head'] ?? '') . ' ';
    foreach ($nlt_s['body'] ?? [] as $nlt_p)  { $nlt_t .= $nlt_p . ' '; }
    foreach ($nlt_s['items'] ?? [] as $nlt_r) { $nlt_t .= ($nlt_r[0] ?? '') . ' ' . ($nlt_r[1] ?? '') . ' '; }
    return $nlt_t . ($nlt_s['note'] ?? '');
}

function nlt_stats(array $nlt_data): array {
    static $nlt_cache = null;
    if ($nlt_cache !== null) return $nlt_cache;
    $nlt_out = ['blocks' => [], 'total' => 0, 'minutes' => 1];
    foreach ($nlt_data['blocks'] ?? [] as $nlt_b) {
        $nlt_n = nlt_words(nlt_sample_text($nlt_b['sample'] ?? []));
        $nlt_out['blocks'][$nlt_b['key']] = $nlt_n;
        $nlt_out['total'] += $nlt_n;
    }
    $nlt_out['minutes'] = max(1, (int) round($nlt_out['total'] / 210));
    return $nlt_cache = $nlt_out;
}

}
