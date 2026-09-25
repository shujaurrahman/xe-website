<?php
/**
 * Apply — reads the query, handles the POST and sends the application. Include from
 * careers/apply.php after partials/init.php and partials/careers/lib.php, BEFORE any output
 * (it may redirect and exit).
 *
 * This follows exactly the mechanism contact.php already uses (partials/contact/handler.php):
 * validate, compose one email to $SITE['company']['email'] with Reply-To set to the applicant,
 * send it with mail(), then Post/Redirect/Get to ?sent=1. Nothing is written to disk and nothing
 * is stored on the website. The one addition is that the email is multipart/mixed so the CV can
 * ride along as a real attachment rather than being promised and dropped.
 *
 *   GET   ?role=<slug>            pre-selects that role (validated against data/careers.php)
 *   GET   ?sent=1[&ref=XE-…]      the success state (the Post/Redirect/Get target)
 *   POST  the form (multipart/form-data): validated, emailed, then redirected.
 *
 * Protection: a honeypot field (bots get a quiet fake success), a signed render time with a minimum
 * fill time, length limits on every field, header-injection-safe values (control characters
 * stripped, the address validated, every header value encoded), and an upload that is checked for
 * size, extension and sniffed media type before it is attached.
 *
 * Produces $APL:
 *   'state'    'form' | 'sent' | 'failed'
 *   'v'        name, email, phone, role, portfolio, location, notice, why
 *   'errors'   field => message      't'  the signed time token
 *   'role_gone' the ?role= slug we did not recognise, so the page can say so
 *   'ref'      'XE-A-XXXXXX' (sent / failed)     'mailto'  mailto: URL (failed, no attachment)
 *   'cv'       ['name','size'] of the file that was attached, or null
 *   'cv_lost'  true when a file was uploaded but the form came back with errors, so it was dropped
 *   'notices'  the notice-period options (value => label)      'max_cv'  the real upload cap in bytes
 *
 * Locals are prefixed apl_. PLACEHOLDER: confirm where applications should go (a hiring inbox, an
 * applicant tracking system) and that the live host can send mail, before launch.
 */

$APL = [
    'state'   => 'form',
    'errors'  => [],
    'ref'     => '',
    'mailto'  => '',
    'cv'      => null,
    'cv_lost' => false,
    'role_gone' => '',
    'v' => ['name' => '', 'email' => '', 'phone' => '', 'role' => '', 'portfolio' => '', 'location' => '', 'notice' => '', 'why' => ''],
    'notices' => [
        'immediate' => 'Available immediately',
        '15-days'   => 'Up to 15 days',
        '30-days'   => '30 days',
        '60-days'   => '60 days',
        '90-days'   => '90 days',
        'discuss'   => 'Longer, or still to be agreed',
    ],
];

/** One line of text: control characters and line breaks removed, whitespace collapsed, length capped. */
function apl_line($s, int $max): string {
    $s = is_string($s) ? $s : '';
    $s = preg_replace('~[\x00-\x1F\x7F]+~u', ' ', $s) ?? '';
    $s = trim(preg_replace('~\s+~u', ' ', $s) ?? '');
    return mb_substr($s, 0, $max);
}
/** Free text: keeps line breaks, drops other control characters, caps the length. */
function apl_text($s, int $max): string {
    $s = is_string($s) ? str_replace(["\r\n", "\r"], "\n", $s) : '';
    $s = preg_replace('~[\x00-\x09\x0B-\x1F\x7F]~u', '', $s) ?? '';
    return mb_substr(trim($s), 0, $max);
}
function apl_key(): string { return hash('sha256', __FILE__ . '|' . php_uname('n') . '|xe-apply'); }
function apl_token(): string { $t = (string) time(); return $t . '.' . substr(hash_hmac('sha256', $t, apl_key()), 0, 20); }
/** Seconds since the form was rendered, or null when the token is missing or forged. */
function apl_age($tok): ?int {
    if (!is_string($tok) || !preg_match('~^(\d{9,11})\.([a-f0-9]{20})$~', $tok, $m)) return null;
    if (!hash_equals(substr(hash_hmac('sha256', $m[1], apl_key()), 0, 20), $m[2])) return null;
    return time() - (int) $m[1];
}
/** "Name <email>" with the name MIME-encoded, so nothing in it can break the header. */
function apl_addr(string $name, string $email): string {
    $name = trim(str_replace(['"', '<', '>', ',', ';', '\\'], '', $name));
    return ($name !== '' ? mb_encode_mimeheader($name, 'UTF-8', 'Q') . ' ' : '') . '<' . $email . '>';
}
/** The site root as an absolute URL, for links in the email. */
function apl_root(): string {
    $host   = preg_replace('~[^a-z0-9.:\-]~i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $scheme . '://' . $host . '/';
}
/** A php.ini size ('8M', '512K') in bytes. */
function apl_bytes(string $v): int {
    $v = trim($v);
    if ($v === '') return 0;
    $n = (int) $v;
    switch (strtolower(substr($v, -1))) {
        case 'g': return $n * 1024 * 1024 * 1024;
        case 'm': return $n * 1024 * 1024;
        case 'k': return $n * 1024;
    }
    return $n;
}
/**
 * The largest CV this host can actually accept: our own 5 MB ceiling, capped by whatever
 * upload_max_filesize and post_max_size allow, so the label on the field is never a lie.
 */
function apl_max_cv(): int {
    $ours = 5 * 1024 * 1024;
    $up   = apl_bytes((string) ini_get('upload_max_filesize'));
    $post = apl_bytes((string) ini_get('post_max_size'));
    $lim  = $ours;
    if ($up > 0)   $lim = min($lim, $up);
    if ($post > 0) $lim = min($lim, max(0, $post - 262144));   // leave room for the text fields
    return max(0, $lim);
}
/** '4.8 MB' / '480 KB' */
function apl_size(int $b): string {
    if ($b >= 1024 * 1024) {
        $mb = $b / (1024 * 1024);
        return rtrim(rtrim(number_format($mb, $mb < 10 ? 1 : 0, '.', ''), '0'), '.') . ' MB';
    }
    return max(1, (int) round($b / 1024)) . ' KB';
}
/** '[Application] Senior Brand Designer · Name' */
function apl_subject(string $role, string $name): string {
    return apl_line('[Application] ' . $role . ' · ' . $name, 180);
}

/** A URL as a human would type it: 'xterraedze.com/x' and 'https://…' both accepted. */
function apl_url(string $raw): ?string {
    if ($raw === '') return null;
    $u = preg_match('~^https?://~i', $raw) ? $raw : 'https://' . ltrim($raw, '/');
    if (!filter_var($u, FILTER_VALIDATE_URL)) return null;
    $host = parse_url($u, PHP_URL_HOST);
    if (!$host || strpos($host, '.') === false) return null;
    return $u;
}

$APL['max_cv'] = apl_max_cv();

/* ---------------- success (the Post/Redirect/Get target) ---------------- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && ($_GET['sent'] ?? '') === '1') {
    $APL['state'] = 'sent';
    $APL['ref']   = (is_string($_GET['ref'] ?? null) && preg_match('~^XE-A-[A-F0-9]{6}$~', $_GET['ref'])) ? $_GET['ref'] : '';
    $apl_r = is_string($_GET['role'] ?? null) ? $_GET['role'] : '';
    if ($apl_r !== '' && car_role($apl_r)) $APL['v']['role'] = $apl_r;
    $APL['cv'] = ($_GET['cv'] ?? '') === '1' ? ['name' => '', 'size' => 0] : null;
}

/* ---------------- arriving from a role ---------------- */
elseif (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    $apl_r = is_string($_GET['role'] ?? null) ? $_GET['role'] : '';
    /* an unknown slug is simply not pre-selected — the page says so rather than failing */
    if ($apl_r !== '' && car_role($apl_r)) $APL['v']['role'] = $apl_r;
    elseif ($apl_r !== '') $APL['role_gone'] = $apl_r;
}

/* ---------------- the form ---------------- */
else {
    /* An upload bigger than post_max_size arrives with $_POST and $_FILES both empty. Without this
       the page would look like a form that silently lost everything. */
    if (!$_POST && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $APL['errors']['form'] = 'That was too large for the server to accept, so nothing came through. '
            . 'The limit on this server is ' . apl_size(apl_bytes((string) ini_get('post_max_size')))
            . ' for the whole form. Send a smaller CV, or leave the file out and give us a link to it.';
        $APL['t'] = apl_token();
        return;
    }

    $P = $_POST;
    $v = &$APL['v'];
    $v['name']      = apl_line($P['name'] ?? '', 120);
    $v['email']     = apl_line($P['email'] ?? '', 190);
    $v['phone']     = apl_line($P['phone'] ?? '', 40);
    $v['portfolio'] = apl_line($P['portfolio'] ?? '', 300);
    $v['location']  = apl_line($P['location'] ?? '', 120);
    $v['why']       = apl_text($P['why'] ?? '', 2000);
    $apl_role       = apl_line($P['role'] ?? '', 80);
    $v['role']      = ($apl_role !== '' && car_role($apl_role)) ? $apl_role : '';
    $apl_nt         = is_string($P['notice'] ?? null) ? $P['notice'] : '';
    $v['notice']    = isset($APL['notices'][$apl_nt]) ? $apl_nt : '';
    unset($v);

    /* bots: a filled honeypot gets a quiet success and nothing is sent */
    if (trim((string) ($P['website'] ?? '')) !== '') {
        header('Location: ' . xe_url('careers/apply.php') . '?sent=1', true, 303);
        exit;
    }

    $apl_v = $APL['v'];
    $apl_e = [];
    if (mb_strlen($apl_v['name']) < 2) $apl_e['name'] = 'Enter your name.';
    if ($apl_v['email'] === '' || !filter_var($apl_v['email'], FILTER_VALIDATE_EMAIL)) $apl_e['email'] = 'Enter an email address we can reply to, like name@example.com.';
    if ($apl_v['phone'] === '') $apl_e['phone'] = 'Enter a phone number, including the country code.';
    elseif (!preg_match('~^[0-9+().\s-]{6,40}$~', $apl_v['phone'])) $apl_e['phone'] = 'Use digits, spaces and + ( ) - only.';
    if ($apl_role !== '' && $apl_v['role'] === '') $apl_e['role'] = 'That role is not open any more. Choose one from the list, or send a general application.';
    $apl_link = apl_url($apl_v['portfolio']);
    if ($apl_v['portfolio'] === '') $apl_e['portfolio'] = 'Add one link to your work — a portfolio, a repository, a LinkedIn profile or your own site.';
    elseif ($apl_link === null) $apl_e['portfolio'] = 'That does not look like a web address. Something like yourname.com or linkedin.com/in/yourname.';
    if (mb_strlen($apl_v['location']) < 2) $apl_e['location'] = 'Tell us which city you are in.';
    if ($apl_v['notice'] === '') $apl_e['notice'] = 'Choose how soon you could start.';
    if (mb_strlen($apl_v['why']) < 60) $apl_e['why'] = 'A few sentences, please — at least 60 characters. It is the part we read most closely.';

    $apl_age = apl_age($P['t'] ?? null);
    if ($apl_age === null) $apl_e['form'] = 'This form expired. Check your answers and send it again.';
    elseif ($apl_age < 4) $apl_e['form'] = 'That was quick. Check your answers and send the application again.';

    /* ---- the CV: optional, checked on size, extension and sniffed media type ---- */
    $apl_f    = $_FILES['cv'] ?? null;
    $apl_file = null;                                     // ['name','size','tmp','mime']
    $apl_got  = is_array($apl_f) && (int) ($apl_f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE;
    if ($apl_got) {
        $apl_err  = (int) $apl_f['error'];
        $apl_ok   = ['pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $apl_name = apl_line((string) ($apl_f['name'] ?? ''), 160);
        $apl_ext  = strtolower((string) pathinfo($apl_name, PATHINFO_EXTENSION));
        if ($apl_err === UPLOAD_ERR_INI_SIZE || $apl_err === UPLOAD_ERR_FORM_SIZE) {
            $apl_e['cv'] = 'That file is over the ' . apl_size($APL['max_cv']) . ' limit. Send a smaller PDF, or leave it out and give us a link.';
        } elseif ($apl_err !== UPLOAD_ERR_OK || !is_uploaded_file((string) ($apl_f['tmp_name'] ?? ''))) {
            $apl_e['cv'] = 'The file did not upload. Try again, or leave it out and give us a link to your CV.';
        } elseif ((int) $apl_f['size'] <= 0) {
            $apl_e['cv'] = 'That file is empty. Check it opens on your side and try again.';
        } elseif ((int) $apl_f['size'] > $APL['max_cv']) {
            $apl_e['cv'] = 'That file is ' . apl_size((int) $apl_f['size']) . '. The limit is ' . apl_size($APL['max_cv']) . '.';
        } elseif (!isset($apl_ok[$apl_ext])) {
            $apl_e['cv'] = 'PDF, DOC or DOCX only. A PDF travels best.';
        } else {
            $apl_mime = $apl_ok[$apl_ext];
            if (function_exists('finfo_open') && ($apl_fi = finfo_open(FILEINFO_MIME_TYPE))) {
                $apl_sniff = (string) finfo_file($apl_fi, (string) $apl_f['tmp_name']);
                finfo_close($apl_fi);
                /* What each extension is actually allowed to sniff as. A .pdf must be a PDF. A .docx is
                   a zip, and a .doc is an OLE container that some builds of libmagic only identify as
                   a generic binary, so those two are given the wider list rather than every upload. */
                $apl_sniffs = [
                    'pdf'  => ['application/pdf'],
                    'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage', 'application/octet-stream'],
                    'docx' => [$apl_mime, 'application/zip', 'application/octet-stream'],
                ];
                if ($apl_sniff !== '' && !in_array($apl_sniff, $apl_sniffs[$apl_ext], true)) {
                    $apl_e['cv'] = 'That file is not a PDF or Word document, whatever it is named. Export it again and retry.';
                }
            }
            if (!isset($apl_e['cv'])) {
                $apl_safe = preg_replace('~[^A-Za-z0-9._-]+~', '-', $apl_name) ?: 'cv';
                $apl_file = ['name' => trim($apl_safe, '-'), 'size' => (int) $apl_f['size'], 'tmp' => (string) $apl_f['tmp_name'], 'mime' => $apl_mime];
            }
        }
    }

    if ($apl_e) {
        $APL['errors'] = $apl_e;
        /* a file input cannot be re-populated from the server, so say so rather than lose it quietly */
        $APL['cv_lost'] = $apl_got && !isset($apl_e['cv']);
    } else {
        /* ---------------- compose the application ---------------- */
        // PLACEHOLDER: confirm where applications should go (a hiring inbox, or an applicant tracking system) before launch
        $APL_EMAIL = $SITE['company']['email'];
        $apl_ref   = 'XE-A-' . strtoupper(bin2hex(random_bytes(3)));
        $apl_r     = $apl_v['role'] !== '' ? car_role($apl_v['role']) : null;
        $apl_g     = $apl_r ? car_group($apl_r['discipline']) : null;
        $apl_root  = apl_root();

        $apl_subj = apl_subject($apl_r ? $apl_r['title'] : 'General application', $apl_v['name']);

        $L   = [];
        $L[] = 'New application from the ' . $SITE['company']['name'] . ' website';
        $L[] = 'Reference: ' . $apl_ref;
        $L[] = 'Received:  ' . gmdate('j M Y, H:i') . ' UTC';
        $L[] = '';
        $L[] = '— ROLE';
        $L[] = 'Applied for: ' . ($apl_r ? $apl_r['title'] : 'General application (no specific role)');
        if ($apl_r) {
            $L[] = 'Practice:    ' . ($apl_g ? $apl_g['name'] : $apl_r['discipline']);
            $L[] = 'Based:       ' . car_loc_line($apl_r);
            $L[] = 'Slug:        ' . $apl_r['slug'];
            $L[] = 'Listing:     ' . $apl_root . 'careers#role-' . $apl_r['slug'];
        }
        $L[] = '';
        $L[] = '— CANDIDATE';
        $L[] = 'Name:      ' . $apl_v['name'];
        $L[] = 'Email:     ' . $apl_v['email'];
        $L[] = 'Phone:     ' . $apl_v['phone'];
        $L[] = 'Location:  ' . $apl_v['location'];
        $L[] = 'Notice:    ' . $APL['notices'][$apl_v['notice']];
        $L[] = 'Work link: ' . $apl_link;
        $L[] = '';
        $L[] = '— WHY US';
        $L[] = $apl_v['why'];
        $L[] = '';
        $L[] = '— CV';
        $L[] = $apl_file ? 'Attached: ' . $apl_file['name'] . ' (' . apl_size($apl_file['size']) . ')' : 'Not attached. See the work link above.';
        $L[] = '';
        $L[] = '— SOURCE';
        $L[] = 'Apply page: ' . $apl_root . 'careers/apply';
        $apl_text = implode("\n", $L) . "\n";

        /* multipart/mixed so the CV is a real attachment. Built with \n and converted to \r\n once. */
        $apl_bd   = 'xe-' . bin2hex(random_bytes(12));
        $apl_body = "This is a multi-part message in MIME format.\n\n"
                  . '--' . $apl_bd . "\n"
                  . "Content-Type: text/plain; charset=UTF-8\n"
                  . "Content-Transfer-Encoding: 8bit\n\n"
                  . $apl_text . "\n";
        if ($apl_file) {
            $apl_raw = (string) file_get_contents($apl_file['tmp']);
            $apl_body .= '--' . $apl_bd . "\n"
                      . 'Content-Type: ' . $apl_file['mime'] . '; name="' . $apl_file['name'] . "\"\n"
                      . "Content-Transfer-Encoding: base64\n"
                      . 'Content-Disposition: attachment; filename="' . $apl_file['name'] . "\"\n\n"
                      . chunk_split(base64_encode($apl_raw), 76, "\n") . "\n";
        }
        $apl_body .= '--' . $apl_bd . "--\n";

        $apl_headers = [
            'From'         => apl_addr($SITE['company']['name'] . ' website', $APL_EMAIL),   // PLACEHOLDER: a sending address on the live domain
            'Reply-To'     => apl_addr($apl_v['name'], $apl_v['email']),
            'MIME-Version' => '1.0',
            'Content-Type' => 'multipart/mixed; boundary="' . $apl_bd . '"',
            'X-XE-Apply'   => $apl_ref,
        ];
        $apl_sent = function_exists('mail')
            && @mail($APL_EMAIL, mb_encode_mimeheader($apl_subj, 'UTF-8', 'B', "\r\n"), str_replace("\n", "\r\n", $apl_body), $apl_headers);

        if ($apl_sent) {
            header('Location: ' . xe_url('careers/apply.php') . '?sent=1&ref=' . $apl_ref
                . ($apl_v['role'] !== '' ? '&role=' . rawurlencode($apl_v['role']) : '')
                . ($apl_file ? '&cv=1' : ''), true, 303);
            exit;
        }

        error_log('apply: mail() failed for application ' . $apl_ref);
        $APL['state'] = 'failed';
        $APL['ref']   = $apl_ref;
        $APL['cv']    = $apl_file ? ['name' => $apl_file['name'], 'size' => $apl_file['size']] : null;
        /* mailto: bodies are capped by most mail apps at about 2,000 characters, and a mailto can
           never carry the file — the page tells the applicant to attach it themselves. */
        $apl_short = mb_strlen($apl_text) > 1600 ? mb_substr($apl_text, 0, 1580) . "\n[…]" : $apl_text;
        $APL['mailto'] = 'mailto:' . $APL_EMAIL . '?subject=' . rawurlencode($apl_subj) . '&body=' . rawurlencode($apl_short);
    }
}

$APL['t'] = apl_token();
