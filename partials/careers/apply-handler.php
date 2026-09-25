<?php
/**
 * Apply — reads the query, handles the POST and sends the application. Include from
 * careers/apply.php after partials/init.php and partials/careers/lib.php, BEFORE any output
 * (it may redirect and exit).
 *
 * This follows exactly the mechanism contact.php already uses (partials/contact/handler.php):
 * validate, compose one email to $SITE['company']['email'] with Reply-To set to the applicant,
 * send it with mail(), then Post/Redirect/Get to ?sent=1. Nothing is written to disk and nothing
 * is stored on the website. The one addition is that the email is multipart/mixed, so the CV is a
 * real attachment rather than something promised and dropped.
 *
 *   GET   ?role=<slug>            pre-selects that role (validated against data/careers.php)
 *   GET   ?sent=1[&ref=XE-…]      the success state (the Post/Redirect/Get target)
 *   POST  the form (multipart/form-data): validated, emailed, then redirected.
 *
 * ---------------------------------------------------------------------------------------------
 * THE UPLOAD, which is the part most likely to be got wrong
 * ---------------------------------------------------------------------------------------------
 *  • A POST larger than post_max_size arrives with $_POST AND $_FILES both empty and no upload
 *    error to read, because PHP discarded the body before populating either. The only signal left
 *    is CONTENT_LENGTH, so that is what the first branch below tests. Without it the page would
 *    look like a form that silently threw the application away.
 *  • $_FILES['cv']['error'] is checked first, then the real size on disk, then the extension, then
 *    the media type sniffed from the file's own bytes with finfo_file. The browser-supplied
 *    ['type'] is never trusted and neither is the filename.
 *  • The file is never moved. It is read from its temporary path, base64-encoded into the email,
 *    and left for PHP to delete. Nothing is written inside the web root at any point, and the
 *    name the applicant's computer used is discarded: the attachment is renamed from the
 *    reference and the applicant's name, so a crafted filename cannot travel anywhere.
 *  • A file input cannot be re-populated by the server, so when any other field fails validation
 *    the page says plainly that the CV has to be attached again ($APL['cv_reattach']).
 *
 * Protection: a honeypot field (bots get a quiet fake success), a signed render time with a
 * minimum fill time, length limits on every field, header-injection-safe values (control
 * characters stripped, the address validated, every header value encoded).
 *
 * Produces $APL:
 *   'state'    'form' | 'sent' | 'failed'
 *   'v'        every posted value, re-rendered into the form on an error
 *   'errors'   field => message      't'  the signed time token
 *   'role_gone' the ?role= slug we did not recognise, so the page can say so
 *   'ref'      'XE-A-XXXXXX' (sent / failed)     'mailto'  mailto: URL (failed, no attachment)
 *   'cv'       ['name','size'] of the file that was attached, or null
 *   'cv_reattach' true when a CV came through but the form came back with errors, so it was dropped
 *   'notices' / 'years' / 'auth'   the option lists      'max_cv'  the real upload cap in bytes
 *
 * Locals are prefixed apl_. PLACEHOLDER: confirm where applications should go (a hiring inbox, an
 * applicant tracking system) and that the live host can send mail with attachments, before launch.
 */

$APL = [
    'state'   => 'form',
    'errors'  => [],
    'ref'     => '',
    'mailto'  => '',
    'cv'      => null,
    'cv_reattach' => false,
    'role_gone'   => '',
    'v' => [
        'name' => '', 'email' => '', 'phone' => '', 'location' => '', 'auth' => '',
        'role' => '', 'role2' => '',
        'portfolio' => '', 'linkedin' => '', 'profile' => '',
        'years' => '', 'title_now' => '', 'company_now' => '', 'notice' => '', 'comp' => '', 'start' => '',
        'why' => '', 'proud' => '', 'keep' => '',
    ],
    'auth' => [
        'citizen' => 'Indian citizen or OCI cardholder',
        'permit'  => 'I already hold a valid permit to work in India',
        'need'    => 'I would need a visa or sponsorship',
        'other'   => 'Something else — I will explain in my note',
    ],
    'years' => [
        '0-1'  => 'Less than a year, or still studying',
        '1-3'  => '1 to 3 years',
        '3-5'  => '3 to 5 years',
        '5-8'  => '5 to 8 years',
        '8-12' => '8 to 12 years',
        '12+'  => 'More than 12 years',
    ],
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
 * upload_max_filesize and post_max_size allow, so the label on the field is never a lie. The
 * sandbox this was built in allows 2 MB; a production host will differ, and the page reads the
 * real number rather than repeating one from a comment.
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
/** 'Xxx: value' padded, for the plain-text email body. */
function apl_kv(string $k, string $v): string { return $k . ':' . str_repeat(' ', max(1, 17 - strlen($k) - 1)) . $v; }

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
    /* A POST over post_max_size arrives with $_POST and $_FILES both empty and no upload error to
       read. CONTENT_LENGTH is the only thing left, so it is what we test. */
    if (!$_POST && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $APL['errors']['form'] = 'That was larger than this server accepts, so none of it came through — not even the text. '
            . 'The whole form, including the CV, has to stay under ' . apl_size(apl_bytes((string) ini_get('post_max_size'))) . '. '
            . 'Attach a smaller CV (a PDF exported without images is usually well under a megabyte) and send it again. '
            . 'Nothing was received, so nothing was lost on our side.';
        $APL['t'] = apl_token();
        return;
    }

    $apl_p = $_POST;
    $apl_vals = &$APL['v'];
    $apl_vals['name']        = apl_line($apl_p['name'] ?? '', 120);
    $apl_vals['email']       = apl_line($apl_p['email'] ?? '', 190);
    $apl_vals['phone']       = apl_line($apl_p['phone'] ?? '', 40);
    $apl_vals['location']    = apl_line($apl_p['location'] ?? '', 120);
    $apl_vals['portfolio']   = apl_line($apl_p['portfolio'] ?? '', 300);
    $apl_vals['linkedin']    = apl_line($apl_p['linkedin'] ?? '', 300);
    $apl_vals['profile']     = apl_line($apl_p['profile'] ?? '', 300);
    $apl_vals['title_now']   = apl_line($apl_p['title_now'] ?? '', 120);
    $apl_vals['company_now'] = apl_line($apl_p['company_now'] ?? '', 120);
    $apl_vals['comp']        = apl_line($apl_p['comp'] ?? '', 80);
    $apl_vals['start']       = apl_line($apl_p['start'] ?? '', 10);
    $apl_vals['why']         = apl_text($apl_p['why'] ?? '', 2000);
    $apl_vals['proud']       = apl_text($apl_p['proud'] ?? '', 1500);
    $apl_vals['keep']        = isset($apl_p['keep']) ? '1' : '';

    $apl_in = function (string $field, string $list) use ($apl_p, $APL): string {
        $x = is_string($apl_p[$field] ?? null) ? $apl_p[$field] : '';
        return isset($APL[$list][$x]) ? $x : '';
    };
    $apl_vals['auth']   = $apl_in('auth', 'auth');
    $apl_vals['years']  = $apl_in('years', 'years');
    $apl_vals['notice'] = $apl_in('notice', 'notices');

    $apl_r1 = apl_line($apl_p['role'] ?? '', 80);
    $apl_r2 = apl_line($apl_p['role2'] ?? '', 80);
    $apl_vals['role']  = ($apl_r1 !== '' && car_role($apl_r1)) ? $apl_r1 : '';
    $apl_vals['role2'] = ($apl_r2 !== '' && car_role($apl_r2)) ? $apl_r2 : '';
    unset($apl_vals);

    /* bots: a filled honeypot gets a quiet success and nothing is sent */
    if (trim((string) ($apl_p['website'] ?? '')) !== '') {
        header('Location: ' . xe_url('careers/apply.php') . '?sent=1', true, 303);
        exit;
    }

    $apl_v = $APL['v'];
    $apl_e = [];

    /* 01 about you */
    if (mb_strlen($apl_v['name']) < 2) $apl_e['name'] = 'Enter your name.';
    if ($apl_v['email'] === '' || !filter_var($apl_v['email'], FILTER_VALIDATE_EMAIL)) $apl_e['email'] = 'Enter an email address we can reply to, like name@example.com.';
    if ($apl_v['phone'] === '') $apl_e['phone'] = 'Enter a phone number, including the country code.';
    elseif (!preg_match('~^[0-9+().\s-]{6,40}$~', $apl_v['phone'])) $apl_e['phone'] = 'Use digits, spaces and + ( ) - only.';
    if (mb_strlen($apl_v['location']) < 2) $apl_e['location'] = 'Tell us which city you are in.';
    if ($apl_v['auth'] === '') $apl_e['auth'] = 'Choose the line that describes your right to work in India.';

    /* 02 the role */
    if ($apl_r1 !== '' && $apl_v['role'] === '') $apl_e['role'] = 'That role is not open any more. Choose one from the list, or send a general application.';
    if ($apl_r2 !== '' && $apl_v['role2'] === '') $apl_e['role2'] = 'That second choice is not open any more. Pick another, or leave it empty.';
    if ($apl_v['role2'] !== '' && $apl_v['role2'] === $apl_v['role']) $apl_e['role2'] = 'Your second choice is the same as your first. Pick a different one, or leave it empty.';
    if ($apl_v['role2'] !== '' && $apl_v['role'] === '') $apl_e['role2'] = 'Choose a first role above before adding a second choice.';

    /* 03 your work — three link fields, at least one of them real */
    $apl_links = [];
    foreach (['portfolio' => 'Portfolio', 'linkedin' => 'LinkedIn', 'profile' => 'Repo/profile'] as $apl_lk => $apl_ll) {
        if ($apl_v[$apl_lk] === '') continue;
        $apl_u = apl_url($apl_v[$apl_lk]);
        if ($apl_u === null) $apl_e[$apl_lk] = 'That does not look like a web address. Something like yourname.com or linkedin.com/in/yourname.';
        else $apl_links[$apl_ll] = $apl_u;
    }
    if (!$apl_links && !isset($apl_e['portfolio']) && !isset($apl_e['linkedin']) && !isset($apl_e['profile'])) {
        $apl_e['portfolio'] = 'Add at least one link — a portfolio, your LinkedIn, or a repository or profile.';
    }
    if ($apl_v['linkedin'] !== '' && isset($apl_links['LinkedIn']) && !preg_match('~(^|\.)linkedin\.com~i', (string) parse_url($apl_links['LinkedIn'], PHP_URL_HOST))) {
        $apl_e['linkedin'] = 'That is not a linkedin.com address. Put other links in the field below.';
    }

    /* 05 experience */
    if ($apl_v['years'] === '')  $apl_e['years']  = 'Choose how long you have been doing this work.';
    if ($apl_v['notice'] === '') $apl_e['notice'] = 'Choose how soon you could start.';
    if ($apl_v['start'] !== '') {
        $apl_d = DateTime::createFromFormat('!Y-m-d', $apl_v['start']);
        if (!$apl_d || $apl_d->format('Y-m-d') !== $apl_v['start']) {
            $apl_e['start'] = 'Use a real date, as year-month-day.';
        } elseif ($apl_d < new DateTime('today')) {
            $apl_e['start'] = 'Pick today or a date after it.';
        } elseif ($apl_d > (new DateTime('today'))->modify('+2 years')) {
            $apl_e['start'] = 'That is more than two years away. Put the detail in your note instead.';
        }
    }

    /* 06 the two questions */
    if (mb_strlen($apl_v['why']) < 60) $apl_e['why'] = 'A few sentences, please — at least 60 characters. It is the part we read most closely.';
    if (mb_strlen($apl_v['proud']) < 60) $apl_e['proud'] = 'Tell us about one piece of work and what your own part in it was — at least 60 characters.';

    $apl_age = apl_age($apl_p['t'] ?? null);
    if ($apl_age === null) $apl_e['form'] = 'This form expired. Check your answers and send it again.';
    elseif ($apl_age < 4) $apl_e['form'] = 'That was quick. Check your answers and send the application again.';

    /* ---- the CV: required, checked on error code, real size, extension and sniffed media type ---- */
    $apl_f    = $_FILES['cv'] ?? null;
    $apl_file = null;                                     // ['size','tmp','mime','ext']
    $apl_code = is_array($apl_f) ? (int) ($apl_f['error'] ?? UPLOAD_ERR_NO_FILE) : UPLOAD_ERR_NO_FILE;
    $apl_ok   = ['pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

    if ($apl_code === UPLOAD_ERR_NO_FILE) {
        $apl_e['cv'] = 'Attach your CV as a PDF, DOC or DOCX. It is the one file we ask for.';
    } elseif ($apl_code === UPLOAD_ERR_INI_SIZE || $apl_code === UPLOAD_ERR_FORM_SIZE) {
        $apl_e['cv'] = 'That file is over the ' . apl_size($APL['max_cv']) . ' limit this server accepts. Export a smaller PDF and attach it again.';
    } elseif ($apl_code === UPLOAD_ERR_PARTIAL) {
        $apl_e['cv'] = 'The upload was cut off part way. Attach the file again.';
    } elseif ($apl_code !== UPLOAD_ERR_OK || !is_uploaded_file((string) ($apl_f['tmp_name'] ?? ''))) {
        $apl_e['cv'] = 'The file did not upload. Try again, and if it keeps failing email it to us instead.';
    } else {
        /* the browser's filename and MIME type are both attacker-controlled: the extension is only
           used to decide what the bytes are allowed to look like, and the name is thrown away */
        $apl_ext  = strtolower((string) pathinfo(apl_line((string) ($apl_f['name'] ?? ''), 160), PATHINFO_EXTENSION));
        $apl_real = (int) @filesize((string) $apl_f['tmp_name']);
        if ($apl_real <= 0) {
            $apl_e['cv'] = 'That file is empty. Check it opens on your side and attach it again.';
        } elseif ($apl_real > $APL['max_cv']) {
            $apl_e['cv'] = 'That file is ' . apl_size($apl_real) . '. The limit is ' . apl_size($APL['max_cv']) . '.';
        } elseif (!isset($apl_ok[$apl_ext])) {
            $apl_e['cv'] = 'PDF, DOC or DOCX only — that one is a .' . ($apl_ext !== '' ? $apl_ext : 'file with no extension') . '. A PDF travels best.';
        } else {
            $apl_mime = $apl_ok[$apl_ext];
            if (function_exists('finfo_open') && ($apl_fi = finfo_open(FILEINFO_MIME_TYPE))) {
                $apl_sniff = (string) finfo_file($apl_fi, (string) $apl_f['tmp_name']);
                finfo_close($apl_fi);
                /* What each extension is actually allowed to sniff as. A .pdf must be a PDF. A .docx
                   is a zip, and a .doc is an OLE container that some builds of libmagic only report
                   as a generic binary, so those two get the wider list rather than every upload. */
                $apl_sniffs = [
                    'pdf'  => ['application/pdf'],
                    'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage', 'application/octet-stream'],
                    'docx' => [$apl_mime, 'application/zip', 'application/octet-stream'],
                ];
                if ($apl_sniff !== '' && !in_array($apl_sniff, $apl_sniffs[$apl_ext], true)) {
                    $apl_e['cv'] = 'The inside of that file is not a PDF or a Word document, whatever it is named. Export it again and attach it.';
                }
            }
            if (!isset($apl_e['cv'])) {
                $apl_file = ['size' => $apl_real, 'tmp' => (string) $apl_f['tmp_name'], 'mime' => $apl_mime, 'ext' => $apl_ext];
            }
        }
    }

    if ($apl_e) {
        $APL['errors'] = $apl_e;
        /* a file input cannot be re-populated from the server, so say so rather than lose it quietly */
        $APL['cv_reattach'] = $apl_file !== null;
        if ($apl_file !== null) {
            $APL['errors']['cv'] = 'Your browser cannot keep a chosen file across a page reload, so the CV you attached was not kept. Attach it again before you send.';
        }
    } else {
        /* ---------------- compose the application ---------------- */
        // PLACEHOLDER: confirm where applications should go (a hiring inbox, or an applicant tracking system) before launch
        $APL_EMAIL = $SITE['company']['email'];
        $apl_ref   = 'XE-A-' . strtoupper(bin2hex(random_bytes(3)));
        $apl_r     = $apl_v['role'] !== '' ? car_role($apl_v['role']) : null;
        $apl_r2o   = $apl_v['role2'] !== '' ? car_role($apl_v['role2']) : null;
        $apl_g     = $apl_r ? car_group($apl_r['discipline']) : null;
        $apl_site  = apl_root();

        $apl_subj = apl_subject($apl_r ? $apl_r['title'] : 'General application', $apl_v['name']);

        $apl_l   = [];
        $apl_l[] = 'New application from the ' . $SITE['company']['name'] . ' website';
        $apl_l[] = 'Reference: ' . $apl_ref;
        $apl_l[] = 'Received:  ' . gmdate('j M Y, H:i') . ' UTC';
        $apl_l[] = '';
        $apl_l[] = '— ROLE';
        $apl_l[] = apl_kv('Applied for', $apl_r ? $apl_r['title'] : 'General application (no specific role)');
        if ($apl_r) {
            $apl_l[] = apl_kv('Practice', $apl_g ? $apl_g['name'] : $apl_r['discipline']);
            $apl_l[] = apl_kv('Based', car_loc_line($apl_r));
            $apl_l[] = apl_kv('Listing', $apl_site . 'careers#role-' . $apl_r['slug']);
        }
        if ($apl_r2o) $apl_l[] = apl_kv('Second choice', $apl_r2o['title']);
        $apl_l[] = '';
        $apl_l[] = '— CANDIDATE';
        $apl_l[] = apl_kv('Name', $apl_v['name']);
        $apl_l[] = apl_kv('Email', $apl_v['email']);
        $apl_l[] = apl_kv('Phone', $apl_v['phone']);
        $apl_l[] = apl_kv('Location', $apl_v['location']);
        $apl_l[] = apl_kv('Right to work', $APL['auth'][$apl_v['auth']]);
        $apl_l[] = '';
        $apl_l[] = '— EXPERIENCE';
        $apl_l[] = apl_kv('Years', $APL['years'][$apl_v['years']]);
        $apl_l[] = apl_kv('Current role', trim(($apl_v['title_now'] !== '' ? $apl_v['title_now'] : 'Not given')
                          . ($apl_v['company_now'] !== '' ? ' at ' . $apl_v['company_now'] : '')));
        $apl_l[] = apl_kv('Notice', $APL['notices'][$apl_v['notice']]);
        $apl_l[] = apl_kv('Earliest start', $apl_v['start'] !== '' ? $apl_v['start'] : 'Not given');
        $apl_l[] = apl_kv('Expected pay', $apl_v['comp'] !== '' ? $apl_v['comp'] : 'Not given');
        $apl_l[] = '';
        $apl_l[] = '— WORK';
        foreach ($apl_links as $apl_ll => $apl_u) $apl_l[] = apl_kv($apl_ll, $apl_u);
        $apl_l[] = '';
        $apl_l[] = '— WHY US';
        $apl_l[] = $apl_v['why'];
        $apl_l[] = '';
        $apl_l[] = '— WORK THEY ARE PROUD OF';
        $apl_l[] = $apl_v['proud'];
        $apl_l[] = '';
        $apl_l[] = '— CV';
        $apl_l[] = 'Attached as ' . strtoupper($apl_file['ext']) . ', ' . apl_size($apl_file['size']) . '. Renamed on our side; the file is not stored on the website.';
        $apl_l[] = '';
        $apl_l[] = '— CONSENT';
        $apl_l[] = apl_kv('Keep on file', $apl_v['keep'] === '1'
            ? 'Yes — may be kept for future roles until they ask otherwise'
            : 'No — consider for this application only');
        $apl_l[] = '';
        $apl_l[] = '— SOURCE';
        $apl_l[] = apl_kv('Apply page', $apl_site . 'careers/apply');
        $apl_body_text = implode("\n", $apl_l) . "\n";

        /* The attachment name is built here and never taken from the upload: <ref>-CV-<name>.<ext>,
           restricted to letters, digits, dot and hyphen. */
        $apl_slug = trim(preg_replace('~[^A-Za-z0-9]+~', '-', $apl_v['name']) ?: '', '-');
        $apl_att  = $apl_ref . '-CV' . ($apl_slug !== '' ? '-' . mb_substr($apl_slug, 0, 40) : '') . '.' . $apl_file['ext'];

        /* multipart/mixed, so the CV is a real attachment. Built with \n and converted to CRLF once,
           because RFC 5322 wants CRLF line endings and mail() on some hosts rewrites bare \n badly. */
        $apl_bd   = 'xe-' . bin2hex(random_bytes(12));
        /* quoted-printable rather than 8bit: the body carries em dashes and may carry any script,
           and an MTA without 8BITMIME would otherwise be free to mangle it. The encoder emits CRLF,
           which is normalised back to \n here so the single conversion at the end stays the only one. */
        $apl_qp   = str_replace("\r\n", "\n", quoted_printable_encode($apl_body_text));
        $apl_body = "This is a multi-part message in MIME format.\n\n"
                  . '--' . $apl_bd . "\n"
                  . "Content-Type: text/plain; charset=UTF-8\n"
                  . "Content-Transfer-Encoding: quoted-printable\n\n"
                  . $apl_qp . "\n";
        $apl_raw = (string) file_get_contents($apl_file['tmp']);
        $apl_body .= '--' . $apl_bd . "\n"
                  . 'Content-Type: ' . $apl_file['mime'] . '; name="' . $apl_att . "\"\n"
                  . "Content-Transfer-Encoding: base64\n"
                  . 'Content-Disposition: attachment; filename="' . $apl_att . "\"\n\n"
                  . chunk_split(base64_encode($apl_raw), 76, "\n") . "\n";
        $apl_body .= '--' . $apl_bd . "--\n";
        unset($apl_raw);

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
                . ($apl_v['role'] !== '' ? '&role=' . rawurlencode($apl_v['role']) : '') . '&cv=1', true, 303);
            exit;
        }

        error_log('apply: mail() failed for application ' . $apl_ref);
        $APL['state'] = 'failed';
        $APL['ref']   = $apl_ref;
        $APL['cv']    = ['name' => $apl_att, 'size' => $apl_file['size']];
        /* mailto: bodies are capped by most mail apps at about 2,000 characters, and a mailto can
           never carry the file — the page tells the applicant to attach it themselves. */
        $apl_short = mb_strlen($apl_body_text) > 1600 ? mb_substr($apl_body_text, 0, 1580) . "\n[…]" : $apl_body_text;
        $APL['mailto'] = 'mailto:' . $APL_EMAIL . '?subject=' . rawurlencode($apl_subj) . '&body=' . rawurlencode($apl_short);
    }
}

$APL['t'] = apl_token();
