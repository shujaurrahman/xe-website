<?php /* DRAFT COPY — review before launch */
/* FAQ — asked directly. A sticky side with the heading, the route to a session and what to bring to
   it; beside it, the six questions from the brief in a core accordion ([data-acc], one open at a
   time), each tagged with its topic. The model answer builds on $CAP['faq']; the rest are page copy.
   FAQPage structured data mirrors the visible questions and answers. */
$tas_fq_cap = [];
foreach ($CAP['faq'] as $tas_f) { $tas_fq_cap[] = $tas_f; }
$tas_fq = [   // [topic, question, answer]
    ['Strategy', 'Where should we start?',
        'With one process that has volume, a clear owner and data you can already reach. We score a long list with the people who run the work, then pilot the top candidate at L1 or L2. Strong first candidates are usually back-office tasks with clear rules, such as invoice matching or quote drafting, rather than open-ended customer chat.'],
    ['Models', $tas_fq_cap[1][0] ?? 'Which models do you use?',
        ($tas_fq_cap[1][1] ?? '') . ' Within one agent, models are chosen per step: a small, fast model routes and extracts, and a larger one is used only where the reasoning pays for itself.'],
    ['Autonomy', 'Can agents act without a person approving?',
        'Only at L4, only for named tasks and only inside limits you set: spend per run, records touched and a business limit such as a maximum discount. Anything outside the limits escalates to a person. A task reaches L4 only after 90 days at L3 in which approvers rarely changed the agent’s actions, and the decision is recorded in the register.'],
    ['Security', 'How do you stop prompt injection and an agent doing something it should not?',
        'Everything the model reads is treated as untrusted, including retrieved documents, emails and account notes. Tools are allow-listed per level, credentials are scoped to the agent’s own identity, every write passes a policy check outside the model, and high-impact actions wait for a person. Each release is red-teamed against OWASP LLM01 (prompt injection) and LLM06 (excessive agency). No filter catches everything, which is why permissions and approvals, not the prompt, carry the weight.'],
    ['Cost', 'What does an agent cost to run?',
        'Three parts: model usage, the platform around it (hosting, vector store, tracing) and the time people spend approving and reviewing. With a small model routing and retrieved context cached, model usage for a back-office task is often a few cents, depending on document length and the models chosen. We measure cost per task from the first eval baseline against the manual cost, review time included.'],
    ['Regulation', 'How do the EU AI Act and India’s DPDP Act affect us?',
        'The EU AI Act applies when you place AI systems on the EU market, deploy them in the EU, or their output is used in the EU. Most business agents sit in the minimal or limited tiers; transparency duties, such as telling people they are dealing with AI, apply from August 2026. Annex III uses, such as recruitment or the creditworthiness of individuals, are high-risk, with duties for risk management, logging and human oversight that apply from December 2027 after the 2026 amendment. The DPDP Act 2023 governs the personal data of people in India; under the DPDP Rules 2025 most duties (notice, consent, security safeguards, breach reporting) apply from May 2027. We map both in one register. This is engineering guidance, not legal advice.'],
];
$tas_fq = array_values(array_filter($tas_fq, fn ($tas_x) => $tas_x[2] !== ''));
$tas_fq_bring = [
    ['workflow', 'The processes you want to change, with rough weekly volumes'],
    ['users',    'Who owns each one, and who approves changes to it'],
    ['database', 'The systems and data each process touches'],
    ['shield',   'Your risk appetite, and any regulator in scope'],
];
$tas_fq_ld = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => array_map(fn ($tas_x) => ['@type' => 'Question', 'name' => $tas_x[1], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $tas_x[2]]], $tas_fq),
];
?>
<section class="band tas-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="tas-fq">
      <div class="tas-fq__side">
        <div class="tas-fq__sticky" data-rv>
          <p class="tas-kick"><span class="tas-kick__ref">12</span>Questions</p>
          <h2 class="h2" id="faq-t"><span class="g">AI Strategy &amp; Agents,</span> asked directly.</h2>
          <p class="lead">The questions leadership, legal and security ask in the first meeting, answered plainly.</p>

          <div class="tas-fq__bring">
            <p class="tas-lbl">Bring to the first session</p>
            <ul>
              <?php foreach ($tas_fq_bring as $tas_b): ?>
                <li><?= xt_icon($tas_b[0], ['size' => 18]) ?><span><?= e($tas_b[1]) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <a class="btn btn--ink tas-fq__cta" href="<?= xe_url('contact.php') ?>">Book an AI strategy session <span class="i" aria-hidden="true">›</span></a>
          </div>
        </div>
      </div>

      <div class="tas-fq__list" data-acc data-rv>
        <?php foreach ($tas_fq as $tas_qi => $tas_q): $tas_open = $tas_qi === 0; ?>
          <?php if ($tas_q[0] === 'Regulation'): ?><!-- PLACEHOLDER: confirm the EU AI Act (as amended 2026) and DPDP Rules 2025 dates before launch --><?php endif; ?>
          <div class="tas-fq__item">
            <h3 class="tas-fq__q">
              <button type="button" class="tas-fq__btn" data-acc-b aria-expanded="<?= $tas_open ? 'true' : 'false' ?>" aria-controls="faq-a<?= $tas_qi ?>" id="faq-q<?= $tas_qi ?>">
                <span class="tas-fq__n"><?= sprintf('%02d', $tas_qi + 1) ?></span>
                <span class="tas-fq__t"><?= e($tas_q[1]) ?></span>
                <span class="tas-fq__tag"><?= e($tas_q[0]) ?></span>
                <span class="tas-fq__ic" aria-hidden="true"><i></i><i></i></span>
              </button>
            </h3>
            <div class="tas-fq__a" id="faq-a<?= $tas_qi ?>" data-acc-p role="region" aria-labelledby="faq-q<?= $tas_qi ?>">
              <div class="tas-fq__in"><p><?= e($tas_q[2]) ?></p></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <script type="application/ld+json"><?= json_encode($tas_fq_ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
</section>
