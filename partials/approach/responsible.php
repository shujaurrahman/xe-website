<?php /* DRAFT COPY — review before launch */
$apr_ra = [
  ['eye', 'Disclosed', 'You always know which work an agent touched, which model, and which version of the prompt.'],
  ['users', 'Human-accountable', 'Every agent has a named human owner. No agent approves its own work.'],
  ['lock', 'Your data stays yours', 'Client data is never used to train shared models. Retention is set per project and written down.'],
  ['scan', 'Tested before trusted', 'Evals for accuracy, bias and harmful output run before launch and on a schedule after.'],
  ['shield', 'Attack-aware', 'Red-teamed for prompt injection, data leakage and jailbreaks, mapped to OWASP LLM Top 10 and MITRE ATLAS.'],
  ['rollback', 'Reversible', 'Every automated action can be paused, rolled back or switched to manual by your team.'],
];
?>
<section class="band band--ink apr-ra" id="responsible-ai" aria-labelledby="ra-t">
  <div class="wrap">
    <div class="apr-ra__grid">
      <div class="apr-ra__head">
        <p class="lbl lbl--blue"><span class="dot"></span>Responsible AI</p>
        <h2 class="h2" id="ra-t"><span class="g">Six commitments</span> we write into the contract.</h2>
        <p class="p">Not a values page. Each commitment maps to a control on the board above and a clause you can hold us to.</p>
        <p class="apr-ra__fw">Frameworks we build to</p>
        <p class="apr-ra__badges"><?= xt_badge('iso42001', ['variant' => 'chip']) ?><?= xt_badge('nist-ai-rmf', ['variant' => 'chip']) ?><?= xt_badge('eu-ai-act', ['variant' => 'chip']) ?><?= xt_badge('owasp-llm', ['variant' => 'chip']) ?><?= xt_badge('mitre-atlas', ['variant' => 'chip']) ?></p>
      </div>
      <ol class="apr-ra__list">
        <?php foreach ($apr_ra as $apr_n => $apr_r): ?>
        <li><span class="apr-ra__i"><?= xt_icon($apr_r[0]) ?></span><div><h3 class="apr-ra__t"><?= e($apr_r[1]) ?></h3><p class="apr-ra__p"><?= e($apr_r[2]) ?></p></div></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
