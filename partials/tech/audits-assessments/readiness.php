<?php /* DRAFT COPY — review before launch */
/* Readiness — the AI-readiness assessment. The instrument is a gap chart: one track per dimension,
   the score today as a solid run, the shortfall to the target hatched behind a dashed target mark,
   and the engineering days that close it. Rows are ordered by that effort, largest first, and the
   segmented strip above them shows the same days stacked — the sum of the gaps, which is the number
   the section argues about and the one a polygon chart cannot show. Each row carries its evidence,
   its next action, an owner and the framework it is judged against.
   Under it, the profiling snippet an agent produces on day two and the line that matters: how many
   of its candidate findings a human analyst kept.
   readiness.js only gates the entrance — the shipped HTML already holds every score, every gap and
   every profiling number. */

/* dimension · score today · target · engineering days to close · evidence · next action · owner · framework */
$taa_rd_dims = [
    ['k' => 'data',  'n' => 'Data foundations',        'now' => 2, 'tgt' => 4, 'd' => 12,
     'ev'  => 'Core entities documented. 40% of the knowledge base is duplicated and freshness is unmonitored.',
     'act' => 'De-duplicate the corpus, then add freshness and null checks to the ingestion pipeline.',
     'own' => 'Data engineering', 'std' => 'dpdp'],
    ['k' => 'gov',   'n' => 'Governance',              'now' => 1, 'tgt' => 3, 'd' => 8,
     'ev'  => 'No model inventory, no approval gate, no evaluation record. AI use is discovered after the fact.',
     'act' => 'Stand up a model register and an approval gate before the next pilot leaves a laptop.',
     'own' => 'CTO office', 'std' => 'iso42001'],
    ['k' => 'sec',   'n' => 'Security & privacy',      'now' => 3, 'tgt' => 4, 'd' => 6,
     'ev'  => 'SSO and central logging in place. Prompts are neither tested for injection nor retained under a rule.',
     'act' => 'Run prompt-injection probes against the OWASP Top 10 for LLM Applications and set a prompt retention rule.',
     'own' => 'Security', 'std' => 'owasp-llm'],
    ['k' => 'skill', 'n' => 'Skills & operating model', 'now' => 2, 'tgt' => 4, 'd' => 5,
     'ev'  => 'Two engineers experimenting. No named model owner, no review rota, no on-call path for failures.',
     'act' => 'Name a model owner, start a weekly output review, put model failure in the on-call runbook.',
     'own' => 'Platform', 'std' => 'nist-ai-rmf'],
    ['k' => 'infra', 'n' => 'Infrastructure',          'now' => 3, 'tgt' => 4, 'd' => 4,
     'ev'  => 'Managed cluster and a vector store are running. No cost-per-request budget, no latency objective.',
     'act' => 'Set a cost-per-request budget and a p95 latency objective before the first production agent.',
     'own' => 'Platform', 'std' => ''],
    ['k' => 'fit',   'n' => 'Use-case fit',            'now' => 4, 'tgt' => 4, 'd' => 0,
     'ev'  => 'Three candidates with a measured baseline; one has an owner and a budget. Already at target.',
     'act' => 'Nothing to close. Keep the baseline current so the first use case is judged against a measured starting point.',
     'own' => 'Product', 'std' => ''],
];
$taa_rd_days = array_sum(array_column($taa_rd_dims, 'd'));
$taa_rd_open = count(array_filter($taa_rd_dims, fn ($taa_rd_x) => $taa_rd_x['d'] > 0));
$taa_rd_pc   = fn (int $taa_rd_v): string => number_format($taa_rd_v / 5 * 100, 1);

$taa_rd_prof = [  // [column, null %, duplicate %, freshness, flag]
    ['orders.order_id',    0.0,  0.0,  '2 min',  ''],
    ['orders.channel',    12.8,  0.0,  '2 min',  'nulls'],
    ['customers.email',    0.4,  6.1,  '2 min',  'duplicates'],
    ['events.session_id',  3.1,  0.2,  '5 min',  'event loss'],
    ['kb_articles.body',   1.1, 40.2,  '31 days','duplicates · stale'],
];
$taa_rd_scale = 45;  // both bars share one scale so the columns are comparable

$taa_rd_next = $TI['ai-strategy-agents'] ?? null;
?>
<section class="band band--alt taa-rd" id="readiness" aria-labelledby="readiness-t">
  <div class="wrap">

    <header class="taa-head" data-rv>
      <div class="taa-head__t">
        <p class="taa-kick"><span class="taa-kick__ref">07</span><span>AI readiness</span></p>
        <h2 class="h2" id="readiness-t"><span class="g">Ready for AI,</span> or ready to find out.</h2>
      </div>
      <div class="taa-head__l">
        <p class="lead">Most AI programmes stall on data, governance and ownership rather than on models. The readiness assessment scores six dimensions against where the first production use case needs them to be, and returns a prerequisite list instead of a verdict.</p>
      </div>
    </header>

    <div class="taa-rd__top" data-taa-rd>

      <div class="taa-rd__gh">
        <h3 class="bdh-t bdh-t--l" id="readiness-gap-t">The gap to a first production use case</h3>
        <p class="bdh-d">Each dimension is scored 1–5 against a rubric published before the assessment. The solid run is where it stands today, the pale run is the shortfall, and the dashed mark is the level the first production use case needs. What the shortfall costs to close is stated in engineering days, so the answer is a backlog rather than a verdict.</p>
      </div>

      <figure class="taa-rd__load">
        <figcaption class="taa-rd__loadh">
          <span class="taa-lbl">Prerequisite work, by dimension</span>
          <span class="taa-rd__loadt"><b class="taa-num"><?= (int) $taa_rd_days ?></b> engineering days</span>
        </figcaption>
        <span class="taa-rd__loadbar" aria-hidden="true">
          <?php foreach ($taa_rd_dims as $taa_rd_li => $taa_rd_l): if ($taa_rd_l['d'] <= 0) continue; ?>
            <i style="--w:<?= number_format($taa_rd_l['d'] / max(1, $taa_rd_days) * 100, 2) ?>;--i:<?= (int) $taa_rd_li ?>"><b><?= (int) $taa_rd_l['d'] ?>d</b></i>
          <?php endforeach; ?>
        </span>
        <ul class="taa-rd__loadk" role="list">
          <?php foreach ($taa_rd_dims as $taa_rd_li => $taa_rd_l): if ($taa_rd_l['d'] <= 0) continue; ?>
            <li><i aria-hidden="true" style="--i:<?= (int) $taa_rd_li ?>"></i><?= e($taa_rd_l['n']) ?> <span><?= (int) $taa_rd_l['d'] ?> d</span></li>
          <?php endforeach; ?>
        </ul>
      </figure>
      <p class="bdh-sr">A strip showing the <?= (int) $taa_rd_days ?> engineering days of prerequisite work split by dimension: data foundations 12 days, governance 8, security and privacy 6, skills and operating model 5, infrastructure 4, use-case fit none. The same figures are listed below.</p>

      <p class="taa-rd__key" aria-hidden="true">
        <span class="taa-rd__k taa-rd__k--now">Score today</span>
        <span class="taa-rd__k taa-rd__k--short">Shortfall</span>
        <span class="taa-rd__k taa-rd__k--tgt">Target for a first production use case</span>
      </p>

      <ol class="taa-rd__gaps" role="list" aria-labelledby="readiness-gap-t">
        <?php foreach ($taa_rd_dims as $taa_rd_gi => $taa_rd_g): ?>
          <li class="taa-rd__gap<?= $taa_rd_g['d'] <= 0 ? ' is-at' : '' ?>" style="--i:<?= (int) $taa_rd_gi ?>">

            <div class="taa-rd__gh2">
              <span class="taa-rd__ix"><?= str_pad((string) ($taa_rd_gi + 1), 2, '0', STR_PAD_LEFT) ?></span>
              <h4 class="taa-rd__gn"><?= e($taa_rd_g['n']) ?></h4>
              <span class="taa-rd__sc">
                <b><?= (int) $taa_rd_g['now'] ?></b><i aria-hidden="true">→</i><b><?= (int) $taa_rd_g['tgt'] ?></b>
                <span class="bdh-sr">scores <?= (int) $taa_rd_g['now'] ?> of 5 today against a target of <?= (int) $taa_rd_g['tgt'] ?> of 5</span>
              </span>
              <span class="taa-rd__ef<?= $taa_rd_g['d'] <= 0 ? ' is-none' : '' ?>">
                <?= $taa_rd_g['d'] > 0 ? (int) $taa_rd_g['d'] . ' eng. days' : 'At target' ?>
              </span>
            </div>

            <span class="taa-rd__track" aria-hidden="true">
              <i class="taa-rd__ticks"><b></b><b></b><b></b><b></b><b></b></i>
              <i class="taa-rd__short" style="--a:<?= $taa_rd_pc($taa_rd_g['now']) ?>;--b:<?= $taa_rd_pc($taa_rd_g['tgt']) ?>"></i>
              <i class="taa-rd__now" style="--a:<?= $taa_rd_pc($taa_rd_g['now']) ?>"></i>
              <i class="taa-rd__mark" style="--b:<?= $taa_rd_pc($taa_rd_g['tgt']) ?>"></i>
            </span>

            <p class="taa-rd__ev"><span class="taa-lbl">Evidence</span><?= e($taa_rd_g['ev']) ?></p>
            <p class="taa-rd__ga"><span class="taa-lbl">Next action</span><?= e($taa_rd_g['act']) ?></p>
            <div class="taa-rd__gm">
              <span class="taa-rd__ow"><?= e($taa_rd_g['own']) ?></span>
              <?php if ($taa_rd_g['std']) { echo xt_badge($taa_rd_g['std'], ['variant' => 'chip', 'class' => 'taa-rd__bg']); } ?>
            </div>

          </li>
        <?php endforeach; ?>
      </ol>

      <p class="taa-rd__sum">
        <span class="taa-est">Illustrative</span>
        <span><b><?= (int) $taa_rd_days ?> engineering days</b> of prerequisite work across <?= (int) $taa_rd_open ?> dimensions before a first production use case is worth funding. Use-case fit is the one dimension already at target — the ideas are fine, the ground underneath them is not. Scores describe a system at a point in time and are re-scored on the same rubric at re-test.</span>
      </p>
    </div>

    <div class="taa-rd__bot">

      <div class="taa-rd__prof taa-win" data-taa-rd-prof>
        <div class="taa-win__bar">
          <span class="taa-win__t"><b>Profiling run</b> · agent 04 · warehouse.analytics</span>
          <span class="taa-win__st"><i class="taa-led" aria-hidden="true"></i>Complete</span>
          <span class="taa-win__st">6.1M rows · 9 min</span>
        </div>

        <p class="taa-rd__cmd" aria-hidden="true"><span>$</span> xe-audit profile --source warehouse.analytics --sample 100% --window 30d</p>

        <div class="taa-rd__scroll bdh-scroll-x">
          <table class="taa-tbl taa-rd__tbl">
            <caption class="bdh-sr">Data profiling output for five columns: null rate, duplicate rate, freshness and the flag raised. The bars share one scale from 0 to 45%.</caption>
            <thead>
              <tr>
                <th scope="col">Column</th>
                <th scope="col">Null rate</th>
                <th scope="col">Duplicate rate</th>
                <th scope="col">Freshness</th>
                <th scope="col">Flag</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($taa_rd_prof as $taa_rd_pi => $taa_rd_p): ?>
                <tr style="--i:<?= (int) $taa_rd_pi ?>">
                  <th scope="row" class="taa-id"><?= e($taa_rd_p[0]) ?></th>
                  <td class="taa-n">
                    <span class="taa-rd__pv"><?= number_format($taa_rd_p[1], 1) ?>%</span>
                    <i class="taa-rd__bar" aria-hidden="true"><em style="--p:<?= number_format($taa_rd_p[1] / $taa_rd_scale, 3) ?>"></em></i>
                  </td>
                  <td class="taa-n">
                    <span class="taa-rd__pv"><?= number_format($taa_rd_p[2], 1) ?>%</span>
                    <i class="taa-rd__bar<?= $taa_rd_p[2] >= 20 ? ' is-hot' : '' ?>" aria-hidden="true"><em style="--p:<?= number_format($taa_rd_p[2] / $taa_rd_scale, 3) ?>"></em></i>
                  </td>
                  <td class="taa-n"><?= e($taa_rd_p[3]) ?></td>
                  <td><?= $taa_rd_p[4] ? '<span class="taa-rd__flag">' . e($taa_rd_p[4]) . '</span>' : '<span class="taa-rd__ok">clean</span>' ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <p class="taa-rd__pf">
          <span class="taa-est">Illustrative</span>
          <span>Agents run the profiling, cluster log errors and draft candidate findings in the first days. On this run the agent drafted <b>14 candidates</b>; an analyst confirmed <b>9</b> and rejected <b>5</b> as false positives. Only the confirmed nine reached the register.</span>
        </p>
      </div>

      <aside class="taa-rd__side">
        <!-- PLACEHOLDER: reference photograph (Unsplash) — confirm before launch -->
        <figure class="bdh-img bdh-img--r169 taa-rd__photo">
          <img src="<?= xe_url('assets/imgs/tech/audits-assessments/readiness-dashboard.jpg') ?>" width="700" height="409"
               alt="A desk with a monitor of source code, a handwritten list on a tablet, sticky notes and a calculator" loading="lazy" decoding="async" style="object-position:50% 45%">
        </figure>
        <p class="taa-cap">Machine speed for collection, human judgement for the rating. No tool output enters the register unverified.</p>

        <?php if ($taa_rd_next): ?>
          <a class="taa-rd__go" href="<?= xe_url('services/technology-intelligence/' . $taa_rd_next['slug'] . '.php') ?>">
            <span class="taa-lbl">Once the ground is ready</span>
            <span class="taa-rd__gon"><?= e($taa_rd_next['name']) ?> <span class="i" aria-hidden="true">›</span></span>
            <span class="taa-rd__god">Capability <?= e($taa_rd_next['n']) ?> — where the prerequisite list turns into a funded programme.</span>
          </a>
        <?php endif; ?>
      </aside>

    </div>

  </div>
</section>
