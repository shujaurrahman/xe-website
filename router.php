<?php
/**
 * Clean URLs for PHP's built-in server, which ignores .htaccess:
 *
 *   php -S localhost:8000 router.php
 *
 * Mirrors .htaccess — /contact serves contact.php, old .php and index URLs 301
 * to the clean form. Apache (XAMPP, Hostinger) never loads this file.
 */

$xe_route = (function () {
    $uri  = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $qs   = ($_SERVER['QUERY_STRING'] ?? '') !== '' ? '?' . $_SERVER['QUERY_STRING'] : '';
    $root = __DIR__;
    $go   = function (string $to) use ($qs) { header('Location: ' . $to . $qs, true, 301); return true; };

    if (preg_match('~^((?:.*/)?)index(?:\.php)?$~i', $uri, $m)) return $go($m[1]);   // /index.php → /
    if (preg_match('~^(.+)\.php$~i', $uri, $m))                 return $go($m[1]);   // /contact.php → /contact

    $page = rtrim($uri, '/');
    if ($page !== '' && is_file("$root$page.php")) {
        return $page === $uri ? "$root$page.php" : $go($page);                        // /contact/ → /contact
    }
    if (substr($uri, -1) !== '/' && is_file("$root$uri/index.php")) return $go("$uri/"); // /services → /services/

    if (is_file("$root$uri") || is_file("$root$uri/index.php")) return false;         // assets and folder indexes

    http_response_code(404);   // php -S would otherwise answer unknown paths with the home page
    return "$root/404.php";    // the designed not-found page (it sets the 404 status itself too)
})();

if (is_string($xe_route)) {       // a page: run it at the top level, from its own folder, as if requested directly
    chdir(dirname($xe_route));
    require $xe_route;
    return true;
}
return $xe_route;
