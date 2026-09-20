<?php /* DRAFT COPY — review before launch */
/* Process (alt) — 10 · How the programme runs. Two halves: a vertical stage rail (Audit, Fix,
   Build, Measure — taken from $CAP['process']) driving a detail pane, and beneath it a 90-day
   calendar strip built as a real table: seven workstreams down the side, thirteen weeks across.
   Every workstream sits inside the week range its stage claims on the rail, so the two are read
   together without contradicting each other. The caption is a paragraph after the scroll region,
   not a <caption> inside it, or it lays out at the table's 860px and runs off a phone screen.
   The stage rail filters the calendar; the calendar fills week by week when it comes into view.
   Timings are illustrative and marked as such. */

$tsv_pr_p     = isset($CAP['process']) ? $CAP['process'] : ['title' => '', 'lead' => '', 'steps' => []];
$tsv_pr_steps = isset($tsv_pr_p['steps']) ? $tsv_pr_p['steps'] : [];

/* Page-side detail for each stage, in the same order as the data steps. */
$tsv_pr_meta = [
    [
        'k' => 'audit', 'icon' => 'scan',
        'q' => 'Can search engines and answer engines reach, render and understand the site as it stands today?',
        'work' => [
            'Every indexable URL crawled against the rendered DOM, not the raw HTML alone, so JavaScript-dependent content is judged the way an engine sees it.',
            'A server log sample split by user agent, to see what the real crawlers requested, how often, and what status code came back.',
            'Index coverage, enhancement errors and Core Web Vitals field data read back from Search Console rather than inferred from a single lab run.',
            'A prompt panel written from the questions your buyers actually ask, sampled repeatedly per engine so the baseline is a rate with a sample size.',
        ],
        'need' => 'Read access to Search Console and analytics, a sample of server logs, and a staging URL if one exists.',
        'gate' => 'A ranked fix backlog and a signed-off baseline. Nothing is changed before the baseline is captured, or there is nothing to measure against.',
    ],
    [
        'k' => 'fix', 'icon' => 'wrench',
        'q' => 'What is stopping the pages that matter from being crawled, rendered, indexed and served quickly?',
        'work' => [
            'Status codes, canonicals, redirect chains and parameter sprawl cleaned up, so crawl effort lands on URLs that can earn something.',
            'Rendering fixed at the source: server-rendered or pre-rendered output for anything that must be indexed, instead of relying on a crawler to run your application.',
            'Core Web Vitals worked against field data until the good thresholds hold at the 75th percentile: LCP under 2.5 s, INP under 200 ms, CLS under 0.1.',
            'JSON-LD written to the Schema.org vocabulary and validated in CI, so a template change cannot quietly break eligibility months later.',
        ],
        'need' => 'A developer with deploy rights, or our engineers working inside your repository under your review process.',
        'gate' => 'Priority URLs return 200, render without errors, validate as structured data, and pass the Core Web Vitals thresholds in field data.',
    ],
    [
        'k' => 'build', 'icon' => 'layers',
        'q' => 'Which questions do we deserve to answer, and who else needs to say so before an engine believes it?',
        'work' => [
            'Question clusters chosen from demand you can prove — query data, sales calls and support tickets — not from a volume column on its own.',
            'Pages that answer in the first fifty words and then earn the rest: a comparison table, an original data point, a named author with credentials, sources and a real updated date.',
            'Entity work in parallel: Organization markup, consistent name, address and contact data, and the external profiles that state the same facts.',
            'Mentions earned where answers already look — trade publications, review programmes, documentation and communities. No bought links, no exchanges.',
        ],
        'need' => 'A subject-matter expert for about an hour a week, and approval to publish under a named author.',
        'gate' => 'The cluster is published with named authors, sources and updated dates, and outreach is live with a tracked pipeline of mentions.',
    ],
    [
        'k' => 'measure', 'icon' => 'chart',
        'q' => 'Is the number moving, and which part of the work moved it?',
        'work' => [
            'Clicks, impressions and average position exported from Search Console on a schedule, rather than screenshotted out of the interface once a month.',
            'The prompt panel re-sampled weekly, because generated answers change run to run and a single check is an anecdote.',
            'Share of answer, citation rate and non-brand share reported by engine and by intent, always against the baseline taken before any change.',
            'A written read each month: what moved, what we shipped, what we are changing next, and what we got wrong.',
        ],
        'need' => 'Thirty minutes a month from the person who owns the pipeline, so the numbers are read next to revenue.',
        'gate' => 'One dashboard both teams read, with measured and sampled figures labelled and never averaged into the same column.',
    ],
];

/* The 90-day strip: workstream, stage, first week, last week, one line of detail. 13 weeks. */
$tsv_pr_weeks = 13;
$tsv_pr_rows  = [
    ['Crawl, log and index analysis', 'audit',   1,  3,  'Rendered-DOM crawl and a log sample by user agent'],
    ['Baseline and prompt panel',     'audit',   2,  3,  'Rankings, clicks and answer presence recorded before any change'],
    ['Indexation and rendering',      'fix',     3,  6,  'Status codes, canonicals, internal links, rendering path'],
    ['Structured data and entities',  'fix',     4,  6,  'JSON-LD written, validated, then watched for enhancement errors'],
    ['Answer-first content',          'build',   6, 12,  'Clusters published with named authors, sources and updated dates'],
    ['Digital PR and citations',      'build',   7, 12,  'Commentary, data and review programmes where answers already look'],
    ['Dashboard and reporting',       'measure', 4, 13,  'Weekly re-sampling, one dashboard, a monthly read with both teams'],
];
$tsv_pr_beats = [4, 8, 12];   /* monthly report beats on the reporting row */
$tsv_pr_names = ['audit' => 'Audit', 'fix' => 'Fix', 'build' => 'Build', 'measure' => 'Measure'];
?>
<section class="band band--alt tsv-proc" id="process" aria-labelledby="process-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">10 · Process</span><span>Audit, fix, publish, track</span></p>
        <h2 class="h2" id="process-t"><?= $tsv_pr_p['title'] ?></h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead"><?= e($tsv_pr_p['lead']) ?> Fixes ship in weekly batches rather than one release at the end, because the answer surfaces move while the work is in progress.</p>
      </div>
    </header>

    <div class="tsv-proc__grid" data-tsv-proc data-rv>

      <div class="tsv-proc__rail" role="tablist" aria-label="Programme stages">
        <?php foreach ($tsv_pr_steps as $tsv_pr_i => $tsv_pr_s):
            $tsv_pr_m = isset($tsv_pr_meta[$tsv_pr_i]) ? $tsv_pr_meta[$tsv_pr_i] : $tsv_pr_meta[0]; ?>
          <button class="tsv-proc__stage<?= $tsv_pr_i === 0 ? ' is-on' : '' ?>" type="button" role="tab"
                  id="process-tab-<?= e($tsv_pr_m['k']) ?>" aria-controls="process-pane-<?= e($tsv_pr_m['k']) ?>"
                  aria-selected="<?= $tsv_pr_i === 0 ? 'true' : 'false' ?>" tabindex="<?= $tsv_pr_i === 0 ? '0' : '-1' ?>"
                  data-stage="<?= e($tsv_pr_m['k']) ?>">
            <span class="tsv-proc__sn"><?= str_pad((string) ($tsv_pr_i + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="tsv-proc__si"><?= xt_icon($tsv_pr_m['icon'], ['size' => 20]) ?></span>
            <span class="tsv-proc__st"><?= e($tsv_pr_s[0]) ?></span>
            <span class="tsv-proc__sw"><?= e($tsv_pr_s[1]) ?></span>
          </button>
        <?php endforeach; ?>
        <p class="tsv-proc__loop"><?= xt_icon('rollback', ['size' => 16]) ?><span>Measure feeds the next audit. The loop runs each quarter, not once.</span></p>
      </div>

      <div class="bdh-panes tsv-proc__panes">
        <?php foreach ($tsv_pr_steps as $tsv_pr_i => $tsv_pr_s):
            $tsv_pr_m = isset($tsv_pr_meta[$tsv_pr_i]) ? $tsv_pr_meta[$tsv_pr_i] : $tsv_pr_meta[0]; ?>
          <div class="bdh-pane tsv-proc__pane<?= $tsv_pr_i === 0 ? ' is-on' : '' ?>" id="process-pane-<?= e($tsv_pr_m['k']) ?>"
               role="tabpanel" aria-labelledby="process-tab-<?= e($tsv_pr_m['k']) ?>" tabindex="0">

            <div class="tsv-proc__top">
              <h3 class="tsv-proc__h"><?= e($tsv_pr_s[0]) ?></h3>
              <span class="tsv-proc__wk"><?= e($tsv_pr_s[1]) ?></span>
            </div>
            <p class="tsv-proc__q"><?= e($tsv_pr_m['q']) ?></p>
            <p class="tsv-proc__d"><?= e($tsv_pr_s[2]) ?></p>

            <ul class="tsv-proc__work" role="list">
              <?php foreach ($tsv_pr_m['work'] as $tsv_pr_w): ?>
                <li><?= e($tsv_pr_w) ?></li>
              <?php endforeach; ?>
            </ul>

            <?php if (!empty($tsv_pr_s[3])): ?>
              <div class="tsv-proc__out">
                <p class="tsv-proc__ol">Leaves behind</p>
                <ul class="tsv-proc__chips" role="list">
                  <?php foreach ($tsv_pr_s[3] as $tsv_pr_o): ?>
                    <li><?= xt_icon('check', ['size' => 14]) ?><?= e($tsv_pr_o) ?></li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>

            <dl class="tsv-proc__gate">
              <div>
                <dt>What we need from you</dt>
                <dd><?= e($tsv_pr_m['need']) ?></dd>
              </div>
              <div>
                <dt>Exit gate</dt>
                <dd><?= e($tsv_pr_m['gate']) ?></dd>
              </div>
            </dl>

          </div>
        <?php endforeach; ?>
      </div>

      <div class="tsv-cal" data-tsv-cal data-stage="all">
        <div class="tsv-cal__bar">
          <p class="tsv-cal__t">The first ninety days, week by week</p>
          <p class="tsv-cal__read">
            <span class="tsv-cal__w" data-tsv-week>W13</span>
            <span class="tsv-cal__of">of <?= $tsv_pr_weeks ?> weeks</span>
          </p>
        </div>

        <div class="bdh-scroll-x mask-x tsv-cal__scroll" tabindex="0" role="group" aria-label="The first ninety days, week by week — scroll sideways to see every week">
          <table class="tsv-cal__tbl" aria-labelledby="process-cal-cap">
            <thead>
              <tr>
                <th scope="col" class="tsv-cal__wsh">Workstream</th>
                <th scope="col" class="tsv-cal__sth">Stage</th>
                <?php for ($tsv_pr_w = 1; $tsv_pr_w <= $tsv_pr_weeks; $tsv_pr_w++):
                    $tsv_pr_pad = str_pad((string) $tsv_pr_w, 2, '0', STR_PAD_LEFT); ?>
                  <th scope="col" class="tsv-cal__wh<?= ($tsv_pr_w === 5 || $tsv_pr_w === 9) ? ' is-month' : '' ?>">
                    <span aria-hidden="true"><?= $tsv_pr_pad ?></span><span class="bdh-sr">Week <?= $tsv_pr_pad ?></span>
                  </th>
                <?php endfor; ?>
                <th scope="col" class="tsv-cal__rh">Runs</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tsv_pr_rows as $tsv_pr_r):
                  $tsv_pr_a = str_pad((string) $tsv_pr_r[2], 2, '0', STR_PAD_LEFT);
                  $tsv_pr_z = str_pad((string) $tsv_pr_r[3], 2, '0', STR_PAD_LEFT); ?>
                <tr class="tsv-cal__row" data-stage="<?= e($tsv_pr_r[1]) ?>">
                  <th scope="row" class="tsv-cal__ws">
                    <b><?= e($tsv_pr_r[0]) ?></b>
                    <small><?= e($tsv_pr_r[4]) ?></small>
                  </th>
                  <td class="tsv-cal__st">
                    <span class="tsv-cal__sd" aria-hidden="true"></span><?= e($tsv_pr_names[$tsv_pr_r[1]]) ?>
                  </td>
                  <?php for ($tsv_pr_w = 1; $tsv_pr_w <= $tsv_pr_weeks; $tsv_pr_w++):
                      $tsv_pr_on   = ($tsv_pr_w >= $tsv_pr_r[2] && $tsv_pr_w <= $tsv_pr_r[3]);
                      $tsv_pr_beat = ($tsv_pr_r[1] === 'measure' && in_array($tsv_pr_w, $tsv_pr_beats, true)); ?>
                    <td class="tsv-cal__c<?= $tsv_pr_on ? ' is-on' : '' ?><?= $tsv_pr_beat ? ' is-beat' : '' ?><?= ($tsv_pr_w === 5 || $tsv_pr_w === 9) ? ' is-month' : '' ?>" data-w="<?= $tsv_pr_w ?>">
                      <?php if ($tsv_pr_on && $tsv_pr_w === (int) $tsv_pr_r[2]): ?>
                        <span class="bdh-sr">Runs week <?= $tsv_pr_a ?> to week <?= $tsv_pr_z ?></span>
                      <?php endif; ?>
                      <?php if ($tsv_pr_beat): ?>
                        <span class="bdh-sr">Monthly report</span>
                      <?php endif; ?>
                    </td>
                  <?php endfor; ?>
                  <td class="tsv-cal__r">W<?= $tsv_pr_a ?>–W<?= $tsv_pr_z ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <p class="tsv-cal__cap" id="process-cal-cap">
          <!-- PLACEHOLDER: confirm programme timings before launch -->
          Illustrative schedule. Seven workstreams across thirteen weeks; the reporting row carries a monthly read at weeks 04, 08 and 12. Work continues on a monthly cycle after week 13.
        </p>

        <p class="bdh-sr">The strip fills from week one to week thirteen when it comes into view; the finished state shows every workstream in place.</p>

        <ul class="tsv-cal__key" role="list">
          <li><span class="tsv-cal__kd" data-stage="audit" aria-hidden="true"></span>Audit</li>
          <li><span class="tsv-cal__kd" data-stage="fix" aria-hidden="true"></span>Fix</li>
          <li><span class="tsv-cal__kd" data-stage="build" aria-hidden="true"></span>Build</li>
          <li><span class="tsv-cal__kd" data-stage="measure" aria-hidden="true"></span>Measure</li>
          <li class="tsv-cal__key--beat"><span class="tsv-cal__kd is-beat" aria-hidden="true"></span>Monthly report</li>
        </ul>
      </div>

    </div>

    <p class="tsv-note tsv-proc__note" data-rv>
      <?= xt_icon('clock', ['size' => 18]) ?>
      <span><b>Why weekly, not quarterly.</b> A technical fix can show up within days of the page being recrawled. A generated answer can change between two Tuesdays without anyone publishing anything. So the fix backlog ships in weekly batches, the prompt panel is re-sampled on the same rhythm, and the monthly read explains the trend rather than one lucky run.</span>
    </p>

  </div>
</section>
