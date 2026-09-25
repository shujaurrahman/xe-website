<?php /* DRAFT COPY — review before launch */
/* Sector Console — SIGNATURE. Two axes, not one: choose a sector, then choose where the engagement
   starts, and the console assembles a draft brief — the rules that switch on, the disciplines in the
   order we would bring them, the systems it touches, the number it moves and what it unlocks next.
   Every combination (six sectors × three entry points) is in the markup, so the <noscript> rule below
   stacks all of them and the section is complete with JavaScript off. console.js adds the roving
   radiogroup, the tab behaviour, the typed brief lines and an autoplay that stops on first interaction.
   PLACEHOLDER: every length below is a typical range for a programme of that shape, not a quote. */
$con_lvl  = [3 => 'Leads', 2 => 'Core', 1 => 'Supports'];
$con_verd = ['Applies' => 'y', 'Not in scope' => 'n'];
$con_vcls = function (string $con_v) use ($con_verd): string { return $con_verd[$con_v] ?? 'c'; };
$con_url  = fn (string $con_d, string $con_c): string => xe_url('services/' . $con_d . '/' . $con_c . '.php');
/* the brief sheet: nine numbered lines, the first five fixed by the sector and the rest by the entry point */
$con_sheet = function (array $con_s, array $con_e) use ($ind_disc, $con_lvl): array {
    $con_mix = $con_s['mix'];
    arsort($con_mix);
    $con_dl = [];
    foreach ($con_mix as $con_slug => $con_w) {
        if ($con_w < 2) continue;
        $con_dl[] = $ind_disc[$con_slug]['n'] . ' ' . $ind_disc[$con_slug]['name'] . ' (' . strtolower($con_lvl[$con_w]) . ')';
    }
    $con_rules = [];
    foreach ($con_s['scope'] as $con_r) {
        $con_st = xt_standard($con_r[0]);
        if ($con_r[1] === 'Not in scope') continue;
        $con_rules[] = $con_st ? $con_st['code'] : $con_r[0];
    }
    $con_sysline = [];
    foreach (array_slice($con_s['stack'], 0, 4) as $con_t) { $con_sysline[] = svc_tech_name($con_t); }
    return [
        ['01', 'sector',      $con_s['name']],
        ['02', 'entry point', $con_e[0]],
        ['03', 'why here',    $con_e[1]],
        ['04', 'typical',     $con_e[2] . ' · scoped with your team before it starts'],
        ['05', 'disciplines', implode('  ·  ', $con_dl)],
        ['06', 'rules on',    implode('  ·  ', $con_rules)],
        ['07', 'systems',     implode('  ·  ', $con_sysline) . ' …'],
        ['08', 'we measure',  $con_s['kpi'] . ' — ' . rtrim($con_s['kpi_def'], '.')],
        ['09', 'unlocks',     $con_e[3]],
    ];
};
?>
<noscript><style>
  .ind-con__sectors,.ind-con__hint,.ind-con__tabs,.ind-con__bar .ind-live{display:none}
  .ind-con__panes,.ind-con__epanes{display:grid;gap:clamp(28px,4vw,56px)}
  .ind-con__panes>.bdh-pane,.ind-con__epanes>.bdh-pane{grid-area:auto;opacity:1;visibility:visible;transform:none}
  .ind-con__epane{border-top:1px solid var(--line-2);padding-top:clamp(20px,2.5vw,32px)}
</style></noscript>
<section class="band ind-con" id="console" aria-labelledby="console-t">
  <div class="wrap">
    <div class="bdh-head bdh-head--row" data-rv>
      <div>
        <p class="lbl lbl--blue"><span class="dot"></span>Sector Console</p>
        <h2 class="h2" id="console-t"><span class="g">Pick a sector and a starting point.</span> Read the brief it writes.</h2>
      </div>
      <div>
        <p class="lead">Two choices, one draft brief. The console shows which rules switch on, which disciplines lead, what the work touches, the number it is judged on and what it opens up next.</p>
        <p class="ind-note">A draft brief, not a proposal. Lengths are typical ranges for a programme of that shape; everything is scoped with your team before it starts.</p>
      </div>
    </div>

    <div class="bdh-ui ind-con__app" data-rv data-rv-d="60" data-bdh-live>
      <div class="bdh-ui__bar ind-con__bar">
        <span class="bdh-ui__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="ind-con__title">sector-console <i aria-hidden="true">/</i> your-company <i aria-hidden="true">/</i> draft-brief</span>
        <span class="ind-live"><i class="bdh-pulse" aria-hidden="true"></i><span class="ind-con__stxt">Brief ready</span></span>
        <span class="bdh-ill">Typical ranges</span>
      </div>

      <div class="ind-con__sectors" role="radiogroup" aria-label="Sector">
        <?php foreach ($IND as $con_i => $con_s): ?>
          <button class="ind-con__sector" type="button" role="radio" aria-checked="<?= $con_i ? 'false' : 'true' ?>" tabindex="<?= $con_i ? '-1' : '0' ?>" data-sector="<?= $con_i ?>">
            <span class="ind-con__sn"><?= e($con_s['n']) ?></span>
            <span class="ind-con__snm"><?= e($con_s['name']) ?></span>
            <span class="ind-con__skpi"><?= e($con_s['kpi']) ?></span>
          </button>
        <?php endforeach; ?>
      </div>
      <p class="ind-con__hint" aria-hidden="true"><span class="ind-kbd">←</span><span class="ind-kbd">→</span> sector<span class="ind-con__hsep">·</span><span class="ind-kbd">Tab</span> then <span class="ind-kbd">←</span><span class="ind-kbd">→</span> starting point</p>

      <p class="bdh-sr ind-con__live" aria-live="polite">Brief: <?= e($IND[0]['name']) ?> · <?= e($IND[0]['entry'][0][0]) ?> · <?= e($IND[0]['entry'][0][2]) ?> typical.</p>

      <div class="ind-con__panes bdh-panes">
        <?php foreach ($IND as $con_i => $con_s):
            $con_mix = $con_s['mix'];
            arsort($con_mix); ?>
          <div class="bdh-pane ind-con__pane<?= $con_i ? '' : ' is-on' ?>" data-sector="<?= $con_i ?>">
            <div class="ind-con__grid">

              <div class="ind-con__side">
                <!-- PLACEHOLDER: reference photograph (Unsplash) — replace with commissioned/own imagery before launch -->
                <figure class="bdh-img bdh-img--r43 ind-con__img">
                  <img src="<?= e($BASE) ?>assets/imgs/industries/<?= e($con_s['img']) ?>" alt="" loading="lazy" decoding="async">
                  <span class="ind-con__chip bdh-ro" aria-hidden="true"><?= e($con_s['n']) ?> · <?= e($con_s['short']) ?></span>
                </figure>

                <div class="ind-con__tray">
                  <p class="ind-k">Rules that switch on</p>
                  <ul class="ind-con__scope">
                    <?php foreach ($con_s['scope'] as $con_r): $con_st = xt_standard($con_r[0]); ?>
                      <li>
                        <span class="ind-con__sc"><?= e($con_st ? $con_st['code'] : $con_r[0]) ?></span>
                        <span class="ind-scope ind-scope--<?= e($con_vcls($con_r[1])) ?>"><?= e($con_r[1]) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                  <div class="ind-con__badges"><?php foreach ($con_s['badges'] as $con_b) echo xt_badge($con_b, ['variant' => 'chip']); ?></div>
                </div>

                <div class="ind-con__ladder">
                  <p class="ind-k">Disciplines, in the order we bring them</p>
                  <ol>
                    <?php $con_k = 0; foreach ($con_mix as $con_slug => $con_w): $con_dd = $ind_disc[$con_slug]; $con_k++; ?>
                      <li>
                        <span class="ind-con__ln"><?= str_pad((string) $con_k, 2, '0', STR_PAD_LEFT) ?></span>
                        <a href="<?= xe_discipline_url($con_dd) ?>"><?= e($con_dd['name']) ?></a>
                        <span class="ind-meter ind-meter--sm" data-v="<?= $con_w ?>" aria-hidden="true"><i></i><i></i><i></i></span>
                        <span class="ind-con__lv"><?= e($con_lvl[$con_w]) ?></span>
                      </li>
                    <?php endforeach; ?>
                  </ol>
                </div>
              </div>

              <div class="ind-con__main">
                <div class="ind-con__sh">
                  <h3><?= e($con_s['name']) ?></h3>
                  <p class="ind-con__line"><?= e($con_s['line']) ?></p>
                  <dl class="ind-con__facts">
                    <div><dt>Number we move</dt><dd><?= e($con_s['kpi']) ?></dd></div>
                    <div><dt>Reported</dt><dd><?= e($con_s['cadence']) ?></dd></div>
                    <div><dt>Starting points</dt><dd><?= count($con_s['entry']) ?></dd></div>
                  </dl>
                </div>

                <div class="ind-con__tabs" role="tablist" aria-label="Where a <?= e(strtolower($con_s['name'])) ?> engagement starts">
                  <?php foreach ($con_s['entry'] as $con_ei => $con_e): ?>
                    <button type="button" role="tab" id="con-<?= e($con_s['id']) ?>-t<?= $con_ei ?>" aria-controls="con-<?= e($con_s['id']) ?>-p<?= $con_ei ?>" aria-selected="<?= $con_ei ? 'false' : 'true' ?>" tabindex="<?= $con_ei ? '-1' : '0' ?>">
                      <span class="ind-con__tn"><?= str_pad((string) ($con_ei + 1), 2, '0', STR_PAD_LEFT) ?></span>
                      <span class="ind-con__tt"><?= e($con_e[0]) ?></span>
                      <span class="ind-con__tw"><?= e($con_e[2]) ?></span>
                    </button>
                  <?php endforeach; ?>
                </div>

                <div class="ind-con__epanes bdh-panes">
                  <?php foreach ($con_s['entry'] as $con_ei => $con_e): ?>
                    <div class="bdh-pane ind-con__epane<?= $con_ei ? '' : ' is-on' ?>" id="con-<?= e($con_s['id']) ?>-p<?= $con_ei ?>" role="tabpanel" aria-labelledby="con-<?= e($con_s['id']) ?>-t<?= $con_ei ?>" tabindex="0">

                      <!-- PLACEHOLDER: confirm typical lengths against real engagements before launch -->
                      <div class="ind-con__sheet ind-on-ink" data-sheet>
                        <p class="ind-con__shead" aria-hidden="true">
                          <span class="bdh-ui__dots"><i></i><i></i><i></i></span>
                          <span>brief.draft</span>
                          <span class="ind-con__sref">XE / <?= e($con_s['n']) ?>-<?= str_pad((string) ($con_ei + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        </p>
                        <dl class="ind-con__slines">
                          <?php foreach ($con_sheet($con_s, $con_e) as $con_ln): ?>
                            <div><dt><span aria-hidden="true"><?= e($con_ln[0]) ?></span> <?= e($con_ln[1]) ?></dt><dd><?= e($con_ln[2]) ?></dd></div>
                          <?php endforeach; ?>
                        </dl>
                      </div>

                      <div class="ind-con__cols">
                        <div class="ind-con__col">
                          <p class="ind-k">First 90 days · we measure</p>
                          <ol class="ind-con__meas">
                            <?php foreach ($con_s['measure'] as $con_mi => $con_m): ?>
                              <li><span aria-hidden="true"><?= str_pad((string) ($con_mi + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($con_m) ?></li>
                            <?php endforeach; ?>
                          </ol>
                        </div>
                        <div class="ind-con__col">
                          <p class="ind-k">What usually goes wrong here</p>
                          <p class="ind-con__risk"><?= e($con_s['risk']) ?></p>
                          <p class="ind-k ind-con__k2">Capability pages this starts with</p>
                          <div class="ind-capls">
                            <?php foreach ($con_e[4] as $con_p): $con_dd = $ind_disc[$con_p[0]];
                                $con_nm = '';
                                foreach ($con_dd['caps'] as $con_cap) { if (($con_cap[2] ?? '') === $con_p[1]) $con_nm = $con_cap[0]; } ?>
                              <a class="ind-capl" href="<?= $con_url($con_p[0], $con_p[1]) ?>"><b><?= e($con_dd['n']) ?></b><?= e($con_nm) ?><i aria-hidden="true">›</i></a>
                            <?php endforeach; ?>
                          </div>
                        </div>
                      </div>

                      <div class="ind-con__foot">
                        <p class="ind-con__unlock"><span class="ind-k">Then</span><?= e($con_e[3]) ?></p>
                        <a class="btn btn--ink btn--sm" href="<?= e(svc_contact_url([], null, $con_s['id'])) ?>">Scope this brief with us <span class="i" aria-hidden="true">›</span><span class="bdh-sr">: <?= e($con_e[0]) ?>, <?= e($con_s['name']) ?></span></a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="ind-note ind-con__note">The console shows how we would usually start, not what we would charge. Rules named here are the ones that shape the build; your legal and compliance teams keep sign-off, and we make their review faster.</p>
  </div>
</section>
