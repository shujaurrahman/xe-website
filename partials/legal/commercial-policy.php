<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Commercial Policy body. The selector renders every contract as a stacked pane (complete without JS); legal.js turns it into
   ARIA tabs. COUNSEL: every clause below — especially the liability cap and carve-outs, IP assignment mechanics under the
   Copyright Act 1957 s.18–19 (written, signed assignment), non-solicitation enforceability under Indian Contract Act s.27,
   termination notice periods, late-payment interest and the MSMED Act if applicable, and arbitration seat. */
$lgl_pk_terms = [
    // key => [invoicing, change control, ending it]
    'sprint'     => ['50% on signing, 50% on delivery', 'A change to the question means a new sprint', 'Either side, 5 working days\' notice; work done to date is paid'],
    'project'    => ['Staged: on signing, at mid-point review, on acceptance', 'Written change request, priced before it is started', 'Either side, 15 days\' notice; work done to date is paid'],
    'milestone'  => ['Per milestone, on acceptance of that milestone', 'Changes re-plan the next milestone, never the current one', 'At any milestone boundary, without penalty'],
    'retainer'   => ['Monthly in advance', 'Priorities re-set at each monthly review, inside the retained capacity', 'After the minimum term, 30 days\' notice'],
    'enterprise' => ['Per statement of work — monthly or by milestone', 'Programme change board; each change signed by both sides', 'As the master agreement sets out'],
    'squad'      => ['Monthly in arrears, against timesheets', 'You direct priorities week to week; the rate card is fixed', 'After the minimum term, 30 days\' notice'],
];
?>
<?php lgl_sec('basis'); ?>
  <p>This policy describes our standard commercial terms so you know what to expect before you sign. It is not itself a contract. Each engagement is governed by a <strong>master services agreement</strong> (where we have one) and a <strong>statement of work</strong>. Order of precedence: the signed statement of work, then the signed agreement, then this policy.</p>
  <p class="lgl-note"><span class="lgl-note__k">Subject to the signed agreement</span>Everything below is subject to the signed agreement between us, which prevails over this page.</p>
</section>

<?php lgl_sec('contracts'); ?>
  <p>We offer six ways to contract. Choose one to see how the standard terms apply to it.</p>
  <div class="lgl-pk" data-lgl-pk>
    <div class="lgl-pk__tabs" role="tablist" aria-label="Ways to contract">
      <?php $lgl_i = 0; foreach ($LGL_PK as $lgl_k => $lgl_p): ?>
        <button class="lgl-pk__tab" type="button" role="tab" id="lgl-pk-t-<?= e($lgl_k) ?>" aria-controls="lgl-pk-<?= e($lgl_k) ?>" aria-selected="<?= $lgl_i++ ? 'false' : 'true' ?>"><?= xt_icon(['retainer' => 'sync', 'enterprise' => 'cluster'][$lgl_k] ?? ($lgl_p['icon'] ?? 'doc')) ?><?= e($lgl_p['name']) ?></button>
      <?php endforeach; ?>
    </div>
    <?php foreach ($LGL_PK as $lgl_k => $lgl_p): $lgl_t = $lgl_pk_terms[$lgl_k] ?? ['As the statement of work sets out', 'Written change request', 'As the agreement sets out']; ?>
      <div class="lgl-pk__pane" id="lgl-pk-<?= e($lgl_k) ?>" aria-labelledby="lgl-pk-t-<?= e($lgl_k) ?>">
        <h3><?= e($lgl_p['name']) ?></h3>
        <p class="lgl-pk__tag"><?= e($lgl_p['tagline']) ?></p>
        <dl class="lgl-dl">
          <dt>Pricing model</dt><dd><?= e($lgl_p['pricing']) ?></dd>
          <!-- PLACEHOLDER: typical durations and invoicing schedules — confirm before launch. -->
          <dt>Typical length</dt><dd><?= e($lgl_p['duration']) ?></dd>
          <dt>Invoicing</dt><dd><span class="lgl-ph"><?= e($lgl_t[0]) ?></span></dd>
          <dt>Change control</dt><dd><?= e($lgl_t[1]) ?></dd>
          <dt>Ending it</dt><dd><?= e($lgl_t[2]) ?></dd>
        </dl>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php lgl_sec('sow'); ?>
  <p>A statement of work records the outcome, scope and exclusions, deliverables and acceptance criteria, the team and named lead, timeline, fees and payment schedule, dependencies on you, and any data-protection or AI terms specific to the work. We do not start work — and you owe nothing — until it is signed by both sides.</p>
  <p><strong>Acceptance.</strong> You have <span class="lgl-ph">[10] working days</span> to accept a deliverable or tell us in writing how it misses the acceptance criteria. We then fix it at our cost. A deliverable is accepted when you approve it, when that period ends without a notice, or when you use it in live operation.</p>
</section>

<?php lgl_sec('change'); ?>
  <p>Either side can propose a change. We respond in writing with its effect on scope, timeline and fee. A change takes effect only when both sides approve it in writing — email from a named approver is enough. We will not bill for unapproved work.</p>
</section>

<?php lgl_sec('fees'); ?>
  <!-- PLACEHOLDER: payment terms, currency and late-payment interest — confirm with finance and counsel before launch. -->
  <ul>
    <li>Fees are in Indian rupees unless the statement of work says otherwise, and <strong>exclude GST</strong>, which we add at the applicable rate. Our GSTIN appears on every tax invoice.</li>
    <li>Invoices are payable within <span class="lgl-ph">[30] days</span> of the invoice date.</li>
    <li>For clients outside India, services may qualify as an export of services; GST treatment follows the law at the time of supply.</li>
    <li>Where you must deduct TDS, please send the TDS certificate each quarter so we can reconcile.</li>
    <li>Pre-approved expenses (travel, third-party licences) are passed through at cost, with receipts.</li>
    <li>Overdue amounts may carry interest at <span class="lgl-ph">[rate]</span>, and we may pause work on 15 days' written notice.</li>
  </ul>
</section>

<?php lgl_sec('ip'); ?>
  <ul>
    <li><strong>Deliverables are yours on payment.</strong> On full payment of the fees for a deliverable, we assign to you all rights in it, in writing, worldwide and for the full term of protection.</li>
    <li><strong>Our background IP stays ours.</strong> Tools, frameworks, libraries, prompts, evaluation suites and know-how we had before, or build independently, remain ours. Where a deliverable includes them, you get a perpetual, royalty-free, non-exclusive licence to use them as part of that deliverable.</li>
    <li><strong>Third-party and open-source components</strong> stay under their own licences, which we list at handover.</li>
    <li><strong>Portfolio.</strong> We will not name you or show your work publicly without your written permission.</li>
  </ul>
</section>

<?php lgl_sec('conf'); ?>
  <p>Each side keeps the other's confidential information secret, uses it only for the engagement, and shares it only with people who need it and are bound by the same duty. This lasts during the engagement and for <span class="lgl-ph">[3] years</span> after — indefinitely for trade secrets and personal data. We sign your NDA, or offer ours, before any briefing that needs one.</p>
</section>

<?php lgl_sec('data'); ?>
  <p>Where we process personal data for you, we act as your processor under a <strong>Data Processing Agreement</strong> that meets the DPDP Act and, where relevant, GDPR Art. 28: we act only on your documented instructions, keep it confidential and secure, use approved sub-processors, help with rights requests and breaches, and return or delete it at the end. Our <a href="<?= e(lgl_url('responsible-ai')) ?>">Responsible AI Policy</a> forms part of every engagement that uses AI.</p>
</section>

<?php lgl_sec('warranty'); ?>
  <p>We warrant that we will perform the services with reasonable skill and care, by suitably qualified people, in line with good industry practice; and that, to our knowledge, deliverables will not infringe third-party rights. We do not warrant specific commercial results, since those depend on factors outside our control. All other warranties are excluded to the extent the law allows.</p>
</section>

<?php lgl_sec('liability'); ?>
  <p>Each side's total liability under a statement of work is capped at the <strong>fees paid and payable under that statement of work</strong> in the 12 months before the claim. Neither side is liable for indirect or consequential loss, or loss of profit, revenue or goodwill. The cap does not apply to fraud, wilful misconduct, breach of confidentiality, your payment obligations, or liability that cannot legally be limited.</p>
</section>

<?php lgl_sec('term'); ?>
  <p>Notice periods for each way to contract are shown in section 02. Either side may also end an engagement at once if the other materially breaches and does not fix it within 30 days of written notice, or becomes insolvent. On termination you pay for work done to date; we hand over work in progress, and return or delete your data and confidential information.</p>
</section>

<?php lgl_sec('nonsol'); ?>
  <p>During an engagement and for <span class="lgl-ph">[12] months</span> after, neither side will actively solicit for employment anyone from the other side who worked on it, without consent. General job advertisements are not solicitation.</p>
</section>

<?php lgl_sec('law'); ?>
  <p>These terms and every agreement that refers to them are governed by the laws of India. The parties will first try to settle any dispute through senior representatives within 30 days. Failing that, it goes to arbitration under the Arbitration and Conciliation Act 1996, by a sole arbitrator, seated in <span class="lgl-ph">New Delhi</span>, in English; the courts at New Delhi have supervisory jurisdiction.</p>
</section>
