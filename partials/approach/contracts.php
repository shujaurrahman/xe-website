<?php /* DRAFT COPY — review before launch */ ?>
<section class="band apr-ct" id="contracts" aria-labelledby="contracts-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Six ways to engage</p>
        <h2 class="h2" id="contracts-t"><span class="g">Same operating model,</span> six contracts.</h2></div>
      <div><p class="lead">The gates, evals and logs are identical in all six. What changes is how much is fixed up front and how long we stay.</p></div>
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
        <a class="btn btn--out btn--sm apr-pk__go" href="<?= e(svc_contact_url([], $apr_k, 'approach')) ?>">Discuss a <?= e(strtolower($apr_p['name'])) ?><span class="sr"> engagement</span> <span class="i" aria-hidden="true">›</span></a>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
