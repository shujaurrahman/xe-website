<?php /* DRAFT COPY — review before launch */
/* 10 Migration — replace the legacy system without a cliff edge. A strangler-fig board: a routing facade sits in
   front of the legacy monolith, and six modules move across one at a time, each through the same stages
   (legacy → shadow with a parallel run → 10% canary → 50% → 100% with the legacy module read-only → retired).
   Per module: the legacy side, a traffic dial in the facade, the new service, and the reconciliation counter.
   A week scrubber (real range input, Previous / Play / Next) moves the programme; the cutover log and the KPI
   strip follow it. migration.js links the week to scroll until the first interaction and animates the dials
   and packets. The HTML is week 20, where every stage is visible at once. All figures illustrative. */
$tcs_mg_mods = [   // [legacy module, new service, records compared at full parallel run]
    ['Customer accounts',   'accounts-service',  '412,908'],
    ['Product catalogue',   'catalogue-service', '38,214'],
    ['Orders',              'orders-service',    '4.8 M'],
    ['Pricing & quotes',    'pricing-service',   '96,540'],
    ['Billing & invoicing', 'billing-service',   '1.9 M'],
    ['Reporting',           'data platform · gold marts', '312 reports'],
];
/* stage 0..5 — [key, share of live traffic on the new side, dial label, legacy status, new status, reconciliation (with %s = records)] */
$tcs_mg_stages = [
    ['legacy', 0,   '0%',     'serving 100%',                'not started',                'no parallel run yet'],
    ['shadow', 0,   'shadow', 'serving 100%',                'shadow · reads mirrored',    '%s compared · 3 diffs open'],
    ['canary', 10,  '10%',    'serving 90%',                 'canary · 10% of tenants',    '%s compared · 0 diffs'],
    ['split',  50,  '50%',    'serving 50%',                 '50% · by region',            '%s compared · 0 diffs'],
    ['live',   100, '100%',   'read-only · rollback ready',  'live · 100%',                'reconciled daily · 0 diffs'],
    ['retired',100, '100%',   'retired · data archived',     'live · legacy switched off', 'archive checksum verified'],
];
$tcs_mg_log = [   // one line per step (week = step × 4)
    'Facade deployed in front of legacy-erp · 100% passthrough · no behaviour change',
    'accounts-service in shadow · CDC sync from legacy · 3 diffs open, all timezone rounding',
    'Accounts to 10% canary by feature flag · catalogue in shadow',
    'Accounts to 50% · catalogue 10% · orders in shadow on 4.8 M records',
    'Orders at 10%: diff rate 0.3% over the 0.1% budget · flag back to 0% in 40 s · fixed and resumed',
    'Accounts legacy module retired · 412,908 records archived · billing shadowed through month-end',
    'Catalogue retired · orders live at 100% with legacy read-only · reports shadowed',
    'Orders legacy module retired · billing at 50% after a clean month-end, signed by finance',
    'Pricing retired · billing live at 100% · half of all reports read gold marts',
    'Billing retired · 312 reports re-pointed to gold marts, 41 retired as unused',
    'legacy-erp switched off · final reconciliation signed by finance · licences ended',
];
$tcs_mg_step = 5;   // the state rendered in the HTML
$tcs_mg_max  = count($tcs_mg_log) - 1;
$tcs_mg_st   = fn (int $m, int $s): int => max(0, min(5, $s - $m));
$tcs_mg_kpi  = function (int $s) use ($tcs_mg_mods, $tcs_mg_stages, $tcs_mg_st): array {
    $live = 0; $share = 0; $diffs = 0;
    foreach (array_keys($tcs_mg_mods) as $m) {
        $k = $tcs_mg_st($m, $s);
        if ($k >= 4) $live++;
        $share += $tcs_mg_stages[$k][1];
        if ($k === 1) $diffs += 3;
    }
    return [$live . ' of ' . count($tcs_mg_mods), (int) round($share / count($tcs_mg_mods)) . '%', (string) $diffs, $s >= 4 ? '1' : '0', '0 min'];
};
$tcs_mg_k = $tcs_mg_kpi($tcs_mg_step);
$tcs_mg_data = [
    'mods'   => array_map(fn ($m) => ['old' => $m[0], 'new' => $m[1], 'n' => $m[2]], $tcs_mg_mods),
    'stages' => array_map(fn ($s) => ['k' => $s[0], 'p' => $s[1], 'dial' => $s[2], 'old' => $s[3], 'new' => $s[4], 'rc' => $s[5]], $tcs_mg_stages),
    'log'    => $tcs_mg_log,
];
$tcs_mg_practices = [   // [icon, title, text]
    ['sync',     'Dual running, kept in sync',   'Change data capture keeps legacy and new stores aligned in both directions while a module is split, so either side can serve a request.'],
    ['eval',     'Reconciliation you can read',  'Every night the two sides are compared on counts, checksums and sampled fields. Diffs have an owner and a budget; finance signs the money modules.'],
    ['rollback', 'A way back per module',        'Traffic moves by feature flag at the facade. Rolling a module back is a flag change measured in seconds, not a restore.'],
    ['database', 'Data migration, rehearsed',    'Full dry runs on production-sized copies, timed and repeated until the cutover window is predictable and boring.'],
];
?>
<section class="band band--alt tcs-migration" id="migration" aria-labelledby="migration-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="tcs-eb"><span class="tcs-eb__g" aria-hidden="true"></span>Legacy modernisation · strangler fig</p>
        <h2 class="h2" id="migration-t"><span class="g">Replace the legacy system</span> without a cliff edge.</h2>
      </div>
      <div>
        <p class="lead">No big-bang weekend. A routing facade goes in front of the old system, then modules move across one at a time: shadowed, reconciled, shifted by percentage and retired only when the numbers agree.</p>
      </div>
    </div>

    <div class="tcs-mg" data-rv>
      <div class="bdh-ui tcs-mg__win" data-mg='<?= e(json_encode($tcs_mg_data, JSON_UNESCAPED_UNICODE)) ?>' data-step="<?= $tcs_mg_step ?>">
        <div class="bdh-ui__bar tcs-mg__bar">
          <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
          <span class="tcs-mg__path">migration <i>/</i> your-company <i>/</i> <b>legacy-erp → platform</b></span>
          <span class="tcs-mg__wk" aria-hidden="true"><i class="bdh-pulse"></i><span data-mg-wk>Week <?= $tcs_mg_step * 4 ?> of <?= $tcs_mg_max * 4 ?></span></span>
        </div>

        <div class="tcs-mg__ctl">
          <div class="tcs-mg__btns">
            <button type="button" class="tcs-btn" data-mg-go="-1" aria-label="Previous step, four weeks back"><span aria-hidden="true">‹</span></button>
            <button type="button" class="tcs-btn tcs-btn--pri" data-mg-play aria-pressed="false"><span data-mg-play-l>Play programme</span></button>
            <button type="button" class="tcs-btn" data-mg-go="1" aria-label="Next step, four weeks on"><span aria-hidden="true">›</span></button>
          </div>
          <div class="tcs-mg__scrub">
            <label class="tcs-mg__sl" for="migration-week">Programme week</label>
            <div class="tcs-mg__rw" style="--v:<?= round($tcs_mg_step / $tcs_mg_max, 4) ?>">
              <span class="tcs-mg__rail" aria-hidden="true"><i></i></span>
              <input class="tcs-mg__range" type="range" id="migration-week" min="0" max="<?= $tcs_mg_max ?>" step="1" value="<?= $tcs_mg_step ?>" aria-valuetext="Week <?= $tcs_mg_step * 4 ?> of <?= $tcs_mg_max * 4 ?>" data-mg-range>
            </div>
            <span class="tcs-mg__ticks" aria-hidden="true"><?php for ($tcs_mg_i = 0; $tcs_mg_i <= $tcs_mg_max; $tcs_mg_i++): ?><i<?= $tcs_mg_i <= $tcs_mg_step ? ' class="is-past"' : '' ?>><?= $tcs_mg_i % 2 === 0 ? '<b>wk ' . ($tcs_mg_i * 4) . '</b>' : '' ?></i><?php endfor; ?></span>
          </div>
        </div>

        <div class="tcs-mg__board">
          <div class="tcs-mg__heads" aria-hidden="true">
            <span class="tcs-mg__hd tcs-mg__hd--old"><?= xt_icon('server', ['size' => 15, 'mono' => true]) ?>Legacy monolith <em>legacy-erp · on-premises</em></span>
            <span class="tcs-mg__hd tcs-mg__hd--fac"><?= xt_icon('network', ['size' => 15]) ?>Routing facade <em>by path and tenant</em></span>
            <span class="tcs-mg__hd tcs-mg__hd--new"><?= xt_icon('cloud', ['size' => 15, 'mono' => true]) ?>New platform <em>your cloud account</em></span>
          </div>
          <p class="tcs-mg__in" aria-hidden="true"><span>All client traffic · web, mobile, partner API, batch jobs</span></p>

          <ol class="tcs-mg__rows" aria-label="Modules and their migration stage">
            <?php foreach ($tcs_mg_mods as $tcs_mg_m => $tcs_mg_mod):
                $tcs_mg_k2 = $tcs_mg_st($tcs_mg_m, $tcs_mg_step);
                $tcs_mg_s  = $tcs_mg_stages[$tcs_mg_k2];
                $tcs_mg_p  = $tcs_mg_s[1]; ?>
              <li class="tcs-mg__row is-<?= $tcs_mg_s[0] ?>" data-m="<?= $tcs_mg_m ?>" style="--p:<?= $tcs_mg_p / 100 ?>;--i:<?= $tcs_mg_m ?>">
                <div class="tcs-mg__old">
                  <b><?= e($tcs_mg_mod[0]) ?></b>
                  <span data-mg-old><?= e($tcs_mg_s[3]) ?></span>
                </div>
                <span class="tcs-mg__pipe tcs-mg__pipe--l" aria-hidden="true"><i></i><i></i></span>
                <span class="tcs-mg__dial" aria-hidden="true">
                  <svg viewBox="0 0 44 44"><circle class="tcs-mg__dt" cx="22" cy="22" r="18"/><circle class="tcs-mg__dv" cx="22" cy="22" r="18" pathLength="100"/></svg>
                  <b data-mg-dial><?= e($tcs_mg_s[2]) ?></b>
                </span>
                <span class="tcs-mg__pipe tcs-mg__pipe--r" aria-hidden="true"><i></i><i></i></span>
                <div class="tcs-mg__new">
                  <b><?= e($tcs_mg_mod[1]) ?></b>
                  <span data-mg-new><?= e($tcs_mg_s[4]) ?></span>
                  <span class="tcs-mg__rc" data-mg-rc><?= e(sprintf($tcs_mg_s[5], $tcs_mg_mod[2])) ?></span>
                </div>
                <span class="bdh-sr" data-mg-sr><?= e($tcs_mg_mod[0]) ?>: <?= e($tcs_mg_s[2] === 'shadow' ? 'shadow run, no live traffic moved' : $tcs_mg_p . '% of live traffic on ' . $tcs_mg_mod[1]) ?>. Legacy <?= e($tcs_mg_s[3]) ?>.</span>
              </li>
            <?php endforeach; ?>
          </ol>
        </div>

        <div class="tcs-mg__foot">
          <dl class="tcs-mg__kpis">
            <div><dt>Modules on the platform</dt><dd data-mg-k="0"><?= e($tcs_mg_k[0]) ?></dd></div>
            <div><dt>Live traffic moved</dt><dd data-mg-k="1"><?= e($tcs_mg_k[1]) ?></dd></div>
            <div><dt>Open diffs</dt><dd data-mg-k="2"><?= e($tcs_mg_k[2]) ?></dd></div>
            <div><dt>Rollbacks</dt><dd data-mg-k="3"><?= e($tcs_mg_k[3]) ?></dd></div>
            <div><dt>Unplanned downtime</dt><dd data-mg-k="4"><?= e($tcs_mg_k[4]) ?></dd></div>
          </dl>
          <div class="tcs-mg__log">
            <p class="tcs-mg__lh">Cutover log <em>append-only</em></p>
            <ol class="tcs-mg__ll" data-mg-log>
              <?php for ($tcs_mg_i = $tcs_mg_step; $tcs_mg_i >= max(0, $tcs_mg_step - 2); $tcs_mg_i--): ?>
                <li<?= $tcs_mg_i === $tcs_mg_step ? ' class="is-new"' : '' ?>><time>wk <?= sprintf('%02d', $tcs_mg_i * 4) ?></time><span><?= e($tcs_mg_log[$tcs_mg_i]) ?></span></li>
              <?php endfor; ?>
            </ol>
          </div>
        </div>
        <p class="tcs-mg__status bdh-sr" aria-live="polite" data-mg-status></p>
      </div>

      <aside class="tcs-mg__side" aria-labelledby="migration-side-t">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r43 tcs-mg__img">
          <img src="<?= xe_url('assets/imgs/tech/custom-software-data-platforms/migration-control-room.jpg') ?>" alt="An old control room with rows of switch panels, a wall-sized system diagram and three boxy monitors" width="1800" height="1200" loading="lazy" decoding="async" style="object-position:40% 50%">
          <figcaption class="tcs-mg__cap"><span class="bdh-cap-chip"><b>Parallel run</b>The old system stays on until the numbers agree.</span></figcaption>
        </figure>
        <h3 class="tcs-mg__st" id="migration-side-t">How the cutover stays reversible</h3>
        <ul class="tcs-mg__pr">
          <?php foreach ($tcs_mg_practices as $tcs_mg_pr): ?>
            <li><span class="tcs-mg__pi"><?= xt_icon($tcs_mg_pr[0], ['size' => 18]) ?></span><div><b><?= e($tcs_mg_pr[1]) ?></b><p><?= e($tcs_mg_pr[2]) ?></p></div></li>
          <?php endforeach; ?>
        </ul>
      </aside>
    </div>
    <p class="tcs-note tcs-mg__note"><span class="bdh-ill">Illustrative programme</span>Six modules over forty weeks for “Your company”. Real waves follow your risk, your release calendar and your month-end.</p>
  </div>
</section>
