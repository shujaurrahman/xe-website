<?php /* DRAFT COPY — review before launch */
/* Shift — why the work sits ahead of the build. The curve idiom (.pxh-curve): relative cost of changing one
   decision at each stage. Values are an illustrative order of magnitude, labelled as such. */
$pxh_sh_pts = [['Signal', 1], ['Journey', 2], ['Wireframe', 4], ['Prototype', 8], ['Build', 30], ['Live', 100]];
$pxh_sh_w = 600; $pxh_sh_h = 260; $pxh_sh_pad = 20;
$pxh_sh_xy = [];
foreach ($pxh_sh_pts as $pxh_i => $pxh_p) {
    $pxh_x = $pxh_sh_pad + $pxh_i * (($pxh_sh_w - 2 * $pxh_sh_pad) / (count($pxh_sh_pts) - 1));
    $pxh_y = $pxh_sh_h - $pxh_sh_pad - (log10($pxh_p[1]) / 2) * ($pxh_sh_h - 2 * $pxh_sh_pad);
    $pxh_sh_xy[] = [round($pxh_x, 1), round($pxh_y, 1)];
}
$pxh_sh_line = implode(' ', array_map(fn ($pxh_q) => $pxh_q[0] . ',' . $pxh_q[1], $pxh_sh_xy));
$pxh_sh_claims = [
    ['Roadmaps built on opinion', 'The loudest request wins a quarter of engineering time, and nobody wrote down what would prove it wrong.'],
    ['Research that stops at a deck', 'Findings arrive after the design is signed off, so they change the next release rather than this one.'],
    ['AI features without evals', 'A demo on five prompts goes live, and the first sign of trouble is a support ticket.'],
];
?>
<section class="band pxh-shift" id="shift" aria-labelledby="shift-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Why this work comes first</p>
        <h2 class="h2" id="shift-t"><span class="g">Change is cheap on paper.</span> It is expensive in production.</h2></div>
      <div><p class="lead">Every decision gets harder to reverse as an idea gains fidelity. So we test the expensive assumptions while they still live in a sketch or a prototype, and carry the evidence forward into the build.</p></div>
    </div>
    <div class="pxh-shift__g">
      <figure class="pxh-shift__chart pxh-win" data-rv>
        <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span>Relative cost to change one decision<span class="sp">Log scale · illustrative</span></div>
        <div class="pxh-curve">
          <svg class="pxh-curve__svg" viewBox="0 0 <?= $pxh_sh_w ?> <?= $pxh_sh_h ?>" preserveAspectRatio="none" aria-hidden="true" focusable="false">
            <?php foreach ([1, 10, 100] as $pxh_g): $pxh_gy = $pxh_sh_h - $pxh_sh_pad - (log10($pxh_g) / 2) * ($pxh_sh_h - 2 * $pxh_sh_pad); ?>
            <line class="pxh-curve__grid" x1="0" x2="<?= $pxh_sh_w ?>" y1="<?= round($pxh_gy, 1) ?>" y2="<?= round($pxh_gy, 1) ?>"/>
            <?php endforeach; ?>
            <rect class="pxh-curve__zone" x="0" y="0" width="<?= $pxh_sh_xy[3][0] + 20 ?>" height="<?= $pxh_sh_h ?>"/>
            <polyline class="pxh-curve__line" points="<?= $pxh_sh_line ?>"/>
          </svg>
          <?php foreach ($pxh_sh_xy as $pxh_i => $pxh_q): ?>
          <span class="pxh-curve__pt<?= $pxh_i <= 3 ? ' is-zone' : '' ?>" style="left:<?= round($pxh_q[0] / $pxh_sh_w * 100, 2) ?>%;top:<?= round($pxh_q[1] / $pxh_sh_h * 100, 2) ?>%"><b><?= $pxh_sh_pts[$pxh_i][1] ?>×</b></span>
          <?php endforeach; ?>
          <span class="pxh-curve__tag">Where we work</span>
        </div>
        <ol class="pxh-curve__x" aria-hidden="true">
          <?php foreach ($pxh_sh_pts as $pxh_p): ?><li><?= e($pxh_p[0]) ?></li><?php endforeach; ?>
        </ol>
        <figcaption class="bdh-sr">Chart: the relative cost of changing a decision rises from 1× at the signal stage to about 2× at journey, 4× at wireframe, 8× at prototype, 30× in build and 100× once live. Illustrative order of magnitude.</figcaption>
      </figure>
      <ul class="pxh-shift__list" data-bdh-stagger>
        <?php foreach ($pxh_sh_claims as $pxh_i => $pxh_c): ?>
        <li><span class="pxh-card__idx">0<?= $pxh_i + 1 ?></span><h3 class="h3"><?= e($pxh_c[0]) ?></h3><p class="p"><?= e($pxh_c[1]) ?></p></li>
        <?php endforeach; ?>
        <li class="pxh-shift__fix"><span class="pxh-card__idx">Our default</span><p class="p">Name the assumption, test it at the lowest fidelity that can answer it, and keep the evidence attached to the decision.</p></li>
      </ul>
    </div>
  </div>
</section>
