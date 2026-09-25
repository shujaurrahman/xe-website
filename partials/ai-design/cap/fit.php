<?php /* DRAFT COPY — review before launch */
/* Where it sits — the hub's diagram idiom (.aih-flow nodes joined by edge connectors that stop at the box edges).
   On Brand AI Tools this is the explicit difference from Brand Design's capability of the same name. */
$aid_fit  = $AID_X['fit'];
$aid_link = null;
if (!empty($aid_fit['link'])) {
    foreach ($SITE['disciplines'] as $aid_d) {
        if ($aid_d['slug'] !== $aid_fit['link'][0]) continue;
        foreach ($aid_d['caps'] as $aid_r) { if ($aid_r[2] === $aid_fit['link'][1]) $aid_link = xe_cap_url($aid_d, $aid_r); }
    }
}
?>
<section class="band band--alt aid-fit" id="fit" aria-labelledby="fit-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span><?= e($aid_fit['lbl']) ?></p>
        <h2 class="h2" id="fit-t"><?= $aid_fit['title'] ?></h2>
      </div>
      <div><p class="lead"><?= e($aid_fit['lead']) ?></p></div>
    </div>
    <ol class="aih-flow aid-flow" role="list">
      <?php foreach ($aid_fit['nodes'] as $aid_i => $aid_n): ?>
        <?php if ($aid_i): ?><li class="aih-edge<?= $aid_n[3] || $aid_fit['nodes'][$aid_i - 1][3] ? ' aih-edge--blue' : '' ?>" aria-hidden="true"></li><?php endif; ?>
        <li class="aih-node<?= $aid_n[3] ? ' aih-node--blue' : '' ?>"<?= $aid_n[3] ? ' aria-current="page"' : '' ?>>
          <span class="aih-node__k"><?= e($aid_n[0]) ?><?= $aid_n[3] ? ' · this page' : '' ?></span>
          <span class="aih-node__t"><?= e($aid_n[1]) ?></span>
          <p class="aih-node__d"><?= e($aid_n[2]) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
    <div class="aid-fit__note">
      <p><?= e($aid_fit['note']) ?></p>
      <?php if ($aid_link): ?><a class="tl" href="<?= e($aid_link) ?>"><?= e($aid_fit['link'][2]) ?> <span class="i" aria-hidden="true"></span></a><?php endif; ?>
    </div>
  </div>
</section>
