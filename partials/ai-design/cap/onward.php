<?php /* DRAFT COPY — review before launch */
/* Onward — the three sibling capabilities in the hub's card system, the paired ones first, plus the way back to the hub. */
$aid_sib = array_values(array_unique(array_merge($CAP['pairs'], array_keys($CAPS))));
$aid_sib = array_values(array_filter($aid_sib, fn ($aid_k) => $aid_k !== $AID_KEY && isset($CAPS[$aid_k])));
$aid_rows = [];
foreach ($DISC['caps'] as $aid_r) { $aid_rows[$aid_r[2]] = $aid_r; }
?>
<section class="band band--alt aid-onward" id="onward" aria-labelledby="onward-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row">
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Also in AI Design</p>
        <h2 class="h2" id="onward-t"><?= aid_h('on', 'Same studio,', 'three more ways in.') ?></h2>
      </div>
      <div>
        <p class="lead">Each shares the models, evaluation sets and approval rules built here.</p>
        <a class="tl" href="<?= e($AIH_URL) ?>">All of AI Design <span class="i" aria-hidden="true"></span></a>
      </div>
    </div>
    <div class="aid-onward__grid">
      <?php foreach (array_slice($aid_sib, 0, 3) as $aid_k): $aid_c = $CAPS[$aid_k]; $aid_r = $aid_rows[$aid_k] ?? null; if (!$aid_r) continue; ?>
        <article class="aih-card" aria-labelledby="on-<?= e($aid_k) ?>">
          <div class="aih-card__media">
            <img src="<?= e(xe_url($aid_c['img']['src'])) ?>" width="1200" height="800" alt="" loading="lazy" style="object-position:<?= e($aid_c['img']['pos'] ?? '50% 50%') ?>">
          </div>
          <div class="aih-card__body">
            <p class="aih-card__idx"><?= e($aid_c['n']) ?> / 04 · <?= e($aid_c['kicker']) ?></p>
            <h3 class="aih-card__t" id="on-<?= e($aid_k) ?>"><?= e($aid_r[0]) ?></h3>
            <p class="aih-card__d"><?= e($aid_r[1]) ?></p>
            <div class="aih-card__foot">
              <a class="tl" href="<?= e(xe_cap_url($DISC, $aid_r)) ?>">Explore <?= e($aid_r[0]) ?> <span class="i" aria-hidden="true"></span></a>
            </div>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
