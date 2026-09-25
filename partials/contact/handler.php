<?php /* DRAFT COPY — review before launch */
/**
 * Contact — reads the query, handles the POST and sends the brief. Include from contact.php after
 * partials/init.php and partials/services/lib.php, BEFORE any output (it may redirect and exit).
 *
 *   GET   ?service[]=<id>… (or ?service=a,b) · ?package=<key> · ?from=<page key>
 *         ids are validated with svc_resolve(); unknown ids are dropped and counted.
 *   GET   ?sent=1[&ref=XE-…][&from=…][&doc=1]  → the success state (Post/Redirect/Get target)
 *   POST  intent=select  → a selection posted from a service catalogue: pre-fill only, never sent.
 *   POST  the form (multipart/form-data): validated, then one email to $SITE['company']['email']
 *         with Reply-To set to the visitor. Success redirects (303) to ?sent=1; a failed mail()
 *         renders an honest error with a mailto: link holding the same brief. Nothing is stored.
 *
 * THE PROGRESSIVE BRIEF
 *   One form, three depths ($CT['depths']): 'hello' (a sentence), 'brief' (the default) and 'rfq'
 *   (everything procurement, legal and delivery need). Depth only decides which blocks start open —
 *   every field is in the shipped HTML and every field posts, so the page works identically with
 *   JavaScript off. Required at every depth: a name, an address we can reply to, and either one
 *   service or ten characters of message.
 *
 * ---------------------------------------------------------------------------------------------
 * THE OPTIONAL BRIEF DOCUMENT, which is the part most likely to be got wrong
 * ---------------------------------------------------------------------------------------------
 *  • A POST larger than post_max_size arrives with $_POST AND $_FILES both empty and no upload
 *    error to read, because PHP discarded the body before populating either. The only signal left
 *    is CONTENT_LENGTH, so that is what the first branch below tests. Without it the page would
 *    look like a form that silently threw the enquiry away.
 *  • $_FILES['doc']['error'] is checked first, then the real size on disk, then the extension,
 *    then the media type sniffed from the file's own bytes with finfo_file. The browser-supplied
 *    ['type'] is never trusted and neither is the filename.
 *  • The file is never moved. It is read from its temporary path, base64-encoded into the email,
 *    and left for PHP to delete. Nothing is written inside the web root at any point, and the
 *    name the sender's computer used is discarded: the attachment is renamed from the reference
 *    and the company, so a crafted filename cannot travel anywhere.
 *  • A file input cannot be re-populated by the server, so when any other field fails validation
 *    the page says plainly that the document has to be attached again ($CT['doc_reattach']).
 *
 * Protection: a honeypot field (bots get a quiet fake success), a signed render time with a
 * minimum fill time, length limits on every field, and header-injection-safe values (control
 * characters stripped, the email validated, every header value encoded).
 *
 * Produces $CT:
 *   'state'   'form' | 'sent' | 'failed'
 *   'v'       every posted value, re-rendered into the form on an error (see the array below)
 *   'errors'  field => message          'dropped'  how many query ids were not recognised
 *   'ref'     'XE-XXXXXX' (sent / failed)   'mailto'  mailto: URL (failed)   't'  the signed time token
 *   'doc'     ['name','size'] of the attached document, or null
 *   'doc_reattach'  true when a document arrived but the form came back with errors
 *   'max_doc' the real upload cap in bytes   'exts' the extensions accepted
 *   'blocks'  the brief as ordered blocks of [label, value] — the email body, the page preview and
 *             the completeness meter are all built from this one structure, so they cannot disagree
 *   'answered' / 'askable'  how many optional questions carry an answer, for the meter
 *   the option lists: 'depths' 'kinds' 'budgets' 'timelines' 'decisions' 'buyings' 'heards' 'zones'
 *
 * Locals are prefixed ct_. PLACEHOLDER: confirm where leads should go (email / CRM) before launch.
 */

$CT = [
    'state' => 'form', 'app' => null, 'errors' => [], 'dropped' => 0, 'ref' => '', 'mailto' => '',
    'doc' => null, 'doc_reattach' => false, 'max_doc' => 0, 'over' => false,
    'v' => [
        /* who they are */
        'name' => '', 'email' => '', 'phone' => '', 'company' => '', 'website' => '', 'role' => '',
        'country' => '', 'zone' => '',
        /* what they need */
        'depth' => 'brief', 'kind' => '', 'services' => [], 'package' => '',
        /* the brief */
        'message' => '', 'goals' => '', 'audience' => '', 'current' => '', 'measures' => '',
        /* commercials and the decision */
        'budget' => '', 'timeline' => '', 'deadline' => '', 'decision' => '', 'stakeholders' => '', 'buying' => '',
        /* practicalities */
        'heard' => '', 'heard_note' => '', 'nda' => '', 'access' => '',
        /* routing */
        'from' => '', 'pre' => [],
    ],
    'depths' => [
        'hello' => ['Say hello',   'A sentence about what you need. We read it and ask the rest.',        'About 2 minutes',  'Name, an address, one paragraph'],
        'brief' => ['Send a brief', 'Enough for us to answer properly and propose a shape of work.',      'About 5 minutes',  'Adds services, goals and rough budget'],
        'rfq'   => ['Full RFQ',    'Everything delivery, legal and procurement need to price it.',        'About 12 minutes', 'Adds decision process, dates and a document'],
    ],
    'kinds' => [
        'new'      => 'Something new, built from scratch',
        'rebuild'  => 'Rebuilding or replacing what exists',
        'improve'  => 'Improving something already live',
        'audit'    => 'An audit, review or second opinion',
        'capacity' => 'Ongoing capacity, or a team to embed',
        'unsure'   => 'Not sure yet — help us work it out',
    ],
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
    'decisions' => [
        'exploring' => 'Exploring what is possible',
        'case'      => 'Building the internal case',
        'approved'  => 'Budget approved, choosing a partner',
        'comparing' => 'Comparing proposals now',
        'ready'     => 'Ready to start once we agree scope',
    ],
    'buyings' => [
        'direct'    => 'Direct — our team can sign it',
        'procure'   => 'Through procurement',
        'tender'    => 'A formal tender or RFP process',
        'framework' => 'Onto an existing supplier framework',
        'unsure'    => 'Not decided yet',
    ],
    'heards' => [
        'search'   => 'A search engine',
        'ai'       => 'An AI assistant — ChatGPT, Perplexity, Gemini',
        'referral' => 'Someone recommended you',
        'team'     => 'Someone at Xterra Edze',
        'social'   => 'LinkedIn or another social platform',
        'event'    => 'An event, talk or workshop',
        'press'    => 'Press, a podcast or an article',
        'other'    => 'Somewhere else',
    ],
    'zones' => [
        'ist'    => 'India — IST, UTC+5:30',
        'gulf'   => 'Gulf — UTC+3 to +4',
        'africa' => 'Africa — UTC+0 to +3',
        'uk'     => 'UK and Ireland — UTC+0 to +1',
        'europe' => 'Europe — UTC+1 to +2',
        'apac'   => 'Asia-Pacific — UTC+7 to +11',
        'am-e'   => 'Americas, east — UTC−4 to −5',
        'am-w'   => 'Americas, west — UTC−7 to −8',
    ],
    'exts' => ['pdf', 'doc', 'docx', 'ppt', 'pptx'],
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
/** A web address as a person would type it: 'yourcompany.com' and 'https://…' both accepted. */
function ct_url(string $raw): ?string {
    if ($raw === '') return null;
    $u = preg_match('~^https?://~i', $raw) ? $raw : 'https://' . ltrim($raw, '/');
    if (!filter_var($u, FILTER_VALIDATE_URL)) return null;
    $host = parse_url($u, PHP_URL_HOST);
    if (!$host || strpos($host, '.') === false) return null;
    return $u;
}
/** A php.ini size ('8M', '512K') in bytes. */
function ct_bytes(string $v): int {
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
 * The largest document this host can actually accept: our own 8 MB ceiling, capped by whatever
 * upload_max_filesize and post_max_size allow, so the label on the field is never a lie. The
 * sandbox this was built in allows 2 MB; a production host will differ, and the page reads the
 * real number rather than repeating one from a comment.
 */
function ct_max_doc(): int {
    $ours = 8 * 1024 * 1024;
    $up   = ct_bytes((string) ini_get('upload_max_filesize'));
    $post = ct_bytes((string) ini_get('post_max_size'));
    $lim  = $ours;
    if (!ini_get('file_uploads')) return 0;
    if ($up > 0)   $lim = min($lim, $up);
    if ($post > 0) $lim = min($lim, max(0, $post - 262144));   // leave room for the text fields
    return max(0, $lim);
}
/** '4.8 MB' / '480 KB' */
function ct_size(int $b): string {
    if ($b >= 1024 * 1024) {
        $mb = $b / (1024 * 1024);
        return rtrim(rtrim(number_format($mb, $mb < 10 ? 1 : 0, '.', ''), '0'), '.') . ' MB';
    }
    return max(1, (int) round($b / 1024)) . ' KB';
}
/** 'Xxx:        value' for the plain-text email body. */
function ct_kv(string $k, string $v): string { return $k . ':' . str_repeat(' ', max(1, 18 - mb_strlen($k) - 1)) . $v; }

$CT['max_doc'] = ct_max_doc();

/* ---------------- success (the Post/Redirect/Get target) ---------------- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET' && ($_GET['sent'] ?? '') === '1') {
    $CT['state'] = 'sent';
    $CT['ref'] = (is_string($_GET['ref'] ?? null) && preg_match('~^XE-[A-F0-9]{6}$~', $_GET['ref'])) ? $_GET['ref'] : '';
    $CT['v']['from'] = ct_from($_GET['from'] ?? '');
    $CT['doc'] = ($_GET['doc'] ?? '') === '1' ? ['name' => '', 'size' => 0] : null;
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
    $ct_d = is_string($_GET['depth'] ?? null) ? $_GET['depth'] : '';
    if (isset($CT['depths'][$ct_d])) $CT['v']['depth'] = $ct_d;
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
    /* A POST over post_max_size arrives with $_POST and $_FILES both empty and no upload error to
       read. CONTENT_LENGTH is the only thing left, so it is what we test. */
    if (!$_POST && (int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 0) {
        $CT['over'] = true;
        $CT['errors']['form'] = 'That was larger than this server accepts, so none of it arrived — not even the text. '
            . 'The whole form, including any attachment, has to stay under ' . ct_size(ct_bytes((string) ini_get('post_max_size'))) . '. '
            . 'Send the brief without the document, or attach a smaller one, and we will ask for the rest by email. '
            . 'Nothing reached us, so nothing was lost on our side.';
        $CT['t'] = ct_token();
        return;
    }

    $P = $_POST;
    $v = &$CT['v'];
    $v['name']         = ct_line($P['name'] ?? '', 120);
    $v['email']        = ct_line($P['email'] ?? '', 190);
    $v['company']      = ct_line($P['company'] ?? '', 160);
    $v['phone']        = ct_line($P['phone'] ?? '', 40);
    $v['website']      = ct_line($P['website'] ?? '', 200);
    $v['role']         = ct_line($P['role'] ?? '', 120);
    $v['country']      = ct_line($P['country'] ?? '', 80);
    $v['stakeholders'] = ct_line($P['stakeholders'] ?? '', 300);
    $v['heard_note']   = ct_line($P['heard_note'] ?? '', 200);
    $v['deadline']     = ct_line($P['deadline'] ?? '', 10);
    $v['message']      = ct_text($P['message'] ?? '', 4000);
    $v['goals']        = ct_text($P['goals'] ?? '', 2000);
    $v['audience']     = ct_text($P['audience'] ?? '', 800);
    $v['current']      = ct_text($P['current'] ?? '', 1500);
    $v['measures']     = ct_text($P['measures'] ?? '', 1000);
    $v['access']       = ct_text($P['access'] ?? '', 800);
    $v['nda']          = isset($P['nda']) ? '1' : '';
    $v['from']         = ct_from($P['from'] ?? '');
    $v['services']     = array_values(array_filter(svc_ids($P['service'] ?? []), fn ($ct_x) => (bool) svc_resolve($ct_x)));
    $v['pre']          = array_values(array_filter(svc_ids($P['pre'] ?? ''), fn ($ct_x) => (bool) svc_resolve($ct_x)));
    $ct_pk = is_string($P['package'] ?? null) ? $P['package'] : '';
    $v['package']  = isset(svc_packages()[$ct_pk]) ? $ct_pk : '';
    /* every other select: keep the value only when it is one we offer */
    $ct_pick = function (string $field, string $list) use ($P, $CT): string {
        $x = is_string($P[$field] ?? null) ? $P[$field] : '';
        return isset($CT[$list][$x]) ? $x : '';
    };
    $v['depth']    = $ct_pick('depth', 'depths') !== '' ? $ct_pick('depth', 'depths') : 'brief';
    $v['kind']     = $ct_pick('kind', 'kinds');
    $v['budget']   = $ct_pick('budget', 'budgets');
    $v['timeline'] = $ct_pick('timeline', 'timelines');
    $v['decision'] = $ct_pick('decision', 'decisions');
    $v['buying']   = $ct_pick('buying', 'buyings');
    $v['heard']    = $ct_pick('heard', 'heards');
    $v['zone']     = $ct_pick('zone', 'zones');
    unset($v);

    /* bots: a filled honeypot gets a quiet success and nothing is sent.
       The field is named 'fax' because 'website' is now a real question on this form. */
    if (trim((string) ($P['fax'] ?? '')) !== '') {
        header('Location: ' . xe_url('contact.php') . '?sent=1', true, 303);
        exit;
    }

    $ct_v = $CT['v'];
    $ct_e = [];
    if (mb_strlen($ct_v['name']) < 2) $ct_e['name'] = 'Enter your name.';
    if ($ct_v['email'] === '' || !filter_var($ct_v['email'], FILTER_VALIDATE_EMAIL)) $ct_e['email'] = 'Enter an email address we can reply to, like name@company.com.';
    if ($ct_v['phone'] !== '' && !preg_match('~^[0-9+().\s-]{6,40}$~', $ct_v['phone'])) $ct_e['phone'] = 'Use digits, spaces and + ( ) - only.';

    $ct_site = null;
    if ($ct_v['website'] !== '') {
        $ct_site = ct_url($ct_v['website']);
        if ($ct_site === null) $ct_e['website'] = 'That does not look like a web address. Something like yourcompany.com.';
    }
    if (!$ct_v['services'] && mb_strlen($ct_v['message']) < 10) $ct_e['service'] = 'Choose at least one service, or tell us what you need in the message.';
    if ($ct_v['depth'] === 'rfq' && mb_strlen($ct_v['message']) < 60) {
        $ct_e['message'] = 'A full RFQ needs the problem in your own words — at least a couple of sentences. Switch to “Send a brief” if you would rather keep it short.';
    }
    if ($ct_v['deadline'] !== '') {
        $ct_d = DateTime::createFromFormat('!Y-m-d', $ct_v['deadline']);
        if (!$ct_d || $ct_d->format('Y-m-d') !== $ct_v['deadline']) {
            $ct_e['deadline'] = 'Use a real date, as year-month-day.';
        } elseif ($ct_d < new DateTime('today')) {
            $ct_e['deadline'] = 'Pick today or a date after it.';
        } elseif ($ct_d > (new DateTime('today'))->modify('+3 years')) {
            $ct_e['deadline'] = 'That is more than three years away. Put the detail in the brief instead.';
        }
    }
    $ct_age = ct_age($P['t'] ?? null);
    if ($ct_age === null) $ct_e['form'] = 'This form expired. Check your answers and send it again.';
    elseif ($ct_age < 3) $ct_e['form'] = 'That was quick. Check your answers and send the brief again.';

    /* ---- the optional document: error code, real size, extension, then sniffed media type ---- */
    $ct_f    = $_FILES['doc'] ?? null;
    $ct_file = null;                                     // ['size','tmp','mime','ext']
    $ct_code = is_array($ct_f) ? (int) ($ct_f['error'] ?? UPLOAD_ERR_NO_FILE) : UPLOAD_ERR_NO_FILE;
    $ct_mimes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'ppt'  => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    ];
    if ($ct_code === UPLOAD_ERR_NO_FILE) {
        /* nothing attached — the document is optional, so this is not an error */
    } elseif ($ct_code === UPLOAD_ERR_INI_SIZE || $ct_code === UPLOAD_ERR_FORM_SIZE) {
        $ct_e['doc'] = 'That file is over the ' . ct_size($CT['max_doc']) . ' limit this server accepts. Attach a smaller export, or send the brief without it and we will ask for the document by email.';
    } elseif ($ct_code === UPLOAD_ERR_PARTIAL) {
        $ct_e['doc'] = 'The upload was cut off part way. Attach the file again.';
    } elseif ($ct_code !== UPLOAD_ERR_OK || !is_uploaded_file((string) ($ct_f['tmp_name'] ?? ''))) {
        $ct_e['doc'] = 'The file did not upload. Try again, and if it keeps failing send the brief without it and email the document to us.';
    } else {
        /* the browser's filename and MIME type are both attacker-controlled: the extension only
           decides what the bytes are allowed to look like, and the name is thrown away */
        $ct_ext  = strtolower((string) pathinfo(ct_line((string) ($ct_f['name'] ?? ''), 160), PATHINFO_EXTENSION));
        $ct_real = (int) @filesize((string) $ct_f['tmp_name']);
        if ($ct_real <= 0) {
            $ct_e['doc'] = 'That file is empty. Check it opens on your side and attach it again.';
        } elseif ($ct_real > $CT['max_doc']) {
            $ct_e['doc'] = 'That file is ' . ct_size($ct_real) . '. The limit on this server is ' . ct_size($CT['max_doc']) . '.';
        } elseif (!isset($ct_mimes[$ct_ext])) {
            $ct_e['doc'] = 'PDF, DOC, DOCX, PPT or PPTX only — that one is a .' . ($ct_ext !== '' ? $ct_ext : 'file with no extension') . '. A PDF travels best.';
        } else {
            $ct_mime = $ct_mimes[$ct_ext];
            if (function_exists('finfo_open') && ($ct_fi = finfo_open(FILEINFO_MIME_TYPE))) {
                $ct_sniff = (string) finfo_file($ct_fi, (string) $ct_f['tmp_name']);
                finfo_close($ct_fi);
                /* What each extension is actually allowed to sniff as. A .pdf must be a PDF. The
                   Office XML formats are zips, and the older ones are OLE containers that some
                   builds of libmagic only report as a generic binary, so those get the wider list
                   rather than every upload getting it. */
                $ct_sniffs = [
                    'pdf'  => ['application/pdf'],
                    'doc'  => ['application/msword', 'application/CDFV2', 'application/x-ole-storage', 'application/octet-stream'],
                    'ppt'  => ['application/vnd.ms-powerpoint', 'application/CDFV2', 'application/x-ole-storage', 'application/octet-stream'],
                    'docx' => [$ct_mime, 'application/zip', 'application/octet-stream'],
                    'pptx' => [$ct_mime, 'application/zip', 'application/octet-stream'],
                ];
                if ($ct_sniff !== '' && !in_array($ct_sniff, $ct_sniffs[$ct_ext], true)) {
                    $ct_e['doc'] = 'The inside of that file is not a PDF, a Word document or a slide deck, whatever it is named. Export it again and attach it.';
                }
            }
            if (!isset($ct_e['doc'])) {
                $ct_file = ['size' => $ct_real, 'tmp' => (string) $ct_f['tmp_name'], 'mime' => $ct_mime, 'ext' => $ct_ext];
            }
        }
    }

    if ($ct_e) {
        $CT['errors'] = $ct_e;
        /* a file input cannot be re-populated from the server, so say so rather than lose it quietly */
        if ($ct_file !== null) {
            $CT['doc_reattach'] = true;
            $CT['errors']['doc'] = 'Your browser cannot keep a chosen file across a page reload, so the document you attached was not kept. Attach it again before you send.';
        }
    } else {
        /* ---------------- compose the brief ---------------- */
        $SITE_EMAIL = $SITE['company']['email'];   // PLACEHOLDER: confirm where leads should go (email / CRM) before launch
        $ct_ref  = 'XE-' . strtoupper(bin2hex(random_bytes(3)));
        $ct_pkg  = $ct_v['package'] ? svc_packages()[$ct_v['package']] : null;
        $ct_rows = array_map('svc_resolve', $ct_v['services']);
        $ct_root = ct_root();

        $ct_names = array_map(fn ($ct_r) => $ct_r['name'], $ct_rows);
        $ct_sum   = $ct_names ? $ct_names[0] . (count($ct_names) > 1 ? ' +' . (count($ct_names) - 1) . ' more' : '') : 'General enquiry';
        $ct_tagv  = $ct_v['depth'] === 'rfq' ? '[RFQ] ' : '[Lead] ';
        $ct_subj  = $ct_tagv . $ct_sum . ($ct_pkg ? ' · ' . $ct_pkg['name'] : '') . ' · ' . ($ct_v['company'] !== '' ? $ct_v['company'] : $ct_v['name']);
        $ct_app = ct_app($ct_v['message'], $ct_v['from']) ?? ct_app(is_string($P['apply'] ?? null) ? $P['apply'] : '', $ct_v['from']);
        if ($ct_app) {
            if (preg_match('~^\s*Application:~', $ct_v['message'])) {   // sent straight from a careers form: say it in words
                $ct_v['message'] = ct_app_text($ct_app, trim(preg_replace('~^\s*Application:\s*.+?\([A-Za-z0-9._-]{1,40}\)\s*~u', '', $ct_v['message'], 1)));
            }
            $ct_subj = '[Application] ' . $ct_app['role'] . ' (' . $ct_app['id'] . ') · ' . $ct_v['name'];   // PLACEHOLDER: route applications to careers@ once that inbox exists
        }
        $ct_subj  = ct_line($ct_subj, 180);
        $CT['v']['message'] = $ct_v['message'];   // ct_blocks() reads $CT, so keep the rewritten wording

        $ct_src = '—';
        if ($ct_v['from'] !== '') {
            $ct_m   = svc_page_meta($ct_v['from']);
            $ct_src = $ct_m['name'] . ' (' . $ct_v['from'] . ')' . (!empty($ct_m['url']) ? ' — ' . $ct_root . preg_replace('~^(\.\./|\./)+~', '', $ct_m['url']) : '');
        }

        $L   = [];
        $L[] = ($ct_v['depth'] === 'rfq' ? 'New RFQ' : 'New brief') . ' from the ' . $SITE['company']['name'] . ' website';
        $L[] = 'Reference: ' . $ct_ref;
        $L[] = 'Received:  ' . gmdate('j M Y, H:i') . ' UTC';
        $L[] = 'Depth:     ' . $CT['depths'][$ct_v['depth']][0];
        if ($ct_v['nda'] === '1') $L[] = 'NDA:       Requested before anything detailed is shared';
        foreach (ct_blocks($CT, $ct_rows, $ct_pkg, $ct_site) as $ct_bk) {
            $L[] = '';
            $L[] = '— ' . strtoupper($ct_bk['title']);
            foreach ($ct_bk['rows'] as $ct_r2) {
                if ($ct_r2[2] ?? false) {                     // a long answer prints on its own lines
                    $L[] = $ct_r2[0] . ':';
                    foreach (explode("\n", $ct_r2[1]) as $ct_ln) $L[] = '  ' . $ct_ln;
                } else {
                    $L[] = ct_kv($ct_r2[0], $ct_r2[1]);
                }
            }
        }
        $L[] = '';
        $L[] = '— ATTACHMENT';
        $L[] = $ct_file
            ? 'Brief document attached as ' . strtoupper($ct_file['ext']) . ', ' . ct_size($ct_file['size']) . '. Renamed on our side; the file is not stored on the website.'
            : 'None.';
        $L[] = '';
        $L[] = '— SOURCE';
        $L[] = ct_kv('Source page', $ct_src);
        $L[] = ct_kv('Pre-selected', $ct_v['pre'] ? implode(', ', $ct_v['pre']) : '—');
        $L[] = ct_kv('Service ids', $ct_v['services'] ? implode(', ', $ct_v['services']) : '—');
        $L[] = ct_kv('Package key', $ct_v['package'] !== '' ? $ct_v['package'] : '—');
        $L[] = ct_kv('Contact page', $ct_root . preg_replace('~^(\.\./|\./)+~', '', xe_url('contact.php')));
        $ct_body_text = implode("\n", $L) . "\n";

        $ct_headers = [
            'From'         => ct_addr($SITE['company']['name'] . ' website', $SITE_EMAIL),   // PLACEHOLDER: a sending address on the live domain
            'Reply-To'     => ct_addr($ct_v['name'], $ct_v['email']),
            'MIME-Version' => '1.0',
            'X-XE-Lead'    => $ct_ref,
        ];

        if ($ct_file) {
            /* The attachment name is built here and never taken from the upload: <ref>-BRIEF-<who>.<ext>,
               restricted to letters, digits, dot and hyphen. */
            $ct_who  = trim(preg_replace('~[^A-Za-z0-9]+~', '-', $ct_v['company'] !== '' ? $ct_v['company'] : $ct_v['name']) ?: '', '-');
            $ct_att  = $ct_ref . '-BRIEF' . ($ct_who !== '' ? '-' . mb_substr($ct_who, 0, 40) : '') . '.' . $ct_file['ext'];
            /* multipart/mixed, so the document is a real attachment. Built with \n and converted to
               CRLF once at the end, because RFC 5322 wants CRLF and mail() on some hosts rewrites
               bare \n badly. quoted-printable for the text part: the body carries em dashes and may
               carry any script, and an MTA without 8BITMIME would otherwise be free to mangle it. */
            $ct_bd = 'xe-' . bin2hex(random_bytes(12));
            $ct_qp = str_replace("\r\n", "\n", quoted_printable_encode($ct_body_text));
            $ct_raw = (string) file_get_contents($ct_file['tmp']);
            $ct_body = "This is a multi-part message in MIME format.\n\n"
                     . '--' . $ct_bd . "\n"
                     . "Content-Type: text/plain; charset=UTF-8\n"
                     . "Content-Transfer-Encoding: quoted-printable\n\n"
                     . $ct_qp . "\n"
                     . '--' . $ct_bd . "\n"
                     . 'Content-Type: ' . $ct_file['mime'] . '; name="' . $ct_att . "\"\n"
                     . "Content-Transfer-Encoding: base64\n"
                     . 'Content-Disposition: attachment; filename="' . $ct_att . "\"\n\n"
                     . chunk_split(base64_encode($ct_raw), 76, "\n") . "\n"
                     . '--' . $ct_bd . "--\n";
            unset($ct_raw);
            $ct_headers['Content-Type'] = 'multipart/mixed; boundary="' . $ct_bd . '"';
            $CT['doc'] = ['name' => $ct_att, 'size' => $ct_file['size']];
        } else {
            $ct_body = $ct_body_text;
            $ct_headers['Content-Type']              = 'text/plain; charset=UTF-8';
            $ct_headers['Content-Transfer-Encoding'] = '8bit';
        }

        $ct_ok = function_exists('mail')
            && @mail($SITE_EMAIL, mb_encode_mimeheader($ct_subj, 'UTF-8', 'B', "\r\n"), str_replace("\n", "\r\n", $ct_body), $ct_headers);

        if ($ct_ok) {
            header('Location: ' . xe_url('contact.php') . '?sent=1&ref=' . $ct_ref
                . ($ct_v['from'] !== '' ? '&from=' . rawurlencode($ct_v['from']) : '')
                . ($ct_file ? '&doc=1' : ''), true, 303);
            exit;
        }

        error_log('contact: mail() failed for lead ' . $ct_ref);
        $CT['state'] = 'failed';
        $CT['ref']   = $ct_ref;
        /* mailto: bodies are capped by most mail apps at about 2,000 characters, and a mailto can
           never carry the file — the page tells the sender to attach it themselves. */
        $ct_short = mb_strlen($ct_body_text) > 1600 ? mb_substr($ct_body_text, 0, 1580) . "\n[…]" : $ct_body_text;
        $CT['mailto'] = 'mailto:' . $SITE_EMAIL . '?subject=' . rawurlencode($ct_subj) . '&body=' . rawurlencode($ct_short);
    }
}

/**
 * The brief as ordered blocks of rows: [title, rows[[label, value, long?]]].
 * The email body, the on-page "what lands in our inbox" preview and the completeness meter are all
 * built from this one call, so the three can never disagree. Unanswered questions come back as '',
 * and each caller decides whether to print a dash or drop the row.
 */
function ct_blocks(array $ct_c, ?array $ct_rows = null, ?array $ct_pkg = null, ?string $ct_site = null): array {
    $v = $ct_c['v'];
    $opt = fn (string $f, string $list): string => $v[$f] !== '' ? $ct_c[$list][$v[$f]] : '';
    if ($ct_rows === null) $ct_rows = array_values(array_filter(array_map('svc_resolve', $v['services'])));
    if ($ct_pkg === null)  $ct_pkg  = $v['package'] !== '' ? (svc_packages()[$v['package']] ?? null) : null;
    if ($ct_site === null) $ct_site = $v['website'] !== '' ? (ct_url($v['website']) ?? $v['website']) : '';

    $svc = '';
    if ($ct_rows) {
        $lines = [];
        foreach ($ct_rows as $r) {
            $lines[] = $r['name'] . '  [' . $r['discipline'] . ' › ' . ($r['hub'] ? 'Overview' : $r['page']) . ']';
        }
        $svc = implode("\n", $lines);
    }

    return [
        /* Row order matches the order the questions appear in partials/contact/brief.php, because
           contact.js rebuilds this same list from the DOM for the live preview. */
        ['key' => 'contact', 'title' => 'Who is asking', 'rows' => [
            ['Name', $v['name']], ['Work email', $v['email']], ['Company', $v['company']],
            ['Their role', $v['role']], ['Phone', $v['phone']], ['Website', $ct_site],
            ['Country', $v['country']], ['Best hours', $opt('zone', 'zones')],
        ]],
        ['key' => 'need', 'title' => 'What they need', 'rows' => [
            ['Kind of work', $opt('kind', 'kinds')],
            ['Services (' . count($ct_rows) . ')', $svc, true],
        ]],
        ['key' => 'brief', 'title' => 'The brief', 'rows' => [
            ['The problem', $v['message'], true],
            ['Goals', $v['goals'], true],
            ['Audience', $v['audience'], true],
            ['What exists today', $v['current'], true],
            ['How success is measured', $v['measures'], true],
        ]],
        ['key' => 'money', 'title' => 'Commercials and the decision', 'rows' => [
            ['Engagement', $ct_pkg ? $ct_pkg['name'] . ' · ' . $ct_pkg['pricing'] : ''],
            ['Budget', $opt('budget', 'budgets')],
            ['Timing', $opt('timeline', 'timelines')],
            ['Fixed date', $v['deadline']],
            ['Decision stage', $opt('decision', 'decisions')],
            ['How it is bought', $opt('buying', 'buyings')],
            ['Others involved', $v['stakeholders']],
        ]],
        ['key' => 'practical', 'title' => 'Practicalities', 'rows' => [
            ['Heard about us', trim($opt('heard', 'heards') . ($v['heard_note'] !== '' ? ' — ' . $v['heard_note'] : ''))],
            ['NDA first', $v['nda'] === '1' ? 'Yes — before anything detailed is shared' : ''],
            ['Access or language', $v['access'], true],
        ]],
    ];
}

/** How many of the brief's questions carry an answer: [answered, askable]. Drives the meter. */
function ct_answered(array $ct_c): array {
    $on = 0; $all = 0;
    foreach (ct_blocks($ct_c) as $b) {
        foreach ($b['rows'] as $r) { $all++; if (trim((string) $r[1]) !== '') $on++; }
    }
    return [$on, $all];
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
