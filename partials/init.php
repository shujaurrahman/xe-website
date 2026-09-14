<?php
/**
 * Bootstraps every page. Include this first, then set $page before the head.
 *
 *   <?php $BASE = ''; require 'partials/init.php';
 *         $page = ['key' => 'work', 'title' => 'Work', 'desc' => '…']; ?>
 *
 * $BASE is the path back to the site root ('' at the root, '../' one level
 * down). Every asset and link in the chrome is written through it, so pages
 * can live in sub-folders without anything breaking.
 */

if (!isset($BASE)) { $BASE = ''; }

$SITE = require __DIR__ . '/../data/site.php';

/** Root-relative URL for the page currently being rendered. */
function xe_url(string $path): string {
    global $BASE;
    if (preg_match('~^(https?:|mailto:|tel:|#)~', $path)) return $path;
    return $BASE . $path;
}

/** Inline an SVG from assets/brand so it can inherit currentColor. */
function xe_svg(string $name): string {
    $file = __DIR__ . '/../assets/brand/' . basename($name) . '.svg';
    return is_file($file) ? trim(file_get_contents($file)) : '';
}

/** Escape for HTML output. */
function e(?string $s): string {
    return htmlspecialchars((string) $s, ENT_QUOTES, 'UTF-8');
}

/** The URL of a discipline's page. */
function xe_discipline_url(array $d): string {
    return xe_url('services/' . $d['slug'] . '.php');
}

/** The URL of one capability: its own page when it has one, else the discipline. */
function xe_cap_url(array $d, array $c): string {
    if (!empty($c[2])) return xe_url('services/' . $d['slug'] . '/' . $c[2] . '.php');
    return xe_discipline_url($d);
}

/** Include one of the home-page sections. */
function xe_section(string $name): void {
    $file = __DIR__ . '/../sections/' . basename($name) . '.php';
    if (is_file($file)) {
        include $file;
    } else {
        echo "\n<!-- missing section: {$name} -->\n";
    }
}
