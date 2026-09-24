<?php /* DRAFT COPY — review before launch */ ?>
<?php
$wrk_f = null;
foreach ($WRK['cases'] as $wrk_c) if (!empty($wrk_c['featured'])) { $wrk_f = $wrk_c; break; }
$wrk_checks = ['Tokens', 'Type', 'Claims', 'Pack'];
?>
<section class="band band--alt wrk-feat" id="featured" aria-labelledby="featured-t">
  <div class="wrap">
    <div class="wrk-feat__grid">
      <div class="wrk-feat__say">
        <p class="lbl lbl--blue"><span class="dot"></span>Featured · <?= e($WRK['industries'][$wrk_f['industry']]) ?></p>
        <h2 class="h2" id="featured-t"><span class="g"><?= e($wrk_f['title']) ?>.</span> Every market ships from the same rules.</h2>
        <div class="wrk-brief"><p class="bdh-ro wrk-brief__l">The brief, as we would write it · illustrative</p><p class="wrk-brief__t"><?= e($wrk_f['brief']) ?></p></div>
        <p class="p"><?= e($wrk_f['system']) ?></p>
        <ul class="wrk-feat__did">
          <?php foreach ($wrk_f['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]]; ?>
          <li><a href="<?= xe_discipline_url($wrk_d) ?>"><span class="bdh-ro"><?= e($wrk_d['n']) ?></span><?= e($wrk_d['name']) ?></a><span><?= e($wrk_x[1]) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <!-- PLACEHOLDER: outcome figures pending client approval — confirm before launch -->
        <p class="wrk-pending bdh-ro">Results · shared under NDA, pending client approval</p>
        <a class="tl" href="#<?= e($wrk_f['id']) ?>">Full programme notes <span class="i" aria-hidden="true">›</span></a>
      </div>

      <div class="wrk-board-wrap">
        <div class="wrk-board bdh-ui" aria-hidden="true" data-wrk-board>
          <div class="wrk-board__bar">
            <span class="bdh-ro"><span class="bdh-pulse"></span> Your brand · system v4 · rollout</span>
            <span class="bdh-ro wrk-board__sum"><span data-wrk-done>35</span>/36 checks</span>
          </div>
          <div class="wrk-board__tok">
            <span class="wrk-sw wrk-sw--ink"></span><span class="wrk-sw wrk-sw--blue"></span><span class="wrk-sw wrk-sw--wash"></span><span class="wrk-sw wrk-sw--paper"></span>
            <span class="bdh-ro">tokens · locked</span>
          </div>
          <table class="wrk-board__t">
            <thead><tr><th>Market</th><?php foreach ($wrk_checks as $wrk_h): ?><th><?= $wrk_h ?></th><?php endforeach; ?><th>Status</th></tr></thead>
            <tbody>
            <?php for ($wrk_m = 1; $wrk_m <= 9; $wrk_m++): $wrk_last = $wrk_m === 9; ?>
              <tr style="--r:<?= $wrk_m ?>"><td class="bdh-ro">M<?= sprintf('%02d', $wrk_m) ?></td>
                <?php foreach ($wrk_checks as $wrk_ci => $wrk_h): $wrk_flag = $wrk_last && $wrk_h === 'Claims'; ?>
                <td><span class="wrk-ck<?= $wrk_flag ? ' wrk-ck--flag' : '' ?>" style="--c:<?= $wrk_ci ?>"><?= $wrk_flag ? '!' : '✓' ?></span></td>
                <?php endforeach; ?>
                <td><span class="wrk-st<?= $wrk_last ? ' wrk-st--rev' : '' ?>"><?= $wrk_last ? 'Review<span class="wrk-st__x"> · human</span>' : 'Live' ?></span></td></tr>
            <?php endfor; ?>
            </tbody>
          </table>
          <p class="wrk-board__log bdh-ro">brand-check › M09 claim “clinically proven” needs substantiation → routed to medical-legal · logged</p>
        </div>
        <p class="bdh-sr">Illustration: a rollout board for one brand system across nine markets. Each market is checked for tokens, type, claims and pack; 35 of 36 checks pass, and one unsupported claim in market nine is routed to a person for medical-legal review and logged.</p>
      </div>
    </div>
  </div>
</section>
