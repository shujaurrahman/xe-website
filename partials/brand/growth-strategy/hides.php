<?php /* DRAFT COPY — review before launch */
/* 02 Where growth hides — scrollytelling. A sticky treemap of the category changes state as four
   short steps scroll past: size → your share → growth rate → whitespace. All figures illustrative.
   <!-- PLACEHOLDER: illustrative market figures, confirm before launch --> */
$cgs_hd_segs = [ // label, size £m, your share %, growth %/yr, tile [left, top, width, height] in %
    ['A', 420, 38, 2,  [0, 0, 29.8, 100]],
    ['B', 310, 24, 4,  [29.8, 0, 34.8, 63]],
    ['D', 180, 31, 3,  [29.8, 63, 34.8, 37]],
    ['C', 260, 6,  14, [64.6, 0, 35.4, 52]],
    ['E', 150, 4,  11, [64.6, 52, 35.4, 30]],
    ['F', 90,  12, 6,  [64.6, 82, 35.4, 18]],
];
$cgs_hd_steps = [
    ['Size', 'Start with how big each segment really is.', 'The category splits into six segments. The largest is where every competitor already spends, so size alone says little about where to go next.'],
    ['Share', 'Then overlay the share you already hold.', 'Your brand is strong in A and D, thin in C and E. Share shows where you are defending, not where you could grow.'],
    ['Growth', 'Add how fast each segment is moving.', 'C and E are growing three to five times faster than the category. That changes the picture more than any single number.'],
    ['Whitespace', 'Growth hides where speed meets low share.', 'Two segments are growing fast and nobody owns them yet. They become the first candidates to score, not the conclusion.'],
];
$cgs_hd_ws = ['C', 'E'];
?>
<section class="band cgs-hides" id="hides" aria-labelledby="hides-t">
  <!-- PLACEHOLDER: illustrative segment sizes, shares and growth rates, confirm before launch -->
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>02</b><i></i>Reading the ground</p>
        <h2 class="h2" id="hides-t"><span class="g">Growth rarely sits</span> where the category is loudest.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead">Every engagement begins with the same survey: four layers laid over one map of the category, until the openings show themselves.</p>
      </div>
    </div>

    <div class="cgs-hd" data-cgs-hides>
      <div class="cgs-hd__steps">
        <?php foreach ($cgs_hd_steps as $cgs_hi => $cgs_hs): ?>
          <article class="cgs-hd__step<?= $cgs_hi === 0 ? ' is-on' : '' ?>" data-cgs-step="<?= $cgs_hi + 1 ?>">
            <p class="cgs-hd__n"><span>Layer <?= sprintf('%02d', $cgs_hi + 1) ?></span><span><?= e($cgs_hs[0]) ?></span></p>
            <h3 class="cgs-hd__h"><?= e($cgs_hs[1]) ?></h3>
            <p class="cgs-hd__p"><?= e($cgs_hs[2]) ?></p>
          </article>
        <?php endforeach; ?>
      </div>

      <div class="cgs-hd__stage">
        <figure class="cgs-hd__fig" data-state="1">
          <figcaption class="cgs-hd__cap" aria-hidden="true">
            <span class="cgs-hd__title">
              <?php foreach ($cgs_hd_steps as $cgs_hi => $cgs_hs): ?><b data-s="<?= $cgs_hi + 1 ?>"><?= ['Category by segment size, £m', 'Your share of each segment', 'Annual growth by segment', 'Whitespace: fast growth, low share'][$cgs_hi] ?></b><?php endforeach; ?>
            </span>
            <span class="cgs-hd__pips"><?php for ($cgs_p = 1; $cgs_p <= 4; $cgs_p++): ?><i data-s="<?= $cgs_p ?>"></i><?php endfor; ?></span>
          </figcaption>
          <div class="cgs-tm" aria-hidden="true">
            <?php foreach ($cgs_hd_segs as $cgs_hi => $cgs_sg): [$cgs_l, $cgs_t, $cgs_w, $cgs_h] = $cgs_sg[4]; ?>
              <div class="cgs-tm__tile<?= in_array($cgs_sg[0], $cgs_hd_ws, true) ? ' is-ws' : '' ?><?= $cgs_h < 25 ? ' is-thin' : '' ?>"
                   style="left:<?= $cgs_l ?>%;top:<?= $cgs_t ?>%;width:<?= $cgs_w ?>%;height:<?= $cgs_h ?>%;--share:<?= $cgs_sg[2] / 100 ?>;--grow:<?= min(1, $cgs_sg[3] / 14) ?>;--i:<?= $cgs_hi ?>">
                <span class="cgs-tm__fill"></span>
                <span class="cgs-tm__hatch"></span>
                <span class="cgs-tm__bar"></span>
                <span class="cgs-tm__lbl">Segment <?= e($cgs_sg[0]) ?></span>
                <span class="cgs-tm__val">
                  <b data-s="1">£<?= $cgs_sg[1] ?>m</b><b data-s="2"><?= $cgs_sg[2] ?>% share</b><b data-s="3">+<?= $cgs_sg[3] ?>% / yr</b><b data-s="4"><?= in_array($cgs_sg[0], $cgs_hd_ws, true) ? 'Open · +' . $cgs_sg[3] . '%' : $cgs_sg[2] . '% held' ?></b>
                </span>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="cgs-hd__foot">
            <span class="cgs-note">Source: desk research + your sales data</span>
            <span class="cgs-illus">Illustrative</span>
          </div>
          <table class="bdh-sr">
            <caption>Illustrative category survey by segment</caption>
            <thead><tr><th>Segment</th><th>Size £m</th><th>Your share</th><th>Growth per year</th><th>Whitespace</th></tr></thead>
            <tbody>
              <?php foreach ($cgs_hd_segs as $cgs_sg): ?><tr><td><?= e($cgs_sg[0]) ?></td><td><?= $cgs_sg[1] ?></td><td><?= $cgs_sg[2] ?>%</td><td><?= $cgs_sg[3] ?>%</td><td><?= in_array($cgs_sg[0], $cgs_hd_ws, true) ? 'Yes' : 'No' ?></td></tr><?php endforeach; ?>
            </tbody>
          </table>
        </figure>
      </div>
    </div>
  </div>
</section>
