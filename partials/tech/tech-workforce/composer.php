<?php /* DRAFT COPY — review before launch */
/* Composer — the signature component. Pick a mission, adjust the roles, choose your time zone.
   The squad composition, sprint capacity, skill coverage, onboarding track and an indicative
   rate-card model all update live. Overlap arithmetic is from IST (UTC+5:30) and is stated per
   zone with the daylight-saving change noted. Illustrative figures, labelled as such.
   composer.js reads the JSON block below; the HTML is the finished state for mission 01.
   WITHOUT JAVASCRIPT the section is honest about itself: every control ships disabled, so nothing
   invites a click it cannot answer, all five time-zone panels are rendered in full rather than
   four of them hidden behind a dead button, and a note says so. composer.js enables the controls
   and collapses the zones to one on load. */

$ttw_cp_roles = [
    // key, name, skills, sprint points per engineer, rate-card units per engineer per month
    ['lead', 'Tech lead',            'Architecture · review · standards',     8,  1.40],
    ['fe',   'Frontend engineer',    'React · Next.js · TypeScript',          13, 1.00],
    ['be',   'Backend engineer',     'Node.js · Go · Python · APIs',          13, 1.00],
    ['mob',  'Mobile engineer',      'Flutter · Swift · Kotlin',              12, 1.05],
    ['ml',   'ML / AI engineer',     'RAG · evals · PyTorch',                 11, 1.30],
    ['data', 'Data engineer',        'Kafka · dbt · warehouses',              12, 1.15],
    ['qa',   'QA automation',        'Playwright · Cypress · k6',             11, 0.90],
    ['sre',  'DevOps / SRE',         'Kubernetes · Terraform · CI/CD',        10, 1.20],
    ['des',  'Product designer',     'Figma · design systems',                10, 0.95],
    ['dm',   'Delivery manager',     'Cadence · reporting · risk',            0,  0.80],
];

$ttw_cp_missions = [
    'mvp' => [
        'name' => 'Ship an MVP',
        'note' => 'A first release in production, with tests and a deployment pipeline behind it.',
        'squad' => ['lead' => 1, 'fe' => 2, 'be' => 2, 'qa' => 1, 'sre' => 1, 'des' => 1, 'dm' => 1],
        'cover' => [
            ['Architecture, code review and standards', 'lead', 1],
            ['Product interface in React and TypeScript', 'fe', 2],
            ['APIs, data model and integrations', 'be', 2],
            ['Automated tests before every release', 'qa', 1],
            ['Interface design and a working design system', 'des', 1],
            ['Production launch: environments, deploys, on-call', 'sre', 1],
            ['Cadence, reporting and risk', 'dm', 1],
        ],
    ],
    'legacy' => [
        'name' => 'Modernise a legacy app',
        'note' => 'Strangle the monolith service by service, with the old system still serving users.',
        'squad' => ['lead' => 1, 'be' => 3, 'fe' => 2, 'qa' => 1, 'sre' => 1, 'data' => 1, 'dm' => 1],
        'cover' => [
            ['Architecture and a strangler-fig migration plan', 'lead', 1],
            ['Service extraction and API work', 'be', 3],
            ['Interface rebuild without a big-bang release', 'fe', 2],
            ['A regression safety net before any refactor', 'qa', 1],
            ['Environments, CI/CD and rollback', 'sre', 1],
            ['Data migration and reconciliation', 'data', 1],
            ['Cadence, reporting and risk', 'dm', 1],
        ],
    ],
    'aiteam' => [
        'name' => 'Stand up an AI team',
        'note' => 'A first AI feature in production with evaluations, guardrails and a cost ceiling.',
        'squad' => ['lead' => 1, 'ml' => 2, 'data' => 1, 'be' => 1, 'sre' => 1, 'qa' => 1, 'dm' => 1],
        'cover' => [
            ['AI architecture and an evaluation strategy', 'lead', 1],
            ['Retrieval, prompting and model integration', 'ml', 2],
            ['Pipelines, embeddings and feature stores', 'data', 1],
            ['Application and API work around the model', 'be', 1],
            ['Inference infrastructure and cost control', 'sre', 1],
            ['Evaluations and red-teaming in CI', 'qa', 1],
            ['Cadence, reporting and risk', 'dm', 1],
        ],
    ],
    'qaauto' => [
        'name' => 'Scale test automation',
        'note' => 'Move from manual regression to suites that run on every pull request.',
        'squad' => ['lead' => 1, 'qa' => 3, 'sre' => 1, 'be' => 1, 'dm' => 1],
        'cover' => [
            ['Test strategy and a coverage plan', 'lead', 1],
            ['End-to-end, API and load suites', 'qa', 3],
            ['CI runners, parallelism and flake control', 'sre', 1],
            ['Test data and fixtures inside your services', 'be', 1],
            ['Cadence, reporting and risk', 'dm', 1],
        ],
    ],
];

/* Time zones, in the same order as #overlap so the two can be read against each other. Hours are
   local to the client zone across a 24-hour day; the squad's shift is the same IST shift converted
   into that zone. Overlap is the intersection of the two. Row: key, name, city and offset, the
   shift in IST, the client's own working day, the overlap, then the three 24-hour spans (client
   day, squad shift, overlap), the ceremonies, the daylight-saving note, and the squad's shift in
   the client's own clock. */
$ttw_cp_zones = [
    ['uk', 'United Kingdom', 'London · GMT (UTC+0)', '10:00–19:00 IST', '09:00–17:30', '4.5 h',
        [9, 17.5], [4.5, 13.5], [9, 13.5],
        [['Stand-up', 'daily', '09:30', '15:00'], ['Sprint planning', 'Monday', '10:00', '15:30'], ['Review &amp; demo', 'Friday', '12:00', '17:30']],
        'From late March to late October London runs on BST (UTC+1) and the shared window grows to 5.5 hours.',
        '04:30–13:30'],
    ['eu', 'EU Central', 'Berlin · CET (UTC+1)', '10:00–19:00 IST', '09:00–17:30', '5.5 h',
        [9, 17.5], [5.5, 14.5], [9, 14.5],
        [['Stand-up', 'daily', '09:30', '14:00'], ['Sprint planning', 'Monday', '10:00', '14:30'], ['Review &amp; demo', 'Friday', '13:00', '17:30']],
        'From late March to late October Central Europe runs on CEST (UTC+2) and the shared window grows to 6.5 hours.',
        '05:30–14:30'],
    ['gulf', 'Gulf', 'Dubai · GST (UTC+4)', '10:00–19:00 IST', '09:00–18:00', '8.5 h',
        [9, 18], [8.5, 17.5], [9, 17.5],
        [['Stand-up', 'daily', '09:30', '11:00'], ['Sprint planning', 'Sunday', '10:00', '11:30'], ['Review &amp; demo', 'Thursday', '15:00', '16:30']],
        'Neither zone observes daylight saving, so the window holds all year. Ceremonies follow the Sunday-to-Thursday working week.',
        '08:30–17:30'],
    ['sg', 'Singapore', 'Singapore · SGT (UTC+8)', '10:00–19:00 IST', '09:00–18:00', '5.5 h',
        [9, 18], [12.5, 21.5], [12.5, 18],
        [['Stand-up', 'daily', '13:00', '10:30'], ['Sprint planning', 'Monday', '14:00', '11:30'], ['Review &amp; demo', 'Friday', '16:30', '14:00']],
        'Neither zone observes daylight saving, so the window holds all year.',
        '12:30–21:30'],
    ['us', 'US East', 'New York · EST (UTC−5)', '13:30–22:30 IST', '09:00–17:30', '3 h',
        [9, 17.5], [3, 12], [9, 12],
        [['Stand-up', 'daily', '09:15', '19:45'], ['Sprint planning', 'Monday', '09:30', '20:00'], ['Review &amp; demo', 'Thursday', '11:00', '21:30']],
        'US East needs a shifted India day, agreed in the contract and rotated fairly. On EDT (UTC−4), late March to early November, the shared window is 4 hours.',
        '03:00–12:00'],
];

$ttw_cp_pct = function (array $span): string {
    $s = $span[0] / 24 * 100;
    $w = ($span[1] - $span[0]) / 24 * 100;
    return '--s:' . round($s, 4) . '%;--w:' . round($w, 4) . '%';
};

$ttw_cp_on = [
    ['Day 0', 'Contract, NDA and IP assignment signed'],
    ['Day 1', 'Accounts issued through your SSO, least privilege'],
    ['Day 2', 'Codebase walkthrough with your tech lead'],
    ['Day 3', 'Local environment running, tests green'],
    ['Day 5', 'First pull request merged'],
    ['Day 10', 'First sprint demo to your stakeholders'],
];

$ttw_cp_first = $ttw_cp_missions['mvp'];
$ttw_cp_head  = 0; $ttw_cp_pts = 0; $ttw_cp_units = 0.0;
foreach ($ttw_cp_roles as $ttw_cp_r) {
    $ttw_cp_n = $ttw_cp_first['squad'][$ttw_cp_r[0]] ?? 0;
    $ttw_cp_head += $ttw_cp_n;
    $ttw_cp_pts  += $ttw_cp_n * $ttw_cp_r[3];
    $ttw_cp_units += $ttw_cp_n * $ttw_cp_r[4];
}
$ttw_cp_hours = $ttw_cp_head * 65;

$ttw_cp_json = json_encode([
    'roles'    => array_map(fn ($r) => ['k' => $r[0], 'n' => $r[1], 'pts' => $r[3], 'u' => $r[4]], $ttw_cp_roles),
    'missions' => array_map(fn ($m) => ['name' => $m['name'], 'squad' => $m['squad'], 'cover' => $m['cover']], $ttw_cp_missions),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
?>
<section class="band band--ink ttw-cmp" id="composer" aria-labelledby="composer-t">
  <div class="wrap">

    <header class="ttw-head ttw-head--wide" data-rv>
      <div class="ttw-head__t">
        <p class="lbl lbl--blue"><span class="dot"></span>Squad composer</p>
        <h2 class="h2" id="composer-t"><span class="g">Build the squad</span> your roadmap needs.</h2>
      </div>
      <div class="ttw-head__l">
        <p class="lead">Start from a mission, adjust the roles, then pick your time zone to see the shared working window and where the ceremonies fall inside it. Capacity, skill coverage and an indicative rate-card model update as you go.</p>
      </div>
    </header>

    <div class="ttw-win ttw-win--ink ttw-cmp__win" data-ttw-cmp>
      <p class="ttw-win__bar">
        <span class="ttw-win__dots" aria-hidden="true"><i></i><i></i><i></i></span>
        <span class="ttw-win__path">squad-composer · <b>Your platform</b> · draft brief</span>
        <span class="ttw-win__end"><span class="ttw-ill">Illustrative</span></span>
      </p>

      <div class="ttw-cmp__body">

        <!-- ---------- controls ---------- -->
        <div class="ttw-cmp__ctl">
         <div class="ttw-cmp__ctlin">

          <p class="ttw-cmp__nojs">This composer needs JavaScript. Below is the “Ship an MVP” squad it opens with, and all five time-zone windows in full.</p>

          <fieldset class="ttw-cmp__set">
            <legend class="ttw-lbl">01 · Mission</legend>
            <div class="ttw-cmp__miss" role="radiogroup" aria-label="Mission" data-ttw-radio>
              <?php $ttw_cp_i = 0; foreach ($ttw_cp_missions as $ttw_cp_k => $ttw_cp_m): $ttw_cp_i++; $ttw_cp_sel = $ttw_cp_k === 'mvp'; ?>
                <button type="button" class="ttw-btn ttw-cmp__mb" role="radio" disabled
                        data-ttw-mission="<?= e($ttw_cp_k) ?>" aria-checked="<?= $ttw_cp_sel ? 'true' : 'false' ?>" tabindex="<?= $ttw_cp_sel ? '0' : '-1' ?>">
                  <span class="ttw-cmp__mn"><?= e(str_pad((string) $ttw_cp_i, 2, '0', STR_PAD_LEFT)) ?></span><?= e($ttw_cp_m['name']) ?>
                </button>
              <?php endforeach; ?>
            </div>
            <p class="ttw-cmp__mnote" data-ttw-mnote><?= e($ttw_cp_first['note']) ?></p>
          </fieldset>

          <fieldset class="ttw-cmp__set">
            <legend class="ttw-lbl">02 · Roles</legend>
            <ul class="ttw-cmp__roles" role="list">
              <?php foreach ($ttw_cp_roles as $ttw_cp_r): $ttw_cp_n = $ttw_cp_first['squad'][$ttw_cp_r[0]] ?? 0; ?>
                <li class="ttw-cmp__role<?= $ttw_cp_n ? ' is-on' : '' ?>" data-ttw-role="<?= e($ttw_cp_r[0]) ?>">
                  <span class="ttw-cmp__rn"><?= e($ttw_cp_r[1]) ?><span class="ttw-cmp__rs"><?= e($ttw_cp_r[2]) ?></span></span>
                  <span class="ttw-cmp__step">
                    <button type="button" class="ttw-cmp__b" data-ttw-step="-1" disabled aria-label="Remove one <?= e(strtolower($ttw_cp_r[1])) ?>"><span aria-hidden="true">−</span></button>
                    <span class="ttw-cmp__v" data-ttw-val><?= (int) $ttw_cp_n ?></span>
                    <button type="button" class="ttw-cmp__b" data-ttw-step="1" disabled aria-label="Add one <?= e(strtolower($ttw_cp_r[1])) ?>"><span aria-hidden="true">+</span></button>
                  </span>
                </li>
              <?php endforeach; ?>
            </ul>
          </fieldset>

          <fieldset class="ttw-cmp__set">
            <legend class="ttw-lbl">03 · Your time zone</legend>
            <div class="ttw-cmp__zb" role="radiogroup" aria-label="Your time zone" data-ttw-radio>
              <?php foreach ($ttw_cp_zones as $ttw_cp_z): $ttw_cp_zs = $ttw_cp_z[0] === 'uk'; ?>
                <button type="button" class="ttw-btn ttw-cmp__zbtn" role="radio" disabled
                        data-ttw-zbtn="<?= e($ttw_cp_z[0]) ?>" aria-checked="<?= $ttw_cp_zs ? 'true' : 'false' ?>" tabindex="<?= $ttw_cp_zs ? '0' : '-1' ?>"><?= e($ttw_cp_z[1]) ?></button>
              <?php endforeach; ?>
            </div>
          </fieldset>

         </div>
        </div>

        <!-- ---------- outputs ---------- -->
        <div class="ttw-cmp__out">

          <div class="ttw-cmp__panel">
            <p class="ttw-cmp__ph"><span class="ttw-lbl">Squad composition</span><span class="ttw-ro" data-ttw-headline><?= (int) $ttw_cp_head ?> people</span></p>
            <div class="ttw-cmp__bar" data-ttw-bar aria-hidden="true">
              <?php foreach ($ttw_cp_roles as $ttw_cp_r): $ttw_cp_n = $ttw_cp_first['squad'][$ttw_cp_r[0]] ?? 0; if (!$ttw_cp_n) continue; ?>
                <i data-r="<?= e($ttw_cp_r[0]) ?>" style="--n:<?= (int) $ttw_cp_n ?>"><b><?= (int) $ttw_cp_n ?></b></i>
              <?php endforeach; ?>
            </div>
            <ul class="ttw-cmp__key" role="list" data-ttw-key>
              <?php foreach ($ttw_cp_roles as $ttw_cp_r): $ttw_cp_n = $ttw_cp_first['squad'][$ttw_cp_r[0]] ?? 0; if (!$ttw_cp_n) continue; ?>
                <li><span class="ttw-chip"><span class="ttw-chip__d"></span><?= e($ttw_cp_r[1]) ?><span class="ttw-chip__s">× <?= (int) $ttw_cp_n ?></span></span></li>
              <?php endforeach; ?>
            </ul>
            <dl class="ttw-cmp__figs">
              <div><dt>Sprint capacity</dt><dd><span class="ttw-fig" data-ttw-pts><?= (int) $ttw_cp_pts ?></span> story points / 2-week sprint</dd></div>
              <div><dt>Engineering hours</dt><dd><span class="ttw-fig" data-ttw-hours><?= (int) $ttw_cp_hours ?></span> focus hours / sprint</dd></div>
              <div><dt>Indicative model</dt><dd><span class="ttw-fig" data-ttw-units><?= number_format($ttw_cp_units, 2) ?></span> rate-card units / month</dd></div>
            </dl>
            <!-- PLACEHOLDER: confirm the rate card, the points-per-engineer baseline and the focus-hour figure before launch -->
            <p class="ttw-cmp__fine">A rate-card unit is one standard monthly engineer rate agreed in your contract; capacity assumes 6.5 focus hours a day over ten working days, after ceremonies and review.</p>
          </div>

          <div class="ttw-cmp__panel">
            <p class="ttw-cmp__ph"><span class="ttw-lbl">Shared working window</span><span class="ttw-ro" data-ttw-ovh>Five zones, 3–8.5 h shared</span></p>
            <?php foreach ($ttw_cp_zones as $ttw_cp_z): ?>
              <div class="ttw-cmp__zone" data-ttw-zone="<?= e($ttw_cp_z[0]) ?>" data-ttw-ov="<?= e($ttw_cp_z[5]) ?>">
                <p class="ttw-cmp__zh"><b><?= e($ttw_cp_z[1]) ?></b><span><?= e($ttw_cp_z[2]) ?></span><span class="ttw-ro"><?= e($ttw_cp_z[5]) ?> shared</span></p>
                <div class="ttw-cmp__clock">
                  <p class="ttw-cmp__ticks" aria-hidden="true"><span>00</span><span>06</span><span>12</span><span>18</span><span>24</span></p>
                  <div class="ttw-cmp__tracks">
                    <span class="ttw-cmp__ov" style="<?= e($ttw_cp_pct($ttw_cp_z[8])) ?>" aria-hidden="true"></span>
                    <p class="ttw-cmp__tl"><span>Your working day</span><span class="ttw-ro"><?= e($ttw_cp_z[4]) ?></span></p>
                    <span class="ttw-cmp__track"><i class="ttw-cmp__band" style="<?= e($ttw_cp_pct($ttw_cp_z[6])) ?>"></i></span>
                    <p class="ttw-cmp__tl"><span>Squad shift, in your time</span><span class="ttw-ro"><?= e($ttw_cp_z[11]) ?> · <?= e($ttw_cp_z[3]) ?></span></p>
                    <span class="ttw-cmp__track"><i class="ttw-cmp__band ttw-cmp__band--b" style="<?= e($ttw_cp_pct($ttw_cp_z[7])) ?>"></i></span>
                  </div>
                </div>
                <ol class="ttw-cmp__cer" role="list">
                  <?php foreach ($ttw_cp_z[9] as $ttw_cp_c): ?>
                    <li><span class="ttw-cmp__cn"><?= $ttw_cp_c[0] ?></span><span class="ttw-cmp__cd"><?= e($ttw_cp_c[1]) ?></span><span class="ttw-ro"><?= e($ttw_cp_c[2]) ?> your time · <?= e($ttw_cp_c[3]) ?> IST</span></li>
                  <?php endforeach; ?>
                </ol>
                <p class="ttw-cmp__fine"><?= e($ttw_cp_z[10]) ?></p>
              </div>
            <?php endforeach; ?>
            <!-- PLACEHOLDER: confirm contracted overlap hours and ceremony times per engagement before launch -->
          </div>

          <div class="ttw-cmp__panel">
            <p class="ttw-cmp__ph"><span class="ttw-lbl">Skill coverage</span><span class="ttw-ro" data-ttw-cov>7 of 7 met</span></p>
            <ul class="ttw-cmp__cov" role="list" data-ttw-cover>
              <?php foreach ($ttw_cp_first['cover'] as $ttw_cp_c):
                  $ttw_cp_have = $ttw_cp_first['squad'][$ttw_cp_c[1]] ?? 0;
                  $ttw_cp_ok   = $ttw_cp_have >= $ttw_cp_c[2]; ?>
                <li class="<?= $ttw_cp_ok ? 'is-met' : 'is-gap' ?>">
                  <span class="ttw-tick<?= $ttw_cp_ok ? '' : ' ttw-tick--gap' ?>" aria-hidden="true"><svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2"><?= $ttw_cp_ok ? '<path d="M2 6.4 4.6 9 10 3"/>' : '<path d="M6 2.5v4.2M6 9.4v.1"/>' ?></svg></span>
                  <span class="ttw-cmp__ct"><?= e($ttw_cp_c[0]) ?><span class="ttw-cmp__cq"><?= $ttw_cp_ok ? 'Covered' : 'Gap' ?></span></span>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="ttw-cmp__panel">
            <p class="ttw-cmp__ph"><span class="ttw-lbl">Onboarding</span><span class="ttw-ro">Signed → first merged pull request</span></p>
            <ol class="ttw-cmp__on" role="list">
              <?php foreach ($ttw_cp_on as $ttw_cp_d): ?>
                <li><span class="ttw-cmp__od"><?= e($ttw_cp_d[0]) ?></span><span class="ttw-cmp__ox"><?= e($ttw_cp_d[1]) ?></span></li>
              <?php endforeach; ?>
            </ol>
            <!-- PLACEHOLDER: confirm typical onboarding timings before launch -->
          </div>

          <p class="ttw-cmp__act">
            <a class="btn btn--ink" href="<?= xe_url('contact.php') ?>?from=tech-workforce">Send this squad as a brief <span class="i" aria-hidden="true">›</span></a>
          </p>

        </div>
      </div>
    </div>

    <p class="bdh-sr">An interactive squad composer. Choosing a mission loads a suggested squad; role steppers change the numbers; choosing a time zone shows the shared working window between your day and the squad's shift, with stand-up, planning and review times in both zones. It opens on the “Ship an MVP” mission — one tech lead, two frontend engineers, two backend engineers, one QA automation engineer, one DevOps engineer, one designer and one delivery manager, <?= (int) $ttw_cp_head ?> people, about <?= (int) $ttw_cp_pts ?> story points a sprint — and on the United Kingdom window of four and a half hours. A short demonstration changes the mission once, silently, shortly after the panel comes into view, and stops as soon as you touch a control; changes you make are announced below. All figures are illustrative.</p>
    <p class="ttw-sr-live" data-ttw-live role="status" aria-live="polite"></p>

  </div>

  <script type="application/json" data-ttw-cmp-data><?= $ttw_cp_json ?></script>
</section>
