<?php /* DRAFT COPY — review before launch */
/* Deliver — what an engagement actually hands over, as a manifest table: the artefact, the format
   it arrives in, when it lands, and which of the four engagement models includes it. Core rows come
   from $CAP['deliver']; the profile, delivery-manager and transfer rows are the page's own.
   All timings are typical and carry a PLACEHOLDER.
   Row shape: [icon, deliverable, format, when, when-short, description, [included per model]].
   The deliverable column stays put while the model columns scroll sideways, each model column
   carries how many of the nine artefacts it includes, and deliver.js lights a whole column on
   hover or focus so a model can be read down the page. */
$ttw_dl_c  = $CAP['deliver'] ?? [];
$ttw_dl_mx = ['Individual', 'Pod', 'Squad', 'BOT'];
$ttw_dl = [
    ['doc', 'Vetted candidate profiles', 'Profiles + scorecards', 'Within 5 working days of the brief', 'D+5',
        'Two to four profiles per role, each with the assessment record behind it, so you shortlist on evidence rather than on a CV.',
        [1, 1, 1, 1]],
    ['users', $ttw_dl_c[0][0] ?? 'Vetted engineers or a delivery squad', $ttw_dl_c[0][1] ?? 'Named people', 'On the agreed start date', 'Start date',
        'Named engineers, not a resource pool. The same people stay on your account for the term unless you ask for a change.',
        [1, 1, 1, 1]],
    ['clipboard-check', $ttw_dl_c[1][0] ?? 'Role profiles & assessment results', $ttw_dl_c[1][1] ?? 'Scorecards', 'Before you interview', 'Pre-interview',
        'The brief we recruited against and the scored result of every stage: live technical interview, pairing on a real problem, system design, AI-tooling and secure-coding practice, communication and references.',
        [1, 1, 1, 1]],
    ['headset', 'A named delivery manager', 'Named contact', 'From kickoff', 'Kick-off',
        'One person accountable for fit, quality and escalation, reachable inside your agreed overlap hours and named in the contract.',
        [0, 1, 1, 1]],
    ['check', $ttw_dl_c[2][0] ?? 'Onboarding plan', $ttw_dl_c[2][1] ?? 'Checklist', 'Signed off on day 0', 'Day 0',
        'Access, environment, codebase walkthrough and first task mapped day by day, against a first merged pull request in about a week.',
        [1, 1, 1, 1]],
    ['dashboard', $ttw_dl_c[3][0] ?? 'Delivery metrics', $ttw_dl_c[3][1] ?? 'Dashboard', 'From the first full sprint', 'Sprint 1',
        'Throughput, commitments against delivered work, review turnaround and the four DORA measures: deployment frequency, lead time for changes, change failure rate and time to restore service.',
        [0, 1, 1, 1]],
    ['chart', $ttw_dl_c[4][0] ?? 'Monthly engagement review', $ttw_dl_c[4][1] ?? 'Report', 'Monthly, in your calendar', 'Monthly',
        'Quality, fit, risk and next quarter’s capacity, reviewed with your engineering lead and minuted so decisions are written down.',
        [1, 1, 1, 1]],
    ['layers', $ttw_dl_c[5][0] ?? 'Knowledge transfer & handover plan', $ttw_dl_c[5][1] ?? 'Docs', 'Written from sprint 1, updated each sprint', 'Sprint 1+',
        'Architecture decisions, runbooks and environment notes kept in your own wiki as the work happens, so understanding does not leave with an engineer.',
        [1, 1, 1, 1]],
    ['handshake', 'Transfer and conversion terms', 'Contract schedule', 'Signed at the start, run at transfer', 'Start / transfer',
        'For build–operate–transfer: the conversion mechanism, notice, asset list and the order in which people, accounts and documentation move to your entity.',
        [0, 0, 0, 1]],
];
/* How many of the artefacts each model includes — printed in its column head. */
$ttw_dl_inc = array_map(
    fn (int $j): int => array_sum(array_map(fn ($r) => (int) $r[6][$j], $ttw_dl)),
    array_keys($ttw_dl_mx)
);
$ttw_dl_tools   = ['github', 'jira', 'linear', 'confluence', 'figma'];
$ttw_dl_cadence = [
    ['Weekly', 'Written status note — progress, blockers, decisions needed'],
    ['Fortnightly', 'Sprint review and demo of working software, recorded'],
    ['Monthly', 'Service review: metrics pack, quality, fit and risk'],
    ['Quarterly', 'Capacity and skills plan against your roadmap'],
];
?>
<section class="band band--alt ttw-dlv" id="deliver" aria-labelledby="deliver-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>What you get</p>
        <h2 class="h2" id="deliver-t"><span class="g">People are the deliverable,</span> but they are not the only one.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Every engagement hands over the same artefacts, whatever its size. The table sets out what arrives, in what form, when, and which models include it.</p>
      </div>
    </header>

    <!-- PLACEHOLDER: confirm delivery timings (profiles in five working days, reporting cadence) before launch -->
    <div class="ttw-win ttw-dlv__win" data-rv data-ttw-arm>
      <p class="ttw-win__bar">
        <span class="ttw-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="ttw-win__path">engagement / <b>deliverables.manifest</b></span>
        <span class="ttw-win__end">
          <span class="ttw-ill">Typical</span>
          <span class="ttw-ro ttw-dlv__count"><?= count($ttw_dl) ?> artefacts</span>
        </span>
      </p>

      <div class="ttw-dlv__scroll" tabindex="0" role="region" aria-label="Deliverables by engagement model">
        <table class="ttw-dlv__tbl" data-ttw-dlv>
          <caption class="bdh-sr">Deliverables in a Tech Workforce engagement, with the format, when each one lands, and whether it is included for individual specialists, pods, delivery squads and build–operate–transfer.</caption>
          <thead>
            <tr>
              <th scope="col" class="ttw-dlv__ch">Deliverable</th>
              <th scope="col">Format</th>
              <th scope="col">When it lands</th>
              <?php foreach ($ttw_dl_mx as $ttw_dl_j => $ttw_dl_m): ?>
                <th scope="col" class="ttw-dlv__cm" data-ttw-col="<?= (int) $ttw_dl_j ?>">
                  <?= e($ttw_dl_m) ?>
                  <span class="ttw-dlv__cn"><?= (int) $ttw_dl_inc[$ttw_dl_j] ?> of <?= count($ttw_dl) ?></span>
                </th>
              <?php endforeach; ?>
            </tr>
          </thead>
          <tbody data-bdh-in data-bdh-stagger>
            <?php foreach ($ttw_dl as $ttw_dl_n => $ttw_dl_it): ?>
              <tr class="ttw-dlv__row">
                <th scope="row" class="ttw-dlv__rh">
                  <span class="ttw-dlv__rw">
                    <span class="ttw-dlv__ix" aria-hidden="true"><?= str_pad((string) ($ttw_dl_n + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="ttw-dlv__ic" aria-hidden="true"><?= xt_icon($ttw_dl_it[0], ['size' => 18]) ?></span>
                    <span class="ttw-dlv__tx">
                      <b class="ttw-dlv__h"><?= e($ttw_dl_it[1]) ?></b>
                      <span class="ttw-dlv__d"><?= e($ttw_dl_it[5]) ?></span>
                    </span>
                  </span>
                </th>
                <td class="ttw-dlv__fm"><span class="bdh-tag"><?= e($ttw_dl_it[2]) ?></span></td>
                <td class="ttw-dlv__wh"><span class="ttw-dlv__when"><?= e($ttw_dl_it[4]) ?></span><span class="ttw-dlv__whl"><?= e($ttw_dl_it[3]) ?></span></td>
                <?php foreach ($ttw_dl_it[6] as $ttw_dl_j => $ttw_dl_v): ?>
                  <td class="ttw-dlv__m<?= $ttw_dl_v ? '' : ' is-off' ?>" data-ttw-col="<?= (int) $ttw_dl_j ?>">
                    <?php if ($ttw_dl_v): ?>
                      <span class="ttw-tick ttw-dlv__tk" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 6.4 4.6 9 10 3"/></svg></span>
                      <span class="bdh-sr">Included for <?= e($ttw_dl_mx[$ttw_dl_j]) ?></span>
                    <?php else: ?>
                      <span class="ttw-dlv__no" aria-hidden="true">—</span>
                      <span class="bdh-sr">Not applicable for <?= e($ttw_dl_mx[$ttw_dl_j]) ?></span>
                    <?php endif; ?>
                  </td>
                <?php endforeach; ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
    <p class="ttw-dlv__hint">Scroll the table sideways to read all four models.</p>

    <div class="ttw-dlv__strip">
      <article class="ttw-card ttw-dlv__c" data-rv data-rv-s>
        <h3 class="bdh-t">Everything lands in your tools</h3>
        <p class="bdh-d">Nothing is delivered as an attachment to an email. Profiles, plans, tickets, documentation and metrics live in your own tenancy, under your retention and access rules, so the record stays with you when the engagement ends.</p>
        <?= xt_stack($ttw_dl_tools, ['variant' => 'chips', 'size' => 18, 'label' => 'Tools deliverables are handed over in', 'class' => 'ttw-dlv__stack']) ?>
        <p class="ttw-dlv__fine">Where you use a different tracker or wiki, we work in that one instead. We do not ask you to adopt ours.</p>
      </article>

      <article class="ttw-card ttw-dlv__c" data-rv data-rv-s>
        <h3 class="bdh-t">The reporting rhythm</h3>
        <p class="bdh-d">Reporting is part of the engagement, not an extra. Each line below is scheduled at kickoff and owned by the delivery manager.</p>
        <dl class="ttw-dlv__cad">
          <?php foreach ($ttw_dl_cadence as $ttw_dl_cd): ?>
            <div><dt><?= e($ttw_dl_cd[0]) ?></dt><dd><?= e($ttw_dl_cd[1]) ?></dd></div>
          <?php endforeach; ?>
        </dl>
      </article>
    </div>

    <p class="ttw-dlv__note"><span class="ttw-ill">Illustrative</span> Timings above are typical and are fixed per engagement in the statement of work. <a class="tl" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Ask for a sample engagement pack <span class="i" aria-hidden="true">›</span></a></p>

  </div>
</section>
