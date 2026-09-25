<?php /* DRAFT COPY — review before launch */ ?>
<?php
/* Sector dossiers — one section, six collapsible dossiers (native <details>, so it works without JS).
   Each dossier leads with an artefact unique to that sector (partials/industries/artefacts.php), then the
   shift → need pairs, the disciplines, the rules, and how success is measured. The first dossier is open;
   assets/js/industries/sectors.js opens the dossier a #sector link points at. */
require_once __DIR__ . '/artefacts.php';
?>
<section class="band ind-dos" id="dossiers" aria-labelledby="dossiers-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Sector dossiers</p>
        <h2 class="h2" id="dossiers-t"><span class="g">Six sectors, six rulebooks.</span> Open the one you work in.</h2></div>
      <div><p class="lead">Each dossier starts with the working artefact that sector lives by — a claims trail, a KYC funnel, a season calendar — then what is shifting, what we build and the rules it is built to.</p></div>
    </div>

    <div class="ind-dos__list">
    <?php foreach ($IND as $ind_i => $ind_s):
        $ind_parts = preg_split('/(?<=\.)\s+|\s+—\s+/u', $ind_s['line'], 2);
        $ind_tid   = $ind_s['id'] . '-t';
    ?>
      <details class="ind-dos__item" id="<?= e($ind_s['id']) ?>"<?= $ind_i ? '' : ' open' ?>>
        <summary class="ind-dos__sum">
          <span class="ind-dos__n bdh-ro"><?= e($ind_s['n']) ?></span>
          <h3 class="ind-dos__t" id="<?= e($ind_tid) ?>"><?= e($ind_s['name']) ?></h3>
          <span class="ind-dos__line"><?= e(rtrim($ind_parts[0], '.')) ?>.</span>
          <span class="ind-dos__kpi bdh-ro"><span class="ind-dos__kl">Number we move</span><?= e($ind_s['kpi']) ?></span>
          <span class="ind-dos__pm" aria-hidden="true"></span>
        </summary>

        <div class="ind-dos__body">
          <div class="ind-dos__art">
            <?= ind_art($ind_s['id']) ?>
            <div class="ind-case">
              <p class="ind-case__lbl bdh-ro">Anonymised example</p>
              <!-- PLACEHOLDER: anonymised composite — confirm against a real engagement, and client approval, before launch -->
              <p class="ind-case__txt"><?= e($ind_s['example']) ?></p>
              <a class="tl" href="<?= xe_url('work.php') ?>?i=<?= e($ind_s['id']) ?>">See related work <span class="i" aria-hidden="true">›</span></a>
            </div>
          </div>

          <div class="ind-dos__main">
            <?php if (!empty($ind_parts[1])): ?><p class="ind-dos__lead"><?= e(ucfirst($ind_parts[1])) ?></p><?php endif; ?>

            <div class="ind-blk">
              <p class="ind-blk__t" aria-hidden="true"><span>What is shifting</span><span>What it demands</span></p>
              <ol class="ind-sn">
                <?php foreach ($ind_s['shifts'] as $ind_k => $ind_x): ?>
                <li><p class="ind-sn__s"><span class="sr">Shift: </span><?= e($ind_x) ?></p><p class="ind-sn__n"><span class="sr">Need: </span><?= e($ind_s['needs'][$ind_k] ?? '') ?></p></li>
                <?php endforeach; ?>
              </ol>
            </div>

            <div class="ind-blk">
              <p class="ind-blk__t">What we do</p>
              <ul class="ind-do">
                <?php foreach ($ind_s['do'] as $ind_x): $ind_d = $ind_disc[$ind_x[0]]; ?>
                <li><a class="ind-do__a" href="<?= xe_discipline_url($ind_d) ?>"><span class="ind-do__n bdh-ro"><?= e($ind_d['n']) ?></span><span class="ind-do__d"><?= e($ind_d['name']) ?></span><span class="ind-do__x"><?= e($ind_x[1]) ?></span><span class="i" aria-hidden="true">›</span></a></li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="ind-blk ind-rules">
              <div class="ind-rules__top">
                <p class="ind-blk__t">Rules we build to</p>
                <div class="ind-rules__badges"><?php foreach ($ind_s['badges'] as $ind_b) echo xt_badge($ind_b, ['variant' => 'chip']); ?></div>
              </div>
              <dl class="ind-rules__dl">
                <?php foreach ($ind_s['rules'] as $ind_r): ?><div><dt><?= e($ind_r[0]) ?></dt><dd><?= e($ind_r[1]) ?></dd></div><?php endforeach; ?>
              </dl>
              <p class="ind-rules__note sm">Frameworks we design and build to. Your legal and compliance teams keep sign-off; we make their review faster.</p>
            </div>

            <div class="ind-pm">
              <div><p class="ind-blk__t">Typical programmes</p>
                <ul class="ind-prog"><?php foreach ($ind_s['programmes'] as $ind_x): ?><li><?= e($ind_x) ?></li><?php endforeach; ?></ul></div>
              <div><p class="ind-blk__t">How success is measured</p>
                <ul class="ind-meas"><?php foreach ($ind_s['measure'] as $ind_x): ?><li><?= xt_icon('gauge') ?><span><?= e($ind_x) ?></span></li><?php endforeach; ?></ul></div>
            </div>

            <div class="ind-blk ind-dos__caps">
              <p class="ind-blk__t">Capability pages this sector usually needs</p>
              <div class="ind-capls">
                <?php foreach ($ind_s['caps'] as $ind_ds => $ind_cs): $ind_dd = $ind_disc[$ind_ds];
                    foreach ($ind_cs as $ind_cp):
                        $ind_cn = '';
                        foreach ($ind_dd['caps'] as $ind_row) { if (($ind_row[2] ?? '') === $ind_cp) $ind_cn = $ind_row[0]; } ?>
                  <a class="ind-capl" href="<?= xe_url('services/' . $ind_ds . '/' . $ind_cp . '.php') ?>"><b><?= e($ind_dd['n']) ?></b><?= e($ind_cn) ?><i aria-hidden="true">›</i></a>
                <?php endforeach; endforeach; ?>
              </div>
              <p class="ind-dos__more">
                <a class="tl" href="#systems-<?= e($ind_s['id']) ?>">What it runs on <span class="i" aria-hidden="true">›</span></a>
                <a class="tl" href="#console">Build a brief <span class="i" aria-hidden="true">›</span></a>
                <a class="tl" href="#rulebook">What applies here <span class="i" aria-hidden="true">›</span></a>
              </p>
            </div>
          </div>
        </div>
      </details>
    <?php endforeach; ?>
    </div>
  </div>
</section>
