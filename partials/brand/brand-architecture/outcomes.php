<?php /* DRAFT COPY — review before launch */
/* 11 · Outcomes — "What gets simpler". Each $BD outcome is a structural statement with a small
   before / after line diagram: a tangled route straightens, nine thin nodes become four strong ones,
   a floating launch finds its slot. The "after" half wipes in with clip-path on entry. */
$cba_outs = $CBA_CAP['outcomes'];
$cba_diag_cap = [['Nine turns', 'Three turns'], ['9 brands, thin', '4 brands, strong'], ['No home', 'A place in the tree']];

/* Diagrams drawn in a 200 × 120 box per half; plain strokes, default aspect ratio. */
$cba_diag = [
    [ // route
        '<path class="cba-out__ln is-loose" d="M16 104 L16 70 L60 70 L60 30 L36 30 L36 14 L104 14 L104 56 L78 56 L78 92 L140 92 L140 40 L184 40"/><circle class="cba-out__end" cx="184" cy="40" r="5"/><circle class="cba-out__start" cx="16" cy="104" r="5"/>',
        '<path class="cba-out__ln" d="M16 104 L16 60 L184 60 L184 40"/><circle class="cba-out__end" cx="184" cy="40" r="5"/><circle class="cba-out__start" cx="16" cy="104" r="5"/>',
    ],
    [ // equity
        '<g class="cba-out__dots">' . implode('', array_map(fn ($cba_p) => '<circle cx="' . $cba_p[0] . '" cy="' . $cba_p[1] . '" r="7"/>', [[30, 30], [78, 22], [130, 34], [174, 24], [44, 74], [96, 64], [150, 80], [70, 104], [128, 106]])) . '</g>',
        '<path class="cba-out__ln" d="M100 24 L100 52 M36 52 L164 52 M36 52 L36 76 M79 52 L79 76 M121 52 L121 76 M164 52 L164 76"/><rect class="cba-out__big" x="88" y="8" width="24" height="24"/><g class="cba-out__dots is-strong"><circle cx="36" cy="92" r="14"/><circle cx="79" cy="92" r="14"/><circle cx="121" cy="92" r="14"/><circle cx="164" cy="92" r="14"/></g>',
    ],
    [ // launch
        '<path class="cba-out__ln" d="M60 24 L60 52 M24 52 L96 52 M24 52 L24 72 M60 52 L60 72 M96 52 L96 72"/><rect class="cba-out__big" x="50" y="10" width="20" height="20"/><g class="cba-out__dots"><circle cx="24" cy="82" r="8"/><circle cx="60" cy="82" r="8"/><circle cx="96" cy="82" r="8"/></g><circle class="cba-out__new" cx="164" cy="70" r="11"/><text class="cba-out__q" x="164" y="75">?</text>',
        '<path class="cba-out__ln" d="M100 24 L100 52 M28 52 L172 52 M28 52 L28 72 M76 52 L76 72 M124 52 L124 72 M172 52 L172 72"/><rect class="cba-out__big" x="90" y="10" width="20" height="20"/><g class="cba-out__dots"><circle cx="28" cy="82" r="8"/><circle cx="76" cy="82" r="8"/><circle cx="124" cy="82" r="8"/></g><circle class="cba-out__new is-home" cx="172" cy="82" r="11"/>',
    ],
];
?>
<section class="band band--alt cba-out" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="cba-out__grid">
      <div class="cba-out__aside">
        <div class="cba-head cba-head--stack" data-rv>
          <div class="cba-head__t">
            <p class="cba-eb"><b>A-110</b><i aria-hidden="true"></i>Outcomes</p>
            <h2 class="h2" id="outcomes-t"><span class="g">What gets simpler</span> once the structure holds.</h2>
          </div>
          <div class="cba-head__l"><p class="lead">Architecture is judged by what stops being hard: finding things, carrying brands and launching the next one.</p></div>
        </div>
        <!-- PLACEHOLDER: reference photography (Unsplash) — replace with own imagery before launch -->
        <figure class="cba-plate cba-out__photo" data-rv>
          <img src="<?= xe_url('assets/imgs/brand/brand-architecture/structure-ceiling.jpg') ?>" alt="Looking up into a steel roof structure where repeating beams meet in clear lines" width="867" height="1200" loading="lazy" decoding="async">
          <figcaption><b>Fig. 06</b>Structure, not accumulation</figcaption>
        </figure>
      </div>

      <ol class="cba-out__list">
        <?php foreach ($cba_outs as $cba_oi => $cba_oc): ?>
          <li class="cba-out__row" data-bdh-in>
            <div class="cba-out__text">
              <p class="cba-mono cba-mono--blue">S-<?= sprintf('%02d', $cba_oi + 1) ?></p>
              <h3 class="cba-out__h"><?= e($cba_oc[0]) ?></h3>
              <p class="cba-out__p"><?= e($cba_oc[1]) ?></p>
            </div>
            <div class="cba-out__diag" aria-hidden="true">
              <figure class="cba-out__half">
                <svg viewBox="0 0 200 120" focusable="false"><?= $cba_diag[$cba_oi][0] ?></svg>
                <figcaption><span>Before</span><?= e($cba_diag_cap[$cba_oi][0]) ?></figcaption>
              </figure>
              <figure class="cba-out__half is-after">
                <svg viewBox="0 0 200 120" focusable="false"><?= $cba_diag[$cba_oi][1] ?></svg>
                <figcaption><span>After</span><?= e($cba_diag_cap[$cba_oi][1]) ?></figcaption>
              </figure>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>
