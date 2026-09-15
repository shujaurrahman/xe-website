<?php /* DRAFT COPY — review before launch */
/* Plate 11 — Outcomes ($CAP['outcomes']) as margin notes on a specimen statement, then the FAQ
   ($CAP['faq']) as an indexed specimen list, A, B, C… with its own open/close (outcomes.js). */
$oc_phrases = [   // the statement, split so each outcome annotates one phrase — same order as $CAP['outcomes']
    ['People know it is yours before they read the name.', ' Teams '],
    ['ship on brand without a queue at the door,', ' and '],
    ['the touchpoint nobody has designed yet will fit', '.'],
];
?>
<section class="cbi-sec cbi-oc" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 11 · Outcomes</span><span>What changes</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="outcomes-t"><span class="g">An identity is working</span> when nobody has to defend it.</h2>
      </div>
      <p class="lead">Three things you should be able to see in the months after launch. Each is annotated in the margin, the way a specimen notes what a typeface was drawn to do.</p>
    </div>

    <div class="cbi-oc__spread">
      <p class="cbi-oc__state">
        <?php foreach ($oc_phrases as $oc_i => $oc_p): ?><span class="cbi-oc__ph" data-n="<?= $oc_i ?>"><?= e($oc_p[0]) ?><sup><?= $oc_i + 1 ?></sup></span><?= e($oc_p[1]) ?><?php endforeach; ?>
      </p>
      <ol class="cbi-oc__notes">
        <?php foreach ($CAP['outcomes'] as $oc_i => $oc_o): ?>
        <li class="cbi-oc__note cbi-oc__note--<?= $oc_i ?>" data-n="<?= $oc_i ?>">
          <span class="cbi-oc__nn" aria-hidden="true"><?= $oc_i + 1 ?></span>
          <h3 class="cbi-oc__nt"><?= e($oc_o[0]) ?></h3>
          <p class="cbi-oc__nd"><?= e($oc_o[1]) ?></p>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <div class="cbi-faq" id="faq">
      <p class="cbi-faq__h"><span class="cbi-lbl cbi-lbl--ink">Questions, indexed</span><span class="cbi-lbl"><?= count($CAP['faq']) ?> entries</span></p>
      <ol class="cbi-faq__list">
        <?php foreach ($CAP['faq'] as $oc_i => $oc_f): ?>
        <li class="cbi-faq__item">
          <h3 class="cbi-faq__q">
            <button type="button" class="cbi-faq__btn" id="faq-b<?= $oc_i ?>" aria-expanded="false" aria-controls="faq-p<?= $oc_i ?>">
              <span class="cbi-faq__idx" aria-hidden="true"><?= chr(65 + $oc_i) ?></span>
              <span class="cbi-faq__qt"><?= e($oc_f[0]) ?></span>
              <span class="cbi-faq__pm" aria-hidden="true"></span>
            </button>
          </h3>
          <div class="cbi-faq__a" id="faq-p<?= $oc_i ?>" role="region" aria-labelledby="faq-b<?= $oc_i ?>" hidden>
            <p><?= e($oc_f[1]) ?></p>
          </div>
        </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
