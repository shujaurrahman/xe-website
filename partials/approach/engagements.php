<?php /* DRAFT COPY — review before launch */
/* Engagements — how the work is bought, read straight from data/services/packages.php so this page can
   never disagree with the services catalogue or the contact page. Nothing here is restated by hand: the
   names, taglines, typical durations, pricing models and "best for" lines are the data. What this page
   adds is the one thing the catalogue does not say — which of the six stages each package covers.
   No prices anywhere: scope, typical length and pricing model only. */
$apre_stage_map = [
    'sprint'     => ['frame', 'shape'],
    'project'    => ['frame', 'shape', 'build', 'prove', 'launch'],
    'milestone'  => ['frame', 'shape', 'build', 'prove', 'launch', 'run'],
    'retainer'   => ['run'],
    'enterprise' => ['frame', 'shape', 'build', 'prove', 'launch', 'run'],
    'squad'      => ['build', 'prove', 'launch', 'run'],
];
$apre_gov = [
    'sprint'     => 'One senior lead. The gate at the end is the only one.',
    'project'    => 'A named project lead, with all four delivery gates.',
    'milestone'  => 'A gate at the end of every phase, and you pay against accepted ones.',
    'retainer'   => 'A monthly review against the measure agreed at handover.',
    'enterprise' => 'An engagement director and a steering group above the delivery gates.',
    'squad'      => 'Your ceremonies and your gates. We work to yours, not ours.',
];
$apre_names = [];
foreach ($APR['stages'] as $apre_s) { $apre_names[$apre_s['key']] = $apre_s; }
?>
<section class="band band--alt apr-engagements" id="engagements" aria-labelledby="engagements-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>How it is bought</p>
        <h2 class="h2" id="engagements-t"><span class="g">Six ways in.</span> The same six stages inside each.</h2>
      </div>
      <div>
        <p class="lead">The stages do not change with the contract. What changes is how much of them you
          buy at once, how the gates are used, and who carries the risk. Scope is fixed before we start,
          and everything we build is transferred to you.</p>
        <p class="apr-note">Typical lengths and pricing models only. We do not publish prices, because a
          price without a scope is a guess.
          <!-- PLACEHOLDER: confirm typical engagement lengths before launch --></p>
      </div>
    </div>

    <ul class="apr-eng__grid" data-rv-s data-rv-step="60">
      <?php foreach ($PACKS as $apre_key => $apre_p):
              $apre_on = $apre_stage_map[$apre_key] ?? []; ?>
        <li class="apr-eng__card">
          <p class="apr-eng__top">
            <span class="bdh-tag"><?= e($apre_p['pricing']) ?></span>
            <span class="apr-eng__dur"><?= xt_icon('clock', ['size' => 13, 'mono' => true]) ?><?= e($apre_p['duration']) ?></span>
          </p>
          <h3 class="bdh-t bdh-t--l"><?= e($apre_p['name']) ?></h3>
          <p class="bdh-d apr-eng__tag"><?= e($apre_p['tagline']) ?></p>

          <div class="apr-eng__stages">
            <p class="apr-k">Stages it covers</p>
            <ol class="apr-eng__track" aria-label="Stages covered by the <?= e($apre_p['name']) ?> engagement">
              <?php foreach ($APR['stages'] as $apre_st): $apre_has = in_array($apre_st['key'], $apre_on, true); ?>
                <li class="apr-eng__sq<?= $apre_has ? ' is-on' : '' ?>">
                  <span class="bdh-sr"><?= e($apre_st['name']) ?><?= $apre_has ? ': covered' : ': not covered' ?></span>
                  <span aria-hidden="true"><?= e($apre_st['n']) ?></span>
                </li>
              <?php endforeach; ?>
            </ol>
            <p class="apr-eng__list"><?= e(implode(' · ', array_map(fn (string $apre_k): string => $apre_names[$apre_k]['name'], $apre_on))) ?></p>
          </div>

          <ul class="apr-eng__inc">
            <?php foreach ($apre_p['includes'] as $apre_v): ?>
              <li><span class="apr-tick" aria-hidden="true">✓</span><?= e($apre_v) ?></li>
            <?php endforeach; ?>
          </ul>

          <dl class="apr-defs apr-eng__defs">
            <div><dt>Suits</dt><dd><?= e($apre_p['best']) ?></dd></div>
            <div><dt>Governance</dt><dd><?= e($apre_gov[$apre_key] ?? '') ?></dd></div>
          </dl>
        </li>
      <?php endforeach; ?>
    </ul>

    <p class="apr-eng__foot" data-rv>
      <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Talk about scope <span class="i" aria-hidden="true">›</span></a>
      <span class="apr-note">Not sure which shape fits? Frame is designed to answer that, and it is the
        cheapest thing on this page. <a class="apr-lk" href="<?= xe_url('services/') ?>">Every service and package</a>.</span>
    </p>
  </div>
</section>
