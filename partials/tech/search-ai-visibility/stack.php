<?php /* DRAFT COPY — review before launch */
/* Stack (paper) — the toolbelt, grouped by the job it does rather than by vendor. Six jobs, each a
   tab over a three-column panel: the question that job answers on the left, what the tooling reads,
   what it cannot see and the artefact it leaves behind in the middle, and the technologies we work
   with on the right. Tools with no licence-clean mark are written out plainly in 'also' rather than
   drawn as an empty tile — every slug in 'slugs' has a mark in assets/tech/logos/.
   Every job states whether the number that comes out is a measurement or an estimate.
   Technologies are shown as technologies we work with. No partnership, tier or certification is
   implied by any mark on this page. */

$tsv_st_jobs = [
    [
        'k' => 'crawl', 'n' => 'Crawl & audit', 'q' => 'Can every page be reached, rendered and indexed?',
        'd' => 'Full-site crawls against the rendered DOM, server log analysis to see what the real crawlers fetched, and index coverage read back from the search engines themselves.',
        'slugs' => ['googlesearchconsole', 'lighthouse', 'pagespeedinsights', 'python'],
        'also'  => ['Screaming Frog', 'Sitebulb', 'Playwright', 'Server log files', 'Bing Webmaster Tools'],
        'facts' => [
            ['What it reads',        'Every indexable URL, its status code, its canonical, and the HTML that exists after JavaScript has run.'],
            ['What it cannot see',   'Whether a page deserves to rank. A crawl proves reachability, never relevance.'],
            ['What it leaves behind','A crawl export and a ranked fix backlog, each row tied to the URLs it affects.'],
        ],
        'prov'  => ['m', 'Measured — a crawl either reached the URL or it did not'],
    ],
    [
        'k' => 'measure', 'n' => 'Measure', 'q' => 'What did people actually do?',
        'd' => 'Clicks, impressions and average position straight from Search Console; sessions, engaged sessions and conversions from analytics; events defined once and named consistently across the site.',
        'slugs' => ['googlesearchconsole', 'googleanalytics', 'googletagmanager', 'posthog'],
        'also'  => ['Bing Webmaster Tools', 'Consent management platform'],
        'facts' => [
            ['What it reads',        'Clicks, impressions and average position by query and page; sessions, engaged sessions and conversions.'],
            ['What it cannot see',   'Queries Google withholds for privacy, and anything a consent decision stopped us collecting.'],
            ['What it leaves behind','A Search Console property with a scheduled bulk export, and an event schema named once.'],
        ],
        'prov'  => ['m', 'Measured — first-party data from your own properties'],
    ],
    [
        'k' => 'research', 'n' => 'Research', 'q' => 'What are buyers asking, and who answers today?',
        'd' => 'Demand mapped from query data, sales calls and support tickets, then matched against who currently ranks and who currently gets cited. Competitor gaps become the content backlog.',
        'slugs' => ['semrush', 'google'],
        'also'  => ['Ahrefs', 'Your sales call notes', 'Support ticket exports'],
        'facts' => [
            ['What it reads',        'Who ranks and who gets cited for a question today, against the demand your own data already proves.'],
            ['What it cannot see',   'The true search volume. Third-party figures are models built from clickstream panels.'],
            ['What it leaves behind','A question map: cluster, intent, current holder, and the gap that makes a page worth writing.'],
        ],
        'prov'  => ['e', 'Estimated — third-party keyword volumes are modelled, not measured'],
    ],
    [
        'k' => 'schema', 'n' => 'Structured data', 'q' => 'Does the machine know what this page is about?',
        'd' => 'JSON-LD written to the Schema.org vocabulary, validated before release and re-validated in CI, then watched in Search Console for enhancement errors after it ships.',
        'slugs' => ['googlesearchconsole', 'wordpress', 'contentful'],
        'also'  => ['Schema.org vocabulary', 'Rich Results Test', 'Schema Markup Validator'],
        'facts' => [
            ['What it reads',        'Whether the markup parses, whether it is eligible for an enhancement, and whether it still is after a release.'],
            ['What it cannot see',   'Whether Google will actually show the enhancement. Valid markup buys eligibility, never placement.'],
            ['What it leaves behind','JSON-LD in the templates, a CI check that fails the build, and an enhancement report watched weekly.'],
        ],
        'prov'  => ['m', 'Measured — markup either validates and is eligible, or it does not'],
    ],
    [
        'k' => 'ai', 'n' => 'AI visibility', 'q' => 'Are we in the answer, and with a link?',
        'd' => 'A defined prompt panel run on a schedule against each answer surface from a clean session, recording whether you were cited, mentioned without a link, or absent — and which sources were used instead.',
        'slugs' => ['perplexity', 'googlegemini', 'anthropic', 'python'],
        'also'  => ['OpenAI', 'Playwright', 'Our own prompt panel harness', 'Commercial AI visibility trackers'],
        'facts' => [
            ['What it reads',        'For each prompt and engine: cited with a link, mentioned without one, or absent — and which sources won instead.'],
            ['What it cannot see',   'Why the model chose those sources. We record what it did, and never claim to know what it thought.'],
            ['What it leaves behind','A versioned prompt panel, the raw answers with their timestamps, and a weekly rate with its sample size.'],
        ],
        'prov'  => ['e', 'Sampled — answers vary run to run, so results are rates with a sample size'],
    ],
    [
        'k' => 'report', 'n' => 'Reporting', 'q' => 'One set of numbers everyone trusts.',
        'd' => 'Every source landed in one warehouse on a schedule, modelled once, and served to a single dashboard — so nobody reconciles two different versions of last month in a meeting.',
        'slugs' => ['googlebigquery', 'looker', 'googleanalytics', 'python'],
        'also'  => ['Scheduled Search Console bulk export', 'Monthly review document'],
        'facts' => [
            ['What it reads',        'Every source on one schedule, modelled once, so last month reads the same in every meeting.'],
            ['What it cannot see',   'Causation. The dashboard shows what moved and when we shipped; the written read argues the link.'],
            ['What it leaves behind','One warehouse dataset, one dashboard, and a monthly written read both teams sign off.'],
        ],
        'prov'  => ['m', 'Both, labelled — measured and sampled figures never share a column'],
    ],
];
?>
<section class="band tsv-belt" id="stack" aria-labelledby="stack-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">07 · Toolbelt</span><span>Technologies we work with</span></p>
        <h2 class="h2" id="stack-t"><span class="g">The toolbelt,</span> by job.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Tools are not a strategy, but the wrong one quietly produces confident nonsense. We group ours by the job they do and state, every time, whether the number that comes out is a measurement or an estimate.</p>
      </div>
    </header>

    <div class="tsv-belt__w" data-tsv-belt>
      <div class="bdh-tabs tsv-belt__tabs" role="tablist" aria-label="Toolbelt, by job">
        <?php foreach ($tsv_st_jobs as $tsv_sti => $tsv_sj): ?>
          <button class="tsv-belt__tab<?= $tsv_sti === 0 ? ' is-on' : '' ?>" type="button" role="tab"
                  id="stack-tab-<?= e($tsv_sj['k']) ?>" aria-controls="stack-pane-<?= e($tsv_sj['k']) ?>"
                  aria-selected="<?= $tsv_sti === 0 ? 'true' : 'false' ?>" tabindex="<?= $tsv_sti === 0 ? '0' : '-1' ?>">
            <span class="tsv-belt__tn"><?= str_pad((string) ($tsv_sti + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($tsv_sj['n']) ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="bdh-panes tsv-belt__panes">
        <?php foreach ($tsv_st_jobs as $tsv_sti => $tsv_sj): ?>
          <div class="bdh-pane tsv-belt__pane<?= $tsv_sti === 0 ? ' is-on' : '' ?>" id="stack-pane-<?= e($tsv_sj['k']) ?>"
               role="tabpanel" aria-labelledby="stack-tab-<?= e($tsv_sj['k']) ?>" tabindex="0">

            <div class="tsv-belt__t">
              <p class="tsv-belt__jk"><span class="tsv-belt__jn"><?= str_pad((string) ($tsv_sti + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($tsv_sj['n']) ?></p>
              <h3 class="tsv-belt__q"><?= e($tsv_sj['q']) ?></h3>
              <p class="tsv-belt__d"><?= e($tsv_sj['d']) ?></p>
              <p class="tsv-prov<?= $tsv_sj['prov'][0] === 'm' ? ' tsv-prov--m' : '' ?> tsv-belt__prov"><?= e($tsv_sj['prov'][1]) ?></p>
              <?php if ($tsv_sj['also']): ?>
                <p class="tsv-belt__also"><span>Also in this job</span>
                  <?php foreach ($tsv_sj['also'] as $tsv_sa): ?><i><?= e($tsv_sa) ?></i><?php endforeach; ?>
                </p>
              <?php endif; ?>
            </div>

            <dl class="tsv-belt__facts">
              <?php foreach ($tsv_sj['facts'] as $tsv_sfi => $tsv_sf): ?>
                <div class="tsv-fact<?= $tsv_sfi === 1 ? ' is-limit' : '' ?>">
                  <dt><?= e($tsv_sf[0]) ?></dt>
                  <dd><?= e($tsv_sf[1]) ?></dd>
                </div>
              <?php endforeach; ?>
            </dl>

            <div class="tsv-belt__g">
              <p class="tsv-belt__gk">Technologies we work with</p>
              <?= xt_stack($tsv_sj['slugs'], ['variant' => 'tiles', 'cat' => true, 'label' => $tsv_sj['n'] . ' — technologies we work with']) ?>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="tsv-note tsv-belt__note" data-rv>
      <?= xt_icon('filter', ['size' => 18]) ?>
      <span><b>Why the labels matter.</b> A keyword volume from a third-party suite is a model of demand, not a count of searches. An AI visibility panel is a sample of a system that answers differently on every run. Search Console clicks are a measurement of what happened on your own property. We put all three on the same dashboard and never let them sit in the same column without saying which is which.</span>
    </p>

  </div>
</section>
