<?php /* DRAFT COPY — review before launch */
/* Why now: four dated changes that turned martech from tooling into infrastructure. Each row: when, what changed,
   what it means in the stack, and which capability carries it. */
$mth_sh_rows = [
    ['Feb 2024', 'Mailbox providers', 'Gmail and Yahoo require bulk senders to authenticate with SPF, DKIM and DMARC, offer one-click unsubscribe (RFC 8058) and keep reported spam below 0.3%.',
        'Deliverability is now an engineering property of the sender, not a copywriting problem.', 'content-communication-infrastructure'],
    ['Mar 2024', 'Advertising signal', 'Google’s Consent Mode v2 became the condition for using measurement and personalisation features on traffic from the European Economic Area.',
        'Tags, consent banners and conversion APIs have to agree, or the optimisation models are trained on gaps.', 'ai-campaign-optimization'],
    ['Aug 2024 → Aug 2026', 'AI regulation', 'The EU AI Act entered into force in August 2024; its transparency duties for AI-generated and manipulated content apply from August 2026.',
        'Generated creative needs provenance, disclosure where required and a record of who approved it.', 'ai-creative-solutions'],
    ['Nov 2025', 'Indian data protection', 'The Digital Personal Data Protection Rules 2025 were notified, bringing the DPDP Act 2023 into operation in phases: notice, specific consent, easy withdrawal and consent managers.',
        'Consent has to be stored per purpose and enforced at the moment of sending, not at the moment a list is built.', 'ai-driven-marketing-automation'],
];
$mth_sh_names = array_column($DISC['caps'], 0, 2);
?>
<!-- PLACEHOLDER: confirm the four dates and rule summaries against the primary sources before launch -->
<section class="band band--alt mth-shift" id="shift" aria-labelledby="shift-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>What changed</p>
        <h2 class="h2" id="shift-t"><span class="g">The rules moved into the stack.</span> Marketing now runs on infrastructure.</h2>
      </div>
      <div><p class="lead">Inbox access, ad measurement, AI disclosure and consent are all decided by systems now, at the moment a message is sent. Four changes in two years made that true.</p></div>
    </div>

    <ol class="mth-shift__list" data-bdh-stagger data-bdh-in>
      <?php foreach ($mth_sh_rows as $mth_sh_i => $mth_sh): ?>
      <li class="mth-shift__row bdh-up">
        <p class="mth-shift__when"><span class="bdh-idx"><?= sprintf('%02d', $mth_sh_i + 1) ?></span><span><?= e($mth_sh[0]) ?></span></p>
        <div class="mth-shift__what">
          <p class="mth-shift__k"><?= e($mth_sh[1]) ?></p>
          <p class="mth-shift__d"><?= e($mth_sh[2]) ?></p>
        </div>
        <div class="mth-shift__so">
          <p class="mth-shift__k">What it means</p>
          <p class="mth-shift__m"><?= e($mth_sh[3]) ?></p>
          <a class="tl" href="<?= e(xe_url('services/marketing-technology.php')) ?>#<?= e($mth_sh[4]) ?>"><?= e($mth_sh_names[$mth_sh[4]] ?? '') ?> <span class="i" aria-hidden="true">›</span></a>
        </div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
