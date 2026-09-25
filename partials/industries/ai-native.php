<?php /* DRAFT COPY — review before launch */
/* AI-native — the section that has to be specific or it is worthless. One agent per sector, named,
   with what it is allowed to touch, what it must refuse, the guardrail, the eval, the person who
   approves and what is written to the log. Every policy readout is code-built and illustrative; none
   of it is a client system. The ink band is the page's one dark stretch before the closing CTA. */
$ain_shared = [
    ['eval',     'An eval set',        'A fixed set of real cases with expected answers, run before every release.'],
    ['shield',   'Guardrails',         'Refusals, allow-listed tools and retrieval scoped to the record in session.'],
    ['approve',  'A named approver',   'A person signs anything that changes money, a contract or a published claim.'],
    ['log',      'An audit log',       'Prompt, retrieved records, model version, output and reviewer, kept with the work.'],
    ['rollback', 'A way back',         'A previous version that can be restored without a deployment.'],
];
$ain_cap = function (array $ain_s) use ($ind_disc): array {
    $ain_slug = $ain_s['caps']['ai-design'][0] ?? null;
    if (!$ain_slug) return [];
    foreach ($ind_disc['ai-design']['caps'] as $ain_c) {
        if (($ain_c[2] ?? '') === $ain_slug) return ['n' => $ind_disc['ai-design']['n'], 'name' => $ain_c[0], 'url' => xe_url('services/ai-design/' . $ain_slug . '.php')];
    }
    return [];
};
?>
<section class="band band--ink ind-ain" id="ai-native" aria-labelledby="ai-native-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>AI, per sector</p>
        <h2 class="h2" id="ai-native-t"><span class="g">“We use AI” means nothing.</span> This is what it is allowed to do.</h2>
      </div>
      <div>
        <p class="lead">One agent per category, with the same five artefacts behind every one of them. The interesting part is never the model — it is what the system may touch, what it must refuse, and who is named when it gets something wrong.</p>
      </div>
    </div>

    <ul class="ind-ain__shared" data-rv data-rv-d="60" aria-label="What every AI feature we ship carries">
      <?php foreach ($ain_shared as $ain_i => $ain_x): ?>
        <li><span class="ind-ain__si" aria-hidden="true"><?= xt_icon($ain_x[0], ['size' => 18]) ?></span><b><?= e($ain_x[1]) ?></b><span><?= e($ain_x[2]) ?></span></li>
      <?php endforeach; ?>
    </ul>

    <!-- PLACEHOLDER: every agent, guardrail, eval and log line below is an illustrative composite, not a client system — confirm before launch -->
    <ol class="ind-ain__list" data-rv-s data-rv-step="70">
      <?php foreach ($IND as $ain_s): $ain_a = $ain_s['ai']; $ain_c = $ain_cap($ain_s); ?>
        <li class="ind-ain__card">
          <p class="ind-ain__top"><span class="ind-ain__n"><?= e($ain_s['n']) ?></span><a class="ind-ain__sec" href="#<?= e($ain_s['id']) ?>"><?= e($ain_s['name']) ?></a><span class="bdh-ill">Illustrative</span></p>
          <h3 class="bdh-t bdh-t--l ind-ain__t"><?= e($ain_a['name']) ?></h3>

          <div class="ind-ain__pair">
            <p class="ind-ain__does"><span class="ind-k">What it does</span><?= e($ain_a['does']) ?></p>
            <p class="ind-ain__never"><span class="ind-k">What it never does</span><?= e($ain_a['never']) ?></p>
          </div>

          <div class="ind-ain__policy" aria-hidden="true">
            <p class="ind-ain__ph"><span class="bdh-ui__dots"><i></i><i></i><i></i></span><span>policy</span><span class="ind-ain__pk"><?= e($ain_s['id']) ?></span></p>
            <dl>
              <div><dt>guardrail</dt><dd><?= e($ain_a['guard']) ?></dd></div>
              <div><dt>evals</dt><dd><?= e($ain_a['eval']) ?></dd></div>
              <div><dt>approval</dt><dd><?= e($ain_a['approve']) ?></dd></div>
              <div><dt>audit log</dt><dd><?= e($ain_a['log']) ?></dd></div>
            </dl>
          </div>
          <p class="bdh-sr">For <?= e($ain_s['name']) ?>, the <?= e($ain_a['name']) ?> is governed by: guardrail — <?= e($ain_a['guard']) ?> Evals — <?= e($ain_a['eval']) ?> Approval — <?= e($ain_a['approve']) ?> Audit log — <?= e($ain_a['log']) ?></p>

          <?php if ($ain_c): ?>
            <p class="ind-ain__foot"><a class="ind-capl" href="<?= e($ain_c['url']) ?>"><b><?= e($ain_c['n']) ?></b><?= e($ain_c['name']) ?><i aria-hidden="true">›</i></a></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="ind-note ind-ain__note">Every agent above is a composite of the shape of work we do in that category, drawn to show the controls rather than a client system. Nothing here reports a result. <a class="tl" href="<?= xe_discipline_url($ind_disc['ai-design']) ?>">See how we design AI <span class="i" aria-hidden="true">›</span></a></p>
  </div>
</section>
