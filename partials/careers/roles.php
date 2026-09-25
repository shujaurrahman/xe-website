<?php /* DRAFT COPY — review before launch */
/* Open roles — the one section on the page driven entirely by data/careers.php. Every role is a
   native <details> panel inside a group for its practice, so the whole list reads and opens with
   JavaScript off. The filters are a real GET form the server answers (?d=practice&l=location&t=type),
   which assets/js/careers/roles.js turns into instant client-side filtering and hides the submit
   button. /careers?role=<slug> opens that role's panel server-side, so a shared link lands on the
   role itself. Locals are prefixed roles_. */

$roles_groups = $CAR_GROUPS;
$roles_locs   = car_locations();
$roles_types  = car_types();

/* ---- the filter, read from the query and validated against the data file ---- */
$roles_q = [
    'd' => isset($roles_groups[$_GET['d'] ?? '']) ? (string) $_GET['d'] : '',
    'l' => isset($roles_locs[$_GET['l'] ?? ''])   ? (string) $_GET['l'] : '',
    't' => isset($roles_types[$_GET['t'] ?? ''])  ? (string) $_GET['t'] : '',
];
$roles_on   = ($roles_q['d'] !== '') || ($roles_q['l'] !== '') || ($roles_q['t'] !== '');
$roles_open = is_string($_GET['role'] ?? null) && car_role($_GET['role']) ? (string) $_GET['role'] : '';

$roles_match = function (array $roles_r) use ($roles_q): bool {
    if ($roles_q['d'] !== '' && $roles_r['discipline'] !== $roles_q['d']) return false;
    if ($roles_q['l'] !== '' && !in_array($roles_q['l'], $roles_r['locations'], true)) return false;
    if ($roles_q['t'] !== '' && $roles_r['type'] !== $roles_q['t']) return false;
    return true;
};

$roles_total = count($CAR_ROLES);
$roles_shown = 0;
$roles_by_g  = [];
foreach ($CAR_ROLES as $roles_slug => $roles_r) {
    $roles_by_g[$roles_r['discipline']][] = $roles_r;
    if ($roles_match($roles_r)) $roles_shown++;
}

$roles_url   = xe_url('careers.php');
$roles_word  = $roles_total === 1 ? 'role' : 'roles';
$roles_note  = $roles_on
    ? 'Showing ' . $roles_shown . ' of ' . $roles_total . ' ' . $roles_word . '.'
    : 'Showing all ' . $roles_total . ' ' . $roles_word . '.';
$roles_n = 0;
?>
<section class="band band--alt car-roles" id="roles" aria-labelledby="roles-t">
  <div class="wrap">

    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Open roles</p>
        <h2 class="h2" id="roles-t"><span class="g">Where we are hiring</span> right now.</h2>
      </div>
      <div>
        <p class="lead">Each role says what the work actually is, what we will look for, and which parts are genuinely optional. Read the whole panel before you write to us. If nothing fits, the card at the end takes a general application.</p>
        <p class="car-note">Pay is discussed in the first call, against the role and your experience. We do not publish bands we would then have to argue with.</p>
      </div>
    </div>

    <!-- PLACEHOLDER: confirm the open roles before launch -->
    <div class="car-rls" data-car-roles>

      <form class="car-flt" method="get" action="<?= e($roles_url) ?>#roles" data-car-flt>
        <div class="car-flt__fields">
          <p class="car-flt__k" id="roles-flt-k">Filter roles</p>
          <div class="car-flt__f">
            <label class="car-flt__l" for="roles-f-d">Practice</label>
            <span class="car-selw">
              <select class="car-sel" id="roles-f-d" name="d" data-car-f="d">
                <option value="">All practices</option>
                <?php foreach ($roles_groups as $roles_gk => $roles_g): ?>
                  <option value="<?= e($roles_gk) ?>"<?= $roles_q['d'] === $roles_gk ? ' selected' : '' ?>><?= e($roles_g['name']) ?> (<?= count($roles_by_g[$roles_gk] ?? []) ?>)</option>
                <?php endforeach; ?>
              </select>
            </span>
          </div>
          <div class="car-flt__f">
            <label class="car-flt__l" for="roles-f-l">Location</label>
            <span class="car-selw">
              <select class="car-sel" id="roles-f-l" name="l" data-car-f="l">
                <option value="">All locations</option>
                <?php foreach ($roles_locs as $roles_lk => $roles_ll): ?>
                  <option value="<?= e($roles_lk) ?>"<?= $roles_q['l'] === $roles_lk ? ' selected' : '' ?>><?= e($roles_ll) ?></option>
                <?php endforeach; ?>
              </select>
            </span>
          </div>
          <div class="car-flt__f">
            <label class="car-flt__l" for="roles-f-t">Type</label>
            <span class="car-selw">
              <select class="car-sel" id="roles-f-t" name="t" data-car-f="t">
                <option value="">All types</option>
                <?php foreach ($roles_types as $roles_tk => $roles_tl): ?>
                  <option value="<?= e($roles_tk) ?>"<?= $roles_q['t'] === $roles_tk ? ' selected' : '' ?>><?= e($roles_tl) ?></option>
                <?php endforeach; ?>
              </select>
            </span>
          </div>
          <div class="car-flt__go">
            <button class="btn btn--out btn--sm car-flt__btn" type="submit" data-car-go>Show matching roles</button>
          </div>
        </div>
        <div class="car-flt__ro">
          <p class="car-flt__n" role="status" data-car-count><?= e($roles_note) ?></p>
          <a class="tl car-flt__clear" href="<?= e($roles_url) ?>#roles" data-car-clear<?= $roles_on ? '' : ' hidden' ?>>Clear filters <span class="i" aria-hidden="true">›</span></a>
        </div>
      </form>

      <div class="car-rl" data-car-list>
        <?php foreach ($roles_groups as $roles_gk => $roles_g):
            $roles_set  = $roles_by_g[$roles_gk] ?? [];
            if (!$roles_set) continue;
            $roles_vis  = array_values(array_filter($roles_set, $roles_match)); ?>
          <div class="car-rl__g" role="group" aria-label="<?= e($roles_g['name']) ?>, <?= count($roles_set) ?> open <?= count($roles_set) === 1 ? 'role' : 'roles' ?>" data-car-group="<?= e($roles_gk) ?>"<?= $roles_vis ? '' : ' hidden' ?>>
            <p class="car-rl__gk">
              <span class="car-rl__gn"><?= e($roles_g['name']) ?></span>
              <?php if ($roles_g['url'] !== ''): ?>
                <a class="car-rl__gl" href="<?= e($roles_g['url']) ?>">What this practice does <span class="i" aria-hidden="true">›</span></a>
              <?php endif; ?>
              <span class="car-rl__gc" data-car-gcount><?= count($roles_vis) ?></span>
            </p>

            <?php foreach ($roles_set as $roles_r): $roles_n++;
                $roles_is_open = $roles_open === $roles_r['slug'];
                $roles_hit     = $roles_match($roles_r); ?>
              <details class="car-role" id="role-<?= e($roles_r['slug']) ?>" data-car-role
                       data-d="<?= e($roles_r['discipline']) ?>" data-l="<?= e(implode(' ', $roles_r['locations'])) ?>" data-t="<?= e($roles_r['type']) ?>"
                       data-title="<?= e($roles_r['title']) ?>"<?= $roles_is_open ? ' open' : '' ?><?= $roles_hit ? '' : ' hidden' ?>>
                <summary class="car-role__s">
                  <span class="car-role__i" aria-hidden="true"><?= str_pad((string) $roles_n, 2, '0', STR_PAD_LEFT) ?></span>
                  <h3 class="car-role__t"><?= e($roles_r['title']) ?></h3>
                  <span class="car-role__d"><?= e($roles_r['does']) ?></span>
                  <span class="car-role__m">
                    <span class="bdh-tag bdh-tag--blue"><?= e($roles_types[$roles_r['type']] ?? 'Role') ?></span>
                    <span class="bdh-tag"><?= e(car_loc_line($roles_r)) ?></span>
                    <span class="bdh-tag"><?= e($roles_r['experience']) ?></span>
                  </span>
                  <span class="car-role__x" aria-hidden="true"></span>
                </summary>

                <div class="car-role__b">
                  <div class="car-role__cols">
                    <?php foreach ([['work', 'What you will work on'], ['look', 'What we look for'], ['nice', 'Nice to have']] as $roles_col):
                        if (!$roles_r[$roles_col[0]]) continue; ?>
                      <div class="car-role__col">
                        <p class="car-k"><?= e($roles_col[1]) ?></p>
                        <ul class="bdh-bullets">
                          <?php foreach ($roles_r[$roles_col[0]] as $roles_li): ?><li><?= e($roles_li) ?></li><?php endforeach; ?>
                        </ul>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <div class="car-role__foot">
                    <dl class="car-role__dl">
                      <div><dt>Practice</dt><dd><?= e($roles_g['name']) ?></dd></div>
                      <div><dt>Based</dt><dd><?= e(car_loc_line($roles_r)) ?></dd></div>
                      <div><dt>Type</dt><dd><?= e($roles_types[$roles_r['type']] ?? '—') ?></dd></div>
                      <div><dt>Experience</dt><dd><?= e($roles_r['experience']) ?></dd></div>
                    </dl>
                    <div class="car-role__act">
                      <a class="btn btn--ink" href="<?= e(car_apply_url($roles_r['slug'])) ?>">Apply for this role <span class="i" aria-hidden="true">›</span></a>
                      <a class="tl" href="#hiring">See the hiring stages <span class="i" aria-hidden="true">›</span></a>
                    </div>
                  </div>
                </div>
              </details>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <p class="car-rl__none" data-car-none<?= $roles_shown ? ' hidden' : '' ?>>
          Nothing open matches that combination today. Clear the filters to see every role, or send a
          general application and we will hold it against the next opening in that practice.
        </p>
      </div>

      <div class="car-rl__gen">
        <div>
          <p class="car-k">No role that fits?</p>
          <h3 class="bdh-t bdh-t--l">Send a general application.</h3>
          <p class="bdh-d">We read every one. If your work is close to something we will need, we will say so and tell you when. If it is not, we will say that too rather than leave you waiting.</p>
        </div>
        <a class="btn btn--dark" href="<?= e(car_apply_url()) ?>">Apply without a role <span class="i" aria-hidden="true">›</span></a>
      </div>

    </div>
  </div>
</section>
