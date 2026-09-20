<?php /* DRAFT COPY — review before launch */
/* Overlap — where the squads work from, and how the working day lines up. The section carries no
   location photographs: the two used before showed London and an abstract façade, not New Delhi and
   Ludhiana, and a picture of the wrong city is worse than none on a page whose argument is "here is
   where your squad actually sits". The two studio cards state the facts instead, and the 24-hour IST
   strip — the stronger device — carries the section. Overlap arithmetic is from IST (UTC+5:30).
   Zone order matches #composer so the two can be read against each other. */
$ttw_ov_places = [
    ['01', 'New Delhi', 'Delivery and client-facing teams',
        'Delivery management, architecture and the client-facing side of every engagement. Interviews, kick-offs, service reviews and quarterly planning run from here, inside your contracted overlap hours.',
        [['Runs from here', 'Delivery management · architecture · client reviews'],
         ['Working week', 'Monday to Friday, or Sunday to Thursday for Gulf accounts'],
         ['Clock', 'IST, UTC+5:30 — no daylight saving, all year']]],
    ['02', 'Ludhiana', 'Engineering studio',
        'Engineering, QA and data work, on the same tooling, the same review bar and the same security controls as the Delhi team. Punjab keeps Indian Standard Time, so there is one clock across both studios.',
        [['Runs from here', 'Engineering · QA automation · data'],
         ['Working week', 'Monday to Friday'],
         ['Clock', 'IST, UTC+5:30 — the same shift as New Delhi']]],
];
/* label, sub, squad shift [start,end] IST, overlap [start,end] IST, readout */
$ttw_ov_rows = [
    ['United Kingdom', 'London · GMT (UTC+0)',      [10, 19],     [14.5, 19],   '4.5 h · 14:30–19:00 IST'],
    ['EU Central',     'Berlin · CET (UTC+1)',      [10, 19],     [13.5, 19],   '5.5 h · 13:30–19:00 IST'],
    ['Gulf',           'Dubai · GST (UTC+4)',       [10, 19],     [10.5, 19],   '8.5 h · 10:30–19:00 IST'],
    ['Singapore',      'Singapore · SGT (UTC+8)',   [10, 19],     [10, 15.5],   '5.5 h · 10:00–15:30 IST'],
    ['US East',        'New York · EST (UTC−5)',    [13.5, 22.5], [19.5, 22.5], '3 h · 19:30–22:30 IST, shifted shift'],
];
$ttw_ov_pct = function (array $s): string {
    return '--s:' . round($s[0] / 24 * 100, 4) . '%;--w:' . round(($s[1] - $s[0]) / 24 * 100, 4) . '%';
};
$ttw_ov_sus = [
    ['≤ 2', 'return trips per squad, per year', 'A kick-off and one delivery checkpoint. Anything beyond that is proposed with a reason and agreed with you.'],
    ['4 years', 'device refresh interval', 'Managed laptops are repaired and redeployed inside the interval rather than replaced on a cycle.'],
    ['SCI', 'reported per delivered sprint', 'Where you measure software carbon intensity we report our share on the Green Software Foundation form, ((E × I) + M) per R, with R defined as one delivered sprint.'],
];
?>
<section class="band band--alt ttw-ovl" id="overlap" aria-labelledby="overlap-t">
  <div class="wrap">

    <header class="ttw-head" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Where we work from</p>
        <h2 class="h2" id="overlap-t"><span class="g">New Delhi and Ludhiana,</span> inside your working day.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Squads work from India on Indian Standard Time, UTC+5:30. The overlap with your day is contracted, not hoped for, and a shifted shift is agreed in writing when your zone needs one.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm office locations, what each studio runs and the working weeks before launch -->
    <div class="ttw-ovl__places">
      <?php foreach ($ttw_ov_places as $ttw_ov_p): ?>
        <article class="ttw-card ttw-ovl__pl" data-rv data-rv-s>
          <p class="ttw-ovl__pk">
            <span class="ttw-ovl__pin"><?= xt_icon('pin', ['size' => 16]) ?></span><?= e($ttw_ov_p[2]) ?>
            <span class="ttw-ovl__pix"><?= e($ttw_ov_p[0]) ?></span>
          </p>
          <h3 class="bdh-t ttw-ovl__pn"><?= e($ttw_ov_p[1]) ?></h3>
          <p class="bdh-d ttw-ovl__pd"><?= e($ttw_ov_p[3]) ?></p>
          <dl class="ttw-ovl__pf">
            <?php foreach ($ttw_ov_p[4] as $ttw_ov_f): ?>
              <div><dt><?= e($ttw_ov_f[0]) ?></dt><dd><?= e($ttw_ov_f[1]) ?></dd></div>
            <?php endforeach; ?>
          </dl>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="ttw-ovl__strip" data-bdh-in data-ttw-arm>
      <p class="ttw-ovl__sh"><span class="ttw-lbl">Shared hours, on a 24-hour IST scale</span><span class="ttw-ro">Pale band: squad shift · Blue band: hours shared with you</span></p>
      <p class="ttw-ovl__ticks" aria-hidden="true"><span>00</span><span>06</span><span>12</span><span>18</span><span>24</span></p>
      <ul class="ttw-ovl__rows" role="list">
        <?php foreach ($ttw_ov_rows as $ttw_ov_i => $ttw_ov_r): ?>
          <li class="ttw-ovl__row" style="--i:<?= (int) $ttw_ov_i ?>">
            <span class="ttw-ovl__zn"><?= e($ttw_ov_r[0]) ?><span class="ttw-ovl__zs"><?= e($ttw_ov_r[1]) ?></span></span>
            <span class="ttw-ovl__track">
              <i class="ttw-ovl__shift" style="<?= e($ttw_ov_pct($ttw_ov_r[2])) ?>"></i>
              <i class="ttw-ovl__win" style="<?= e($ttw_ov_pct($ttw_ov_r[3])) ?>"></i>
            </span>
            <span class="ttw-ro ttw-ovl__rd"><?= e($ttw_ov_r[4]) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="ttw-ovl__note">Windows assume standard time in each zone. The UK and Central Europe gain an hour of overlap during their summer time; the Gulf and Singapore do not change. <!-- PLACEHOLDER: confirm contracted overlap hours per engagement before launch --></p>
    </div>

    <div class="ttw-ovl__sus ttw-card">
      <div class="ttw-ovl__st">
        <p class="ttw-ovl__si"><?= xt_icon('leaf', ['size' => 22]) ?></p>
        <h3 class="bdh-t">Remote-first, so the travel is deliberate</h3>
        <p class="bdh-d">Delivery runs remotely by default, and in-person time is planned by need — a kick-off, an architecture week, a launch — rather than by calendar. These are the targets we work to and report against, not measured results.</p>
      </div>
      <!-- PLACEHOLDER: confirm the travel target, the device refresh interval and whether SCI reporting can be offered before launch -->
      <dl class="ttw-ovl__sf">
        <?php foreach ($ttw_ov_sus as $ttw_ov_s): ?>
          <div>
            <dt><span class="ttw-fig"><?= e($ttw_ov_s[0]) ?></span><span class="ttw-ovl__su"><?= e($ttw_ov_s[1]) ?></span></dt>
            <dd><?= e($ttw_ov_s[2]) ?></dd>
          </div>
        <?php endforeach; ?>
      </dl>
    </div>

  </div>
</section>
