<?php /* DRAFT COPY — review before launch */
/* Ways to work together — four engagement models. PLACEHOLDER: typical lengths — confirm before launch. */
$eng_models = [
    ['Brand sprint',        'One capability, scoped and delivered on its own.', '3–10 weeks',       'A contained problem: a foundation, an architecture decision, a brand check', 'Capability lead and specialists', 'Start small'],
    ['Brand programme',     'Inception to rollout, end to end.',                '16–24 weeks',      'Rebrands, mergers and new ventures',                                        'Engagement director with strategy, identity, systems and AI leads', 'Go end to end'],
    ['Brand office',        'Your embedded brand team after launch.',           'Ongoing · monthly', 'Governance, templates and campaigns built on the system',                  'System editor, designers and a brand strategist', 'Stay embedded'],
    ['Brand AI operations', 'The brand OS, run as a managed service.',          'Ongoing',          'High content volume across many markets',                                   'AI lead, brand reviewer and engineers', 'Run at scale'],
];
?>
<section class="band band--alt bdh-engagement" id="engagement" aria-labelledby="engagement-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--c" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Ways to work together</p>
      <h2 class="h2" id="engagement-t"><span class="g">Start where you are.</span> Scale when it works.</h2>
      <p class="lead">Four ways to engage, each with a named lead and a clear scope. Most clients start with a sprint and grow from there.</p>
    </div>

    <ol class="bdh-eng__steps" aria-hidden="true" data-rv>
      <?php foreach ($eng_models as $eng_i => $eng_m): ?>
        <li style="--i:<?= $eng_i ?>"><i></i><?= e($eng_m[5]) ?></li>
      <?php endforeach; ?>
    </ol>

    <ul class="bdh-eng__cards" data-rv-s data-rv-step="90">
      <?php foreach ($eng_models as $eng_i => $eng_m): $eng_ink = $eng_i === 1; ?>
        <li class="bdh-card bdh-card--lift bdh-eng__card<?= $eng_ink ? ' bdh-card--ink' : '' ?>">
          <p class="bdh-eng__top">
            <span class="bdh-idx"><?= str_pad((string) ($eng_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <?php if ($eng_ink): ?><span class="bdh-tag bdh-tag--blue">Most complete</span><?php endif; ?>
          </p>
          <h3 class="bdh-t bdh-t--l"><?= e($eng_m[0]) ?></h3>
          <p class="bdh-d"><?= e($eng_m[1]) ?></p>
          <dl class="bdh-eng__dl">
            <div><dt>Typical length</dt><dd><?= e($eng_m[2]) ?></dd></div>
            <div><dt>Best for</dt><dd><?= e($eng_m[3]) ?></dd></div>
            <div><dt>Team</dt><dd><?= e($eng_m[4]) ?></dd></div>
          </dl>
          <a class="tl bdh-eng__go" href="<?= xe_url('contact.php') ?>">Discuss this model <span class="i" aria-hidden="true">›</span><span class="bdh-sr">: <?= e($eng_m[0]) ?></span></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
