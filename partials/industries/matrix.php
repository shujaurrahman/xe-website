<?php /* DRAFT COPY — review before launch */
/* Matrix — the whole page in one grid: six sectors down, six disciplines across, and the usual weight
   of each pairing. Static by design; it sits between two interactive sections and its job is to be
   read, not driven. The concentration readouts under it are counted from data/industries.php, so the
   grid and the prose can never disagree. Under it, every capability page each sector usually needs —
   the page's main way through to the rest of the site. */
$mtx_lvl  = [3 => 'Leads', 2 => 'Core', 1 => 'Supports'];
$mtx_ord  = array_keys($ind_disc);
$mtx_tot  = [];
foreach ($mtx_ord as $mtx_slug) {
    $mtx_tot[$mtx_slug] = [3 => 0, 2 => 0, 1 => 0];
    foreach ($IND as $mtx_s) { $mtx_tot[$mtx_slug][$mtx_s['mix'][$mtx_slug] ?? 1]++; }
}
/* the two readouts: which discipline leads in most sectors, and which pairing changes most */
$mtx_leads = $mtx_ord;
usort($mtx_leads, fn ($mtx_a, $mtx_b) => ($mtx_tot[$mtx_b][3] <=> $mtx_tot[$mtx_a][3]) ?: (array_search($mtx_a, $mtx_ord, true) <=> array_search($mtx_b, $mtx_ord, true)));
/* one discipline that both leads somewhere and only supports somewhere else, with the sectors named,
   so the claim can be checked against the grid above rather than taken on trust */
$mtx_swing = null;
foreach ($mtx_ord as $mtx_slug) {
    if ($mtx_tot[$mtx_slug][3] < 1 || $mtx_tot[$mtx_slug][1] < 1) continue;
    $mtx_score = $mtx_tot[$mtx_slug][3] * $mtx_tot[$mtx_slug][1];
    if ($mtx_swing === null || $mtx_score > $mtx_swing[1]) $mtx_swing = [$mtx_slug, $mtx_score];
}
$mtx_at = function (string $mtx_slug, int $mtx_w) use ($IND): string {
    $mtx_names = [];
    foreach ($IND as $mtx_s) { if (($mtx_s['mix'][$mtx_slug] ?? 1) === $mtx_w) $mtx_names[] = $mtx_s['name']; }
    return count($mtx_names) > 1
        ? implode(', ', array_slice($mtx_names, 0, -1)) . ' and ' . end($mtx_names)
        : ($mtx_names[0] ?? '');
};
/* every sector draws a different mix — checked here rather than asserted */
$mtx_shapes = [];
foreach ($IND as $mtx_s) { $mtx_m = $mtx_s['mix']; ksort($mtx_m); $mtx_shapes[json_encode($mtx_m)] = true; }
$mtx_distinct = count($mtx_shapes);
$mtx_cap_name = function (string $mtx_ds, string $mtx_cs) use ($ind_disc): string {
    foreach ($ind_disc[$mtx_ds]['caps'] as $mtx_c) { if (($mtx_c[2] ?? '') === $mtx_cs) return $mtx_c[0]; }
    return ucwords(str_replace('-', ' ', $mtx_cs));
};
$mtx_uniq = [];
foreach ($IND as $mtx_s) { foreach ($mtx_s['caps'] as $mtx_ds => $mtx_cs) { foreach ($mtx_cs as $mtx_cp) $mtx_uniq[$mtx_ds . '/' . $mtx_cp] = true; } }
$mtx_count = count($mtx_uniq);
?>
<section class="band ind-mtx" id="matrix" aria-labelledby="matrix-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Sectors × disciplines</p>
        <h2 class="h2" id="matrix-t"><span class="g">Six sectors, six disciplines,</span> thirty-six different weights.</h2>
      </div>
      <div>
        <p class="lead">The mix is never the same twice. This is the grid we start every scoping conversation from — which disciplines lead, which are core, and which sit in support.</p>
      </div>
    </div>

    <figure class="ind-mtx__wrap" data-rv data-rv-d="60">
      <figcaption class="ind-mtx__cap">
        <span class="ind-k">Typical weight in a programme</span>
        <span class="ind-mtx__key" aria-hidden="true">
          <span><span class="ind-meter ind-meter--sm" data-v="1"><i></i><i></i><i></i></span>Supports</span>
          <span><span class="ind-meter ind-meter--sm" data-v="2"><i></i><i></i><i></i></span>Core</span>
          <span><span class="ind-meter ind-meter--sm" data-v="3"><i></i><i></i><i></i></span>Leads</span>
        </span>
      </figcaption>
      <div class="bdh-scroll-x mask-x ind-mtx__scroll" tabindex="0" role="region" aria-label="Sectors by discipline: how much each discipline typically leads">
        <table class="ind-ledger ind-mtx__tbl">
          <caption class="sr">For each of the six sectors, how much each of the six disciplines typically weighs in a programme: leads, core, or supports.</caption>
          <thead>
            <tr>
              <th scope="col">Sector</th>
              <?php foreach ($mtx_ord as $mtx_slug): $mtx_d = $ind_disc[$mtx_slug]; ?>
                <th scope="col"><a href="<?= xe_discipline_url($mtx_d) ?>"><span class="ind-mtx__dn"><?= e($mtx_d['n']) ?></span><span class="ind-mtx__dnm"><?= e($mtx_d['name']) ?></span></a></th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($IND as $mtx_ri => $mtx_s): ?>
              <tr>
                <th scope="row"><a href="#<?= e($mtx_s['id']) ?>"><span class="ind-mtx__sn"><?= e($mtx_s['n']) ?></span><?= e($mtx_s['name']) ?></a></th>
                <?php foreach ($mtx_ord as $mtx_ci => $mtx_slug): $mtx_v = $mtx_s['mix'][$mtx_slug] ?? 1; ?>
                  <td<?= $mtx_v === 3 ? ' class="is-lead"' : '' ?>>
                    <span class="ind-meter ind-meter--sm" data-v="<?= $mtx_v ?>" style="--i:<?= $mtx_ci ?>;--s:<?= $mtx_ri ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                    <span class="sr"><?= e($mtx_lvl[$mtx_v]) ?></span>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
          <tfoot>
            <tr>
              <th scope="row">Leads in</th>
              <?php foreach ($mtx_ord as $mtx_slug): ?>
                <td><b><?= $mtx_tot[$mtx_slug][3] ?></b> of 6</td>
              <?php endforeach; ?>
            </tr>
          </tfoot>
        </table>
      </div>
      <p class="ind-note ind-mtx__swipe">Swipe the grid to see all six disciplines.</p>
    </figure>

    <div class="ind-mtx__read" data-rv data-rv-d="90">
      <p class="ind-mtx__r">
        <span class="ind-k">What the grid says</span>
        <?= $mtx_distinct ?> sectors, <?= $mtx_distinct ?> different mixes — no two of them draw the same shape.
        <?= e($ind_disc[$mtx_leads[0]]['name']) ?> leads most often, in <?= $mtx_tot[$mtx_leads[0]][3] ?> of the six. That is a reading of where the hard problems currently sit, not a ranking of the disciplines.
      </p>
      <p class="ind-mtx__r">
        <span class="ind-k">What moves most</span>
<?php if ($mtx_swing): ?><?= e($ind_disc[$mtx_swing[0]]['name']) ?> leads in <?= e($mtx_at($mtx_swing[0], 3)) ?>, and only supports in <?= e($mtx_at($mtx_swing[0], 1)) ?>. Same discipline, a different size of job — which is why a team that has only worked in one of those categories will size the other wrongly.<?php endif; ?>
      </p>
      <p class="ind-mtx__r">
        <span class="ind-k">How we use it</span>
        The grid sets the shape of the first conversation, never the answer. Your estate, your team and your calendar move the weights before anything is scoped.
      </p>
    </div>

    <div class="ind-mtx__caps" data-rv data-rv-d="120">
      <div class="ind-mtx__ch">
        <h3 class="bdh-t bdh-t--l">Capability pages, by sector</h3>
        <p class="ind-note"><?= $mtx_count ?> distinct capability pages across the six categories — each one a page that exists, not a promise.</p>
      </div>
      <ul class="ind-mtx__clist">
        <?php foreach ($IND as $mtx_s): ?>
          <li>
            <p class="ind-mtx__cs"><a href="#<?= e($mtx_s['id']) ?>"><span class="ind-mtx__sn"><?= e($mtx_s['n']) ?></span><?= e($mtx_s['name']) ?></a></p>
            <div class="ind-capls">
              <?php foreach ($mtx_ord as $mtx_slug):
                  foreach (($mtx_s['caps'][$mtx_slug] ?? []) as $mtx_cs): ?>
                    <a class="ind-capl" href="<?= xe_url('services/' . $mtx_slug . '/' . $mtx_cs . '.php') ?>"><b><?= e($ind_disc[$mtx_slug]['n']) ?></b><?= e($mtx_cap_name($mtx_slug, $mtx_cs)) ?><i aria-hidden="true">›</i></a>
              <?php endforeach; endforeach; ?>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>
