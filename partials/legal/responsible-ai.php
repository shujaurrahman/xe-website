<?php /* DRAFT COPY — review before launch */ ?>
<?php /* Responsible AI body. COUNSEL: alignment with MeitY AI advisories and the IT Rules on synthetic content labelling;
   EU AI Act obligations where we build for EU deployers (Art. 50 transparency); contractual wording of "no training". */
$lgl_rail = [
    ['clipboard-check', 'Intake',        'Purpose, risk and data classified before any model sees anything.'],
    ['lock',            'Data boundary', 'Only the minimum data, in your approved region and accounts.'],
    ['brain',           'Model choice',  'Vendor and model picked for the task, terms and residency.'],
    ['eval',            'Evaluation',    'Tested against quality and safety evals, then red-teamed.'],
    ['approve',         'Human approval','A named person signs off. Nothing ships without it.', true],
    ['log',             'Logging',       'Inputs, outputs, versions and approvals kept for audit.'],
];
?>
<?php lgl_sec('rail'); ?>
  <p>Every AI-assisted piece of client work passes the same six controls, in order.</p>
  <ol class="lgl-rail" aria-label="The six controls">
    <?php foreach ($lgl_rail as $lgl_n => $lgl_r): ?>
      <li<?= !empty($lgl_r[3]) ? ' class="is-gate"' : '' ?>><span class="lgl-rail__n"><?= sprintf('%02d', $lgl_n + 1) ?><?= xt_icon($lgl_r[0]) ?></span><h3><?= e($lgl_r[1]) ?></h3><p><?= e($lgl_r[2]) ?></p></li>
    <?php endforeach; ?>
  </ol>
</section>

<?php lgl_sec('human'); ?>
  <p>AI drafts, analyses and automates; people decide. Every AI-assisted deliverable is reviewed and approved by a named member of our team before it reaches you. In systems we build, actions with legal, financial or safety consequences require a human approval step by design, and the approver is recorded.</p>
</section>

<?php lgl_sec('data'); ?>
  <ul>
    <li>We <strong>do not use your data to train or fine-tune any model</strong> — ours or a vendor's — without your prior written consent, given for a specific purpose.</li>
    <li>We use enterprise or API terms under which the vendor does not train on inputs or outputs, and disable optional data retention where the vendor offers it.</li>
    <li>We never paste your confidential information into consumer AI tools.</li>
    <li>Where personal data is involved, the <a href="<?= e(lgl_url('privacy')) ?>">Privacy Notice</a> and our Data Processing Agreement apply.</li>
  </ul>
</section>

<?php lgl_sec('disclose'); ?>
  <p>We tell you where AI was used to produce your work. For systems your customers will use, we design clear disclosure — that they are talking to an AI, and that content is AI-generated where the law or good practice requires a label.</p>
</section>

<?php lgl_sec('evals'); ?>
  <p>Before an AI system we build goes live, we test it against task-specific evaluations for accuracy and quality, and red-team it for known risks — including prompt injection (OWASP LLM01), sensitive-data disclosure, harmful or biased output and excessive agency. Results and residual risks are documented and shared with you. Evaluations keep running after launch.</p>
</section>

<?php lgl_sec('vendors'); ?>
  <p>We choose models and vendors for the job, not by default: capability, cost, data terms, security posture, residency options and exit path. We are independent — naming a vendor on this site means we work with it, not that we are its partner. You approve the vendors used on your work.</p>
</section>

<?php lgl_sec('residency'); ?>
  <p>Where you need data to stay in India or another region, we use vendors and regions that support it, or models hosted in your own cloud account. We record where data is processed for each engagement.</p>
</section>

<?php lgl_sec('logging'); ?>
  <p>Systems we build keep an audit log of prompts, outputs, model and prompt versions, tool calls and human approvals, with retention agreed with you and access limited to those who need it. Logs are yours.</p>
</section>

<?php lgl_sec('limits'); ?>
  <p>We will not build systems intended to deceive people about whether they are dealing with AI, to impersonate real people without consent, to profile people on sensitive characteristics, for mass surveillance, or to make fully automated decisions with significant effects on people without a route to a human.</p>
</section>

<?php lgl_sec('frame'); ?>
  <p>These are frameworks we build to — not certifications we hold.</p>
  <div class="lgl-badges"><?= xt_badge('iso42001', ['variant' => 'chip']) ?><?= xt_badge('nist-ai-rmf', ['variant' => 'chip']) ?><?= xt_badge('owasp-llm', ['variant' => 'chip']) ?><?= xt_badge('eu-ai-act', ['variant' => 'chip']) ?><?= xt_badge('dpdp', ['variant' => 'chip']) ?></div>
</section>
