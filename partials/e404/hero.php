<?php /* DRAFT COPY — review before launch */ ?>
<section class="band e404-hero" id="top" aria-labelledby="e404-t">
  <span class="e404-hero__dots dots" aria-hidden="true"></span>
  <div class="wrap e404-hero__in">
    <div class="e404-hero__say">
      <p class="lbl lbl--blue"><span class="dot"></span>Error 404 · Page not found</p>
      <h1 class="d2 e404-hero__h" id="e404-t"><span class="g">No page lives here.</span> The rest of the site does.</h1>
      <p class="lead e404-hero__lead">The address may be mistyped, or the page may have moved when we rebuilt the site. Nothing you did is broken — pick a destination below or search for what you came for.</p>

      <?php if ($e404_best): ?>
        <p class="e404-guess"><span class="e404-guess__k">Closest match</span>
          <a class="e404-guess__a" href="<?= e($e404_best[1]) ?>"><b><?= e($e404_best[0]) ?></b><span><?= e($e404_best[2]) ?></span><span class="i" aria-hidden="true">›</span></a></p>
      <?php endif; ?>

      <form class="e404-q" action="<?= e(xe_url('services/')) ?>#finder" method="get" role="search" aria-label="Search capabilities">
        <label class="e404-q__k" for="e404-q">Search every capability</label>
        <span class="e404-q__row">
          <span class="e404-q__w"><?= xt_icon('search') ?><input class="e404-q__in" id="e404-q" name="q" type="search" value="<?= e($e404_word) ?>" placeholder="e.g. branding, agents, SEO" autocomplete="off"></span>
          <button class="btn btn--ink" type="submit">Search <span class="i" aria-hidden="true">›</span></button>
        </span>
      </form>
    </div>

    <div class="e404-trace" aria-hidden="true">
      <p class="e404-trace__bar"><span class="e404-trace__dot"></span><span class="e404-trace__dot"></span><span class="e404-trace__dot"></span><span class="e404-trace__ttl">route · resolve</span></p>
      <ol class="e404-trace__log">
        <li><span class="e404-trace__k">GET</span><span class="e404-trace__v"><?= e($e404_path ?: '/') ?></span></li>
        <li><span class="e404-trace__k">match</span><span class="e404-trace__v">page file</span><span class="e404-trace__s">none</span></li>
        <li><span class="e404-trace__k">match</span><span class="e404-trace__v">folder index</span><span class="e404-trace__s">none</span></li>
        <li><span class="e404-trace__k">match</span><span class="e404-trace__v">closest page</span><span class="e404-trace__s<?= $e404_best ? ' is-ok' : '' ?>"><?= $e404_best ? 'found' : 'none' ?></span></li>
        <li class="e404-trace__end"><span class="e404-trace__k">status</span><span class="e404-trace__code">404</span><span class="e404-trace__v">showing destinations</span></li>
      </ol>
    </div>
    <p class="bdh-sr">A route readout: the requested address matched no page file and no folder index, so the site returned status 404 and lists destinations instead.</p>
  </div>
</section>
