<?php /* DRAFT COPY — review before launch */
/* Open roles. Filters are a plain GET form (q, dept, loc, type) so the list filters without JS;
   assets/js/careers/roles.js filters live and keeps the URL in step. Each role is a <details> with
   id="role-<id>" (?role=<id> opens it server-side; JS opens it from the #hash). Apply posts to the
   contact page's own send fields with from=careers and the signed t token. */
$car_g = fn (string $k): string => is_string($_GET[$k] ?? null) ? trim(mb_substr($_GET[$k], 0, 80)) : '';
$car_q = $car_g('q'); $car_fd = $car_g('dept'); $car_fl = $car_g('loc'); $car_ft = $car_g('type'); $car_open = $car_g('role');
$car_opts = ['dept' => [], 'loc' => [], 'type' => []];
foreach ($car_roles as $car_r) foreach ($car_opts as $car_k => $car_v) $car_opts[$car_k][$car_r[$car_k]] = true;
$car_text = fn (array $r): string => mb_strtolower(implode(' ', array_merge([$r['title'], $r['dept'], $r['loc'], $r['type'], $r['level'], $r['summary']], $r['req'], $r['nice'])));
$car_match = function (array $r) use ($car_q, $car_fd, $car_fl, $car_ft, $car_text): bool {
    if ($car_fd !== '' && $r['dept'] !== $car_fd) return false;
    if ($car_fl !== '' && $r['loc'] !== $car_fl) return false;
    if ($car_ft !== '' && $r['type'] !== $car_ft) return false;
    foreach (preg_split('~\s+~', mb_strtolower($car_q), -1, PREG_SPLIT_NO_EMPTY) as $car_w) if (!str_contains($car_text($r), $car_w)) return false;
    return true;
};
$car_shown = count(array_filter($car_roles, $car_match));
$car_labels = ['dept' => 'Team', 'loc' => 'Location', 'type' => 'Type'];
$car_sel = ['dept' => $car_fd, 'loc' => $car_fl, 'type' => $car_ft];
?>
<section class="band band--alt car-roles" id="roles" aria-labelledby="roles-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div><p class="lbl lbl--blue"><span class="dot"></span>Open roles</p>
        <h2 class="h2" id="roles-t"><span class="g">Find your role.</span> Apply in two minutes.</h2></div>
      <div><p class="lead">Search, filter, open a role for the detail, then apply on a short form with the role already filled in. No account, no cover-letter portal.</p></div>
    </div>
    <!-- PLACEHOLDER: openings are to be confirmed before launch -->
    <p class="car-roles__tbc"><?= xt_icon('alert') ?> Openings listed here are to be confirmed. Apply anyway; we keep strong applications on file for the next opening.</p>
    <form class="car-filter" method="get" action="<?= e(xe_url('careers.php')) ?>#roles" role="search" aria-label="Filter open roles" data-car-filter>
      <div class="car-filter__q">
        <label for="car-q"><?= xt_icon('search') ?><span class="sr">Search roles</span></label>
        <input id="car-q" name="q" type="search" value="<?= e($car_q) ?>" placeholder="Search roles, skills, teams" autocomplete="off" maxlength="80">
      </div>
      <?php foreach ($car_opts as $car_k => $car_vals): ?>
      <div class="car-filter__f">
        <label for="car-<?= $car_k ?>"><?= $car_labels[$car_k] ?></label>
        <select id="car-<?= $car_k ?>" name="<?= $car_k ?>">
          <option value="">All</option>
          <?php foreach (array_keys($car_vals) as $car_v): ?><option<?= $car_sel[$car_k] === $car_v ? ' selected' : '' ?>><?= e($car_v) ?></option><?php endforeach; ?>
        </select>
      </div>
      <?php endforeach; ?>
      <div class="car-filter__go">
        <button class="btn btn--ink" type="submit" data-car-submit>Filter</button>
        <a class="tl car-filter__clear" href="<?= e(xe_url('careers.php')) ?>#roles" data-car-clear>Clear</a>
      </div>
    </form>
    <p class="car-count" role="status" aria-live="polite" data-car-count><?= $car_shown ?> of <?= count($car_roles) ?> roles</p>
    <div class="car-list" data-car-list>
      <?php foreach ($car_roles as $car_r): $car_id = $car_r['id']; $car_ok = $car_match($car_r); ?>
      <details class="car-role" id="role-<?= e($car_id) ?>" data-dept="<?= e($car_r['dept']) ?>" data-loc="<?= e($car_r['loc']) ?>" data-type="<?= e($car_r['type']) ?>" data-text="<?= e($car_text($car_r)) ?>"<?= $car_ok ? '' : ' hidden' ?><?= $car_open === $car_id ? ' open' : '' ?>>
        <summary class="car-role__sum">
          <span class="car-role__main"><span class="car-role__dept"><?= e($car_r['dept']) ?></span><span class="car-role__t"><?= e($car_r['title']) ?></span></span>
          <span class="car-role__tags"><span><?= e($car_r['loc']) ?></span><span><?= e($car_r['type']) ?></span><span><?= e($car_r['level']) ?></span></span>
          <span class="car-role__x" aria-hidden="true"></span>
        </summary>
        <div class="car-role__body">
          <div class="car-role__info">
            <p class="car-role__sm"><?= e($car_r['summary']) ?></p>
            <div class="car-role__cols">
              <div><h3 class="car-role__h">You will</h3><ul><?php foreach ($car_r['resp'] as $car_x): ?><li><?= e($car_x) ?></li><?php endforeach; ?></ul></div>
              <div><h3 class="car-role__h">You bring</h3><ul><?php foreach ($car_r['req'] as $car_x): ?><li><?= e($car_x) ?></li><?php endforeach; ?></ul></div>
              <div><h3 class="car-role__h">Nice to have</h3><ul><?php foreach ($car_r['nice'] as $car_x): ?><li><?= e($car_x) ?></li><?php endforeach; ?></ul></div>
            </div>
            <p class="car-role__link"><a class="tl" href="<?= e(xe_url('careers.php') . '?role=' . $car_id . '#role-' . $car_id) ?>" data-car-link>Link to this role</a></p>
          </div>
          <?php /* Applying happens on its own page, /careers/apply, which the owner asked for. The role
                   travels in ?role=, which that page validates against this same data file. */ ?>
          <div class="car-apply">
            <p class="car-apply__h">Apply for this role</p>
            <p class="car-apply__note">A short form on its own page, with this role already filled in: your details, a link to your work, and why this role.</p>
            <a class="btn btn--ink car-apply__go" href="<?= e(xe_url('careers/apply.php') . '?role=' . rawurlencode($car_id)) ?>">Apply for this role <span class="i" aria-hidden="true">›</span><span class="sr">: <?= e($car_r['title']) ?></span></a>
          </div>
        </div>
      </details>
      <?php endforeach; ?>
      <p class="car-empty" data-car-empty<?= $car_shown ? ' hidden' : '' ?>>No roles match that yet. <a class="tl" href="<?= e(xe_url('careers.php')) ?>#roles" data-car-clear>Clear the filters</a> or <a class="tl" href="#apply">send a general application</a>.</p>
    </div>
  </div>
</section>
