<?php /* DRAFT COPY — review before launch */
/* FAQ — native <details>, so every answer opens without JavaScript. Two hub questions, then the first question
   of each capability (data 'faq'), each linking to the capability it belongs to. */
$pxh_fq = [
    ['Do we have to start with research?', 'No. Most engagements enter where the product already is: a strategy question, a design that needs testing, a front end to build or a system to consolidate. We check which assumptions are still open and test only the ones that matter to the next decision.', null],
    ['Will you work with our designers and engineers?', 'Yes, and we plan for it. We work in your Figma, your repositories and your ticketing, pair with your people, and hand over the working files and the decision record so the team can carry on without us.', null],
];
foreach ($CAPS as $pxh_slug => $pxh_cap) {
    if (!empty($pxh_cap['faq'][0])) $pxh_fq[] = [$pxh_cap['faq'][0][0], $pxh_cap['faq'][0][1], [$pxh_slug, $pxh_cap['name'], array_values(array_filter($DISC['caps'], fn ($pxh_dc) => $pxh_dc[2] === $pxh_slug))[0] ?? [$pxh_cap['name'], '', $pxh_slug]]];
}
?>
<section class="band pxh-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-grid">
      <div class="bdh-c4">
        <div class="bdh-sticky bdh-head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
          <h2 class="h2" id="faq-t"><span class="g">Asked before</span> the first workshop.</h2>
          <p class="lead">Anything else goes to the team that would do the work.</p>
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, 'product-experience')) ?>">Ask a question <span class="i" aria-hidden="true"></span></a>
        </div>
      </div>
      <div class="bdh-c7 bdh-s6 pxh-faq__list">
        <?php foreach ($pxh_fq as $pxh_i => $pxh_q): ?>
        <details class="pxh-faq__i"<?= $pxh_i === 0 ? ' open' : '' ?>>
          <summary><span class="pxh-faq__n">Q<?= str_pad((string) ($pxh_i + 1), 2, '0', STR_PAD_LEFT) ?></span><span class="pxh-faq__q"><?= e($pxh_q[0]) ?></span><span class="pxh-faq__p" aria-hidden="true"></span></summary>
          <div class="pxh-faq__a">
            <p><?= e($pxh_q[1]) ?></p>
            <?php if ($pxh_q[2]): ?><a class="tl" href="<?= e(xe_cap_url($DISC, $pxh_q[2][2])) ?>"><?= e($pxh_q[2][1]) ?> <span class="i" aria-hidden="true"></span></a><?php endif; ?>
          </div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
