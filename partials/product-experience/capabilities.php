<?php /* DRAFT COPY — review before launch */
/* Capabilities — the index of the five, and the anchor targets for every capability link on the page.
   The five capability subpages do not exist yet, so each row carries id="<capability-slug>" and every
   link elsewhere on the hub points at it. Names and the one-line descriptions are the approved copy in
   data/site.php; the lead, the meta and the deliverables come from data/product-experience.php.
   The "six services" link jumps to #offer and, when JavaScript is on, opens that capability's tab. */
$cap_rows = [];
foreach (array_values($CAPS) as $cap_i => $cap_c) {
    $cap_rows[] = [
        'c'    => $cap_c,
        'line' => $DISC['caps'][$cap_i][1],            // the approved one-liner from data/site.php
        'del'  => array_slice($cap_c['deliver'], 0, 3),
        'i'    => $cap_i,
    ];
}
?>
<section class="band pxh-caps" id="capabilities" aria-labelledby="capabilities-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The capabilities</p>
        <h2 class="h2" id="capabilities-t"><span class="g">Five capabilities,</span> in the order a product needs them.</h2>
      </div>
      <div>
        <p class="lead">Each one can be bought on its own. Most work runs two or three of them together, because the decision, the design and the system it lands in are the same problem seen from different distances.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: typical lengths below are ranges from data/product-experience.php — confirm before launch -->
    <ol class="pxh-caps__list">
      <?php foreach ($cap_rows as $cap_r): $cap_c = $cap_r['c']; ?>
        <li class="pxh-caps__row" id="<?= e($cap_c['slug']) ?>" data-rv data-rv-d="<?= $cap_r['i'] * 40 ?>">
          <div class="pxh-caps__id">
            <span class="pxh-caps__n"><?= e($cap_c['n']) ?></span>
            <span class="pxh-caps__ico" aria-hidden="true"><?= xt_icon($cap_c['icon'], ['size' => 22]) ?></span>
            <p class="pxh-k pxh-caps__kick"><?= e($cap_c['kicker']) ?></p>
            <h3 class="pxh-caps__t"><?= e($cap_c['name']) ?></h3>
            <p class="pxh-caps__line"><?= e($cap_r['line']) ?></p>
            <p class="pxh-caps__oc">
              <span class="pxh-k">What changes</span>
              <b><?= e($cap_c['outcomes'][0][0]) ?></b>
              <span><?= e($cap_c['outcomes'][0][1]) ?></span>
            </p>
          </div>

          <div class="pxh-caps__body">
            <p class="pxh-caps__lead"><?= e($cap_c['lead']) ?></p>
            <div class="pxh-caps__del">
              <p class="pxh-k">Headline outputs</p>
              <ul>
                <?php foreach ($cap_r['del'] as $cap_d): ?>
                  <li><b><?= e($cap_d[0]) ?></b><small><?= e($cap_d[1]) ?></small></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

          <div class="pxh-caps__side">
            <dl class="pxh-caps__meta">
              <?php foreach ($cap_c['meta'] as $cap_mi => $cap_m): ?>
                <div><dt><?= e($cap_c['meta_k'][$cap_mi]) ?></dt><dd><?= e($cap_m) ?></dd></div>
              <?php endforeach; ?>
            </dl>
            <div class="pxh-caps__act">
              <a class="btn btn--out btn--sm" href="<?= e(svc_contact_url([], null, 'product-experience')) ?>"><?= e($cap_c['cta']) ?> <span class="i" aria-hidden="true">›</span></a>
              <a class="tl pxh-caps__tl" href="#offer" data-offer="<?= $cap_r['i'] ?>">The six services it covers <span class="i" aria-hidden="true">›</span></a>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <p class="pxh-note pxh-caps__note"><b>One boundary worth stating.</b> Brand Design owns brand strategy, identity and the brand system. Technology &amp; Intelligence engineers the models, platforms and infrastructure. This discipline is the strategy and design in between: what to build, whether it works for the people who have to use it, and the system it is assembled from.</p>
  </div>
</section>
