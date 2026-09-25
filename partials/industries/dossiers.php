<?php /* DRAFT COPY — review before launch */
/* Dossiers — the six category briefs, in depth. One brief per category, all in the shipped HTML, each
   with the same five parts so two can be compared line for line: what the category is under, what is
   different here, what we do across the six disciplines, what binds the work, and how it is measured.
   The left column is sticky on wide screens and the detail scrolls past it. Capability links resolve
   through $IND_URL, which falls back to the discipline hub when a capability subpage does not exist,
   so nothing here can point at a missing file. No JavaScript: this section is finished HTML. */

/* discipline slug => ['n','name','short', caps => [capability slug => label]] */
$ind_dmap = [];
foreach ($SITE['disciplines'] as $ind_row) {
    $ind_caps = [];
    foreach ($ind_row['caps'] as $ind_cap) {
        if (!empty($ind_cap[2])) $ind_caps[$ind_cap[2]] = $ind_cap[0];
    }
    $ind_dmap[$ind_row['slug']] = ['n' => $ind_row['n'], 'name' => $ind_row['name'], 'short' => $ind_row['short'], 'caps' => $ind_caps];
}
$ind_parts = ['What is different here', 'What we do', 'What binds the work', 'How it is measured'];
?>
<section class="band ind-dossiers" id="dossiers" aria-labelledby="dossiers-t">
  <div class="wrap">
    <div class="ind-head ind-dos__head" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>The briefs</p>
        <h2 class="h2" id="dossiers-t"><span class="g">Six briefs,</span> written the same way on purpose.</h2>
      </div>
      <div>
        <p class="lead">Each brief carries the pressure the category is under, what is genuinely different about it, what we do there across all six disciplines, the instruments that shape the work, and the measures we would agree before starting.</p>
        <ol class="ind-dos__key" aria-label="What every brief contains">
          <?php foreach ($ind_parts as $ind_pi => $ind_p): ?>
            <li><span class="ind-num"><?= str_pad((string) ($ind_pi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($ind_p) ?></li>
          <?php endforeach; ?>
        </ol>
      </div>
    </div>

    <div class="ind-dos__stack">
      <?php $ind_last = count($IND_SET); $ind_pos = 0; foreach ($IND_SET as $ind_c): $ind_pos++; ?>
        <article class="ind-dos" id="<?= e($ind_c['slug']) ?>" aria-labelledby="dos-<?= e($ind_c['slug']) ?>-t">
          <div class="ind-dos__rule" aria-hidden="true"></div>

          <div class="ind-dos__side">
            <div class="bdh-sticky ind-dos__sticky">
              <p class="ind-dos__pos"><span><?= e($ind_c['n']) ?></span> / <?= str_pad((string) $ind_last, 2, '0', STR_PAD_LEFT) ?></p>
              <span class="ind-dos__ico" aria-hidden="true"><?= xt_icon($ind_c['icon'], ['size' => 22]) ?></span>
              <h3 class="ind-dos__t" id="dos-<?= e($ind_c['slug']) ?>-t"><?= e($ind_c['name']) ?></h3>
              <p class="ind-dos__kick"><?= e($ind_c['kicker']) ?></p>
              <p class="ind-dos__pressure"><?= e($ind_c['pressure']) ?></p>
              <div class="ind-dos__teams">
                <p class="ind-k">Usually alongside</p>
                <ul class="ind-chips" role="list">
                  <?php foreach ($ind_c['teams'] as $ind_tm): ?><li class="ind-chip"><?= e($ind_tm) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>

          <div class="ind-dos__body">

            <div class="ind-dos__block">
              <p class="ind-k ind-dos__bk"><span class="ind-num">01</span>What is different here</p>
              <ol class="ind-dos__diff">
                <?php foreach ($ind_c['different'] as $ind_d): ?>
                  <li>
                    <h4 class="bdh-t bdh-t--s"><?= e($ind_d[0]) ?></h4>
                    <p class="bdh-d"><?= e($ind_d[1]) ?></p>
                  </li>
                <?php endforeach; ?>
              </ol>
            </div>

            <div class="ind-dos__block">
              <p class="ind-k ind-dos__bk"><span class="ind-num">02</span>What we do, across the six disciplines</p>
              <ul class="ind-dos__work" role="list">
                <?php
                /* read in discipline order (01–06 of data/site.php), so every brief runs 01 to 06 */
                $ind_work = $ind_c['work'];
                usort($ind_work, fn (array $ind_a, array $ind_b): int => strcmp($ind_dmap[$ind_a[0]]['n'] ?? '99', $ind_dmap[$ind_b[0]]['n'] ?? '99'));
                foreach ($ind_work as $ind_w):
                    $ind_dd  = $ind_dmap[$ind_w[0]] ?? null;
                    if ($ind_dd === null) continue;
                    $ind_cap = $ind_w[1];
                    $ind_lbl = ($ind_cap !== null && isset($ind_dd['caps'][$ind_cap])) ? $ind_dd['caps'][$ind_cap] : $ind_dd['name'];
                    $ind_href = $IND_URL($ind_w[0], $ind_cap);
                    /* the label only names a capability when its own page exists; otherwise it names the discipline */
                    if ($ind_href === xe_url('services/' . $ind_w[0] . '.php')) $ind_lbl = $ind_dd['name'];
                ?>
                  <li>
                    <p class="ind-dos__wd"><span class="ind-num"><?= e($ind_dd['n']) ?></span><?= e($ind_dd['name']) ?></p>
                    <p class="ind-dos__wt"><?= e($ind_w[2]) ?></p>
                    <p class="ind-dos__wl"><a class="ind-capl" href="<?= $ind_href ?>"><b><?= e($ind_dd['n']) ?></b><?= e($ind_lbl) ?><i aria-hidden="true">›</i></a></p>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>

            <div class="ind-dos__block">
              <p class="ind-k ind-dos__bk"><span class="ind-num">03</span>What binds the work</p>
              <dl class="ind-dos__rules">
                <?php foreach ($ind_c['rules'] as $ind_r): ?>
                  <div><dt><?= e($ind_r[0]) ?></dt><dd><?= e($ind_r[1]) ?></dd></div>
                <?php endforeach; ?>
              </dl>
              <div class="ind-dos__std">
                <p class="ind-k">Frameworks we build to here</p>
                <ul class="ind-dos__badges" role="list" aria-label="Frameworks we build to in <?= e($ind_c['name']) ?>">
                  <?php foreach ($ind_c['badges'] as $ind_b) { echo xt_badge($ind_b, ['variant' => 'chip', 'tag' => 'li']); } ?>
                </ul>
                <p class="ind-note">Frameworks delivery is built to and aligned with. Nothing here says Xterra Edze holds a certification, and a regulation is named only where it actually applies.</p>
              </div>
            </div>

            <div class="ind-dos__block">
              <p class="ind-k ind-dos__bk"><span class="ind-num">04</span>How it is measured</p>
              <ol class="ind-dos__meas">
                <?php foreach ($ind_c['measures'] as $ind_m): ?>
                  <li>
                    <p class="ind-dos__mn"><?= e($ind_m[0]) ?></p>
                    <p class="bdh-d"><?= e($ind_m[1]) ?></p>
                  </li>
                <?php endforeach; ?>
              </ol>
              <p class="ind-note">Measures are agreed with a baseline taken before the work starts. They are targets and definitions, not results.</p>
            </div>

            <div class="ind-dos__foot">
              <div class="ind-dos__first">
                <p class="ind-k">A typical first project</p>
                <p class="ind-dos__ft"><?= e($ind_c['first']) ?></p>
                <a class="tl" href="<?= xe_url('contact.php') ?>">Talk about this category <span class="i" aria-hidden="true">›</span></a>
              </div>
              <div class="ind-dos__fixed">
                <p class="ind-k">Systems of record we integrate with</p>
                <ul class="bdh-bullets" role="list">
                  <?php foreach ($ind_c['fixed'] as $ind_fx): ?><li><?= e($ind_fx) ?></li><?php endforeach; ?>
                </ul>
              </div>
            </div>

          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
