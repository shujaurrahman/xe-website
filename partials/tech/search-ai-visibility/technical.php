<?php /* DRAFT COPY — review before launch */
/* Technical (alt) — the crawl-to-index pipeline and the bot switchboard.
   Top: five stages from discovery to serving, with a crawl log that fills beneath them.
   Bottom: a robots.txt switchboard where each user-agent can be allowed or disallowed, with the
   generated rules and the explanation pane beside it in the right column so the two columns end
   together; the rules block rewrites itself and the explanation says exactly what that agent controls — including the
   distinctions people get wrong (GPTBot trains, OAI-SearchBot fetches for ChatGPT search, and
   Google-Extended governs Gemini use of already-crawled content, not Search ranking).
   The switches are real buttons with aria-pressed; the pipeline animation is decoration only. */

$tsv_tc_stages = [   // [key, name, subtitle, checks[]]
    ['discover', 'Discover', 'Sitemaps · internal links · IndexNow',
     ['XML sitemaps under 50,000 URLs and 50 MB each', 'Every important page reachable in three clicks', 'IndexNow ping on publish for Bing and partners']],
    ['crawl', 'Crawl', 'robots.txt · status codes · crawl budget',
     ['robots.txt rules read per user-agent, not globally', 'No redirect chains: one hop, 301, then stop', 'Server response under 600 ms, the threshold Lighthouse audits against']],
    ['render', 'Render', 'JavaScript rendering',
     ['Primary content present in the server HTML', 'Nothing important behind a click-only tab', 'Rendered HTML confirmed in URL inspection']],
    ['index', 'Index', 'canonicals · duplicates · parameters',
     ['One canonical per piece of content, self-referencing', 'Faceted and tracking parameters handled deliberately', 'noindex only where it is genuinely meant']],
    ['serve', 'Serve', 'Core Web Vitals · HTTPS · mobile',
     ['LCP, INP and CLS in the good band at p75', 'HTTPS everywhere with no mixed content', 'Mobile shows the same content as desktop']],
];

$tsv_tc_log = [   // [url path, status label, state]
    ['/payroll/mid-size-india',            '200 · indexed',                  'ok'],
    ['/guides/multi-state-payroll',        '200 · rendered client-side',     'warn'],
    ['/pricing?plan=growth&ref=ad',        '200 · duplicate of /pricing',    'warn'],
    ['/resources/checklist.pdf',           '200 · gated, not indexable',     'warn'],
    ['/trust/audit-evidence',              'Blocked by robots.txt',          'bad'],
    ['/blog/old-payroll-guide',            '301 → 301 → 200 · chain',        'warn'],
    ['/compare/platforms',                 '200 · indexed',                  'ok'],
    ['/careers/payroll-analyst-2021',      '404 · still in the sitemap',     'bad'],
];

$tsv_tc_bots = [   // [agent, what it is, allowed by default, what allowing it does, what blocking it costs]
    ['Googlebot', 'Google Search crawling and indexing', true,
     'Allows Google to crawl and index the page. This is the foundation for organic results and for AI Overviews, which are built on indexed pages.',
     'Blocking it removes you from Google Search entirely, including AI Overviews.'],
    ['Bingbot', 'Bing crawling and indexing', true,
     'Allows Bing to crawl and index the page. Bing’s index also underpins several assistant experiences.',
     'Blocking it removes you from Bing and from the answers built on its index.'],
    ['OAI-SearchBot', 'Fetches pages for ChatGPT search results', true,
     'Allows ChatGPT search to fetch and link your page as a source. This agent is not used for model training.',
     'Blocking it removes your pages from ChatGPT search results and citations.'],
    ['GPTBot', 'Crawls content to train OpenAI models', false,
     'Allows your content to be used in training data for OpenAI models. This is a policy decision, not a visibility one.',
     'Blocking it does not affect whether ChatGPT search can cite you — that is OAI-SearchBot.'],
    ['PerplexityBot', 'Crawls to index pages for Perplexity answers', true,
     'Allows Perplexity to index your pages so they can be surfaced and cited in its answers.',
     'Blocking it removes you from Perplexity’s cited sources.'],
    ['Google-Extended', 'Controls Gemini use of already-crawled content', true,
     'Leaves your content eligible for use in Gemini app responses and grounding. It is a control token, not a crawler: Googlebot still does the crawling.',
     'Opting out does not change Search ranking and does not remove you from AI Overviews.'],
];

$tsv_tc_cwv = [
    ['LCP', 'Largest Contentful Paint', '≤ 2.5 s', 'when the main content has rendered'],
    ['INP', 'Interaction to Next Paint', '≤ 200 ms', 'how quickly the page answers a tap'],
    ['CLS', 'Cumulative Layout Shift',  '≤ 0.1',   'how much the layout moves while loading'],
];
?>
<section class="band band--alt tsv-tech" id="technical" aria-labelledby="technical-t">
  <div class="wrap">

    <header class="tsv-head" data-rv>
      <div class="tsv-head__t">
        <p class="tsv-kick"><span class="tsv-kick__ref">03 · Foundations</span><span>Crawl · render · index</span></p>
        <h2 class="h2" id="technical-t"><span class="g">If crawlers cannot read it,</span> nothing else matters.</h2>
      </div>
      <div class="tsv-head__l">
        <p class="lead">Ranking and citation both start in the same place: a machine asking for your page and getting a clean answer. Five stages, and a page can fail at any of them without anyone noticing for months.</p>
      </div>
    </header>

    <div class="tsv-pipe" data-tsv-pipe data-rv>
      <ol class="tsv-pipe__stages" role="list">
        <?php foreach ($tsv_tc_stages as $tsv_tsi => $tsv_ts): ?>
          <li class="tsv-stage<?= $tsv_tsi === 0 ? ' is-at' : '' ?>" data-stage="<?= e($tsv_ts[0]) ?>" style="--i:<?= $tsv_tsi ?>">
            <span class="tsv-stage__n"><?= str_pad((string) ($tsv_tsi + 1), 2, '0', STR_PAD_LEFT) ?></span>
            <span class="tsv-stage__line" aria-hidden="true"><i></i></span>
            <h3 class="tsv-stage__t"><?= e($tsv_ts[1]) ?></h3>
            <p class="tsv-stage__s"><?= e($tsv_ts[2]) ?></p>
            <ul class="tsv-stage__c" role="list">
              <?php foreach ($tsv_ts[3] as $tsv_tcx): ?><li><?= e($tsv_tcx) ?></li><?php endforeach; ?>
            </ul>
          </li>
        <?php endforeach; ?>
      </ol>

      <div class="tsv-log" aria-hidden="true">
        <p class="tsv-log__bar"><i class="tsv-led tsv-led--pulse"></i><b>crawl log</b><span>yourcompany.com · last 200 URLs sampled</span></p>
        <ul class="tsv-log__list" role="list">
          <?php foreach ($tsv_tc_log as $tsv_tli => $tsv_tl): ?>
            <li class="tsv-log__row" data-st="<?= e($tsv_tl[2]) ?>" style="--i:<?= $tsv_tli ?>">
              <span class="tsv-log__u"><?= e($tsv_tl[0]) ?></span>
              <span class="tsv-log__s"><?= e($tsv_tl[1]) ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <p class="bdh-sr">An illustrative crawl log for the placeholder company: eight sampled URLs with their status. Two are clean, four carry warnings — client-side rendering, a duplicate parameter URL, a gated PDF and a redirect chain — and two are broken: a trust page blocked in robots.txt and a removed job page that is still listed in the sitemap.</p>
    </div>

    <div class="tsv-bots" data-tsv-bots>
      <div class="tsv-bots__panel">
        <p class="tsv-bots__k"><?= xt_icon('terminal', ['size' => 16]) ?>robots.txt · user-agent rules</p>
        <ul class="tsv-bots__list" role="list">
          <?php foreach ($tsv_tc_bots as $tsv_tbi => $tsv_tb): ?>
            <li class="tsv-bot">
              <span class="tsv-bot__n"><b><?= e($tsv_tb[0]) ?></b><small><?= e($tsv_tb[1]) ?></small></span>
              <button class="tsv-bot__sw" type="button" aria-pressed="<?= $tsv_tb[2] ? 'true' : 'false' ?>"
                      data-bot="<?= $tsv_tbi ?>"
                      data-allow="<?= e($tsv_tb[3]) ?>"
                      data-deny="<?= e($tsv_tb[4]) ?>">
                <span class="tsv-bot__track" aria-hidden="true"></span>
                <span class="tsv-bot__st" aria-hidden="true"><?= $tsv_tb[2] ? 'Allow' : 'Disallow' ?></span>
                <span class="bdh-sr"><?= e($tsv_tb[0]) ?> · <?= $tsv_tb[2] ? 'allowed' : 'disallowed' ?></span>
              </button>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <p class="tsv-note tsv-bots__note">
        <?= xt_icon('alert', ['size' => 18]) ?>
        <span><b>The distinction that costs traffic.</b> Teams block “AI crawlers” in one line and quietly remove themselves from ChatGPT search and Perplexity citations. Training access and search access are separate decisions with separate agents. We write the rules per agent, record the reason, and re-check them after every platform change.</span>
      </p>

      <div class="tsv-bots__side">
        <div class="tsv-bots__explain" aria-live="polite">
          <p class="tsv-bots__ek" data-bots-ek>Googlebot · allowed</p>
          <p class="tsv-bots__et" data-bots-et><?= e($tsv_tc_bots[0][3]) ?></p>
          <p class="tsv-bots__en" data-bots-en><?= e($tsv_tc_bots[0][4]) ?></p>
        </div>
        <div class="tsv-bots__out">
          <p class="tsv-bots__ok"><?= xt_icon('terminal', ['size' => 14]) ?>The rules this produces</p>
          <pre class="tsv-bots__code" data-bots-code aria-hidden="true"><code><?php
          foreach ($tsv_tc_bots as $tsv_tb) {
              echo 'User-agent: ' . e($tsv_tb[0]) . "\n" . ($tsv_tb[2] ? 'Allow: /' : 'Disallow: /') . "\n\n";
          }
          echo "Sitemap: https://yourcompany.com/sitemap.xml";
          ?></code></pre>
        </div>
      </div>
    </div>

    <ul class="tsv-cwv" role="list" data-rv data-bdh-stagger>
      <li class="tsv-cwv__k"><b>Core Web Vitals</b><small>Good thresholds, measured at the 75th percentile of real users over 28 days</small></li>
      <?php foreach ($tsv_tc_cwv as $tsv_tv): ?>
        <li class="tsv-cwv__m">
          <span class="tsv-cwv__a"><?= e($tsv_tv[0]) ?></span>
          <span class="tsv-cwv__v"><?= e($tsv_tv[2]) ?></span>
          <span class="tsv-cwv__n"><?= e($tsv_tv[1]) ?></span>
          <span class="tsv-cwv__d"><?= e($tsv_tv[3]) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>

  </div>
</section>
