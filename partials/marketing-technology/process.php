<?php /* DRAFT COPY — review before launch */
/* Process: the stepper idiom. Five phases from audit to always-on, each with what happens, what is produced and
   the gate that must be true before the next phase starts. Without JS every phase is shown in full. */
$mth_pr = [
    ['Audit',        'Wk 01–03', 'Journeys, data sources, consent records, platforms and spend reviewed. The gaps between what platforms report and what your own records say are quantified.',
        ['Martech and data audit', 'Consent gap review', 'Prioritised backlog'], 'Everyone agrees on one conversion definition and the first journey to build.'],
    ['Foundations',  'Wk 03–07', 'Server-side events, identity stitching, the consent ledger and sender authentication built once, for every module that follows.',
        ['Event tracking plan', 'Consent ledger', 'SPF · DKIM · DMARC'], 'Events arrive in the warehouse and the platform, deduplicated, with consent attached.'],
    ['First journey','Wk 06–10', 'One journey built end to end, with its holdout, guardrails and approval rules, and tested on real profiles before it goes live.',
        ['Live journey', 'Holdout set-up', 'Approval rules'], 'The journey runs for two full cycles with no consent or deliverability defects.'],
    ['Scale',        'Wk 10–16', 'Remaining journeys, decisioning where there is enough history, agents with written permissions, and the measurement layer.',
        ['Journey set', 'Decision models', 'Agent permissions'], 'Every journey reports lift against its holdout.'],
    ['Operate',      'Monthly',  'A monthly review of lift, contact quality and cost; models refitted, tests planned and the backlog re-ranked by expected value.',
        ['Performance review', 'Test log', 'Runbooks'], 'Your team can run and change it without us.'],
];
?>
<!-- PLACEHOLDER: confirm typical phase timings before launch -->
<section class="band mth-proc" id="process" aria-labelledby="process-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How we get there</p>
        <h2 class="h2" id="process-t"><span class="g">Foundations once,</span> then one journey at a time.</h2>
      </div>
      <div><p class="lead">Typically sixteen weeks from audit to an always-on programme. Each phase ends at a gate, a condition that has to be true before the next one starts, so nothing is built on top of a gap.</p></div>
    </div>

    <div class="mth-steps" data-mth-steps>
      <div class="mth-steps__rail" role="tablist" aria-label="Phases">
        <?php foreach ($mth_pr as $mth_pr_i => $mth_p): ?>
        <button type="button" class="mth-steps__tab" role="tab" id="mth-pr-t<?= $mth_pr_i ?>" aria-controls="mth-pr-p<?= $mth_pr_i ?>" aria-selected="<?= $mth_pr_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $mth_pr_i === 0 ? '0' : '-1' ?>">
          <span class="mth-steps__n"><?= sprintf('%02d', $mth_pr_i + 1) ?></span>
          <span class="mth-steps__txt"><span class="mth-steps__l"><?= e($mth_p[0]) ?></span><span class="mth-steps__w"><?= e($mth_p[1]) ?></span></span>
        </button>
        <?php endforeach; ?>
      </div>
      <?php foreach ($mth_pr as $mth_pr_i => $mth_p): ?>
      <div class="mth-steps__pane mth-proc__pane<?= $mth_pr_i === 0 ? ' is-on' : '' ?>" id="mth-pr-p<?= $mth_pr_i ?>" role="tabpanel" aria-labelledby="mth-pr-t<?= $mth_pr_i ?>">
        <div class="mth-proc__a">
          <p class="mth-proc__ph"><span class="bdh-idx">Phase <?= sprintf('%02d', $mth_pr_i + 1) ?></span><span><?= e($mth_p[1]) ?></span></p>
          <h3 class="h3"><?= e($mth_p[0]) ?></h3>
          <p class="p"><?= e($mth_p[2]) ?></p>
        </div>
        <div class="mth-proc__b">
          <p class="mth-proc__k">Produces</p>
          <ul class="mth-proc__out"><?php foreach ($mth_p[3] as $mth_pr_o): ?><li><?= xt_icon('check') ?><?= e($mth_pr_o) ?></li><?php endforeach; ?></ul>
        </div>
        <div class="mth-proc__gate">
          <p class="mth-proc__k"><?= xt_icon('flag') ?>Gate</p>
          <p><?= e($mth_p[4]) ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
