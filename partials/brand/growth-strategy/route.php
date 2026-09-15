<?php /* DRAFT COPY — review before launch */
/* 07 Process — a field route. One horizontal route line with a stop per $CAP process step, a week ruler
   under it, artefacts as small tags and a documentary photo at each stop. Scrolls sideways on phones.
   route.js draws the line to each stop as it comes into view. */
$cgs_rt_photos = [ // file, w, h — PLACEHOLDER: reference photography (Unsplash), replace before launch
    ['interview-setup.jpg', 1100, 733], ['research-notes.jpg', 1100, 619], ['whiteboard-decide.jpg', 1100, 734],
];
$cgs_rt_who = [ // DRAFT COPY — per stop: what agents do, what people decide
    ['Agents transcribe and tag every interview; desk research is summarised with sources.', 'People run the conversations and choose who to talk to.'],
    ['Agents score each segment and stress-test weightings.', 'The strategist sets the weights and signs the shortlist.'],
    ['Agents draft move cards and measure definitions from the thesis.', 'Leadership orders the moves and signs the roadmap.'],
];
$cgs_rt_steps = $CAP['process']['steps'];
$cgs_rt_weeks = 6;
?>
<section class="band cgs-route" id="route" aria-labelledby="route-t">
  <div class="wrap">
    <div class="cgs-head" data-rv>
      <div class="cgs-head__t">
        <p class="cgs-eye"><b>07</b><i></i>How the engagement runs</p>
        <h2 class="h2" id="route-t"><?php /* DRAFT COPY */ ?><span class="g">Read the ground,</span> rank it, then route it.</h2>
      </div>
      <div class="cgs-head__l">
        <p class="lead"><?= e($CAP['process']['lead']) ?></p>
        <p class="cgs-note cgs-route__hint">Scroll the route sideways</p>
      </div>
    </div>
  </div>

  <!-- PLACEHOLDER: reference photography (Unsplash) at each stop, replace before launch -->
  <div class="cgs-rt bdh-scroll-x" data-cgs-route tabindex="0" aria-label="Engagement route, <?= count($cgs_rt_steps) ?> stops over <?= $cgs_rt_weeks ?> weeks; scroll sideways">
    <div class="cgs-rt__track">
      <div class="cgs-rt__ruler" aria-hidden="true">
        <?php for ($cgs_wk = 1; $cgs_wk <= $cgs_rt_weeks; $cgs_wk++): ?>
          <span class="cgs-rt__wk"><b>Wk <?= sprintf('%02d', $cgs_wk) ?></b></span>
        <?php endfor; ?>
      </div>
      <div class="cgs-rt__line" aria-hidden="true"><i data-cgs-rline></i></div>

      <ol class="cgs-rt__stops">
        <?php foreach ($cgs_rt_steps as $cgs_ri => $cgs_st): $cgs_ph = $cgs_rt_photos[$cgs_ri] ?? $cgs_rt_photos[0]; ?>
          <li class="cgs-rt__stop" data-cgs-stop style="--i:<?= $cgs_ri ?>">
            <span class="cgs-rt__pin" aria-hidden="true"><i></i></span>
            <p class="cgs-rt__at"><span>Stop <?= sprintf('%02d', $cgs_ri + 1) ?></span><span><?= e($cgs_st[1]) ?></span></p>
            <h3 class="cgs-rt__h"><?= e($cgs_st[0]) ?></h3>
            <figure class="cgs-photo cgs-rt__ph">
              <img src="<?= xe_url('assets/imgs/brand/growth-strategy/' . $cgs_ph[0]) ?>" alt="" width="<?= $cgs_ph[1] ?>" height="<?= $cgs_ph[2] ?>" loading="lazy" decoding="async">
            </figure>
            <p class="cgs-rt__p"><?= e($cgs_st[2]) ?></p>
            <dl class="cgs-rt__who">
              <div><dt>Agents</dt><dd><?= e($cgs_rt_who[$cgs_ri][0] ?? '') ?></dd></div>
              <div><dt>People</dt><dd><?= e($cgs_rt_who[$cgs_ri][1] ?? '') ?></dd></div>
            </dl>
            <p class="cgs-rt__k">Leaves with</p>
            <ul class="cgs-rt__tags">
              <?php foreach ($cgs_st[3] as $cgs_art): ?><li><?= e($cgs_art) ?></li><?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>
        <li class="cgs-rt__end" aria-hidden="true"><span class="cgs-rt__flag"></span><span class="cgs-note">Roadmap signed</span></li>
      </ol>
    </div>
  </div>
</section>
