<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Which delivery stages (the #delivery section above) each contract usually spans — the part home s25 does not show. */
$apr_stg = ['Discover', 'Define', 'Design', 'Build', 'Run', 'Improve'];
$apr_cov = [
  'sprint'     => [[0, 1], 'Ends at the “Problem framed” or “Scope signed” gate, with a decision in hand.'],
  'project'    => [[1, 2, 3], 'Scope signed up front; ends when the release gate is approved.'],
  'milestone'  => [[1, 2, 3, 4], 'You approve, and pay for, one gate at a time; stop after any of them.'],
  'retainer'   => [[4, 5], 'Picks up after launch: the run and improve gates, reviewed quarterly.'],
  'enterprise' => [[0, 1, 2, 3, 4, 5], 'Every gate, per workstream, under a steering group and SLAs.'],
  'squad'      => [[2, 3, 4, 5], 'Works inside your cadence; your leads own each gate, our team meets it.'],
];
?>
<section class="band apr-ct" id="contracts" aria-labelledby="contracts-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Six ways to engage</p>
        <h2 class="h2" id="contracts-t"><span class="g">Same operating model,</span> six contracts.</h2></div>
      <div><p class="lead">The gates, evals and logs are identical in all six. What changes is which stages of delivery the contract spans, how much is fixed up front and how long we stay.</p></div>
    </div>
    <div class="apr-ct__axis" aria-hidden="true"><span>Fixed scope</span><i></i><span>Standing capacity</span></div>
    <ol class="apr-ct__list">
      <?php $apr_n = 0; foreach ($apr_pk as $apr_k => $apr_p): $apr_n++; ?>
      <li class="apr-pk">
        <span class="apr-pk__n">0<?= $apr_n ?></span>
        <div class="apr-pk__main"><h3 class="apr-pk__t"><?= e($apr_p['name']) ?></h3><p class="apr-pk__d"><?= e($apr_p['tagline']) ?></p></div>
        <dl class="apr-pk__meta">
          <!-- PLACEHOLDER: confirm typical durations before launch -->
          <div><dt>Typical length</dt><dd><?= e($apr_p['duration']) ?></dd></div>
          <div><dt>Pricing model</dt><dd><?= e($apr_p['pricing']) ?></dd></div>
          <div class="apr-pk__best"><dt>Best for</dt><dd><?= e($apr_p['best']) ?></dd></div>
        </dl>
        <?php if (isset($apr_cov[$apr_k])): ?>
        <div class="apr-pk__cov">
          <p class="apr-pk__cl">Stages covered</p>
          <ol class="apr-pk__stg" aria-label="Delivery stages covered by a <?= e(strtolower($apr_p['name'])) ?>">
            <?php foreach ($apr_stg as $apr_si => $apr_sn): $apr_in = in_array($apr_si, $apr_cov[$apr_k][0], true); ?>
            <li class="<?= $apr_in ? 'is-in' : '' ?>"><?= e($apr_sn) ?><span class="sr"><?= $apr_in ? ' — covered' : ' — not covered' ?></span></li>
            <?php endforeach; ?>
          </ol>
          <p class="apr-pk__ex"><?= e($apr_cov[$apr_k][1]) ?></p>
        </div>
        <?php endif; ?>
        <?php $apr_art = preg_match('/^[aeiou]/i', $apr_p['name']) ? 'an' : 'a'; ?>
        <a class="btn btn--out btn--sm apr-pk__go" href="<?= e(svc_contact_url([], $apr_k, 'approach')) ?>">Discuss <?= $apr_art ?> <?= e(strtolower($apr_p['name'])) ?><span class="sr"> engagement</span> <span class="i" aria-hidden="true">›</span></a>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
