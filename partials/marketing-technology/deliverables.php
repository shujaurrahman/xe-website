<?php /* DRAFT COPY — review before launch */
/* Deliverables — everything that is handed over, with the form it arrives in, straight from each
   capability's 'deliver' list in data/marketing-technology.php. A capability filter narrows the grid; with
   JavaScript off every block is printed, so nothing is hidden behind a control that never arrives. */
$del_total = 0;
foreach ($CAPS as $del_c) { $del_total += count($del_c['deliver']); }
?>
<section class="band band--alt mth-deliverables" id="deliverables" aria-labelledby="deliverables-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Deliverables</p>
        <h2 class="h2" id="deliverables-t"><span class="g"><?= $del_total ?> things</span> that end up in your hands.</h2>
      </div>
      <div>
        <p class="lead">Not slides about the work: the work. Models, configured platforms, tracking, templates, dashboards and the documentation that lets your team run it after we leave.</p>
        <p class="mth-note"><b>Built in your accounts, handed to your team.</b> Models, pipelines, prompts, eval sets and documentation live in your platforms and your repositories from the first week, so the asset stays yours if the engagement ends.</p>
      </div>
    </div>

    <div class="mth-del" data-cap="all" data-rv data-rv-d="50">
      <div class="mth-del__filter" role="group" aria-label="Filter deliverables by capability">
        <button type="button" class="mth-del__f" data-cap="all" aria-pressed="true">All capabilities <b><?= $del_total ?></b></button>
        <?php foreach ($CAPS as $del_cs => $del_c): ?>
          <button type="button" class="mth-del__f" data-cap="<?= e($del_cs) ?>" aria-pressed="false"><?= e($del_c['short']) ?> <b><?= count($del_c['deliver']) ?></b></button>
        <?php endforeach; ?>
      </div>

      <div class="mth-del__grid">
        <?php foreach ($CAPS as $del_cs => $del_c): ?>
          <div class="mth-del__block" data-cap="<?= e($del_cs) ?>">
            <p class="mth-del__bh">
              <span class="mth-del__bn"><?= e($del_c['n']) ?></span>
              <a class="mth-del__bt" href="<?= e(($MTH['cap_href'])($del_cs)) ?>"><?= e($del_c['name']) ?> <i aria-hidden="true">›</i></a>
            </p>
            <ul class="mth-rows mth-del__rows">
              <?php foreach ($del_c['deliver'] as $del_d): ?>
                <li><span><?= e($del_d[0]) ?></span><small><?= e($del_d[1]) ?></small></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
