<?php /* DRAFT COPY — review before launch */
/* Standards — frameworks we build to (xt_badge), each with what it changes in the work. Not certifications. */
$aih_std = [
    ['eu-ai-act',   'Transparency duties for generated content and chatbots, and a risk classification written down for each system.'],
    ['iso42001',    'An AI management system shape for the studio: roles, impact assessment and a record of every model in use.'],
    ['nist-ai-rmf', 'Govern, map, measure, manage: the structure of our risk register and evaluation plan.'],
    ['owasp-llm',   'Guardrails tested against the LLM Top 10, starting with LLM01 prompt injection.'],
    ['wcag22',      'AA for every AI interface: streamed output announced, agents keyboard-operable, captions on generated film.'],
    ['gdpr',        'Lawful basis, minimisation and no personal data in training sets without it.'],
    ['dpdp',        'India’s Digital Personal Data Protection Act applied to prompts, logs and datasets.'],
];
?>
<section class="band band--alt aih-standards" id="standards" aria-labelledby="standards-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Frameworks we build to</p>
        <h2 class="h2" id="standards-t"><span class="g">Responsible AI</span> as working practice, with the paperwork to show it.</h2>
      </div>
      <div><p class="lead">The frameworks our delivery is built to and aligned with. They shape the evaluation plan, the guardrails and the records we hand over. They are not certifications we claim to hold.</p></div>
    </div>
    <ul class="aih-std" role="list">
      <?php foreach ($aih_std as $aih_s): $aih_sd = xt_standard($aih_s[0]); ?>
        <li class="aih-std__i">
          <?= xt_badge($aih_s[0]) ?>
          <div>
            <p class="aih-std__d"><?= e($aih_s[1]) ?></p>
          </div>
        </li>
      <?php endforeach; ?>
      <li class="aih-std__i aih-std__i--note">
        <p class="aih-std__d">Standards are applied where the work involves them. A content studio is not given a security certification it does not need.</p>
      </li>
    </ul>
  </div>
</section>
