<?php /* DRAFT COPY — review before launch */
/* 07 · Governance and releases — who may change what, and a semver changelog with filters and
   watch controls. Versions, dates and notes are illustrative. PLACEHOLDER: confirm before launch */
$cbs_gv_roles = [   // [role, who, patch, minor, major]
    ['Contributor',  'Any team using the system', 'propose', 'propose', 'propose'],
    ['Maintainer',   'Design and engineering leads', 'approve', 'review', 'review'],
    ['System owner', 'Named brand lead',          'approve', 'approve', 'approve'],
    ['Brand council','Marketing, product, comms', '—',       '—',       'sign off'],
];
$cbs_gv_log = [   // [version, level, date, title, [[type, note], …], status]
    ['2.5.0-rc.1', 'minor', 'In review', 'Brighter primary for campaign surfaces', [['added', 'color.primary.bright, campaign templates only'], ['changed', 'button.primary label weight 500 → 600']], 'rc'],
    ['2.4.0', 'minor', 'Illustrative · Q3', 'Density tokens', [['added', 'space.density compact, default and comfortable'], ['deprecated', 'spacing.sm, use space.2 · removed in 3.0.0']], ''],
    ['2.3.2', 'patch', 'Illustrative · Q3', 'Focus and safe areas', [['fixed', 'Focus ring visible on ink surfaces'], ['changed', 'Social tile safe area 64 → 72 px']], ''],
    ['2.0.0', 'major', 'Illustrative · Q1', 'Tokens renamed to category.role', [['breaking', 'color-blue is now color.primary'], ['breaking', 'Card drops the legacy shadow prop'], ['added', 'Codemod and a six-week overlap for migration']], ''],
    ['1.4.0', 'minor', 'Illustrative · Q4', 'Email and market packs', [['added', 'Email header template with three slots'], ['added', 'Market 03 locale pack']], ''],
    ['1.0.0', 'major', 'Illustrative · Q3', 'First release', [['added', 'Token set, core components and the first templates']], ''],
];
$cbs_gv_types = ['all' => 'All', 'added' => 'Added', 'changed' => 'Changed', 'fixed' => 'Fixed', 'deprecated' => 'Deprecated', 'breaking' => 'Breaking'];
?>
<section class="band cbs-gv" id="governance" aria-labelledby="cbs-gv-t">
  <div class="wrap">
    <header class="cbs-head cbs-head--split" data-rv>
      <p class="cbs-head__path"><b>07</b><i>/</i>governance<i>/</i>releases</p>
      <h2 class="cbs-head__h" id="cbs-gv-t"><span class="g">Who changes what,</span> and how everyone finds out.</h2>
      <p class="lead cbs-head__lead">A system without governance drifts back into a folder of files. Changes are proposed, reviewed and released with a version number that says how much they break, and every team chooses how closely it follows.</p>
    </header>

    <div class="cbs-gv__grid">
      <aside class="cbs-gv__side">
        <!-- PLACEHOLDER: reference photo (Unsplash) — confirm before launch -->
        <figure class="cbs-photo cbs-gv__photo">
          <img src="<?= xe_url('assets/imgs/brand/brand-systems/governance-review.jpg') ?>" alt="Two colleagues reviewing work together on a desktop monitor" width="1200" height="800" loading="lazy" decoding="async">
          <figcaption><span>Release review · maintainers</span><span>2.5.0-rc.1</span></figcaption>
        </figure>

        <div class="cbs-gv__perm bdh-scroll-x" tabindex="0" role="region" aria-label="Who can change what">
          <table>
            <caption class="cbs-gv__cap">Who can change what</caption>
            <thead><tr><th scope="col">Role</th><th scope="col">Patch</th><th scope="col">Minor</th><th scope="col">Major</th></tr></thead>
            <tbody>
              <?php foreach ($cbs_gv_roles as $cbs_rl): ?>
                <tr>
                  <th scope="row"><b><?= e($cbs_rl[0]) ?></b><span><?= e($cbs_rl[1]) ?></span></th>
                  <?php for ($cbs_c = 2; $cbs_c <= 4; $cbs_c++): ?><td><span class="cbs-gv__p cbs-gv__p--<?= e(str_replace(' ', '-', $cbs_rl[$cbs_c] === '—' ? 'none' : $cbs_rl[$cbs_c])) ?>"><?= e($cbs_rl[$cbs_c]) ?></span></td><?php endfor; ?>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <p class="cbs-gv__semver"><b>MAJOR</b> breaks something · <b>MINOR</b> adds · <b>PATCH</b> fixes</p>
      </aside>

      <div class="cbs-gv__log" data-cbs-gv>
        <div class="cbs-gv__ctl">
          <div class="cbs-gv__chips" role="group" aria-label="Filter release notes">
            <?php foreach ($cbs_gv_types as $cbs_tk => $cbs_tl): ?>
              <button type="button" class="cbs-gv__chip" aria-pressed="<?= $cbs_tk === 'all' ? 'true' : 'false' ?>" data-cbs-gv-filter="<?= e($cbs_tk) ?>"><?= e($cbs_tl) ?></button>
            <?php endforeach; ?>
          </div>
          <fieldset class="cbs-gv__watch">
            <legend>Watch releases</legend>
            <label><input type="radio" name="cbs-gv-level" value="major"> Major only</label>
            <label><input type="radio" name="cbs-gv-level" value="minor" checked> Minor and up</label>
            <label><input type="radio" name="cbs-gv-level" value="patch"> Everything</label>
          </fieldset>
        </div>
        <p class="cbs-gv__live" role="status" aria-live="polite" data-cbs-gv-status>Watching minor and major releases · 4 of 6 shown would notify you.</p>

        <ol class="cbs-gv__list">
          <?php foreach ($cbs_gv_log as $cbs_li => $cbs_l): ?>
            <li class="cbs-gv__item cbs-gv__item--<?= e($cbs_l[1]) ?><?= $cbs_l[5] ? ' is-rc' : '' ?>" data-cbs-gv-item data-level="<?= e($cbs_l[1]) ?>">
              <div class="cbs-gv__when">
                <span class="cbs-gv__ver">v<?= e($cbs_l[0]) ?></span>
                <span class="cbs-gv__lvl"><?= e($cbs_l[1]) ?></span>
                <span class="cbs-gv__bell" aria-hidden="true" title="You would be notified"></span>
              </div>
              <div class="cbs-gv__what">
                <p class="cbs-gv__date"<?= $cbs_l[5] ? ' data-cbs-gv-rc' : '' ?>><?= e($cbs_l[2]) ?></p>
                <h3 class="cbs-gv__h"><?= e($cbs_l[3]) ?></h3>
                <ul class="cbs-gv__notes">
                  <?php foreach ($cbs_l[4] as $cbs_n): ?>
                    <li data-type="<?= e($cbs_n[0]) ?>"><span class="cbs-gv__b cbs-gv__b--<?= e($cbs_n[0]) ?>"><?= e(ucfirst($cbs_n[0])) ?></span><code><?= e($cbs_n[1]) ?></code></li>
                  <?php endforeach; ?>
                </ul>
                <?php if ($cbs_l[5]): ?>
                  <ol class="cbs-gv__steps" aria-label="Release steps" data-cbs-gv-steps>
                    <li class="is-done">Proposed</li><li class="is-done">Agent checks · 2 contrast flags</li><li class="is-now">Maintainer review</li><li>System owner</li><li>Released</li>
                  </ol>
                <?php endif; ?>
              </div>
            </li>
          <?php endforeach; ?>
        </ol>
        <p class="cbs-gv__empty" hidden data-cbs-gv-empty>No notes of that type in these releases.</p>
      </div>
    </div>
  </div>
</section>
