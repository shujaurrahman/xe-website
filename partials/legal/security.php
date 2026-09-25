<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Security body. COUNSEL: safe-harbour wording under IT Act s.43/66 (authorisation), CERT-In Directions (April 2022)
   6-hour incident reporting, and whether to name a CERT-In point of contact. Truth: no certification is claimed. */
$lgl_txt = @file_get_contents(__DIR__ . '/../../.well-known/security.txt') ?: '';
?>
<?php lgl_sec('practice'); ?>
  <p>Security is part of how we build, not a stage at the end. In summary:</p>
  <ul>
    <li><strong>Access</strong> — least privilege, multi-factor authentication on every business account, and access removed the day someone leaves an engagement.</li>
    <li><strong>Client environments</strong> — we work in your accounts and tools where you prefer, with credentials you issue and can revoke.</li>
    <li><strong>Encryption</strong> — HTTPS everywhere; data encrypted at rest in the services we use.</li>
    <li><strong>Secure delivery</strong> — code review, dependency scanning and secrets management on the software we build, to OWASP ASVS as a baseline.</li>
    <li><strong>Incidents</strong> — a written response plan; we notify affected clients without undue delay and report to CERT-In and the Data Protection Board where the law requires.</li>
  </ul>
  <!-- PLACEHOLDER: confirm each practice is in place before launch; do not add any certification claim without evidence. -->
  <p>We build to frameworks such as ISO/IEC 27001 and OWASP ASVS. We do not currently hold a security certification.</p>
</section>

<?php lgl_sec('report'); ?>
  <p>Email <a href="<?= e(lgl_mail('Security report')) ?>"><?= e($SITE['company']['email']) ?></a> with the subject "Security report". Please include the affected URL or system, a description of the issue and its impact, steps to reproduce, and how we can reach you. Do not include personal data you may have encountered beyond what is needed to show the issue.</p>
</section>

<?php lgl_sec('process'); ?>
  <!-- PLACEHOLDER: response targets — confirm before launch. -->
  <ol class="lgl-flow">
    <li><h3>Acknowledge <span class="lgl-st">Target: [3] working days</span></h3><p>We confirm we have your report and who is handling it.</p></li>
    <li><h3>Triage <span class="lgl-st">Target: [10] working days</span></h3><p>We reproduce the issue, assess severity and tell you our assessment.</p></li>
    <li><h3>Fix</h3><p>We fix it in line with its severity and keep you updated. We may ask you to confirm the fix.</p></li>
    <li><h3>Disclose and credit</h3><p>We agree the timing of any public disclosure with you, and credit you if you wish.</p></li>
  </ol>
</section>

<?php lgl_sec('scope'); ?>
  <p><strong>In scope:</strong> this website and its forms, and systems operated by Xterra Edze. <strong>Out of scope:</strong> client systems (report those to the client), third-party services we use, denial-of-service, social engineering or phishing of our people, physical attacks, and findings with no security impact such as missing headers on static pages without a demonstrated exploit.</p>
</section>

<?php lgl_sec('rules'); ?>
  <ul>
    <li>Test only against your own accounts and data; stop and report as soon as you reach anyone else's.</li>
    <li>Do not degrade service, destroy data, or keep more data than needed to show the issue — and delete it afterwards.</li>
    <li>Give us reasonable time to fix before disclosing publicly.</li>
    <li>Do not demand payment in exchange for details of a vulnerability.</li>
  </ul>
</section>

<?php lgl_sec('harbour'); ?>
  <p>If you make a good-faith effort to follow this policy, we will consider your research authorised, we will not pursue or support legal action against you for it, and we will work with you to understand and fix the issue. If a third party brings action against you for research that followed this policy, we will make clear that it was authorised.</p>
</section>

<?php lgl_sec('txt'); ?>
  <p>Our security contact is also published in machine-readable form, as RFC 9116 specifies:</p>
  <div class="lgl-txt">
    <div class="lgl-txt__h"><span>/.well-known/security.txt</span><a href="<?= e(xe_url('.well-known/security.txt')) ?>">Open file</a></div>
    <pre><?php foreach (preg_split('~\R~', trim($lgl_txt)) as $lgl_ln) echo (str_starts_with($lgl_ln, '#') ? '<span class="c">' . e($lgl_ln) . '</span>' : e($lgl_ln)), "\n"; ?></pre>
  </div>
</section>
