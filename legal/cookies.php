<?php
/* Cookie Policy — concept: the storage inventory + a working preferences panel. The panel is a plain POST form handled here
   (Post/Redirect/Get), so it works without JavaScript; the choice is stored in one first-party cookie, xe_prefs.
   Template: partials/legal/doc.php · body: partials/legal/cookies.php. PLACEHOLDER: legal review by qualified counsel before launch. */
$BASE = '../';
require __DIR__ . '/../partials/init.php';
require_once __DIR__ . '/../partials/tech/kit.php';
require __DIR__ . '/../partials/legal/lib.php';

/* Categories other than "necessary" are not in use today (verified: no analytics/ads/social scripts, no third-party requests).
   Recording a choice still matters: if a category is ever introduced, it stays off for anyone who has not opted in. */
$lgl_cats = ['analytics' => 'a', 'marketing' => 'm'];
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['lgl_act'])) {
    $lgl_act = (string) $_POST['lgl_act'];
    $lgl_v = 'v1';
    foreach ($lgl_cats as $lgl_k => $lgl_c) {
        $lgl_on = $lgl_act === 'all' ? 1 : ($lgl_act === 'none' ? 0 : (int) !empty($_POST[$lgl_k]));
        $lgl_v .= '.' . $lgl_c . $lgl_on;
    }
    $lgl_v .= '.' . time();
    setcookie('xe_prefs', $lgl_v, ['expires' => time() + 180 * 86400, 'path' => '/', 'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off', 'httponly' => false, 'samesite' => 'Lax']);
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?saved=1#preferences', true, 303);
    exit;
}
/* Read the stored choice: v1.a0.m0.<unix time> */
$lgl_pref = ['analytics' => false, 'marketing' => false, 'at' => null];
if (preg_match('~^v1\.a([01])\.m([01])\.(\d{9,11})$~', (string) ($_COOKIE['xe_prefs'] ?? ''), $lgl_m)) {
    $lgl_pref = ['analytics' => $lgl_m[1] === '1', 'marketing' => $lgl_m[2] === '1', 'at' => (int) $lgl_m[3]];
}
$lgl_saved = isset($_GET['saved']) && $lgl_pref['at'];

$LG = [
    'key'   => 'cookies',
    'h1'    => ['Three small items.', 'No trackers.'],
    'lead'  => 'This policy lists every cookie and browser-storage item this website uses, by name, with what it does and how long it lasts. It also holds your preferences panel.',
    'scope' => 'This website, in every browser',
    'short' => [
        'The site uses <strong>two session-storage items</strong> and, only if you save a choice here, <strong>one cookie</strong>. All three are ours.',
        '<strong>No analytics, advertising or social-media cookies</strong> — and no third-party scripts or fonts — are in use today.',
        'Your choice is stored <strong>on your device only</strong>, for 180 days, and you can change it at any time below.',
        'If we ever add a non-essential category, it will <strong>stay off</strong> until you switch it on.',
    ],
    'toc' => [
        'preferences' => 'Your preferences',
        'what'        => 'What cookies and storage are',
        'inventory'   => 'Everything this site stores',
        'third'       => 'Third parties',
        'control'     => 'Controlling storage in your browser',
        'changes'     => 'Changes to this policy',
    ],
    'body'    => __DIR__ . '/../partials/legal/cookies.php',
    'related' => ['privacy', 'terms', 'security'],
];
require __DIR__ . '/../partials/legal/doc.php';
