<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Privacy Notice body. The data map rows carry data-src so legal.js can filter them; without JS the full table shows.
   Storage facts were verified by grepping assets/js and sections on 24 Sep 2026: sessionStorage 'xe-seen' (core.js),
   'xe-brief' (services.js, contact.js); cookie 'xe_prefs' (legal/cookies.php). Fonts are self-hosted; no third-party requests.
   COUNSEL: confirm lawful-basis mapping, retention periods, the DPDP "legitimate uses" reliance, and the EU/UK representative question. */
$lgl_rows = [
    // [data, sources, where it comes from, purpose, basis, retention]
    ['Name, email, company, phone', 'contact brief', 'Contact form', 'Reply to your enquiry; prepare a proposal', 'Consent (DPDP s.6); GDPR Art. 6(1)(b) steps before a contract', '24 months from last contact'],
    ['Services picked, package, budget band, timeline, message', 'contact brief', 'Contact form and services brief', 'Understand the work you want and scope it', 'Consent; GDPR Art. 6(1)(b)', '24 months from last contact'],
    ['Services brief in your browser', 'brief', 'Services catalogue (sessionStorage <code>xe-brief</code>)', 'Carry the services you picked to the contact form', 'Strictly necessary for a feature you use', 'Until you close the tab; never sent unless you submit the form'],
    ['Call requests — name, email, company, the day and time you picked, your time zone and your brief', 'booking', 'The call-request form on our home page, or calls arranged by email', 'Confirm and hold the call; record what was agreed', 'Consent; GDPR Art. 6(1)(b)', '24 months from last contact'],
    ['Name, email, optional phone, your message and portfolio or LinkedIn links; a CV or references if you email them', 'careers', 'The application form on our careers page (no file uploads), or applications sent by email', 'Assess your application; contact you about roles', 'Consent; GDPR Art. 6(1)(b)', '12 months after the role closes, unless you ask us to keep it longer'],
    ['IP address, browser, pages requested, time, referrer', 'logs', 'Web server logs (our hosting provider)', 'Deliver pages, detect abuse, fix faults', 'DPDP legitimate use / reasonable purpose; GDPR Art. 6(1)(f) security', 'Rolling 30–90 days, set by the host'],
    ['Contract contacts, invoices, correspondence', 'client', 'Client engagements', 'Deliver the work, invoice, meet tax and company-law duties', 'Contract; legal obligation', '8 years after the financial year (Companies Act / GST records)'],
    ['Personal data inside client systems we work on', 'client', 'Client engagements, as a processor', 'Only the client\'s documented instructions', 'The client\'s basis; our Data Processing Agreement', 'Returned or deleted at the end of the engagement'],
];
$lgl_src = ['all' => 'All sources', 'contact' => 'Contact form', 'brief' => 'Services brief', 'booking' => 'Calls', 'careers' => 'Careers', 'logs' => 'Server logs', 'client' => 'Client work'];
?>
<?php lgl_sec('who'); ?>
  <p>Xterra Edze is the trading name of <span class="lgl-ph"><?= e($LGL_CO['entity']) ?></span>, a company incorporated in India (CIN <span class="lgl-ph"><?= e($LGL_CO['cin']) ?></span>), with offices in New Delhi and Ludhiana. For personal data we decide how to use, we are the <strong>Data Fiduciary</strong> under the DPDP Act and the <strong>controller</strong> under the GDPR and UK GDPR.</p>
  <p>When we work inside a client's systems, the client is the fiduciary or controller and we act as its <strong>Data Processor</strong>, under a written agreement. This notice covers our own processing; the client's notice covers theirs.</p>
  <!-- COUNSEL: whether an Art. 27 EU / UK representative is required given the volume of EU/UK visitors and clients. -->
</section>

<?php lgl_sec('collect'); ?>
  <p>This map lists every kind of personal data we hold, where it comes from, why we use it and how long we keep it. Filter it by where the data comes from.</p>
  <div class="lgl-map" data-lgl-map>
    <div class="lgl-map__f" role="group" aria-label="Filter the data map by source" hidden>
      <?php foreach ($lgl_src as $lgl_k => $lgl_v): $lgl_n = $lgl_k === 'all' ? count($lgl_rows) : count(array_filter($lgl_rows, fn ($r) => in_array($lgl_k, explode(' ', $r[1]), true))); ?>
        <button class="lgl-chip" type="button" data-lgl-f="<?= e($lgl_k) ?>" aria-pressed="<?= $lgl_k === 'all' ? 'true' : 'false' ?>"><?= e($lgl_v) ?> <b><?= $lgl_n ?></b></button>
      <?php endforeach; ?>
    </div>
    <div class="lgl-tw mask-x" tabindex="0" role="region" aria-label="Data map, scrolls sideways on small screens">
      <table class="lgl-tbl">
        <caption class="sr">Personal data Xterra Edze holds, with source, purpose, lawful basis and retention</caption>
        <thead><tr><th scope="col">Data</th><th scope="col">Where from</th><th scope="col">Why</th><th scope="col">Basis</th><th scope="col">Kept for</th></tr></thead>
        <tbody>
          <?php foreach ($lgl_rows as $lgl_r): ?>
            <tr data-src="<?= e($lgl_r[1]) ?>"><th scope="row"><?= e($lgl_r[0]) ?></th><td><?= $lgl_r[2] ?></td><td><?= e($lgl_r[3]) ?></td><td><?= e($lgl_r[4]) ?></td><td><?= e($lgl_r[5]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="lgl-map__live" aria-live="polite"></p>
  </div>
  <!-- PLACEHOLDER: retention periods are proposed defaults — confirm with counsel and the finance team before launch. -->
  <p>We do not ask for sensitive data such as health, religion, caste, biometrics or financial account details. Please do not send it in a message or CV. We do not use automated decision-making that has legal or similarly significant effects on you.</p>
  <p>The booking form on our home page sends a call request; nothing is reserved until we confirm by email. We use no third-party scheduling tool. The careers form sends your application to the same inbox as the contact form; it takes no file uploads.</p>
</section>

<?php lgl_sec('use'); ?>
  <p>We use personal data only for the purposes in the map above, and for these related purposes:</p>
  <ul>
    <li><strong>Keeping the site and our systems secure</strong> — detecting spam, abuse and attacks. Our forms (contact, call request and careers) use a hidden honeypot field and a timing check, not a third-party CAPTCHA.</li>
    <li><strong>Meeting legal duties</strong> — tax, accounting, company law and lawful requests from authorities.</li>
    <li><strong>Defending legal claims</strong> — only for as long as a claim could be brought.</li>
  </ul>
  <p>Under the DPDP Act we rely on your <strong>consent</strong>, given when you submit a form or send us an email, and on the <strong>legitimate uses</strong> the Act allows — for example where you voluntarily provide data for a specified purpose. Under the GDPR and UK GDPR we rely on steps before or for a contract (Art. 6(1)(b)), legal obligation (6(1)(c)) and our legitimate interest in running a secure website (6(1)(f)).</p>
  <p>We do not send marketing email unless you have asked for it, and every such email carries a one-click way to stop.</p>
</section>

<?php lgl_sec('storage'); ?>
  <p>This site sets <strong>no analytics, advertising or social-media cookies</strong>, loads no third-party scripts and serves its fonts from our own server. It uses three small first-party items, all described in the <a href="<?= e(lgl_url('cookies')) ?>">Cookie Policy</a>:</p>
  <ul>
    <li><code>xe-seen</code> — session storage; remembers that the opening animation has played, so it does not repeat on every page.</li>
    <li><code>xe-brief</code> — session storage; holds the services you picked until you send the contact form or close the tab.</li>
    <li><code>xe_prefs</code> — a cookie, set only when you save a choice in the preferences panel, recording that choice.</li>
  </ul>
</section>

<?php lgl_sec('share'); ?>
  <p>We share personal data only with service providers who process it for us under contract, and only as much as they need:</p>
  <div class="lgl-tw mask-x" tabindex="0" role="region" aria-label="Processors, scrolls sideways on small screens">
    <table class="lgl-tbl">
      <thead><tr><th scope="col">Processor</th><th scope="col">What for</th><th scope="col">Location</th></tr></thead>
      <tbody>
        <!-- PLACEHOLDER: confirm each processor, its role and its location before launch. -->
        <tr><th scope="row"><span class="lgl-ph">[Web hosting provider]</span></th><td>Hosting this site; server logs</td><td><span class="lgl-ph">[Country]</span></td></tr>
        <tr><th scope="row"><span class="lgl-ph">[Email provider]</span></th><td>Receiving and answering enquiries and applications</td><td><span class="lgl-ph">[Country]</span></td></tr>
        <tr><th scope="row"><span class="lgl-ph">[Accounting / invoicing tool]</span></th><td>Invoices and statutory records for clients</td><td><span class="lgl-ph">[Country]</span></td></tr>
        <tr><th scope="row"><span class="lgl-ph">[Video-call provider]</span></th><td>Calls you agree to join</td><td><span class="lgl-ph">[Country]</span></td></tr>
      </tbody>
    </table>
  </div>
  <p>We may also disclose data to professional advisers under a duty of confidence, to a buyer of our business under equivalent protections, or where Indian law requires it. <strong>We do not sell personal data</strong>, and we do not share it for others' advertising.</p>
</section>

<?php lgl_sec('transfer'); ?>
  <p>Some of our providers may store data outside India. The DPDP Act permits transfers except to countries the Central Government restricts by notification; we will not transfer to a restricted country. For data about people in the EU or UK, we rely on an adequacy decision or on Standard Contractual Clauses (or the UK Addendum) with the recipient.</p>
  <!-- COUNSEL: confirm transfer mechanisms and any sector-specific localisation obligations for client data. -->
</section>

<?php lgl_sec('retention'); ?>
  <p>We keep data only as long as the purpose needs, or as long as the law requires — the periods are in the data map. When a period ends we delete the data or make it anonymous. Under the DPDP Rules, where you have not engaged with us for the period specified for our class of fiduciary, we will tell you before erasing data we hold on your consent.</p>
</section>

<?php lgl_sec('rights'); ?>
  <p>Depending on where you live, you can ask us to:</p>
  <ul>
    <li><strong>Access</strong> — a summary of the personal data we hold and what we do with it, and who we have shared it with.</li>
    <li><strong>Correct, complete or update</strong> data that is wrong or out of date.</li>
    <li><strong>Erase</strong> data we no longer need or hold only on your consent.</li>
    <li><strong>Withdraw consent</strong> at any time, as easily as you gave it. Withdrawal does not affect what was done before.</li>
    <li><strong>Nominate</strong> someone to exercise your rights if you die or become incapable (DPDP Act s.14).</li>
    <li>Under the GDPR and UK GDPR, also <strong>object</strong>, <strong>restrict</strong> processing and <strong>port</strong> your data.</li>
  </ul>
  <p>Email <a href="<?= e(lgl_mail('Privacy request')) ?>"><?= e($SITE['company']['email']) ?></a> with the subject "Privacy request". We may ask you to confirm who you are.</p>
  <!-- PLACEHOLDER: response time — confirm before launch (DPDP Rules and GDPR both set outer limits; GDPR: one month). -->
  <p>We aim to reply within <span class="lgl-ph">[30] days</span>.</p>
</section>

<?php lgl_sec('children'); ?>
  <p>This site and our services are for businesses and adults. We do not knowingly collect data from anyone under 18. If you believe a child has sent us personal data, tell us and we will delete it. We do not track, behaviourally monitor or target advertising at children.</p>
</section>

<?php lgl_sec('security'); ?>
  <p>We protect personal data with reasonable security safeguards, as the DPDP Act and the IT Act's reasonable-security-practices rules require: encrypted connections (HTTPS), least-privilege access, multi-factor authentication on the accounts that hold data, and deletion when retention ends. The <a href="<?= e(lgl_url('security')) ?>">Security page</a> describes our practice.</p>
  <p>If a personal data breach occurs, we will inform the Data Protection Board of India and affected people as the DPDP Rules require, CERT-In within its reporting window where the incident is reportable, and — for EU/UK data — the supervisory authority within 72 hours where required.</p>
</section>

<?php lgl_sec('grievance'); ?>
  <dl class="lgl-dl">
    <dt>Grievance Officer</dt><dd><span class="lgl-ph"><?= e($LGL_CO['go_name']) ?></span></dd>
    <dt>Email</dt><dd><a href="<?= e(lgl_mail('Grievance')) ?>"><?= e($LGL_CO['go_mail']) ?></a> <!-- PLACEHOLDER: dedicated grievance mailbox --></dd>
    <dt>Post</dt><dd><span class="lgl-ph"><?= e($LGL_CO['office']) ?></span></dd>
    <dt>Response</dt><dd>Acknowledged, and resolved within the period the DPDP Rules set <span class="lgl-ph">[confirm]</span></dd>
  </dl>
  <p>If you are not satisfied with our answer, you can complain to the <strong>Data Protection Board of India</strong>. In the EU or UK you can also complain to your local supervisory authority, such as the UK Information Commissioner's Office.</p>
</section>

<?php lgl_sec('changes'); ?>
  <p>We will update this notice when our practice changes. The version and date at the top will change, and if the change is material we will say so on this page for at least 30 days.</p>
</section>
