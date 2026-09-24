<?php /* DRAFT COPY — review before launch */ ?>
<?php foreach ($IND as $ind_i => $ind_s):
    $ind_parts = preg_split('/(?<=\.)\s+|\s+—\s+/u', $ind_s['line'], 2);
    $ind_next  = $IND[$ind_i + 1] ?? null;
    $ind_tid   = $ind_s['id'] . '-t';
?>
<section class="band <?= $ind_i % 2 ? 'band--alt' : '' ?> ind-sec" id="<?= e($ind_s['id']) ?>" aria-labelledby="<?= e($ind_tid) ?>">
  <div class="wrap">
    <header class="ind-sec__head" data-rv>
      <p class="lbl lbl--blue"><span class="dot"></span>Sector <?= e($ind_s['n']) ?> / 06</p>
      <h2 class="h2" id="<?= e($ind_tid) ?>"><span class="g"><?= e($ind_s['name']) ?>.</span> <?= e(rtrim($ind_parts[0], '.')) ?>.</h2>
      <?php if (!empty($ind_parts[1])): ?><p class="lead"><?= e(ucfirst($ind_parts[1])) ?></p><?php endif; ?>
    </header>

    <div class="ind-sec__grid">
      <aside class="ind-sec__side">
        <figure class="bdh-img bdh-img--r43 ind-sec__img">
          <img src="<?= e($BASE) ?>assets/imgs/industries/<?= e($ind_s['img']) ?>" alt="" loading="lazy" decoding="async">
        </figure>
        <div class="ind-case">
          <p class="ind-case__lbl bdh-ro">Anonymised example</p>
          <!-- PLACEHOLDER: anonymised composite — confirm against a real engagement, and client approval, before launch -->
          <p class="ind-case__txt"><?= e($ind_s['example']) ?></p>
          <a class="tl" href="<?= xe_url('work.php') ?>?i=<?= e($ind_s['id']) ?>#index">See related work <span class="i" aria-hidden="true">›</span></a>
        </div>
      </aside>

      <div class="ind-sec__main">
        <div class="ind-sec__pair">
          <div class="ind-blk">
            <h3 class="ind-blk__t">What is shifting</h3>
            <ol class="ind-shift"><?php foreach ($ind_s['shifts'] as $ind_x): ?><li><?= e($ind_x) ?></li><?php endforeach; ?></ol>
          </div>
          <div class="ind-blk">
            <h3 class="ind-blk__t">What brands need</h3>
            <ul class="ind-need"><?php foreach ($ind_s['needs'] as $ind_x): ?><li><?= xt_icon('check') ?><span><?= e($ind_x) ?></span></li><?php endforeach; ?></ul>
          </div>
        </div>

        <div class="ind-blk">
          <h3 class="ind-blk__t">What we do</h3>
          <ul class="ind-do">
            <?php foreach ($ind_s['do'] as $ind_x): $ind_d = $ind_disc[$ind_x[0]]; ?>
            <li><a class="ind-do__a" href="<?= xe_discipline_url($ind_d) ?>"><span class="ind-do__n bdh-ro"><?= e($ind_d['n']) ?></span><span class="ind-do__d"><?= e($ind_d['name']) ?></span><span class="ind-do__x"><?= e($ind_x[1]) ?></span><span class="i" aria-hidden="true">›</span></a></li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="ind-blk ind-rules">
          <div class="ind-rules__top">
            <h3 class="ind-blk__t">Rules we build to</h3>
            <div class="ind-rules__badges"><?php foreach ($ind_s['badges'] as $ind_b) echo xt_badge($ind_b, ['variant' => 'chip']); ?></div>
          </div>
          <dl class="ind-rules__dl">
            <?php foreach ($ind_s['rules'] as $ind_r): ?><div><dt><?= e($ind_r[0]) ?></dt><dd><?= e($ind_r[1]) ?></dd></div><?php endforeach; ?>
          </dl>
          <p class="ind-rules__note sm">Frameworks we design and build to. Your legal and compliance teams keep sign-off; we make their review faster.</p>
        </div>

        <div class="ind-sec__pair">
          <div class="ind-blk">
            <h3 class="ind-blk__t">Typical programmes</h3>
            <ul class="ind-prog"><?php foreach ($ind_s['programmes'] as $ind_x): ?><li><?= e($ind_x) ?></li><?php endforeach; ?></ul>
          </div>
          <div class="ind-blk">
            <h3 class="ind-blk__t">How success is measured</h3>
            <ul class="ind-meas"><?php foreach ($ind_s['measure'] as $ind_x): ?><li><?= xt_icon('gauge') ?><span><?= e($ind_x) ?></span></li><?php endforeach; ?></ul>
          </div>
        </div>

        <nav class="ind-sec__foot" aria-label="<?= e($ind_s['name']) ?> sector navigation">
          <a class="tl" href="#explorer">Back to the explorer <span class="i" aria-hidden="true">›</span></a>
          <?php if ($ind_next): ?><a class="tl" href="#<?= e($ind_next['id']) ?>">Next: <?= e($ind_next['name']) ?> <span class="i" aria-hidden="true">›</span></a>
          <?php else: ?><a class="tl" href="#cross-industry">Across every sector <span class="i" aria-hidden="true">›</span></a><?php endif; ?>
        </nav>
      </div>
    </div>
  </div>
</section>
<?php endforeach; ?>
