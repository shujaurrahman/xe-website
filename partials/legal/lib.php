<?php /* DRAFT COPY — review before launch */ ?>
<?php
/**
 * Legal suite — the policy register and the document helpers (prefix lgl).
 * Every legal page reads its title, summary, date and version from $LGL_POLICIES, so the hub,
 * the related-policy cards and each page's header can never disagree.
 *
 * PLACEHOLDER: legal review by qualified counsel before launch. Nothing in this suite is legal advice.
 * PLACEHOLDER: every date and version below is a draft stamp — reset to the publication date at launch.
 */

$LGL_POLICIES = [
    'privacy' => ['title' => 'Privacy Notice', 'icon' => 'lock', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'What we collect through this site and our work, why, how long we keep it, and the rights you have under the DPDP Act 2023 and, where they apply, the GDPR and UK GDPR.'],
    'terms' => ['title' => 'Terms of Use', 'icon' => 'doc', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'The rules for using this website: what you may do with its content, what we do not promise, and the law and courts that govern it.'],
    'cookies' => ['title' => 'Cookie Policy', 'icon' => 'filter', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'Every cookie and browser-storage item this site uses, listed by name. No analytics or advertising cookies today. Your preferences panel lives here.'],
    'accessibility' => ['title' => 'Accessibility Statement', 'icon' => 'accessibility', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'We build to WCAG 2.2 AA. What we do to get there, where we know we fall short, and how to report a barrier.'],
    'commercial-policy' => ['title' => 'Commercial Policy', 'icon' => 'handshake', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'Our standard terms of business: statements of work, the six ways to contract, change control, invoicing, IP, confidentiality and liability — always subject to the signed agreement.'],
    'intellectual-property' => ['title' => 'Intellectual Property', 'icon' => 'shield', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'The Xterra Edze® mark, how you may refer to it, who owns the content on this site, and how client work passes to clients on payment.'],
    'responsible-ai' => ['title' => 'Responsible AI Policy', 'icon' => 'agent', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'How we use AI in client work: human approval, no training on your data without written consent, disclosure, evaluation, vendor choice, residency and logging.'],
    'security' => ['title' => 'Security & Disclosure', 'icon' => 'shield', 'updated' => '24 September 2026', 'iso' => '2026-09-24', 'version' => '0.9',
        'sum' => 'A summary of our security practice, and how to report a vulnerability to us in good faith — with a safe harbour for researchers who follow it.'],
];

/* Company legal particulars — every value is a PLACEHOLDER until the registration documents are in hand. */
$LGL_CO = [
    'entity'    => '[Legal entity name] Private Limited',
    'cin'       => '[CIN — 21 characters]',
    'gstin'     => '[GSTIN — 15 characters]',
    'office'    => '[Registered office address, as on the Certificate of Incorporation]',
    'tm'        => [['[Reg. no.]', 'Class 35', 'Advertising, business management and brand consultancy'], ['[Reg. no.]', 'Class 42', 'Design, software and technology services']],
    'go_name'   => '[Name of Grievance Officer]',
    'go_mail'   => 'connect@xterraedze.com',
];

if (!function_exists('lgl_url')) {
    function lgl_url(string $key): string { return xe_url('legal/' . ($key === 'index' ? '' : $key . '.php')); }

    /** mailto: link to the site inbox with a subject line. PLACEHOLDER: dedicated mailboxes (privacy@, security@, grievance@) before launch. */
    function lgl_mail(string $subject): string {
        global $SITE;
        return 'mailto:' . $SITE['company']['email'] . '?subject=' . rawurlencode($subject);
    }

    /** Opens a numbered document section; the number and title come from $LG['toc']. */
    function lgl_sec(string $id): void {
        global $LG;
        $n = array_search($id, array_keys($LG['toc']), true);
        $t = $LG['toc'][$id] ?? $id;
        printf('<section class="lgl-sec" id="%1$s" aria-labelledby="%1$s-t"><h2 class="lgl-h2" id="%1$s-t"><a class="lgl-anc" href="#%1$s" aria-label="Link to section %2$02d, %3$s">%2$02d</a><span>%3$s</span></h2>',
            e($id), $n === false ? 0 : $n + 1, e($t));
    }
}
