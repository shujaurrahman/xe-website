<?php
/**
 * Services & packages — the shared data layer for the service catalogue and the contact page.
 *
 * Include-safe: require_once it from anywhere after partials/init.php (it needs xe_url() and e()).
 * Every function is guarded, so a second include is harmless.
 *
 * DATA
 *   data/services/packages.php          the six engagement packages, keyed sprint · project · milestone ·
 *                                       retainer · enterprise · squad
 *   data/services/<discipline>.php      catalogue pages, keyed by page key — the discipline slug for its hub,
 *                                       the capability slug for each capability page. Every *.php file in
 *                                       data/services/ except packages.php is loaded automatically, so a new
 *                                       discipline only needs its file. Schema per page:
 *     '<page-key>' => [
 *       'discipline' => '<discipline-slug>',
 *       'title'      => '<span class="g">Grey first phrase.</span> Ink rest',   (trusted HTML)
 *       'lead'       => '…',
 *       'categories' => [ ['key', 'name', 'icon', 'offers' => [
 *                          ['key', 'name', 'desc', 'includes' => [], 'tags' => [], 'stack' => [] (optional),
 *                           'time', 'best', 'cap' => '<capability slug>' (optional, hub pages: links the card
 *                           to that capability's page)], … ]], … ],
 *       'packages'   => ['sprint', 'project', …],   which packages apply here, in display order
 *     ]
 *   A service id is '<page-key>:<offer-key>' and is unique site-wide.
 *
 * API
 *   svc_all(): array                      every catalogue page, keyed by page key ('key' added to each), cached
 *   svc_packages(): array                 the engagement packages, keyed by package key ('key' added), cached
 *   svc_page(string $key): ?array         one catalogue page, or null
 *   svc_find(string $id): ?array          ['id', 'page', 'category', 'offer'] for a service id, or null
 *   svc_contact_url(array $ids = [], ?string $package = null, ?string $from = null): string
 *                                         xe_url('contact.php') + ?service[]=…&package=…&from=… (clean URL, not escaped —
 *                                         wrap in e() when printing into HTML)
 *   svc_page_meta(string $key): array     ['name', 'discipline', 'dslug', 'url', 'hub'] for any page key
 *                                         (catalogue pages and discipline / capability slugs from data/site.php)
 *   svc_general(): array                  disciplines with no data/services file: their capabilities from data/site.php
 *                                         as general options — [dslug => ['discipline' => row, 'options' => [['id','name','desc']]]]
 *                                         ids are 'cap:<discipline-slug>:<capability-slug>'
 *   svc_resolve(string $id): ?array       a service id OR a 'cap:' id → ['id','type','name','discipline','dslug','page',
 *                                         'page_key','category']; null when unknown
 *   svc_ids($raw): array                  normalise ?service[]=… / ?service=a,b input into a clean, unique list (max 40)
 *   svc_tech_name(string $slug): string   display name for a data/tech-stack.php slug
 *   svc_icon(string $name, array $o = []) 24px line icon (stroke 1.5, currentColor, class "a" parts take the blue accent).
 *                                         $o: size (px) · class · label (role="img" + aria-label; otherwise aria-hidden)
 *                                         Unknown names fall back to xt_icon() from partials/tech/kit.php (loaded on demand;
 *                                         it only defines functions), then to a dot.
 *
 * COMPONENT
 *   partials/services/catalogue.php — see its header. Styles: assets/css/services.css · script: assets/js/services.js.
 */

if (!function_exists('svc_all')) {

/** Every catalogue page, merged by page key. A file that fails to load is skipped, never fatal. */
function svc_all(): array {
    static $ALL = null;
    if ($ALL !== null) return $ALL;
    $ALL = [];
    $files = glob(__DIR__ . '/../../data/services/*.php') ?: [];
    sort($files);
    foreach ($files as $file) {
        if (basename($file) === 'packages.php') continue;
        try {
            $pages = (static function (string $f) { return require $f; })($file);
        } catch (\Throwable $t) {
            error_log('services: could not load ' . basename($file) . ': ' . $t->getMessage());
            continue;
        }
        if (!is_array($pages)) continue;
        foreach ($pages as $key => $p) {
            if (!is_array($p) || !is_string($key) || $key === '') continue;
            $p['key']        = $key;
            $p['categories'] = array_values(array_filter($p['categories'] ?? [], 'is_array'));
            $p['packages']   = array_values($p['packages'] ?? []);
            $ALL[$key] = $p;
        }
    }
    return $ALL;
}

function svc_packages(): array {
    static $P = null;
    if ($P !== null) return $P;
    $P = [];
    $file = __DIR__ . '/../../data/services/packages.php';
    $raw = is_file($file) ? (static function (string $f) { return require $f; })($file) : [];
    foreach ((is_array($raw) ? $raw : []) as $k => $p) { $P[$k] = ['key' => $k] + $p; }
    return $P;
}

function svc_page(string $key): ?array {
    $all = svc_all();
    return $all[$key] ?? null;
}

function svc_find(string $id): ?array {
    static $INDEX = null;
    if ($INDEX === null) {
        $INDEX = [];
        foreach (svc_all() as $pk => $p) {
            foreach ($p['categories'] as $c) {
                foreach ($c['offers'] ?? [] as $o) {
                    if (!isset($o['key'])) continue;
                    $INDEX[$pk . ':' . $o['key']] = [$pk, $c, $o];
                }
            }
        }
    }
    if (!isset($INDEX[$id])) return null;
    [$pk, $c, $o] = $INDEX[$id];
    return ['id' => $id, 'page' => svc_page($pk), 'category' => $c, 'offer' => $o];
}

function svc_contact_url(array $ids = [], ?string $package = null, ?string $from = null): string {
    $q = [];
    $ids = array_values(array_unique(array_filter(array_map('strval', $ids), 'strlen')));
    foreach ($ids as $id) { $q[] = 'service%5B%5D=' . str_replace('%3A', ':', rawurlencode($id)); }
    if ($package !== null && $package !== '') $q[] = 'package=' . rawurlencode($package);
    if ($from !== null && $from !== '')       $q[] = 'from=' . rawurlencode($from);
    return xe_url('contact.php') . ($q ? '?' . implode('&', $q) : '');
}

/** data/site.php, from the page's $SITE when there is one. */
function svc_site(): array {
    static $S = null;
    if (isset($GLOBALS['SITE']) && is_array($GLOBALS['SITE'])) return $GLOBALS['SITE'];
    if ($S === null) $S = require __DIR__ . '/../../data/site.php';
    return $S;
}

function svc_page_meta(string $key): array {
    $p = svc_page($key);
    $want = $p['discipline'] ?? null;
    foreach (svc_site()['disciplines'] as $d) {
        if ($want !== null && $d['slug'] !== $want) continue;
        if ($key === $d['slug']) {
            return ['name' => $d['name'], 'discipline' => $d['name'], 'dslug' => $d['slug'], 'url' => xe_discipline_url($d), 'hub' => true];
        }
        foreach ($d['caps'] as $c) {
            if (($c[2] ?? '') === $key) {
                return ['name' => $c[0], 'discipline' => $d['name'], 'dslug' => $d['slug'], 'url' => xe_cap_url($d, $c), 'hub' => false];
            }
        }
    }
    $name = ucwords(str_replace('-', ' ', $key));
    return ['name' => $name, 'discipline' => $name, 'dslug' => (string) $want, 'url' => null, 'hub' => false];
}

function svc_slug(string $s): string {
    return trim(preg_replace('~[^a-z0-9]+~', '-', strtolower(str_replace('&', 'and', $s))), '-');
}

function svc_general(): array {
    static $G = null;
    if ($G !== null) return $G;
    $G = [];
    $have = [];
    foreach (svc_all() as $p) { if (!empty($p['discipline'])) $have[$p['discipline']] = true; }
    foreach (svc_site()['disciplines'] as $d) {
        if (isset($have[$d['slug']])) continue;
        $opts = [];
        foreach ($d['caps'] as $c) {
            $opts[] = ['id' => 'cap:' . $d['slug'] . ':' . (!empty($c[2]) ? $c[2] : svc_slug($c[0])), 'name' => $c[0], 'desc' => $c[1] ?? ''];
        }
        $G[$d['slug']] = ['discipline' => $d, 'options' => $opts];
    }
    return $G;
}

function svc_resolve(string $id): ?array {
    if ($f = svc_find($id)) {
        $m = svc_page_meta($f['page']['key']);
        return ['id' => $id, 'type' => 'service', 'name' => $f['offer']['name'], 'discipline' => $m['discipline'], 'dslug' => $m['dslug'],
                'page' => $m['name'], 'page_key' => $f['page']['key'], 'category' => $f['category']['name'] ?? '', 'hub' => $m['hub']];
    }
    if (strncmp($id, 'cap:', 4) === 0) {
        $parts = explode(':', $id);
        $g = svc_general()[$parts[1] ?? ''] ?? null;
        foreach (($g['options'] ?? []) as $o) {
            if ($o['id'] === $id) {
                return ['id' => $id, 'type' => 'capability', 'name' => $o['name'], 'discipline' => $g['discipline']['name'], 'dslug' => $g['discipline']['slug'],
                        'page' => $o['name'], 'page_key' => '', 'category' => 'Capabilities', 'hub' => false];
            }
        }
    }
    return null;
}

function svc_ids($raw): array {
    $list = [];
    foreach ((array) $raw as $r) {
        if (!is_string($r)) continue;
        foreach (explode(',', $r) as $p) { $list[] = trim($p); }
    }
    $out = [];
    foreach ($list as $id) {
        if ($id === '' || !preg_match('~^[a-z0-9][a-z0-9:-]{2,119}$~', $id)) continue;
        $out[$id] = true;
        if (count($out) >= 40) break;
    }
    return array_keys($out);
}

function svc_tech_name(string $slug): string {
    static $T = null;
    if (function_exists('xt_tech') && ($t = xt_tech($slug))) return $t['name'];
    if ($T === null) {
        $f = __DIR__ . '/../../data/tech-stack.php';
        $T = is_file($f) ? (require $f) : [];
    }
    return $T[$slug]['name'] ?? ucwords(str_replace(['dotjs', '-', '_'], ['.js', ' ', ' '], $slug));
}

function svc_icon(string $name, array $o = []): string {
    static $I = [
        // strategy + research
        'compass'   => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="m15.5 8.5-2 5-5 2 2-5z"/>',
        'target'    => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="4.5"/><circle class="a af" cx="12" cy="12" r="1.3"/>',
        'map'       => '<path d="M3 6.5 8.5 4l7 2.5L21 4v13.5L15.5 20l-7-2.5L3 20z"/><path d="M8.5 4v13.5"/><path class="a" d="M15.5 6.5V20"/>',
        'search'    => '<circle cx="10.5" cy="10.5" r="6.5"/><path class="a" d="m15.5 15.5 5 5"/>',
        'chart'     => '<path d="M3.5 3.5v17h17"/><path d="M7.5 16v-4M11.5 16V8M15.5 16v-6"/><path class="a" d="M19.5 16V5.5"/>',
        'trend'     => '<path d="M3 17.5 9 11.5l4 4 8-8"/><path class="a" d="M15 7.5h6v6"/>',
        'users'     => '<circle cx="9" cy="8.5" r="3"/><path d="M3.5 19c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle class="a" cx="17" cy="9.5" r="2.3"/><path class="a" d="M16.8 14c2.4 0 4.2 1.8 4.2 4.5"/>',
        'lightbulb' => '<path d="M9.5 17.5h5M10.5 21h3"/><path d="M8.5 14.5a6 6 0 1 1 7 0c-.6.5-1 1.2-1 2v1h-5v-1c0-.8-.4-1.5-1-2z"/><path class="a" d="m12.5 7.5-2 3.5h3l-2 3.5"/>',
        'scale'     => '<path d="M12 5v15M7.5 20h9M5 7.5h14"/><path d="M5 7.5 2.8 13a2.3 2.3 0 0 0 4.4 0zM19 7.5 16.8 13a2.3 2.3 0 0 0 4.4 0z"/><circle class="a" cx="12" cy="4" r="1.3"/>',
        'gauge'     => '<path d="M4 16a8 8 0 1 1 16 0"/><path d="M4 19.5h16"/><path class="a" d="m12 16 3.8-4.8"/>',
        'steps'     => '<path d="M3 20h5v-5h5v-5h5V6"/><path class="a" d="m15 7.5 3-3 3 3"/>',
        'globe'     => '<circle cx="12" cy="12" r="8.5"/><path d="M3.5 12h17M12 3.5C9.7 5.8 8.5 8.7 8.5 12s1.2 6.2 3.5 8.5"/><path class="a" d="M12 3.5c2.3 2.3 3.5 5.2 3.5 8.5s-1.2 6.2-3.5 8.5"/>',
        'eye'       => '<path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12z"/><circle class="a" cx="12" cy="12" r="3"/>',
        'handshake' => '<path d="M2.5 12.5 7 8l3.5-1 1.5 1"/><path d="M21.5 12.5 17 8l-3.5-1-4 3.5a1.5 1.5 0 0 0 2 2.2L14 11l3.5 3.5"/><path class="a" d="m6 14.5 2.5 2.5a1.4 1.4 0 0 0 2-2M10 18l.8.8a1.4 1.4 0 0 0 2-2M12.8 18.8a1.4 1.4 0 0 0 2-2l2.7-2.3"/><path d="M2.5 12.5 6 14.5"/>',
        'megaphone' => '<path d="M4 10v4a1 1 0 0 0 1 1h2l8 4.5v-15L7 9H5a1 1 0 0 0-1 1z"/><path d="m7.5 15 1 4.5h2l-.8-3.6"/><path class="a" d="M18.5 9.5a3.5 3.5 0 0 1 0 5"/>',
        // identity + expression
        'mark'      => '<path d="M4 5.5h4.5l6.5 6.5-6.5 6.5H4l6.5-6.5z"/><path class="a" d="m15.5 7 5 5-5 5"/>',
        'quote'     => '<path d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v8a2.5 2.5 0 0 1-2.5 2.5H11l-4.5 3.5V17A2.5 2.5 0 0 1 4 14.5z"/><path class="a" d="M8.5 9h7M8.5 12.5h4.5"/>',
        'pen'       => '<path d="M4 20l1-4.5L15.5 5a2.1 2.1 0 0 1 3 0l.5.5a2.1 2.1 0 0 1 0 3L8.5 19zM13 20h7"/><path class="a" d="m13.5 7 3.5 3.5"/>',
        'type'      => '<path d="M4.5 7V5h11v2M10 5v14M7.5 19h5"/><path class="a" d="M14.5 12.5h5M17 12.5V19"/>',
        'palette'   => '<path d="M12 3.5a8.5 8.5 0 1 0 0 17c1.2 0 1.8-.9 1.8-1.8 0-1.2-1-1.6-1-2.6 0-1 .8-1.6 1.8-1.6h2.2a3.7 3.7 0 0 0 3.7-3.7C20.5 7 16.7 3.5 12 3.5z"/><circle cx="7.8" cy="11" r="1.1"/><circle cx="10" cy="7.3" r="1.1"/><circle class="a af" cx="14.6" cy="7.6" r="1.3"/>',
        'images'    => '<rect x="3.5" y="6.5" width="13" height="13" rx="2"/><path d="M7.5 3.5h11a2 2 0 0 1 2 2v11"/><path d="m3.5 16 4-4 3.5 3.5 2-2 3.5 3.5"/><circle class="a" cx="12.3" cy="10.3" r="1.3"/>',
        'camera'    => '<path d="M4 8.5a2 2 0 0 1 2-2h2l1.5-2h5l1.5 2h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/><circle class="a" cx="12" cy="13" r="3.5"/>',
        'film'      => '<rect x="3.5" y="4.5" width="17" height="15" rx="2"/><path d="M7.5 4.5v15M16.5 4.5v15M3.5 9h4M3.5 15h4M16.5 9h4M16.5 15h4"/><path class="a" d="m10.5 9.8 3.5 2.2-3.5 2.2z"/>',
        'sound'     => '<path d="M3 12h1.5M7 8.5v7M15 9v6M18.5 11v2M21 12h0"/><path class="a" d="M11 5v14"/>',
        'cursor'    => '<path d="M5 4l13 5.5-5.5 1.8L10.7 17z"/><path class="a" d="m13.2 13.2 5.3 5.3"/>',
        'box'       => '<path d="M12 3 20 7.5v9L12 21l-8-4.5v-9z"/><path d="M4 7.5 12 12l8-4.5M12 12v9"/><path class="a" d="m8 5.3 8 4.5"/>',
        'print'     => '<path d="M7 8.5v-5h10v5"/><rect x="3.5" y="8.5" width="17" height="8" rx="2"/><path d="M7 14h10v6.5H7z"/><path class="a" d="M16.5 11.5h.01"/>',
        'signpost'  => '<path d="M12 21v-4M12 10V3"/><path d="M5 5h12l2.5 2.5L17 10H5z"/><path class="a" d="M19 12H7l-2.5 2.5L7 17h12z"/>',
        // systems + structure
        'layers'    => '<path d="M12 4 21 8.5 12 13 3 8.5z"/><path d="m3 12.5 9 4.5 9-4.5"/><path class="a" d="m3 16.5 9 4.5 9-4.5"/>',
        'grid'      => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect class="a" x="13.5" y="13.5" width="7" height="7" rx="1.5" stroke-dasharray="2 2"/>',
        'blocks'    => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect class="a" x="13.5" y="13.5" width="7" height="7" rx="3.5"/>',
        'tokens'    => '<path d="M8 4H7a2 2 0 0 0-2 2v3.5L3.5 12 5 14.5V18a2 2 0 0 0 2 2h1M16 4h1a2 2 0 0 1 2 2v3.5l1.5 2.5-1.5 2.5V18a2 2 0 0 1-2 2h-1"/><circle class="a af" cx="12" cy="12" r="1.8"/>',
        'layout'    => '<rect x="3.5" y="4" width="17" height="16" rx="2"/><path d="M3.5 9h17M10 9v11"/><path class="a" d="M13 13h4.5M13 16h3"/>',
        'book'      => '<path d="M12 6.5C10 5 7 4.5 4 5v13.5c3-.5 6 0 8 1.5 2-1.5 5-2 8-1.5V5c-3-.5-6 0-8 1.5z"/><path class="a" d="M12 6.5V20"/>',
        'doc'       => '<path d="M6 3.5h8l4 4v13H6z"/><path d="M14 3.5v4h4"/><path class="a" d="M9 12h6M9 15.5h4"/>',
        'tree'      => '<rect x="9" y="3" width="6" height="4.5" rx="1"/><rect x="3" y="16.5" width="5" height="4.5" rx="1"/><rect x="16" y="16.5" width="5" height="4.5" rx="1"/><path d="M12 7.5v9M5.5 16.5V12h13v4.5"/><rect class="a" x="9.5" y="16.5" width="5" height="4.5" rx="1"/>',
        'tag'       => '<path d="M3.5 12.2V4.5a1 1 0 0 1 1-1h7.7l8.3 8.3a1.5 1.5 0 0 1 0 2.1l-6.6 6.6a1.5 1.5 0 0 1-2.1 0z"/><circle class="a" cx="8" cy="8" r="1.6"/>',
        'link'      => '<path d="M10 14a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1 1"/><path class="a" d="M14 10a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1-1"/>',
        'arrows'    => '<path d="M4 8h13M13.5 4.5 17 8l-3.5 3.5"/><path class="a" d="M20 16H7M10.5 12.5 7 16l3.5 3.5"/>',
        'ranges'    => '<path d="M4 7h3M11 7h9M4 17h9M17 17h3"/><circle class="a" cx="9" cy="7" r="2"/><circle cx="15" cy="17" r="2"/><path d="M4 12h16" stroke-dasharray="1 3"/>',
        'branch'    => '<circle cx="6.5" cy="5.5" r="2"/><circle cx="6.5" cy="18.5" r="2"/><path d="M6.5 7.5v9M17.5 10.5c0 4-11 2.5-11 6"/><circle class="a" cx="17.5" cy="8.5" r="2"/>',
        'flow'      => '<rect x="3" y="4" width="6" height="6" rx="1.5"/><rect x="3" y="14" width="6" height="6" rx="1.5"/><path d="M9 7h2.5A1.5 1.5 0 0 1 13 8.5V12h2M9 17h2.5a1.5 1.5 0 0 0 1.5-1.5V12"/><rect class="a" x="15" y="9" width="6" height="6" rx="1.5"/>',
        'shield'    => '<path d="M12 3 19.5 6v5.5c0 4.5-3.2 8-7.5 9.5-4.3-1.5-7.5-5-7.5-9.5V6z"/><path class="a" d="m8.8 12 2.3 2.3L15.5 10"/>',
        'lock'      => '<rect x="4.5" y="10.5" width="15" height="10" rx="2"/><path d="M8 10.5v-3a4 4 0 0 1 8 0v3"/><path class="a" d="M12 14.5v2.5"/>',
        'check'     => '<rect x="3.5" y="3.5" width="17" height="17" rx="4"/><path class="a" d="m8 12.3 2.8 2.7L16 9"/>',
        'building'  => '<path d="M3.5 20.5h17"/><path d="M6 20.5v-15a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v15"/><path d="M15 9.5h2.5a1 1 0 0 1 1 1v10"/><path class="a" d="M9 8h3M9 11.5h3M9 15h3"/>',
        // AI + technology
        'chip'      => '<rect x="6" y="6" width="12" height="12" rx="2"/><path d="M9.5 3v3M14.5 3v3M9.5 18v3M14.5 18v3M3 9.5h3M3 14.5h3M18 9.5h3M18 14.5h3"/><rect class="a" x="9.5" y="9.5" width="5" height="5" rx="1"/>',
        'sparkle'   => '<path d="M12 3.5 13.8 9a2 2 0 0 0 1.2 1.2l5.5 1.8-5.5 1.8a2 2 0 0 0-1.2 1.2L12 20.5 10.2 15a2 2 0 0 0-1.2-1.2L3.5 12 9 10.2A2 2 0 0 0 10.2 9z"/><path class="a" d="M19 2.5v4M17 4.5h4"/>',
        'scan'      => '<path d="M4 8V5.5A1.5 1.5 0 0 1 5.5 4H8M16 4h2.5A1.5 1.5 0 0 1 20 5.5V8M20 16v2.5a1.5 1.5 0 0 1-1.5 1.5H16M8 20H5.5A1.5 1.5 0 0 1 4 18.5V16"/><path class="a" d="m8.5 12.2 2.4 2.3 4.6-5"/>',
        'browser'   => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="M3 9h18M6 6.8h.01M8.5 6.8h.01"/><path class="a" d="M7 13h6M7 16h9"/>',
        'mobile'    => '<rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M10.5 5.5h3"/><path class="a" d="M10.5 18.5h3"/>',
        'code'      => '<path d="m8 7-5 5 5 5M16 7l5 5-5 5"/><path class="a" d="m13.5 5-3 14"/>',
        'database'  => '<ellipse cx="12" cy="6" rx="7.5" ry="2.5"/><path d="M4.5 6v12c0 1.4 3.4 2.5 7.5 2.5s7.5-1.1 7.5-2.5V6"/><path class="a" d="M4.5 12c0 1.4 3.4 2.5 7.5 2.5s7.5-1.1 7.5-2.5"/>',
        'cloud'     => '<path d="M7 18.5a4.5 4.5 0 0 1-.6-8.96A6 6 0 0 1 18 9.5a4.5 4.5 0 0 1-1 9z"/><path class="a" d="M9.5 14.5h5"/>',
        // engagement + time
        'bolt'      => '<path d="M13 3 5 13.5h6L11 21l8-10.5h-6z"/><path class="a" d="M11 13.5 11 21"/>',
        'flag'      => '<path d="M5 21V3.5"/><path class="a" d="M5 4.5h12l-2.5 4 2.5 4H5"/>',
        'cycle'     => '<path d="M19.5 9A8 8 0 0 0 5 7.5M4.5 15A8 8 0 0 0 19 16.5"/><path d="M5 3.5v4h4"/><path class="a" d="M19 20.5v-4h-4"/>',
        'calendar'  => '<rect x="3.5" y="5" width="17" height="15.5" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/><path class="a" d="M8 14h3"/>',
        'clock'     => '<circle cx="12" cy="12" r="8.5"/><path class="a" d="M12 7.5V12l3 2"/>',
        'dot'       => '<circle cx="12" cy="12" r="8.5"/><circle class="a af" cx="12" cy="12" r="2"/>',
        // interface marks
        'plus'      => '<path d="M12 5v14M5 12h14"/>',
        'tick'      => '<path d="m5 12.5 4.5 4.5L19 7.5"/>',
        'x'         => '<path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/>',
        'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path class="a" d="m3.5 6.5 8.5 6.5 8.5-6.5"/>',
    ];
    $alias = ['people' => 'users', 'trend-up' => 'trend', 'sync' => 'cycle', 'page' => 'doc', 'gridgap' => 'grid', 'wave' => 'sound', 'rocket' => 'bolt'];
    $name = $alias[$name] ?? $name;
    if (!isset($I[$name]) && !function_exists('xt_icon') && is_file(__DIR__ . '/../tech/kit.php')) {
        require_once __DIR__ . '/../tech/kit.php';
    }
    if (!isset($I[$name]) && function_exists('xt_icon') && function_exists('xt_icons') && in_array($name, xt_icons(), true)) {
        return xt_icon($name, $o + ['class' => 'svc-ico']);
    }
    $body  = $I[$name] ?? $I['dot'];
    $size  = !empty($o['size']) ? (int) $o['size'] : 0;
    $dim   = $size ? ' width="' . $size . '" height="' . $size . '"' : '';
    $class = trim('svc-ico ' . ($o['class'] ?? ''));
    $a11y  = !empty($o['label']) ? ' role="img" aria-label="' . e($o['label']) . '"' : ' aria-hidden="true"';
    return '<svg class="' . e($class) . '" viewBox="0 0 24 24"' . $dim . ' fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"'
         . $a11y . ' focusable="false">' . $body . '</svg>';
}

}
