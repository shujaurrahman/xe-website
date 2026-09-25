<?php /* DRAFT COPY — review before launch */
/* Featured — one programme given an editorial spread: a wide plate and a portrait plate, the brief
   set large, and the artefact the work left behind as a live rollout board (featured.js ticks it
   through its checks once on entry; the shipped HTML is the finished board). */
$wrk_f = null;
foreach ($wrk_cases as $wrk_c) if (!empty($wrk_c['featured'])) { $wrk_f = $wrk_c; break; }
if ($wrk_f === null) $wrk_f = $wrk_cases[0] ?? null;
if ($wrk_f !== null):
$wrk_checks = ['Tokens', 'Type', 'Claims', 'Pack'];
$wrk_wide   = ['file' => 'f-prints.jpg', 'alt' => 'A hand laying out printed photographs in rows on a wooden table', 'w' => 1400, 'h' => 933, 'pos' => '50% 55%'];
$wrk_tall   = ['file' => 'f-crowd.jpg',  'alt' => 'A crowd of people crossing a wide street, seen from directly above',  'w' => 800,  'h' => 1200, 'pos' => '50% 50%'];
?>
<section class="band band--alt wrk-feat" id="featured" aria-labelledby="featured-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Featured programme · <?= e($WRK['industries'][$wrk_f['industry']]) ?></p>
        <h2 class="h2" id="featured-t"><span class="g"><?= e($wrk_f['title']) ?>.</span> Every market ships from the same rules.</h2>
      </div>
      <div>
        <p class="lead"><?= e($wrk_f['system']) ?></p>
        <p class="wrk-meta bdh-meta"><span><?= e($wrk_f['duration']) ?></span><span><?= e($wrk_f['scope'] ?? '') ?></span></p>
      </div>
    </div>

    <!-- PLACEHOLDER: reference photography (assets/imgs/work/CREDITS.md) — replace with this programme's own plates -->
    <div class="wrk-feat__plates" data-rv data-rv-d="60">
      <?= wrk_img($wrk_wide, [
          'ratio'    => '',
          'class'    => 'bdh-img--xl wrk-feat__wide',
          'parallax' => '0.05',
          'inner'    => '<span class="wrk-frame" aria-hidden="true"><i></i><i></i><i></i><i></i></span>'
                      . '<span class="bdh-cap-chip wrk-feat__chip"><b>What the work left behind</b>One set of tokens, nine sets of market permissions</span>',
      ]) ?>
      <?= wrk_img($wrk_tall, ['ratio' => '', 'class' => 'bdh-img--xl wrk-feat__tall',
          'inner' => '<span class="wrk-feat__tallro bdh-ro" aria-hidden="true">nine markets</span>']) ?>
    </div>

    <div class="wrk-feat__grid">
      <div class="wrk-feat__say">
        <blockquote class="wrk-brief">
          <p class="bdh-ro wrk-brief__l">The brief, as the client put it</p>
          <p class="wrk-brief__t"><?= e($wrk_f['brief']) ?></p>
        </blockquote>

        <?php if (!empty($wrk_f['call'])): ?>
        <div class="wrk-call">
          <p class="bdh-ro wrk-call__l"><?= e($wrk_f['call'][0]) ?></p>
          <p class="p"><?= e($wrk_f['call'][1]) ?></p>
        </div>
        <?php endif; ?>

        <ul class="wrk-did" aria-label="What we did, by discipline">
          <?php foreach ($wrk_f['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]] ?? null; if (!$wrk_d) continue; ?>
          <li>
            <a href="<?= xe_discipline_url($wrk_d) ?>"><span class="bdh-idx"><?= e($wrk_d['n']) ?></span><span class="wrk-did__n"><?= e($wrk_d['name']) ?><i aria-hidden="true">›</i></span></a>
            <span class="wrk-did__r"><?= e($wrk_x[1]) ?></span>
          </li>
          <?php endforeach; ?>
        </ul>

        <!-- PLACEHOLDER: outcome figures pending client approval — confirm before launch -->
        <p class="wrk-pending bdh-ro"><?= xt_icon('lock', ['size' => 14]) ?>Results · shared under NDA, pending client approval</p>

        <?php if ($wrk_has($wrk_f['slug'])): ?>
        <a class="btn btn--ink wrk-feat__go" href="<?= xe_url('work/' . $wrk_f['slug'] . '.php') ?>">Read the full case <span class="i" aria-hidden="true">›</span></a>
        <?php endif; ?>
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
              <thead><tr><th scope="col">Market</th><?php foreach ($wrk_checks as $wrk_h): ?><th scope="col"><?= e($wrk_h) ?></th><?php endforeach; ?><th scope="col">Status</th></tr></thead>
              <tbody>
              <?php for ($wrk_m = 1; $wrk_m <= 9; $wrk_m++): $wrk_last = $wrk_m === 9; ?>
                <tr style="--r:<?= $wrk_m ?>"><th scope="row" class="bdh-ro">M<?= wrk_n($wrk_m) ?></th>
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
        <p class="wrk-ill-note"><span class="bdh-ill">Illustrative</span> A working sketch of the artefact, not a client screen.</p>
      </div>
    </div>

  </div>
</section>
<?php endif; ?>
