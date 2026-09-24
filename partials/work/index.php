<?php /* DRAFT COPY — review before launch */ ?>
<?php
require_once __DIR__ . '/thumbs.php';
$wrk_shown = 0;
foreach ($WRK['cases'] as $wrk_c) if ($wrk_match($wrk_c, $wrk_fd, $wrk_fi)) $wrk_shown++;
$wrk_total = count($WRK['cases']);
$wrk_cnt_d = function (string $d) use ($WRK, $wrk_match, $wrk_fi) { $n = 0; foreach ($WRK['cases'] as $c) if ($wrk_match($c, $d, $wrk_fi)) $n++; return $n; };
$wrk_cnt_i = function (string $i) use ($WRK, $wrk_match, $wrk_fd) { $n = 0; foreach ($WRK['cases'] as $c) if ($wrk_match($c, $wrk_fd, $i)) $n++; return $n; };
?>
<section class="band wrk-idx" id="programmes" aria-labelledby="programmes-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Programme index</p>
        <h2 class="h2" id="programmes-t"><span class="g">Filter by discipline or sector.</span> Every programme, told the same way.</h2></div>
      <div><p class="lead">Each entry leads with the artefact the programme left behind, then the brief as we would frame it, what we did and in which discipline, the system left behind, the deliverables and what is measured. Durations are typical ranges.</p></div>
    </div>

    <form class="wrk-filter" action="<?= xe_url('work.php') ?>#programmes" method="get" data-wrk-filter>
      <fieldset class="wrk-filter__set">
        <legend class="bdh-ro">Discipline</legend>
        <div class="wrk-filter__opts">
          <label class="wrk-opt"><input type="radio" name="d" value=""<?= $wrk_fd === '' ? ' checked' : '' ?>><span>All <b class="wrk-opt__n" data-n><?= $wrk_cnt_d('') ?></b></span></label>
          <?php foreach ($wrk_disc as $wrk_slug => $wrk_d): ?>
          <label class="wrk-opt"><input type="radio" name="d" value="<?= e($wrk_slug) ?>"<?= $wrk_fd === $wrk_slug ? ' checked' : '' ?>><span><?= e($wrk_d['short'] ?? $wrk_d['name']) ?> <b class="wrk-opt__n" data-n><?= $wrk_cnt_d($wrk_slug) ?></b></span></label>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <fieldset class="wrk-filter__set">
        <legend class="bdh-ro">Industry</legend>
        <div class="wrk-filter__opts">
          <label class="wrk-opt"><input type="radio" name="i" value=""<?= $wrk_fi === '' ? ' checked' : '' ?>><span>All <b class="wrk-opt__n" data-n><?= $wrk_cnt_i('') ?></b></span></label>
          <?php foreach ($WRK['industries'] as $wrk_k => $wrk_name): ?>
          <label class="wrk-opt"><input type="radio" name="i" value="<?= e($wrk_k) ?>"<?= $wrk_fi === $wrk_k ? ' checked' : '' ?>><span><?= e($wrk_name) ?> <b class="wrk-opt__n" data-n><?= $wrk_cnt_i($wrk_k) ?></b></span></label>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <div class="wrk-filter__foot">
        <p class="wrk-filter__status" role="status" aria-live="polite" data-wrk-status>Showing <?= $wrk_shown ?> of <?= $wrk_total ?> programmes</p>
        <button class="btn btn--ink btn--sm wrk-filter__go" type="submit">Apply filters</button>
        <a class="tl wrk-filter__reset" href="<?= xe_url('work.php') ?>#programmes" data-wrk-reset>Clear filters</a>
      </div>
    </form>

    <p class="wrk-empty" data-wrk-empty<?= $wrk_shown ? ' hidden' : '' ?>>No programme on this page matches that combination yet. <a class="tl" href="<?= xe_url('work.php') ?>#programmes" data-wrk-reset>Clear filters</a> or <a class="tl" href="<?= xe_url('contact.php') ?>">ask us about it directly</a>.</p>

    <ol class="wrk-list">
      <?php foreach ($WRK['cases'] as $wrk_n => $wrk_c): $wrk_on = $wrk_match($wrk_c, $wrk_fd, $wrk_fi); ?>
      <li class="wrk-case" id="<?= e($wrk_c['id']) ?>" data-d="<?= e(implode(' ', array_column($wrk_c['did'], 0))) ?>" data-i="<?= e($wrk_c['industry']) ?>"<?= $wrk_on ? '' : ' hidden' ?>>
        <article aria-labelledby="<?= e($wrk_c['id']) ?>-t">
          <header class="wrk-case__top">
            <span class="wrk-case__n bdh-ro"><?= sprintf('%02d', $wrk_n + 1) ?></span>
            <span class="bdh-tag"><?= e($WRK['industries'][$wrk_c['industry']]) ?></span>
            <span class="wrk-case__dur bdh-ro"><?= xt_icon('clock') ?><span class="sr">Typical duration: </span><?= e($wrk_c['duration']) ?></span>
          </header>
          <?= wrk_thumb($wrk_c['id']) ?>
          <h3 class="wrk-case__t" id="<?= e($wrk_c['id']) ?>-t"><?= e($wrk_c['title']) ?></h3>
          <p class="wrk-case__brief"><span class="bdh-ro wrk-case__bl">Brief</span><?= e($wrk_c['brief']) ?></p>
          <ul class="wrk-case__did" aria-label="What we did">
            <?php foreach ($wrk_c['did'] as $wrk_x): $wrk_d = $wrk_disc[$wrk_x[0]]; ?>
            <li><a href="<?= xe_discipline_url($wrk_d) ?>"><?= e($wrk_d['name']) ?></a><span><?= e($wrk_x[1]) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <details class="wrk-case__more">
            <summary><span>Programme notes</span><span class="wrk-case__plus" aria-hidden="true"></span></summary>
            <div class="wrk-case__body">
              <div><h4 class="wrk-case__h">The system built</h4><p><?= e($wrk_c['system']) ?></p></div>
              <div><h4 class="wrk-case__h">Deliverables</h4><ul><?php foreach ($wrk_c['deliverables'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul></div>
              <div><h4 class="wrk-case__h">Measured by</h4><ul><?php foreach ($wrk_c['measure'] as $wrk_x): ?><li><?= e($wrk_x) ?></li><?php endforeach; ?></ul></div>
              <!-- PLACEHOLDER: results pending client approval — confirm before launch -->
              <p class="wrk-pending bdh-ro">Results · available under NDA, pending client approval</p>
            </div>
          </details>
          <a class="wrk-case__link bdh-ro" href="#<?= e($wrk_c['id']) ?>" aria-label="Link to <?= e($wrk_c['title']) ?>">#<?= e($wrk_c['id']) ?></a>
        </article>
      </li>
      <?php endforeach; ?>
      <li class="wrk-next">
        <p class="bdh-ro wrk-next__n">Next</p>
        <h3 class="wrk-case__t">Your programme</h3>
        <p class="p">Tell us the brief in one line. We will reply with how we would approach it and which disciplines it needs.</p>
        <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>">Share a brief <span class="i" aria-hidden="true">›</span></a>
      </li>
    </ol>
  </div>
</section>
