<?php /* DRAFT COPY — review before launch */
/**
 * Contact — reads the query, handles the POST and sends the lead. Include from contact.php after
 * partials/init.php and partials/services/lib.php, BEFORE any output (it may redirect and exit).
 *
 *   GET   ?service[]=<id>… (or ?service=a,b) · ?package=<key> · ?from=<page key>
 *         ids are validated with svc_resolve(); unknown ids are dropped and counted.
 *   GET   ?sent=1[&ref=XE-…][&from=…]  → the success state (Post/Redirect/Get target)
 *   POST  the form: validated, then one plain-text email to $SITE['company']['email'] with
 *         Reply-To set to the visitor. Success redirects (303) to ?sent=1; a failed mail() renders
 *         an honest error with a mailto: link holding the same brief. Nothing is stored anywhere.
 *
 * Protection: a honeypot field (bots get a quiet fake success), a signed render time with a
 * minimum fill time, length limits on every field, and header-injection-safe values (control
 * characters stripped, the email validated, every header value encoded).
 *
 * Produces $CT:
 *   'state'   'form' | 'sent' | 'failed'
 *   'v'       name, email, company, phone, services (ids), package, budget, timeline, message, from, pre (ids)
 *   'errors'  field => message          'dropped'  how many query ids were not recognised
 *   'ref'     'XE-XXXXXX' (sent / failed)   'mailto'  mailto: URL (failed)   't'  the signed time token
 *   'budgets' / 'timelines'  the option lists (value => label)
 *
 * Locals are prefixed ct_. PLACEHOLDER: confirm where leads should go (email / CRM) before launch.
 */

$CT = [
    'state' => 'form', 'app' => null, 'errors' => [], 'dropped' => 0, 'ref' => '', 'mailto' => '',
    'v' => ['name' => '', 'email' => '', 'company' => '', 'phone' => '', 'services' => [], 'package' => '',
            'budget' => '', 'timeline' => '', 'message' => '', 'from' => '', 'pre' => []],
    // PLACEHOLDER: confirm the currency and the bands before launch.
    'budgets' => [
        'under-25k' => 'Under $25k',
        '25k-50k'   => '$25k–$50k',
        '50k-100k'  => '$50k–$100k',
        '100k-250k' => '$100k–$250k',
        '250k-plus' => '$250k and above',
        'unsure'    => 'Not sure yet',
    ],
    'timelines' => [
        'asap'      => 'As soon as possible',
        '1-month'   => 'Within a month',
        '1-3'       => 'In one to three months',
        '3-6'       => 'In three to six months',
        'exploring' => 'Just exploring',
    ],
];

/** One line of text: control characters and line breaks removed, whitespace collapsed, length capped. */
function ct_line($s, int $max): string {
    $s = is_string($s) ? $s : '';
    $s = preg_replace('~[\x00-\x1F\x7F]+~u', ' ', $s) ?? '';
    $s = trim(preg_replace('~\s+~u', ' ', $s) ?? '');
    return mb_substr($s, 0, $max);
}
/** Free text: keeps line breaks, drops other control characters, caps the length. */
function ct_text($s, int $max): string {
    $s = is_string($s) ? str_replace(["\r\n", "\r"], "\n", $s) : '';
    $s = preg_replace('~[\x00-\x09\x0B-\x1F\x7F]~u', '', $s) ?? '';
    return mb_substr(trim($s), 0, $max);
}
function ct_key(): string { return hash('sha256', __FILE__ . '|' . php_uname('n') . '|xe-contact'); }
function ct_token(): string { $t = (string) time(); return $t . '.' . substr(hash_hmac('sha256', $t, ct_key()), 0, 20); }
/** Seconds since the form was rendered, or null when the token is missing or forged. */
function ct_age($tok): ?int {
    if (!is_string($tok) || !preg_match('~^(\d{9,11})\.([a-f0-9]{20})$~', $tok, $m)) return null;
    if (!hash_equals(substr(hash_hmac('sha256', $m[1], ct_key()), 0, 20), $m[2])) return null;
    return time() - (int) $m[1];
}
/** A careers application arrives as message "Application: <role> (<id>)" with from=careers.
    Returns ['role' =>, 'id' =>] so the page and the email can say it in plain words, or null. */
function ct_app(string $msg, string $from): ?array {
    if ($from !== 'careers' || !preg_match('~^\s*Application:\s*(.+?)\s*\(([A-Za-z0-9._-]{1,40})\)~u', $msg, $m)) return null;
    return ['role' => mb_substr(trim($m[1]), 0, 120), 'id' => $m[2]];
}
/** The same application, as a sentence a person would write. */
function ct_app_text(array $app, string $rest = ''): string {
    return 'I would like to apply for the ' . $app['role'] . ' role (reference ' . $app['id'] . ').' . ($rest !== '' ? "\n\n" . $rest : '');
}
function ct_from($s): string { return (is_string($s) && preg_match('~^[a-z0-9-]{1,64}$~', $s)) ? $s : ''; }
/** "Name <email>" with the name MIME-encoded, so nothing in it can break the header. */
function ct_addr(string $name, string $email): string {
    $name = trim(str_replace(['"', '<', '>', ',', ';', '\\'], '', $name));
    return ($name !== '' ? mb_encode_mimeheader($name, 'UTF-8', 'Q') . ' ' : '') . '<' . $email . '>';
}
/** The site root as an absolute URL, for links in the email. */
function ct_root(): string {
    $host   = preg_replace('~[^a-z0-9.:\-]~i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $path   = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $dir    = rtrim(str_replace('\\', '/', dirname($path)), '/');
    return $scheme . '://' . $host . $dir . '/';
}

/* ---------------- success (the Post/Redirect/Get target) ---------------- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && ($_GET['sent'] ?? '') === '1') {
    $CT['state'] = 'sent';
    $CT['ref'] = (is_string($_GET['ref'] ?? null) && preg_match('~^XE-[A-F0-9]{6}$~', $_GET['ref'])) ? $_GET['ref'] : '';
    $CT['v']['from'] = ct_from($_GET['from'] ?? '');
}

/* ---------------- arriving with a selection ---------------- */
elseif (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    $ct_raw = svc_ids($_GET['service'] ?? []);
    foreach ($ct_raw as $ct_id) {
        if (svc_resolve($ct_id)) $CT['v']['services'][] = $ct_id; else $CT['dropped']++;
    }
    $ct_pk = is_string($_GET['package'] ?? null) ? $_GET['package'] : '';
    $CT['v']['package'] = isset(svc_packages()[$ct_pk]) ? $ct_pk : '';
    $CT['v']['from']    = ct_from($_GET['from'] ?? '');
    $CT['v']['pre']     = $CT['v']['services'];
    $CT['v']['message'] = ct_text($_GET['message'] ?? '', 4000);   // careers links carry "Application: <role> (<id>)"
}

/* ---------------- arriving with a selection, posted from a service catalogue ----------------
   The catalogue posts rather than links so a brief of many services does not become a long query
   string. 'intent' marks it as a selection to pre-fill, not a completed enquiry to send. A single
   "Enquire" button posts 'only' with its own service id; the brief posts every ticked service[].
   The GET form above still works, so older links and shared URLs keep pre-filling. */
elseif (($_POST['intent'] ?? '') === 'select') {
    $ct_raw = (isset($_POST['only']) && is_string($_POST['only']))
        ? svc_ids($_POST['only'])
        : svc_ids($_POST['service'] ?? []);
    foreach ($ct_raw as $ct_id) {
        if (svc_resolve($ct_id)) $CT['v']['services'][] = $ct_id; else $CT['dropped']++;
    }
    /* a package card posts its own key; the brief's picker posts 'package' */
    $ct_pk = is_string($_POST['pick_package'] ?? null) && $_POST['pick_package'] !== ''
        ? $_POST['pick_package']
        : (is_string($_POST['package'] ?? null) ? $_POST['package'] : '');
    $CT['v']['package'] = isset(svc_packages()[$ct_pk]) ? $ct_pk : '';
    $CT['v']['from']    = ct_from($_POST['from'] ?? '');
    $CT['v']['pre']     = $CT['v']['services'];
    $CT['v']['message'] = ct_text($_POST['message'] ?? '', 4000);
}

/* ---------------- the form ---------------- */
else {
    $P = $_POST;
    $v = &$CT['v'];
    $v['name']     = ct_line($P['name'] ?? '', 120);
    $v['email']    = ct_line($P['email'] ?? '', 190);
    $v['company']  = ct_line($P['company'] ?? '', 160);
    $v['phone']    = ct_line($P['phone'] ?? '', 40);
    $v['message']  = ct_text($P['message'] ?? '', 4000);
    $v['from']     = ct_from($P['from'] ?? '');
    $v['services'] = array_values(array_filter(svc_ids($P['service'] ?? []), fn ($ct_x) => (bool) svc_resolve($ct_x)));
    $v['pre']      = array_values(array_filter(svc_ids($P['pre'] ?? ''), fn ($ct_x) => (bool) svc_resolve($ct_x)));
    $ct_pk = is_string($P['package'] ?? null) ? $P['package'] : '';
    $v['package']  = isset(svc_packages()[$ct_pk]) ? $ct_pk : '';
    $ct_b = is_string($P['budget'] ?? null) ? $P['budget'] : '';
    $ct_t = is_string($P['timeline'] ?? null) ? $P['timeline'] : '';
    $v['budget']   = isset($CT['budgets'][$ct_b]) ? $ct_b : '';
    $v['timeline'] = isset($CT['timelines'][$ct_t]) ? $ct_t : '';
    unset($v);

    /* bots: a filled honeypot gets a quiet success and nothing is sent */
    if (trim((string) ($P['website'] ?? '')) !== '') {
        header('Location: ' . xe_url('contact.php') . '?sent=1', true, 303);
        exit;
    }

    $ct_v = $CT['v'];
    $ct_e = [];
    if (mb_strlen($ct_v['name']) < 2) $ct_e['name'] = 'Enter your name.';
    if ($ct_v['email'] === '' || !filter_var($ct_v['email'], FILTER_VALIDATE_EMAIL)) $ct_e['email'] = 'Enter an email address we can reply to, like name@company.com.';
    if ($ct_v['phone'] !== '' && !preg_match('~^[0-9+().\s-]{6,40}$~', $ct_v['phone'])) $ct_e['phone'] = 'Use digits, spaces and + ( ) - only.';
    if (!$ct_v['services'] && mb_strlen($ct_v['message']) < 10) $ct_e['service'] = 'Choose at least one service, or tell us what you need in the message.';
    $ct_age = ct_age($P['t'] ?? null);
    if ($ct_age === null) $ct_e['form'] = 'This form expired. Check your answers and send it again.';
    elseif ($ct_age < 3) $ct_e['form'] = 'That was quick. Check your answers and send the brief again.';

    if ($ct_e) {
        $CT['errors'] = $ct_e;
    } else {
        /* ---------------- compose the lead ---------------- */
        $SITE_EMAIL = $SITE['company']['email'];   // PLACEHOLDER: confirm where leads should go (email / CRM) before launch
        $ct_ref  = 'XE-' . strtoupper(bin2hex(random_bytes(3)));
        $ct_pkg  = $ct_v['package'] ? svc_packages()[$ct_v['package']] : null;
        $ct_rows = array_map('svc_resolve', $ct_v['services']);
        $ct_root = ct_root();

        $ct_names = array_map(fn ($ct_r) => $ct_r['name'], $ct_rows);
        $ct_sum   = $ct_names ? $ct_names[0] . (count($ct_names) > 1 ? ' +' . (count($ct_names) - 1) . ' more' : '') : 'General enquiry';
        $ct_subj  = '[Lead] ' . $ct_sum . ($ct_pkg ? ' · ' . $ct_pkg['name'] : '') . ' · ' . ($ct_v['company'] !== '' ? $ct_v['company'] : $ct_v['name']);
        $ct_app = ct_app($ct_v['message'], $ct_v['from']) ?? ct_app(is_string($P['apply'] ?? null) ? $P['apply'] : '', $ct_v['from']);
        if ($ct_app) {
            if (preg_match('~^\s*Application:~', $ct_v['message'])) {   // sent straight from a careers form: say it in words
                $ct_v['message'] = ct_app_text($ct_app, trim(preg_replace('~^\s*Application:\s*.+?\([A-Za-z0-9._-]{1,40}\)\s*~u', '', $ct_v['message'], 1)));
            }
            $ct_subj = '[Application] ' . $ct_app['role'] . ' (' . $ct_app['id'] . ') · ' . $ct_v['name'];   // PLACEHOLDER: route applications to careers@ once that inbox exists
        }
        $ct_subj  = ct_line($ct_subj, 180);

        $ct_src = '—';
        if ($ct_v['from'] !== '') {
            $ct_m   = svc_page_meta($ct_v['from']);
            $ct_src = $ct_m['name'] . ' (' . $ct_v['from'] . ')' . (!empty($ct_m['url']) ? ' — ' . $ct_root . preg_replace('~^(\.\./|\./)+~', '', $ct_m['url']) : '');
        }

        $L   = [];
        $L[] = 'New brief from the ' . $SITE['company']['name'] . ' website';
        $L[] = 'Reference: ' . $ct_ref;
        $L[] = 'Received:  ' . gmdate('j M Y, H:i') . ' UTC';
        $L[] = '';
        $L[] = '— CONTACT';
        $L[] = 'Name:       ' . $ct_v['name'];
        $L[] = 'Work email: ' . $ct_v['email'];
        $L[] = 'Company:    ' . ($ct_v['company'] !== '' ? $ct_v['company'] : '—');
        $L[] = 'Phone:      ' . ($ct_v['phone'] !== '' ? $ct_v['phone'] : '—');
        $L[] = '';
        $L[] = '— SERVICES (' . count($ct_rows) . ')';
        if (!$ct_rows) $L[] = 'None chosen. See the message.';
        foreach ($ct_rows as $ct_r) {
            $L[] = '• ' . $ct_r['name'] . '  [' . $ct_r['id'] . ']';
            $L[] = '  ' . $ct_r['discipline'] . ' › ' . ($ct_r['hub'] ? 'Overview' : $ct_r['page']) . ' › ' . $ct_r['category'];
        }
        $L[] = '';
        $L[] = '— ENGAGEMENT PACKAGE';
        $L[] = $ct_pkg ? $ct_pkg['name'] . ' (' . $ct_pkg['key'] . ') · ' . $ct_pkg['pricing'] : 'Not sure yet';
        $L[] = '';
        $L[] = '— BUDGET AND TIMING';
        $L[] = 'Budget:   ' . ($ct_v['budget'] !== '' ? $CT['budgets'][$ct_v['budget']] : '—');
        $L[] = 'Timeline: ' . ($ct_v['timeline'] !== '' ? $CT['timelines'][$ct_v['timeline']] : '—');
        $L[] = '';
        $L[] = '— MESSAGE';
        $L[] = $ct_v['message'] !== '' ? $ct_v['message'] : '—';
        $L[] = '';
        $L[] = '— SOURCE';
        $L[] = 'Source page:   ' . $ct_src;
        $L[] = 'Pre-selected:  ' . ($ct_v['pre'] ? implode(', ', $ct_v['pre']) : '—');
        $L[] = 'Service ids:   ' . ($ct_v['services'] ? implode(', ', $ct_v['services']) : '—');
        $L[] = 'Package key:   ' . ($ct_v['package'] !== '' ? $ct_v['package'] : '—');
        $L[] = 'Contact page:  ' . $ct_root . preg_replace('~^(\.\./|\./)+~', '', xe_url('contact.php'));
        $ct_body = implode("\n", $L) . "\n";

        $ct_headers = [
            'From'                      => ct_addr($SITE['company']['name'] . ' website', $SITE_EMAIL),   // PLACEHOLDER: a sending address on the live domain
            'Reply-To'                  => ct_addr($ct_v['name'], $ct_v['email']),
            'MIME-Version'              => '1.0',
            'Content-Type'              => 'text/plain; charset=UTF-8',
            'Content-Transfer-Encoding' => '8bit',
            'X-XE-Lead'                 => $ct_ref,
        ];
        $ct_ok = function_exists('mail')
            && @mail($SITE_EMAIL, mb_encode_mimeheader($ct_subj, 'UTF-8', 'B', "\r\n"), str_replace("\n", "\r\n", $ct_body), $ct_headers);

        if ($ct_ok) {
            header('Location: ' . xe_url('contact.php') . '?sent=1&ref=' . $ct_ref . ($ct_v['from'] !== '' ? '&from=' . rawurlencode($ct_v['from']) : ''), true, 303);
            exit;
        }

        error_log('contact: mail() failed for lead ' . $ct_ref);
        $CT['state'] = 'failed';
        $CT['ref']   = $ct_ref;
        /* mailto: bodies are capped by most mail apps at about 2,000 characters */
        $ct_short = mb_strlen($ct_body) > 1600 ? mb_substr($ct_body, 0, 1580) . "\n[…]" : $ct_body;
        $CT['mailto'] = 'mailto:' . $SITE_EMAIL . '?subject=' . rawurlencode($ct_subj) . '&body=' . rawurlencode($ct_short);
    }
}

/* A careers application reads as a sentence on the page ("I would like to apply for the … role"),
   and the page switches to its application wording. The success redirect keeps from=careers. */
$CT['app'] = ct_app($CT['v']['message'], $CT['v']['from'])
    ?? ct_app(is_string($_POST['apply'] ?? null) ? $_POST['apply'] : '', $CT['v']['from']);
if ($CT['app'] && $CT['state'] !== 'sent' && strpos($CT['v']['message'], 'I would like to apply') !== 0) {
    $ct_rest = trim(preg_replace('~^\s*Application:\s*.+?\([A-Za-z0-9._-]{1,40}\)\s*~u', '', $CT['v']['message'], 1));
    $CT['v']['message'] = ct_app_text($CT['app'], $ct_rest);
}
$CT['t'] = ct_token();
