<?php /* DRAFT COPY — review before launch */
/**
 * The Dispatch — the sign-up POST handler.
 *
 * Include from newsletter.php after partials/init.php and BEFORE any output: it may redirect and exit,
 * and it may answer a JavaScript submission with JSON and exit.
 *
 *   GET   ?sent=1[&ref=XE-NL-…][&at=<instance>]   the success state (the Post/Redirect/Get target)
 *   POST  nl=1  the sign-up form from partials/newsletter/signup.php, on this page or on any other
 *         page that includes the component. Every instance of the component posts here, because this
 *         is the only page that runs this file.
 *
 * WHAT ACTUALLY HAPPENS ON SUBMIT — and what the page must say
 *   There is no database and no email-service integration on this site. A valid submission sends ONE
 *   plain-text email to $SITE['company']['email'] with the address in it, and stops. Nothing is stored,
 *   nothing is subscribed, and no confirmation email goes to the visitor, because there is nothing to
 *   send one with. partials/newsletter/signup.php prints that in the form, and partials/newsletter/
 *   subscribe.php prints the three steps it will become once an email service is connected.
 *   <!-- PLACEHOLDER: connect a real email service (Mailchimp, Buttondown, Kit, …) before launch, and
 *        move this handler over to its API so the address is stored and the confirmation email is sent
 *        by the service rather than added by hand. -->
 *
 * PROTECTION, the same mechanisms partials/contact/handler.php uses
 *   a honeypot field (a filled one gets a quiet fake success and nothing is sent), a signed render
 *   time with a minimum fill time, a length cap on every field, and header-injection-safe values
 *   (control characters stripped, the address validated, every header value encoded).
 *
 * TWO RESPONSE SHAPES
 *   Without JavaScript the form is an ordinary POST: success redirects 303 to ?sent=1 on this page and
 *   an error re-renders the page with every value back in the field it came from. With JavaScript the
 *   component adds js=1 and this file answers with JSON and exits, so the visitor's page never moves.
 *
 * Produces $NL:
 *   'state'   'form' | 'error' | 'sent' | 'failed'
 *   'inst'    which instance of the component the result belongs to (see $NL_INSTANCES in newsletter.php)
 *   'v'       ['email' =>, 'topics' => [], 'source' =>] — re-rendered into the form on an error
 *   'errors'  field => message          'ref' 'XE-NL-XXXXXX' (sent / failed)
 *   'mailto'  a mailto: URL holding the same request (failed only)
 *   't'       the signed time token every rendered form carries
 *   'topics'  the interest list from data/newsletter.php
 *
 * Locals are prefixed nl_.
 */

$NL = [
    'state'  => 'form',
    'inst'   => '',
    'v'      => ['email' => '', 'topics' => [], 'source' => ''],
    'errors' => [],
    'ref'    => '',
    'mailto' => '',
    't'      => '',
    'topics' => [],
];

$NL['topics'] = (require __DIR__ . '/../../data/newsletter.php')['topics'];

/* ---------------- helpers ---------------- */

/** One line of visitor text: control characters out, trimmed, capped. */
function nl_line($nl_s, int $nl_max): string {
    $nl_s = is_string($nl_s) ? $nl_s : '';
    $nl_s = preg_replace('~[\x00-\x1F\x7F]~u', '', $nl_s) ?? '';
    return mb_substr(trim($nl_s), 0, $nl_max);
}

/** The key the render-time token is signed with. Per file and per host, never in the page. */
function nl_key(): string { return hash('sha256', __FILE__ . '|' . php_uname('n') . '|xe-newsletter'); }

/** A signed "this form was rendered at" token. */
function nl_token(): string {
    $nl_t = (string) time();
    return $nl_t . '.' . substr(hash_hmac('sha256', $nl_t, nl_key()), 0, 20);
}

/** Seconds since the form was rendered, or null when the token is missing or forged. */
function nl_age($nl_tok): ?int {
    if (!is_string($nl_tok) || !preg_match('~^(\d{9,11})\.([a-f0-9]{20})$~', $nl_tok, $nl_m)) return null;
    if (!hash_equals(substr(hash_hmac('sha256', $nl_m[1], nl_key()), 0, 20), $nl_m[2])) return null;
    return time() - (int) $nl_m[1];
}

/** A page key ('blog', 'newsletter', …) recorded so we can tell which writing brings people in. */
function nl_source($nl_s): string {
    return (is_string($nl_s) && preg_match('~^[a-z0-9][a-z0-9-]{0,39}$~', $nl_s)) ? $nl_s : '';
}

/**
 * Is this a deliverable-looking address? filter_var does the syntax; the rest rejects the shapes it
 * accepts that no mail server would ever deliver to — a domain with no dot, a local part over the
 * RFC 5321 limit, or a trailing dot.
 */
function nl_email_ok(string $nl_e): bool {
    if ($nl_e === '' || mb_strlen($nl_e) > 190) return false;
    if (!filter_var($nl_e, FILTER_VALIDATE_EMAIL)) return false;
    $nl_at = strrpos($nl_e, '@');
    if ($nl_at === false) return false;
    $nl_local  = substr($nl_e, 0, $nl_at);
    $nl_domain = substr($nl_e, $nl_at + 1);
    if ($nl_local === '' || strlen($nl_local) > 64) return false;
    if (strpos($nl_domain, '.') === false) return false;
    if (substr($nl_domain, -1) === '.' || substr($nl_domain, 0, 1) === '-') return false;
    if (!preg_match('~\.[A-Za-z]{2,}$~', $nl_domain)) return false;
    return true;
}

/** "Name <email>" with the name MIME-encoded, so nothing in it can break a header. */
function nl_addr(string $nl_name, string $nl_email): string {
    $nl_name = trim(str_replace(['"', '<', '>', ',', ';', '\\'], '', $nl_name));
    return ($nl_name !== '' ? mb_encode_mimeheader($nl_name, 'UTF-8', 'Q') . ' ' : '') . '<' . $nl_email . '>';
}

/** Answer a JavaScript submission with JSON and stop. Never called for a plain form post. */
function nl_json(array $nl_payload): void {
    header('Content-Type: application/json; charset=UTF-8');
    header('Cache-Control: no-store');
    echo json_encode($nl_payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

/* ---------------- the success state, after the redirect ---------------- */

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    if (isset($_GET['sent']) && $_GET['sent'] === '1') {
        $NL['state'] = 'sent';
        $NL['inst']  = nl_source($_GET['at'] ?? '');
        $nl_ref      = is_string($_GET['ref'] ?? null) ? $_GET['ref'] : '';
        $NL['ref']   = preg_match('~^XE-NL-[A-Z0-9]{6}$~', $nl_ref) ? $nl_ref : '';
    }
    $NL['t'] = nl_token();
    return;
}

/* ---------------- the POST ---------------- */

/* Not our form: another handler on this page owns it, or the body was dropped. Fall through to the
   ordinary page so nothing is silently swallowed. */
if (($_POST['nl'] ?? '') !== '1') {
    $NL['t'] = nl_token();
    return;
}

$nl_js   = ($_POST['js'] ?? '') === '1';
$nl_home = xe_url('newsletter.php');

$NL['inst']         = nl_source($_POST['inst'] ?? '');
$NL['v']['email']   = nl_line($_POST['email'] ?? '', 190);
$NL['v']['source']  = nl_source($_POST['source'] ?? '');
$nl_posted          = $_POST['topic'] ?? [];
$NL['v']['topics']  = is_array($nl_posted)
    ? array_values(array_intersect(array_map('strval', $nl_posted), array_keys($NL['topics'])))
    : [];

/* Bots: a filled honeypot gets the same success a person gets, and nothing is sent. */
if (nl_line($_POST['website'] ?? '', 200) !== '') {
    if ($nl_js) nl_json(['ok' => true, 'state' => 'sent', 'ref' => '', 'message' => 'Thank you. Your address is with us.']);
    header('Location: ' . $nl_home . '?sent=1' . ($NL['inst'] !== '' ? '&at=' . rawurlencode($NL['inst']) : ''), true, 303);
    exit;
}

if ($NL['v']['email'] === '') {
    $NL['errors']['email'] = 'Enter the address you would like the issue sent to.';
} elseif (!nl_email_ok($NL['v']['email'])) {
    $NL['errors']['email'] = 'That does not look like an address we could send to. Something like name@company.com.';
}

$nl_age = nl_age($_POST['t'] ?? null);
if ($nl_age === null) {
    $NL['errors']['form'] = 'This form expired. Your address is still in the box — send it again.';
} elseif ($nl_age < 2) {
    $NL['errors']['form'] = 'That was quicker than a person. Press subscribe once more.';
}

if ($NL['errors']) {
    $NL['state'] = 'error';
    $NL['t']     = nl_token();
    if ($nl_js) nl_json(['ok' => false, 'state' => 'error', 'errors' => $NL['errors'], 't' => $NL['t']]);
    return;
}

/* ---------------- one email to the inbox, then stop ---------------- */

$nl_ref   = 'XE-NL-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
$nl_to    = $SITE['company']['email'];
$nl_names = [];
foreach ($NL['v']['topics'] as $nl_k) { $nl_names[] = $NL['topics'][$nl_k]; }

$nl_body = implode("\n", [
    'Newsletter sign-up — The Dispatch',
    'Reference     : ' . $nl_ref,
    'Address       : ' . $NL['v']['email'],
    'Interests     : ' . ($nl_names ? implode('; ', $nl_names) : '— none chosen'),
    'Signed up from: ' . ($NL['v']['source'] !== '' ? $NL['v']['source'] : '— not recorded'),
    'Received      : ' . gmdate('Y-m-d H:i:s') . ' UTC',
    '',
    'NOT SUBSCRIBED. Nothing was stored and no confirmation email was sent, because no email service',
    'is connected to this site yet. Add this address to the list by hand, or connect the service and',
    'send the confirmation link from there.',
]) . "\n";

$nl_subject = 'Newsletter sign-up ' . $nl_ref . ' — ' . $NL['v']['email'];
$nl_headers = [
    // PLACEHOLDER: a sending address on the live domain, once DNS and SPF/DKIM are set up.
    'From'                      => nl_addr($SITE['company']['name'] . ' website', $nl_to),
    'Reply-To'                  => nl_addr('', $NL['v']['email']),
    'MIME-Version'              => '1.0',
    'Content-Type'              => 'text/plain; charset=UTF-8',
    'Content-Transfer-Encoding' => '8bit',
    'X-XE-Newsletter'           => $nl_ref,
];

$nl_ok = function_exists('mail')
    && @mail($nl_to, mb_encode_mimeheader($nl_subject, 'UTF-8', 'B', "\r\n"), str_replace("\n", "\r\n", $nl_body), $nl_headers);

if ($nl_ok) {
    if ($nl_js) {
        nl_json(['ok' => true, 'state' => 'sent', 'ref' => $nl_ref,
                 'message' => 'Your address is with us. Nothing is subscribed yet — see what happens next below.']);
    }
    header('Location: ' . $nl_home . '?sent=1&ref=' . $nl_ref
        . ($NL['inst'] !== '' ? '&at=' . rawurlencode($NL['inst']) : '') . '#subscribe', true, 303);
    exit;
}

/* mail() is unavailable or the MTA refused it. Say so, keep what was typed, and hand over a mailto:
   holding the same request so the visitor is not left with nothing. */
error_log('newsletter: mail() failed for sign-up ' . $nl_ref);
$NL['state']  = 'failed';
$NL['ref']    = $nl_ref;
$NL['t']      = nl_token();
$NL['mailto'] = 'mailto:' . $nl_to
    . '?subject=' . rawurlencode('Newsletter sign-up ' . $nl_ref)
    . '&body=' . rawurlencode($nl_body);

if ($nl_js) {
    nl_json(['ok' => false, 'state' => 'failed', 'ref' => $nl_ref, 'mailto' => $NL['mailto'], 't' => $NL['t'],
             'message' => 'Your address did not reach our inbox. Nothing was lost — send it to us directly with the link below.']);
}
