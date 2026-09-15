<?php /* DRAFT COPY — review before launch */
/* Plate 02 — the six offer items ($CAP['offer']) as type specimens. Each sheet is set with a
   giant glyph; hover, focus (or the autoplay, until touched) flexes it from light to heavy. */
$offer_spec = [   // one per $CAP['offer'] row: [glyph, where on this page it is shown, plate label]
    ['Aa', '#construct', 'Plates 03–05'],
    ['“”', '#voice',     'Plate 06'],
    ['?!', '#voice',     'Plate 06'],
    ['~',  '#motion',    'Plate 07'],
    ['§',  '#deliver',   'Plate 10'],
    ['&',  '#process',   'Plate 09'],
];
?>
<section class="cbi-sec cbi-offer" id="offer" aria-labelledby="offer-t">
  <div class="wrap">
    <div class="cbi-head" data-rv>
      <p class="cbi-head__folio"><span>Plate 02 · What we design</span><span><?= count($CAP['offer']) ?> specimens</span></p>
      <div class="cbi-head__t">
        <h2 class="h2" id="offer-t"><?= $CAP['offer_title'] /* trusted HTML from data */ ?></h2>
      </div>
      <p class="lead"><?= e($CAP['offer_lead']) ?></p>
    </div>

    <figure class="cbi-offer__fig" data-rv>
      <!-- PLACEHOLDER: reference photo (Unsplash) — replace with own imagery before launch -->
      <div class="cbi-offer__plate">
        <div class="cbi-offer__frame">
          <img src="<?= xe_url('assets/imgs/brand/brand-identity/letterpress.jpg') ?>" alt="Close-up of metal letterpress type locked in a forme" width="1400" height="933" loading="lazy" decoding="async">
        </div>
        <span class="cbi-crop" aria-hidden="true"><i></i><i></i><i></i><i></i></span>
      </div>
      <figcaption><span>Fig. 02</span>A type case: every part made to combine with the others. That is how the six pieces below are built.</figcaption>
    </figure>

    <div class="cbi-offer__grid">
      <?php foreach ($CAP['offer'] as $offer_i => $offer_o): $offer_s = $offer_spec[$offer_i] ?? ['Aa', '#top', '']; ?>
      <article class="cbi-spec" style="--i:<?= $offer_i ?>">
        <p class="cbi-spec__top"><span>Specimen <?= sprintf('%02d', $offer_i + 1) ?></span><span><?= e($offer_o[2]) ?></span></p>
        <div class="cbi-spec__stage" aria-hidden="true">
          <span class="cbi-spec__rule cbi-spec__rule--cap"><i>Cap</i></span>
          <span class="cbi-spec__rule cbi-spec__rule--base"><i>Base</i></span>
          <span class="cbi-spec__g<?= in_array($offer_s[0], ['~', '“”'], true) ? ' cbi-spec__g--mid' : '' ?>"><?= e($offer_s[0]) ?></span>
        </div>
        <p class="cbi-spec__axis" aria-hidden="true"><span>wght</span><span class="cbi-spec__track"><i></i></span><span class="cbi-spec__val"><em>300</em><em>600</em></span></p>
        <h3 class="cbi-spec__t"><?= e($offer_o[0]) ?></h3>
        <p class="cbi-spec__d"><?= e($offer_o[1]) ?></p>
        <a class="cbi-spec__go" href="<?= e($offer_s[1]) ?>"><span class="bdh-sr"><?= e($offer_o[0]) ?>: </span>See it on <?= e($offer_s[2]) ?> <span aria-hidden="true">›</span></a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
