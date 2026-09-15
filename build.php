<?php
/**
 * Bundles the per-section stylesheets and scripts into the two files the
 * pages actually load.
 *
 *     php build.php
 *
 * Authoring stays modular — one .css and one .js per section, next to its
 * .php — while the browser still only fetches core + sections.
 */

$root = __DIR__;
$sections = $root . '/sections';

foreach ([['css', 'assets/css/sections.css'], ['js', 'assets/js/sections.js']] as [$ext, $out]) {
    $files = glob("$sections/*.$ext");
    sort($files);
    $parts = [];
    foreach ($files as $f) {
        $name = basename($f, ".$ext");
        $body = trim(file_get_contents($f));
        if ($body === '') continue;
        $parts[] = ($ext === 'css' ? "/* ===== $name ===== */" : "/* ===== $name ===== */") . "\n" . $body . "\n";
    }
    $bundle = implode("\n", $parts);
    // Rewrite only on a real change: the file time is the ?v= cache stamp and what deploy.sh compares.
    if (!is_file("$root/$out") || file_get_contents("$root/$out") !== $bundle) file_put_contents("$root/$out", $bundle);
    printf("%-24s %2d files  %7s bytes\n", $out, count($parts), number_format(strlen($bundle)));
}

/* A quick sanity check that every section a page includes actually exists. */
$missing = [];
foreach (glob("$sections/*.php") as $f) {
    $stem = basename($f, '.php');
    foreach (['css', 'js'] as $ext) {
        // a section may legitimately have no js; only flag a missing css
        if ($ext === 'css' && !is_file("$sections/$stem.css")) $missing[] = "$stem.css";
    }
}
if ($missing) echo "note: no stylesheet for " . implode(', ', $missing) . "\n";
