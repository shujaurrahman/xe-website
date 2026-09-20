<?php /* DRAFT COPY — review before launch */
/* Outcomes — the three engagement outcomes from $CAP, each tied to a figure that appears elsewhere
   on this page and linked to it, then six measures an engineering leader already tracks, each drawn
   as a target band on its own scale. Two of the six are DORA measures — lead time for changes and
   change failure rate — and both are worded on DORA's own definitions. Every figure is a target
   agreed per engagement, not a claimed result: see the PLACEHOLDER above the rows. */
$ttw_oc_top = $CAP['outcomes'] ?? [];
$ttw_oc_ico = ['bolt', 'gauge', 'sync'];
/* Each outcome card is tied to a figure that exists elsewhere on this page, and links to it.
   [icon, figure, what the figure is, link text, section id] */
$ttw_oc_ev = [
    ['2–4 weeks', 'typical start, with a first merged pull request targeted for day 5', 'See the thirty-day track', 'onboarding'],
    ['97%',       'sprint predictability in the example report you receive every fortnight', 'See the sprint report', 'governance'],
    ['30–90 days','notice by model, with a replacement target of 10 working days', 'Compare the four models', 'models'],
];
/* [name, definition, scale-min label, scale-max label, band start %, band end %, marker %,
    target figure, target unit, direction, how it is measured] */
$ttw_oc = [
    ['Time to first merged pull request',
        'From contract signature to an engineer’s first change reviewed, approved and merged in your repository — not their first commit on a branch.',
        '0 days', '20 days', 0, 25, 25, '≤ 5', 'working days', 'Lower is better', 'Per engineer, from day 0'],
    ['Sprint predictability',
        'What the squad delivered against what it committed to at planning, averaged across three sprints so one bad week does not read as a trend.',
        '50%', '110%', 58.3, 83.3, 58.3, '85–100', 'per cent delivered', 'Inside the band is better', 'Per squad, from sprint three'],
    ['Escaped defects',
        'Defects found in production within thirty days of a release that trace back to our commits. Counted by your own triage, not by ours.',
        '0', '6 per sprint', 0, 16.7, 16.7, '≤ 1', 'per squad, per sprint', 'Lower is better', 'From your issue tracker'],
    ['Lead time for changes',
        'The DORA measure, on DORA’s own definition: median elapsed time from a change being committed to it running in production. It depends on your release process as much as on the engineer, so it is baselined before it is targeted. The AI-native section states the same target.',
        '0 days', '7 days', 0, 28.6, 28.6, '≤ 2', 'working days', 'Lower is better', 'From your pipeline'],
    ['Engineer retention on your account',
        'The share of engineers still on your account twelve months after they started, excluding the changes you asked for. Continuity is what keeps context in the team.',
        '50%', '100%', 70, 100, 70, '≥ 85', 'per cent at 12 months', 'Higher is better', 'Rolling twelve months'],
    ['Change failure rate',
        'The DORA measure: the share of deployments to production that cause a degradation needing a fix, a rollback or a patch. It is not a count of defects — an escaped defect that never degraded a release does not appear here.',
        '0%', '40%', 0, 37.5, 37.5, '≤ 15', 'per cent of deployments', 'Lower is better', 'From your deploy and incident records'],
];
$ttw_oc_dora = [
    ['Deployment frequency', 'How often you release to production'],
    ['Lead time for changes', 'Commit to production, median'],
    ['Change failure rate', 'Releases needing a fix or rollback'],
    ['Time to restore service', 'Degraded to healthy again'],
];
?>
<section class="band ttw-out" id="outcomes" aria-labelledby="outcomes-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Outcomes</p>
        <h2 class="h2" id="outcomes-t"><span class="g">Measures that matter</span> to an engineering leader.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Extra people are easy to count and hard to justify. These are the six measures we agree up front, baseline in the first weeks, and report every month for as long as the engagement runs.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm the typical start window, the notice periods and the replacement target before launch -->
    <ul class="ttw-out__top" role="list" data-bdh-stagger>
      <?php foreach ($ttw_oc_top as $ttw_oc_n => $ttw_oc_t): $ttw_oc_e = $ttw_oc_ev[$ttw_oc_n] ?? null; ?>
        <li class="ttw-card ttw-out__tc" data-rv data-rv-s>
          <span class="ttw-out__tic" aria-hidden="true"><?= xt_icon($ttw_oc_ico[$ttw_oc_n] ?? 'dot', ['size' => 20]) ?></span>
          <h3 class="bdh-t ttw-out__th"><?= e($ttw_oc_t[0]) ?></h3>
          <p class="bdh-d"><?= e($ttw_oc_t[1]) ?></p>
          <?php if ($ttw_oc_e): ?>
            <p class="ttw-out__tf"><span class="ttw-fig"><?= e($ttw_oc_e[0]) ?></span><span class="ttw-out__tu"><?= e($ttw_oc_e[1]) ?></span></p>
            <p class="ttw-out__tl"><a class="tl" href="#<?= e($ttw_oc_e[3]) ?>"><?= e($ttw_oc_e[2]) ?> <span class="i" aria-hidden="true">›</span></a></p>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>

    <!-- PLACEHOLDER: confirm the target ranges below with delivery before launch; they are targets, not measured results -->
    <div class="ttw-out__wrap" data-rv>
      <p class="ttw-out__cap">
        <span class="ttw-ill">Targets</span>
        <span class="ttw-out__capt">Each row shows the range we work to, drawn on that measure’s own scale. Baselines are taken from your tooling in the first two weeks, and the target is confirmed in writing before it is reported against.</span>
      </p>
      <p class="bdh-sr">Each measure below is shown as a horizontal scale with the target range marked on it. The scale ends and the target value are given in text beside every row, so no information is carried by the drawing alone.</p>

      <ol class="ttw-out__rows" data-bdh-in data-ttw-arm data-bdh-stagger>
        <?php foreach ($ttw_oc as $ttw_oc_i => $ttw_oc_r): ?>
          <li class="ttw-out__r" style="--s:<?= e((string) $ttw_oc_r[4]) ?>%;--e:<?= e((string) $ttw_oc_r[5]) ?>%;--m:<?= e((string) $ttw_oc_r[6]) ?>%">
            <div class="ttw-out__lft">
              <p class="ttw-out__ix"><?= str_pad((string) ($ttw_oc_i + 1), 2, '0', STR_PAD_LEFT) ?></p>
              <h3 class="ttw-out__h"><?= e($ttw_oc_r[0]) ?></h3>
              <p class="ttw-out__d"><?= e($ttw_oc_r[1]) ?></p>
            </div>

            <div class="ttw-out__mid">
              <div class="ttw-out__bar" aria-hidden="true">
                <span class="ttw-out__track"></span>
                <?php foreach ([25, 50, 75] as $ttw_oc_tk): ?>
                  <i class="ttw-out__tick" style="--p:<?= (int) $ttw_oc_tk ?>%"></i>
                <?php endforeach; ?>
                <span class="ttw-out__band"></span>
                <span class="ttw-out__mk"></span>
              </div>
              <p class="ttw-out__scale" aria-hidden="true">
                <span><?= e($ttw_oc_r[2]) ?></span>
                <span class="ttw-out__mez"><?= e($ttw_oc_r[10]) ?></span>
                <span><?= e($ttw_oc_r[3]) ?></span>
              </p>
            </div>

            <div class="ttw-out__rgt">
              <p class="ttw-out__tg"><span class="ttw-fig"><?= e($ttw_oc_r[7]) ?></span><span class="ttw-out__u"><?= e($ttw_oc_r[8]) ?></span></p>
              <p class="ttw-out__dir"><span class="bdh-tag"><?= e($ttw_oc_r[9]) ?></span></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
    </div>

    <aside class="ttw-out__dora" data-rv>
      <div class="ttw-out__badge"><?= xt_badge('dora-metrics') ?></div>
      <div class="ttw-out__dx">
        <h3 class="bdh-t">Two of the six are DORA measures</h3>
        <p class="bdh-d">DORA describes delivery performance with four measures. We report all four where we own a pipeline. Where you own the pipeline we report the two that are ours to influence — lead time for changes and change failure rate — and treat the other two as yours.</p>
        <dl class="ttw-out__dl">
          <?php foreach ($ttw_oc_dora as $ttw_oc_d): ?>
            <div><dt><?= e($ttw_oc_d[0]) ?></dt><dd><?= e($ttw_oc_d[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </div>
    </aside>

    <p class="ttw-out__note">A measure nobody acts on is a slide. Each of these has an owner and a named review in the monthly service review. <a class="tl" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Agree the measures for your team <span class="i" aria-hidden="true">›</span></a></p>

  </div>
</section>
