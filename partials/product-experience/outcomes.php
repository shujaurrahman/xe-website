<?php /* DRAFT COPY — review before launch */
/* Outcomes — the data-viz idiom (.pxh-db dumbbells): baseline → result against an agreed target, each with how
   it is measured. Every figure is illustrative; the rows are the measures we agree before work starts. */
$pxh_oc = [
    ['Task completion, key journeys', 'Unmoderated test, same tasks before and after', 64, 90, 85, '%'],
    ['Perceived usability (UMUX-Lite)', 'Two-item survey after the task, 0–100', 58, 79, 75, ''],
    ['WCAG 2.2 AA criteria met', 'Automated checks plus a manual audit', 71, 100, 100, '%'],
    ['AI answers accepted unedited', 'Logged accept, edit and reject events', 55, 82, 80, '%'],
    ['Screens built from system components', 'Code scan of component imports', 20, 85, 80, '%'],
    ['New-feature users active in week 4', 'Product analytics cohort', 18, 41, 35, '%'],
];
?>
<section class="band band--alt pxh-outcomes" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">
    <div class="bdh-grid">
      <div class="bdh-c4 pxh-outcomes__l">
        <div class="bdh-head" data-rv>
          <p class="lbl lbl--blue"><span class="dot"></span>Outcomes and how they are measured</p>
          <h2 class="h2" id="outcomes-t"><span class="g">Usable is measurable.</span> So we measure it.</h2>
          <p class="lead">Before any design work starts we agree a baseline, a target and the instrument that will measure both. The same instrument is used after release, so the comparison is honest.</p>
        </div>
        <ol class="pxh-outcomes__how">
          <li><b>Baseline first</b><span>Measured on the current product in week one.</span></li>
          <li><b>Same instrument</b><span>Identical tasks, survey or event definition afterwards.</span></li>
          <li><b>Reviewed at every gate</b><span>With your team, in your analytics tools.</span></li>
        </ol>
      </div>
      <figure class="bdh-c7 bdh-s6 pxh-outcomes__fig">
        <div class="pxh-win">
          <div class="pxh-win__bar"><span class="dots3" aria-hidden="true"><i></i><i></i><i></i></span>Outcome review · Your product<span class="sp">Illustrative</span></div>
          <div class="pxh-outcomes__body">
            <ul class="pxh-db">
              <?php foreach ($pxh_oc as $pxh_o): ?>
              <li class="pxh-db__row" style="--a:<?= $pxh_o[2] ?>%;--b:<?= $pxh_o[3] ?>%;--t:<?= $pxh_o[4] ?>%">
                <div class="pxh-db__k"><b><?= e($pxh_o[0]) ?></b><span><?= e($pxh_o[1]) ?></span></div>
                <div class="pxh-db__track" aria-hidden="true"><span class="pxh-db__seg"></span><span class="pxh-db__tgt"></span><span class="pxh-db__dot pxh-db__dot--a"></span><span class="pxh-db__dot pxh-db__dot--b"></span></div>
                <div class="pxh-db__v"><?= $pxh_o[3] . $pxh_o[5] ?><small>from <?= $pxh_o[2] . $pxh_o[5] ?></small><small>target <?= $pxh_o[4] . $pxh_o[5] ?></small></div>
              </li>
              <?php endforeach; ?>
            </ul>
            <div class="pxh-db__legend" aria-hidden="true"><span><i class="a"></i>Baseline</span><span><i class="b"></i>After release</span><span><i class="t"></i>Agreed target</span></div>
          </div>
        </div>
        <figcaption class="pxh-note">Scale 0–100 on every row. Figures are illustrative examples of the measures we set, not client results.</figcaption>
      </figure>
    </div>
  </div>
</section>
