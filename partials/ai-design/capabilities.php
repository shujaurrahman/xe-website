<?php /* DRAFT COPY — review before launch */
/* Capabilities — the card system every AI Design page reuses (.aih-card). Stable id = capability slug.
   Links use xe_cap_url(), which falls back to the hub while a capability page does not exist. */
$aih_cap_alt = [
    'ai-application-design'  => 'Over-ear headphones and a microphone in front of an open laptop',
    'ai-content-studio'      => 'An editor works on footage at a monitor in a darkened edit suite',
    'brand-ai-tools'         => 'Hands sort a spread of instant photographs on a wooden table',
    'ai-strategy-consulting' => 'Two people arrange sticky notes on a glass wall during a workshop',
];
?>
<section class="band band--alt aih-capabilities" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Four capabilities</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Four ways in.</span> One studio behind them.</h2>
      </div>
      <div><p class="lead">Start with any one. Each is scoped on its own and built to share the same models, evaluation sets and approval rules as the other three.</p></div>
    </div>

    <div class="aih-cards">
      <?php foreach ($DISC['caps'] as $aih_cp):
        $aih_slug = $aih_cp[2];
        $aih_c    = $CAPS[$aih_slug] ?? null;
        if (!$aih_c) continue;
        $aih_href = xe_cap_url($DISC, $aih_cp); ?>
        <article class="aih-card" id="<?= e($aih_slug) ?>" aria-labelledby="<?= e($aih_slug) ?>-t">
          <div class="aih-card__media">
            <img src="<?= e(xe_url($aih_c['img']['src'])) ?>" width="1200" height="800" alt="<?= e($aih_cap_alt[$aih_slug] ?? '') ?>" loading="lazy">
          </div>
          <div class="aih-card__body">
            <p class="aih-card__idx"><?= e($aih_c['n']) ?> / 04 · <?= e($aih_c['kicker']) ?></p>
            <h3 class="aih-card__t" id="<?= e($aih_slug) ?>-t"><?= e($aih_cp[0]) ?></h3>
            <p class="aih-card__d"><?= e($aih_cp[1]) ?></p>
            <ul class="aih-list" aria-label="What it covers">
              <?php foreach (array_slice($aih_c['offer'], 0, 3) as $aih_o): ?>
                <li><span><?= e($aih_o[0]) ?></span></li>
              <?php endforeach; ?>
            </ul>
            <div class="aih-card__foot">
              <!-- PLACEHOLDER: confirm typical timeframe before launch -->
              <p class="aih-cap__len"><span>Typical</span> <?= e($aih_c['meta'][0]) ?></p>
              <a class="tl" href="<?= e($aih_href) ?>">Explore <?= e($aih_cp[0]) ?> <span class="i" aria-hidden="true"></span></a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
