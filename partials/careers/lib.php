<?php
/**
 * Careers — shared helpers over data/careers.php. Safe to require_once from
 * careers.php and careers/apply.php (every function is guarded). Needs
 * partials/init.php first, for $SITE-derived discipline names.
 *
 *   car_data()                    the whole file, normalised: groups, locations, types, roles
 *   car_roles()                   slug => role, in file order, every role normalised
 *   car_role(string $slug)        one role or null — this is what validates ?role=…
 *   car_groups()                  group key => ['key','name','url'] for every group used by a role,
 *                                 the six disciplines first (in data/site.php order), extras after
 *   car_group(string $key)        one group or null
 *   car_locations() / car_types() key => label, only the ones roles actually use
 *   car_loc_line(array $role)     'New Delhi or Ludhiana · Hybrid'
 *   car_apply_url(?string $slug)  the apply page, with ?role= when a slug is given
 *
 * Nothing here writes. A malformed role (no slug, no title) is dropped rather than
 * half-rendered, so a typo in the data file cannot break the page.
 */

if (!function_exists('car_data')) {

/** 'Remote (India)' → 'remote-india' — a stable key for a label written in the data file. */
function car_key(string $label): string {
    return trim(preg_replace('~[^a-z0-9]+~', '-', strtolower($label)), '-');
}

/**
 * data/careers.php is the careers page's own file, and the careers page reads it directly in its
 * own shape: roles as [id, title, dept, loc, type, level, summary, resp, req, nice], with the
 * department, location and type written out as labels. This helper only serves careers/apply.php,
 * so rather than change a file the careers page owns, it maps that shape onto the one below.
 * A file written in the older shape (slug, discipline, locations[] …) is still read as-is.
 */
function car_from_labels(array $raw): array {
    $site  = $GLOBALS['SITE']['disciplines'] ?? [];
    $bydep = [];                                   // department label → discipline slug
    foreach ($site as $d) $bydep[$d['name']] = $d['slug'];
    $raw += ['locations' => [], 'types' => [], 'groups' => []];
    foreach (($raw['roles'] ?? []) as $i => $r) {
        if (!isset($r['id']) || isset($r['slug'])) continue;
        $dep = (string) ($r['dept'] ?? '');
        $grp = $bydep[$dep] ?? car_key($dep);      // a department that is not a discipline becomes its own group
        if ($dep !== '' && !isset($bydep[$dep])) $raw['groups'][$grp] = $dep;
        $loc = (string) ($r['loc'] ?? '');
        if ($loc !== '') $raw['locations'][car_key($loc)] = $loc;
        $typ = (string) ($r['type'] ?? '');
        if ($typ !== '') $raw['types'][car_key($typ)] = $typ;
        $raw['roles'][$i] = [
            'slug'       => (string) $r['id'],
            'title'      => $r['title'] ?? '',
            'discipline' => $grp,
            'locations'  => $loc !== '' ? [car_key($loc)] : [],
            'mode'       => '',
            'type'       => $typ !== '' ? car_key($typ) : '',
            'experience' => (string) ($r['level'] ?? ''),
            'does'       => (string) ($r['summary'] ?? ''),
            'work'       => (array) ($r['resp'] ?? []),
            'look'       => (array) ($r['req'] ?? []),
            'nice'       => (array) ($r['nice'] ?? []),
        ];
    }
    return $raw;
}

function car_data(): array {
    static $D = null;
    if ($D !== null) return $D;

    $raw   = car_from_labels(require __DIR__ . '/../../data/careers.php');
    $locs  = is_array($raw['locations'] ?? null) ? $raw['locations'] : [];
    $types = is_array($raw['types'] ?? null) ? $raw['types'] : [];
    $roles = [];

    foreach (($raw['roles'] ?? []) as $r) {
        $slug = isset($r['slug']) ? preg_replace('~[^a-z0-9-]~', '', strtolower((string) $r['slug'])) : '';
        if ($slug === '' || empty($r['title']) || isset($roles[$slug])) continue;
        $rl = array_values(array_filter(
            array_map('strval', (array) ($r['locations'] ?? [])),
            fn ($k) => isset($locs[$k])
        ));
        $roles[$slug] = [
            'slug'       => $slug,
            'title'      => (string) $r['title'],
            'discipline' => (string) ($r['discipline'] ?? ''),
            'locations'  => $rl,
            'mode'       => (string) ($r['mode'] ?? ''),
            'type'       => isset($types[$r['type'] ?? '']) ? (string) $r['type'] : '',
            'experience' => (string) ($r['experience'] ?? ''),
            'does'       => (string) ($r['does'] ?? ''),
            'work'       => array_values(array_map('strval', (array) ($r['work'] ?? []))),
            'look'       => array_values(array_map('strval', (array) ($r['look'] ?? []))),
            'nice'       => array_values(array_map('strval', (array) ($r['nice'] ?? []))),
        ];
    }

    return $D = [
        'groups'    => is_array($raw['groups'] ?? null) ? $raw['groups'] : [],
        'locations' => $locs,
        'types'     => $types,
        'roles'     => $roles,
    ];
}

function car_roles(): array { return car_data()['roles']; }

function car_role(string $slug): ?array {
    $r = car_roles();
    return $r[$slug] ?? null;
}

/** Every group at least one role sits in: the six disciplines in site order, then the extras. */
function car_groups(): array {
    static $G = null;
    if ($G !== null) return $G;
    global $SITE;
    $used = [];
    foreach (car_roles() as $r) { $used[$r['discipline']] = ($used[$r['discipline']] ?? 0) + 1; }

    $G = [];
    foreach (($SITE['disciplines'] ?? []) as $d) {
        if (!isset($used[$d['slug']])) continue;
        $G[$d['slug']] = ['key' => $d['slug'], 'name' => $d['name'], 'short' => $d['short'], 'url' => xe_discipline_url($d)];
    }
    foreach (car_data()['groups'] as $k => $name) {
        if (!isset($used[$k]) || isset($G[$k])) continue;
        $G[$k] = ['key' => (string) $k, 'name' => (string) $name, 'short' => (string) $name, 'url' => ''];
    }
    /* a role pointing at a group nobody defined still needs somewhere to live */
    foreach ($used as $k => $n) {
        if ($k === '' || isset($G[$k])) continue;
        $G[$k] = ['key' => (string) $k, 'name' => ucwords(str_replace('-', ' ', (string) $k)), 'short' => (string) $k, 'url' => ''];
    }
    if (isset($used[''])) $G[''] = ['key' => '', 'name' => 'Other roles', 'short' => 'Other', 'url' => ''];
    return $G;
}

function car_group(string $key): ?array {
    $g = car_groups();
    return $g[$key] ?? null;
}

/** Only the locations and types roles actually use, in data-file order. */
function car_locations(): array {
    $used = [];
    foreach (car_roles() as $r) { foreach ($r['locations'] as $k) $used[$k] = true; }
    return array_filter(car_data()['locations'], fn ($v, $k) => isset($used[$k]), ARRAY_FILTER_USE_BOTH);
}

function car_types(): array {
    $used = [];
    foreach (car_roles() as $r) { if ($r['type'] !== '') $used[$r['type']] = true; }
    return array_filter(car_data()['types'], fn ($v, $k) => isset($used[$k]), ARRAY_FILTER_USE_BOTH);
}

/** 'New Delhi or Ludhiana · Hybrid' */
function car_loc_line(array $role): string {
    $all   = car_data()['locations'];
    $names = array_values(array_map(fn ($k) => $all[$k] ?? $k, $role['locations']));
    $where = count($names) > 1
        ? implode(', ', array_slice($names, 0, -1)) . ' or ' . end($names)
        : ($names[0] ?? 'India');
    return $role['mode'] !== '' ? $where . ' · ' . $role['mode'] : $where;
}

function car_apply_url(?string $slug = null): string {
    return xe_url('careers/apply.php') . ($slug ? '?role=' . rawurlencode($slug) : '');
}

}
