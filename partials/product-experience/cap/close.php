<?php /* DRAFT COPY — review before launch */
/* The close of every capability page: the shared services catalogue (key = capability slug), the FAQ (native <details>,
   complete without JS) and the onward aid — the five capabilities as a numbered index, the two paired capabilities
   as cards, and the way back to the hub. */
$svc_key = $PXD_KEY;
include __DIR__ . '/../../services/catalogue.php';
$pxd_hf = $pxd_h('faq', ['Asked before', 'the first workshop.']);
$pxd_hn = $pxd_h('next', ['One loop, five ways in.', 'This work hands its evidence on.', 'Each capability is scoped on its own, and each passes its research, decisions and files to the next, so nothing is rediscovered.']);
$pxd_rows = [];
foreach ($DISC['caps'] as $pxd_r) { $pxd_rows[$pxd_r[2]] = $pxd_r; }
?>
<section class="band pxh-faq pxd-faq" id="faq" aria-labelledby="faq-t">
  <div class="wrap">
    <div class="bdh-grid">
      <div class="bdh-c4">
        <div class="bdh-sticky bdh-head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>Questions</p>
          <h2 class="h2" id="faq-t"><span class="g"><?= e($pxd_hf[0]) ?></span> <?= e($pxd_hf[1]) ?></h2>
          <p class="lead">Anything else goes straight to the people who would do the work.</p>
          <a class="btn btn--ink" href="<?= e(svc_contact_url([], null, $PXD_KEY)) ?>">Ask a question <span class="i" aria-hidden="true"></span></a>
        </div>
      </div>
      <div class="bdh-c7 bdh-s6 pxh-faq__list">
        <?php foreach ($CAP['faq'] as $pxd_i => $pxd_q): ?>
        <details class="pxh-faq__i"<?= $pxd_i === 0 ? ' open' : '' ?>>
          <summary><span class="pxh-faq__n">Q<?= str_pad((string) ($pxd_i + 1), 2, '0', STR_PAD_LEFT) ?></span><span class="pxh-faq__q"><?= e($pxd_q[0]) ?></span><span class="pxh-faq__p" aria-hidden="true"></span></summary>
          <div class="pxh-faq__a"><p><?= e($pxd_q[1]) ?></p></div>
        </details>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="band band--alt pxd-next" id="next" aria-labelledby="next-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Keep going</p>
        <h2 class="h2" id="next-t"><span class="g"><?= e($pxd_hn[0]) ?></span> <?= e($pxd_hn[1]) ?></h2></div>
      <div><p class="lead"><?= e($pxd_hn[2]) ?></p></div>
    </div>
    <nav class="pxd-next__idx" aria-label="<?= e($DISC['name']) ?> capabilities">
      <ol>
        <?php foreach ($CAPS as $pxd_slug => $pxd_c): $pxd_here = $pxd_slug === $PXD_KEY; ?>
        <li class="<?= $pxd_here ? 'is-here' : '' ?>">
          <a href="<?= e(xe_cap_url($DISC, $pxd_rows[$pxd_slug])) ?>"<?= $pxd_here ? ' aria-current="page"' : '' ?>>
            <span class="pxd-next__n"><?= e($pxd_c['n']) ?></span>
            <span class="pxd-next__nm"><?= e($pxd_c['name']) ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ol>
    </nav>
    <div class="pxd-next__g">
      <?php foreach ($CAP['pairs'] as $pxd_slug): $pxd_c = $CAPS[$pxd_slug] ?? null; if (!$pxd_c) continue; ?>
      <a class="pxh-card pxd-next__card bdh-zoom" href="<?= e(xe_cap_url($DISC, $pxd_rows[$pxd_slug])) ?>">
        <?php if (!empty($PXD_TS[$pxd_slug]['img'])): ?><span class="bdh-img bdh-img--r169 pxd-next__img"><img src="<?= e($BASE . 'assets/imgs/product-experience/' . $PXD_TS[$pxd_slug]['img'][0]) ?>" alt="" width="1200" height="675" loading="lazy" decoding="async"></span><?php endif; ?>
        <span class="pxh-card__top"><span class="pxh-card__idx"><?= e($pxd_c['n']) ?> · Pairs well</span><span class="pxh-card__ico"><?= xt_icon($pxd_c['icon']) ?></span></span>
        <span class="pxh-card__k"><?= e($pxd_c['kicker']) ?></span>
        <span class="pxh-card__t"><?= e($pxd_c['name']) ?></span>
        <span class="pxh-card__d"><?= e($pxd_rows[$pxd_slug][1]) ?></span>
        <span class="pxh-card__foot"><span class="tl">Explore <?= e($pxd_c['short']) ?> <span class="i" aria-hidden="true"></span></span></span>
      </a>
      <?php endforeach; ?>
      <a class="pxh-card pxh-card--ink pxd-next__card pxd-next__card--hub" href="<?= e($PXD_HUB) ?>">
        <span class="pxh-card__top"><span class="pxh-card__idx">The discipline</span><span class="pxh-card__ico"><?= xt_icon('layers') ?></span></span>
        <span class="pxh-card__k">From signal to shipped</span>
        <span class="pxh-card__t"><?= e($DISC['name']) ?></span>
        <span class="pxh-card__d">All five capabilities, the loop they share and how an engagement moves through it.</span>
        <span class="pxh-card__foot"><span class="tl">Back to the overview <span class="i" aria-hidden="true"></span></span></span>
      </a>
    </div>
  </div>
</section>
